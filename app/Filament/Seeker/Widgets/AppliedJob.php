<?php

namespace App\Filament\Seeker\Widgets;

use App\Models\Seeker\JobApplicant;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class AppliedJob extends BaseWidget
{
    protected int | string | array $columnSpan = 2;
    protected static ?string $heading = "Pekerjaan Yang Anda Lamar";
    protected static bool $isDiscovered = false;

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
                    ->sortable()
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
            ])
            ->headerActions([
                Action::make('Daftar Pekerjaan Lainnya')
                    ->url(fn(): string => route('portal.jobs.index'))
                    ->openUrlInNewTab()
            ])
            ->actions([
                Action::make('edit')
                    ->label('Tentang Pekerjaan')
                    ->url(fn($record): string => route('portal.jobs.detail', $record->job_id))
                    ->color('warning')
                    ->openUrlInNewTab()
            ], position: ActionsPosition::BeforeColumns);
    }
}
