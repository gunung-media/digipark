<?php

namespace App\Filament\Company\Resources\InstitutionalApprovalResource\Pages;

use App\Filament\Company\Resources\InstitutionalApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInstitutionalApprovals extends ListRecords
{
    protected static string $resource = InstitutionalApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
