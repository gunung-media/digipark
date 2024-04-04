<?php

namespace App\Filament\Company\Resources\CompanyLaidOffResource\Pages;

use App\Filament\Company\Resources\CompanyLaidOffResource;
use App\Utils\FilamentUtil;
use Filament\Resources\Pages\CreateRecord;

class CreateCompanyLaidOff extends CreateRecord
{
    protected static string $resource = CompanyLaidOffResource::class;

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.company-laid-offs.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Laporan PHK Baru!",
            body: "Laporan PHK Baru dari " . $user->name
        );
    }
}
