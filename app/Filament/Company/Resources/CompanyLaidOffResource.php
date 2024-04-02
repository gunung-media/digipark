<?php

namespace App\Filament\Company\Resources;

use App\Filament\Company\Resources\CompanyLaidOffResource\Pages;
use App\Filament\Company\Resources\CompanyLaidOffResource\RelationManagers;
use App\Models\Company\CompanyLaidOff;
use App\Utils\FilamentUtil;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CompanyLaidOffResource extends Resource
{
    protected static ?string $label = "Laporan PHK";

    protected static ?string $model = CompanyLaidOff::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Data')->description('Perusahaan')->schema([
                    Forms\Components\Placeholder::make('company.name')->content(function () {
                        return FilamentUtil::getUser()->name;
                    }),
                    Forms\Components\Placeholder::make('company.address')->content(function () {
                        return FilamentUtil::getUser()->address;
                    })
                ])->disabled(),
                Tabs::make()->tabs([
                    Tab::make('Penanggung Jawab')->schema([
                        Forms\Components\TextInput::make('responsible_name')
                            ->required(),
                        Forms\Components\TextInput::make('responsible_position')
                            ->required(),
                        SignaturePad::make('signature')
                            ->columnSpanFull()
                            ->downloadable(),
                    ])->columns(2),
                    Tab::make('Data')->schema([
                        Forms\Components\RichEditor::make('response_worker')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('position')
                            ->required(),
                        Forms\Components\TextInput::make('division')
                            ->required(),
                        Forms\Components\DatePicker::make('start_contract')
                            ->required(),
                        Forms\Components\DatePicker::make('end_contract')
                            ->required(),
                        Forms\Components\RichEditor::make('reason')
                            ->columnSpanFull()->required(),
                        Forms\Components\Hidden::make('company_id')->default(FilamentUtil::getUser()->id),
                    ])->columns(2),
                    Tab::make('Dokumen')->schema([
                        Forms\Components\FileUpload::make('doc_joint_agreement')
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_not_rejecting_layoff')
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('doc_layoff_notification')
                            ->disk('public')
                            ->directory('company/laid-off')
                            ->downloadable()
                            ->columnSpanFull(),
                    ])->columns(2)
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCompanyLaidOffs::route('/'),
            'create' => Pages\CreateCompanyLaidOff::route('/create'),
            'edit' => Pages\EditCompanyLaidOff::route('/{record}/edit'),
        ];
    }
}
