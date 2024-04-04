<?php

namespace App\Filament\Company\Resources\CompanyLegalizationResource\Pages;

use App\Filament\Company\Resources\CompanyLegalizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompanyLegalization extends EditRecord
{
    protected static string $resource = CompanyLegalizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
