<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stripe_plan_id',
        'price',
        'interval',
        'interval_count',
        'description',
        'currency',
        'status',
        'features',
        'type',
        'sort_order',
    ];

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'plan_taxes');
    }
}
