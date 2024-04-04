<?php

namespace App\Filament\Seeker\Resources\ClaimJhtResource\Pages;

use App\Filament\Seeker\Pages\EditProfile;
use App\Filament\Seeker\Resources\ClaimJhtResource;
use App\Utils\FilamentUtil;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateClaimJht extends CreateRecord
{
    protected static string $resource = ClaimJhtResource::class;

    public function mount(): void
    {
        if (is_null(FilamentUtil::getUser()->additional)) {
            Notification::make()
                ->warning()
                ->title('Pengaturan profil anda belum lengkap. Silahkan lengkapi profil anda terlebih dahulu.')
                ->send();
            $this->redirect(EditProfile::getUrl());
        }
        parent::mount();
    }
}
