<?php

namespace App\Filament\Admin\Resources\CompanyResource\RelationManagers;

use App\Filament\Admin\Clusters\Company\Resources\PlacementResource;
use App\Models\Company\Placement;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use ZipArchive;
use Illuminate\Support\Collection;

class PlacementRelationManager extends RelationManager
{
    protected static string $relationship = 'placements';
    protected static ?string $title = "Laporan Penempatan";

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Nama Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('identity_number')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'diterima' => 'gray',
                        'ditunda' => 'warning',
                        'diproses' => 'success',
                        'ditolak' => 'danger',
                        'selesai' => 'info',
                    })
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'diterima' => 'Diterima',
                        'ditunda' => 'Ditunda',
                        'diproses' => 'Diproses',
                        'ditolak' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function (Placement $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.placement', ['record' => $record])
                            )->stream();
                        }, "laporan-penempatan-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                    }),
                Tables\Actions\EditAction::make()->label("View")->icon('heroicon-o-eye')->url(fn(Model $record) => PlacementResource::getUrl('edit', ['record' => $record->getKey()])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('download')
                        ->label('Download PDF')
                        ->icon('heroicon-o-arrow-down-on-square')
                        ->action(function (Collection $records) {
                            $zipFileName = 'bulk-laporan-penempatan-' . now()->format('d_m_Y') . '.zip';
                            $zipPath = storage_path("app/public/$zipFileName");

                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                                foreach ($records as $record) {
                                    $pdfContent = Pdf::loadHtml(
                                        Blade::render('pdf.placement', ['record' => $record])
                                    )->output();

                                    $pdfFileName = "laporan-penempatan-{$record->id}-" . now()->format('d_m_Y') . ".pdf";
                                    $zip->addFromString($pdfFileName, $pdfContent);
                                }
                                $zip->close();
                            } else {
                                return response()->json(['error' => 'Failed to create ZIP file'], 500);
                            }

                            return response()->download($zipPath)->deleteFileAfterSend(true);
                        })

                ]),
            ]);
    }
}
