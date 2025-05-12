@if (!empty($featuredEvents) && count($featuredEvents) > 0)
    <div class="row g-4 mb-3">
        <div class="col-12">
            <div class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
                <h3 class="mb-0 fw-bold">Featured Events</h3>
            </div>
        </div>
        @foreach ($featuredEvents as $featuredEvent)
            @include('FrontEnd.events.partials.event-card', [
                'event' => $featuredEvent,
            ])
        @endforeach
    </div>
@endif
<div class="row g-4 mb-3">
    <div class="col-12">
        <div class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
            <h3 class="mb-0 fw-bold">Today Events</h3>
            <div class="head-btn">
                <a href="{{ route('events') }}?date_filter[]=today" class="btn view-btn">View All</a>
            </div>
        </div>
    </div>
    @if (!empty($todayEvents) && count($todayEvents) > 0)
        @foreach ($todayEvents as $todayEvent)
            @include('FrontEnd.events.partials.event-card', ['event' => $todayEvent])
        @endforeach
    @else
        <p>No events available.</p>
    @endif
</div>
<div class="row g-4 mb-3">
    <div class="col-12">
        <div class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
            <h3 class="mb-0 fw-bold">Tomorrow Events</h3>
            <div class="head-btn">
                <a href="{{ route('events') }}?date_filter[]=tomorrow" class="btn view-btn">View
                    All</a>
            </div>
        </div>
    </div>
    @if (!empty($tomorrowEvents) && count($tomorrowEvents) > 0)
        @foreach ($tomorrowEvents as $tomorrowEvent)
            @include('FrontEnd.events.partials.event-card', [
                'event' => $tomorrowEvent,
            ])
        @endforeach
    @else
        <p>No events available.</p>
    @endif
</div>
<div class="row g-4 mb-3">
    <div class="col-12">
        <div class="event-head position-relative d-flex align-items-center justify-content-between gap-1 py-2">
            <h3 class="mb-0 fw-bold">Upcoming Events</h3>
            <div class="head-btn">
                <a href="{{ route('events') }}?date_filter[]=upcoming" class="btn view-btn">View
                    All</a>
            </div>
        </div>
    </div>
    @if (!empty($upcomingEvents) && count($upcomingEvents) > 0)
        @foreach ($upcomingEvents as $upcomingEvent)
            @include('FrontEnd.events.partials.event-card', [
                'event' => $upcomingEvent,
            ])
        @endforeach
    @else
        <p>No events available.</p>
    @endif
</div>
