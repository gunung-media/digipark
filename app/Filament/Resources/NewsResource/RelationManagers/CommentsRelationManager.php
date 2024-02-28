<?php

namespace App\Filament\Resources\NewsResource\RelationManagers;

use App\Models\NewsComment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('comment')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('comment'),
                Tables\Columns\IconColumn::make('is_show')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('is_show')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('show')
                    ->action(function (NewsComment $record) {
                        $record->is_show = true;
                        $record->save();
                    })
                    ->hidden(fn (NewsComment $record): bool => $record->is_show),
                Tables\Actions\Action::make('inactive')
                    ->action(function (NewsComment $record) {
                        $record->is_show = false;
                        $record->save();
                    })
                    ->visible(fn (NewsComment $record): bool => $record->is_show),
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
