<?php

namespace App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyLaidOffs extends ListRecords
{
    protected static string $resource = CompanyLaidOffResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
