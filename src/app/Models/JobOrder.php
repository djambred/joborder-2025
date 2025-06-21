<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOrder extends Model
{
    protected $guarded = ['id'];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'requester_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'recipient_id');
    }

    public function objectives(): BelongsToMany
    {
        return $this->belongsToMany(Objective::class, 'job_order_objectives');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(JobOrderApproval::class);
    }
}
