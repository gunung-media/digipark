<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DashboardResource\Pages;
use App\Filament\Resources\DashboardResource\RelationManagers;
use App\Models\Dashboard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DashboardResource extends Resource
{
    protected static ?string $model = Dashboard::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\RichEditor::make('short_description')
                    ->columnSpanFull()
                    ->maxLength(50)
                    ->required(),
                Forms\Components\RichEditor::make('mission')
                    ->columnSpanFull()
                    ->maxLength(50)
                    ->required(),
                Forms\Components\RichEditor::make('quote')
                    ->default('"The purpose of life is not to be happy. It is to be useful, to be honorable, to be compassionate, to have it make some difference that you have lived and lived well."')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('our_story_image')
                    ->disk('public')
                    ->directory('dashboard')
                    ->image()
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('facebook')
                    ->prefixIcon('icon-fb'),
                Forms\Components\TextInput::make('instagram')
                    ->prefixIcon('icon-ig'),
                Forms\Components\TextInput::make('twitter')
                    ->prefixIcon('icon-x'),
                Forms\Components\TextInput::make('youtube')
                    ->prefixIcon('icon-yt'),
                Forms\Components\TextInput::make('linkedin')
                    ->prefixIcon('icon-linkedin'),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('phone_number')
                    ->prefixIcon('icon-wa'),
                Forms\Components\TextInput::make('default_text')
                    ->label('Default Text WA')
                    ->default('Halo admin digipark'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            RelationManagers\ImagesRelationManager::class,
            RelationManagers\VisionsRelationManager::class,
            RelationManagers\TestimonialsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDashboards::route('/'),
            'create' => Pages\CreateDashboard::route('/create'),
            'edit' => Pages\EditDashboard::route('/{record}/edit'),
        ];
    }
}
