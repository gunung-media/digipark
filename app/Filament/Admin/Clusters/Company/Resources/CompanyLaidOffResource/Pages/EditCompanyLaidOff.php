<?php

namespace App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource;
use Filament\Resources\Pages\EditRecord;

class EditCompanyLaidOff extends EditRecord
{
    protected static ?string $title = "View Laporan PHK";
    protected static string $resource = CompanyLaidOffResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
