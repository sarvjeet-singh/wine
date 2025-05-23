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

        <div class="event-head d-flex align-items-center justify-content-between gap-1 position-relative">

            <h3 class="mb-0 fs-4">

                {{ count(request('date_filter', [])) === 1 && request('date_filter')[0] != 'date_range' ? ucfirst(request('date_filter')[0]) : 'Filtered' }}
                Events

            </h3>

        </div>

    </div>

    @if (!empty($events) && count($events) > 0)

        @foreach ($events as $event)
            @include('FrontEnd.events.partials.event-card', [
                'event' => $event,
            ])
        @endforeach
    @else
        <p>No events available.</p>

    @endif

</div>
