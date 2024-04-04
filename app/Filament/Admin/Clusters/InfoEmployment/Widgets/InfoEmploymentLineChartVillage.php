<?php

namespace App\Filament\Admin\Clusters\InfoEmployment\Widgets;

use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;
use KodePandai\Indonesia\Models\District;

class InfoEmploymentLineChartVillage extends ChartWidget
{
    use InteractsWithPageFilters;

    public function getHeading(): string | Htmlable | null
    {
        $month = !is_null($this->filters['month'] ?? null) ?
            Carbon::parse($this->filters['month']) :
            now();

        return  "Jumlah Pengangguran Per Kecamatan Bulan {$month->format('F')}";
    }

    protected function getData(): array
    {
        $month = !is_null($this->filters['month'] ?? null) ?
            Carbon::parse($this->filters['month']) :
            now();

        $results = District::select('indonesia_districts.name', DB::raw('sum(info_employments.count) as people_count'))
            ->join('indonesia_villages', 'indonesia_villages.district_code', '=', 'indonesia_districts.code')
            ->join('info_employments', 'info_employments.village_code', '=', 'indonesia_villages.code')
            ->whereMonth('info_employments.date_in', $month?->month)
            ->whereYear('info_employments.date_in', $month?->year)
            ->groupBy('indonesia_districts.code', 'indonesia_districts.name')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Pengangguran',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => $results->map(fn ($d) => $d->people_count)->toArray(),
                    'tension' => '0.1',
                    'pointSyle' => 'circle',
                    'pointRadius' => 5
                ],
            ],
            'labels' => $results->map(fn ($d) => $d->name)->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
