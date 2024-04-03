<?php

namespace App\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class Company extends Cluster
{
    protected static ?string $navigationGroup = 'Layanan';
    protected static ?string $title = 'Laporan Perusahaan';
    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
}
