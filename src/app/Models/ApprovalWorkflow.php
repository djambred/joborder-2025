<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ApprovalWorkflow extends Model
{
    protected $guarded = ['id'];
    public function steps(): HasMany
    {
        return $this->hasMany(ApprovalWorkflowStep::class)->orderBy('step');
    }
}
