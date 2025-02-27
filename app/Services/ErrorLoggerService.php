<?php

namespace App\Services;

use App\Models\ErrorLog;
use Illuminate\Support\Facades\Log;

class ErrorLoggerService
{
    public static function log(string $level, string $message, ?array $context = null, ?string $file = null, ?int $line = null)
    {
        // Store in the database
        ErrorLog::create([
            'level' => $level,
            'message' => $message,
            'file' => $file,
            'line' => $line,
            'context' => $context ? json_encode($context) : null,
        ]);

        // Log to storage/logs/laravel.log
        Log::channel('daily')->$level($message, $context ?? []);
    }
}
