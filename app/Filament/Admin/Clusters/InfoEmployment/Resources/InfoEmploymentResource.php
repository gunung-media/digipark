<?php

namespace App\Filament\Admin\Clusters\InfoEmployment\Resources;

use App\Filament\Admin\Clusters\InfoEmployment as Cluster;
use App\Filament\Admin\Clusters\InfoEmployment\Resources\InfoEmploymentResource\Pages;
use App\Models\Admin\InfoEmployment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use KodePandai\Indonesia\Models\District;
use KodePandai\Indonesia\Models\Village;

class InfoEmploymentResource extends Resource
{
    protected static ?string $model = InfoEmployment::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $cluster = Cluster::class;
    protected static ?string $label = "Informasi Ketenagakerjaan";
    protected static ?string $pluralModelLabel = "Informasi Ketenagakerjaan";
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('district')
                        ->label('Kecamatan')
                        ->options(District::query()
                            ->where('city_code', 6271)
                            ->pluck('name', 'code'))
                        ->searchable()
                        ->dehydrated(false)
                        ->live(),
                    Select::make('village_code')
                        ->label('Kelurahan/Desa')
                        ->options(fn(Get $get): Collection => Village::query()
                            ->where('district_code', $get('district'))
                            ->pluck('name', 'code'))
                        ->searchable()
                        ->required(),
                ])->columns(2)->disabled(fn($record) => !is_null($record)),
                Section::make()->schema([
                    DatePicker::make('date_in')
                        ->label('Tanggal Perolehan Data')
                        ->required(),
                    TextInput::make('unemployed_count')
                        ->label('Jumlah Pengangguran')
                        ->numeric()
                        ->required(),
                    TextInput::make('seeker_count')
                        ->label('Jumlah Pencari Kerja')
                        ->numeric()
                        ->required(),
                    TextInput::make('job_count')
                        ->label('Jumlah Lowongan Pekerjaan')
                        ->numeric()
                        ->required(),
                    TextInput::make('placement_count')
                        ->label('Jumlah Penempatan Kerja')
                        ->numeric()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('village.district.name')
                    ->label('Kecamatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('village.name')
                    ->label('Kelurahan/Desa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_in')
                    ->label('Tanggal Perolehan Data')
                    ->date()
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unemployed_count')
                    ->label('Jumlah Pengangguran')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('seeker_count')
                    ->label('Jumlah Pencari Kerja')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_count')
                    ->label('Jumlah Lowongan Pekerjaan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('placement_count')
                    ->label('Jumlah Penempatan Kerja')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                Tables\Grouping\Group::make('village.district.name')
                    ->label('Kecamatan')
                    ->collapsible(),
                Tables\Grouping\Group::make('village.name')
                    ->label('Kelurahan')
                    ->collapsible(),
                Tables\Grouping\Group::make('date_in')
                    ->label('Tanggal Perolehan Data')
                    ->date()
                    ->collapsible(),
            ]);;
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
