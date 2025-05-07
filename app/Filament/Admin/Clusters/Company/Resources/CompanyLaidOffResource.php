<?php

namespace App\Filament\Admin\Clusters\Company\Resources;

use App\Filament\Admin\Clusters\Company;
use App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource\Pages;
use App\Filament\Admin\Clusters\Company\Resources\CompanyLaidOffResource\Widgets\CompanyLaidOffStats;
use App\Models\Company\CompanyLaidOff;
use App\Utils\FilamentUtil;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use ZipArchive;
use Illuminate\Support\Facades\Blade;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class CompanyLaidOffResource extends Resource
{
    protected static ?string $label = "Laporan PHK";
    protected static ?string $pluralModelLabel = 'Laporan PHK';
    protected static ?string $model = CompanyLaidOff::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-minus';
    protected static ?string $cluster = Company::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make('Main Data')
                        ->description('Perusahaan')
                        ->schema([
                            Forms\Components\Placeholder::make('company.name')->content(function ($record) {
                                return $record->company->name ?? "-";
                            }),
                            Forms\Components\Placeholder::make('company.company_type')->label("Jenis Perusahaan")->content(function ($record) {
                                return $record->company->company_type ?? "-";
                            }),
                            Forms\Components\Placeholder::make('company.company_status')->label("Status Perusahaan")->content(function ($record) {
                                return $record->company->company_status ?? "-";
                            }),
                            Forms\Components\Placeholder::make('company.address')->label('Alamat')->content(function ($record) {
                                return $record->company->company_status ?? "-";
                            })
                        ])
                        ->disabled(),
                    Section::make('')
                        ->schema([
                            ToggleButtons::make('status')
                                ->options([
                                    'diterima' => 'Diterima',
                                    'diproses' => 'Diproses',
                                    'ditunda' => 'Ditunda',
                                    'ditolak' => 'Ditolak',
                                    'selesai' => 'Selesai'
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
                                        url: route('filament.company.resources.company-laid-offs.index'),
                                        title: "Laporan PHK {$state} oleh Admin",
                                        body: "Laporan PHK {$record->responsible_name} {$state} oleh Admin",
                                        companyId: $record->company_id,
                                        sendEmail: true
                                    );
                                })
                                ->required()
                        ])->compact()
                        ->grow(false),
                ])
                    ->from('md')
                    ->columnSpanFull(),
                Tabs::make()->tabs([
                    Tab::make('Penanggung Jawab')->schema([
                        Forms\Components\TextInput::make('responsible_name')
                            ->label('Nama')
                            ->required(),
                        Forms\Components\TextInput::make('responsible_position')
                            ->label('Posisi')
                            ->required(),
                        SignaturePad::make('signature')
                            ->label('Tanda Tangan')
                            ->columnSpanFull()
                            ->downloadable(),
                    ])->columns(2),
                    Tab::make('Data')->schema([
                        Forms\Components\RichEditor::make('response_worker')
                            ->label('Tanggapan pekerja')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('position')
                            ->label('Jabatan')
                            ->required(),
                        Forms\Components\TextInput::make('division')
                            ->label('Divisi')
                            ->required(),
                        Forms\Components\DatePicker::make('start_contract')
                            ->label('Tanggal Perjanjian Kerja')
                            ->required(),
                        Forms\Components\DatePicker::make('end_contract')
                            ->label('Kompensasi pemutusan hubungan kerja dan hak-hak lainnya dibayar pada tanggal')
                            ->required(),
                        Forms\Components\RichEditor::make('reason')
                            ->label('Alasan pemutusan hubungan kerja')
                            ->columnSpanFull()->required(),
                        Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                    ])->columns(2),
                    Tab::make('Dokumen')->schema([
                        Forms\Components\FileUpload::make('doc_joint_agreement')
                            ->label('Surat Perjanjian Kerja')
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->maxSize(10240)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_not_rejecting_layoff')
                            ->label('Surat Tidak Menolak PHK')
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->maxSize(10240)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_layoff_notification')
                            ->label('Surat Pemberitahuan PHK')
                            ->required()
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->maxSize(10240)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_participant_card')
                            ->label('Kartu Peserta')
                            ->required()
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->maxSize(10240)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_bpjs_card')
                            ->label('BPJS Jamsotek')
                            ->required()
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->maxSize(10240)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_bpjs_card')
                            ->label('Identitas')
                            ->helperText('KTP, SIM, Passport, Dll.')
                            ->required()
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->maxSize(10240)
                            ->columnSpanFull(),
                    ])->columns(2)
                ])
                    ->disabled()
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
                Tables\Columns\TextColumn::make('responsible_name')
                    ->label('Nama Penanggung Jawab')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Karyawan PHK')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->action(function (CompanyLaidOff $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.company-laid-off', ['record' => $record])
                            )->stream();
                        }, "laporan-phk-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                    }),
                Tables\Actions\EditAction::make()->label("View")->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('download')
                        ->label('Download PDF')
                        ->icon('heroicon-o-arrow-down-on-square')
                        ->action(function (Collection $records) {
                            $zipFileName = 'bulk-laporan-phk-' . now()->format('d_m_Y') . '.zip';
                            $zipPath = storage_path("app/public/$zipFileName");

                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                                foreach ($records as $record) {
                                    $pdfContent = Pdf::loadHtml(
                                        Blade::render('pdf.company-laid-off', ['record' => $record])
                                    )->output();

                                    $pdfFileName = "laporan-phk-{$record->id}-" . now()->format('d_m_Y') . ".pdf";
                                    $zip->addFromString($pdfFileName, $pdfContent);
                                }
                                $zip->close();
                            } else {
                                return response()->json(['error' => 'Failed to create ZIP file'], 500);
                            }

                            return response()->download($zipPath)->deleteFileAfterSend(true);
                        })
                ]),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            CompanyLaidOffStats::class,
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
            'index' => Pages\ListCompanyLaidOffs::route('/'),
            'create' => Pages\CreateCompanyLaidOff::route('/create'),
            'edit' => Pages\EditCompanyLaidOff::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin() || (FilamentUtil::isContent() && FilamentUtil::getUser()->role === 'HI dan Jamsostek');
    }
}
