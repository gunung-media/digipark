<?php

namespace App\Filament\Company\Resources\InstitutionalApprovalResource\Pages;

use App\Filament\Company\Resources\InstitutionalApprovalResource;
use App\Utils\FilamentUtil;
use Filament\Resources\Pages\CreateRecord;

class CreateInstitutionalApproval extends CreateRecord
{
    protected static string $resource = InstitutionalApprovalResource::class;

    protected function afterCreate(): void
    {
        $user = FilamentUtil::getUser();
        FilamentUtil::sendNotifToAdmin(
            url: route('filament.admin.company.resources.institutional-approvals.index', ['activeTab' => 'diterima', 'tableSearch' => $user->name]),
            title: "Ada Pengesahan Lembaga LKS BIPARTIT Baru!",
            body: "Pengesahan Lembaga LKS BIPARTIT baru telah ditambahkan oleh " . $user->name,
            sendEmail: true
        );
    }
}
