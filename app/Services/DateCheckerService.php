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
            ->where("cancelled_at", null)
            ->get();
        // Process all date types
        $this
            ->processBookings($booked)
            ->processOrders($orders);
        return $this;
    }

    private function processBookings(Collection $bookings): self
    {
        foreach ($bookings as $booking) {
            $startDate = Carbon::parse($booking->start_date);
            $endDate = Carbon::parse($booking->end_date);

            $startStr = $startDate->format('Y-m-d');
            $endStr = $endDate->format('Y-m-d');

            // 🚨 If the start date is in checkOutOnly, block it and remove it
            if (in_array($startStr, $this->checkInOnly)) {
                $this->bookedAndBlockedDates[] = $startStr;
                $this->checkInOnly = array_diff($this->checkInOnly, [$startStr]);
            } else if (in_array($startStr, $this->checkOutOnly)) {
                $this->bookedAndBlockedDates[] = $startStr;
                $this->checkOutOnly = array_diff($this->checkOutOnly, [$startStr]);
            } else {
                $this->checkOutOnly[] = $startStr;
            }

            // 🚨 If the end date is in checkInOnly, block it and remove it
            if (in_array($endStr, $this->checkOutOnly)) {
                $this->bookedAndBlockedDates[] = $endStr;
                $this->checkOutOnly = array_diff($this->checkOutOnly, [$endStr]);
            }
            else if (in_array($endStr, $this->checkInOnly)) {
                $this->bookedAndBlockedDates[] = $endStr;
                $this->checkInOnly = array_diff($this->checkInOnly, [$endStr]);
            } else {
                $this->checkInOnly[] = $endStr;
            }


            if (in_array($endStr, $this->checkOutOnly)) {
                $this->bookedAndBlockedDates[] = $startStr;
                $this->checkOutOnly = array_diff($this->checkInOnly, [$endStr]);
            }

            // 🚨 Block all middle dates between start and end (exclusive)
            $currentDate = $startDate->copy()->addDay();
            while ($currentDate->lt($endDate)) {
                $this->bookedAndBlockedDates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }
        }

        // 🚨 Remove duplicate blocked dates
        $this->bookedAndBlockedDates = array_values(array_unique($this->bookedAndBlockedDates));

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

            $checkinStr = $checkin->format('Y-m-d');
            $checkoutStr = $checkout->format('Y-m-d');

            // 🚨 If check-in date is in checkOutOnly, block it and remove it
            if (in_array($checkinStr, $this->checkInOnly)) {
                $this->bookedAndBlockedDates[] = $checkinStr;
                $this->checkInOnly = array_diff($this->checkInOnly, [$checkinStr]);
            } else if (in_array($checkinStr, $this->checkOutOnly)) {
                $this->bookedAndBlockedDates[] = $checkinStr;
                $this->checkOutOnly = array_diff($this->checkOutOnly, [$checkinStr]);
            } else {
                $this->checkOutOnly[] = $checkinStr;
            }

            // 🚨 If the end date is in checkInOnly, block it and remove it
            if (in_array($checkoutStr, $this->checkOutOnly)) {
                $this->bookedAndBlockedDates[] = $checkoutStr;
                $this->checkOutOnly = array_diff($this->checkOutOnly, [$checkoutStr]);
            }
            else if (in_array($checkoutStr, $this->checkInOnly)) {
                $this->bookedAndBlockedDates[] = $checkoutStr;
                $this->checkInOnly = array_diff($this->checkInOnly, [$checkoutStr]);
            } else {
                $this->checkInOnly[] = $checkoutStr;
            }


            // 🚨 Block all middle dates between check-in and check-out (exclusive)
            $currentDate = $checkin->copy()->addDay();
            while ($currentDate->lt($checkout)) {
                $this->bookedAndBlockedDates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }
        }

        // 🚨 Remove duplicate blocked dates
        $this->bookedAndBlockedDates = array_values(array_unique($this->bookedAndBlockedDates));

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
