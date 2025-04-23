<?php

namespace App\Filament\Admin\Clusters\Company\Resources\InstitutionalApprovalResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\InstitutionalApprovalResource;
use App\Models\Company\InstitutionalApproval;
use Filament\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Blade;
use Filament\Resources\Pages\EditRecord;

class EditInstitutionalApproval extends EditRecord
{
    protected static string $resource = InstitutionalApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-arrow-down-on-square')
                ->action(function (InstitutionalApproval $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo Pdf::loadHtml(
                            Blade::render('pdf.institutional-approval', ['record' => $record])
                        )->stream();
                    }, "pengesahan-lembaga-lks{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                }),
        ];
    }
}
