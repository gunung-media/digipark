<?php

namespace App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource;
use App\Models\Company\LaborDemand;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Blade;

class EditLaborDemand extends EditRecord
{
    protected static ?string $title = "View Laporan Permintaan Tenaga Kerja";
    protected static string $resource = LaborDemandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-arrow-down-on-square')
                ->action(function (LaborDemand $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo Pdf::loadHtml(
                            Blade::render('pdf.labor-demand', ['record' => $record])
                        )->stream();
                    }, "laporan-permintaan-tenaga-kerja-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                }),
        ];
    }
}
