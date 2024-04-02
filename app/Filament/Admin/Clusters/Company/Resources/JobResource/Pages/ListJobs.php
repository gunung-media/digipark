<?php

namespace App\Filament\Admin\Clusters\Company\Resources\JobResource\Pages;

use App\Filament\Admin\Clusters\Company\Resources\JobResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobs extends ListRecords
{
    protected static string $resource = JobResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
