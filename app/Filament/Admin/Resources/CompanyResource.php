<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompanyResource\Pages;
use App\Models\Company\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $label = "Perusahaan";
    protected static ?string $pluralModelLabel = "Perusahaan";
    protected static ?string $model = Company::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationGroup = 'Akun';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Perusahaan')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->unique('companies', 'email', null, true)
                        ->required(),
                    Forms\Components\TextInput::make('phone_number')
                        ->label('No. Telp')
                        ->tel()
                        ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                        ->required(),
                    Forms\Components\TextInput::make('address')
                        ->label('Alamat')
                        ->required(),
                    Forms\Components\TextInput::make('company_type')
                        ->label('Jenis/ Bidang Usaha'),
                    Forms\Components\Select::make('company_status')
                        ->label('Status Perusahaan')
                        ->options(
                            collect([
                                'pt',
                                'cv',
                                'perorangan',
                                'badan usaha negara',
                                'parsero',
                                'pma',
                                'perusahaan',
                                'joint venture',
                                'pmdn'
                            ])->mapWithKeys(fn ($val) => [$val => strlen($val) < 4 ? strtoupper($val) : ucfirst($val)])
                                ->toArray()
                        ),
                ])->columns(2),
                // Password::make('password')
                //     ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                //     ->dehydrated(fn ($state) => filled($state))
                //     ->required(fn (string rcontext): bool => $context === 'create'),
                Forms\Components\Section::make()->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Logo')
                        ->disk('public')
                        ->directory('company')
                        ->image()
                        ->columnSpan(2)
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Nama Perusahaan")
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label("Alamat")
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label("Logo")
                    ->disk('public')
                    ->square(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label("No. Telp")
                    ->searchable(),
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
            // RelationManagers\JobsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
