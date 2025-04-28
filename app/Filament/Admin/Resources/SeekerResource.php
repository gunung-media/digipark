<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SeekerResource\Pages;
use App\Models\Seeker\Seeker;
use App\Utils\FilamentUtil;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeekerResource extends Resource
{
    protected static ?string $model = Seeker::class;
    protected static ?string $label = "Member";
    protected static ?string $pluralModelLabel = "Member";
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Akun';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()
                    ->tabs([
                        Tab::make('Data Pribadi')
                            ->schema([
                                TextInput::make('email')
                                    ->label('Email')
                                    ->required()->columnSpanFull(),
                                TextInput::make('full_name')
                                    ->label('Nama Lengkap')
                                    ->required(),
                                Group::make()
                                    ->relationship('additional')
                                    ->schema([
                                        TextInput::make('identity_number')
                                            ->label('NIK')
                                            ->required(),
                                    ]),
                                TextInput::make('phone_number')
                                    ->label('No. Telpon')
                                    ->required(),
                                Select::make('gender')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                    ])
                                    ->required(),
                                Group::make()
                                    ->relationship('additional')
                                    ->schema([
                                        TextInput::make('birth_place')
                                            ->label('Tempat Lahir')
                                            ->required(),
                                    ]),
                                DatePicker::make('date_of_birth')
                                    ->label('Tanggal Lahir')
                                    ->required(),
                                TextInput::make('address')
                                    ->label('Alamat')
                                    ->required(),
                                Group::make()
                                    ->relationship('additional')
                                    ->schema([
                                        TextInput::make('postal_code')
                                            ->label('Kode Pos')
                                            ->required(),
                                    ]),
                                Group::make()
                                    ->relationship('additional')
                                    ->schema([
                                        TextInput::make('rt')
                                            ->label('RT')
                                            ->required(),
                                        TextInput::make('rw')
                                            ->label('RW')
                                            ->required(),
                                    ])->columns(2)
                                    ->columnSpanFull()
                            ])
                            ->columns(2),
                        Tab::make('Dokumen Tambahan')
                            ->schema([
                                Group::make()
                                    ->relationship('additional')
                                    ->schema([
                                        FileUpload::make('doc_ktp')
                                            ->label('KTP')
                                            ->disk('public')
                                            ->directory('seeker/additional')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        FileUpload::make('doc_bpjs_card')
                                            ->label('Kartu BPJS')
                                            ->disk('public')
                                            ->directory('seeker/additional')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        FileUpload::make('doc_cv')
                                            ->label('Surat Pengalaman Kerja / CV / Resume')
                                            ->disk('public')
                                            ->directory('seeker/additional')
                                            ->downloadable()
                                            ->columnSpanFull(),
                                        SignaturePad::make('signature')
                                            ->label('Tanda Tangan')
                                            ->columnSpanFull()
                                            ->downloadable(),
                                    ])->columnSpanFull()
                            ])
                            ->columns(2),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('address')->label('Alamat')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label('No. Telpon')
                    ->searchable(),
                TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->formatStateUsing(fn(string $state): string => __($state === 'male' ? 'Laki-laki' : 'Perempuan'))
                    ->sortable(),
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
            'index' => Pages\ListSeekers::route('/'),
            'create' => Pages\CreateSeeker::route('/create'),
            'edit' => Pages\EditSeeker::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin();
    }
}
