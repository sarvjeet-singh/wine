@extends('VendorDashboard.layouts.vendorapp')



@section('title', 'Wine Country Weekends - Guest Registry')



@section('content')

    <div class="col right-side">

        <div class="row mt-5">

            <div class="information-box p-0">

                <div class="information-box-head">

                    <div class="box-head-heading d-flex">

                        <span class="box-head-label theme-color">Business Hours</span>

                    </div>

                </div>

                <div class="information-box-body hours-operation-sec">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form id="business-hours-form" action="{{ route('business-hours.update', $vendor_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                            <?php
                            $savedHour = $businessHours->where('day', ucfirst($day))->first();
                            $openingTime = isset($savedHour->opening_time) ? \Carbon\Carbon::parse($savedHour->opening_time)->format('H:i') : '';
                            $closingTime = isset($savedHour->closing_time) ? \Carbon\Carbon::parse($savedHour->closing_time)->format('H:i') : '';
                            ?>
                            <div class="weekdays-main mb-3 d-flex align-items-center gap-5 bussines_days_box">
                                <div class="w-25">
                                    <p class="mb-0 fw-bold">{{ ucfirst($day) }}</p>
                                </div>
                                <div class="form-check form-switch p-0 d-flex align-items-center gap-2 w-25">
                                    <input role="switch" type="checkbox" class="form-check-input m-0 bussines_days"
                                        name="hours[{{ $day }}][is_open]" id="{{ $day }}Checkbox"
                                        value="1" {{ isset($savedHour) && $savedHour->is_open ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $day }}Checkbox">
                                        <span
                                            id="{{ $day }}Status">{{ isset($savedHour) && $savedHour->is_open ? 'Open' : 'Closed' }}</span>
                                    </label>
                                </div>
                                <div class="w-50">
                                    <div class="row open_close_time">
                                        <div class="col-sm-6">
                                            <input type="time" value="{{ $openingTime }}"
                                                id="{{ $day }}_opening_time" class="open_time"
                                                name="hours[{{ $day }}][opening_time]">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="time" value="{{ $closingTime }}"
                                                id="{{ $day }}_closing_time" class="close_time"
                                                name="hours[{{ $day }}][closing_time]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <button type="submit" id="save-button" class="btn btn-primary">Save</button>
                    </form>
                </div>

            </div>

        </div>

    </div>

@endsection

@section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('business-hours-form');
            const saveButton = document.getElementById('save-button');

            // Disable Save button on form submission to prevent multiple submissions
            form.addEventListener('submit', function() {
                saveButton.disabled = true;
                saveButton.innerText = 'Saving...';
            });

            // Check all checkboxes and time fields for each day
            const checkboxes = document.querySelectorAll('.bussines_days');
            checkboxes.forEach(checkbox => {
                const day = checkbox.id.replace('Checkbox', '');
                const openingTimeInput = document.getElementById(`${day}_opening_time`);
                const closingTimeInput = document.getElementById(`${day}_closing_time`);
                const statusText = document.getElementById(`${day}Status`);

                // Function to toggle checkbox state and label text
                function toggleCheckboxState() {
                    if (openingTimeInput.value && closingTimeInput.value) {
                        checkbox.disabled = false; // Enable the checkbox
                    } else {
                        checkbox.checked = false; // Uncheck if time is incomplete
                        checkbox.disabled = true; // Disable the checkbox
                    }

                    // Update status text based on whether checkbox is checked
                    statusText.textContent = checkbox.checked ? 'Open' : 'Closed';
                }

                // Run initially to set the correct state on page load
                toggleCheckboxState();

                // Add event listeners to monitor changes in time inputs and checkbox
                openingTimeInput.addEventListener('input', toggleCheckboxState);
                closingTimeInput.addEventListener('input', toggleCheckboxState);
                checkbox.addEventListener('change', function() {
                    statusText.textContent = checkbox.checked ? 'Open' : 'Closed';
                });
            });
        });
    </script>

@endsection
