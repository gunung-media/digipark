<?php

namespace App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\Pages;

use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListClaimJhts extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = ClaimJhtResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return ClaimJhtResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'diterima' => Tab::make()->query(fn($query) => $query->doesntHave('tracks')),
            'diproses' => Tab::make()->query(
                fn($query) =>
                $query->whereHas('tracks', function ($q) {
                    $q->whereRaw('id = (SELECT MAX(id) FROM track_claim_jhts WHERE claim_jht_id = claim_jhts.id)')
                        ->where('status', 'diproses');
                })
            ),
            'ditunda' => Tab::make()->query(
                fn($query) =>
                $query->whereHas('tracks', function ($q) {
                    $q->whereRaw('id = (SELECT MAX(id) FROM track_claim_jhts WHERE claim_jht_id = claim_jhts.id)')
                        ->where('status', 'ditunda');
                })
            ),
            'ditolak' => Tab::make()->query(
                fn($query) =>
                $query->whereHas(
                    'tracks',
                    function ($q) {
                        $q->whereRaw('id = (SELECT MAX(id) FROM track_claim_jhts WHERE claim_jht_id = claim_jhts.id)')
                            ->where('status', 'ditolak');
                    }
                )
            ),
            'selesai' => Tab::make()->query(
                fn($query) =>
                $query->whereHas(
                    'tracks',
                    function ($q) {
                        $q->whereRaw('id = (SELECT MAX(id) FROM track_claim_jhts WHERE claim_jht_id = claim_jhts.id)')
                            ->where('status', 'selesai');
                    }
                )
            ),
        ];
    }
}
