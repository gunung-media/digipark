<?php

namespace App\Filament\Admin\Clusters\Seeker\Resources;

use App\Filament\Admin\Clusters\Seeker;
use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\Pages;
use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\RelationManagers;
use App\Models\Seeker\ClaimJht;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClaimJhtResource extends Resource
{
    protected static ?string $model = ClaimJht::class;
    protected static ?string $label = 'Klaim JHT';
    protected static ?string $pluralModelLabel = 'Klaim JHT';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $cluster = Seeker::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('seeker.full_name')
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
