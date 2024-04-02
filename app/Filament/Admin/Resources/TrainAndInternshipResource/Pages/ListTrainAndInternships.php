<?php

namespace App\Filament\Admin\Resources\TrainAndInternshipResource\Pages;

use App\Filament\Admin\Resources\TrainAndInternshipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainAndInternships extends ListRecords
{
    protected static string $resource = TrainAndInternshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
