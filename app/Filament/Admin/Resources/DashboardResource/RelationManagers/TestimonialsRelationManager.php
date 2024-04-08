<?php

namespace App\Filament\Admin\Resources\DashboardResource\RelationManagers;

use App\Models\Admin\Settings\DashboardTestimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialsRelationManager extends RelationManager
{
    protected static string $relationship = 'testimonials';
    protected static ?string $label = "Testimoni";
    protected static ?string $title = "Testimoni";

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('job')
                    ->label('Pekerjaan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('testimonial')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->image()
                    ->directory('dashboard')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('job')->label('Pekerjaan'),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif di Web')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
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
                    ->action(function (DashboardTestimonial $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (DashboardTestimonial $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->label('Non Aktifkan')
                    ->action(function (DashboardTestimonial $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn (DashboardTestimonial $record): bool => $record->is_active),
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
