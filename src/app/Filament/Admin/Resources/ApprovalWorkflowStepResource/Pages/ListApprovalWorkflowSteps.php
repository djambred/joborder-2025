<?php

namespace App\Filament\Admin\Resources\ApprovalWorkflowStepResource\Pages;

use App\Filament\Admin\Resources\ApprovalWorkflowStepResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApprovalWorkflowSteps extends ListRecords
{
    protected static string $resource = ApprovalWorkflowStepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
