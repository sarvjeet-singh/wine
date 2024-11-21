<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqSection extends Model
{
    use HasFactory;
    protected $fillable = ['account_type', 'section_name', 'status'];

    public function questions()
    {
        return $this->hasMany(FaqQuestion::class, 'faq_section_id');
    }

    protected static function boot()
    {
        parent::boot();

        // Before deleting the section, delete all related questions
        static::deleting(function ($section) {
            $section->questions()->delete(); // Delete related questions
        });
    }
}
