<?php

namespace App\Filament\Admin\Resources\SubMenuResource\Pages;

use App\Filament\Admin\Resources\SubMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubMenus extends ListRecords
{
    protected static string $resource = SubMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
