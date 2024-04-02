<?php

namespace App\Filament\Admin\Resources\DepartementMemberResource\Pages;

use App\Filament\Admin\Resources\DepartementMemberResource;
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
