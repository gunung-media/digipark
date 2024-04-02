<?php

namespace App\Filament\Company\Resources\CompanyLaidOffResource\Pages;

use App\Filament\Company\Resources\CompanyLaidOffResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanyLaidOffs extends ListRecords
{
    protected static ?string $title = "Laporan PHK";
    protected static string $resource = CompanyLaidOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
