<?php

namespace App\Filament\Seeker\Pages;

use App\Filament\Seeker\Widgets\AppliedJob as WidgetsAppliedJob;
use Filament\Pages\Page;

class AppliedJob extends Page
{
    protected static string $view = 'filament.seeker.pages.applied-job';
    protected static ?string $navigationGroup = 'Layanan';
    protected static ?string $title = 'Lamaran Pekerjaan';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected function getHeaderWidgets(): array
    {
        return [
            WidgetsAppliedJob::class
        ];
    }
}
