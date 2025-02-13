<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DateCheckerService
{
    private array $checkInOnly = [];
    private array $checkOutOnly = [];
    private array $bookedAndBlockedDates = [];
    private Carbon $currentDate;

    public function __construct()
    {
        $this->currentDate = Carbon::today();
    }

    public function processVendorDates(int $vendorId, int $inventoryType = 2): self
    {
        // Process regular bookings
        $booked = DB::table('booking_dates')
            ->where('vendor_id', $vendorId)
            ->where('booking_type', '!=', 'packaged')
            ->select('start_date', 'end_date')
            ->get();

        // Process packaged bookings
        $packagedBookings = DB::table('booking_dates')
            ->where('vendor_id', $vendorId)
            ->where('booking_type', 'packaged')
            ->select('start_date', 'end_date')
            ->get();

        // Process orders
        $orders = Order::where('vendor_id', $vendorId)
            ->where(function ($query) {
                $query->where('check_in_at', '>=', $this->currentDate)
                    ->orWhere('check_out_at', '>=', $this->currentDate);
            })
            ->get();

        // Process all date types
        $this->processBookings($booked)
            ->processOrders($orders);

        return $this;
    }

    private function processBookings(Collection $bookings): self
    {
        foreach ($bookings as $booking) {
            $startDate = Carbon::parse($booking->start_date);
            $endDate = Carbon::parse($booking->end_date);

            // Add check-in and check-out dates
            $this->checkOutOnly[] = $startDate->format('Y-m-d');
            $this->checkInOnly[] = $endDate->format('Y-m-d');

            // Only block dates between check-in and check-out (exclusive)
            $currentDate = $startDate->copy()->addDay();
            while ($currentDate->lt($endDate)) {
                $dateStr = $currentDate->format('Y-m-d');
                // Only add to blocked dates if it's not a check-in or check-out date
                if (
                    !in_array($dateStr, $this->checkInOnly) &&
                    !in_array($dateStr, $this->checkOutOnly)
                ) {
                    $this->bookedAndBlockedDates[] = $dateStr;
                }
                $currentDate->addDay();
            }
        }

        return $this;
    }

    private function processOrders(Collection $orders): self
    {
        foreach ($orders as $order) {
            $checkin = Carbon::parse($order->check_in_at);
            $checkout = Carbon::parse($order->check_out_at);

            if ($checkin->lt($this->currentDate)) {
                $checkin = $this->currentDate;
            }

            // Add check-in and check-out dates
            $this->checkOutOnly[] = $checkin->format('Y-m-d');
            $this->checkInOnly[] = $checkout->format('Y-m-d');

            // Block dates between check-in and check-out (exclusive)
            $currentDate = $checkin->copy()->addDay();
            while ($currentDate->lt($checkout)) {
                $dateStr = $currentDate->format('Y-m-d');
                if (
                    !in_array($dateStr, $this->checkInOnly) &&
                    !in_array($dateStr, $this->checkOutOnly)
                ) {
                    $this->bookedAndBlockedDates[] = $dateStr;
                }
                $currentDate->addDay();
            }
        }

        return $this;
    }

    public function isDateAvailable(string $date): bool
    {
        return !in_array($date, $this->bookedAndBlockedDates);
    }

    public function isCheckInAllowed(string $date): bool
    {
        // Can check in if the date is not blocked and not a check-out only date
        return !in_array($date, $this->bookedAndBlockedDates) &&
            !in_array($date, $this->checkOutOnly);
    }

    public function isCheckOutAllowed(string $date): bool
    {
        // Can check out if the date is not blocked and not a check-in only date
        return !in_array($date, $this->bookedAndBlockedDates) &&
            !in_array($date, $this->checkInOnly);
    }

    public function validateDateRange(string $startDate, string $endDate): bool
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Check if start date is valid for check-in
        if (!$this->isCheckInAllowed($startDate)) {
            return false;
        }

        // Check if end date is valid for check-out
        if (!$this->isCheckOutAllowed($endDate)) {
            return false;
        }

        // Check all dates in between
        $currentDate = $start->copy()->addDay();
        while ($currentDate->lt($end)) {
            if (!$this->isDateAvailable($currentDate->format('Y-m-d'))) {
                return false;
            }
            $currentDate->addDay();
        }

        return true;
    }

    public function getCheckInOnlyDates(): array
    {
        return array_values(array_unique($this->checkInOnly));
    }

    public function getCheckOutOnlyDates(): array
    {
        return array_values(array_unique($this->checkOutOnly));
    }

    public function getBlockedDates(): array
    {
        // Remove any check-in or check-out dates from blocked dates
        $blockedDates = array_diff(
            $this->bookedAndBlockedDates,
            $this->checkInOnly,
            $this->checkOutOnly
        );

        return array_values(array_unique($blockedDates));
    }
}
