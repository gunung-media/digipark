<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\CompanyLegalizationResource\Pages;
use App\Filament\Company\Resources\CompanyLegalizationResource\RelationManagers;
use App\Models\Company\CompanyLegalization;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyLegalizationResource extends Resource
{
    protected static ?string $label = "Laporan Pengesahan";
    protected static ?string $pluralModelLabel = 'Laporan Pengesahan';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $model = CompanyLegalization::class;
    protected static ?string $navigationGroup = 'Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()->tabs([
                    Tab::make('Main Data')->schema([
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
                    ])->columns(2),
                    Tab::make('Karyawan')->schema([
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
                    ])->columns(2),
                    Tab::make('Pengupahan')->schema([
                        TextInput::make('minimum_monthly_wage')
                            ->label('Upah Pekerja Bulanan Minimum')
                            ->prefix('Rp.')
                            ->numeric()
                            ->required(),
                        TextInput::make('maximum_monthly_wage')
                            ->label('Upah Pekerja Bulanan Maximum')
                            ->prefix('Rp.')
                            ->numeric()
                            ->required(),
                        TextInput::make('minimum_daily_wage')
                            ->label('Upah Pekerja Harian Minimum')
                            ->prefix('Rp.')
                            ->numeric()
                            ->required(),
                        TextInput::make('maximum_daily_wage')
                            ->label('Upah Pekerja Harian Maximum')
                            ->prefix('Rp.')
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
                    ])->columns(2),
                ])->columnSpanFull(),
                Section::make('Dokument')->schema([
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Nama Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_regulation_effective_date')
                    ->label('Tanggal Berlaku')
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
            'index' => Pages\ListCompanyLegalizations::route('/'),
            'create' => Pages\CreateCompanyLegalization::route('/create'),
            'edit' => Pages\EditCompanyLegalization::route('/{record}/edit'),
        ];
    }
}
