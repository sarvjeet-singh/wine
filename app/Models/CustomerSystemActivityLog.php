<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSystemActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'event_type', 'message', 'data'];

    protected $casts = ['data' => 'array'];
}
