<?php

namespace App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListLaborDemands extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = LaborDemandResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return LaborDemandResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'diterima' => Tab::make()->query(fn ($query) => $query->where('status', 'diterima')),
            'diproses' => Tab::make()->query(fn ($query) => $query->where('status', 'diproses')),
            'ditunda' => Tab::make()->query(fn ($query) => $query->where('status', 'ditunda')),
            'ditolak' => Tab::make()->query(fn ($query) => $query->where('status', 'ditolak')),
        ];
    }
}
