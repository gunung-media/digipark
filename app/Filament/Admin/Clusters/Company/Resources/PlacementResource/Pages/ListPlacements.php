<?php

namespace App\Filament\Admin\Clusters\Company\Resources\PlacementResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\PlacementResource;
use Filament\Resources\Pages\ListRecords;

class ListPlacements extends ListRecords
{
    protected static string $resource = PlacementResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
