<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Objective extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function jobOrders(): BelongsToMany
    {
        return $this->belongsToMany(JobOrder::class, 'job_order_objectives');
    }
}
