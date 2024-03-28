<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\JobResource\Pages;
use App\Filament\Company\Resources\JobResource\RelationManagers;
use App\Models\Job;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_job')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->default(function ($livewire) {
                        return optional($livewire)->ownerRecord?->address ?? '';
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_job'),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }
}
