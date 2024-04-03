<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DepartementMemberResource\Pages;
use App\Models\Admin\DepartementMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DepartementMemberResource extends Resource
{
    protected static ?string $model = DepartementMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required(),
                            Forms\Components\TextInput::make('position')
                                ->required(),
                            Forms\Components\RichEditor::make('description')
                                ->columnSpanFull(),
                            Forms\Components\TextInput::make('facebook')
                                ->prefixIcon('icon-fb'),
                            Forms\Components\TextInput::make('instagram')
                                ->prefixIcon('icon-ig'),
                            Forms\Components\TextInput::make('twitter')
                                ->prefixIcon('icon-x'),
                        ])
                        ->columns(2),
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\Toggle::make('is_active')
                                ->label('Apakah Ini Tampil Di Website?')
                                ->default(false)
                        ])->grow(false)
                ])->columnSpanFull(),
                Forms\Components\Section::make()->schema([
                    Forms\Components\FileUpload::make('image')
                        ->disk('public')
                        ->directory('departement-members')
                        ->image()
                        ->columnSpanFull(),
                ])
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
