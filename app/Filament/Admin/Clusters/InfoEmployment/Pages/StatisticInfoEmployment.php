<?php

namespace App\Filament\Admin\Clusters\InfoEmployment\Pages;

use App\Filament\Admin\Clusters\InfoEmployment\Widgets;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use App\Filament\Admin\Clusters\InfoEmployment as Cluster;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SubNavigationPosition;

class StatisticInfoEmployment extends Page
{
    use HasFiltersForm;

    protected static ?string $cluster = Cluster::class;
    protected static ?string $title = "Statistik";
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?int $navigationSort = 2;
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    protected static string $view = 'filament.admin.clusters.info-employment.pages.statistic-info-employment';

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('month')
                            ->label("Bulan")
                            ->type('month'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected function getWidgets(): array
    {
        return [
            Widgets\InfoEmploymentBarChart::class,
            Widgets\InfoEmploymentLineChart::class,
            Widgets\InfoEmploymentBarChartVillage::class,
            Widgets\InfoEmploymentLineChartVillage::class,
        ];
    }

    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
