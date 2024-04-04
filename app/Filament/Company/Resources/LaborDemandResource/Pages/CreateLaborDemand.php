<?php

namespace App\Filament\Company\Resources\LaborDemandResource\Pages;

use App\Filament\Company\Resources\LaborDemandResource;
use App\Utils\FilamentUtil;
use Filament\Resources\Pages\CreateRecord;

class CreateLaborDemand extends CreateRecord
{
    protected static string $resource = LaborDemandResource::class;

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.labor-demands.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Laporan Permintaan Tenaga Kerja Baru!",
            body: "Laporan Permintaan Tenaga Kerja Baru dari " . $user->name
        );
    }
}
