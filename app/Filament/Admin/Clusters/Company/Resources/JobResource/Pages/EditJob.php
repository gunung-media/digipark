<?php

namespace App\Filament\Admin\Clusters\Company\Resources\JobResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\JobResource;
use Filament\Resources\Pages\EditRecord;

class EditJob extends EditRecord
{
    protected static ?string $title = "View Laporan Pekerjaan";
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
