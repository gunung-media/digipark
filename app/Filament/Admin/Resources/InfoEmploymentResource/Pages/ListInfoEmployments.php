<?php

namespace App\Filament\Admin\Resources\InfoEmploymentResource\Pages;

use App\Filament\Admin\Resources\InfoEmploymentResource;
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
