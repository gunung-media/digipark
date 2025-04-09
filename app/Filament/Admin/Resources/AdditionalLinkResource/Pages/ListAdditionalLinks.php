<?php

namespace App\Filament\Admin\Resources\AdditionalLinkResource\Pages;

use App\Filament\Admin\Resources\AdditionalLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdditionalLinks extends ListRecords
{
    protected static string $resource = AdditionalLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
