{{-- resources/views/admin/plans/index.blade.php --}}
@extends('admin.layouts.app')
@section('content')
    <div class="main-content-inner">
        <div class="main-head mb-4">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="mb-0">Plan Management</h2>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('admin.plans.create') }}" class="btn btn-primary">Add Plan</a>
                    <a href="{{ route('admin.plans.sync.index') }}" class="btn btn-info">
                        <i class="fas fa-sync-alt"></i> Sync Stripe Plans
                    </a>
                </div>
            </div>
        </div>
        <div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <div class="top-card d-flex align-items-center justify-content-between p-3">
                        <div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"
                                            class="text-decoration-none text-black">Plan Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Plan Listing</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="dropdown">
                                <select class="form-select" name="interval" id="intervalSelect">
                                    <option value="">Select Interval</option>
                                    <option {{ request('interval') == 'day' ? 'selected' : '' }} value="day">Daily
                                    </option>
                                    <option {{ request('interval') == 'week' ? 'selected' : '' }} value="week">Weekly
                                    </option>
                                    <option {{ request('interval') == 'month' ? 'selected' : '' }} value="month">Monthly
                                    </option>
                                    <option {{ request('interval') == 'year' ? 'selected' : '' }} value="year">Yearly
                                    </option>
                                </select>
                            </div>
                            <div class="search-bar position-relative">
                                <input autocomplete="off" value="{{ !empty(request('q')) ? request('q') : '' }}"
                                    type="search" name="search" id="search" placeholder="Search plans...">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="filterPlans()">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <div class="total-user-value">
                                <p class="mb-0 fw-bold">Total Plans: <span>{{ $total }}</span></p>
                            </div>
                        </div>
                    </div>
                    <!-- Table Start -->
                    <div class="table-users">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>Plan Name</th>
                                        <th>Price</th>
                                        <th>Interval</th>
                                        <th>Tax Rates</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($plans) > 0)
                                        @foreach ($plans as $plan)
                                            <tr>
                                                <td>{{ $plan->name }}</td>
                                                <td>{{currency_symbol($plan->currency)}}{{ number_format($plan->price, 2) }}</td>
                                                <td>
                                                    @php
                                                        $intervals = [
                                                            'day' => 'Daily',
                                                            'week' => 'Weekly',
                                                            'month' => 'Monthly',
                                                            'year' => 'Yearly',
                                                        ];

                                                        $interval =
                                                            $intervals[$plan->interval] ?? ucfirst($plan->interval);
                                                    @endphp

                                                    {{ $plan->interval_count > 1
                                                        ? 'Every ' . $plan->interval_count . ' ' . Str::plural($plan->interval, $plan->interval_count)
                                                        : $interval }}
                                                </td>
                                                <td>
                                                    @foreach ($plan->taxes as $tax)
                                                        <span class="badge bg-info">{{ $tax->name }}
                                                            ({{ $tax->percentage }}%)
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td> <span
                                                        class="badge {{ $plan->status ? 'bg-success' : 'bg-danger' }}">{{ $plan->status ? 'Active' : 'Inactive' }}
                                                </td>

                                                <td>{{ $plan->created_at->format('m/d/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('admin.plans.edit', $plan->id) }}">
                                                        <img
                                                            src="{{ asset('asset/admin/images/icons/gray-edit-icon.png') }}" />
                                                    </a>
                                                    <form action="{{ route('admin.plans.destroy', $plan->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this plan?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0">
                                                            <i class="fa-solid fa-trash text-danger"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No Plans Found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-end justify-content-end">
                    {{ $plans->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function filterPlans() {
            let baseUrl = window.location.origin + window.location.pathname;
            let interval = document.getElementById('intervalSelect').value;
            let searchTerm = document.getElementById('search').value;

            let params = new URLSearchParams();

            if (interval) {
                params.append('interval', interval);
            }

            if (searchTerm) {
                params.append('q', searchTerm);
            }

            window.location.href = baseUrl + '?' + params.toString();
        }
    </script>
@endpush
