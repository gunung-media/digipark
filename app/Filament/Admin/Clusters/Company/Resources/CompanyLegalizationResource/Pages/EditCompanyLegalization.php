<?php

namespace App\Filament\Admin\Clusters\Company\Resources\CompanyLegalizationResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\CompanyLegalizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyLegalization extends EditRecord
{
    protected static ?string $title = "View Laporan Pengesahaan";
    protected static string $resource = CompanyLegalizationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
