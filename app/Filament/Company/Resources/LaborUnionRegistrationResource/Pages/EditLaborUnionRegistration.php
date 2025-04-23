<?php

namespace App\Filament\Company\Resources\LaborUnionRegistrationResource\Pages;

use App\Filament\Company\Resources\LaborUnionRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaborUnionRegistration extends EditRecord
{
    protected static string $resource = LaborUnionRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
