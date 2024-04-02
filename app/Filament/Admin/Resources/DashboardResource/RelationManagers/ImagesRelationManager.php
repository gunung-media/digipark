<?php

namespace App\Filament\Admin\Resources\DashboardResource\RelationManagers;

use App\Models\Admin\Settings\DashboardImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subtitle'),
                Forms\Components\FileUpload::make('image')
                    ->disk('public')
                    ->directory('dashboard_images')
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
                Tables\Columns\TextColumn::make('subtitle'),
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
                    ->action(function (DashboardImage $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (DashboardImage $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->action(function (DashboardImage $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn (DashboardImage $record): bool => $record->is_active),
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
