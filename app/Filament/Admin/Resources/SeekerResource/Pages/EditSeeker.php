<?php

namespace App\Filament\Admin\Resources\SeekerResource\Pages;

use App\Filament\Admin\Resources\SeekerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeeker extends EditRecord
{
    protected static string $resource = SeekerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
