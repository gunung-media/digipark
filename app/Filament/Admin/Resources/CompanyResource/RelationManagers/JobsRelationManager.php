<?php

namespace App\Filament\Admin\Resources\CompanyResource\RelationManagers;

use App\Filament\Admin\Clusters\Company\Resources\JobResource;
use App\Models\Company\Job;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use ZipArchive;
use Illuminate\Support\Collection;

class JobsRelationManager extends RelationManager
{
    protected static string $relationship = 'jobs';
    protected static ?string $title = "Laporan Pekerjaan";

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Nama Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_job')
                    ->label('Nama Pekerjaan')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label("Aktif Di Web")
                    ->boolean(),
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
                SelectFilter::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
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
                    ->action(function (Job $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.job', ['record' => $record])
                            )->stream();
                        }, "laporan-pekerjaan-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                    }),
                Tables\Actions\Action::make('active')
                    ->action(function (Job $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn(Job $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->action(function (Job $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn(Job $record): bool => $record->is_active),
                Tables\Actions\EditAction::make()->label("View")->icon('heroicon-o-eye')->url(fn(Model $record) => JobResource::getUrl('edit', ['record' => $record->getKey()])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\BulkAction::make('download')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function (Collection $records) {
                        $zipFileName = 'bulk-laporan-pekerjaan-' . now()->format('d_m_Y') . '.zip';
                        $zipPath = storage_path("app/public/$zipFileName");

                        $zip = new ZipArchive;
                        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                            foreach ($records as $record) {
                                $pdfContent = Pdf::loadHtml(
                                    Blade::render('pdf.job', ['record' => $record])
                                )->output();

                                $pdfFileName = "laporan-pekerjaan-{$record->id}-" . now()->format('d_m_Y') . ".pdf";
                                $zip->addFromString($pdfFileName, $pdfContent);
                            }
                            $zip->close();
                        } else {
                            return response()->json(['error' => 'Failed to create ZIP file'], 500);
                        }

                        return response()->download($zipPath)->deleteFileAfterSend(true);
                    })
            ]);
    }
}
