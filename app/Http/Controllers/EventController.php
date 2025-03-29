<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurativeExperience;
use Carbon\Carbon;

class EventController extends Controller
{
    public function events(Request $request)
    {
        $query = CurativeExperience::with('category')
            ->where('status', 'active'); // Only active events

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('name', 'LIKE', "%{$searchTerm}%");
        }

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // ✅ Get today's events (start_date <= today AND end_date >= today)
        $todayEvents = (clone $query)
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get();

        // ✅ Get tomorrow's events (start_date <= tomorrow AND end_date >= tomorrow)
        $tomorrowEvents = (clone $query)
            ->whereDate('start_date', '<=', $tomorrow)
            ->whereDate('end_date', '>=', $tomorrow)
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get();

        // ✅ Get upcoming events (excluding today & tomorrow)
        $upcomingEvents = (clone $query)
            ->whereDate('start_date', '>', $tomorrow)
            ->whereDate('end_date', '>', $tomorrow)
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get();

        return view('FrontEnd.events.index', compact('todayEvents', 'tomorrowEvents', 'upcomingEvents'));
    }

    public function getEvents(Request $request)
    {
        $query = CurativeExperience::with('category')->where('status', 'active'); // Active events only

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // ✅ Handle Date Filters in One Query
        if ($request->has('date_filter') && is_array($request->date_filter)) {
            $query->where(function ($q) use ($request, $today, $tomorrow) {
                foreach ($request->date_filter as $filter) {
                    match ($filter) {
                        'today' => $q->orWhereBetween('start_date', [$today, $today]),
                        'tomorrow' => $q->orWhereBetween('start_date', [$tomorrow, $tomorrow]),
                        'upcoming' => $q->orWhere('start_date', '>', $tomorrow),
                        default => null
                    };
                }
            });
        }

        // ✅ Date Range Filter (Overrides predefined date filters)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $query->whereBetween('start_date', [$startDate, $endDate]);
        }

        // ✅ Filter by Categories (Multiple Selection)
        if ($request->has('categories') && is_array($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        // ✅ Price Filters
        if(!empty($request->min_price) && !empty($request->max_price)) {
            $query->where('is_free', 0); // Only paid events
            if ($request->has('min_price') && $request->has('max_price')) {
                $query->whereBetween('admittance', [$request->min_price, $request->max_price]);
            }
        }
        if (!empty($request->is_free) && $request->is_free == 1) {
            $query->where('is_free', 1); // Only free events
        }

        // ✅ Fetch Events in One Query
        $events = $query->orderBy('start_date', 'asc')->limit(10)->get();
        return response()->json([
            'html' => view('FrontEnd.events.partials.filtered-events', compact('events'))->render()
        ]);
    }

    function searchEvents(Request $request)
    {
        $searchTerm = $request->query('term');

        $results = CurativeExperience::where('name', 'LIKE', "%{$searchTerm}%")
            ->limit(5)
            ->pluck('name', 'id'); // Only return titles

        return response()->json($results);
    }

    function eventDetails(Request $request, $id)
    {
        $event = CurativeExperience::with('category')->find($id);
        $relatedEvents = CurativeExperience::with('category')->where('category_id', $event->category_id)->where('id', '!=', $event->id)->limit(3)->get();
        return view('FrontEnd.events.event-details', compact('event', 'relatedEvents'));
    }

    function eventCheckout(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:curative_experiences,id',
        ]);
        $event = CurativeExperience::with('category')->find($request->event_id);
        return view('FrontEnd.events.event-checkout', compact('event'));
    }
}
