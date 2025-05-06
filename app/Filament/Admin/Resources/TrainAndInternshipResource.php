<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TrainAndInternshipResource\Pages;
use App\Models\Admin\TrainAndInternship;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class TrainAndInternshipResource extends Resource
{
    protected static ?string $model = TrainAndInternship::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $pluralModelLabel = 'Info Pelatihan Dan Magang';
    protected static ?string $label = 'Info Pelatihan Dan Magang';
    protected static ?string $navigationGroup = 'Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Gambar')
                            ->image()
                            ->disk('public')
                            ->directory('news')
                            ->image()
                            ->maxSize(2048)
                            ->required(),
                    ]),
                Split::make([
                    Section::make('')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama Pelatihan/Pemagangan')
                                ->unique(ignoreRecord: true)
                                ->required(),
                            Forms\Components\TextInput::make('location')
                                ->label('Lokasi Pelaksanaan')
                                ->required(),
                            TinyEditor::make('description')
                                ->label('Deskripsi')
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('private')
                                ->fileAttachmentsDirectory('train-internship')
                                ->setConvertUrls(false)
                                ->columnSpanFull()
                                ->columnSpan(2)
                                ->required(),
                            Forms\Components\DatePicker::make('start_date')
                                ->label('Tanggal Pelaksanaan')
                                ->required(),
                            Forms\Components\DatePicker::make('end_date')
                                ->label('Akhir Pelaksanaan')
                                ->required(),
                            Forms\Components\TextInput::make('fee')
                                ->label('Biaya')
                                ->prefix('Rp.')
                                ->numeric()
                                ->required()
                                ->columns(1)
                                ->columnSpanFull(),
                            TinyEditor::make('requirement')
                                ->label('Persyaratan Peserta')
                                ->columnSpanFull()
                                ->columnSpan(2)
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsVisibility('private')
                                ->fileAttachmentsDirectory('train-internship/requirement')
                                ->setConvertUrls(false)
                                ->required(),

                        ])
                        ->columns(2),
                    Section::make('')->schema([
                        Forms\Components\Select::make('type')
                            ->label('Jenis Informasi')
                            ->options([
                                'train' => 'Pelatihan',
                                'internship' => 'Magang',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Apakah Ini Tampil Di Website?')
                            ->default(false),
                    ])->grow(false)
                ])
                    ->from('md')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->action(function (TrainAndInternship $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn(TrainAndInternship $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->action(function (TrainAndInternship $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn(TrainAndInternship $record): bool => $record->is_active),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTrainAndInternships::route('/'),
            'create' => Pages\CreateTrainAndInternship::route('/create'),
            'edit' => Pages\EditTrainAndInternship::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin();
    }
}
