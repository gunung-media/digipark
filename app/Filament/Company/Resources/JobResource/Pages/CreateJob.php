<?php

namespace App\Filament\Company\Resources\JobResource\Pages;

use App\Filament\Company\Resources\JobResource;
use App\Utils\FilamentUtil;
use App\Utils\Helper;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateJob extends CreateRecord
{
    protected static string $resource = JobResource::class;

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.jobs.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Laporan Lowongan Baru!",
            body: "Laporan Lowongan Baru dari " . $user->name,
            sendEmail: true
        );
    }

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation(Helper::manipulateDataHasSignature($data));
    }
}
