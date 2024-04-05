<?php

namespace App\Filament\Admin\Resources\NewsResource\Pages;

use App\Filament\Admin\Resources\NewsResource;
use App\Models\Admin\News\NewsComment as Model;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsComment extends ManageRelatedRecords
{
    protected static string $resource = NewsResource::class;
    protected static string $relationship = 'comments';
    protected static ?string $title = "Kelola Komentar";
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function getNavigationLabel(): string
    {
        return 'Kelola Komentar';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->description(fn ($record) => $record->comment),
                Tables\Columns\IconColumn::make('is_show')
                    ->label('Tampil di web?')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Komentar')
                    ->date(),
            ])
            ->filters([
                SelectFilter::make('is_show')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\Action::make('show')
                    ->action(function (Model $record) {
                        $record->is_show = true;
                        $record->save();
                    })
                    ->hidden(fn (Model $record): bool => $record->is_show),
                Tables\Actions\Action::make('inactive')
                    ->action(function (Model $record) {
                        $record->is_show = false;
                        $record->save();
                    })
                    ->visible(fn (Model $record): bool => $record->is_show),
                Tables\Actions\DeleteAction::make(),
            ])
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
                Tables\Grouping\Group::make('is_show')
                    ->label('Tampil di website')
                    ->collapsible(),
            ]);
    }
}
