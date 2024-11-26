<?php

use App\Models\Review;
use Illuminate\Support\Facades\Mail;

// use Auth;

if (! function_exists('truncateReviewDescription')) {
    function truncateReviewDescription($text, $limit = 41)
    {
        if (strlen($text) > $limit) {
            $truncated = substr($text, 0, $limit) . '...';
            return $truncated . ' <a href="javascript:void(0)" class="read-more theme-color" data-full-text="' . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . '">..Read More</a>';
        }

        return $text;
    }
}
if (! function_exists('reviewsCount')) {
    function reviewsCount()
    {
        return Review::where('user_id', Auth::id())->count();
    }
}

if (! function_exists('sendEmail')) {
    function sendEmail($to, $subject, $emailContent)
    {
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <collaborate@winecountryweekends.ca>' . "\r\n";

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
    function getResidualSugars(?string $key = null)
    {
        $options = [
            '0-1' => '0 - 1 g/l (Bone Dry)',
            '1-9' => '1 - 9 g/l (Dry)',
            '10-49' => '10 - 49 g/l (Off Dry)',
            '50-120' => '50 - 120 g/l (Semi-Sweet)',
            '120+' => '120+ g/l (Sweet)',
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

if(! function_exists('getCategoryById')) {
    function getCategoryById($id) {
        return \App\Models\Category::find($id)->pluck('name')->first();
    }
}

if(! function_exists('getSubCategoryById')) {
    function getSubCategoryById($id) {
        return \App\Models\SubCategory::find($id)->pluck('name')->first();
    }
}

if(! function_exists('getEstablishmentById')) {
    function getEstablishmentById($id) {
        return \App\Models\Establishment::find($id)->pluck('name')->first();
    }
}

if(! function_exists('getAccountStatusById')) {
    function getAccountStatusById($id) {
        return \App\Models\AccountStatus::find($id)->pluck('name')->first();
    }
}
