<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurativeExperienceMedia extends Model
{
    use HasFactory;

    protected $fillable = ['experience_id', 'file_path'];

    public function experience()
    {
        return $this->belongsTo(CurativeExperience::class);
    }
}
