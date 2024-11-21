<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['faq_section_id', 'question', 'answer', 'status'];

    public function section()
    {
        return $this->belongsTo(FaqSection::class, 'faq_section_id');
    }
}
