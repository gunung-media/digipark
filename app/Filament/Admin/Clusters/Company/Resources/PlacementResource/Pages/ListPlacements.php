<?php

namespace App\Filament\Admin\Clusters\Company\Resources\PlacementResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\PlacementResource;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListPlacements extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = PlacementResource::class;

    protected function getHeaderWidgets(): array
    {
        return PlacementResource::getWidgets();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'diterima' => Tab::make()->query(fn($query) => $query->where('status', 'diterima')),
            'diproses' => Tab::make()->query(fn($query) => $query->where('status', 'diproses')),
            'ditunda' => Tab::make()->query(fn($query) => $query->where('status', 'ditunda')),
            'ditolak' => Tab::make()->query(fn($query) => $query->where('status', 'ditolak')),
            'selesai' => Tab::make()->query(fn($query) => $query->where('status', 'selesai')),
        ];
    }
}
