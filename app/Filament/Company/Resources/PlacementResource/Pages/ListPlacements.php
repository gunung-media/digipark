<?php

namespace App\Filament\Company\Resources\PlacementResource\Pages;

use App\Filament\Company\Resources\PlacementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlacements extends ListRecords
{
    protected static string $resource = PlacementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
