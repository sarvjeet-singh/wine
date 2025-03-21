@extends('FrontEnd.layouts.mainapp')

@section('title', 'Wine Country Weekends - Guest Registry')

@section('content')
    <div class="container main-container">
        <div class="row flex-lg-nowrap flex-wrap g-4">
            @include('UserDashboard.includes.leftNav')
            <div class="col right-side">
                <!-- User Emergency Contact Detail Start -->
                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="information-box">
                            <div class="information-box-head">
                                <div class="box-head-heading d-flex">
                                    <span class="box-head-label theme-color">Emergency Contact Details</span>
                                </div>
                            </div>
                            <div class="information-box-body">
                                @if (session('emergency-success'))
                                    <div class="alert alert-success">
                                        {{ session('emergency-success') }}
                                    </div>
                                @endif
                                <form method="post" action="{{ route('user-settings-emergency-update') }}">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <label class="form-label">Medical/Physical Concerns:<span
                                                    class="required-filed">*</span></label>
                                            <textarea class="form-control @error('medical_physical_concerns') is-invalid @enderror" name="medical_physical_concerns"
                                                placeholder="Enter your Medical/Physical Concerns">{{ Auth::user()->medical_physical_concerns }} </textarea>
                                            @error('medical_physical_concerns')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-md-3 mt-1 g-3">
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Contact Name<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                                name="emergency_contact_name"
                                                value="{{ Auth::user()->emergency_contact_name }}"
                                                placeholder="Enter your Contact name">
                                            @error('emergency_contact_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Contact Relation<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('emergency_contact_relation') is-invalid @enderror"
                                                name="emergency_contact_relation"
                                                value="{{ Auth::user()->emergency_contact_relation }}"
                                                placeholder="Enter your contact person relation">
                                            @error('emergency_contact_relation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12 col-12">
                                            <label class="form-label">Phone Number<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control phone-number @error('emergency_contact_phone_number') is-invalid @enderror"
                                                name="emergency_contact_phone_number"
                                                value="{{ Auth::user()->emergency_contact_phone_number }}"
                                                placeholder="Enter your contact person number" id="phone-number">
                                            @error('emergency_contact_phone_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mt-md-3 mt-1 g-3">
                                        <div class="col-md-6 col-12">
                                            <label class="form-label">Alternate Contact Name<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('alternate_contact_full_name') is-invalid @enderror"
                                                name="alternate_contact_full_name"
                                                value="{{ Auth::user()->alternate_contact_full_name }}"
                                                placeholder="Enter your alternate contact name">
                                            @error('alternate_contact_full_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <label class="form-label"> Alternate Contact Relation:<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control @error('alternate_contact_relation') is-invalid @enderror"
                                                name="alternate_contact_relation"
                                                value="{{ Auth::user()->alternate_contact_relation }}"
                                                placeholder="Enter your alter contact relation">
                                            @error('alternate_contact_relation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12 col-12">
                                            <label class="form-label">Alernative Contact Phone<span
                                                    class="required-filed">*</span></label>
                                            <input type="text"
                                                class="form-control phone-number @error('emergency_contact_number') is-invalid @enderror"
                                                name="emergency_contact_number"
                                                value="{{ Auth::user()->emergency_contact_number }}"
                                                placeholder="Enter your alternate contact number">
                                            @error('emergency_contact_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-sm-12 text-center">
                                            <button type="submit" class="btn wine-btn">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- User Emergency Contact Detail End -->
            </div>
        </div>
    </div>
    @include('UserDashboard.includes.logout_modal')
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#phone-number').on('input', function() {
                // Get the current value of the input
                let input = $(this).val();

                // Remove non-digit characters
                input = input.replace(/\D/g, '');

                // Format the input according to 333-333-3333
                if (input.length > 6) {
                    input = input.replace(/(\d{3})(\d{3})(\d{1,4}).*/, '$1-$2-$3');
                } else if (input.length > 3) {
                    input = input.replace(/(\d{3})(\d{1,3})/, '$1-$2');
                }

                // Update the value of the input with the formatted number
                $(this).val(input);
            });
        })
        document.querySelectorAll('.phone-number').forEach(function(input) {
            input.addEventListener('input', function(e) {
                const value = e.target.value.replace(/\D/g, ''); // Remove all non-digit characters
                let formattedValue = '';

                if (value.length > 3 && value.length <= 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3);
                } else if (value.length > 6) {
                    formattedValue = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                } else {
                    formattedValue = value;
                }

                e.target.value = formattedValue;
            });
        });
    </script>
@endsection
