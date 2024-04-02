<?php

namespace App\Filament\Seeker\Resources\ClaimJhtResource\Pages;

use App\Filament\Seeker\Resources\ClaimJhtResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClaimJhts extends ListRecords
{
    protected static string $resource = ClaimJhtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
