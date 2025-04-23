<?php

namespace App\Filament\Admin\Clusters\Company\Resources\LaborUnionRegistrationResource\Widgets;

use App\Filament\Admin\Clusters\Company\Resources\LaborUnionRegistrationResource\Pages\ListLaborUnionRegistrations;
use App\Models\Company\LaborUnionRegistration;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class LaborUnionRegistrationStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListLaborUnionRegistrations::class;
    }

    protected function getStats(): array
    {
        $data = Trend::model(LaborUnionRegistration::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Pendaftaran Serikat Pekerja', $this->getPageTableQuery()->count())
                ->chart(
                    $data
                        ->map(fn(TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
