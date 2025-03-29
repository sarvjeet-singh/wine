@extends('admin.layouts.app')

@section('content')
    <div class="main-content-inner">
        <div class="main-head d-flex align-items-center justify-content-between mb-4">
            <h2 class="mb-0">Vendor Subscriptions</h2>
            <a href="{{ route('admin.vendor.subscriptions.create') }}" class="btn theme-btn text-center py-2 px-4">Add
                Subscription</a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="dashboard-card p-4">
                    <!-- Table Start -->
                    <div class="table-users text-center">
                        <div class="table-responsive w-100">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vendor</th>
                                        <th>Stripe Subscription ID</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($subscriptions as $subscription)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $subscription->vendor->vendor_name ?? 'N/A' }}</td>
                                            <td>{{ $subscription->stripe_subscription_id ?? 'N/A' }}</td>
                                            <td>${{ number_format($subscription->price, 2) }}</td>
                                            <td
                                                class="{{ $subscription->status === 'active' ? 'text-success' : 'text-danger' }}">
                                                {{ ucfirst($subscription->status) }}
                                            </td>
                                            <td>{{ $subscription->start_date }}</td>
                                            <td>{{ $subscription->end_date ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.vendor.subscriptions.edit', $subscription->id) }}"
                                                    class="text-white">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('admin.vendor.subscriptions.destroy', $subscription->id) }}"
                                                    class="delete-form d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-sm delete-subscription">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No subscriptions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Table End -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".delete-subscription").forEach(button => {
                button.addEventListener("click", function() {
                    let form = this.closest("form");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This action cannot be undone!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
    </script>
@endpush
