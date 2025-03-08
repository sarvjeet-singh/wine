<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishSeason extends Model
{
    use HasFactory;

    protected $table = 'publish_seasons';

    protected $fillable = [
        'vendor_id',
        'season_type',
        'publish',
    ];
}
