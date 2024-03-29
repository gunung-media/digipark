<?php

namespace App\Filament\Seeker\Widgets;

use App\Models\JobApplicant;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class AppliedJob extends BaseWidget
{
    protected int | string | array $columnSpan = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                JobApplicant::with(['job.company'])
                    ->where('seeker_id', auth('seeker')->user()->id)
            )
            ->columns([
                TextColumn::make('job.name_job')->searchable(),
                TextColumn::make('job.company.name')->searchable(),
                TextColumn::make('created_at')
                    ->label('Applied At')
                    ->date(),
                IconColumn::make('is_accepted')->boolean(),
                TextColumn::make('updated_at')
                    ->label('Accepted At')
            ])
            ->filters([
                DateRangeFilter::make('created_at')->label('Applied At'),
                DateRangeFilter::make('updated_at')->label('Accepted At'),
            ]);
    }
}
