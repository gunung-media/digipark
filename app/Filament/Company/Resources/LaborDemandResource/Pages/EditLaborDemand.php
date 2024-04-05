<?php

namespace App\Filament\Company\Resources\LaborDemandResource\Pages;

use App\Filament\Company\Resources\LaborDemandResource;
use App\Utils\Helper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLaborDemand extends EditRecord
{
    protected static string $resource = LaborDemandResource::class;

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
