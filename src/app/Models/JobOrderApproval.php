<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOrderApproval extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['approved_at' => 'datetime'];

    public function jobOrder(): BelongsTo
    {
        return $this->belongsTo(JobOrder::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }

    public function workflowStep(): BelongsTo
    {
        return $this->belongsTo(ApprovalWorkflowStep::class, 'approval_workflow_step_id');
    }

    public function approve(Employee $employee): void
    {
        $this->update([
            'employee_id' => $employee->id,
            'status' => 'approved',
            'approved_at' => now(),
        ]);
    }

    public function reject(Employee $employee): void
    {
        $this->update([
            'employee_id' => $employee->id,
            'status' => 'rejected',
            'approved_at' => now(),
        ]);
    }

        public function canBeApprovedBy(User $user): bool
        {
            // Optional: Add is_admin check
            if (method_exists($user, 'super_admin') && $user->isAdmin()) {
                return true;
            }

            return $this->status === 'pending'
                && $user->employee
                && $this->approvalWorkflowStep
                && $user->employee->position_id === $this->approvalWorkflowStep->position_id;
        }


}
