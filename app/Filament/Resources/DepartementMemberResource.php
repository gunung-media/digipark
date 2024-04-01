<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartementMemberResource\Pages;
use App\Filament\Resources\DepartementMemberResource\RelationManagers;
use App\Models\DepartementMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepartementMemberResource extends Resource
{
    protected static ?string $model = DepartementMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('position')
                    ->required(),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->disk('public')
                    ->directory('departement-members')
                    ->image()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('facebook')
                    ->prefixIcon('icon-fb'),
                Forms\Components\TextInput::make('instagram')
                    ->prefixIcon('icon-ig'),
                Forms\Components\TextInput::make('twitter')
                    ->prefixIcon('icon-x'),
                Forms\Components\Select::make('is_active')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])->default(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->action(function (DepartementMember $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (DepartementMember $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->action(function (DepartementMember $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn (DepartementMember $record): bool => $record->is_active),
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
            'index' => Pages\ListDepartementMembers::route('/'),
            'create' => Pages\CreateDepartementMember::route('/create'),
            'edit' => Pages\EditDepartementMember::route('/{record}/edit'),
        ];
    }
}
