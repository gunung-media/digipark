<?php

namespace App\Filament\Seeker\Pages\Auth;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegisterProfile;

class Register extends BaseRegisterProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('full_name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                TextInput::make('phone_number')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->label('Alamat')
                    ->required()
                    ->maxLength(255),
                Select::make('gender')
                    ->options([
                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',
                    ])
                    ->required(),
                DatePicker::make('date_of_birth')
                    ->label('Tangal Lahir')
                    ->required()
            ]);
    }
}
