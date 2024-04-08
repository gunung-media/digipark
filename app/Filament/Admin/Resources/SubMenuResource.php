<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SubMenuResource\Pages;
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
                Forms\Components\Split::make([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Select::make('menu_id')
                            ->relationship('menu', 'name')
                            ->required()
                            ->default(request()->query('ownerRecord')),
                        Forms\Components\TextInput::make('author')->default('Admin'),
                    ])->columns(2),
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Apakah Ini Tampil Di Website?')
                            ->default(false),
                    ])->grow(false)
                ])->columnSpanFull(),
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->helperText('Maximal Kata 250')
                        ->maxLength(250),
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar')
                        ->disk('public')
                        ->directory('news')
                        ->image()
                        ->columnSpan(2),
                    TinyEditor::make('body')
                        ->columnSpan(2)
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsVisibility('private')
                        ->fileAttachmentsDirectory('news/body')
                        ->setConvertUrls(false)
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('menu.name')
                    ->label('Menu')
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
                SelectFilter::make('menu')->relationship('menu', 'name'),
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
