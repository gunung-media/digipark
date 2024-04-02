<?php

namespace App\Filament\Admin\Clusters\Company\Resources;

use App\Filament\Admin\Clusters\Company;
use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Pages;
use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\RelationManagers;
use App\Models\Company\LaborDemand;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Illuminate\Database\Eloquent\Builder;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaborDemandResource extends Resource
{
    protected static ?string $model = LaborDemand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Company::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Informasi')
                        ->description('INFORMASI LOWONGAN JABATAN / PEKERJAAN')
                        ->schema([
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
                    Step::make('Persyarat')
                        ->description('PERSYARATAN JABATAN')
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
                    Step::make('Pekerjaan')
                        ->description('SISTEM PENGUPAHAN')
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
                                ->required(),
                            Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                        ])->columns(2),
                    Step::make('Tanda Tangan')->schema([
                        SignaturePad::make('signature')
                            ->columnSpanFull()
                            ->label('Tanda Tangan')
                            ->required()
                            ->downloadable(),
                    ])
                ])
                    ->disabled()
                    ->skippable()
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
