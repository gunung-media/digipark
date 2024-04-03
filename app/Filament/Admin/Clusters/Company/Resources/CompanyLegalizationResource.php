<?php

namespace App\Filament\Admin\Clusters\Company\Resources;

use App\Filament\Admin\Clusters\Company;
use App\Filament\Admin\Clusters\Company\Resources\CompanyLegalizationResource\Pages;
use App\Filament\Admin\Clusters\Company\Resources\CompanyLegalizationResource\Widgets\CompanyLegalizationStats;
use App\Models\Company\CompanyLegalization;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyLegalizationResource extends Resource
{
    protected static ?string $model = CompanyLegalization::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $cluster = Company::class;
    protected static ?string $label = "Laporan Pengesahan";
    protected static ?string $pluralModelLabel = 'Laporan Pengesahan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Tabs::make()->tabs([
                        Tab::make('Profile Information')
                            ->schema([
                                Group::make()
                                    ->relationship('company')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Nama Lengkap')
                                            ->required(),
                                        TextInput::make('email')
                                            ->label('Email')
                                            ->email()
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                        TextInput::make('address')
                                            ->label('Alamat')
                                            ->required(),
                                        TextInput::make('phone_number')
                                            ->label('No. Telp')
                                            ->tel()
                                            ->required(),
                                        TextInput::make('company_type')
                                            ->label('Jenis/ Bidang Usaha'),
                                        Select::make('company_status')
                                            ->label('Status Perusahaan')
                                            ->options(
                                                collect([
                                                    'pt',
                                                    'cv',
                                                    'perorangan',
                                                    'badan usaha negara',
                                                    'parsero',
                                                    'pma',
                                                    'perusahaan',
                                                    'joint venture',
                                                    'pmdn'
                                                ])->mapWithKeys(fn ($val) => [$val => strlen($val) < 4 ? strtoupper($val) : ucfirst($val)])
                                                    ->toArray()
                                            )
                                            ->searchable()
                                            ->default(1),
                                        FileUpload::make('image')
                                            ->label('Gambar')
                                            ->disk('public')
                                            ->directory('company')
                                            ->columnSpanFull()
                                            ->required()
                                            ->image()
                                            ->imagePreviewHeight(500)
                                    ])
                            ])->columns(2),
                        Tab::make('Pengesahan')
                            ->schema([
                                Wizard::make()->steps([
                                    Step::make('Input')->schema([
                                        TextInput::make('business_license_decision_letter')
                                            ->label('Surat Keputusan Ijin Usaha')
                                            ->required(),
                                        TextInput::make('labor_union_names')
                                            ->label('Nama-Nama Serikat Pekerja/Serikat Buruh di perusahaan (apabila ada)')
                                            ->required(),
                                        TextInput::make('bpjs_membership_number')
                                            ->label('Nomor Kepesertaan BPJS')
                                            ->required()
                                            ->columnSpanFull(),
                                        TextInput::make('headquarters_male_employee_count')
                                            ->label('Jumlah Pekerja Laki-Laki di Pusat')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('headquarters_female_employee_count')
                                            ->label('Jumlah Pekerja Perempuan di Pusat')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('branch_male_employee_count')
                                            ->label('Jumlah Pekerja Laki-Laki di Cabang')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('branch_female_employee_count')
                                            ->label('Jumlah Pekerja Perempuan di Cabang')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('outsourced_male_employee_count')
                                            ->label('Jumlah Pekerja Laki-Laki di Outsourcing')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('outsourced_female_employee_count')
                                            ->label('Jumlah Pekerja Perempuan di Outsourcing')
                                            ->numeric()
                                            ->required(),
                                        Radio::make('company_regulation_concept')
                                            ->label('Konsep Peraturan Perusahaan')
                                            ->options([
                                                'Baru' => 'Baru',
                                                'Pembaruan' => 'Pembaruan',
                                            ])
                                            ->inline()
                                            ->required(),
                                        DatePicker::make('company_regulation_effective_date')
                                            ->label('Tanggal berlakunya Peraturan Perusahaan yang baru')
                                            ->required(),
                                        TextInput::make('minimum_monthly_wage')
                                            ->label('Upah Pekerja Bulanan Minimum')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('maximum_monthly_wage')
                                            ->label('Upah Pekerja Bulanan Maximum')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('minimum_daily_wage')
                                            ->label('Upah Pekerja Harian Minimum')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('maximum_daily_wage')
                                            ->label('Upah Pekerja Harian Maximum')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('fixed_term_employment_system')
                                            ->label('Sistem Hubungan Kerja Untuk Waktu Tertentu')
                                            ->numeric()
                                            ->required(),
                                        TextInput::make('permanent_employment_system')
                                            ->label('Sistem Hubungan Kerja Untuk Waktu Tidak Tertentu')
                                            ->numeric()
                                            ->required(),
                                    ]),
                                    Step::make('Dokument')->schema([
                                        FileUpload::make('doc_pp')
                                            ->label('Naskah PP')
                                            ->disk('public')
                                            ->directory('company/legalization')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        FileUpload::make('doc_evidence_union_consultation_request')
                                            ->label('Bukti telah dimintakan saran dan pertimbangan dari Serikat Pekerja/Serikat Buruh dan/atau waktu pekerja Apabila diperusahaan tidak ada')
                                            ->disk('public')
                                            ->directory('company/legalization')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        FileUpload::make('doc_union_consultation_statement')
                                            ->label('Surat pernyataan sebagai bukti telah dimintakan saran dan pertimbangan dari Serikat Pekerja/Serikat Buruh')
                                            ->disk('public')
                                            ->directory('company/legalization')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        FileUpload::make('doc_no_union_declaration')
                                            ->label('Surat Pernyataan sebagai bukti tidak ada Serikat Pekerja/Serikat Buruh di Perusahaan.')
                                            ->disk('public')
                                            ->directory('company/legalization')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        FileUpload::make('doc_wage_structure_and_scale')
                                            ->label('Struktur & Skala Upah')
                                            ->disk('public')
                                            ->directory('company/legalization')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        FileUpload::make('doc_bpjs_membership_and_payment_copy')
                                            ->label('Fotocopy tanda keanggotaan dan pembayaran terakhir BPJS')
                                            ->disk('public')
                                            ->directory('company/legalization')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                    ])
                                ])
                                    ->skippable()
                                    ->columns(2),
                            ])
                    ])->disabled(),
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
                                })
                                ->required()
                        ])->compact()
                        ->grow(false),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Nama Perusahaan')
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

    public static function getWidgets(): array
    {
        return [
            CompanyLegalizationStats::class,
        ];
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
            'index' => Pages\ListCompanyLegalizations::route('/'),
            'create' => Pages\CreateCompanyLegalization::route('/create'),
            'edit' => Pages\EditCompanyLegalization::route('/{record}/edit'),
        ];
    }
}
