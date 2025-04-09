<?php

namespace App\Livewire\Portal;

use App\Models\Admin\InfoEmployment;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Contracts\Support\Htmlable;

class InfoEmploymentBarChart extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string | Htmlable | null
    {
        $month = !is_null($_GET['month'] ?? null) ?
            Carbon::parse($_GET['month']) :
            now();

        return  "Info Per Tahun {$month->format('Y')} (Bar chart)";
    }

    protected function getData(): array
    {
        $month = !is_null($_GET['month'] ?? null) ?
            Carbon::parse($_GET['month']) :
            now();

        $unemployed = Trend::query(InfoEmployment::query()
            ->whereYear('date_in', $month?->year))
            ->dateColumn('date_in')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('unemployed_count');

        $seeker = Trend::query(InfoEmployment::query()
            ->whereYear('date_in', $month?->year))
            ->dateColumn('date_in')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('seeker_count');

        $job = Trend::query(InfoEmployment::query()
            ->whereYear('date_in', $month?->year))
            ->dateColumn('date_in')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('job_count');

        $placement = Trend::query(InfoEmployment::query()
            ->whereYear('date_in', $month?->year))
            ->dateColumn('date_in')
            ->between(start: now()->startOfYear(), end: now()->endOfYear())
            ->perMonth()
            ->sum('placement_count');

        return [
            'datasets' => [
                [
                    'label' => 'Total Pengangguran',
                    'data' => $unemployed->map(fn(TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
                [
                    'label' => 'Pencari Kerja',
                    'data' => $seeker->map(fn(TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#4BC0C0',
                    'borderColor' => '#B2EBF2',
                ],
                [
                    'label' => 'Lowongan Kerja',
                    'data' => $job->map(fn(TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#FFCE56',
                    'borderColor' => '#FFF59D',
                ],
                [
                    'label' => 'Penempatan Kerja',
                    'data' => $placement->map(fn(TrendValue $d) => $d->aggregate)->toArray(),
                    'backgroundColor' => '#9966FF',
                    'borderColor' => '#D1C4E9',
                ],
            ],
            'labels' => $unemployed->map(fn(TrendValue $d) => Carbon::parse($d->date)->format('F'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
