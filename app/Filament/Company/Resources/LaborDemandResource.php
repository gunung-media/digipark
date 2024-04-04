<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\LaborDemandResource\Pages;
use App\Models\Company\LaborDemand;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class LaborDemandResource extends Resource
{
    protected static ?string $label = "Laporan Permintaan Tenaga Kerja";
    protected static ?string $pluralModelLabel = 'Laporan Permintaan Tenaga Kerja';
    protected static ?string $model = LaborDemand::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Layanan';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('company_id', FilamentUtil::getUser()->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi')->schema([
                    Forms\Components\DatePicker::make('request_deadline')
                        ->label('Batas Waktu Permintaan')
                        ->required(),
                    Forms\Components\TextInput::make('name_job')
                        ->label('Nama Jabatan / Pekerjaan')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('total_man_needs')
                        ->label('Jumlah Tenaga Kerja Pria yang dibutuhkan')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('total_woman_needs')
                        ->label('Jumlah Tenaga Kerja Perempuan yang dibutuhkan')
                        ->numeric()
                        ->required(),
                ])->columns(2),
                Tabs::make()->schema([
                    Tab::make('Persyarat')
                        ->schema([
                            Forms\Components\Select::make('education')
                                ->label('Pendidikan Tertinggi')
                                ->required()
                                ->options([
                                    "Tidak Ada" => 'Tidak Ada',
                                    "SD" => 'SD',
                                    "SMP" => 'SMP',
                                    "SMA/SMK" => 'SMA/SMK',
                                    "Kuliah" => 'KuliahSMA',
                                ]),
                            Forms\Components\TextInput::make('major')
                                ->label('Jurusan')
                                ->required(),
                            Forms\Components\RichEditor::make('skills')
                                ->label('Keterampilan / Keahlian')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('experience')
                                ->label('Pengalaman')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('special_conditions')
                                ->label('Syarat Khusus')
                                ->required()
                                ->columnSpanFull(),
                        ])->columns(2),
                    Tab::make('Pekerjaan')
                        ->schema([
                            Forms\Components\Select::make('wage_system')
                                ->label('Sistem Pengupahan')
                                ->required()
                                ->options(collect([
                                    'Borongan',
                                    'Harian',
                                    'Mingguan',
                                    'Bulanan'
                                ])
                                    ->mapWithKeys(fn ($val) => [$val => $val])
                                    ->toArray()),
                            Forms\Components\TextInput::make('salary')
                                ->label('Gaji / Upah Sebulan')
                                ->numeric()
                                ->prefix('Rp')
                                ->required(),
                            Forms\Components\Select::make('work_status')
                                ->label('Status Hubungan Kerja')
                                ->required()
                                ->options(collect([
                                    'Waktu Tak Tertentu',
                                    'Waktu Tertentu',
                                ])
                                    ->mapWithKeys(fn ($val) => [$val => $val])
                                    ->toArray()),
                            Forms\Components\TextInput::make('total_hours_per_week')
                                ->label('Jumlah jam kerja dalam seminggu')
                                ->numeric()
                                ->prefix('Jam')
                                ->required(),
                            Forms\Components\Select::make('social_guarantee')
                                ->label('Jaminan Sosial Lainnya')
                                ->required()
                                ->multiple()
                                ->searchable()
                                ->options(collect([
                                    'Tidak Ada',
                                    'Makan',
                                    'Lembur',
                                    'Pakaian Kerja',
                                    'Transport',
                                    'Waktu Istirahat',
                                    'Kecelakaan',
                                    'Kesehataan',
                                    'Cuti',
                                    'Hari Raya',
                                    'Premi/Bonus',
                                    'Hari Tua',
                                ])
                                    ->mapWithKeys(fn ($val) => [$val => $val])
                                    ->toArray()),
                            TinyEditor::make('work_description')
                                ->label('Uraian Tugas')
                                ->columnSpanFull()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('private')
                                ->fileAttachmentsDirectory('placement/description')
                                ->setConvertUrls(false)
                                ->required(),
                            Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                        ])->columns(2),
                    Tab::make('Tanda Tangan')->schema([
                        SignaturePad::make('signature')
                            ->columnSpanFull()
                            ->label('Tanda Tangan')
                            ->required()
                            ->downloadable(),
                    ])
                ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_job')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_deadline')
                    ->date(),
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
            'index' => Pages\ListLaborDemands::route('/'),
            'create' => Pages\CreateLaborDemand::route('/create'),
            'edit' => Pages\EditLaborDemand::route('/{record}/edit'),
        ];
    }
}
