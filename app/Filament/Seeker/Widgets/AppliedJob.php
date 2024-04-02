<?php

namespace App\Filament\Seeker\Widgets;

use App\Models\Seeker\JobApplicant;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class AppliedJob extends BaseWidget
{
    protected int | string | array $columnSpan = 2;
    protected static ?string $heading = "Pekerjaan Yang Anda Lamar";

    public function table(Table $table): Table
    {
        return $table
            ->query(
                JobApplicant::with(['job.company'])
                    ->where('seeker_id', auth('seeker')->user()->id)
            )
            ->columns([
                TextColumn::make('job.name_job')
                    ->label("Pekerjaan")
                    ->searchable(),
                TextColumn::make('job.company.name')
                    ->label("Perusahaan")
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label("Melamar pada")
                    ->date(),
                IconColumn::make('is_accepted')
                    ->label("Diterima?")
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label("Diterima pada")
            ])
            ->filters([
                DateRangeFilter::make('created_at')->label('Applied At'),
                DateRangeFilter::make('updated_at')->label('Accepted At'),
            ]);
    }
}
