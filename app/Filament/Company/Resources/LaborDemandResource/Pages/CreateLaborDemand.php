<?php

namespace App\Filament\Company\Resources\LaborDemandResource\Pages;

use App\Filament\Company\Resources\LaborDemandResource;
use App\Utils\FilamentUtil;
use App\Utils\Helper;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLaborDemand extends CreateRecord
{
    protected static string $resource = LaborDemandResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation(Helper::manipulateDataHasSignature($data));
    }

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.labor-demands.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Laporan Permintaan Tenaga Kerja Baru!",
            body: "Laporan Permintaan Tenaga Kerja Baru dari " . $user->name,
            sendEmail: true
        );
    }
}
