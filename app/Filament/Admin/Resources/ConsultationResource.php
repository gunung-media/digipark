<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ConsultationResource\Pages;
use App\Filament\Admin\Resources\ConsultationResource\Widgets\ConsultationStat;
use App\Models\Admin\Consultation;
use App\Utils\FilamentUtil;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';
    protected static ?string $navigationGroup = 'Layanan';
    protected static ?string $pluralModelLabel = "Konsultasi";
    protected static ?string $label = "Konsultasi";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('index')
                    ->label('No.')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('identity_number')
                    ->label('NIK')
                    ->searchable()
                    ->default('-'),
                TextColumn::make('email')->searchable(),
                TextColumn::make('phone_number')->label('No. Telepon/Wa')->searchable(),
                TextColumn::make('subject')->toggleable()->description(fn($record) => $record->description),
                TextColumn::make('created_at')->date()->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('created_at')
                    ->label('Order Date')
                    ->date()
                    ->collapsible(),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            ConsultationStat::class,
        ];
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
            'index' => Pages\ListConsultations::route('/'),
            // 'create' => Pages\CreateConsultation::route('/create'),
            // 'edit' => Pages\EditConsultation::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin();
    }
}
