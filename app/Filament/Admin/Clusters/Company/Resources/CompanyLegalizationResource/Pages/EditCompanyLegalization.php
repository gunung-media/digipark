<?php

namespace App\Filament\Admin\Clusters\Company\Resources\CompanyLegalizationResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\CompanyLegalizationResource;
use App\Models\Company\CompanyLegalization;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Blade;

class EditCompanyLegalization extends EditRecord
{
    protected static ?string $title = "View Laporan Pengesahaan";
    protected static string $resource = CompanyLegalizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-arrow-down-on-square')
                ->action(function (CompanyLegalization $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo Pdf::loadHtml(
                            Blade::render('pdf.company-legalization', ['record' => $record])
                        )->stream();
                    }, "laporan-pengesahaan-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                }),
        ];
    }
}
