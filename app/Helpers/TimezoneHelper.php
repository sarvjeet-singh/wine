<?php

namespace App\Helpers;

use Carbon\Carbon;

use Illuminate\Support\Facades\Session;

class TimezoneHelper
{
    /**
     * Convert a local date/time to UTC.
     *
     * @param string $localDateTime
     * @param string $timezone
     * @return string
     */
    public static function toUTC($localDateTime, $timezone)
    {
        return Carbon::parse($localDateTime, $timezone)->utc()->toDateTimeString();
    }

    /**
     * Convert a UTC date/time to the user's local timezone.
     *
     * @param string $utcDateTime
     * @param string $timezone
     * @return string
     */
    public static function toLocal($utcDateTime, $timezone, $time = true)
    {
        if(!$time) {
            return Carbon::parse($utcDateTime, 'UTC')->setTimezone($timezone)->format('m/d/Y'); //->toDateTimeString();
        }
        return Carbon::parse($utcDateTime, 'UTC')->setTimezone($timezone)->format('m/d/Y h:i A'); //->toDateTimeString();
    }

    /**
     * Get the current user's timezone (mock function).
     *
     * @return string
     */
    public static function getUserTimezone()
    {
        return Session::get('timezone', 'UTC');
        // Replace with logic to fetch user's timezone from DB or request
        return config('app.timezone', 'UTC');
    }
}