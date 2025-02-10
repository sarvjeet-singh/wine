@extends('VendorDashboard.layouts.vendorapp')

@section('title', 'Wine Country Weekends - Vendor Dashboard')

@section('css')
@endsection
@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Access Credentials</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('user.details.update', ['vendorid' => $vendor->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Given Name(s)</label>
                                    <div>
                                        <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                            name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}"
                                            placeholder="Enter first name">
                                        @error('firstname')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Surname / Last Name</label>
                                    <div>
                                        <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                            name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}"
                                            placeholder="Enter last name">
                                        @error('lastname')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">eMail / Username</label>
                                    <div>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ Auth::user()->email }}" placeholder="Enter email address" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <label class="form-label">Contact Phone</label>
                                    <div>
                                        <input type="text"
                                            class="form-control phone-number @error('contact_number') is-invalid @enderror"
                                            name="contact_number"
                                            value="{{ old('contact_number', Auth::user()->contact_number) }}"
                                            placeholder="Enter Phone number">
                                        @error('contact_number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Add Account Btn Section -->
                            {{-- <div class="row mt-3">
                                            <div class="col-12 text-end">
                                                <a href="#" id="toggle-form" class="btn wine-btn">Add Account</a>
                                            </div>
                                        </div> --}}
                            {{-- <div id="form-container">
                                            <form id="account-form" style="display: none;">
                                                <div class="row mt-3">
                                                    <div class="col-sm-6 col-12">
                                                        <label class="form-label">Given Name(s)</label>
                                                        <input type="text" class="form-control" name="firstname"
                                                            value="{{ Auth::user()->firstname }}" placeholder="Enter first name">
                                                    </div>
                                                    <div class="col-sm-6 col-12">
                                                        <label class="form-label">Surname / Last Name</label>
                                                        <input type="text" class="form-control" name="lastname"
                                                            value="{{ Auth::user()->lastname }}" placeholder="Enter last name">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-6 col-12">
                                                        <label class="form-label">Title</label>
                                                        <select name="title"
                                                            class="form-control @error('title') is-invalid @enderror">
                                                            <option value="Chief Executive Officer (CEO)"
                                                                @if (old('title') == 'Chief Executive Officer (CEO)') selected @endif>Chief Executive
                                                                Officer (CEO)</option>
                                                            <option value="President"
                                                                @if (old('title') == 'President') selected @endif>President</option>
                                                            <option value="Chief Financial Officer"
                                                                @if (old('title') == 'Chief Financial Officer') selected @endif>Chief Financial
                                                                Officer</option>
                                                            <option value="Chief Information Officer"
                                                                @if (old('title') == 'Chief Information Officer') selected @endif>Chief Information
                                                                Officer</option>
                                                            <option value="Vice-President"
                                                                @if (old('title') == 'Vice-President') selected @endif>Vice-President
                                                            </option>
                                                            <option value="Director"
                                                                @if (old('title') == 'Director') selected @endif>Director</option>
                                                            <option value="Manager"
                                                                @if (old('title') == 'Manager') selected @endif>Manager</option>
                                                            <option value="Chief Marketing Officer"
                                                                @if (old('title') == 'Chief Marketing Officer') selected @endif>Chief Marketing
                                                                Officer</option>
                                                            <option value="Chairman of the Board"
                                                                @if (old('title') == 'Chairman of the Board') selected @endif>Chairman of the
                                                                Board</option>
                                                            <option value="Admin Staff"
                                                                @if (old('title') == 'Admin Staff') selected @endif>Admin Staff</option>
                                                        </select>
                                                        @error('title')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-sm-6 col-12">
                                                        <label class="form-label">Position</label>
                                                        <input type="text" class="form-control" name="position"
                                                            placeholder="Enter Position">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-6 col-12">
                                                        <label class="form-label">eMail / Username</label>
                                                        <input type="text" class="form-control" name="email"
                                                            value="{{ Auth::user()->email }}" placeholder="Enter email address">
                                                    </div>
                                                    <div class="col-sm-6 col-12">
                                                        <label class="form-label">Contact Phone</label>
                                                        <input type="text" class="form-control phone-number" name="contact_number"
                                                            value="{{ Auth::user()->contact_number }}"
                                                            placeholder="Enter Phone number">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-6 col-12">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" class="form-control" placeholder="Password">
                                                    </div>
                                                    <div class="col-sm-6 col-12">
                                                        <label class="form-label">Confirm Password</label>
                                                        <input type="password" class="form-control" placeholder="Confirm Password">
                                                    </div>
                                                </div>
                                                <!-- <div class="row mt-5">
                                                            <div class="col-sm-12 text-center">
                                                                <button type="submit" class="btn wine-btn">Update</button>
                                                            </div>
                                                        </div>  -->
                                            </form>
                                        </div> --}}
                            <!-- /Add Account Btn Section -->
                            <div class="row mt-5">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn wine-btn">Update</button>
                                    {{-- <button type="button" id="delete-form" class="btn btn-danger">Delete</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('.phone-number').on('input', function() {
            const $input = $(this);
            const cursorPosition = $input.prop('selectionStart');
            const rawValue = $input.val().replace(/\D/g, ''); // Remove all non-digit characters
            let formattedValue = '';

            // Format the phone number
            if (rawValue.length > 3 && rawValue.length <= 6) {
                formattedValue = rawValue.slice(0, 3) + '-' + rawValue.slice(3);
            } else if (rawValue.length > 6) {
                formattedValue =
                    rawValue.slice(0, 3) +
                    '-' +
                    rawValue.slice(3, 6) +
                    '-' +
                    rawValue.slice(6, 10);
            } else {
                formattedValue = rawValue;
            }

            // Update the input value
            $input.val(formattedValue);

            // Restore cursor position
            const adjustedPosition =
                cursorPosition + (formattedValue.length - rawValue.length);
            $input[0].setSelectionRange(adjustedPosition, adjustedPosition);
        });
    });
</script>
@endsection
