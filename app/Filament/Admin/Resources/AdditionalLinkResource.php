<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AdditionalLinkResource\Pages;
use App\Filament\Admin\Resources\AdditionalLinkResource\RelationManagers;
use App\Models\Admin\Menu\AdditionalLink;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdditionalLinkResource extends Resource
{
    protected static ?string $model = AdditionalLink::class;
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = "Link Tambahan";
    protected static ?string $pluralModelLabel = "Link Tambahan";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required(),
                        Forms\Components\TextInput::make('url')
                            ->url()
                            ->helperText('Link harus diawali dengan https://')
                            ->prefixIcon('heroicon-s-link')
                            ->label('URL')
                            ->required(),
                    ])->columnSpanFull(),
                Forms\Components\Section::make()->schema([
                    Forms\Components\FileUpload::make('doc_picture')
                        ->label('Gambar')
                        ->disk('public')
                        ->directory('addtional-link')
                        ->image()
                        ->columnSpan(2)
                        ->maxSize(10240)
                        ->required(),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('Link')
                    ->openUrlInNewTab()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('doc_picture')
                    ->label('Gambar')
                    ->disk('public')
                    ->square(),
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
            'index' => Pages\ListAdditionalLinks::route('/'),
            'create' => Pages\CreateAdditionalLink::route('/create'),
            'edit' => Pages\EditAdditionalLink::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin();
    }
}
