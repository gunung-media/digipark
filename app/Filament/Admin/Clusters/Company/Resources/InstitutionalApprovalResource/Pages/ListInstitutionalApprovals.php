<?php

namespace App\Filament\Admin\Clusters\Company\Resources\InstitutionalApprovalResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\InstitutionalApprovalResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListInstitutionalApprovals extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = InstitutionalApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return InstitutionalApprovalResource::getWidgets();
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
