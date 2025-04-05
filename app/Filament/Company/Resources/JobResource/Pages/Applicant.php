<?php

namespace App\Filament\Company\Resources\JobResource\Pages;

use App\Filament\Company\Resources\JobResource;
use App\Models\Seeker\Seeker;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class Applicant extends ManageRelatedRecords
{
    protected static string $resource = JobResource::class;
    protected static string $relationship = 'applicants';
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public function getTitle(): string | Htmlable
    {
        $recordTitle = $this->getRecordTitle();

        $recordTitle = $recordTitle instanceof Htmlable ? $recordTitle->toHtml() : $recordTitle;

        return "List Pendaftar";
    }

    public function getBreadcrumb(): string
    {
        return 'Pendaftar';
    }

    public static function getNavigationLabel(): string
    {
        return 'List Pendaftar';
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('seeker')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No.')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('seeker.full_name')->label('Pendaftar')->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Mendaftar Pada')
                    ->sortable()
                    ->date(),
            ])
            ->filters([
                DateRangeFilter::make('created_at')->label('Mendaftar Pada'),
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('Terima')
                    ->form(function ($record) {
                        return [
                            // TextInput::make('full_name')
                            //     ->default($record->seeker->full_name ?? '')
                            //     ->readOnly(),
                            // TextInput::make('email')
                            //     ->default($record->seeker->email ?? '')
                            //     ->readOnly(),
                            // TextInput::make('phone_number')
                            //     ->default($record->seeker->phone_number ?? '')
                            //     ->readOnly(),
                            // TextInput::make('address')
                            //     ->default($record->seeker->address ?? '')
                            //     ->readOnly(),
                            // TextInput::make('gender')
                            //     ->default($record->seeker->gender ?? '')
                            //     ->readOnly(),
                            Textarea::make('message')
                                ->required()
                                ->autosize()
                        ];
                    })
                    ->action(function ($data, $record) {
                        if ($record->update([
                            'is_accepted' => true,
                            'company_message' => $data['message'],
                        ])) {
                            Seeker::find($record->seeker_id)->update(['company_id' => $record->job->company_id]);
                            Notification::make()
                                ->success()
                                ->title('Selamat anda telah diterima!')
                                ->body($data['message'])
                                ->sendToDatabase(Seeker::find($record->seeker_id));
                        }
                    })
                    ->requiresConfirmation()
                    ->modalWidth(MaxWidth::ExtraLarge)
                    ->hidden(fn($record) => $record->is_accepted)
            ])
            ->bulkActions([]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                TextEntry::make('seeker.full_name')
                    ->label("Nama Lengkap"),
                TextEntry::make('seeker.email')
                    ->label("Email"),
                TextEntry::make('seeker.phone_number')
                    ->label("Nomor Telp"),
                TextEntry::make('seeker.address')
                    ->label("Alamat"),
                TextEntry::make('seeker.gender')
                    ->label("Jenis Kelamin"),
            ]);
    }
}
