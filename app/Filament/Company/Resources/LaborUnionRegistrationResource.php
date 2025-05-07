<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\LaborUnionRegistrationResource\Pages;
use App\Models\Company\LaborUnionRegistration;
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

class LaborUnionRegistrationResource extends Resource
{
    protected static ?string $model = LaborUnionRegistration::class;
    protected static ?string $label = "Pendaftaran Serikat Pekerja";
    protected static ?string $pluralModelLabel = 'Pendaftaran Serikat Pekerja';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Layanan';
    static protected ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('company_id', FilamentUtil::getUser()->id);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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

                    Hidden::make('company_id')->default(FilamentUtil::getUser()->id),

                    SignaturePad::make('signature')
                        ->columnSpanFull()
                        ->label('Tanda Tangan')
                        ->required()
                        ->downloadable(),
                ])->columns(2),

                Section::make('Berkas')->schema([
                    Forms\Components\FileUpload::make('doc_member_list')
                        ->required()
                        ->label('Daftar Nama Anggota')
                        ->disk('public')
                        ->directory('company/labor-union-registration')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(10240)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_budget')
                        ->required()
                        ->label('Anggaran Dasar Rumah Tangga')
                        ->disk('public')
                        ->directory('company/labor-union-registration')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(10240)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_arrangement')
                        ->required()
                        ->label('Susunan dan Nama Pengurus')
                        ->disk('public')
                        ->directory('company/labor-union-registration')
                        ->downloadable()
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->maxSize(10240)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('doc_photocopies')
                        ->required()
                        ->label('Fotocopy Kartu Tanda Anggota/KTP (Seluruh Anggota)')
                        ->disk('public')
                        ->directory('company/labor-union-registration')
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
            'index' => Pages\ListLaborUnionRegistrations::route('/'),
            'create' => Pages\CreateLaborUnionRegistration::route('/create'),
            'edit' => Pages\EditLaborUnionRegistration::route('/{record}/edit'),
        ];
    }
}
