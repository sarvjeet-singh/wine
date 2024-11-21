@extends('VendorDashboard.layouts.vendorapp')



@section('title', 'Wine Country Weekends - Winery Shop')



@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <h2>Manage Subscription</h2>

                <div id="subscription-info">
                    <p><strong>Current Plan:</strong> {{ $subscription->stripe_plan_id ?? 'None' }}</p>
                    <p><strong>Status:</strong> {{ $subscription->status ?? 'Inactive' }}</p>
                    <p><strong>Expires On:</strong>
                        {{ $subscription->end_date ? $subscription->end_date->format('Y-m-d') : 'N/A' }}</p>
                </div>

                <div class="mt-4">
                    <h4>Actions</h4>
                    <button id="change-subscription-btn" class="btn btn-primary">Change Subscription</button>
                    <button id="cancel-subscription-btn" class="btn btn-danger">Cancel Subscription</button>
                </div>

                <!-- Modal for changing subscription -->
                <div class="modal" id="changeSubscriptionModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Change Subscription</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="change-subscription-form">
                                    <div class="form-group">
                                        <label for="new-plan-id">Select New Plan</label>
                                        <select class="form-control" id="new-plan-id" required>
                                            <option value="basic-plan-id">Basic Plan - $10/month</option>
                                            <option value="premium-plan-id">Premium Plan - $20/month</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Change Subscription</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#change-subscription-btn').on('click', function() {
                $('#changeSubscriptionModal').modal('show');
            });

            $('#change-subscription-form').on('submit', function(event) {
                event.preventDefault();
                const newPlanId = $('#new-plan-id').val();

                $.ajax({
                    url: '{{ route('subscription.change') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        vendor_id: '{{ $vendorId }}', // Pass the vendor ID
                        new_plan_id: newPlanId
                    },
                    success: function(response) {
                        $('#subscription-info').html(response.subscriptionInfoHtml);
                        $('#changeSubscriptionModal').modal('hide');
                        alert('Subscription changed successfully!');
                    },
                    error: function(xhr) {
                        alert('Error changing subscription: ' + xhr.responseJSON.message);
                    }
                });
            });

            $('#cancel-subscription-btn').on('click', function() {
                if (confirm('Are you sure you want to cancel your subscription?')) {
                    $.ajax({
                        url: '{{ route('subscription.cancel') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#subscription-info').html(response.subscriptionInfoHtml);
                            alert('Subscription canceled successfully!');
                        },
                        error: function(xhr) {
                            alert('Error canceling subscription: ' + xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
@endsection
