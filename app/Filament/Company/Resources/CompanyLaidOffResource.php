<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\CompanyLaidOffResource\Pages;
use App\Models\Company\CompanyLaidOff;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class CompanyLaidOffResource extends Resource
{
    protected static ?string $label = "Laporan PHK";
    protected static ?string $pluralModelLabel = 'Laporan PHK';
    protected static ?string $model = CompanyLaidOff::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Data')->description('Perusahaan')->schema([
                    Forms\Components\Placeholder::make('company.name')->content(function () {
                        return FilamentUtil::getUser()->name;
                    }),
                    Forms\Components\Placeholder::make('company.address')->content(function () {
                        return FilamentUtil::getUser()->address;
                    })
                ])->disabled(),
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
                            ->label('Surat Perjanjian Bersama')
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_not_rejecting_layoff')
                            ->label('Surat Tidak Menolak PHK')
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_layoff_notification')
                            ->label('Surat Pemberitahuan PHK')
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->columnSpanFull(),
                    ])->columns(2)
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('responsible_name')
                    ->label('Nama Penanggung Jawab')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Karyawan PHK')
                    ->searchable(isIndividual: true),
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
            'index' => Pages\ListCompanyLaidOffs::route('/'),
            'create' => Pages\CreateCompanyLaidOff::route('/create'),
            'edit' => Pages\EditCompanyLaidOff::route('/{record}/edit'),
        ];
    }
}
