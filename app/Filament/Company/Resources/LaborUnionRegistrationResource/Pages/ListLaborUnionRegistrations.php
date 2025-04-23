<?php

namespace App\Filament\Company\Resources\LaborUnionRegistrationResource\Pages;

use App\Filament\Company\Resources\LaborUnionRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaborUnionRegistrations extends ListRecords
{
    protected static string $resource = LaborUnionRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
