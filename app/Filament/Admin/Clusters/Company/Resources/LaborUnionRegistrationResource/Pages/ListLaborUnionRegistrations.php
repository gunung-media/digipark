<?php

namespace App\Filament\Admin\Clusters\Company\Resources\LaborUnionRegistrationResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\LaborUnionRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListLaborUnionRegistrations extends ListRecords
{
    protected static string $resource = LaborUnionRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
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
