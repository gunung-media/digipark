<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\PlacementResource\Pages;
use App\Filament\Company\Resources\PlacementResource\RelationManagers;
use App\Models\Company\Placement;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlacementResource extends Resource
{
    protected static ?string $model = Placement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('Main Data')->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('identity_number')
                            ->label('NIK')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('gender')
                            ->required()
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('education')
                            ->required()
                            ->options([
                                "Tidak Ada" => 'Tidak Ada',
                                "SD" => 'SD',
                                "SMP" => 'SMP',
                                "SMA/SMK" => 'SMA/SMK',
                                "Kuliah" => 'KuliahSMA',
                            ]),
                        Forms\Components\TextInput::make('phone')
                            ->required(),
                        Forms\Components\DatePicker::make('date_worked')
                            ->label('Tanggal Mulai Bekerja')
                            ->required(),
                        Forms\Components\TextInput::make('position')
                            ->label('Posisi')
                            ->required(),
                        TinyEditor::make('description')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('private')
                            ->fileAttachmentsDirectory('placement/description')
                            ->required(),
                        Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                    ])->columns(2),
                    Tab::make('Tanda Tangan')->schema([
                        SignaturePad::make('signature')
                            ->columnSpanFull()
                            ->required()
                            ->downloadable(),
                    ])
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlacements::route('/'),
            'create' => Pages\CreatePlacement::route('/create'),
            'edit' => Pages\EditPlacement::route('/{record}/edit'),
        ];
    }
}
