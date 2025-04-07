<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventGuestDetail extends Model
{
    use HasFactory;

    protected $table = 'event_guest_details';

    protected $fillable = [
        'customer_order_id',
        'event_id',
        'first_name',
        'last_name',
        'email',
        'customer_id',
    ];

    public function customerOrder()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id');
    }
}
