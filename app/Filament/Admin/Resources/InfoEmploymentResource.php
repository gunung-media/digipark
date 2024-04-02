<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InfoEmploymentResource\Pages;
use App\Filament\Admin\Resources\InfoEmploymentResource\RelationManagers;
use App\Models\Admin\InfoEmployment;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InfoEmploymentResource extends Resource
{
    protected static ?string $model = InfoEmployment::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Layanan';
    protected static ?string $label = "Informasi Ketenagakerjaan";
    protected static ?string $pluralModelLabel = "Informasi Ketenagakerjaan";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    TextInput::make('jumlah_pengangguran')->required(),
                    Select::make('nama_kelurahan')->required(),
                    Select::make('nama_kecamatan')->required(),
                    TextInput::make('tahun_perolehan_data')->required(),
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
            'index' => Pages\ListInfoEmployments::route('/'),
            'create' => Pages\CreateInfoEmployment::route('/create'),
            'edit' => Pages\EditInfoEmployment::route('/{record}/edit'),
        ];
    }
}
