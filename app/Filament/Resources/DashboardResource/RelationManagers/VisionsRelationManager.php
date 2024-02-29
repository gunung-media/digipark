<?php

namespace App\Filament\Resources\DashboardResource\RelationManagers;

use App\Models\DashboardVision;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisionsRelationManager extends RelationManager
{
    protected static string $relationship = 'visions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->disk('public')
                    ->directory('dashboard_visions')
                    ->image()
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('is_active')->options([
                    1 => 'Active',
                    0 => 'Inactive',
                ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->action(function (DashboardVision $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (DashboardVision $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->action(function (DashboardVision $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn (DashboardVision $record): bool => $record->is_active),
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
