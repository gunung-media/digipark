<?php

namespace App\Filament\Admin\Clusters\Company\Resources\PlacementResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\PlacementResource;
use Filament\Resources\Pages\EditRecord;

class EditPlacement extends EditRecord
{
    protected static ?string $title = 'View Laporan Penempatan';
    protected static string $resource = PlacementResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
