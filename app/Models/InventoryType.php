<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryType extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'description', 'status'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}