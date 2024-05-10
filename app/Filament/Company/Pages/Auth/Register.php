<?php

namespace App\Filament\Company\Pages\Auth;

use App\Filament\Admin\Resources\CompanyResource;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
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

    protected function handleRegistration(array $data): Model
    {
        Notification::make()->title('Ada Komentar Baru')
            ->body('Ada Perusahaan yang butuh di-validasi, ' . $data['name'])
            ->info()
            ->actions([
                Action::make('View')
                    ->url(CompanyResource::getUrl('index', ['tableSearch' => $data['name']]))
                    ->button()
                    ->markAsRead(),
            ])
            ->sendToDatabase(User::all());
        return $this->getUserModel()::create($data);
    }
}
