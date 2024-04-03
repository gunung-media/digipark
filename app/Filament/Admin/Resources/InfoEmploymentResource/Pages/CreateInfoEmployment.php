<?php

namespace App\Filament\Admin\Resources\InfoEmploymentResource\Pages;

use App\Filament\Admin\Resources\InfoEmploymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateInfoEmployment extends CreateRecord
{
    protected static string $resource = InfoEmploymentResource::class;

    public function handleRecordCreation(array $data): Model
    {
        return static::getModel()::updateOrCreate(['year' => $data['year'], 'village_code' => $data['village_code']], $data);
    }
}
