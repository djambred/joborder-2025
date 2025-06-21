<?php

namespace App\Filament\Admin\Resources\JobOrderApprovalResource\Pages;

use App\Filament\Admin\Resources\JobOrderApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobOrderApproval extends EditRecord
{
    protected static string $resource = JobOrderApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
