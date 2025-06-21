<?php

namespace App\Filament\Admin\Resources\ApprovalWorkflowResource\Pages;

use App\Filament\Admin\Resources\ApprovalWorkflowResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApprovalWorkflow extends EditRecord
{
    protected static string $resource = ApprovalWorkflowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
