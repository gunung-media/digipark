<?php

namespace App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\Pages;

use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource;
use App\Models\Seeker\ClaimJht;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Illuminate\Support\Facades\Blade;

class EditClaimJht extends EditRecord
{
    protected static ?string $title = 'View Laporan Klaim JHT';
    protected static string $resource = ClaimJhtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
                ->label('PDF')
                ->color('success')
                ->icon('heroicon-o-arrow-down-on-square')
                ->action(function (ClaimJht $record) {
                    return response()->streamDownload(function () use ($record) {
                        echo Pdf::loadHtml(
                            Blade::render('pdf.claim-jht', ['record' => $record])
                        )->stream();
                    }, "laporan-claim-jht-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                }),
        ];
    }
    protected function getFormActions(): array
    {
        return [];
    }
}
