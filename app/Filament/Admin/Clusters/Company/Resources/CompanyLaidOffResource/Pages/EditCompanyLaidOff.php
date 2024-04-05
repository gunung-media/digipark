<?php

namespace App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource;
use App\Models\Company\CompanyLaidOff;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Blade;

class EditCompanyLaidOff extends EditRecord
{
    protected static ?string $title = "View Laporan PHK";
    protected static string $resource = CompanyLaidOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-arrow-down-on-square')
                ->action(function (CompanyLaidOff $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo Pdf::loadHtml(
                            Blade::render('pdf.company-laid-off', ['record' => $record])
                        )->stream();
                    }, "laporan-phk-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                }),
        ];
    }
}
