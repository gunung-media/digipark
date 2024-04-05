<?php

namespace App\Filament\Company\Resources\CompanyLegalizationResource\Pages;

use App\Filament\Company\Resources\CompanyLegalizationResource;
use App\Utils\Helper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCompanyLegalization extends EditRecord
{
    protected static string $resource = CompanyLegalizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return parent::handleRecordUpdate($record, Helper::manipulateDataHasSignature($data));
    }
}
