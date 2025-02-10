@extends('admin.layouts.app')
@section('content')
    <style>
        .error {
            color: red;
            font-size: 14px;
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            border: 1px solid #ddd;
            background: #fff;
            padding: 5px;
            list-style: none;
            position: absolute;
            z-index: 1000;
        }
        .ui-menu-item {
            padding: 5px;
            cursor: pointer;
        }
        .ui-menu-item:hover {
            background-color: #f0f0f0;
        }
    </style>

    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Manage Bottle Bucks</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-black">Bottle Bucks Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Bottle Bucks</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="dashboard-card"></div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.wallet.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="type">Select Type</label>
                                        <select class="form-select" name="type" id="type">
                                            <option value="">Select</option>
                                            <option value="refund" {{ old('type') == 'refund' ? 'selected' : '' }}>Refund Amount</option>
                                            <option value="receipt_amount" {{ old('type') == 'receipt_amount' ? 'selected' : '' }}>Receipt Amount</option>
                                        </select>
                                        @error('type')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="customer_email">Customer Email</label>
                                        <input type="text" id="customer_email" name="customer_email" class="form-control" placeholder="Enter customer email" autocomplete="off">
                                        <input type="hidden" id="customer_id" name="customer_id">
                                        @error('customer_id')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row refund-fields" style="display: none;">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="order_id">Order ID</label>
                                        <input type="number" name="order_id" id="order_id" class="form-control" placeholder="Enter order id" value="{{ old('order_id') }}">
                                        @error('order_id')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row refund-fields" style="display: none;">
                                <div class="col-sm-12 col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" value="{{ old('amount') }}">
                                        @error('amount')
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        function toggleRefundFields() {
            if ($('#type').val() === 'refund') {
                $('.refund-fields').show();
            } else {
                $('.refund-fields').hide();
            }
        }

        $('#type').on('change', toggleRefundFields);
        toggleRefundFields(); // Apply correct state on page load

        $(document).ready(function() {
            $("#customer_email").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('admin.customer.search') }}",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response($.map(data, function(item) {
                                return {
                                    label: item.email + " (" + item.firstname + " " + item.lastname + ")",
                                    value: item.email,
                                    id: item.id
                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $("#customer_id").val(ui.item.id);
                }
            });
        });
    </script>
@endpush
