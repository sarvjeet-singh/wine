<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'slug', 'category_id', 'inventory_type_id', 'description', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function inventoryType()
    {
        return $this->belongsTo(InventoryType::class);
    }
}