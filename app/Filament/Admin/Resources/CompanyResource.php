<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompanyResource\Pages;
use App\Models\Company\Company;
use App\Utils\FilamentUtil;
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
                    Forms\Components\FileUpload::make('image')
                        ->label('Logo')
                        ->disk('public')
                        ->directory('company')
                        ->image()
                        ->columnSpan(2)
                        ->maxSize(10240)
                        ->required(),
                ])->columnSpanFull(),
                Forms\Components\Split::make([
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
                        Forms\Components\Select::make('company_type')
                            ->label('Jenis/ Bidang Usaha')
                            ->required()
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
                                ])->mapWithKeys(fn($val) => [$val => strlen($val) < 4 ? strtoupper($val) : ucfirst($val)])
                                    ->toArray()
                            ),
                    ])
                        ->columns(2)
                        ->columnSpanFull(),
                    // Password::make('password')
                    //     ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    //     ->dehydrated(fn ($state) => filled($state))
                    //     ->required(fn (string rcontext): bool => $context === 'create'),
                    //
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Acc?')
                            ->default(false),
                    ])->grow(false),
                ])->columnSpanFull(),
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
                Tables\Columns\TextColumn::make('password_raw')->label('Password')->default('-'),
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
                    ->action(function (Company $record) {
                        $record->is_active = true;
                        $record->save();
                    })
                    ->hidden(fn(Company $record): bool => $record?->is_active ?? false),
                Tables\Actions\Action::make('inactive')
                    ->label('Non Aktifkan')
                    ->action(function (Company $record) {
                        $record->is_active = false;
                        $record->save();
                    })
                    ->visible(fn(Company $record): bool => $record?->is_active ?? false),
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
            CompanyResource\RelationManagers\CompanyLaidOffsRelationManager::class,
            CompanyResource\RelationManagers\CompanyLegalizationRelationManager::class,
            CompanyResource\RelationManagers\JobsRelationManager::class,
            CompanyResource\RelationManagers\LaborDemandRelationManager::class,
            CompanyResource\RelationManagers\PlacementRelationManager::class,
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

    public static function canAccess(): bool
    {
        return FilamentUtil::isAdmin();
    }
}
