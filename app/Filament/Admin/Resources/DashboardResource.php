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
    protected static ?string $label = "Konten Website";
    protected static ?string $pluralModelLabel = "Konten Website";
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Tabs::make()
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('Tentang Kami Section')->schema([
                                Forms\Components\RichEditor::make('short_description')
                                    ->label("Deskripsi")
                                    ->columnSpanFull()
                                    ->required(),
                                Forms\Components\RichEditor::make('mission')
                                    ->label("Misi")
                                    ->columnSpanFull()
                                    ->required(),
                                Forms\Components\FileUpload::make('our_story_image')
                                    ->label('Gambar')
                                    ->disk('public')
                                    ->directory('dashboard')
                                    ->image()
                                    ->columnSpanFull()
                                    ->maxSize(10240)
                                    ->required(),
                            ]),
                            Forms\Components\Tabs\Tab::make('Data Tambahan')
                                ->schema([
                                    Forms\Components\TextInput::make('address')->label('Alamat'),
                                    Forms\Components\TextInput::make('video_url')
                                        ->label('Video Sambutan')
                                        ->prefixIcon('heroicon-s-play')
                                        ->placeholder('https://youtu.be/Eo-KmOd3i7s')
                                        ->hint('Gunakan link youtube'),
                                    Forms\Components\RichEditor::make('quote')
                                        ->default('"The purpose of life is not to be happy. It is to be useful, to be honorable, to be compassionate, to have it make some difference that you have lived and lived well."')
                                        ->columnSpanFull(),
                                ])
                        ]),
                    Forms\Components\Section::make('Kontak')->schema([
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
                            ->label('No. Telp')
                            ->prefixIcon('icon-wa'),
                        Forms\Components\TextInput::make('default_text')
                            ->label('Default Text WA')
                            ->default('Halo admin digipark'),
                    ])
                        ->grow(false)
                ])
                    ->from('md')
                    ->columnSpanFull(),
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
