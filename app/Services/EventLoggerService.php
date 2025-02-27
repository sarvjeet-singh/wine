<?php

namespace App\Services;

use App\Models\CustomerSystemActivityLog;

class EventLoggerService
{
    public static function log(?int $customerId, string $eventType, string $message, ?array $data = null)
    {
        CustomerSystemActivityLog::create([
            'customer_id' => $customerId,
            'event_type' => $eventType,
            'message' => $message,
            'data' => $data ? json_encode($data) : null,
        ]);
    }
}
