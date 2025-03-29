<?php

namespace App\Filament\Admin\Clusters\Company\Resources;

use App\Filament\Admin\Clusters\Company;
use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Pages;
use App\Filament\Admin\Clusters\Company\Resources\LaborDemandResource\Widgets\LaborDemandStat;
use App\Models\Company\LaborDemand;
use App\Utils\FilamentUtil;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class LaborDemandResource extends Resource
{
    protected static ?string $model = LaborDemand::class;
    protected static ?string $label = 'Laporan Permintaan Tenaga Kerja';
    protected static ?string $pluralModelLabel = 'Laporan Permintaan Tenaga Kerja';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $cluster = Company::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Tabs::make()->tabs([
                        Tab::make('Informasi')
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
                        Tab::make('Persyaratan')
                            ->schema([
                                Forms\Components\Select::make('education')
                                    ->label('Pendidikan Tertinggi')
                                    ->required()
                                    ->options([
                                        "Tidak Ada" => 'Tidak Ada',
                                        "SD" => 'SD',
                                        "SMP" => 'SMP',
                                        "SMA/SMK" => 'SMA/SMK',
                                        "Kuliah" => 'Kuliah',
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
                                        ->mapWithKeys(fn($val) => [$val => $val])
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
                                        ->mapWithKeys(fn($val) => [$val => $val])
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
                                        ->mapWithKeys(fn($val) => [$val => $val])
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
                        Tab::make('Tanda Tangan')->schema([
                            SignaturePad::make('signature')
                                ->columnSpanFull()
                                ->label('Tanda Tangan')
                                ->required()
                                ->downloadable(),
                        ])
                    ])
                        ->disabled()
                        ->columnSpanFull(),
                    Section::make('')
                        ->schema([
                            ToggleButtons::make('status')
                                ->options([
                                    'diterima' => 'Diterima',
                                    'diproses' => 'Diproses',
                                    'ditunda' => 'Ditunda',
                                    'ditolak' => 'Ditolak',
                                ])
                                ->reactive()
                                ->afterStateUpdated(function ($record, $state) {
                                    $record->status = $state;
                                    $record->save();
                                    Notification::make()
                                        ->success()
                                        ->title(__("Saved"))
                                        ->send();

                                    FilamentUtil::sendNotifToCompany(
                                        url: route('filament.company.resources.labor-demands.index'),
                                        title: "Laporan Permintaan Tenaga Kerja {$state} oleh Admin",
                                        body: "Laporan Permintaan Tenaga Kerja {$record->name_job} {$state} oleh Admin",
                                        companyId: $record->company_id
                                    );
                                })
                                ->required()
                        ])->compact()
                        ->grow(false),
                ])
                    ->from('md')
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Nama Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_job')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_deadline')
                    ->label('Batas Waktu Permintaan')
                    ->date(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'diterima' => 'gray',
                        'ditunda' => 'warning',
                        'diproses' => 'success',
                        'ditolak' => 'danger',
                        'selesai' => 'info',
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
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function (LaborDemand $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.labor-demand', ['record' => $record])
                            )->stream();
                        }, "laporan-permintaan-tenaga-kerja-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                    }),
                Tables\Actions\EditAction::make()->label("View")->icon('heroicon-o-eye'),
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

    public static function getWidgets(): array
    {
        return [
            LaborDemandStat::class,
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
