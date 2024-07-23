<?php

namespace App\Filament\Admin\Pages;

use App\Utils\FilamentUtil;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Filament\Pages\Page;

class EditProfile extends Page
{
    protected static string $view = 'filament.admin.pages.edit-profile';
    protected static ?string $navigationIcon = 'heroicon-o-user';

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
                Section::make('Update Profile')
                    ->aside()
                    ->description('Pastikan semua data yang dimasukkan benar.')
                    ->compact()
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->readOnly()
                            ->columnSpanFull(),
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),
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
                    ->description('Pastikan password yang dimasukkan benar dan sesuai dengan konfirmasi password yang dimasukkan.')
                    ->schema([
                        TextInput::make('Current password')
                            ->label('Password Saat Ini')
                            ->password()
                            ->required()
                            ->dehydrated(false)
                            ->currentPassword(),
                        TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->required()
                            ->rule(Password::default())
                            ->autocomplete('new-password')
                            ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                            ->live(debounce: 500)
                            ->same('passwordConfirmation'),
                        TextInput::make('passwordConfirmation')
                            ->label('Konfirmasi Password Baru')
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
        if (array_key_exists('Current password', $data)) {
            unset($data['Current password']);
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
