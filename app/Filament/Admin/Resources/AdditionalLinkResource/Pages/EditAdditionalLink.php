<?php

namespace App\Filament\Admin\Resources\AdditionalLinkResource\Pages;

use App\Filament\Admin\Resources\AdditionalLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdditionalLink extends EditRecord
{
    protected static string $resource = AdditionalLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
