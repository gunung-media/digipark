<?php

namespace App\Filament\Admin\Resources\AdminContentResource\Pages;

use App\Filament\Admin\Resources\AdminContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdminContent extends EditRecord
{
    protected static string $resource = AdminContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
