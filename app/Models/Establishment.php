<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'region_id', 'sub_region_id', 'address', 'contact_number', 'email', 'description', 'status'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function subRegion()
    {
        return $this->belongsTo(SubRegion::class);
    }
}