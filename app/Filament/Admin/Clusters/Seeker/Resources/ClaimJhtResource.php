<?php

namespace App\Filament\Admin\Clusters\Seeker\Resources;

use App\Filament\Admin\Clusters\Seeker;
use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\Pages;
use App\Filament\Admin\Clusters\Seeker\Resources\ClaimJhtResource\Widgets\ClaimJhtStat;
use App\Models\Seeker\ClaimJht;
use App\Models\Seeker\TrackClaimJht;
use App\Utils\FilamentUtil;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class ClaimJhtResource extends Resource
{
    protected static ?string $model = ClaimJht::class;
    protected static ?string $label = 'Laporan Klaim JHT';
    protected static ?string $pluralModelLabel = 'Laporan Klaim JHT';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $cluster = Seeker::class;

    public static ?array $feedBackData = [];

    public static function form(Form $form): Form
    {
        TrackClaimJht::latest()->first();
        return $form
            ->schema([
                Section::make('Member')->schema([
                    Group::make()->relationship('seeker')->schema([
                        TextInput::make('full_name')->label('Nama Lengkap'),
                        TextInput::make('additional.identity_number')->label('NIK'),
                        TextInput::make('phone_number')->label('Telepon'),
                        TextInput::make('address')->label('Alamat'),
                        TextInput::make('gender')->label('Jenis Kelamin'),
                    ])->columns(2)
                ])->columnSpanFull()->disabled(),
                Split::make([
                    Section::make('Klaim JHT')->schema([
                        Radio::make('type')
                            ->options([
                                'pengunduran_diri' => 'Pengunduran Diri',
                                'pemutusan_hubungan_kerja' => 'Pemutusan Hubungan Kerja',
                            ]),
                        SignaturePad::make('signature')
                            ->columnSpanFull()
                            ->downloadable(),
                    ])->columns(2)->disabled(),
                    Section::make('Feedback')
                        ->headerActions([
                            Action::make('Kirim')
                                ->action(function (Section $component, EditRecord $livewire, $state) {
                                    $component->getChildComponentContainer()->validate();
                                    $record = $livewire->record;

                                    $data = [
                                        'message' => $state['message'],
                                        'status' => $state['status'],
                                    ];

                                    foreach ($state['file'] as $f) {
                                        if (!is_string($f))
                                            $data['file'] = $f->store('seeker/claim_jht', 'public');
                                        break;
                                    }

                                    $record->tracks()->create($data);

                                    Notification::make()
                                        ->title('Saved')
                                        ->success()
                                        ->send();

                                    FilamentUtil::sendNotifToSeeker(
                                        url: route('filament.seeker.resources.claim-jhts.index'),
                                        title: "Laporan Claim JHT {$state['status']} oleh Admin",
                                        body: "Laporan Claim JHT {$state['status']} oleh Admin",
                                        seekerId: $record->seeker_id
                                    );
                                }),
                        ])
                        ->schema([
                            ToggleButtons::make('status')
                                ->options([
                                    'diproses' => 'Diproses',
                                    'ditunda' => 'Ditunda',
                                    'ditolak' => 'Ditolak',
                                ])
                                ->inline()
                                ->required(),
                            Textarea::make('message')
                                ->label('Pesan')
                                ->required(),
                            FileUpload::make('file')
                                ->label('Dokumen Pendukung')
                                ->disk('public')
                                ->directory('seeker/claim_jht')
                                ->downloadable(),
                        ])->compact()->grow(false)
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('seeker.full_name')
                    ->label('Member')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => __($state === 'pengunduran_diri' ? 'Pengunduran Diri' : 'Pemutusan Hubungan Kerja')),
                TextColumn::make('created_at')->date(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'diterima' => 'gray',
                        'ditunda' => 'warning',
                        'diproses' => 'success',
                        'ditolak' => 'danger',
                    })
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'diterima' => 'Diterima',
                        'ditunda' => 'Ditunda',
                        'diproses' => 'Diproses',
                        'ditolak' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label("View")->icon('heroicon-o-eye'),
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

    public static function getWidgets(): array
    {
        return [
            ClaimJhtStat::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClaimJhts::route('/'),
            'create' => Pages\CreateClaimJht::route('/create'),
            'edit' => Pages\EditClaimJht::route('/{record}/edit'),
        ];
    }
}
