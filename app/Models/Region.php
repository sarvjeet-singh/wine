<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'description', 'status'];

    public function subRegions()
    {
        return $this->hasMany(SubRegion::class);
    }
}
