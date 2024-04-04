<?php

namespace App\Filament\Admin\Resources\ConsultationResource\Pages;

use App\Filament\Admin\Resources\ConsultationResource;
use Filament\Resources\Pages\ListRecords;

class ListConsultations extends ListRecords
{
    protected static string $resource = ConsultationResource::class;

    protected function getHeaderWidgets(): array
    {
        return ConsultationResource::getWidgets();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
