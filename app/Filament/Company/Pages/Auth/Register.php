<?php

namespace App\Filament\Company\Pages\Auth;

use App\Filament\Admin\Resources\CompanyResource;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegisterProfile;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegisterProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                TextInput::make('address')
                    ->label('Alamat')
                    ->required(),
                TextInput::make('phone_number')
                    ->label('No. Telp')
                    ->tel()
                    ->required(),
                TextInput::make('company_type')
                    ->label('Jenis/ Bidang Usaha'),
                Select::make('company_status')
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
                    )
                    ->searchable()
                    ->default(1),
                FileUpload::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->directory('company')
                    ->columnSpanFull()
                    ->required()
                    ->image()
                    ->imagePreviewHeight(500)
            ]);
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $user = $this->wrapInDatabaseTransaction(function () {
            $this->callHook('beforeValidate');

            $data = $this->form->getState();

            $this->callHook('afterValidate');

            $data = $this->mutateFormDataBeforeRegister($data);

            $this->callHook('beforeRegister');

            $user = $this->handleRegistration($data);

            $this->form->model($user)->saveRelationships();

            $this->callHook('afterRegister');

            return $user;
        });

        event(new Registered($user));

        $this->sendEmailVerificationNotification($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }

    protected function handleRegistration(array $data): Model
    {
        Notification::make()->title('Ada Komentar Baru')
            ->body('Ada Perusahaan yang butuh di-validasi, ' . $data['name'])
            ->info()
            ->actions([
                Action::make('View')
                    ->url(route('filament.admin.resources.companies.index', ['tableSearch', $data['name']]))
                    ->button()
                    ->markAsRead(),
            ])
            ->sendToDatabase(User::all());
        return $this->getUserModel()::create($data);
    }
}
