<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'slug'];

    // Automatically serialize/deserialize description
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = json_encode($value);
    }

    public function getDescriptionAttribute($value)
    {
        return json_decode($value, true); // true returns array, false returns object
    }
}
