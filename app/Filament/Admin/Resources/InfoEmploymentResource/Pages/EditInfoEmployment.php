<?php

namespace App\Filament\Admin\Resources\InfoEmploymentResource\Pages;

use App\Filament\Admin\Resources\InfoEmploymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInfoEmployment extends EditRecord
{
    protected static string $resource = InfoEmploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
