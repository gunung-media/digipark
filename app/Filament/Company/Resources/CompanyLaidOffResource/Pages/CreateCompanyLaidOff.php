<?php

namespace App\Filament\Company\Resources\CompanyLaidOffResource\Pages;

use App\Filament\Company\Resources\CompanyLaidOffResource;
use App\Utils\FilamentUtil;
use App\Utils\Helper;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateCompanyLaidOff extends CreateRecord
{
    protected static string $resource = CompanyLaidOffResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation(Helper::manipulateDataHasSignature($data));
    }

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.company-laid-offs.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Laporan PHK Baru!",
            body: "Laporan PHK Baru dari " . $user->name,
            sendEmail: true
        );
    }
}
