<?php

namespace App\Filament\Resources\CompanyResource\RelationManagers;

use App\Models\Company\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class JobsRelationManager extends RelationManager
{
    protected static string $relationship = 'jobs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_job')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->default(function (RelationManager $livewire) {
                        return $livewire->ownerRecord->address;
                    })
                    ->maxLength(255),
                TinyEditor::make('description')
                    ->columnSpanFull()
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('private')
                    ->fileAttachmentsDirectory('jobs/description')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->disk('public')
                    ->directory('jobs')
                    ->image()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('total_needed_man')
                    ->numeric()
                    ->required()
                    ->default(0),
                Forms\Components\TextInput::make('total_needed_woman')
                    ->numeric()
                    ->required()
                    ->default(0),
                Forms\Components\Select::make('minimal_education')
                    ->options([
                        "Tidak Ada" => 'Tidak Ada',
                        "SD" => 'SD',
                        "SMP" => 'SMP',
                        "SMA/SMK" => 'SMA/SMK',
                        "Kuliah" => 'KuliahSMA',
                    ]),
                Forms\Components\TextInput::make('special')
                    ->label('Kelebihan'),
                Forms\Components\DatePicker::make('deadline'),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\TextInput::make('salary')
                    ->numeric()->default(0),
                Forms\Components\Select::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])->default(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name_job')
            ->columns([
                Tables\Columns\TextColumn::make('name_job'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->action(function (Job $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (Job $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->action(function (Job $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn (Job $record): bool => $record->is_active),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
