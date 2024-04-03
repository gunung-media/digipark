<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TrainAndInternshipResource\Pages;
use App\Filament\Admin\Resources\TrainAndInternshipResource\RelationManagers;
use App\Models\Admin\TrainAndInternship;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainAndInternshipResource extends Resource
{
    protected static ?string $model = TrainAndInternship::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $pluralModelLabel = 'Info Pelatihan Dan Magang';
    protected static ?string $label = 'Info Pelatihan Dan Magang';
    protected static ?string $navigationGroup = 'Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Forms\Components\FileUpload::make('Gambar')
                            ->image()
                            ->required(),
                    ]),
                Split::make([
                    Section::make('')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Pelatihan/Pemagangan')
                                ->required(),
                            Forms\Components\TextInput::make('location')
                                ->label('Lokasi Pelaksanaan')
                                ->required(),
                            Forms\Components\RichEditor::make('description')
                                ->label('Deskripsi')
                                ->columnSpanFull()
                                ->required(),
                            Forms\Components\DatePicker::make('start_date')
                                ->label('Tanggal Pelaksanaan')
                                ->required(),
                            Forms\Components\DatePicker::make('end_date')
                                ->label('Akhir Pelaksanaan')
                                ->required(),
                            Forms\Components\TextInput::make('fee')
                                ->label('Biaya')
                                ->prefix('Rp.')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('requirement')
                                ->label('Persyaratan Peserta')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                    Section::make('')->schema([
                        Forms\Components\Select::make('type')
                            ->label('Jenis Informasi')
                            ->options([
                                'train' => 'Pelatihan',
                                'internship' => 'Magang',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Apakah Ini Tampil Di Website?')
                            ->default(false),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainAndInternships::route('/'),
            'create' => Pages\CreateTrainAndInternship::route('/create'),
            'edit' => Pages\EditTrainAndInternship::route('/{record}/edit'),
        ];
    }
}
