<?php

namespace App\Filament\Admin\Resources\DashboardResource\RelationManagers;

use App\Models\Admin\Settings\DashboardVision;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VisionsRelationManager extends RelationManager
{
    protected static string $relationship = 'visions';
    protected static ?string $label = "Visi";
    protected static ?string $title = "Visi";

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->directory('dashboard_visions')
                    ->image()
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif di Web')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Aktif di Web')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->label('Aktifkan')
                    ->action(function (DashboardVision $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (DashboardVision $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->label('Non Aktifkan')
                    ->action(function (DashboardVision $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn (DashboardVision $record): bool => $record->is_active),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
