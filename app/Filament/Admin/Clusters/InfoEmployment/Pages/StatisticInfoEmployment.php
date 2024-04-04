<?php

namespace App\Filament\Admin\Clusters\InfoEmployment\Pages;

use Filament\Pages\Page;
use App\Filament\Admin\Clusters\InfoEmployment as Cluster;
use Filament\Pages\SubNavigationPosition;

class StatisticInfoEmployment extends Page
{
    protected static ?string $cluster = Cluster::class;
    protected static ?string $title = "Statistik";
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string $view = 'filament.admin.clusters.info-employment.pages.statistic-info-employment';
}
