<?php

namespace App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaborDemands extends ListRecords
{
    protected static string $resource = LaborDemandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
