<?php

namespace App\Filament\Resources\DepartementMemberResource\Pages;

use App\Filament\Resources\DepartementMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartementMembers extends ListRecords
{
    protected static string $resource = DepartementMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
