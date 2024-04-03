<?php

namespace App\Filament\Admin\Clusters\Company\Resources\JobResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\JobResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListJobs extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return JobResource::getWidgets();
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
