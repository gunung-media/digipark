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
    protected static ?string $label = "Keanggotaan";
    protected static ?string $pluralModelLabel = "Keanggotaan";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nama')
                                ->required(),
                            Forms\Components\TextInput::make('position')
                                ->label('Jabatan')
                                ->required(),
                            Forms\Components\RichEditor::make('description')
                                ->label('Deskripsi')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                    Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make('facebook')
                                ->prefixIcon('icon-fb'),
                            Forms\Components\TextInput::make('instagram')
                                ->prefixIcon('icon-ig'),
                            Forms\Components\TextInput::make('twitter')
                                ->prefixIcon('icon-x'),
                            Forms\Components\Toggle::make('is_active')
                                ->label('Apakah Ini Tampil Di Website?')
                                ->default(false),
                        ])->grow(false)
                ])
                    ->from('md')
                    ->columnSpanFull(),
                Forms\Components\Section::make()->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar')
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
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif di Web')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('active')
                    ->label('Aktifkan')
                    ->action(function (DepartementMember $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn (DepartementMember $record): bool => $record->is_active),
                Tables\Actions\Action::make('inactive')
                    ->label('Non Aktifkan')
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
