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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class ClaimJhtResource extends Resource
{
    protected static ?string $model = ClaimJht::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $user = FilamentUtil::getUser();
        return $form
            ->schema([
                Section::make('Member')->schema([
                    Placeholder::make('full_name')->content(fn () => $user->full_name),
                    Placeholder::make('identity_number')->content(fn () => $user->additional->identity_number),
                    Placeholder::make('phone_number')->content(fn () => $user->phone_number),
                    Placeholder::make('Address')->content(fn () => $user->phone_number),
                    Placeholder::make('gender')->content(fn () => $user->gender),
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
            'index' => Pages\ListClaimJhts::route('/'),
            'create' => Pages\CreateClaimJht::route('/create'),
            'edit' => Pages\EditClaimJht::route('/{record}/edit'),
        ];
    }
}
