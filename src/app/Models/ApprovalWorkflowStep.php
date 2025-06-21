<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalWorkflowStep extends Model
{
    protected $guarded = ['id'];
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
