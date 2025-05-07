<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\InstitutionalApprovalResource\Pages;
use App\Models\Company\InstitutionalApproval;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class InstitutionalApprovalResource extends Resource
{
    protected static ?string $model = InstitutionalApproval::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $label = "Pengesahan Lembaga LKS BIPARTIT";
    protected static ?string $pluralModelLabel = 'Pengesahan Lembaga LKS BIPARTIT';
    protected static ?string $navigationGroup = 'Layanan';
    static protected ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('company_id', FilamentUtil::getUser()->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data')->schema([
                    Forms\Components\TextInput::make('company_name')
                        ->formatStateUsing(fn($state) => $state ?? FilamentUtil::getUser()->name)
                        ->label('Nama Perusahaan')
                        ->dehydrated(false)
                        ->disabled(),
                    Forms\Components\TextInput::make('company_type')
                        ->formatStateUsing(fn() => FilamentUtil::getUser()->company_type ?? "-")
                        ->label('Jenis Perusahaan')
                        ->dehydrated(false)
                        ->disabled(),
                    Forms\Components\TextInput::make('company_status')
                        ->formatStateUsing(fn() => FilamentUtil::getUser()->company_status ?? "-")
                        ->label('Status Perusahaan')
                        ->dehydrated(false)
                        ->disabled()
                        ->columnSpanFull(),
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
                ])->columns(2),

                Section::make('Berkas')->schema([
                    Forms\Components\FileUpload::make('doc_bap')
                        ->required()
                        ->label('BAP Kepengurusan LKS BIPARTIT(TTD & Cap Asli)')
                        ->disk('public')
                        ->directory('company/institutional-approval')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(10240)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_proofment')
                        ->required()
                        ->label('Bukti Pernah Melaksanakan Rapat Pembentukan (Undangan, Daftar Hadir, Notulensi, Foto Dokumentasi, Dll)')
                        ->disk('public')
                        ->directory('company/institutional-approval')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(10240)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_administrator')
                        ->required()
                        ->label('Susunan Pengurus LKS BIPARTIT')
                        ->disk('public')
                        ->directory('company/institutional-approval')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(10240)
                        ->columnSpanFull(),
                ]),
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
            'index' => Pages\ListInstitutionalApprovals::route('/'),
            'create' => Pages\CreateInstitutionalApproval::route('/create'),
            'edit' => Pages\EditInstitutionalApproval::route('/{record}/edit'),
        ];
    }
}
