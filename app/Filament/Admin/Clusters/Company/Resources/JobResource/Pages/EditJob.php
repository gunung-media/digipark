<?php

namespace App\Filament\Admin\Clusters\Company\Resources\JobResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\JobResource;
use App\Models\Company\Job;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Blade;

class EditJob extends EditRecord
{
    protected static ?string $title = "View Laporan Pekerjaan";
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('pdf')
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
        ];
    }
}
