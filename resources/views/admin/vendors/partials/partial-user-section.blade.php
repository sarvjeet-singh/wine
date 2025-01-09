<div class="information-box mb-3">
    <div class="info-head p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div class="text-white">Vendor Contact Details</div>
            <input type="hidden" name="user_id" id="user_id"
                value="{{ !empty($vendor->user_id) ? $vendor->user_id : '' }}">
        </div>
    </div>
    <div class="m-3 pb-4">
        <div class="row g-4">
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">eMail Address <small>(Email sent on
                            {{ !empty($vendor->email_sent_at) ? \Carbon\Carbon::parse($vendor->email_sent_at)->format('M d, Y H:i A') : 'N/A' }})</small></label>
                    <input type="email" autocomplete="off" class="form-control @error('email') is-invalid @enderror"
                        name="email" id="email" placeholder="eMail Address"
                        value="{{ old('email', $vendor->user->email ?? '') }}" {{ !empty($vendor->user_id) ? '' : '' }}>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Vendor Phone Number</label>
                    <input type="text" class="form-control phone-number @error('phone') is-invalid @enderror"
                        id="phone" name="phone" placeholder="Business/Vendor Phone"
                        value="{{ old('phone', $vendor->user->contact_number ?? '') }}"
                        {{ !empty($vendor->user_id) ? '' : '' }}>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Given Name</label>
                    <input type="text" class="form-control @error('vendor_first_name') is-invalid @enderror"
                        name="vendor_first_name" id="vendor_first_name" placeholder="Given Name(s)"
                        value="{{ old('vendor_first_name', $vendor->user->firstname ?? '') }}"
                        {{ !empty($vendor->user_id) ? '' : '' }}>
                    @error('vendor_first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Last Name</label>
                    <input type="text" class="form-control @error('vendor_last_name') is-invalid @enderror"
                        name="vendor_last_name" id="vendor_last_name" placeholder="Last/Surname"
                        value="{{ old('vendor_last_name', $vendor->user->lastname ?? '') }}"
                        {{ !empty($vendor->user_id) ? '' : '' }}>
                    @error('vendor_last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <label for="" class="form-label fw-bold">Custom Password</small></label>
                    <input type="password" autocomplete="off" class="form-control" name="custom_password"
                        id="custom_password" placeholder="Enter password">
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('asset/js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#phone').mask('000-000-0000');
        });
        $('#email').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '/get-email-suggestions',
                    method: 'GET',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                var email = ui.item.value; // Get selected email
                $.ajax({
                    url: '/get-user-by-email', // Your backend URL for fetching vendor data by email
                    method: 'GET',
                    data: {
                        email: email
                    },
                    success: function(response) {
                        if (response.success) {
                            // Populate form fields with the returned vendor data
                            $('#vendor_first_name').val(response.user.first_name);
                            $('#vendor_last_name').val(response.user.last_name);
                            $('#phone').val(response.user.phone);
                            $('#user_id').val(response.user.id);

                            // Populate other fields as necessary
                        } else {
                            // alert(response.message); // Show error message if vendor not found
                        }
                    }
                });
            }
        });
    </script>
@endpush
