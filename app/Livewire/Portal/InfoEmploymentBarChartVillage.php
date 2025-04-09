<?php

namespace App\Livewire\Portal;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use KodePandai\Indonesia\Models\District;

class InfoEmploymentBarChartVillage extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string | Htmlable | null
    {
        $month = !is_null($this->filters['month'] ?? null) ?
            Carbon::parse($this->filters['month']) :
            now();

        return  "Info Per Kecamatan Bulan {$month->format('F')} (Bar chart)";
    }

    protected function getData(): array
    {
        $month = !is_null($this->filters['month'] ?? null)
            ? Carbon::parse($this->filters['month'])
            : now();

        $results = District::select(
            'indonesia_districts.name',
            DB::raw('SUM(info_employments.unemployed_count) as unemployed_count'),
            DB::raw('SUM(info_employments.seeker_count) as seeker_count'),
            DB::raw('SUM(info_employments.job_count) as job_count'),
            DB::raw('SUM(info_employments.placement_count) as placement_count')
        )
            ->join('indonesia_villages', 'indonesia_villages.district_code', '=', 'indonesia_districts.code')
            ->join('info_employments', 'info_employments.village_code', '=', 'indonesia_villages.code')
            ->whereMonth('info_employments.date_in', $month->month)
            ->whereYear('info_employments.date_in', $month->year)
            ->groupBy('indonesia_districts.code', 'indonesia_districts.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Pengangguran',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => $results->pluck('unemployed_count')->toArray(),
                ],
                [
                    'label' => 'Pencari Kerja',
                    'backgroundColor' => '#4BC0C0',
                    'borderColor' => '#A7ECEE',
                    'data' => $results->pluck('seeker_count')->toArray(),
                ],
                [
                    'label' => 'Lowongan Kerja',
                    'backgroundColor' => '#FFCE56',
                    'borderColor' => '#FFE699',
                    'data' => $results->pluck('job_count')->toArray(),
                ],
                [
                    'label' => 'Penempatan Kerja',
                    'backgroundColor' => '#9966FF',
                    'borderColor' => '#D1B3FF',
                    'data' => $results->pluck('placement_count')->toArray(),
                ],
            ],
            'labels' => $results->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
