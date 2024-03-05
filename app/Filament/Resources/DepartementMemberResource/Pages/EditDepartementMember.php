<?php

namespace App\Filament\Resources\DepartementMemberResource\Pages;

use App\Filament\Resources\DepartementMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartementMember extends EditRecord
{
    protected static string $resource = DepartementMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
