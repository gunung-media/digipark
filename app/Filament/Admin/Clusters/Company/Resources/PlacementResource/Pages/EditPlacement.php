<?php

namespace App\Filament\Admin\Clusters\Company\Resources\PlacementResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\PlacementResource;
use App\Models\Company\Placement;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Blade;
use Filament\Resources\Pages\EditRecord;

class EditPlacement extends EditRecord
{
    protected static ?string $title = 'View Laporan Penempatan';
    protected static string $resource = PlacementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
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
        ];
    }
}
