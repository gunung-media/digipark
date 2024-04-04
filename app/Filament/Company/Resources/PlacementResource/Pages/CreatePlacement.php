<?php

namespace App\Filament\Company\Resources\PlacementResource\Pages;

use App\Filament\Company\Resources\PlacementResource;
use App\Utils\FilamentUtil;
use Filament\Resources\Pages\CreateRecord;

class CreatePlacement extends CreateRecord
{
    protected static string $resource = PlacementResource::class;

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.placements.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Laporan Penempatan Baru!",
            body: "Laporan Penempatan Baru dari " . $user->name
        );
    }
}
