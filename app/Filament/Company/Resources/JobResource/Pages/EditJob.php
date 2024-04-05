<?php

namespace App\Filament\Company\Resources\JobResource\Pages;

use App\Filament\Company\Resources\JobResource;
use App\Utils\Helper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditJob extends EditRecord
{
    protected static string $resource = JobResource::class;

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
