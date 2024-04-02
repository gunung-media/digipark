<?php

namespace App\Filament\Company\Pages;

use App\Utils\FilamentUtil;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.company.pages.edit-profile';
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
                Tabs::make()->tabs([
                    Tab::make('Profile Information')
                        ->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->unique(ignoreRecord: true),
                            TextInput::make('address')
                                ->required(),
                            TextInput::make('phone_number')
                                ->tel()
                                ->required(),
                            TextInput::make('company_type'),
                            Select::make('company_status')
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
                                ->disk('public')
                                ->directory('company')
                                ->columnSpanFull()
                                ->required()
                                ->image()
                                ->imagePreviewHeight(500)
                        ])->columns(2),
                    Tab::make('Pengesahan')
                        ->schema([
                            Wizard::make()->steps([
                                Step::make('Input')->schema([
                                    TextInput::make('legalization.business_license_decision_letter')
                                        ->required(),
                                    TextInput::make('legalization.labor_union_names')
                                        ->required(),
                                    TextInput::make('legalization.bpjs_membership_number')
                                        ->required()
                                        ->columnSpanFull(),
                                    TextInput::make('legalization.headquarters_male_employee_count')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.headquarters_female_employee_count')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.branch_male_employee_count')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.branch_female_employee_count')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.outsourced_male_employee_count')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.outsourced_female_employee_count')
                                        ->numeric()
                                        ->required(),
                                    Radio::make('legalization.company_regulation_concept')
                                        ->options([
                                            'Baru' => 'Baru',
                                            'Pembaruan' => 'Pembaruan',
                                        ])
                                        ->inline()
                                        ->required(),
                                    DatePicker::make('legalization.company_regulation_effective_date')
                                        ->required(),
                                    TextInput::make('legalization.minimum_monthly_wage')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.maximum_monthly_wage')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.minimum_daily_wage')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.maximum_daily_wage')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.fixed_term_employment_system')
                                        ->numeric()
                                        ->required(),
                                    TextInput::make('legalization.permanent_employment_system')
                                        ->numeric()
                                        ->required(),
                                ]),
                                Step::make('Dokument')->schema([
                                    FileUpload::make('legalization.doc_pp')
                                        ->disk('public')
                                        ->directory('company/legalization')
                                        ->downloadable()
                                        ->columnSpanFull(),
                                    FileUpload::make('legalization.doc_evidence_union_consultation_request')
                                        ->disk('public')
                                        ->directory('company/legalization')
                                        ->downloadable()
                                        ->columnSpanFull(),
                                    FileUpload::make('legalization.doc_union_consultation_statement')
                                        ->disk('public')
                                        ->directory('company/legalization')
                                        ->downloadable()
                                        ->columnSpanFull(),
                                    FileUpload::make('legalization.doc_no_union_declaration')
                                        ->disk('public')
                                        ->directory('company/legalization')
                                        ->downloadable()
                                        ->columnSpanFull(),
                                    FileUpload::make('legalization.doc_wage_structure_and_scale')
                                        ->disk('public')
                                        ->directory('company/legalization')
                                        ->downloadable()
                                        ->columnSpanFull(),
                                    FileUpload::make('legalization.doc_bpjs_membership_and_payment_copy')
                                        ->disk('public')
                                        ->directory('company/legalization')
                                        ->downloadable()
                                        ->columnSpanFull(),
                                ])
                            ])
                                ->skippable()
                                ->columns(2),
                        ])
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
        if ($data['legalization']) {
            $record->legalization()->updateOrCreate(['id' => $record->legalization->id ?? null], $data['legalization']);
            unset($data['legalization']);
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
