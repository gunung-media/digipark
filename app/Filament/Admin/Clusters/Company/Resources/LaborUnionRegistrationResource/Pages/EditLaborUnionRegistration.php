<?php

namespace App\Filament\Admin\Clusters\Company\Resources\LaborUnionRegistrationResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\LaborUnionRegistrationResource;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Company\LaborUnionRegistration;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Blade;
use Filament\Resources\Pages\EditRecord;

class EditLaborUnionRegistration extends EditRecord
{
    protected static string $resource = LaborUnionRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-arrow-down-on-square')
                ->action(function (LaborUnionRegistration $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo Pdf::loadHtml(
                            Blade::render('pdf.labor-union-registration', ['record' => $record])
                        )->stream();
                    }, "pendaftaran-serikat-pekerja-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                }),
        ];
    }
}
