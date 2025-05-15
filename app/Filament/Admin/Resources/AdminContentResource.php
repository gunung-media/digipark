<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AdminContentResource\Pages;
use App\Filament\Admin\Resources\AdminContentResource\RelationManagers;
use App\Models\AdminContent;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminContentResource extends Resource
{
    protected static ?string $label = "Admin Bidang";
    protected static ?string $pluralModelLabel = "Admin Bidang";
    protected static ?string $model = AdminContent::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Akun';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->unique('admin_contents', 'email', null, true)
                            ->required(),
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->rule(Password::default())
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->same('passwordConfirmation')
                            ->required(fn($operation) => $operation != 'edit')
                            ->disabledOn('edit'),
                        Forms\Components\TextInput::make('passwordConfirmation')
                            ->label('Konfirmasi Password')
                            ->password()
                            ->revealable(filament()->arePasswordsRevealable())
                            ->dehydrated(false)
                            ->required(fn($operation) => $operation != 'edit'),
                        Forms\Components\Select::make('role')
                            ->label('Role Admin Bidang')
                            ->options(
                                collect(['Binapenta', 'Sekretariat', 'Lattas', 'HI dan Jamsostek', 'BLK', 'Admin Loker'])->mapWithKeys(
                                    fn($val) => [$val => "Bidang $val"]
                                )->toArray()
                            )
                            ->required()
                            ->columnSpanFull(),

                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->prefix('Bidang ')
            ])
            ->filters([
                //
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
            'index' => Pages\ListAdminContents::route('/'),
            'create' => Pages\CreateAdminContent::route('/create'),
            'edit' => Pages\EditAdminContent::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin();
    }
}
