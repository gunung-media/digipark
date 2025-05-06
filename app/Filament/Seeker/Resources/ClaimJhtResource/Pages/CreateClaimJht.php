<?php

namespace App\Filament\Seeker\Resources\ClaimJhtResource\Pages;

use App\Filament\Seeker\Pages\EditProfile;
use App\Filament\Seeker\Resources\ClaimJhtResource;
use App\Utils\FilamentUtil;
use App\Utils\Helper;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

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

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation(Helper::manipulateDataHasSignature($data));
    }

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.seeker.resources.claim-jhts.index', ['activeTab' => 'diterima', 'tableSearch' => $user->full_name]),
            title: "Ada Laporan Claim JHT Baru!",
            body: "Laporan Claim JHT Baru dari " . $user->full_name,
            sendEmail: true
        );
    }
}
