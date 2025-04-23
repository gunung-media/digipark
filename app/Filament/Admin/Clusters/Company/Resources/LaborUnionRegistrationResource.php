<?php

namespace App\Filament\Admin\Clusters\Company\Resources;

use App\Filament\Admin\Clusters\Company;
use App\Filament\Admin\Clusters\Company\Resources\LaborUnionRegistrationResource\Pages;
use App\Filament\Admin\Clusters\Company\Resources\LaborUnionRegistrationResource\Widgets\LaborUnionRegistrationStats;
use App\Models\Company\LaborUnionRegistration;
use App\Utils\FilamentUtil;
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

class LaborUnionRegistrationResource extends Resource
{
    protected static ?string $model = LaborUnionRegistration::class;
    protected static ?string $label = "Pendaftaran Serikat Pekerja";
    protected static ?string $pluralModelLabel = 'Pendaftaran Serikat Pekerja';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $cluster = Company::class;
    static protected ?int $navigationSort = 1;

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
                                        url: route('filament.company.resources.labor-union-registrations.index'),
                                        title: "Pendaftaran Serikat Pekerja {$state} oleh Admin",
                                        body: "Pendaftaran Serikat Pekerja {$record->requester_name} {$state} oleh Admin",
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
                    Forms\Components\TextInput::make('requester_name')
                        ->label('Nama Pemohon')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('requester_position')
                        ->label('Jabatan Pemohon')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('labor_union_name')
                        ->label('Nama Serikat Pekerja')
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('labor_union_address')
                        ->label('Alamat Serikat Pekerja')
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('phone_number')
                        ->label("Nomor Telepon/WA")
                        ->numeric()
                        ->columnSpanFull()
                        ->required(),
                    Forms\Components\TextInput::make('company_email')
                        ->label('Email Perusahaan')
                        ->email()
                        ->required(),
                    Forms\Components\TextInput::make('labor_union_email')
                        ->label('Email Serikat Pekerja')
                        ->email(),
                    Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),

                    SignaturePad::make('signature')
                        ->columnSpanFull()
                        ->label('Tanda Tangan')
                        ->required()
                        ->downloadable(),
                ])->disabled()
                    ->columns(2),

                Section::make('Berkas')->schema([
                    Forms\Components\FileUpload::make('doc_member_list')
                        ->required()
                        ->label('Daftar Nama Anggota')
                        ->disk('public')
                        ->directory('company/labor-union-registration')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_budget')
                        ->required()
                        ->label('Anggaran Dasar Rumah Tangga')
                        ->disk('public')
                        ->directory('company/labor-union-registration')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_arrangement')
                        ->required()
                        ->label('Susunan dan Nama Pengurus')
                        ->disk('public')
                        ->directory('company/labor-union-registration')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_photocopies')
                        ->required()
                        ->label('Fotocopy Kartu Tanda Anggota/KTP (Seluruh Anggota)')
                        ->disk('public')
                        ->directory('company/labor-union-registration')
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
                Tables\Columns\TextColumn::make('company.name')
                    ->label('Nama Perusahaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('requester_name')
                    ->label('Nama Pemohon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('labor_union_name')
                    ->label('Nama Serikat Pekerja')
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
                    ->action(function (LaborUnionRegistration $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.labor-union-registration', ['record' => $record])
                            )->stream();
                        }, "pendaftaran-serikat-pekerja-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
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
                            $zipFileName = 'bulk-pendaftaran-serikat-pekerja-' . now()->format('d_m_Y') . '.zip';
                            $zipPath = storage_path("app/public/$zipFileName");

                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                                foreach ($records as $record) {
                                    $pdfContent = Pdf::loadHtml(
                                        Blade::render('pdf.labor-union-registration', ['record' => $record])
                                    )->output();

                                    $pdfFileName = "pendaftaran-serikat-pekerja-{$record->id}-" . now()->format('d_m_Y') . ".pdf";
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
            LaborUnionRegistrationStats::class,
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
            'index' => Pages\ListLaborUnionRegistrations::route('/'),
            'create' => Pages\CreateLaborUnionRegistration::route('/create'),
            'edit' => Pages\EditLaborUnionRegistration::route('/{record}/edit'),
        ];
    }
}
