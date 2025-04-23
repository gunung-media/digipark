<?php

namespace App\Filament\Admin\Clusters\Company\Resources\InstitutionalApprovalResource\Widgets;

use App\Filament\Admin\Clusters\Company\Resources\InstitutionalApprovalResource\Pages\ListInstitutionalApprovals;
use App\Models\Company\InstitutionalApproval;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class InstitutionalApprovalStats extends BaseWidget
{
    use InteractsWithPageTable;

    protected static ?string $pollingInterval = null;

    protected function getTablePage(): string
    {
        return ListInstitutionalApprovals::class;
    }

    protected function getStats(): array
    {
        $data = Trend::model(InstitutionalApproval::class)
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            Stat::make('Pengesahan Lembaga LKS BIPARTIT', $this->getPageTableQuery()->count())
                ->chart(
                    $data
                        ->map(fn(TrendValue $value) => $value->aggregate)
                        ->toArray()
                ),
        ];
    }
}
