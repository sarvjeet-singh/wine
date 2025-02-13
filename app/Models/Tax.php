<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'stripe_tax_id',
        'percentage',
        'description',
        'active',
        'type'
    ];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_taxes');
    }
}
