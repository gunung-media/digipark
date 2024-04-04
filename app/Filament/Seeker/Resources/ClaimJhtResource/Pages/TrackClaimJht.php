<?php

namespace App\Filament\Seeker\Resources\ClaimJhtResource\Pages;

use App\Filament\Seeker\Resources\ClaimJhtResource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;

class TrackClaimJht extends ManageRelatedRecords
{
    protected static string $resource = ClaimJhtResource::class;
    protected static string $relationship = 'tracks';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Tracks';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('message')
                    ->label("Pesan"),
                FileUpload::make('file')
                    ->label('Dokumen Pendukung')
                    ->disk('public')
                    ->directory('seeker/claim_jht')
                    ->downloadable()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->columns([
                Tables\Columns\TextColumn::make('index')->rowIndex()->sortable(),
                Tables\Columns\TextColumn::make('message')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->date(),
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
                //
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }
}
