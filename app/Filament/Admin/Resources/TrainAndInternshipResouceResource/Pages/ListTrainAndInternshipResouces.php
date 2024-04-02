<?php

namespace App\Filament\Admin\Resources\TrainAndInternshipResouceResource\Pages;

use App\Filament\Admin\Resources\TrainAndInternshipResouceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainAndInternshipResouces extends ListRecords
{
    protected static string $resource = TrainAndInternshipResouceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
