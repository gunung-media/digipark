<?php

namespace App\Filament\Company\Resources\CompanyLaidOffResource\Pages;

use App\Filament\Company\Resources\CompanyLaidOffResource;
use App\Utils\Helper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditCompanyLaidOff extends EditRecord
{
    protected static string $resource = CompanyLaidOffResource::class;

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
