<?php

namespace App\Filament\Admin\Resources\SeekerResource\Pages;

use App\Filament\Admin\Resources\SeekerResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSeeker extends CreateRecord
{
    protected static string $resource = SeekerResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation([...$data, 'password' => bcrypt('password')]);
    }
}
