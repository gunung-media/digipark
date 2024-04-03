<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DashboardResource\Pages;
use App\Filament\Admin\Resources\DashboardResource\RelationManagers;
use App\Models\Admin\Settings\Dashboard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DashboardResource extends Resource
{
    protected static ?string $model = Dashboard::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Tabs::make()
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('Our Story Section')->schema([
                                Forms\Components\RichEditor::make('short_description')
                                    ->columnSpanFull()
                                    ->required(),
                                Forms\Components\RichEditor::make('mission')
                                    ->columnSpanFull()
                                    ->required(),
                                Forms\Components\FileUpload::make('our_story_image')
                                    ->disk('public')
                                    ->directory('dashboard')
                                    ->image()
                                    ->columnSpanFull()
                                    ->required(),
                            ]),
                            Forms\Components\Tabs\Tab::make('Additional')
                                ->schema([
                                    Forms\Components\TextInput::make('address'),
                                    Forms\Components\RichEditor::make('quote')
                                        ->default('"The purpose of life is not to be happy. It is to be useful, to be honorable, to be compassionate, to have it make some difference that you have lived and lived well."')
                                        ->columnSpanFull(),
                                ])
                        ]),
                    Forms\Components\Section::make('Contact')->schema([
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
                        Forms\Components\TextInput::make('phone_number')
                            ->prefixIcon('icon-wa'),
                        Forms\Components\TextInput::make('default_text')
                            ->label('Default Text WA')
                            ->default('Halo admin digipark'),
                    ])->grow(false)
                ])->columnSpanFull(),
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
