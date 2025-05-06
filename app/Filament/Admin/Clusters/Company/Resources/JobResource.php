<?php

namespace App\Filament\Admin\Clusters\Company\Resources;

use App\Filament\Admin\Clusters\Company;
use App\Filament\Admin\Clusters\Company\Resources\JobResource\Pages;
use App\Filament\Admin\Clusters\Company\Resources\JobResource\Widgets\JobStats;
use App\Models\Company\Job;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Illuminate\Support\Collection;
use ZipArchive;

class JobResource extends Resource
{
    protected static ?string $model = Job::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $label = "Pekerjaan";
    protected static ?string $pluralModelLabel = 'Laporan Pekerjaan';
    protected static ?string $cluster = Company::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Tabs::make()->tabs([
                        Tab::make('Data Utama')
                            ->schema([
                                Forms\Components\TextInput::make('name_job')
                                    ->label('Nama Jabatan')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('address')
                                    ->label('Lokasi Pekerjaan')
                                    ->required()
                                    ->default(function ($livewire) {
                                        return FilamentUtil::getUser()->address;
                                    })
                                    ->maxLength(255),
                                TinyEditor::make('description')
                                    ->label('Deskripsi Pekerjaan')
                                    ->columnSpanFull()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsVisibility('private')
                                    ->fileAttachmentsDirectory('jobs/description')
                                    ->required(),
                                Forms\Components\FileUpload::make('image')
                                    ->label('Gambar')
                                    ->disk('public')
                                    ->directory('jobs')
                                    ->image()
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->disabled(),
                        Tab::make('Data Tambahan')
                            ->schema([
                                Forms\Components\TextInput::make('total_needed_man')
                                    ->label('Jumlah Lelaki yang dibutuhkan')
                                    ->numeric()
                                    ->required()
                                    ->default(0),
                                Forms\Components\TextInput::make('total_needed_woman')
                                    ->label('Jumlah Wanita yang dibutuhkan')
                                    ->numeric()
                                    ->required()
                                    ->default(0),
                                Forms\Components\Select::make('minimal_education')
                                    ->label('Pendidikan')
                                    ->options([
                                        "Tidak Ada" => 'Tidak Ada',
                                        "SD" => 'SD',
                                        "SMP" => 'SMP',
                                        "SMA/SMK" => 'SMA/SMK',
                                        "Kuliah" => 'Kuliah',
                                    ]),
                                Forms\Components\TextInput::make('special')
                                    ->label('Keahlian Khusus'),
                                Forms\Components\DatePicker::make('deadline')
                                    ->label('Deadline Lowongan Pekerjaan'),
                                Forms\Components\DatePicker::make('start_date')
                                    ->label('Gaji')
                                    ->required(),
                                Forms\Components\TextInput::make('salary')
                                    ->label('Mulai Pekerjaan')
                                    ->numeric()
                                    ->prefix('Rp.')
                                    ->default(0),
                                Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                            ])
                            ->columns(2)
                            ->disabled(),
                        Tab::make('Tanda Tangan')
                            ->schema([
                                SignaturePad::make('signature')
                                    ->label('Tanda Tangan')
                                    ->columnSpanFull()
                                    ->downloadable(),
                            ])
                            ->disabled()
                    ])->columnSpanFull(),
                    Section::make('')
                        ->schema([
                            ToggleButtons::make('status')
                                ->options([
                                    'diterima' => 'Diterima',
                                    'diproses' => 'Diproses',
                                    'ditunda' => 'Ditunda',
                                    'ditolak' => 'Ditolak',
                                    'selesai' => 'Selesai',
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
                                        url: route('filament.company.resources.jobs.index'),
                                        title: "Laporan Lowongan {$state} oleh Admin",
                                        body: "Laporan Lowongan {$record->name_job} {$state} oleh Admin",
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
                    ->label('Nama Pekerjaan')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label("Aktif Di Web")
                    ->boolean(),
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
                SelectFilter::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
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
                    ->action(function (Job $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.job', ['record' => $record])
                            )->stream();
                        }, "laporan-pekerjaan-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
                    }),
                Tables\Actions\Action::make('active')
                    ->action(function (Job $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn(Job $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->action(function (Job $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn(Job $record): bool => $record->is_active),
                Tables\Actions\EditAction::make()->label("View")->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('download')
                        ->label('Download PDF')
                        ->icon('heroicon-o-arrow-down-on-square')
                        ->action(function (Collection $records) {
                            $zipFileName = 'bulk-laporan-pekerjaan-' . now()->format('d_m_Y') . '.zip';
                            $zipPath = storage_path("app/public/$zipFileName");

                            $zip = new ZipArchive;
                            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                                foreach ($records as $record) {
                                    $pdfContent = Pdf::loadHtml(
                                        Blade::render('pdf.job', ['record' => $record])
                                    )->output();

                                    $pdfFileName = "laporan-pekerjaan-{$record->id}-" . now()->format('d_m_Y') . ".pdf";
                                    $zip->addFromString($pdfFileName, $pdfContent);
                                }
                                $zip->close();
                            } else {
                                return response()->json(['error' => 'Failed to create ZIP file'], 500);
                            }

                            return response()->download($zipPath)->deleteFileAfterSend(true);
                        })
                ])
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            JobStats::class,
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
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin() || (FilamentUtil::isContent() && FilamentUtil::getUser()->role === 'Binapenta');
    }
}
