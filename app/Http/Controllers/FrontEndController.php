<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mime\Part\TextPart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\Models\PublishSeason;
use App\Models\BookingDate;
use App\Models\Experience;
use App\Models\Vendor;
use App\Models\VendorSocialMedia;
use App\Models\VendorPricing;
use App\Models\Review;
use App\Models\Customer;
use App\Models\User;
use App\Models\VendorInquiry;
use App\Models\VendorMediaGallery;
use App\Models\VendorRoom;
use App\Models\VendorWine;
use App\Models\Inquiry;
use App\Models\SubCategory;
use App\Models\FarmingPractice;
use App\Models\SubRegion;
use App\Models\Establishment;
use App\Models\Cuisine;
use App\Models\Wallet;
use Illuminate\Support\Facades\Http;
use App\Helpers\TimezoneHelper;

use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use App\Models\BusinessHour;
use App\Models\TastingOption;
use App\Helpers\SeasonHelper;
use App\Models\CurativeExperience;
use App\Services\DateCheckerService;

class FrontEndController extends Controller
{
    private $dateCheckerService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        DateCheckerService $dateCheckerService
    ) {
        $this->dateCheckerService = $dateCheckerService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        // // Convert local to UTC
        // $utcTime = TimezoneHelper::toUTC('2025-01-13 10:00:00', 'America/New_York');
        // echo $utcTime; // Outputs: 2025-01-13 15:00:00

        // // Convert UTC to local
        // $localTime = TimezoneHelper::toLocal('2025-01-13 15:00:00', 'America/New_York');
        // echo $localTime; // Outputs: 2025-01-13 10:00:00

        // // Get user's timezone
        // $userTimezone = TimezoneHelper::getUserTimezone();
        // echo $userTimezone;

        $reviews = Review::where('review_status', 'approved')->get();
        return view('FrontEnd.home', compact('reviews'));
    }

    public function getAccommodations()
    {
        $subCategories = SubCategory::where(['category_id' => 1, 'status' => 1])->get();
        $subRegions = SubRegion::where(['region_id' => 1, 'status' => 1])->get();
        return view('FrontEnd.accommodations', compact('subCategories', 'subRegions'));
    }
    public function getAccommodationsList(Request $request)
    {
        if ($request->ajax()) {
            $preliminaryData = Vendor::with([
                'countryName',
                'sub_category',
                'sub_regions',
                'accommodationMetadata',
                'mediaGallery'
            ])
                ->where('vendor_type', 'accommodation')
                ->where('account_status', 'Preliminary Profile');

            $fullProfileData = Vendor::with([
                'countryName',
                'sub_category',
                'sub_regions',
                'accommodationMetadata',
                'mediaGallery'
            ])
                ->where('vendor_type', 'accommodation')
                ->where('account_status', 'Full Profile');

            // Apply filters
            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $preliminaryData->where('vendor_name', 'LIKE', "%{$search}%");
                $fullProfileData->where('vendor_name', 'LIKE', "%{$search}%");
            }
            if ($request->has('vendor_sub_category') && !empty($request->vendor_sub_category)) {
                $preliminaryData->whereIn('vendor_sub_category', $request->vendor_sub_category);
                $fullProfileData->whereIn('vendor_sub_category', $request->vendor_sub_category);
            }

            if ($request->has('bedrooms') && !empty($request->bedrooms)) {
                $bedrooms = $request->bedrooms;
                $preliminaryData->whereHas('accommodationMetadata', function ($query) use ($bedrooms) {
                    foreach ($bedrooms as $bedroom) {
                        if ($bedroom == '4+') {
                            $query->orWhere('bedrooms', '>=', 4);
                        } else {
                            $query->orWhere('bedrooms', $bedroom);
                        }
                    }
                });

                $fullProfileData->whereHas('accommodationMetadata', function ($query) use ($bedrooms) {
                    foreach ($bedrooms as $bedroom) {
                        if ($bedroom == '4+') {
                            $query->orWhere('bedrooms', '>=', 4);
                        } else {
                            $query->orWhere('bedrooms', $bedroom);
                        }
                    }
                });
            }

            if ($request->has('person') && !empty($request->person)) {
                $persons = $request->person;
                $preliminaryData->whereHas('accommodationMetadata', function ($query) use ($persons) {
                    foreach ($persons as $person) {
                        if ($person == '8+') {
                            $query->orWhere('sleeps', '>=', 8);
                        } else {
                            $query->orWhere('sleeps', $person);
                        }
                    }
                });

                $fullProfileData->whereHas('accommodationMetadata', function ($query) use ($persons) {
                    foreach ($persons as $person) {
                        if ($person == '8+') {
                            $query->orWhere('sleeps', '>=', 8);
                        } else {
                            $query->orWhere('sleeps', $person);
                        }
                    }
                });
            }
            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $preliminaryData->where('vendor_name', 'LIKE', "%{$search}%");
                $fullProfileData->where('vendor_name', 'LIKE', "%{$search}%");
            }
            if ($request->has('price_point') && !empty($request->price_point)) {
                $preliminaryData->whereIn('price_point', $request->price_point);
                $fullProfileData->whereIn('price_point', $request->price_point);
            }

            if ($request->has('city') && !empty($request->city)) {
                $preliminaryData->whereIn('city', $request->city);
                $fullProfileData->whereIn('city', $request->city);
            }

            if ($request->has('sub_region') && !empty($request->sub_region)) {
                $preliminaryData->whereIn('sub_region', $request->sub_region);
                $fullProfileData->whereIn('sub_region', $request->sub_region);
            }

            // Apply average rating filter
            if ($request->has('avg_rating') && !empty($request->avg_rating)) {
                $avgRating = $request->avg_rating;

                // Subquery to calculate average rating and filter vendors
                $preliminaryData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });

                $fullProfileData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });
            }

            $vendors = $fullProfileData->union($preliminaryData)
                ->orderBy('account_status', 'asc')
                ->orderBy('vendor_name', 'asc')
                // ->orderBy('id', 'desc')
                ->paginate(10)
                // ->toSql();
                ->appends($request->all());
            // print_r($vendors); die;
            return response()->json([
                'html' => view('FrontEnd.get_accommodation_list', compact('vendors'))->render(), // Rendered HTML of the listings
                'pagination' => (string) $vendors->links('vendor.pagination.bootstrap-5'), // Pagination links
            ]);

            //return view('FrontEnd.get_accommodation_list', compact('vendors'));
        }
    }

    private function getAccommodationDetails($short_code)
    {
        // Check if the vendor slug exists
        $vendor = Vendor::with('sub_regions', 'sub_category', 'countryName', 'accommodationMetadata')->where('short_code', $short_code)->first();
        $socialLinks = $vendor->socialMedia()->first();
        $amenities = $vendor->amenities()->get();
        $currentDate = now();
        $season = SeasonHelper::getSeasonAndPrice($currentDate, $vendor->id);
        // If the vendor does not exist, redirect to the homepage
        if (!$vendor) {
            return redirect('/');
        }

        $vendor->load('mediaGallery');
        $mediaGalleries = VendorMediaGallery::where('vendor_id', $vendor->id)->where('is_default', 0)->get();
        // If the vendor exists, proceed with the logic to show the accommodation details
        return view('FrontEnd.accommodation-details', compact('vendor', 'socialLinks', 'amenities', 'season', 'mediaGalleries'));
    }

    private function getWineryDetails($short_code)
    {
        if (Auth::guard('vendor')->check()) {
            $user_id =  Auth::guard('vendor')->user()->id;
            $user = Vendor::find($user_id);
        } else if (Auth::guard('customer')->check()) {
            $user_id =  Auth::guard('customer')->user()->id;
            $user = Customer::find($user_id);
        } else {
            $user = null;
        }
        // Check if the vendor slug exists
        $vendor = Vendor::with('sub_regions', 'sub_category', 'countryName', 'accommodationMetadata')->where('short_code', $short_code)->first();
        $today = Carbon::now()->format('l'); // e.g., 'Monday'


        // Query the business hours for today
        $businessHours = BusinessHour::where('vendor_id', $vendor->id)
            ->where('day', $today)
            ->where('is_open', 1) // Ensure the business is open today
            ->first(); // Get the first matching record (if available)

        if ($businessHours) {
            // Business is open today
            $openingTime = Carbon::parse($businessHours->opening_time)->format('h:i A');
            if ($businessHours->is_late == 1) {
                $closingTime = ' (Late Closing)';
            } else {
                $closingTime = Carbon::parse($businessHours->closing_time)->format('h:i A');
            }
            $isOpen = true;
        } else {
            // Business is closed today
            $openingTime = null;
            $closingTime = null;
            $isOpen = false;
        }

        // Output the result
        $hours = 'Closed Today';
        if ($isOpen) {
            $hours = $openingTime . ' - ' . $closingTime;
        }
        $cuisineIds = !empty($vendor->wineryMetadata->cuisines) ? $vendor->wineryMetadata->cuisines : '[]'; // Split the comma-separated list into an array of IDs
        $cuisineNames = '';
        if (!empty($cuisineIds)) {
            $cuisineIds = json_decode($cuisineIds);
            $cuisines = Cuisine::whereIn('id', $cuisineIds)->get(); // Retrieve the cuisines by these IDs
            $cuisineNames = $cuisines->pluck('name')->implode(', ');
        }


        // Implode the names into a comma-separated string
        $socialLinks = $vendor->socialMedia()->first();
        $amenities = $vendor->amenities()->get();
        $wines = VendorWine::where('vendor_id', $vendor->id)
            ->where('delisted', 0)
            ->where('price', '>', 0.00)
            ->get();
        // If the vendor does not exist, redirect to the homepage
        if (!$vendor) {
            return redirect('/');
        }

        $vendor->load('mediaGallery');
        $mediaGalleries = VendorMediaGallery::where('vendor_id', $vendor->id)->where('is_default', 0)->get();
        // If the vendor exists, proceed with the logic to show the accommodation details
        return view('FrontEnd.wineryDetails', compact('vendor', 'socialLinks', 'amenities', 'wines', 'hours', 'cuisineNames', 'user', 'mediaGalleries'));
    }

    public function getExcursionDetails($short_code)
    {
        // Check if the vendor slug exists
        $vendor = Vendor::with('sub_regions', 'sub_category', 'countryName', 'accommodationMetadata')->where('short_code', $short_code)->first();
        $socialLinks = $vendor->socialMedia()->first();
        $amenities = $vendor->amenities()->get();
        // If the vendor does not exist, redirect to the homepage
        if (!$vendor) {
            return redirect('/');
        }

        $vendor->load('mediaGallery');
        // If the vendor exists, proceed with the logic to show the accommodation details
        return view('FrontEnd.excursionDetails', compact('vendor', 'socialLinks', 'amenities'));
    }

    public function manage_sub_regionsPost(Request $request)
    {
        $vendor_id = $request->vendor_id;
        $vendor = Vendor::find($vendor_id);
        $dates = array();
        $cojoinDates = array();
        $cojoinDatess = array();
        $cojoin = array();
        $VendorBookingAllSeason = array();
        $season_types = array();
        $current_dates =  date('y-m-d'); // gets the current timestamp
        $current_date =  time(); // gets the current timestamp
        $bookedAndBlockeddates = [];
        $checkOutOnly = [];
        $checkInOnly = [];
        if ($vendor->inventory_type == 2) {
            $booked = DB::table('booking_dates')->where('vendor_id',  $vendor_id)->where('booking_type', '!=', 'packaged')->select('start_date', 'end_date')->get();
            $cojoin = DB::table('booking_dates')->where('vendor_id',  $vendor_id)->where('booking_type', 'packaged')->select('start_date', 'end_date')->get();

            // $booked_dates = DB::table('member_payment')->where('vendor_id',  $vendor_id)->select('check_in','check_out')->get();
            // $VendorBookingSeason = VendorBookingSeasons::where('vendor_id',$vendor_id)->first();
            $VendorBookingAllSeason = PublishSeason::where('vendor_id', $vendor_id)->select('season_type')->where('publish', 1)->get();


            $end_date = strtotime('+1 year', $current_date); // gets the timestamp for the date one year from now

            if (count($VendorBookingAllSeason)) {
                foreach ($VendorBookingAllSeason as $VendorBookingAll) {
                    $season_types[] = $VendorBookingAll->season_type;
                }
            }

            //year dates
            $current_year = date('Y');
            $winterYear = date('Y');
            $currentMonth = date('m');
            $winterMonth = array("01", "02", "03");

            if (!in_array($currentMonth, $winterMonth)) {
                $winterYear += 1;
            }

            for ($i = $current_date; $i <= $end_date; $i += 86400) {
                $currentDate = date('Y-m-d', $i);

                // Determine the correct year for winter's ending date
                $winterYear = (date('m-d', $i) >= '12-21') ? date('Y', $i) + 1 : date('Y', $i);
                $currentYear = date('Y', $i); // Adjust current year dynamically

                if (
                    (in_array("spring", $season_types) && $currentDate >= date($currentYear . '-03-21') && $currentDate <= date($currentYear . '-06-20')) ||
                    (in_array("summer", $season_types) && $currentDate >= date($currentYear . '-06-21') && $currentDate <= date($currentYear . '-09-20')) ||
                    (in_array("fall", $season_types) && $currentDate >= date($currentYear . '-09-21') && $currentDate <= date($currentYear . '-12-20')) ||
                    (in_array("winter", $season_types) && (
                        ($currentDate >= date($currentYear . '-12-21') && $currentDate <= date($currentYear . '-12-31')) ||
                        ($currentDate >= date($winterYear . '-01-01') && $currentDate <= date($winterYear . '-03-20'))
                    ))
                ) {
                    // Date is within one of the selected seasons
                    continue;
                } else {
                    // Date is unavailable
                    $dates[] = $currentDate;
                }
            }

            if (count($booked)) {
                foreach ($booked as $value) {
                    $diff = date_diff(date_create($value->start_date), date_create($value->end_date));
                    $days = $diff->format("%a") . ",";
                    $start_date = $value->start_date;
                    $end_date = $value->end_date;
                    $checkOutOnly[] =  $start_date;
                    $checkInOnly[] =  $end_date;
                    // array_push($bookedAndBlockeddates, $value->start_date);
                    $inside_start_date = date('Y-m-d', strtotime(($start_date . '-1 day')));
                    for ($day = 0; $day <= $days; $day++) {
                        $inside_start_date = date('Y-m-d', strtotime(($inside_start_date . '1 day')));
                        if (in_array($inside_start_date, $checkOutOnly)) {
                            continue;
                        }
                        if (in_array($inside_start_date, $checkInOnly)) {
                            continue;
                        }
                        array_push($bookedAndBlockeddates, $inside_start_date);
                    }
                }
            }

            if (count($cojoin)) {
                foreach ($cojoin as $value) {
                    $diff = date_diff(date_create($value->start_date), date_create($value->end_date));
                    $days = $diff->format("%a") . ",";
                    $start_date = $value->start_date;
                    array_push($cojoinDates, $value->start_date);
                    for ($day = 1; $day <= $days; $day++) {
                        $start_date = date('Y-m-d', strtotime(($start_date . '1 day')));
                        array_push($cojoinDates, $start_date);
                    }
                    // array_push($dates, $value->end_date);
                }

                foreach ($cojoin as $value) {
                    // Convert start_date and end_date to Carbon instances
                    $startDate = Carbon::parse($value->start_date);
                    $endDate = Carbon::parse($value->end_date);
                    // Initialize an array to hold dates for the current range
                    $rangeDates = [];

                    // Generate all dates between start_date and end_date, including both
                    for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                        // Add each date to the rangeDates array in 'Y-m-d' format
                        $rangeDates[] = $date->format('Y-m-d');
                    }

                    // Add this array of dates to the main allDates array
                    $cojoinDatess[] = $rangeDates;
                }
            }



            $today = Carbon::today();
            $orders = Order::where('vendor_id', $vendor_id)
                ->where(function ($query) use ($today) {
                    $query->where('check_in_at', '>=', $today)
                        ->orWhere('check_out_at', '>=', $today);
                })
                ->get();
            foreach ($orders as $order) {

                $checkin = Carbon::parse($order->check_in_at);
                $checkout = Carbon::parse($order->check_out_at)->subDay();

                // Ensure we start from today if checkin is before today
                if ($checkin->lt($today)) {
                    $checkin = $today;
                }
                $checkOutOnly[] =  $checkin;
                $checkInOnly[] =  $checkout;
                // Generate dates between checkin and checkout
                while ($checkin->lte($checkout)) {
                    $bookedAndBlockeddates[] = $checkin->toDateString(); // Add the date to the array
                    $checkin->addDay(); // Move to the next day
                }
            }
            // Remove duplicates just in case
            $bookedAndBlockeddates = array_unique($bookedAndBlockeddates);

            // Sort dates (optional)
            sort($bookedAndBlockeddates);
        }
        
        $dates_all = $this->dateCheckerService->processVendorDates($vendor_id);
        $checkInOnly = $this->dateCheckerService->getCheckInOnlyDates();
        $checkOutOnly = $this->dateCheckerService->getCheckOutOnlyDates();
        $bookedAndBlockeddates = $this->dateCheckerService->getBlockedDates();
        $data['bookedAndBlockeddates']  = $bookedAndBlockeddates;
        $data['checkOutOnly']           = $checkOutOnly;
        $data['checkInOnly']           = $checkInOnly;
        $data['dates'] = $dates;
        // $data['booking_minimum']        = isset($VendorBookingSeason->booking_min) ? $VendorBookingSeason->booking_min : '';
        // $data['booking_maximum']        = isset($VendorBookingSeason->booking_max) ? $VendorBookingSeason->booking_max : '';
        // $data['refund_policy']          = isset($VendorBookingSeason->refund_policy) ? $VendorBookingSeason->refund_policy : '';
        // $data['season_types'] = isset($VendorBookingSeason->season_types) ? $VendorBookingSeason->season_types : '';
        $data['cojoin'] = $cojoin;
        $data['cojoinDates'] = $cojoinDates;
        $data['cojoinDatess'] = $cojoinDatess;
        $data['VendorBookingAllSeason'] = $VendorBookingAllSeason;
        return response()->json(array('success' => true, 'data' => $data), 200);
    }

    public function getWineriesList(Request $request)
    {
        if ($request->ajax()) {
            // Preliminary Data Query
            $preliminaryData = Vendor::withCount('businessHours')
                ->with([
                    'countryName',
                    'sub_category',
                    'sub_regions',
                    'wineryMetadata.tastingOptions',
                    'wineryMetadata.farmingPractices',
                    'wineryMetadata.maxGroup',
                    'wineryMetadata.cuisine',
                    'mediaGallery'
                ])
                ->where('vendor_type', 'Winery')
                ->where('account_status', 'Preliminary Profile');

            // Full Profile Data Query
            $fullProfileData = Vendor::withCount('businessHours')
                ->with([
                    'countryName',
                    'sub_category',
                    'sub_regions',
                    'wineryMetadata.tastingOptions',
                    'wineryMetadata.farmingPractices',
                    'wineryMetadata.maxGroup',
                    'wineryMetadata.cuisine',
                    'mediaGallery'
                ])
                ->where('vendor_type', 'Winery')
                ->where('account_status', 'Full Profile');

            // Filter by vendor_sub_category
            if ($request->has('vendor_sub_category') && !empty($request->vendor_sub_category)) {
                $preliminaryData->whereIn('vendor_sub_category', $request->vendor_sub_category);
                $fullProfileData->whereIn('vendor_sub_category', $request->vendor_sub_category);
            }

            // Filter by tasting options through the wineryMetadata.tastingOption relationship
            if ($request->has('tasting_options') && !empty($request->tasting_options)) {
                $preliminaryData->whereHas('wineryMetadata.tastingOptions', function ($query) use ($request) {
                    $query->whereIn('id', $request->tasting_options); // Adjust based on tasting option schema
                });

                $fullProfileData->whereHas('wineryMetadata.tastingOptions', function ($query) use ($request) {
                    $query->whereIn('id', $request->tasting_options);
                });
            }

            if ($request->has('cuisines') && !empty($request->cuisines)) {
                $preliminaryData->whereHas('excursionMetadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines); // Adjust based on tasting option schema
                });

                $fullProfileData->whereHas('excursionMetadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines);
                });
            }

            // Filter by sub_region
            if ($request->has('sub_region') && !empty($request->sub_region)) {
                $preliminaryData->whereIn('sub_region', $request->sub_region);
                $fullProfileData->whereIn('sub_region', $request->sub_region);
            }

            // Apply average rating filter using reviews relation
            if ($request->has('avg_rating') && !empty($request->avg_rating)) {
                $avgRating = $request->avg_rating;

                $preliminaryData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->havingRaw('ROUND(AVG(rating), 0) >= ?', [$avgRating])
                        ->groupBy('vendor_id');
                });

                $fullProfileData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->havingRaw('ROUND(AVG(rating), 0) >= ?', [$avgRating])
                        ->groupBy('vendor_id');
                });
            }

            // Union the results from both preliminary and full profile vendors
            $vendors = $fullProfileData->union($preliminaryData)
                ->orderBy('account_status', 'asc')
                ->orderBy('vendor_name', 'asc')
                // ->orderBy('id', 'desc')
                ->paginate(10)
                ->appends($request->all());

            // Load media gallery and return view with business hours count
            // $vendors->load();

            // die;
            return response()->json([
                'html' => view('FrontEnd.get_wineries_list', compact('vendors'))->render(), // Rendered HTML of the listings
                'pagination' => (string) $vendors->links('vendor.pagination.bootstrap-5'), // Pagination links
            ]);
            // return view('FrontEnd.get_wineries_list', compact('vendors'));
        }
    }

    public function getExcursionsList(Request $request)
    {
        if ($request->ajax()) {
            $preliminaryData = Vendor::withCount('businessHours')
                ->with([
                    'countryName',
                    'sub_category',
                    'sub_regions',
                    'excursionMetadata.establishments',
                    'excursionMetadata.farmingPractices',
                    'excursionMetadata.maxGroup',
                    'excursionMetadata.cuisine',
                    'mediaGallery'
                ])
                ->where('vendor_type', 'Excursion')
                ->where('account_status', 'Preliminary Profile');

            $fullProfileData = Vendor::withCount('businessHours')
                ->with([
                    'countryName',
                    'sub_category',
                    'sub_regions',
                    'excursionMetadata.establishments',
                    'excursionMetadata.farmingPractices',
                    'excursionMetadata.maxGroup',
                    'excursionMetadata.cuisine',
                    'mediaGallery'
                ])
                ->where('vendor_type', 'Excursion')
                ->where('account_status', 'Full Profile');

            // Apply filters
            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $preliminaryData->where('vendor_name', 'LIKE', "%{$search}%");
                $fullProfileData->where('vendor_name', 'LIKE', "%{$search}%");
            }
            if ($request->has('vendor_sub_category') && !empty($request->vendor_sub_category)) {
                $preliminaryData->whereIn('vendor_sub_category', $request->vendor_sub_category);
                $fullProfileData->whereIn('vendor_sub_category', $request->vendor_sub_category);
            }

            if ($request->has('sub_region') && !empty($request->sub_region)) {
                $preliminaryData->whereIn('sub_region', $request->sub_region);
                $fullProfileData->whereIn('sub_region', $request->sub_region);
            }

            if ($request->has('establishment') && !empty($request->establishment)) {
                $preliminaryData->whereHas('excursionMetadata.establishments', function ($query) use ($request) {
                    $query->whereIn('id', $request->establishment); // Adjust based on tasting option schema
                });

                $fullProfileData->whereHas('excursionMetadata.establishments', function ($query) use ($request) {
                    $query->whereIn('id', $request->establishment);
                });
            }

            if ($request->has('cuisines') && !empty($request->cuisines)) {
                $preliminaryData->whereHas('excursionMetadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines); // Adjust based on tasting option schema
                });

                $fullProfileData->whereHas('excursionMetadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines);
                });
            }
            // Apply average rating filter
            if ($request->has('avg_rating') && !empty($request->avg_rating)) {
                $avgRating = $request->avg_rating;

                // Subquery to calculate average rating and filter vendors
                $preliminaryData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });

                $fullProfileData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });
            }

            $vendors = $fullProfileData->union($preliminaryData)
                ->orderBy('account_status', 'asc')
                ->orderBy('vendor_name', 'asc')
                ->paginate(10)
                ->appends($request->all());

            return response()->json([
                'html' => view('FrontEnd.get_excursion_list', compact('vendors'))->render(), // Rendered HTML of the listings
                'pagination' => (string) $vendors->links('vendor.pagination.bootstrap-5'), // Pagination links
            ]);
            // return view('FrontEnd.get_excursion_list', compact('vendors'));
        }
    }
    public function sendMails(Request $request)
    {
        // Validate request data
        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        // Send request to Google's reCAPTCHA API
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('GOOGLE_RECAPTCHA_SECRET'), // Replace with your Secret Key
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $responseBody = json_decode($response->getBody(), true);

        // Check if reCAPTCHA is valid and has a good score
        if (!$responseBody['success'] || $responseBody['score'] < 0.5) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed. Please try again.']);
        }

        // Retrieve request data
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $subject = $request->input('subject');
        $userMessage = $request->input('message');

        // Define email parameters
        $to = $email;
        $subject = 'Thank you for contacting us';
        $emailContent = view('emails.contact_user', [
            'fname' => $fname,
            'lname' => $lname,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $userMessage
        ])->render();

        // Send email using Laravel's Mail facade
        // sendEmail(env('ADMIN_EMAIL'), $subject, $emailContent);
        $send = Mail::send([], [], function ($message) use ($emailContent) {
            $message->to(env('ADMIN_EMAIL'), 'Wine Country Admin')
                ->subject('New Contact Form Submission')
                // ->from('collaborate@winecountryweekends.ca', 'Wine Country Admin')
                ->html($emailContent); // Set the HTML content
        });

        if ($send === null) {
            return back()->withErrors(['error' => 'There was an error sending your message. Please try again.']);
        }

        // Redirect to the specified route after successful submission
        return redirect()->route('contact-us')->with('success', 'Your message has been sent successfully!');
    }
    public function AccommodationsInquiry(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'vendor_id' => 'required|integer',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'visit_nature' => 'required|string',
            'guest_no' => 'required|integer',
            'vendor_sub_category' => 'required|string',
            'sub_region' => 'required|string',
            'rooms_required' => 'required|integer',
            'additional_comments_inquiry' => 'nullable|string',
            'preferred_accommodation' => 'nullable|string',
        ]);

        // Add user ID to the validated data
        $validated['user_id'] = Auth::id();

        // Fetch vendor details using vendor_id from validated data
        $vendor = Vendor::findOrFail($validated['vendor_id']);

        // Fetch user details
        $user = Auth::user();

        // Set default value for preferred_accommodation if not provided
        $validated['preferred_accommodation'] = $request->input('preferred_accommodation', 'Null');

        // Create a new record in the database
        VendorInquiry::create($validated);

        // Define email parameters
        $to = "gagandeeps2588@gmail.com, winecountryweekends@gmail.com"; // Assuming the vendor has an email attribute
        $subject = 'New Accommodation Inquiry';
        $emailContent = view('emails.accommodation_inquiry', [
            'validated' => $validated,
            'vendor' => $vendor,
            'user' => $user
        ])->render();

        // Send email using Laravel's Mail facade
        sendEmail($to, $subject, $emailContent);

        // Redirect or return a response
        return redirect()->back()->with('success', 'Inquiry submitted successfully!');
    }

    public function CheckAvailability(Request $request)
    {
        $status = "success";
        $message = "";
        $view = "";
        if ($request->vendorid) {

            $vendor_id =  $request->vendorid;
            $Vendor = Vendor::find($vendor_id);
            if ($Vendor->inventory_type == "Rooms") {
                // $request->start_date;
                // $request->end_date

                $view = view('FrontEnd.vendorRoomsList', compact('Vendor'))->render();
            } else {
                if ($request->booking_type == 'booked' && !$request->type) {
                    $booking_min = $Vendor->booking_minimum;
                    $booking_max = $Vendor->booking_maximum;

                    $startDate = date_create($request->start_date);
                    $endDate = date_create($request->end_date);

                    $interval = date_diff($startDate, $endDate);
                    $daysDiff = $interval->format('%a');

                    if ($booking_min > $daysDiff) {
                        $data['status'] = "error";
                        $data['message'] = "Please observe the posted booking minimum";
                        return response()->json($data, 200);
                    }

                    if ($booking_max < $daysDiff) {
                        $data['status'] = "error";
                        $data['message'] = "Please observe the posted booking maximum";
                        return response()->json($data, 200);
                    }
                }

                $blockedDate =     BookingDate::where('vendor_id', $vendor_id)
                    ->where('booking_type', '=', 'blocked')
                    ->where('start_date', '>=', $request->start_date)
                    ->where('end_date', '<=', $request->end_date)
                    ->select('start_date', 'end_date')
                    ->get();

                if (count($blockedDate) > 0) {
                    $data['status'] = "error";
                    $data['message'] = "Apologies, Selected dates are Blocked for booking. Please contact admin for assistance.";
                    return response()->json($data, 200);
                }

                $BookingDate =     BookingDate::where('vendor_id', $vendor_id)
                    ->where('booking_type', '=', 'booked')
                    ->where('start_date', '>=', $request->start_date)
                    ->where('end_date', '<=', $request->end_date)
                    ->select('start_date', 'end_date')
                    ->get();

                // $bookedDate = MemberPayment::where('vendor_id', $vendor_id)
                // 				->where('check_in', '>=', $request->start_date)
                // 				->where('check_out', '<=', $request->end_date)
                // 				->select('check_in as start_date', 'check_out as end_date')
                // 				->get();

                // if(count($BookingDate) > 0 || count($bookedDate) > 0){
                if (count($BookingDate) > 0) {
                    $data['status'] = "error";
                    $data['message'] = "Apologies, Booking for selected dates are already booked. Please contact admin for assistance.";
                    return response()->json($data, 200);
                }
            }
        }

        $data = ['status' => $status, 'message' => $message, 'inventory_type' => $Vendor->inventory_type, 'view' => $view];
        return response()->json($data, 200);
    }
    public function CheckProcess(Request $request)
    {
        if ($request->input('apk')) {
            $data = Inquiry::where('apk', $request->input('apk'))->first();
            !empty($data) or abort(404);
            $token = Str::random(64);
            $start_date = Carbon::parse($data->check_in_at)->format('Y-m-d');
            $end_date = Carbon::parse($data->check_out_at)->format('Y-m-d');
            $daysDiff = getDaysDifference($start_date, $end_date);
            $vendor = Vendor::find($data->vendor_id);
            $amount = $vendor->pricing->current_rate ?? 0 * $daysDiff;
            $curative_exp = json_decode($data['experiences_selected'], true);
            $details = [
                'vendor_id' => $data->vendor_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'number_travel_party' => $data->travel_party_size,
                'nature_of_visit' => $data->visit_purpose,
                'days' => $daysDiff,
                'amount' => $amount,
                'token' => $token,
                'apk' => $request->input('apk'),
                'curative_exp' => array_column($curative_exp, 'name')
            ];
            Session::put('booking', $details);
            // Redirect to the checkout page with the token
            return redirect()->route('checkout.info', ['token' => $token]);
        }
        // Generate a unique token
        if ($request->start_date && $request->end_date && $request->vendor_id) {
            $token = Str::random(64);
            $daysDiff = getDaysDifference($request->start_date, $request->end_date);

            $vendor = Vendor::find($request->vendor_id);
            $amount = $vendor->pricing->current_rate ?? 0 * $daysDiff;
            // Store the booking details in the session
            $details = [
                'vendor_id' => $request->input('vendor_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'number_travel_party' => $request->input('number_travel_party'),
                'nature_of_visit' => $request->input('nature_of_visit'),
                'days' => $daysDiff,
                'amount' => $amount,
                'token' => $token,
                'curative_exp' => []
            ];
            Session::put('booking', $details);
            // Redirect to the checkout page with the token
            return redirect()->route('checkout.info', ['token' => $token]);
        }
    }
    public function Checkoutinfo($token)
    {
        // Retrieve the booking details from the session using the token
        $booking = (object) Session::get('booking');
        if (!empty($booking->apk)) {
            $inquiry = inquiry::where('apk', $booking->apk)->first();
            $inquiry->experiences_selected_arr = json_decode($inquiry->experiences_selected);
        } else {
            $inquiry = null;
        }


        if (!$booking || !isset($booking->token) || $booking->token !== $token) {
            return redirect()->route('accommodations')->with('error', 'Invalid token');
        }

        // Get vendor details using vendor_id
        $vendor = Vendor::with('mediaLogo', 'sub_regions', 'sub_category', 'countryName', 'accommodationMetadata', 'stripeDetails')->find($booking->vendor_id);
        if (!$vendor) {
            return redirect()->route('home')->with('error', 'Vendor not found');
        }
        $wallet = Wallet::where('customer_id', Auth::user()->id)->first();

        $vendor->load('mediaGallery');

        $currentDate = now();
        $season = SeasonHelper::getSeasonAndPrice($currentDate, $vendor->id);
        // Return the view with the booking details
        return view('FrontEnd.checkout', compact('booking', 'vendor', 'inquiry', 'wallet', 'season'));
    }

    public function getVendorDetails($vendorid)
    {
        $vendor = Vendor::where('user_id', $vendorid)->first();
        return view('FrontEnd.accommodation', compact('vendor'));
    }
    public function excursionstore(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'vendor_id' => 'required|integer',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'visit_nature' => 'required|string',
            'guest_no' => 'required|integer',
            'excursion_activities' => 'array',
            'preferred_accommodation' => 'required|string',
            'sub_region' => 'required|string',
            'additional_comments_inquiry' => 'nullable|string',
            'vendor_sub_category' => 'nullable|string',
            'rooms_required' => 'nullable|string',
        ]);

        // Add user ID to the validated data
        $validated['user_id'] = Auth::id();
        $validated['excursion_activities'] = json_encode($request->input('excursion_activities'));

        // Fetch vendor details using vendor_id from validated data
        $vendor = Vendor::findOrFail($validated['vendor_id']);

        // Fetch user details
        $user = Auth::user();

        // Set default values if not provided
        $validated['vendor_sub_category'] = $request->input('vendor_sub_category', 'Null');
        $validated['rooms_required'] = $request->input('rooms_required', '0');

        // Create a new record in the database
        VendorInquiry::create($validated);

        // Decode JSON fields for email view
        $validated['excursion_activities'] = json_decode($validated['excursion_activities'], true);

        // Define email parameters
        $to = "gagandeeps2588@gmail.com, winecountryweekends@gmail.com"; // Assuming the vendor has an email attribute
        $subject = 'New Excursion Inquiry';
        $emailContent = view('emails.excursion_inquiry', [
            'validated' => $validated,
            'vendor' => $vendor,
            'user' => $user,
        ])->render();

        // Send email using Laravel's Mail facade
        sendEmail($to, $subject, $emailContent);

        // Redirect or return a response
        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
    public function winerystore(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'vendor_id' => 'required|integer',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'guest_no' => 'required|integer',
            'vendor_sub_category' => 'array',
            'experience_type' => 'array',
            'group_type' => 'array',
            'additional_comments_inquiry' => 'nullable|string',
            'visit_nature' => 'nullable|string',
            'vendor_sub_category' => 'nullable|string',
            'sub_region' => 'nullable|string',
            'rooms_required' => 'nullable|string',
            'preferred_accommodation' => 'nullable|string',
        ]);

        // Add user ID to the validated data
        $validated['user_id'] = Auth::id();
        $validated['vendor_sub_category'] = json_encode($request->input('vendor_sub_category'));
        $validated['experience_type'] = json_encode($request->input('experience_type'));
        $validated['group_type'] = json_encode($request->input('group_type'));

        // Fetch vendor details using vendor_id from validated data
        $vendor = Vendor::findOrFail($validated['vendor_id']);

        // Fetch user details
        $user = Auth::user();

        // Set default values if not provided
        $validated['visit_nature'] = $request->input('visit_nature', 'Null');
        $validated['vendor_sub_category'] = $request->input('vendor_sub_category', 'Null');
        $validated['sub_region'] = $request->input('sub_region', 'Null');
        $validated['rooms_required'] = $request->input('rooms_required', '0');
        $validated['preferred_accommodation'] = $request->input('preferred_accommodation', '0');

        // Create a new record in the database
        VendorInquiry::create($validated);

        // Decode JSON fields for email view
        $validated['vendor_sub_category'] = json_decode($validated['vendor_sub_category'], true);
        $validated['experience_type'] = json_decode($validated['experience_type'], true);
        $validated['group_type'] = json_decode($validated['group_type'], true);

        // Define email parameters
        $to = "hkamboj116@gmail.com"; // Assuming the vendor has an email attribute
        $subject = 'New Winery Inquiry';
        $emailContent = view('emails.winery_inquiry', [
            'validated' => $validated,
            'vendor' => $vendor,
            'user' => $user,
        ])->render();

        // Send email using Laravel's Mail facade
        sendEmail($to, $subject, $emailContent);

        // Redirect or return a response
        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
    public function showQCode(Request $request, $short_code)
    {
        $redirect = $request->query('redirect', null);
        if ($redirect) {
            return redirect($redirect . "?sc=" . $short_code);
        }
        $vendor = Vendor::where('short_code', $short_code)->firstOrFail();

        return view('FrontEnd.showQCode', compact('vendor'));
    }
    public function generateQCode($short_code)
    {
        $vendor = Vendor::where('short_code', $short_code)->firstOrFail();
        // Generate QR Code
        if ($vendor->qr_code == "") {
            $qrCodeData = route('vendorQCode.show', [
                'short_code' => $vendor->short_code,
                'redirect' => "/register" // Replace 'register' with your desired redirect route
            ]);

            $qrCodePath = 'images/VendorQRCodes/' . $vendor->vendor_name . '-' . $vendor->id . '.png';

            QrCode::format('png')->size(200)->generate($qrCodeData, public_path($qrCodePath));

            // Save the QR code path to the vendor
            $vendor->qr_code = $qrCodePath;
            $vendor->save();
            echo "Qr code Created Successfully!";
        } else {
            echo "Qr code already exist";
        }
    }
    public function getlicensedList(Request $request)
    {
        if ($request->ajax()) {
            $preliminaryData = Vendor::withCount('businessHours')
                ->with([
                    'countryName',
                    'sub_category',
                    'sub_regions',
                    'licenseMetadata.farmingPractices',
                    'licenseMetadata.maxGroup',
                    'licenseMetadata.cuisine',
                    'mediaGallery'
                ])
                ->where('vendor_type', 'Licensed')
                ->where('account_status', 'Preliminary Profile');

            $fullProfileData = Vendor::withCount('businessHours')
                ->with([
                    'countryName',
                    'sub_category',
                    'sub_regions',
                    'licenseMetadata.farmingPractices',
                    'licenseMetadata.maxGroup',
                    'licenseMetadata.cuisine',
                    'mediaGallery'
                ])
                ->where('vendor_type', 'Licensed')
                ->where('account_status', 'Full Profile');

            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $preliminaryData->where('vendor_name', 'LIKE', "%{$search}%");
                $fullProfileData->where('vendor_name', 'LIKE', "%{$search}%");
            }

            // Apply vendor sub-category filter
            if ($request->has('vendor_sub_category') && !empty($request->vendor_sub_category)) {
                $subCategories = $request->vendor_sub_category;

                $preliminaryData->where(function ($query) use ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $query->orWhere('vendor_sub_category', 'LIKE', "%{$subCategory}%");
                    }
                });

                $fullProfileData->where(function ($query) use ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $query->orWhere('vendor_sub_category', 'LIKE', "%{$subCategory}%");
                    }
                });
            }

            if ($request->has('cuisines') && !empty($request->cuisines)) {
                $preliminaryData->whereHas('licenseMetadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines); // Adjust based on tasting option schema
                });

                $fullProfileData->whereHas('licenseMetadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines);
                });
            }

            // Apply sub-region filter
            if ($request->has('sub_region') && !empty($request->sub_region)) {
                $preliminaryData->whereIn('sub_region', $request->sub_region);
                $fullProfileData->whereIn('sub_region', $request->sub_region);
            }

            // Apply average rating filter
            if ($request->has('avg_rating') && !empty($request->avg_rating)) {
                $avgRating = $request->avg_rating;

                $preliminaryData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });

                $fullProfileData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });
            }

            $vendors = $fullProfileData->union($preliminaryData)
                ->orderBy('account_status', 'asc')
                ->orderBy('vendor_name', 'asc')
                ->paginate(10)
                ->appends($request->all());
            return response()->json([
                'html' => view('FrontEnd.get_licensed_list', compact('vendors'))->render(), // Rendered HTML of the listings
                'pagination' => (string) $vendors->links('vendor.pagination.bootstrap-5'), // Pagination links
            ]);
            // return view('FrontEnd.get_licensed_list', compact('vendors'));
        }
    }

    public function getnonlicensedList(Request $request)
    {
        if ($request->ajax()) {
            $preliminaryData = Vendor::withCount('businessHours')
                ->with([
                    'countryName',
                    'sub_category',
                    'sub_regions',
                    'nonLicenseMetadata.farmingPractices',
                    'nonLicenseMetadata.maxGroup',
                    'nonLicenseMetadata.cuisine',
                    'mediaGallery'
                ])
                ->where('vendor_type', 'Non-Licensed')
                ->where('account_status', 'Preliminary Profile');

            $fullProfileData = Vendor::withCount('businessHours')
                ->with([
                    'countryName',
                    'sub_category',
                    'sub_regions',
                    'nonLicenseMetadata.farmingPractices',
                    'nonLicenseMetadata.maxGroup',
                    'nonLicenseMetadata.cuisine',
                    'mediaGallery'
                ])
                ->where('vendor_type', 'Non-Licensed')
                ->where('account_status', 'Full Profile');

            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $preliminaryData->where('vendor_name', 'LIKE', "%{$search}%");
                $fullProfileData->where('vendor_name', 'LIKE', "%{$search}%");
            }

            // Apply vendor sub-category filter with partial matching
            if ($request->has('vendor_sub_category') && !empty($request->vendor_sub_category)) {
                $subCategories = $request->vendor_sub_category;

                $preliminaryData->where(function ($query) use ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $query->orWhere('vendor_sub_category', 'LIKE', "%{$subCategory}%");
                    }
                });

                $fullProfileData->where(function ($query) use ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $query->orWhere('vendor_sub_category', 'LIKE', "%{$subCategory}%");
                    }
                });
            }

            if ($request->has('cuisines') && !empty($request->cuisines)) {
                $preliminaryData->whereHas('nonLicenseMetadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines); // Adjust based on tasting option schema
                });

                $fullProfileData->whereHas('nonlicenseMetadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines);
                });
            }

            // Apply sub-region filter
            if ($request->has('sub_region') && !empty($request->sub_region)) {
                $preliminaryData->whereIn('sub_region', $request->sub_region);
                $fullProfileData->whereIn('sub_region', $request->sub_region);
            }

            // Apply average rating filter
            if ($request->has('avg_rating') && !empty($request->avg_rating)) {
                $avgRating = $request->avg_rating;

                $preliminaryData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });

                $fullProfileData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });
            }

            $vendors = $fullProfileData->union($preliminaryData)
                ->orderBy('account_status', 'asc')
                ->orderBy('vendor_name', 'asc')
                ->paginate(10)
                ->appends($request->all());

            $vendors->load('mediaGallery');
            return response()->json([
                'html' => view('FrontEnd.get_non_licensed_list', compact('vendors'))->render(), // Rendered HTML of the listings
                'pagination' => (string) $vendors->links('vendor.pagination.bootstrap-5'), // Pagination links
            ]);
            // return view('FrontEnd.get_non_licensed_list', compact('vendors'));
        }
    }

    public function businessHours(Request $request, $vendor_id)
    {
        if ($request->ajax()) {
            $vendor = Vendor::where('id', $vendor_id)->first();
            if (strtolower($vendor->vendor_type) == 'non-licensed') {
                $cuisineIds = !empty($vendor->nonLicenseMetadata->cuisines) ? $vendor->nonLicenseMetadata->cuisines : '[]';
            } else if (strtolower($vendor->vendor_type) == 'winery') {
                $cuisineIds = !empty($vendor->wineryMetadata->cuisines) ? $vendor->wineryMetadata->cuisines : '[]';
            } else if (strtolower($vendor->vendor_type) == 'excursion') {
                $cuisineIds = !empty($vendor->excursionMetadata->cuisines) ? $vendor->excursionMetadata->cuisines : '[]';
            } else if (strtolower($vendor->vendor_type) == 'licensed') {
                $cuisineIds = !empty($vendor->licenseMetadata->cuisines) ? $vendor->licenseMetadata->cuisines : '[]';
            }
            $cuisines = Cuisine::whereIn('id', json_decode($cuisineIds, true))->pluck('name');
            $businessHours = BusinessHour::where('vendor_id', $vendor_id)->get();
            $currentDay = \Carbon\Carbon::now()->format('l');
            return view('FrontEnd.business_hours', compact('businessHours', 'vendor', 'currentDay', 'cuisines'));
        }
    }

    public function filterSearch(Request $request)
    {
        // Get the search query
        $searchTerm = $request->input('query');
        $type = $request->input('type');
        if ($type == 'accommodations') {
            $type = 'accommodation';
        }
        if ($type == 'wineries') {
            $type = 'winery';
        }
        // Search for vendors whose name matches the query
        $vendors = Vendor::where('vendor_name', 'LIKE', "%{$searchTerm}%")
            ->where('vendor_type', $type)
            ->select('id', 'vendor_name as name')
            ->get();

        // Return the results as JSON
        return response()->json($vendors);
    }

    public function wineries()
    {
        $subCategories = SubCategory::where(['category_id' => 3, 'status' => 1])->get();
        $subRegions = SubRegion::where(['region_id' => 1, 'status' => 1])->get();
        $tastingOptions = TastingOption::where('status', 1)->get();
        return view('FrontEnd.wineries-listing', compact('subCategories', 'subRegions', 'tastingOptions'));
    }

    public function excursions()
    {
        $subCategories = SubCategory::where(['category_id' => 2, 'status' => 1])->get();
        $subRegions = SubRegion::where(['region_id' => 1, 'status' => 1])->get();
        $establishments = Establishment::where('status', 1)->get();
        $cuisines = Cuisine::where('status', 1)->get();
        return view('FrontEnd.excursion-listing', compact('subCategories', 'subRegions', 'establishments', 'cuisines'));
    }

    public function licensed()
    {
        $subCategories = SubCategory::where(['category_id' => 4, 'status' => 1])->get();
        $cuisines = Cuisine::where('status', 1)->get();
        return view('FrontEnd.licensed', compact('subCategories', 'cuisines'));
    }

    public function nonLicensed()
    {
        $subCategories = SubCategory::where(['category_id' => 5, 'status' => 1])->get();
        $cuisines = Cuisine::where('status', 1)->get();
        return view('FrontEnd.nonlicensed', compact('subCategories', 'cuisines'));
    }

    public function vendorType()
    {
        $fullUrl = url()->current();
        $lastSegment = collect(explode('/', $fullUrl))->last();
        $type = $lastSegment;
        if (!in_array($type, ['accommodations', 'wineries', 'excursion', 'licensed', 'non-licensed'])) {
            return redirect()->route('home');
        }
        if ($type == 'wineries') {
            $vendor_type = 'winery';
        } elseif ($type == 'excursion') {
            $vendor_type = 'excursion';
        } elseif ($type == 'licensed') {
            $vendor_type = 'licensed';
        } elseif ($type == 'non-licensed') {
            $vendor_type = 'non-licensed';
        } elseif ($type == 'accommodations') {
            $vendor_type = 'accommodation';
        }

        $vendorCount = Vendor::where('vendor_type', $vendor_type)
            ->where(function ($query) {
                $query->where('account_status', 1)
                    ->orWhere('account_status', 2)
                    ->orWhere('account_status', 3);
            })
            ->orderBy('name', 'asc')
            ->count();

        $subCategories = SubCategory::whereHas('category', function ($query) use ($vendor_type) {
            $query->where('slug', $vendor_type);
        })->get();
        $subRegions = SubRegion::where(['region_id' => 1, 'status' => 1])->get();
        $establishments = Establishment::where('status', 1)->get();
        $cuisines = Cuisine::where('status', 1)->orderBy('name', 'asc')->get();
        $tastingOptions = TastingOption::where('status', 1)->get();
        $farmingPractices = FarmingPractice::where('status', 1)->get();
        $cities = Vendor::where('vendor_type', $vendor_type)
            ->where(function ($query) {
                $query->where('account_status', 1)
                    ->orWhere('account_status', 2)
                    ->orWhere('account_status', 3);
            })
            ->orderBy('city', 'asc')
            ->distinct()
            ->pluck('city');
        return view('FrontEnd.vendor-type', compact('vendor_type', 'subCategories', 'subRegions', 'establishments', 'cuisines', 'tastingOptions', 'cities', 'type', 'farmingPractices', 'vendorCount'));
    }

    public function getVendorTypeList($vendor_type, Request $request)
    {
        if ($vendor_type == 'accommodation') {
            $type = 'accommodation';
            $with = [
                'countryName',
                'sub_category',
                'sub_regions',
                $type . 'Metadata',
                'mediaGallery',
                'mediaLogo',
            ];
        } else if ($vendor_type == 'excursion') {
            $type = 'excursion';
            $with = [
                'countryName',
                'businessHours',
                'sub_category',
                'sub_regions',
                $type . 'Metadata.establishments',
                $type . 'Metadata.farmingPractices',
                $type . 'Metadata.maxGroup',
                $type . 'Metadata.cuisine',
                'mediaGallery',
                'mediaLogo',
            ];
        } else if ($vendor_type == 'winery') {
            $type = 'winery';
            $with = [
                'countryName',
                'sub_category',
                'sub_regions',
                'businessHours',
                $type . 'Metadata.tastingOptions',
                $type . 'Metadata.farmingPractices',
                $type . 'Metadata.maxGroup',
                $type . 'Metadata.cuisine',
                'mediaGallery',
                'mediaLogo',
            ];
        } else if ($vendor_type == 'licensed') {
            $type = 'license';
            $with = [
                'countryName',
                'sub_category',
                'sub_regions',
                'businessHours',
                $type . 'Metadata.farmingPractices',
                $type . 'Metadata.maxGroup',
                $type . 'Metadata.cuisine',
                'mediaGallery',
                'mediaLogo',
            ];
        } else if ($vendor_type == 'non-licensed') {
            $type = 'nonLicense';
            $with = [
                'countryName',
                'businessHours',
                'sub_category',
                'sub_regions',
                $type . 'Metadata.farmingPractices',
                $type . 'Metadata.maxGroup',
                $type . 'Metadata.cuisine',
                'mediaGallery',
                'mediaLogo',
            ];
        }
        if ($request->ajax()) {
            $preliminaryData = Vendor::withCount('businessHours')
                ->with($with)
                ->where('vendor_type', $vendor_type)
                ->where('account_status', '3');

            $participantData = Vendor::withCount('businessHours')
                ->with($with)
                ->where('vendor_type', $vendor_type)
                ->where('account_status', '2');

            $partnerData = Vendor::withCount('businessHours')
                ->with($with)
                ->where('vendor_type', $vendor_type)
                ->where('account_status', '1');

            // Apply search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $preliminaryData->where('vendor_name', 'LIKE', "%{$search}%");
                $participantData->where('vendor_name', 'LIKE', "%{$search}%");
                $partnerData->where('vendor_name', 'LIKE', "%{$search}%");
            }

            // Apply vendor sub-category filter with partial matching
            if ($request->has('vendor_sub_category') && !empty($request->vendor_sub_category)) {
                $subCategories = $request->vendor_sub_category;

                $preliminaryData->where(function ($query) use ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $query->orWhere('vendor_sub_category', 'LIKE', "%{$subCategory}%");
                    }
                });

                $participantData->where(function ($query) use ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $query->orWhere('vendor_sub_category', 'LIKE', "%{$subCategory}%");
                    }
                });

                $partnerData->where(function ($query) use ($subCategories) {
                    foreach ($subCategories as $subCategory) {
                        $query->orWhere('vendor_sub_category', 'LIKE', "%{$subCategory}%");
                    }
                });
            }

            if ($request->has('establishment') && !empty($request->establishment)) {
                $preliminaryData->whereHas($type . 'Metadata.establishments', function ($query) use ($request) {
                    $query->whereIn('id', $request->establishment); // Adjust based on tasting option schema
                });

                $participantData->whereHas($type . 'Metadata.establishments', function ($query) use ($request) {
                    $query->whereIn('id', $request->establishment);
                });

                $partnerData->whereHas($type . 'Metadata.establishments', function ($query) use ($request) {
                    $query->whereIn('id', $request->establishment);
                });
            }

            // // Apply sub-region filter
            if ($request->has('sub_region') && !empty($request->sub_region)) {
                $preliminaryData->whereIn('sub_region', $request->sub_region);
                $participantData->whereIn('sub_region', $request->sub_region);
                $partnerData->whereIn('sub_region', $request->sub_region);
            }

            if ($request->has('city') && !empty($request->city)) {
                $preliminaryData->whereIn('city', $request->city);
                $participantData->whereIn('city', $request->city);
                $partnerData->whereIn('city', $request->city);
            }

            if ($request->has('tasting_options') && !empty($request->tasting_options)) {
                $preliminaryData->whereHas($type . 'Metadata.tastingOptions', function ($query) use ($request) {
                    $query->whereIn('id', $request->tasting_options); // Adjust based on tasting option schema
                });

                $participantData->whereHas($type . 'Metadata.tastingOptions', function ($query) use ($request) {
                    $query->whereIn('id', $request->tasting_options);
                });

                $partnerData->whereHas($type . 'Metadata.tastingOptions', function ($query) use ($request) {
                    $query->whereIn('id', $request->tasting_options);
                });
            }

            if ($request->has('days') && !empty($request->days)) {
                $preliminaryData->whereHas('businessHours', function ($query) use ($request) {
                    $query->whereIn('day', $request->days) // Check if the vendor is open on any of these days
                        ->where('is_open', 1); // Ensure that the vendor is open
                });

                $participantData->whereHas('businessHours', function ($query) use ($request) {
                    $query->whereIn('day', $request->days) // Check if the vendor is open on any of these days
                        ->where('is_open', 1); // Ensure that the vendor is open
                });

                $partnerData->whereHas('businessHours', function ($query) use ($request) {
                    $query->whereIn('day', $request->days) // Check if the vendor is open on any of these days
                        ->where('is_open', 1); // Ensure that the vendor is open
                });
            }

            if ($request->has('farming_practices') && !empty($request->farming_practices)) {
                $preliminaryData->whereHas($type . 'Metadata.farmingPractices', function ($query) use ($request) {
                    $query->whereIn('id', $request->farming_practices); // Adjust based on tasting option schema
                });

                $participantData->whereHas($type . 'Metadata.farmingPractices', function ($query) use ($request) {
                    $query->whereIn('id', $request->farming_practices);
                });

                $partnerData->whereHas($type . 'Metadata.farmingPractices', function ($query) use ($request) {
                    $query->whereIn('id', $request->farming_practices);
                });
            }

            if ($request->has('bedrooms') && !empty($request->bedrooms)) {
                $bedrooms = $request->bedrooms;
                $preliminaryData->whereHas($type . 'Metadata', function ($query) use ($bedrooms) {
                    foreach ($bedrooms as $bedroom) {
                        if ($bedroom == '4+') {
                            $query->orWhere('bedrooms', '>=', 4);
                        } else {
                            $query->orWhere('bedrooms', $bedroom);
                        }
                    }
                });

                $participantData->whereHas($type . 'Metadata', function ($query) use ($bedrooms) {
                    foreach ($bedrooms as $bedroom) {
                        if ($bedroom == '4+') {
                            $query->orWhere('bedrooms', '>=', 4);
                        } else {
                            $query->orWhere('bedrooms', $bedroom);
                        }
                    }
                });

                $partnerData->whereHas($type . 'Metadata', function ($query) use ($bedrooms) {
                    foreach ($bedrooms as $bedroom) {
                        if ($bedroom == '4+') {
                            $query->orWhere('bedrooms', '>=', 4);
                        } else {
                            $query->orWhere('bedrooms', $bedroom);
                        }
                    }
                });
            }

            if ($request->has('person') && !empty($request->person)) {
                $persons = $request->person;
                $preliminaryData->whereHas($type . 'Metadata', function ($query) use ($persons) {
                    foreach ($persons as $person) {
                        if ($person == '8+') {
                            $query->orWhere('sleeps', '>=', 8);
                        } else {
                            $query->orWhere('sleeps', $person);
                        }
                    }
                });

                $participantData->whereHas($type . 'Metadata', function ($query) use ($persons) {
                    foreach ($persons as $person) {
                        if ($person == '8+') {
                            $query->orWhere('sleeps', '>=', 8);
                        } else {
                            $query->orWhere('sleeps', $person);
                        }
                    }
                });

                $partnerData->whereHas($type . 'Metadata', function ($query) use ($persons) {
                    foreach ($persons as $person) {
                        if ($person == '8+') {
                            $query->orWhere('sleeps', '>=', 8);
                        } else {
                            $query->orWhere('sleeps', $person);
                        }
                    }
                });
            }

            if ($request->has('cuisines') && !empty($request->cuisines)) {
                $preliminaryData->whereHas($type . 'Metadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines); // Adjust based on tasting option schema
                });

                $participantData->whereHas($type . 'Metadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines);
                });

                $partnerData->whereHas($type . 'Metadata.cuisine', function ($query) use ($request) {
                    $query->whereIn('id', $request->cuisines);
                });
            }

            // // Apply average rating filter
            if ($request->has('avg_rating') && !empty($request->avg_rating)) {
                $avgRating = $request->avg_rating;

                $preliminaryData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });

                $participantData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });

                $partnerData->whereHas('reviews', function ($query) use ($avgRating) {
                    $query->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                        ->groupBy('vendor_id')
                        ->having('avg_rating', '>=', $avgRating);
                });
            }

            if ($request->has('price_point') && !empty($request->price_point)) {
                $preliminaryData->whereIn('price_point', $request->price_point);
                $participantData->whereIn('price_point', $request->price_point);
                $partnerData->whereIn('price_point', $request->price_point);
            }

            $vendors = $partnerData->union($participantData)
                ->union($preliminaryData)
                ->orderBy('account_status', 'asc')
                ->orderBy('account_status_updated_at', 'asc')
                ->orderBy('vendor_name', 'asc')
                ->paginate(10)
                ->appends($request->all());
            $cities = Vendor::where('vendor_type', $vendor_type)->orderBy('city', 'asc')->distinct()->pluck('city');
            return response()->json([
                'html' => view('FrontEnd.get_vendor_type_list', compact('vendors', 'cities'))->render(), // Rendered HTML of the listings
                'pagination' => (string) $vendors->links('vendor.pagination.bootstrap-5'), // Pagination links
                'total' => $vendors->total(),
            ]);
            // return view('FrontEnd.get_non_licensed_list', compact('vendors'));
        }
    }

    public function detailsShortCode($short_code, Request $request)
    {
        $vendor = Vendor::where('short_code', $short_code)->first();
        if (!$vendor) {
            abort(404);
        }
        if (strtolower($vendor->vendor_type) == 'accommodation') {
            return $this->getAccommodationDetails($short_code);
        } else if (strtolower($vendor->vendor_type) == 'winery') {
            return $this->getWineryDetails($short_code);
        } else if (strtolower($vendor->vendor_type) == 'excursion') {
            return $this->getExcursionDetails($short_code);
        }
    }

    public function events() {
        $events = CurativeExperience::with('category')->paginate(10);
        return view('FrontEnd.events', compact('events'));
    }
}
