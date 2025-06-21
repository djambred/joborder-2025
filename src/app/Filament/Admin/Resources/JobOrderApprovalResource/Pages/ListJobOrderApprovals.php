<?php

namespace App\Filament\Admin\Resources\JobOrderApprovalResource\Pages;

use App\Filament\Admin\Resources\JobOrderApprovalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobOrderApprovals extends ListRecords
{
    protected static string $resource = JobOrderApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
