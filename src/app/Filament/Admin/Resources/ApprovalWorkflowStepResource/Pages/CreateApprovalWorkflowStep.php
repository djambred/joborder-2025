<?php

namespace App\Filament\Admin\Resources\ApprovalWorkflowStepResource\Pages;

use App\Filament\Admin\Resources\ApprovalWorkflowStepResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateApprovalWorkflowStep extends CreateRecord
{
    protected static string $resource = ApprovalWorkflowStepResource::class;
}
