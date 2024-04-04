<?php

namespace App\Filament\Admin\Clusters\InfoEmployment\Resources\InfoEmploymentResource\Pages;

use App\Filament\Admin\Clusters\InfoEmployment\Resources\InfoEmploymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInfoEmployments extends ListRecords
{
    protected static string $resource = InfoEmploymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
