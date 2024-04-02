<?php

namespace App\Filament\Admin\Resources\SubMenuResource\Pages;

use App\Filament\Admin\Resources\SubMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubMenu extends EditRecord
{
    protected static string $resource = SubMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
