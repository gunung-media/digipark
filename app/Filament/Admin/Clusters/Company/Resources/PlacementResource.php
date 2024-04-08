<?php

namespace App\Filament\Admin\Clusters\Company\Resources;

use App\Filament\Admin\Clusters\Company;
use App\Filament\Admin\Clusters\Company\Resources\PlacementResource\Pages;
use App\Filament\Admin\Clusters\Company\Resources\PlacementResource\Widgets\PlacementStats;
use App\Models\Company\Placement;
use App\Utils\FilamentUtil;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class PlacementResource extends Resource
{
    protected static ?string $model = Placement::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $label = 'Laporan Penempatan';
    protected static ?string $pluralModelLabel = 'Laporan Penempatan';
    protected static ?string $cluster = Company::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Tabs::make()->tabs([
                        Tab::make('Data Utama')->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->label('Nama Tenaga Kerja')
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('identity_number')
                                ->label('NIK')
                                ->required()
                                ->maxLength(255)
                                ->columnSpanFull(),
                            Forms\Components\Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->required()
                                ->options([
                                    'male' => 'Laki-laki',
                                    'female' => 'Perempuan',
                                ])
                                ->columnSpanFull(),
                            Forms\Components\Textarea::make('address')
                                ->label('Alamat Domisili')
                                ->required()
                                ->columnSpanFull(),
                            Forms\Components\Select::make('education')
                                ->label('Pendidikan Terakhir')
                                ->required()
                                ->options([
                                    "Tidak Ada" => 'Tidak Ada',
                                    "SD" => 'SD',
                                    "SMP" => 'SMP',
                                    "SMA/SMK" => 'SMA/SMK',
                                    "Kuliah" => 'KuliahSMA',
                                ]),
                            Forms\Components\TextInput::make('phone')
                                ->label('Nomor Kontak')
                                ->required(),
                            Forms\Components\DatePicker::make('date_worked')
                                ->label('Tanggal Mulai Bekerja')
                                ->required(),
                            Forms\Components\TextInput::make('position')
                                ->label('Jabatan')
                                ->required(),
                            TinyEditor::make('description')
                                ->label('Katerangan')
                                ->columnSpanFull()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('private')
                                ->fileAttachmentsDirectory('placement/description')
                                ->setConvertUrls(false)
                                ->required(),
                            Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                        ])->columns(2)->disabled(),
                        Tab::make('Tanda Tangan')->schema([
                            SignaturePad::make('signature')
                                ->label('Tanda Tangan')
                                ->columnSpanFull()
                                ->required()
                                ->downloadable(),
                        ])->disabled()
                    ])->columnSpanFull(),
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
                                        url: route('filament.company.resources.placements.index'),
                                        title: "Laporan Penempatan {$state} oleh Admin",
                                        body: "Laporan Penempatan {$record->name} {$state} oleh Admin",
                                        companyId: $record->company_id
                                    );
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('identity_number')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan')
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
                    ->action(function (Placement $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadHtml(
                                Blade::render('pdf.placement', ['record' => $record])
                            )->stream();
                        }, "laporan-penempatan-{$record->id}-" . now()->format('d_m_Y') . ".pdf", ['content-type' => 'application/pdf']);
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
            PlacementStats::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlacements::route('/'),
            'create' => Pages\CreatePlacement::route('/create'),
            'edit' => Pages\EditPlacement::route('/{record}/edit'),
        ];
    }
}
