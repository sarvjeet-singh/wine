<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CurativeExperienceGenre extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'status', 'image', 'position'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($genre) {
            $genre->slug = Str::slug($genre->name);
        });
    }

    public function curativeExperiences()
    {
        return $this->hasMany(CurativeExperience::class, 'genre_id'); // Adjust foreign key if needed
    }
}
