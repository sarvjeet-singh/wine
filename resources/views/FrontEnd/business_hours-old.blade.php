<div class="modal-header">

    <h2 class="modal-title fs-6" id="hoursModal">{{ $vendor->vendor_name }}</h2>

    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

        <i class="fa-solid fa-xmark"></i>

    </button>

</div>

<div class="modal-body">

    <h3 class="text-center mb-3 fs-6">

        <span class="d-block theme-color fw-bold fs-5 text-uppercase">

            @php

                $openNow = false;

                $closingTime = null;

                $currentTime = \Carbon\Carbon::now();

            @endphp



            @foreach ($businessHours as $hour)
                @if ($hour->day == $currentDay)
                    @php
                        $openTime = null;
                        $closeTime = null;
                        if (!empty($hour->opening_time)) {
                            $openTime = \Carbon\Carbon::createFromFormat('H:i:s', $hour->opening_time);
                        }
                        if (!empty($hour->closing_time)) {
                            $closeTime = \Carbon\Carbon::createFromFormat('H:i:s', $hour->closing_time);
                        }

                        $closingTime = $closeTime;

                        $openNow = $currentTime->between($openTime, $closeTime);

                    @endphp
                @endif
            @endforeach



            @if ($openNow)
                Open Now
            @else
                Closed
            @endif

        </span>
        @if ($closingTime)
            Closes at {{ $closingTime ? $closingTime->format('h:i A') : 'N/A' }}
        @endif

    </h3>

    <ul class="list-unstyled mb-0">

        @foreach ($businessHours as $hour)
            <li @if ($hour->day == \Carbon\Carbon::now()->format('l')) class="active" @endif>

                <span class="weekday">{{ $hour->day }}</span>

                <span class="avail">

                    @if ($hour->is_open == 0)
                        Closed
                    @else
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $hour->opening_time)->format('h:i A') }} -

                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $hour->closing_time)->format('h:i A') }}
                    @endif

                </span>

            </li>
        @endforeach

    </ul>

</div>
