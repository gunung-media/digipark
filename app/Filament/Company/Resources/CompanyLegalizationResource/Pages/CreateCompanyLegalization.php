<?php

namespace App\Filament\Company\Resources\CompanyLegalizationResource\Pages;

use App\Filament\Company\Resources\CompanyLegalizationResource;
use App\Utils\FilamentUtil;
use Filament\Resources\Pages\CreateRecord;

class CreateCompanyLegalization extends CreateRecord
{
    protected static string $resource = CompanyLegalizationResource::class;

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.company-legalizations.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Laporan Pengesahan Baru!",
            body: "Laporan Pengesahan Baru dari " . $user->name
        );
    }
}
