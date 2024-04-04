<?php

namespace App\Filament\Admin\Clusters;

use Filament\Clusters\Cluster;

class InfoEmployment extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $title = "Informasi Ketenagakerjaan";
    protected static ?string $navigationGroup = 'Layanan';
    protected static ?int $navigationSort = 3;
}
