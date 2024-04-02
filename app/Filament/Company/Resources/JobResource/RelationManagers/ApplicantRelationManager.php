<?php

namespace App\Filament\Company\Resources\JobResource\RelationManagers;

use App\Models\Seeker\Seeker;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ApplicantRelationManager extends RelationManager
{
    protected static string $relationship = 'applicants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('seeker')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No.')
                    ->sortable()
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('seeker.full_name')->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied At')
                    ->sortable()
                    ->date(),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),
            ])
            ->headerActions([])
            ->actions([
                Action::make('accept')
                    ->form(function ($record) {
                        return [
                            TextInput::make('full_name')
                                ->default($record->seeker->full_name ?? '')
                                ->readOnly(),
                            TextInput::make('email')
                                ->default($record->seeker->email ?? '')
                                ->readOnly(),
                            TextInput::make('phone_number')
                                ->default($record->seeker->phone_number ?? '')
                                ->readOnly(),
                            TextInput::make('address')
                                ->default($record->seeker->address ?? '')
                                ->readOnly(),
                            TextInput::make('gender')
                                ->default($record->seeker->gender ?? '')
                                ->readOnly(),
                            Textarea::make('message')
                                ->required()
                                ->autosize()
                        ];
                    })
                    ->action(function ($data, $record) {
                        if ($record->update([
                            'is_accepted' => true,
                            'company_message' => $data['message'],
                        ]))
                            Notification::make()
                                ->success()
                                ->title('Selamat anda telah diterima!')
                                ->body($data['message'])
                                ->sendToDatabase(Seeker::find($record->seeker_id));
                    })
                    ->requiresConfirmation()
                    ->modalWidth(MaxWidth::ExtraLarge)
                    ->hidden(fn ($record) => $record->is_accepted)
            ])
            ->bulkActions([]);
    }
}
