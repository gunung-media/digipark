<?php

namespace App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\Pages;

use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClaimJht extends EditRecord
{
    protected static string $resource = ClaimJhtResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
