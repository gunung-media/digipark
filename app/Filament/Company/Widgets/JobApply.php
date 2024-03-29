<?php

namespace App\Filament\Company\Widgets;

use App\Models\JobApplicant;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class JobApply extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = Trend::query(
            JobApplicant::whereHas('job', function (Builder $query) {
                $query->where('company_id', auth('company')->user()->id);
            })
        );
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
