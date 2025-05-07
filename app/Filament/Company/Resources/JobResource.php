<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\JobResource\Pages;
use App\Models\Company\Job;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class JobResource extends Resource
{
    protected static ?string $label = "Laporan Lowongan";
    protected static ?string $pluralModelLabel = 'Laporan Lowongan';
    protected static ?string $model = Job::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?string $navigationGroup = 'Layanan';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('company_id', FilamentUtil::getUser()->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Data')->schema([
                    Forms\Components\TextInput::make('name_job')
                        ->label('Nama Jabatan')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('address')
                        ->label('Lokasi Pekerjaan')
                        ->required()
                        ->default(function () {
                            return FilamentUtil::getUser()->address;
                        })
                        ->maxLength(255),
                    TinyEditor::make('description')
                        ->label('Deskripsi Pekerjaan')
                        ->columnSpanFull()
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsVisibility('private')
                        ->fileAttachmentsDirectory('jobs/description')
                        ->setConvertUrls(false)
                        ->required(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar')
                        ->disk('public')
                        ->directory('jobs')
                        ->image()
                        ->maxSize(10240)
                        ->columnSpanFull(),
                ])->columns(2),
                Tabs::make()->tabs([
                    Tab::make('Data Tambahan')->schema([
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
                                "Kuliah" => 'KuliahSMA',
                            ]),
                        Forms\Components\TextInput::make('special')
                            ->label('Keahlian Khusus'),
                        Forms\Components\DatePicker::make('deadline')
                            ->label('Deadline Lowongan Pekerjaan'),
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Mulai Pekerjaan')
                            ->required(),
                        Forms\Components\TextInput::make('salary')
                            ->label('Gaji')
                            ->numeric()
                            ->prefix('Rp.')
                            ->default(0)
                            ->columnSpanFull(),
                        Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                    ])->columns(2),
                    Tab::make('Tanda Tangan')->schema([
                        SignaturePad::make('signature')
                            ->label('Tanda Tangan')
                            ->columnSpanFull()
                            ->downloadable(),
                    ])
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                        'selesai' => 'Selesai'
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

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditJob::class,
            Pages\Applicant::class,
        ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\ApplicantRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobs::route('/'),
            'create' => Pages\CreateJob::route('/create'),
            'edit' => Pages\EditJob::route('/{record}/edit'),
            'applicants' => Pages\Applicant::route('/{record}/applicants'),
        ];
    }
}
