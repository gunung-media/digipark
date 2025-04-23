<?php

namespace App\Filament\Company\Resources\InstitutionalApprovalResource\Pages;

use App\Filament\Company\Resources\InstitutionalApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstitutionalApproval extends EditRecord
{
    protected static string $resource = InstitutionalApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
