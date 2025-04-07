<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'status',
        'description',
        'order_id',
        'order_type',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
