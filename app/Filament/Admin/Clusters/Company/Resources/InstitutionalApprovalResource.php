<?php

namespace App\Filament\Admin\Clusters\Company\Resources;

use App\Filament\Admin\Clusters\Company;
use App\Filament\Admin\Clusters\Company\Resources\InstitutionalApprovalResource\Pages;
use App\Filament\Admin\Clusters\Company\Resources\InstitutionalApprovalResource\Widgets\InstitutionalApprovalStats;
use App\Filament\Company\Resources\InstitutionalApprovalResource\Pages\CreateInstitutionalApproval;
use App\Models\Company\InstitutionalApproval;
use App\Utils\FilamentUtil;
use Filament\Forms\Components\Hidden;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Illuminate\Support\Collection;
use ZipArchive;
use Illuminate\Support\Facades\Blade;
use Barryvdh\DomPDF\Facade\Pdf;

class InstitutionalApprovalResource extends Resource
{
    protected static ?string $model = InstitutionalApproval::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $label = "Pengesahan Lembaga LKS BIPARTIT";
    protected static ?string $pluralModelLabel = 'Pengesahan Lembaga LKS BIPARTIT';
    static protected ?int $navigationSort = 2;
    protected static ?string $cluster = Company::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make('Main Data')
                        ->description('Perusahaan')
                        ->schema([
                            Forms\Components\Placeholder::make('company.name')->content(function () {
                                return FilamentUtil::getUser()->name;
                            }),
                            Forms\Components\Placeholder::make('company.company_type')->label("Jenis Perusahaan")->content(function () {
                                return FilamentUtil::getUser()->company_type;
                            }),
                            Forms\Components\Placeholder::make('company.company_status')->label("Status Perusahaan")->content(function () {
                                return FilamentUtil::getUser()->company_status;
                            }),
                            Forms\Components\Placeholder::make('company.address')->label('Alamat')->content(function () {
                                return FilamentUtil::getUser()->address ?? "-";
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
                                        url: route('filament.company.resources.institutional-approvals.index'),
                                        title: "Pengesahan Lembaga LKS BIPARTIT {$state} oleh Admin",
                                        body: "Pengesahan Lembaga LKS BIPARTIT {$record->name} {$state} oleh Admin",
                                        companyId: $record->company_id
                                    );
                                })
                                ->required()
                        ])->compact()
                        ->grow(false),
                ])
                    ->from('md')
                    ->columnSpanFull(),
                Section::make('Data')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Pengurus LKS BIPARTIT')
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('address')
                        ->label('Alamat')
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->label("Nomor Telepon/WA")
                        ->numeric()
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('permission_number')
                        ->label('Nomor Surat Keputusan Izin Usaha')
                        ->required(),
                    Forms\Components\DatePicker::make('permission_date')
                        ->label('Tanggal Surat Keputusan Izin Usaha')
                        ->required(),
                    Forms\Components\TextInput::make('bpjs_number')
                        ->label('Nomor Kepesertaan BPJS')
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('male_employee')
                        ->label('Jumlah Pengurus (Laki-Laki)')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('female_employee')
                        ->label('Jumlah Pengurus (Perempuan)')
                        ->numeric()
                        ->required(),

                    Hidden::make('company_id')->default(FilamentUtil::getUser()->id),

                    SignaturePad::make('signature')
                        ->columnSpanFull()
                        ->label('Tanda Tangan')
                        ->required()
                        ->downloadable(),
                ])->disabled()
                    ->columns(2),

                Section::make('Berkas')->schema([
                    Forms\Components\FileUpload::make('doc_bap')
                        ->required()
                        ->label('BAP Kepengurusan LKS BIPARTIT(TTD & Cap Asli)')
                        ->disk('public')
                        ->directory('company/institutional-approval')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_proofment')
                        ->required()
                        ->label('Bukti Pernah Melaksanakan Rapat Pembentukan (Undangan, Daftar Hadir, Notulensi, Foto Dokumentasi, Dll)')
                        ->disk('public')
                        ->directory('company/institutional-approval')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_administrator')
                        ->required()
                        ->label('Susunan Pengurus LKS BIPARTIT')
                        ->disk('public')
                        ->directory('company/institutional-approval')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->columnSpanFull(),
                ])->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengurus')
                    ->searchable(),
                Tables\Columns\TextColumn::make('permission_number')
                    ->label('Nomor Surat Keputusan Izin Usaha'),
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
                    ->action(function (InstitutionalApproval $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.institutional-approval', ['record' => $record])
                            )->stream();
                        }, "pengesahan-lembaga-lks-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
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
                            $zipFileName = 'bulk-pengesahan-lembaga-lks-' . now()->format('d_m_Y') . '.zip';
                            $zipPath = storage_path("app/public/$zipFileName");

                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                                foreach ($records as $record) {
                                    $pdfContent = Pdf::loadHtml(
                                        Blade::render('pdf.institutional-approval', ['record' => $record])
                                    )->output();

                                    $pdfFileName = "pengesahan-lembaga-lks-{$record->id}-" . now()->format('d_m_Y') . ".pdf";
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
            InstitutionalApprovalStats::class,
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
            'index' => Pages\ListInstitutionalApprovals::route('/'),
            'create' => Pages\CreateInstitutionalApproval::route('/create'),
            'edit' => Pages\EditInstitutionalApproval::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin() || (FilamentUtil::isContent() && FilamentUtil::getUser()->role === 'HI dan Jamsostek');
    }
}
