<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'event_order_details';

    protected $fillable = [
        'customer_order_id',
        'event_id',
        'category_id',
        'name',
        'price',
        'extension',
        'no_of_tickets',
        'start_date',
        'end_date',
        'booking_time',
        'duration',
        'full_name',
        'email',
        'contact_number',
        'street_address',
        'unit_suite',
        'city',
        'state',
        'country',
        'postal_code',
    ];

    public function customerOrder()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id');
    }
}
