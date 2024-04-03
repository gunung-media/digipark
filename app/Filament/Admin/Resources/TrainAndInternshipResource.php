<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TrainAndInternshipResource\Pages;
use App\Filament\Admin\Resources\TrainAndInternshipResource\RelationManagers;
use App\Models\Admin\TrainAndInternship;
use Filament\Forms;
use Filament\Forms\Components\Section;
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
                        Forms\Components\TextInput::make('Nama Pelatihan/Pemagangan')
                            ->required(),
                        Forms\Components\Select::make('Jenis Informasi')
                            ->options([
                                'Pelatihan' => 'Pelatihan',
                                'Magang' => 'Magang',
                            ])
                            ->required(),
                        Forms\Components\RichEditor::make('Deskripsi')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\TextInput::make('Lokasi Pelaksanaan')
                            ->columnSpanFull()
                            ->required(),
                        Forms\Components\DatePicker::make('Tanggal Pelaksanaan')
                            ->required(),
                        Forms\Components\DatePicker::make('Akhir Pelaksanaan')
                            ->required(),
                        Forms\Components\TextInput::make('Biaya')
                            ->prefix('Rp.')
                            ->required(),
                        Forms\Components\TextInput::make('Persyaratan Peserta'),
                    ])
                    ->columns(2),
                Section::make('')
                    ->schema([
                        Forms\Components\FileUpload::make('Gambar')
                            ->image()
                            ->required(),
                    ])
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
