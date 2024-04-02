<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\PlacementResource\Pages;
use App\Models\Company\Placement;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class PlacementResource extends Resource
{
    protected static ?string $label = "Laporan Penempatan";
    protected static ?string $pluralModelLabel = 'Laporan Penempatan';
    protected static ?string $model = Placement::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('Main Data')->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nama Tenaga Kerja')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('identity_number')
                            ->label('NIK')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->required()
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Domisili')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Select::make('education')
                            ->label('Pendidikan Terakhir')
                            ->required()
                            ->options([
                                "Tidak Ada" => 'Tidak Ada',
                                "SD" => 'SD',
                                "SMP" => 'SMP',
                                "SMA/SMK" => 'SMA/SMK',
                                "Kuliah" => 'KuliahSMA',
                            ]),
                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor Kontak')
                            ->required(),
                        Forms\Components\DatePicker::make('date_worked')
                            ->label('Tanggal Mulai Bekerja')
                            ->required(),
                        Forms\Components\TextInput::make('position')
                            ->label('Jabatan')
                            ->required(),
                        TinyEditor::make('description')
                            ->label('Katerangan')
                            ->columnSpanFull()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('private')
                            ->fileAttachmentsDirectory('placement/description')
                            ->required(),
                        Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                    ])->columns(2),
                    Tab::make('Tanda Tangan')->schema([
                        SignaturePad::make('signature')
                            ->label('Tanda Tangan')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('identity_number')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diterima' => 'gray',
                        'ditunda' => 'warning',
                        'diproses' => 'success',
                        'ditolak' => 'danger',
                    })
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'diterima' => 'Diterima',
                        'ditunda' => 'Ditunda',
                        'diproses' => 'Diproses',
                        'ditolak' => 'Ditolak',
                    ]),
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
