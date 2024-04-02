<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubMenuResource\Pages;
use App\Models\Admin\Menu\SubMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class SubMenuResource extends Resource
{
    protected static ?string $model = SubMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('author')->default('Admin'),
                Forms\Components\Select::make('menu_id')
                    ->relationship('menu', 'name')
                    ->required()
                    ->default(request()->query('ownerRecord')),
                Forms\Components\Select::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])->default(1),
                Forms\Components\FileUpload::make('image')
                    ->disk('public')
                    ->directory('news')
                    ->image()
                    ->columnSpan(2),
                TinyEditor::make('body')
                    ->columnSpan(2)
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('private')
                    ->fileAttachmentsDirectory('news/body')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('menu.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->defaultImageUrl(url('/portal/images/news/close-up-volunteer-oganizing-stuff-donation.jpg'))
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('menu')->relationship('menu', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->action(function (SubMenu $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (SubMenu $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->action(function (SubMenu $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn (SubMenu $record): bool => $record->is_active),
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
            'index' => Pages\ListSubMenus::route('/'),
            'create' => Pages\CreateSubMenu::route('/create'),
            'edit' => Pages\EditSubMenu::route('/{record}/edit'),
        ];
    }
}
