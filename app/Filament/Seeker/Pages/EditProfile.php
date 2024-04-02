<?php

namespace App\Filament\Seeker\Pages;

use App\Utils\FilamentUtil;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;

class EditProfile extends Page
{
    protected static string $view = 'filament.seeker.pages.edit-profile';
    protected static bool $shouldRegisterNavigation = false;

    public ?array $profileData = [];
    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
        ];
    }

    public function editProfileForm(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make()
                    ->tabs([
                        Tab::make('Profile Information')
                            ->schema([
                                TextInput::make('full_name')
                                    ->label('Nama Lengkap')
                                    ->required(),
                                TextInput::make('additional.identity_number')
                                    ->label('NIK')
                                    ->required(),
                                TextInput::make('phone_number')
                                    ->label('No. Telpon')
                                    ->required(),
                                Select::make('gender')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'male' => 'Male',
                                        'female' => 'Female',
                                    ])
                                    ->required(),
                                TextInput::make('additional.birth_place')
                                    ->label('Tempat Lahir')
                                    ->required(),
                                DatePicker::make('date_of_birth')
                                    ->label('Tanggal Lahir')
                                    ->required(),
                                TextInput::make('address')
                                    ->label('Alamat')
                                    ->required(),
                                TextInput::make('additional.postal_code')
                                    ->label('Kode Pos')
                                    ->required(),
                                TextInput::make('additional.rt')
                                    ->label('RT')
                                    ->required(),
                                TextInput::make('additional.rw')
                                    ->label('RW')
                                    ->required(),
                            ])
                            ->columns(2),
                        Tab::make('Additional Data')
                            ->schema([
                                FileUpload::make('additional.doc_ktp')
                                    ->label('KTP')
                                    ->disk('public')
                                    ->directory('seeker/additional')
                                    ->downloadable()
                                    ->columnSpanFull(),
                                FileUpload::make('additional.doc_bpjs_card')
                                    ->label('BPJS Card')
                                    ->disk('public')
                                    ->directory('seeker/additional')
                                    ->downloadable()
                                    ->columnSpanFull(),
                                FileUpload::make('additional.doc_cv')
                                    ->label('Surat Pengalaman Kerja / CV / Resume')
                                    ->disk('public')
                                    ->directory('seeker/additional')
                                    ->downloadable()
                                    ->columnSpanFull(),
                                SignaturePad::make('additional.signature')
                                    ->label('Tanda Tangan')
                                    ->columnSpanFull()
                                    ->downloadable(),
                            ])
                            ->columns(2),
                    ])
            ])
            ->model(FilamentUtil::getUser())
            ->statePath('profileData');
    }

    public function editPasswordForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Update Password')
                    ->aside()
                    ->description('Ensure your account is using long, random password to stay secure.')
                    ->schema([
                        TextInput::make('Current password')
                            ->password()
                            ->required()
                            ->currentPassword(),
                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation'),
                        TextInput::make('passwordConfirmation')
                            ->password()
                            ->required()
                            ->dehydrated(false),
                    ]),
            ])
            ->model(FilamentUtil::getUser())
            ->statePath('passwordData');
    }

    protected function fillForms(): void
    {
        $data = FilamentUtil::getUser()->toArray();
        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editProfileForm'),
        ];
    }

    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                ->submit('editPasswordForm'),
        ];
    }

    public function updateProfile(): void
    {
        $data = $this->editProfileForm->getState();
        $this->handleRecordUpdate(FilamentUtil::getUser(), $data);
        $this->sendSuccessNotification();
    }

    public function updatePassword(): void
    {
        $data = $this->editPasswordForm->getState();
        $this->handleRecordUpdate(FilamentUtil::getUser(), $data);
        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['password']]);
        }
        $this->editPasswordForm->fill();
        $this->sendSuccessNotification();
    }

    private function handleRecordUpdate(Model $record, array $data): Model
    {
        if ($data['additional']) {
            $record->additional()->updateOrCreate(['id' => $record->additional->id ?? null], $data['additional']);
            unset($data['additional']);
        }
        $record->update($data);
        return $record;
    }

    private function sendSuccessNotification(): void
    {
        Notification::make()
            ->success()
            ->title(__('filament-panels::pages/auth/edit-profile.notifications.saved.title'))
            ->send();
    }
}
