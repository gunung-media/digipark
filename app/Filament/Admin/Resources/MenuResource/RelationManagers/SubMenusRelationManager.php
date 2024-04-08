<?php

namespace App\Filament\Admin\Resources\MenuResource\RelationManagers;

use App\Filament\Admin\Resources\SubMenuResource;
use App\Models\Admin\Menu\SubMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SubMenusRelationManager extends RelationManager
{
    protected static string $relationship = 'subMenus';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author')
                    ->label('Pengarang')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->defaultImageUrl(url('/portal/images/news/close-up-volunteer-oganizing-stuff-donation.jpg'))
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif di Web')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->url(fn ($livewire): string => SubMenuResource::getUrl('create', ['ownerRecord' => $livewire->ownerRecord->getKey()])),
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->label('Aktifkan')
                    ->action(function (SubMenu $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (SubMenu $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->label('Non Aktifkan')
                    ->action(function (SubMenu $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn (SubMenu $record): bool => $record->is_active),
                Tables\Actions\EditAction::make()
                    ->url(fn (Model $record): string => SubMenuResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
