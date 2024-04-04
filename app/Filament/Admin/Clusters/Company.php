<?php

namespace App\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;
use Filament\Pages\SubNavigationPosition;

class Company extends Cluster
{
    protected static ?string $navigationGroup = 'Layanan';
    protected static ?string $title = 'Laporan Perusahaan';
    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
}
