<?php

namespace App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource;
use Filament\Resources\Pages\EditRecord;

class EditLaborDemand extends EditRecord
{
    protected static ?string $title = "View Laporan Permintaan Tenaga Kerja";
    protected static string $resource = LaborDemandResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
