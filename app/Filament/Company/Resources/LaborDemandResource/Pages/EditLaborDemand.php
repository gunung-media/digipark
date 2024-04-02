<?php

namespace App\Filament\Company\Resources\LaborDemandResource\Pages;

use App\Filament\Company\Resources\LaborDemandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaborDemand extends EditRecord
{
    protected static string $resource = LaborDemandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
