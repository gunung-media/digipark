<?php

namespace App\Filament\Seeker\Resources;

use App\Filament\Seeker\Resources\ClaimJhtResource\Pages;
use App\Models\Seeker\ClaimJht;
use App\Utils\FilamentUtil;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class ClaimJhtResource extends Resource
{
    protected static ?string $model = ClaimJht::class;
    protected static ?string $label = 'Klaim JHT';
    protected static ?string $pluralModelLabel = 'Klaim JHT';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Layanan';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('seeker_id', FilamentUtil::getUser()->id);
    }

    public static function form(Form $form): Form
    {
        $user = FilamentUtil::getUser();
        return $form
            ->schema([
                Section::make('Data Diri')->schema([
                    Placeholder::make('Nama Lengkap')->content(fn() => $user->full_name),
                    Placeholder::make('NIK')->label('NIK')->content(fn() => $user->additional->identity_number),
                    Placeholder::make('Nomor Telpon')->content(fn() => $user->phone_number),
                    Placeholder::make('Alamat')->content(fn() => $user->phone_number),
                    Placeholder::make('Jenis Kelamin')->content(fn() => $user->gender === 'male' ? 'Laki-laki' : 'Perempuan'),
                ])->columns(2),
                Section::make('Klaim JHT')->schema([
                    Radio::make('type')
                        ->options([
                            'pengunduran_diri' => 'Pengunduran Diri',
                            'pemutusan_hubungan_kerja' => 'Pemutusan Hubungan Kerja',
                        ]),
                    SignaturePad::make('signature')
                        ->columnSpanFull()
                        ->downloadable(),
                    Hidden::make('seeker_id')->default($user->id),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Jenis Klaim')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pengunduran_diri' => 'gray',
                        'pemutusan_hubungan_kerja' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => __($state === 'pengunduran_diri' ? 'Pengunduran Diri' : 'Pemutusan Hubungan Kerja')),
                TextColumn::make('created_at')
                    ->label('Dibuat pada')
                    ->date(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
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

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditClaimJht::class,
            Pages\TrackClaimJht::class,
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
            'index' => Pages\ListClaimJhts::route('/'),
            'create' => Pages\CreateClaimJht::route('/create'),
            'edit' => Pages\EditClaimJht::route('/{record}/edit'),
            'tracks' => Pages\TrackClaimJht::route('/{record}/track'),
        ];
    }
}
