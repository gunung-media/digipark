<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\NewsResource\Pages;
use App\Models\Admin\News\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?string $label = "Berita";
    protected static ?string $pluralModelLabel = "Berita";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar')
                            ->disk('public')
                            ->directory('news')
                            ->image()
                            ->columnSpan(2)
                            ->required(),
                    ]),
                Forms\Components\Split::make([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Forms\Components\TextInput::make('author')
                            ->label('Pembuat Berita')
                            ->default('Admin'),
                        TinyEditor::make('body')
                            ->label('Isi Berita')
                            ->columnSpan(2)
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('private')
                            ->fileAttachmentsDirectory('news/body')
                            ->setConvertUrls(false)
                            ->required(),
                    ]),
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->required(),
                        Forms\Components\Select::make('tags')
                            ->label('Tag')
                            ->relationship('tags', 'name')
                            ->searchable()
                            ->preload()
                            ->multiple()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Toggle::make('status')
                            ->label('Apakah Ini Tampil Di Website?')
                            ->default(false),
                    ])->grow(false),
                ])->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author')
                    ->label('Pembuat Berita')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Aktif di Web')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->label('Aktifkan')
                    ->action(function (News $record) {
                        $record->status = true;
                        $record->save();
                    })
                    ->hidden(fn (News $record): bool => $record->status),
                Tables\Actions\Action::make('inactive')
                    ->label('Non Aktifkan')
                    ->action(function (News $record) {
                        $record->status = false;
                        $record->save();
                    })
                    ->visible(fn (News $record): bool => $record->status),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditNews::class,
            Pages\NewsComment::class,
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
            'comments' => Pages\NewsComment::route('/{record}/comments'),
        ];
    }
}
