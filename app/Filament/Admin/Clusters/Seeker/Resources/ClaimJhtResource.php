<?php

namespace App\Filament\Admin\Clusters\Seeker\Resources;

use App\Filament\Admin\Clusters\Seeker;
use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\Pages;
use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\Widgets\ClaimJhtStat;
use App\Models\Seeker\ClaimJht;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class ClaimJhtResource extends Resource
{
    protected static ?string $model = ClaimJht::class;
    protected static ?string $label = 'Laporan Klaim JHT';
    protected static ?string $pluralModelLabel = 'Laporan Klaim JHT';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $cluster = Seeker::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make('Member')->schema([
                        Group::make()->relationship('seeker')->schema([
                            TextInput::make('full_name'),
                            TextInput::make('identity_number'),
                            TextInput::make('phone_number'),
                            TextInput::make('address'),
                            TextInput::make('gender'),
                        ])->columns(2)
                    ])->columnSpanFull()->disabled(),
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
                                })
                                ->required()
                        ])->compact()
                        ->grow(false),
                ])->columnSpanFull(),
                Section::make('Klaim JHT')->schema([
                    Radio::make('type')
                        ->options([
                            'pengunduran_diri' => 'Pengunduran Diri',
                            'pemutusan_hubungan_kerja' => 'Pemutusan Hubungan Kerja',
                        ]),
                    SignaturePad::make('signature')
                        ->columnSpanFull()
                        ->downloadable(),
                ])->columns(2)->disabled()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('seeker.full_name')
                    ->label('Member')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __($state === 'pengunduran_diri' ? 'Pengunduran Diri' : 'Pemutusan Hubungan Kerja')),
                TextColumn::make('created_at')->date(),
                TextColumn::make('status')
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
            ClaimJhtStat::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClaimJhts::route('/'),
            'create' => Pages\CreateClaimJht::route('/create'),
            'edit' => Pages\EditClaimJht::route('/{record}/edit'),
        ];
    }
}
