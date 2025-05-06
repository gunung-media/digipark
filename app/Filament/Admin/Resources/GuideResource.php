<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GuideResource\Pages;
use App\Models\Admin\Guide;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GuideResource extends Resource
{
    protected static ?string $model = Guide::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $label = "Panduan";
    protected static ?string $pluralModelLabel = "Panduan";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\FileUpload::make('cover_img')
                            ->label('Gambar Cover')
                            ->disk('public')
                            ->directory('guide')
                            ->image()
                            ->columnSpan(2)
                            ->maxSize(2048)
                            ->required(),
                    ]),
                Forms\Components\Split::make([
                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Judul')
                            ->unique(ignoreRecord: true)
                            ->columnSpan(2)
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpan(2)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('file')
                            ->label('Link Video')
                            ->url()
                            ->prefixIcon('heroicon-o-globe-alt')
                            ->columnSpan(2)
                            ->hidden(fn(Get $get) => $get('is_video') === false)
                            ->required(),
                        Forms\Components\FileUpload::make('file')
                            ->label('Ebook')
                            ->disk('public')
                            ->directory('guide')
                            ->downloadable()
                            ->columnSpan(2)
                            ->hidden(fn(Get $get) => $get('is_video') === true)
                            ->maxSize(2048)
                            ->required(),
                    ])->columns(2),
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Toggle::make('is_video')
                            ->label('Apakah Ini Video?')
                            ->hintIcon('heroicon-o-information-circle')
                            ->hintIconTooltip('Jika iya, input akan berupa url')
                            ->live()
                            ->default(false),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Apakah Ini Tampil Di Website?')
                            ->default(true),
                    ])->grow(false),
                ])
                    ->from('md')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_img')
                    ->label('Cover')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif di Web')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_video')
                    ->label('Video?')
                    ->boolean(),
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
            'index' => Pages\ListGuides::route('/'),
            'create' => Pages\CreateGuide::route('/create'),
            'edit' => Pages\EditGuide::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin();
    }
}
