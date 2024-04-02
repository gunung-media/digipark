<?php

namespace App\Filament\Company\Resources\CompanyLaidOffResource\Pages;

use App\Filament\Company\Resources\CompanyLaidOffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyLaidOff extends EditRecord
{
    protected static string $resource = CompanyLaidOffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
