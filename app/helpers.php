<?php

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Helpers\TimezoneHelper;
use App\Models\CurativeExperience;
use Illuminate\Support\Facades\DB;

// use Auth;

if (! function_exists('truncateReviewDescription')) {
    function truncateReviewDescription($text, $image, $limit = 41)
    {
        if (strlen($text) > $limit) {
            $truncated = ''; //substr($text, 0, $limit) . '...';
            return $truncated . ' <a href="javascript:void(0)" class="read-more theme-color" data-image="' . $image . '" data-full-text="' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '">View Comment</a>';
        }

        return $text;
    }
}
if (! function_exists('reviewsCount')) {
    function reviewsCount()
    {
        return Review::where('customer_id', Auth::id())->count();
    }
}

if (! function_exists('approvedReviewsCount')) {
    function approvedReviewsCount()
    {
        return Review::where('customer_id', Auth::id())->where('review_status', 'approved')->count();
    }
}

if (! function_exists('sendEmail')) {
    function sendEmail($to, $subject, $emailContent)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <system@winecountryweekends.ca>' . "\r\n";

        mail($to, $subject, $emailContent, $headers);
    }
}

// if (!function_exists('sendEmail')) {
//     /**
//      * Send an email with the specified parameters.
//      *
//      * @param  string  $to
//      * @param  string  $subject
//      * @param  string  $messageBody
//      * @return void
//      */
//     function sendEmail($to, $subject, $messageBody)
//     {
//         try {
//             $to = 'sarvjeetsingh.slinfy@gmail.com';
//             $send = Mail::raw($messageBody, function ($message) use ($to, $subject) {
//                 $message->to($to)
//                     ->from('booking@winecountryweekends.ca', 'WineCountryWeekends')
//                     ->subject($subject);
//             });
//             print_r($send);
//             die;
//         } catch (\Exception $e) {
//             print_r($e->getMessage());
//             die;
//             // Log error or handle the exception
//             \Log::error('Error sending email: ' . $e->getMessage());
//         }
//     }
// }

if (! function_exists('getDaysDifference')) {
    function getDaysDifference($start_date, $end_date)
    {
        $startDate = date_create($start_date);
        $endDate = date_create($end_date);

        $interval = date_diff($startDate, $endDate);
        $daysDiff = $interval->format('%a');
        return $daysDiff;
    }
}

if (! function_exists('getVendor')) {
    function getVendor($id)
    {
        return \App\Models\Vendor::find($id);
    }
}

if (! function_exists('getCountries')) {
    function getCountries()
    {
        return \App\Models\Country::all();
    }
}

if (! function_exists('getCategories')) {
    function getCategories()
    {
        return \App\Models\Category::where('status', 1)
            ->get();
    }
}

if (! function_exists('getSubCategories')) {
    function getSubCategories($category_id = null)
    {
        return \App\Models\SubCategory::where('category_id', $category_id)
            ->where('status', 1)
            ->get();
    }
}

if (! function_exists('getInventoryTypes')) {
    function getInventoryTypes($category_id = null)
    {
        return \App\Models\InventoryType::with('subCategories')->where('category_id', $category_id)
            ->where('status', 1)
            ->get();
    }
}

if (! function_exists('getGrapeVarietals')) {
    function getGrapeVarietals()
    {
        return \App\Models\GrapeVarietal::where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }
}

if (! function_exists('getGrapeVarietalsById')) {
    function getGrapeVarietalsById($id = null)
    {
        if ($id == null) {
            return null;
        }
        return \App\Models\GrapeVarietal::where('status', 1)
            ->where('id', $id)
            ->orderBy('name', 'asc')
            ->pluck('name')
            ->first();
    }
}

if (! function_exists('getRegions')) {
    function getRegions()
    {
        return \App\Models\Region::where('status', 1)
            ->get();
    }
}

if (! function_exists('getSubRegions')) {
    function getSubRegions($region_id)
    {
        return \App\Models\SubRegion::where('region_id', $region_id)
            ->where('status', 1)
            ->get();
    }
}

if (! function_exists('getEstablishments')) {
    function getEstablishments()
    {
        return \App\Models\Establishment::where('status', 1)
            ->get();
    }
}

if (! function_exists('getCuisines')) {
    function getCuisines()
    {
        return \App\Models\Cuisine::where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
    }
}

if (! function_exists('getFarmingPractices')) {
    function getFarmingPractices()
    {
        return \App\Models\FarmingPractice::where('status', 1)
            ->get();
    }
}

if (! function_exists('getMaxGroups')) {
    function getMaxGroups()
    {
        return \App\Models\MaxGroup::where('status', 1)
            ->get();
    }
}

if (! function_exists('getTastingOptions')) {
    function getTastingOptions()
    {
        return \App\Models\TastingOption::where('status', 1)
            ->get();
    }
}

if (! function_exists('wineryCart')) {
    function wineryCart($shopid, $vendorid = null)
    {
        // Retrieve the winery cart with related cart items for the specified vendor and user
        $cart = \App\Models\WineryCart::where('user_id', Auth::id())
            ->where('vendor_id', $vendorid)
            ->where('shop_id', $shopid)
            ->withCount('items') // Get the count of related items
            ->first();

        // Check if the cart exists and get item count
        return $cart ? $cart->items_count : 0;
    }
}

if (! function_exists('getCustomFields')) {
    function getCustomFields($entity)
    {
        return match ($entity) {
            'regions' => ['region_code'],
            'sub_regions' => ['region_id', 'sub_region_code'],
            'inventories' => ['stock_quantity', 'price'],
            default => []
        };
    }
}

if (!function_exists('getResidualSugars')) {
    /**
     * Get options for radio buttons or a single value by key.
     *
     * @param string|null $key The key to retrieve a specific value. If null, returns the full array.
     * @return array|string|null The full array, a single value, or null if the key doesn't exist.
     */
    function getResidualSugars(?string $key = null, $value = null)
    {
        $options = [
            '0-1' => $value ?? '0-1' . ' g/l (Bone Dry)',
            '1-9' => $value ?? '1-9' . ' g/l (Dry)',
            '10-49' => $value ?? '10-49' . ' g/l (Off Dry)',
            '50-120' => $value ?? '50-120' . ' g/l (Semi-Sweet)',
            '120+' => $value ?? '120+' . ' g/l (Sweet)',
        ];

        if ($key === null) {
            return $options; // Return the entire array if no key is provided
        }

        return $options[$key] ?? null; // Return the specific value or null if the key doesn't exist
    }
}

if (!function_exists('getModules')) {
    function getModules()
    {
        return \App\Models\Module::where('status', 1)
            ->get();
    }
}

if (!function_exists('getPricePoints')) {
    function getPricePoints()
    {
        return \App\Models\PricePoint::where('status', 1)
            ->get();
    }
}

if (!function_exists('getAccountStatus')) {
    function getAccountStatus()
    {
        return \App\Models\AccountStatus::where('status', 1)
            ->get();
    }
}

if (! function_exists('getCategoryById')) {
    function getCategoryById($id)
    {
        return \App\Models\Category::find($id)->pluck('name')->first();
    }
}

if (! function_exists('getSubCategoryById')) {
    function getSubCategoryById($id)
    {
        return \App\Models\SubCategory::find($id)->pluck('name')->first();
    }
}

if (! function_exists('getEstablishmentById')) {
    function getEstablishmentById($id)
    {
        return \App\Models\Establishment::find($id)->pluck('name')->first();
    }
}

if (! function_exists('getAccountStatusById')) {
    function getAccountStatusById($id)
    {
        return \App\Models\AccountStatus::find($id)->pluck('name');
    }
}

if (! function_exists('getStates')) {
    function getStates($country_id)
    {
        return \App\Models\State::where('status', 1)->where('country_id', $country_id)
            ->orderBy('name')
            ->get()
            ->groupBy('type')
            ->sortKeysUsing(function ($key) {
                // Custom sorting logic: prioritize 'province' over 'state'
                return $key === 'province' ? 0 : ($key === 'state' ? 1 : 2);
            });
    }
}

if (!function_exists('calculateStockingFeeAndPrice')) {
    function calculateStockingFeeAndPrice(float $cost)
    {
        // Calculate stocking fee
        $stockingFee = 0;

        if ($cost <= 20) {
            $stockingFee = 3;
        } elseif ($cost <= 40) {
            $stockingFee = 4;
        } elseif ($cost <= 60) {
            $stockingFee = 6;
        } elseif ($cost <= 80) {
            $stockingFee = 8;
        } else {
            $stockingFee = 10;
        }

        // Calculate final price
        $finalPrice = $cost + $stockingFee;

        return [
            'stocking_fee' => $stockingFee,
            'final_price' => $finalPrice,
        ];
    }
}

if (!function_exists('authCheck')) {
    function authCheck()
    {
        // Check if a specific type of user is logged in
        if (Auth::guard('customer')->check()) {
            return ['is_logged_in' => true, 'user_type' => 'customer', 'user' => Auth::guard('customer')->user()];
        }

        if (Auth::guard('vendor')->check()) {
            return ['is_logged_in' => true, 'user_type' => 'vendor', 'user' => Auth::guard('vendor')->user()];
        }

        if (Auth::guard('admin')->check()) {
            return ['is_logged_in' => true, 'user_type' => 'admin', 'user' => Auth::guard('admin')->user()];
        }

        // If no user is logged in
        return ['is_logged_in' => false, 'user_type' => null, 'user' => null];
    }

    /**
     * Generate a YouTube-style unique ID using SHA256.
     *
     * @param string $input Optional input string for uniqueness (e.g., video metadata, timestamp).
     * @param int $length Length of the unique ID to generate (default is 11).
     * @return string Generated unique ID.
     */
    function generateYouTubeStyleId($input = '', $length = 11)
    {
        // Base character set: a-z, A-Z, 0-9, -, _
        $characterSet = 'abcdefghijklmnopqrstuvwxyz0123456789';
        // $characterSet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        // If no input provided, use the current time in microseconds
        if (empty($input)) {
            $input = microtime(true) . uniqid();
        }

        // Hash the input using SHA256
        $hash = hash('sha256', $input);

        // Convert the hash to Base64-like encoding
        $uniqueId = '';
        for ($i = 0; $i < $length; $i++) {
            // Use 2 hex characters (1 byte) for each character in the unique ID
            $index = hexdec(substr($hash, $i * 2, 2)) % strlen($characterSet);
            $uniqueId .= $characterSet[$index];
        }

        return $uniqueId;
    }
}

if (!function_exists('isCanadaIP')) {
    /**
     * Check if the given IP address belongs to Canada.
     *
     * @param string $ip The IP address to check.
     * @return bool True if the IP is from Canada, false otherwise.
     */
    function isCanadaIP(string $ip): bool
    {
        if (!env('CHECK_IP_ALLOW_OUTSIDE_COUNTRY', false)) {
            return true;
        }
        // Validate IP address
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false; // Invalid IP address
        }

        // API URL
        $url = "https://ipinfo.io/{$ip}/json?token=23a94570707b64";

        try {
            // Set timeout for the request
            $context = stream_context_create([
                'http' => ['timeout' => 5]
            ]);

            // Fetch data from API
            $response = file_get_contents($url, false, $context);

            // Decode JSON response
            $data = json_decode($response, true);

            // Return true if the country code is CA (Canada)
            return isset($data['country']) && $data['country'] === 'CA';
        } catch (Exception $e) {
            // Log or handle errors as needed
            return false;
        }
    }
}
if (!function_exists('isIndiaIP')) {
    /**
     * Check if the given IP address belongs to Canada.
     *
     * @param string $ip The IP address to check.
     * @return bool True if the IP is from Canada, false otherwise.
     */
    function isIndiaIP(string $ip): bool
    {
        // Validate IP address
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false; // Invalid IP address
        }

        // API URL
        $url = "https://ipinfo.io/{$ip}/json?token=23a94570707b64";

        try {
            // Set timeout for the request
            $context = stream_context_create([
                'http' => ['timeout' => 5]
            ]);

            // Fetch data from API
            $response = file_get_contents($url, false, $context);

            // Decode JSON response
            $data = json_decode($response, true);

            // Return true if the country code is CA (Canada)
            return isset($data['country']) && $data['country'] === 'IN';
        } catch (Exception $e) {
            // Log or handle errors as needed
            return false;
        }
    }
}
if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        $ip = null;

        // Check for forwarded IPs (could be IPv4 or IPv6)
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Get the first IP from the X-Forwarded-For header, which could be IPv4 or IPv6
            $forwardedIps = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($forwardedIps as $forwardedIp) {
                $forwardedIp = trim($forwardedIp);
                if (filter_var($forwardedIp, FILTER_VALIDATE_IP)) {
                    return $forwardedIp;
                }
            }
        }

        // Fallback to REMOTE_ADDR
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }

        return $ip;
    }

    if (!function_exists('time_elapsed')) {
        /**
         * Format a timestamp into a human-readable "time ago" format.
         *
         * @param string|DateTime|Carbon $timestamp
         * @return string
         */
        function time_elapsed($timestamp)
        {
            // Ensure $timestamp is a Carbon instance
            $date = \Carbon\Carbon::parse($timestamp);

            // Return the "time ago" format
            return $date->diffForHumans();
        }
    }

    if (!function_exists('getUserTimezone')) {
        function getUserTimezone()
        {
            $timezone = TimezoneHelper::getUserTimezone();
            return $timezone;
        }
    }
    if (!function_exists('toLocalTimezone')) {
        function toLocalTimezone($utcTimestamp, $timezone, $time = false)
        {
            $timezone = TimezoneHelper::toLocal($utcTimestamp, $timezone, $time);
            return $timezone;
        }
    }
}

if (! function_exists('currency_symbol')) {
    /**
     * Get the currency symbol based on the given currency code.
     *
     * @param string $currency
     * @return string
     */
    function currency_symbol($currency)
    {
        // uppercase currency code
        $currency = strtoupper($currency);
        $currencySymbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'INR' => '₹',
            'AUD' => 'A$',
            'CAD' => 'C$',
            'JPY' => '¥',
            'CNY' => '¥',
            'MXN' => '$',
            'RUB' => '₽',
            'BRL' => 'R$',
            // Add any additional currencies and their symbols here
        ];

        return $currencySymbols[$currency] ?? '?'; // Return symbol or '?' if not found
    }
}

if (!function_exists('calculatePlatformProcessingFee')) {
    /**
     * Calculate the platform processing fee as 8% of the total.
     *
     * @param float $totalAmount
     * @return float
     */
    function calculatePlatformProcessingFee(float $totalAmount, float $feePercentage): float
    {
        $feePercentage = $feePercentage ?? 0.00;
        if ($feePercentage < 0) {
            return 0.00;
        }
        return round(($totalAmount * $feePercentage) / 100, 2);
    }
}

if (!function_exists('refundContent')) {
    /**
     * Calculate the platform processing fee as 8% of the total.
     *
     * @param float $totalAmount
     * @return float
     */
    function refundContent($key = null): string
    {
        $key = str_replace('-', '_', $key);
        $refundContent = App\Models\CmsPage::where('slug', 'refund-policy')->first();
        return $refundContent->description[$key] ?? '';
    }
}

if (!function_exists('getCurativeExperienceCategories')) {
    function getExperienceCurativeCategories()
    {
        return App\Models\CurativeExperienceCategory::where('status', 'active')->get();
    }
}

if (!function_exists('getCurativeExperienceGenres')) {
    function getCurativeExperienceGenres()
    {
        return App\Models\CurativeExperienceGenre::where('status', 'active')->get();
    }
}

if (!function_exists('getEventMinMaxPrice')) {
    function getEventMinMaxPrice()
    {
        // Get today's date
        $today = Carbon\Carbon::today();

        // Get the latest event date
        $maxDate = App\Models\CurativeExperience::max('end_date');
        if (empty($maxDate)) {
            return [
                'min_price' => 0,
                'max_price' => 0,
            ];
        }
        // Fetch the min and max price (admittance) for events that are active between start_date and end_date
        $prices = App\Models\CurativeExperience::whereDate('start_date', '<=', $maxDate) // Event must have started or will start soon
            ->whereDate('end_date', '>=', $today) // Event must still be ongoing or upcoming
            ->whereNotNull('admittance') // Ensure price exists
            ->where('status', 'active')
            ->where('is_free', 0)
            ->selectRaw('MIN(admittance) as min_price, MAX(admittance) as max_price')
            ->first();

        return [
            'min_price' => round($prices->min_price) ?? 0,
            'max_price' => round($prices->max_price) ?? 0,
        ];
    }
}

if (!function_exists('getEventOrderTicketsUsedPerDay')) {
    function getEventOrderTicketsUsedPerDay($eventId, $eventDate)
    {
        $totalTickets = App\Models\EventOrderDetail::where('event_id', $eventId)
            ->whereDate('created_at', $eventDate)
            ->sum('no_of_tickets');
        return $totalTickets;
    }
}

if (!function_exists('platformFeeCalculator')) {
    function platformFeeCalculator($vendor,  $totalAmount, $eventID = null, $wineryb2b = false)
    {
        // Check if the vendor is a B2B winery

        $vendor_type = strtolower($vendor->vendor_type);
        if ($eventID) {
            $platform_fee = $vendor->event_platform_fee ?? '0.00';
        } else {
            if ($vendor_type == 'accommodation') {
                // Accommodation vendors have a different fee structure
                $platform_fee = $vendor->accommodation_platform_fee ?? '0.00';
            } else if ($vendor_type == 'winery') {
                if ($wineryb2b) {
                    // B2B wineries have a different fee structure
                    $platform_fee = $vendor->winery_b2b_platform_fee ?? '0.00';
                } else {
                    // Winery vendors have a different fee structure
                    $platform_fee = $vendor->winery_b2c_platform_fee ?? '0.00';
                }
            } else if ($vendor_type == 'excursion') {
                // Accommodation vendors have a different fee structure
                $platform_fee = $vendor->excursion_platform_fee ?? '0.00';
            }
        }
        return number_format($totalAmount * ($platform_fee / 100), 2, '.', '');
    }
}

if (!function_exists('platformFee')) {
    function platformFee($vendor,  $totalAmount = 0.00, $eventID = null, $wineryb2b = false)
    {
        $vendor_type = strtolower($vendor->vendor_type);
        if ($eventID) {
            $platform_fee = $vendor->event_platform_fee ?? '0.00';
        } else {
            if ($vendor_type == 'accommodation') {
                // Accommodation vendors have a different fee structure
                $platform_fee = $vendor->accommodation_platform_fee ?? '0.00';
            } else if ($vendor_type == 'winery') {
                if ($wineryb2b) {
                    // B2B wineries have a different fee structure
                    $platform_fee = $vendor->winery_b2b_platform_fee ?? '0.00';
                } else {
                    // Winery vendors have a different fee structure
                    $platform_fee = $vendor->winery_b2c_platform_fee ?? '0.00';
                }
            } else if ($vendor_type == 'excursion') {
                // Accommodation vendors have a different fee structure
                $platform_fee = $vendor->excursion_platform_fee ?? '0.00';
            }
        }
        return $platform_fee;
    }
}

if (!function_exists('winery_b2b_price')) {
    function winery_b2b_price($vendor, $wine)
    {
        $vendor_type = strtolower($vendor->vendor_type);
        $price = $wine->price;
        if ($vendor_type == 'winery') {
            if ($vendor->stocking_fee_waiver == 1) {
                $platform_fee = platformFeeCalculator($vendor, $wine->cost, null, true);
                $price = $wine->cost + $platform_fee;
            } else {
                $platform_fee = platformFeeCalculator($vendor, $wine->cost, null, true);
                $price = $wine->price + $platform_fee;
            }
        }
        return number_format($price, 2, '.', '');
    }
}

if (!function_exists('winery_b2c_price')) {
    function winery_b2c_price($vendor, $wine)
    {
        $vendor_type = strtolower($vendor->vendor_type);
        $price = $wine->retail_price;
        if ($vendor_type == 'winery') {
            $platform_fee = platformFeeCalculator($vendor, $wine->cost, null, false);
            if ($vendor->account_status == 1) {
                $price = $wine->retail_price + $platform_fee;
            } else {
                $price = $wine->retail_price;
            }
        }
        return number_format($price, 2, '.', '');
    }
}

if (!function_exists('getCurativeExperienceCities')) {
    function getCurativeExperienceCities()
    {
        return CurativeExperience::select(DB::raw('DISTINCT city'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->orderBy('city')
            ->pluck('city')
            ->toArray();
    }
}
