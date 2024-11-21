@extends('VendorDashboard.layouts.vendorapp')



@section('title', 'Wine Country Weekends - Winery Shop')



@section('content')
    <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">
                <div class="information-box">
                    <div class="information-box-head">
                        <div class="box-head-heading d-flex">
                            <span class="box-head-label theme-color">Subscription Plans</span>
                        </div>
                    </div>
                    <div class="information-box-body">
                        <div class="subscription-plan-sec my-4">
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6">
                                    <div class="plan-inner bg-white p-3">
                                        <h3 class="fw-bold fs-5 text-center theme-color">Monthly</h3>
                                        <h2 class="fw-bold text-center">$769.00</h2>
                                        <span class="d-block fw-normal fs-6 mt-2 text-center">12 Payments</span>
                                        <span class="d-block fw-normal fs-7 mb-3 text-center fst-italic">Equivalent to
                                            $9228/yr</span>
                                        <p class="fw-bold mb-2">What Winery Vendor Gets:</p>
                                        <ul class="list-unstyled p-0 mb-4">
                                            <li class="position-relative mb-2">Profile Upgraded to Full
                                                <ul>
                                                    <li class="p-0">Media Gallery</li>
                                                    <li class="p-0">Dedicated Vendor Page</li>
                                                    <li class="p-0">Own Payment Gateway</li>
                                                </ul>
                                            </li>
                                            <li class="position-relative mb-2">Products Listed in B2B Wine Catalogue</li>
                                            <li class="position-relative mb-2">Product Placement w/ Resellers</li>
                                            <li class="position-relative mb-2">Product(s) Featured on Wine Menus Inserts
                                            </li>
                                            <li class="position-relative mb-2">30 sec. Promotional Video</li>
                                        </ul>
                                        <div class="buy-btn text-center">
                                            @if ($activeSubscription && env('PLAN_STRIPE_PRICE_ID_MONTHLY') == $activeSubscription['stripe_price_id'])
                                                <button type="button" class="btn btn-primary">Active Plan</button>
                                                <button class="cancel-subscription-btn btn btn-danger" data-subscription-id="{{ $activeSubscription->stripe_subscription_id }}">
                                                    Cancel Subscription
                                                </button>
                                            @else
                                                <a href="javascript:void(0)" data-id="Monthly"
                                                    data-price-id="{{ env('PLAN_STRIPE_PRICE_ID_MONTHLY') }}"
                                                    class="btn wine-btn px-5">Buy Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="plan-inner bg-white p-3">
                                        <h3 class="fw-bold fs-5 text-center theme-color">Quarterly</h3>
                                        <h2 class="fw-bold text-center">$2250.00</h2>
                                        <span class="d-block fw-normal fs-6 mt-2 text-center">4 Payments/2.5%</span>
                                        <span class="d-block fw-normal fs-7 mb-3 text-center fst-italic">Equivalent to
                                            $750/month</span>
                                        <p class="fw-bold mb-2">What Winery Vendor Gets:</p>
                                        <ul class="list-unstyled p-0 mb-4">
                                            <li class="position-relative mb-2">Profile Upgraded to Full
                                                <ul>
                                                    <li class="p-0">Media Gallery</li>
                                                    <li class="p-0">Dedicated Vendor Page</li>
                                                    <li class="p-0">Own Payment Gateway</li>
                                                </ul>
                                            </li>
                                            <li class="position-relative mb-2">Products Listed in B2B Wine Catalogue</li>
                                            <li class="position-relative mb-2">Product Placement w/ Resellers</li>
                                            <li class="position-relative mb-2">Product(s) Featured on Wine Menus Inserts
                                            </li>
                                            <li class="position-relative mb-2">30 sec. Promotional Video</li>
                                        </ul>
                                        <div class="buy-btn text-center">
                                            @if ($activeSubscription && env('PLAN_STRIPE_PRICE_ID_QUARTERLY') == $activeSubscription['stripe_price_id'])
                                                <button type="button" class="btn btn-primary">Active Plan</button>
                                                <button class="cancel-subscription-btn btn btn-danger" data-subscription-id="{{ $activeSubscription->stripe_subscription_id }}">
                                                    Cancel Subscription
                                                </button>
                                            @else
                                                <a href="javascript:void(0)" class="btn wine-btn px-5" data-id="Quarterly"
                                                    data-price-id="{{ env('PLAN_STRIPE_PRICE_ID_QUARTERLY') }}">Buy Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="plan-inner bg-white p-3">
                                        <h3 class="fw-bold fs-5 text-center theme-color">Semi-Annual</h3>
                                        <h2 class="fw-bold text-center">$4230.00</h2>
                                        <span class="d-block fw-normal fs-6 mt-2 text-center">2 Payments/8.4%</span>
                                        <span class="d-block fw-normal fs-7 mb-3 text-center fst-italic">Equivalent to
                                            $705/month</span>
                                        <p class="fw-bold mb-2">What Winery Vendor Gets:</p>
                                        <ul class="list-unstyled p-0 mb-4">
                                            <li class="position-relative mb-2">Profile Upgraded to Full
                                                <ul>
                                                    <li class="p-0">Media Gallery</li>
                                                    <li class="p-0">Dedicated Vendor Page</li>
                                                    <li class="p-0">Own Payment Gateway</li>
                                                </ul>
                                            </li>
                                            <li class="position-relative mb-2">Products Listed in B2B Wine Catalogue</li>
                                            <li class="position-relative mb-2">Product Placement w/ Resellers</li>
                                            <li class="position-relative mb-2">Product(s) Featured on Wine Menus Inserts
                                            </li>
                                            <li class="position-relative mb-2">30 sec. Promotional Video</li>
                                        </ul>
                                        <div class="buy-btn text-center">
                                            @if ($activeSubscription && env('PLAN_STRIPE_PRICE_ID_SEMI_ANNUAL') == $activeSubscription['stripe_price_id'])
                                                <button type="button" class="btn btn-primary">Active Plan</button>
                                                <button class="cancel-subscription-btn btn btn-danger" data-subscription-id="{{ $activeSubscription->stripe_subscription_id }}">
                                                    Cancel Subscription
                                                </button>
                                            @else
                                                <a href="javascript:void(0)" data-id="Semi-Annual"
                                                    data-price-id="{{ env('PLAN_STRIPE_PRICE_ID_SEMI_ANNUAL') }}"
                                                    class="btn wine-btn px-5">Buy Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6">
                                    <div class="plan-inner bg-white p-3">
                                        <h3 class="fw-bold fs-5 text-center theme-color">Annual</h3>
                                        <h2 class="fw-bold text-center">$7692.00</h2>
                                        <span class="d-block fw-normal fs-6 mt-2 text-center">1 Payment/17%</span>
                                        <span class="d-block fw-normal fs-7 mb-3 text-center fst-italic">Equivalent to
                                            $641/month</span>
                                        <p class="fw-bold mb-2">What Winery Vendor Gets:</p>
                                        <ul class="list-unstyled p-0 mb-4">
                                            <li class="position-relative mb-2">Profile Upgraded to Full
                                                <ul>
                                                    <li class="p-0">Media Gallery</li>
                                                    <li class="p-0">Dedicated Vendor Page</li>
                                                    <li class="p-0">Own Payment Gateway</li>
                                                </ul>
                                            </li>
                                            <li class="position-relative mb-2">Products Listed in B2B Wine Catalogue</li>
                                            <li class="position-relative mb-2">Product Placement w/ Resellers</li>
                                            <li class="position-relative mb-2">Product(s) Featured on Wine Menus Inserts
                                            </li>
                                            <li class="position-relative mb-2">30 sec. Promotional Video</li>
                                        </ul>
                                        <div class="buy-btn text-center">
                                            @if ($activeSubscription && env('PLAN_STRIPE_PRICE_ID_ANNUAL') == $activeSubscription['stripe_price_id'])
                                                <button type="button" class="btn btn-primary">Active Plan</button>
                                                <button class="cancel-subscription-btn btn btn-danger" data-subscription-id="{{ $activeSubscription->stripe_subscription_id }}">
                                                    Cancel Subscription
                                                </button>
                                            @else
                                                <a href="javascript:void(0)" class="btn wine-btn px-5" data-id="Annual"
                                                    data-price-id="{{ env('PLAN_STRIPE_PRICE_ID_ANNUAL') }}">Buy Now</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col right-side">
        <div class="row">
            <div class="col-sm-12">

                <h1>Choose a Subscription Plan</h1>

                <div class="plans">
                    @foreach ($products->data as $product)
                        <div class="plan">
                            <h2 class="plan-title">{{ $product->name }}</h2>
                            <p>{{ $product->description }}</p>

                            @if ($product->default_price)
                                @php
                                    $price = $product->default_price->unit_amount / 100; // Stripe stores amounts in cents
                                    $currency = strtoupper($product->default_price->currency);
                                @endphp
                                <div class="plan-price">
                                    ${{ number_format($price, 2) }} {{ $currency }} /
                                    {{ $product->default_price->recurring->interval }}
                                </div>
                            @endif

                            <a href="{{ url('/subscribe/' . $vendorid . '/?price_id=' . $product->default_price->id) }}"
                                class="subscribe-button">Subscribe Now</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Modal -->
    <div class="modal fade" id="stripeModal" tabindex="-1" aria-labelledby="stripeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stripeModalLabel">Complete Your Subscription</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><b>Plan Name</b>: <span id="plan-name"></span></p>
                    <p><b>Plan Price</b>: $<span id="plan-price"></span></p>
                    <form id="payment-form">
                        <div id="payment-element"><!-- Stripe payment field will be inserted here --></div>
                        <button id="submit" style="width: 100%;" class="btn wine-btn mt-3">Subscribe</button>
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">Cancel</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        let elements, clientSecret;

        // jQuery document ready
        $(document).ready(function() {
            // "Buy Now" button click event
            $('.buy-btn a').on('click', function() {
                // Get the subscribe button and add a loading spinner
                var $this = $(this);
                $this.prop('disabled', true); // Disable the button to prevent multiple clicks
                $this.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                ); // Show spinner

                // Fetch the Payment Intent client secret
                $.ajax({
                    url: '{{ route('subscription.createPaymentIntent', ['vendorid' => $vendorid]) }}',
                    type: 'POST',
                    data: {
                        price_id: $(this).data('price-id'),
                        plan: $(this).data('id'),
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        clientSecret = response.clientSecret;
                        subscriptionId = response.subscription_id;

                        // Initialize Stripe Elements
                        elements = stripe.elements({
                            clientSecret
                        });
                        const paymentElement = elements.create('payment');
                        paymentElement.mount('#payment-element');
                        $('#plan-name').text(response.plan);
                        $('#plan-price').text(parseFloat(response.price).toFixed(2));
                        // Show the modal using Bootstrap's modal method
                        $('#stripeModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        // Use SweetAlert2 for error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: 'Failed to create Payment Intent. Please try again.',
                            confirmButtonText: 'Okay'
                        });

                        // Re-enable the button and reset its content
                        $this.prop('disabled', false);
                        $this.html('Buy Now'); // Reset button text
                    },
                    complete: function() {
                        // Re-enable the button and reset its content on completion
                        $this.prop('disabled', false);
                        $this.html('Buy Now'); // Reset button text
                    }
                });
            });

            // Form submission for payment
            $('#payment-form').on('submit', function(event) {
                event.preventDefault();
                var $this = $(this);
                $('#submit').prop('disabled', true); // Disable the button to prevent multiple clicks
                $('#submit').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                ); // Show spinner
                stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: '{{ route('subscription.index') }}',
                    },
                }).then(function(result) {
                    if (result.error) {
                        // alert(result.error.message);
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: result.error.message,
                            confirmButtonText: 'Okay'
                        });
                        $('#submit').prop('disabled', false);
                        $('#submit').html('Subscribe'); // Reset button text
                    }
                    $('#submit').prop('disabled', false);
                    $('#submit').html('Subscribe'); // Reset button text
                });
            });
        });

        // Close modal button
        $('#closeModal').on('click', function() {
            $('#stripeModal').modal('hide');
        });
        // On click of the cancel button
        $('.cancel-subscription-btn').on('click', function() {
            const subscriptionId = $(this).data(
            'subscription-id'); // Get the subscription ID from the button's data attribute

            // Confirm cancellation with the user
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this subscription!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make the AJAX request to cancel the subscription
                    $.ajax({
                        url: '{{ route('subscription.cancel', ['vendorid' => $vendorid]) }}',
                        type: 'POST',
                        data: {
                            subscription_id: subscriptionId,
                            _token: $('meta[name="csrf-token"]').attr(
                                'content') // CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Canceled!',
                                text: response.message,
                                confirmButtonText: 'Okay'
                            }).then(() => {
                                // Optionally refresh the page or redirect the user
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            // Show an error message if the cancellation fails
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: xhr.responseJSON.message ||
                                    'Failed to cancel the subscription.',
                                confirmButtonText: 'Okay'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
