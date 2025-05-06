<?php

namespace App\Filament\Company\Resources\LaborUnionRegistrationResource\Pages;

use App\Filament\Company\Resources\LaborUnionRegistrationResource;
use App\Utils\FilamentUtil;
use App\Utils\Helper;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLaborUnionRegistration extends CreateRecord
{
    protected static string $resource = LaborUnionRegistrationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation(Helper::manipulateDataHasSignature($data));
    }

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.labor-union-registrations.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Pendaftaran Serikat Pekerja Baru!",
            body: "Pendaftaran serikat pekerja baru telah ditambahkan oleh " . $user->name,
            sendEmail: true
        );
    }
}
