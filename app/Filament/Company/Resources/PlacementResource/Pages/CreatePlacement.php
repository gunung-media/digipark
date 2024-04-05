<?php

namespace App\Filament\Company\Resources\PlacementResource\Pages;

use App\Filament\Company\Resources\PlacementResource;
use App\Utils\FilamentUtil;
use App\Utils\Helper;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

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

    protected function handleRecordCreation(array $data): Model
    {
        return parent::handleRecordCreation(Helper::manipulateDataHasSignature($data));
    }
}
