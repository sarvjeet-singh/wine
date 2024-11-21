@extends('admin.layouts.app')
@section('content')
    <style>
        .error {
            color: red;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <h2 class="mb-0">Account Status</h2>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">Vendor Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Account Status</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="p-3">
                        <form action="{{ route('admin.vendor.update.account.status', $vendor->id) }}" method="POST"
                            id="accountForm">
                            <!-- Account Status Sec Start -->
                            @method('PUT')
                            @csrf
                            <div class="information-box mb-3">
                                <div class="info-head p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="text-white">System Admin</div>
                                    </div>
                                </div>
                                <div class="m-3 pb-4">
                                    @if (session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div><label for="" class="form-label fw-bold">Account Status</label>
                                            </div>
                                            <div class="row g-2">
                                                @foreach ($accountStatuses as $accountstatus)
                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="account_status" id="status_{{ $accountstatus->id }}"
                                                                value="{{ $accountstatus->id }}"
                                                                {{ $vendor->account_status == $accountstatus->id ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="status_{{ $accountstatus->id }}">{{ $accountstatus->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div><label for="" class="form-label fw-bold">Price Point</label></div>
                                            <div class="row g-2">
                                                @foreach ($pricePoints as $pricePoint)
                                                    <div class="col-md-4">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="price_point" id="point_{{ $pricePoint->id }}"
                                                                value="{{ $pricePoint->id }}"
                                                                {{ $vendor->price_point == $pricePoint->id ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="point_{{ $pricePoint->id }}">{{ $pricePoint->name }}</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Account Status Sec End -->
                            <div class="text-center mb-3">
                                <button type="submit" class="btn theme-btn px-5">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize form validation
            $('#accountForm').validate({
                rules: {
                    account_status: {
                        required: true
                    },
                    price_point: {
                        required: true
                    }
                },
                messages: {
                    account_status: {
                        required: "Please select an account status."
                    },
                    price_point: {
                        required: "Please select a price point."
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "account_status") {
                        error.appendTo(element.closest('.row').parent());
                    } else if (element.attr("name") == "price_point") {
                        error.appendTo(element.closest('.row').parent());
                    }
                }
            });
        });
    </script>
@endpush
