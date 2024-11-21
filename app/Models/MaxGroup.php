<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaxGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name']; // Mass assignable attributes
}
