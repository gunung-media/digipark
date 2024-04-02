<?php

namespace App\Filament\Admin\Resources\DashboardResource\Pages;

use App\Filament\Admin\Resources\DashboardResource;
use Filament\Resources\Pages\EditRecord;

class EditDashboard extends EditRecord
{
    protected static string $resource = DashboardResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
