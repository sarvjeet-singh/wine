@extends('VendorDashboard.layouts.vendorapp')







@section('title', 'Wine Country Weekends - Cart')







@section('content')

    <style>
        .error {

            color: red;

            font-size: 14px;

        }
    </style>

    <div class="col right-side">



        <div class="row">

            <div class="col-sm-12">

                <div class="information-box p-0">

                    <div class="information-box-head d-flex align-items-center gap-3">
                        <button class="btn back-btn d-flex align-items-center p-0" onclick="window.history.back()">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <div class="box-head-heading">
                            <span class="box-head-label theme-color fw-bold">Checkout</span>
                        </div>

                    </div>

                    <div class="information-box-body">

                        <div class="cart-sec px-xl-5 py-xl-4 py-2">

                            <div class="row">

                                <div class="col-md-8">

                                    <form method="post" id="checkout-form" enctype="multipart/form-data"
                                        action="{{ route('winery.checkout-post', ['shopid' => $shopid, 'vendorid' => $vendorid]) }}">

                                        @csrf

                                        <div class="checkout-address-sec p-4">

                                            <div class="mb-5">

                                                <h4>Vendor Details - {{ $vendor->vendor_name }}</h4>

                                            </div>

                                            <!-- Shipping Address Start -->

                                            <div class="shipping-address mb-5">

                                                <div class="sec-head border-bottom mb-3">

                                                    <h3 class="fs-5 fw-bold mb-3">Shipping Address</h3>

                                                </div>

                                                <div class="row g-sm-3 g-2 mb-3">

                                                    <div class="col-md-6">

                                                        <label for="shipping_first_name" class="form-label fw-bold">Contact

                                                            First

                                                            Name*</label>

                                                        <input type="text" id="shipping_first_name"
                                                            name="shipping_first_name"
                                                            value="{{ old('shipping_first_name') }}" class="form-control"
                                                            placeholder="First Name" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="shipping_last_name" class="form-label fw-bold">Contact

                                                            Last

                                                            Name*</label>

                                                        <input type="text" id="shipping_last_name"
                                                            name="shipping_last_name"
                                                            value="{{ old('shipping_last_name') }}" class="form-control"
                                                            placeholder="Last Name" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="shipping_phone"
                                                            class="form-label fw-bold">Phone*</label>

                                                        <input type="text" id="shipping_phone" name="shipping_phone"
                                                            value="{{ old('shipping_phone') }}" class="form-control"
                                                            placeholder="Phone" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="shipping_email" class="form-label fw-bold">Email

                                                            Address*</label>

                                                        <input type="text" id="shipping_email" name="shipping_email"
                                                            value="{{ old('shipping_email') }}" class="form-control"
                                                            placeholder="Email Address" id="">

                                                    </div>

                                                    <div class="col-12">

                                                        <div class="mb-1">

                                                            <label for="shipping_street" class="form-label fw-bold">Street

                                                                Address*</label>

                                                            <input type="text" id="shipping_street"
                                                                name="shipping_street" value="{{ old('shipping_street') }}"
                                                                class="form-control" placeholder="Address 1" id="">

                                                        </div>

                                                        <div class="mb-1">

                                                            <input type="text" id="shipping_street2"
                                                                name="shipping_street2"
                                                                value="{{ old('shipping_street2') }}" class="form-control"
                                                                placeholder="Address 2" id="">

                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label for="shipping_city"
                                                            class="form-label fw-bold">City/Town*</label>

                                                        <input type="text" id="shipping_city" name="shipping_city"
                                                            value="{{ old('shipping_city') }}" class="form-control"
                                                            placeholder="Ontario" id="">

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label for="shipping_unit"
                                                            class="form-label fw-bold">Unit/Suite#</label>

                                                        <input type="text" id="shipping_unit" name="shipping_unit"
                                                            value="{{ old('shipping_unit') }}" class="form-control"
                                                            placeholder="Unit/Suite#" id="">

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label for="shipping_state"
                                                            class="form-label fw-bold">Province/State*</label>

                                                        <input type="text" id="shipping_state" name="shipping_state"
                                                            value="{{ old('shipping_state') }}" class="form-control"
                                                            placeholder="L6H 1H4" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="shipping_postal_code"
                                                            class="form-label fw-bold">Postal/Zip*</label>

                                                        <input type="text" id="shipping_postal_code"
                                                            name="shipping_postal_code"
                                                            value="{{ old('shipping_postal_code') }}"
                                                            class="form-control" placeholder="Ontario" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="shipping_country"
                                                            class="form-label fw-bold">Country</label>

                                                        <input type="text" id="shipping_country"
                                                            name="shipping_country" value="{{ old('shipping_country') }}"
                                                            class="form-control" placeholder="L6H 1H4" id="">

                                                    </div>

                                                </div>

                                            </div>

                                            <!-- Shipping Address End -->



                                            <!-- Billing Address Start -->

                                            <div class="billing-address mb-5">

                                                <div
                                                    class="sec-head border-bottom mb-3 d-flex justify-content-between align-items-center">

                                                    <h3 class="fs-5 fw-bold mb-3">Billing Address</h3>

                                                    <div id="same_as_shipping_container">

                                                        <input type="checkbox" id="same_as_shipping"
                                                            class="form-check-input">

                                                        <label for="same_as_shipping" class="form-check-label">Same as

                                                            Shipping Address</label>

                                                    </div>

                                                </div>

                                                <div class="row g-sm-3 g-2 mb-3">

                                                    <div class="col-md-6">

                                                        <label for="billing_first_name" class="form-label fw-bold">First

                                                            Name*</label>

                                                        <input type="text" id="billing_first_name"
                                                            name="billing_first_name"
                                                            value="{{ old('billing_first_name') }}" class="form-control"
                                                            placeholder="First Name" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="billing_last_name" class="form-label fw-bold">Last

                                                            Name*</label>

                                                        <input type="text" id="billing_last_name"
                                                            name="billing_last_name"
                                                            value="{{ old('billing_last_name') }}" class="form-control"
                                                            placeholder="Last Name" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="billing_phone"
                                                            class="form-label fw-bold">Phone*</label>

                                                        <input type="text" id="billing_phone" name="billing_phone"
                                                            value="{{ old('billing_phone') }}" class="form-control"
                                                            placeholder="Phone" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="billing_email" class="form-label fw-bold">Email

                                                            Address*</label>

                                                        <input type="text" id="billing_email" name="billing_email"
                                                            value="{{ old('billing_email') }}" class="form-control"
                                                            placeholder="Email Address" id="">

                                                    </div>

                                                    <div class="col-12">

                                                        <div class="mb-1">

                                                            <label for="billing_street" class="form-label fw-bold">Street

                                                                Address*</label>

                                                            <input type="text" id="billing_street"
                                                                name="billing_street" value="{{ old('billing_street') }}"
                                                                class="form-control" placeholder="Address 1"
                                                                id="">

                                                        </div>

                                                        <div class="mb-1">

                                                            <input type="text" id="billing_street2"
                                                                name="billing_street2"
                                                                value="{{ old('billing_street2') }}" class="form-control"
                                                                placeholder="Address 2" id="">

                                                        </div>

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label for="billing_city"
                                                            class="form-label fw-bold">City/Town*</label>

                                                        <input type="text" id="billing_city" name="billing_city"
                                                            value="{{ old('billing_city') }}" class="form-control"
                                                            placeholder="City/Town" id="">

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label for="billing_unit"
                                                            class="form-label fw-bold">Unit/Suite#</label>

                                                        <input type="text" id="billing_unit" name="billing_unit"
                                                            value="{{ old('billing_unit') }}" class="form-control"
                                                            placeholder="Unit/Suite#" id="">

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label for="billing_state"
                                                            class="form-label fw-bold">Province/State*</label>

                                                        <input type="text" id="billing_state" name="billing_state"
                                                            value="{{ old('billing_state') }}" class="form-control"
                                                            placeholder="Enter state" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="billing_postal_code"
                                                            class="form-label fw-bold">Postal/Zip*</label>

                                                        <input type="text" id="billing_postal_code"
                                                            name="billing_postal_code"
                                                            value="{{ old('billing_postal_code') }}" class="form-control"
                                                            placeholder="Enter Zip code" id="">

                                                    </div>

                                                    <div class="col-md-6">

                                                        <label for="billing_country"
                                                            class="form-label fw-bold">Country</label>

                                                        <input type="text" id="billing_country" name="billing_country"
                                                            value="{{ old('billing_country') }}" class="form-control"
                                                            placeholder="Enter Country" id="">

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                                <div class="col-md-4">

                                    <div class="sticky-top">

                                        <!-- Billing Summary -->
                                        <form id="delivery-form">
                                            <div class="cart-box p-4 mb-3">
                                                <h4>Pickup or Delivery</h4>
                                                <div class="border-top pt-3 mt-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" required
                                                            name="delivery_type" id="pickup" value="pickup">
                                                        <label class="form-check-label" for="pickup">Pick Up</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" required
                                                            name="delivery_type" id="delivery" value="delivery">
                                                        <label class="form-check-label" for="delivery">Delivery</label>
                                                    </div>
                                                    <div id="deliveryTypeError"></div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="cart-box p-4 mb-3">

                                            <h4>Summary</h4>

                                            <div class="subtotal-count pt-3 mt-3">

                                                <div class="d-flex align-items-center justify-content-between mb-2">

                                                    <span>Subtotal</span>

                                                    <span>${{ $cartTotal }}</span>

                                                </div>
                                                @if ($deliveryFee > 0)
                                                    <div id="deliveryCharges">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2">

                                                            <span>Delivery Charges</span>

                                                            <span>${{ $deliveryFee }}</span>

                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="d-flex align-items-center justify-content-between mb-2">

                                                    <span>Total</span>

                                                    <span id="total_amount">${{ $cartTotal }}</span>

                                                </div>

                                            </div>

                                        </div>



                                        <!-- Checkout Payment -->

                                        <div class="cart-box p-4">

                                            <h4 class="fw-bold">Checkout Payment Form</h4>

                                            <div class="checkout-box border-top mt-3 pt-3">

                                                <form action="">

                                                    <div class="row g-sm-3 g-2">

                                                        <div id="card-container">

                                                            <div class="row">

                                                                <div class="col-12">

                                                                    <div id="card-errors" style="color:red"></div>

                                                                </div>

                                                            </div>

                                                            <div class="mb-2">

                                                                <label for="cc-name">Card Holder Name</label>

                                                                <input type="text" class="form-control mt-2" id="cc-name"
                                                                    placeholder="Card Holder Name">

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-12 col-md-12">

                                                                    <div class="form-floating mb-2">

                                                                        <div id="cc-number"></div>

                                                                        <label for="cc-number">Card number</label>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div class="row">

                                                                <div class="col-md-6">

                                                                    <div class="form-floating">

                                                                        <div id="cc-expiry"></div>

                                                                        <label for="cc-expiry">MM/AA</label>

                                                                    </div>

                                                                </div>

                                                                <div class="col-md-6">

                                                                    <div class="form-floating">

                                                                        <div id="cc-cvc"></div>

                                                                        <label for="cc-cvc">CVV</label>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="col-12">

                                                            <button id="pay-button" type="button"
                                                                class="btn book-btn wine-btn w-100 text-uppercase mt-2"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#tyModal">Pay</button>

                                                        </div>

                                                    </div>

                                                </form>

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

    </div>

@endsection



@section('js')

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script src="https://js.stripe.com/v3/"></script>

    <script>
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");

        var elements = stripe.elements();

        var style = {

            // base: {

            //     border: '1px solid #E8E8E8',

            // },

        };



        var cardNumber = elements.create('cardNumber', {

            style: style,

            classes: {

                base: 'form-control w-full'

            }

        });



        var cardExpiry = elements.create('cardExpiry', {

            style: style,

            classes: {

                base: 'form-control'

            }

        });



        var cardCvc = elements.create('cardCvc', {

            style: style,

            classes: {

                base: 'form-control'

            }

        });







        cardNumber.mount('#cc-number');

        cardExpiry.mount('#cc-expiry');

        cardCvc.mount('#cc-cvc');
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#billing_phone').mask('000-000-0000');

            $('#shipping_phone').mask('000-000-0000');

        });

        $.validator.addMethod("phoneUS", function(value, element) {

            // This regular expression matches the format 000-000-0000

            return this.optional(element) || /^\d{3}-\d{3}-\d{4}$/.test(value);

        }, "Please enter a valid phone number in the format 000-000-0000.");
    </script>

    <script>
        $(document).ready(function() {

            // Initialize form validation
            $("#delivery-form").validate({
                rules: {
                    delivery_type: {
                        required: true
                    }
                },
                messages: {
                    delivery_type: {
                        required: "Please select either Pick Up or Delivery."
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "delivery_type") {
                        $("#deliveryTypeError").append(error);
                    } else {
                        error.insertAfter(element); // Default error placement for other elements
                    }
                }
            });

            $("#checkout-form").validate({

                rules: {

                    // Shipping Address

                    shipping_first_name: {

                        required: true,

                        minlength: 2

                    },

                    shipping_last_name: {

                        required: true,

                        minlength: 2

                    },

                    shipping_phone: {

                        required: true,

                        phoneUS: true

                    },

                    shipping_email: {

                        required: true,

                        email: true

                    },

                    shipping_street: "required",

                    shipping_city: "required",

                    shipping_state: "required",

                    shipping_postal_code: {

                        required: true,

                        minlength: 5

                    },

                    // Billing Address

                    billing_first_name: {

                        required: true,

                        minlength: 2

                    },

                    billing_last_name: {

                        required: true,

                        minlength: 2

                    },

                    billing_phone: {

                        required: true,

                        phoneUS: true

                    },

                    billing_email: {

                        required: true,

                        email: true

                    },

                    billing_street: "required",

                    billing_city: "required",

                    billing_state: "required",

                    billing_postal_code: {

                        required: true,

                        minlength: 5

                    }

                },

                messages: {

                    // Shipping Address

                    shipping_first_name: {

                        required: "Please enter your first name.",

                        minlength: "First name must be at least 2 characters."

                    },

                    shipping_last_name: {

                        required: "Please enter your last name.",

                        minlength: "Last name must be at least 2 characters."

                    },

                    shipping_phone: {

                        required: "Please enter your phone number.",

                        // digits: "Please enter a valid phone number."

                    },

                    shipping_email: {

                        required: "Please enter your email address.",

                        email: "Please enter a valid email address."

                    },

                    shipping_street: "Please enter your street address.",

                    shipping_city: "Please enter your city.",

                    shipping_state: "Please enter your state.",

                    shipping_postal_code: {

                        required: "Please enter your postal code.",

                        minlength: "Postal code must be at least 5 characters."

                    },



                    // Billing Address

                    billing_first_name: {

                        required: "Please enter your first name.",

                        minlength: "First name must be at least 2 characters."

                    },

                    billing_last_name: {

                        required: "Please enter your last name.",

                        minlength: "Last name must be at least 2 characters."

                    },

                    billing_phone: {

                        required: "Please enter your phone number.",

                        // digits: "Please enter a valid phone number."

                    },

                    billing_email: {

                        required: "Please enter your email address.",

                        email: "Please enter a valid email address."

                    },

                    billing_street: "Please enter your street address.",

                    billing_city: "Please enter your city.",

                    billing_state: "Please enter your state.",

                    billing_postal_code: {

                        required: "Please enter your postal code.",

                        minlength: "Postal code must be at least 5 characters."

                    }

                },

                errorElement: "div", // error element as span



                errorPlacement: function(error, element) {



                    error.insertAfter(element); // Insert error after the element



                },

            });



            // Trigger validation and submission on the Pay button click

            // $("#pay-button").on("click", function() {

            //     if ($("#checkout-form").valid()) {

            //         $("#checkout-form").submit();

            //     }

            // });

        });
    </script>

    <script>
        $('#same_as_shipping').on('change', function() {

            const fields = [

                'first_name', 'last_name', 'phone', 'email',

                'street', 'street2', 'city', 'unit',

                'state', 'postal_code', 'country'

            ];



            fields.forEach(field => {

                const shippingField = $(`#shipping_${field}`);

                const billingField = $(`#billing_${field}`);



                if (shippingField.length && billingField.length) {

                    billingField.val(this.checked ? shippingField.val() : '');

                } else {

                    console.error(`Missing field for ${field}`);

                }

            });

        });
    </script>

    <script>
        function handlePayment(clientSecret, order_id) {
            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardNumber, // Ensure cardNumber is properly initialized
                },
            }).then((result) => {
                if (result.error) {
                    Swal.fire({
                        title: "Payment failed",
                        text: result.error.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    restorePayButton(); // Restore the button after failure
                } else if (result.paymentIntent.status === "requires_action") {
                    stripe.handleCardAction(clientSecret).then((result) => {
                        if (result.error) {
                            Swal.fire({
                                title: "Authentication failed",
                                text: result.error.message,
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                            restorePayButton(); // Restore the button after failure
                        } else {
                            confirmPayment(result.paymentIntent.id, order_id);
                        }
                    });
                } else if (result.paymentIntent.status === "succeeded") {
                    storeTransactionDetails({
                        order_id: order_id,
                        payment_intent_id: result.paymentIntent.id,
                        status: "succeeded",
                    });

                    Swal.fire({
                        title: "Payment successful!",
                        text: "Your payment has been processed successfully.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href =
                            '{{ route('winery.vendor.order.detail', ['orderid' => ':orderid', 'vendorid' => $vendorid]) }}'
                            .replace(':orderid', order_id);
                        resetCheckoutForm(); // Reset the checkout form
                        restorePayButton(); // Restore the button after success
                    });
                }
            });
        }

        function confirmPayment(paymentIntentId, order_id) {
            fetch('{{ route('confirm-payment', $vendorid) }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        payment_intent_id: paymentIntentId,
                        order_id: order_id,
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        storeTransactionDetails({
                            order_id: order_id,
                            payment_intent_id: paymentIntentId,
                            status: "succeeded",
                        });

                        Swal.fire({
                            title: "Payment confirmed successfully!",
                            text: "Your payment has been confirmed.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href =
                                '{{ route('winery.vendor.order.detail', ['orderid' => ':orderid', 'vendorid' => $vendorid]) }}'
                                .replace(':orderid', order_id);
                            resetCheckoutForm(); // Reset the checkout form
                            restorePayButton(); // Restore the button after success
                        });
                    } else if (data.requires_action) {
                        handlePayment(data.client_secret, order_id);
                    } else {
                        Swal.fire({
                            title: "Payment confirmation failed",
                            text: "Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        restorePayButton(); // Restore the button after failure
                    }
                })
                .catch((error) => {
                    console.error("Confirmation Error:", error);
                    Swal.fire({
                        title: "Error",
                        text: "There was an error confirming the payment.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    restorePayButton(); // Restore the button after error
                });
        }

        function restorePayButton() {
            const $payButton = $("#pay-button");
            $payButton.html(originalButtonText);
            $payButton.prop('disabled', false);
        }

        $("#pay-button").on("click", function() {
            const formData = new FormData();
            if ($("#checkout-form").valid() && $("#delivery-form").valid()) {
                const $payButton = $(this);
                const originalButtonText = $payButton.html(); // Save the original button text globally

                // Change button to show spinner
                $payButton.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                );
                $payButton.prop('disabled', true); // Disable button to prevent multiple clicks

                // Append data from both forms
                const checkoutFormData = new FormData(document.getElementById("checkout-form"));
                for (let [key, value] of checkoutFormData.entries()) {
                    formData.append(key, value);
                }
                const deliveryFormData = new FormData(document.getElementById("delivery-form"));
                for (let [key, value] of deliveryFormData.entries()) {
                    formData.append(key, value);
                }

                fetch('{{ route('winery.checkout-post', ['shopid' => $shopid, 'vendorid' => $vendorid]) }}', {
                        method: "POST",
                        headers: {
                            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                            "Accept": "application/json"
                        },
                        body: formData
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.client_secret && data.order_id) {
                            handlePayment(data.client_secret, data.order_id);
                        } else {
                            console.error("Missing client_secret or order_id in response:", data);
                            restorePayButton(); // Restore the button if data is missing
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                        restorePayButton(); // Restore the button on error
                    });
            }
        });

        function storeTransactionDetails(details = null) {
            fetch('{{ route('store-winery-shop-transaction-details', $vendorid) }}', {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                    },
                    body: JSON.stringify(details),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        console.log("Transaction details stored successfully.");
                    } else {
                        console.error("Failed to store transaction details:", data.error);
                    }
                })
                .catch((error) => {
                    console.error("Error storing transaction details:", error);
                });
        }


        $('input[name="delivery_type"]').on('change', function() {
            let selectedOption = $(this).val();

            if (selectedOption === 'pickup') {
                $("#same_as_shipping_container").hide();
                $(".shipping-address").hide();
                $("#deliveryCharges").hide();
                $("#total_amount").text('${{ $cartTotal }}');
                // Additional code for handling "Pick Up" option can go here
            } else if (selectedOption === 'delivery') {
                $(".shipping-address").show();
                $("#same_as_shipping_container").show();
                $("#deliveryCharges").show();
                $("#total_amount").text('${{ number_format($cartTotal + $deliveryFee, 2) }}');
                // Additional code for handling "Delivery" option can go here
            }
        });
        $(document).ready(function() {
            $(".shipping-address").show();
            $("#same_as_shipping_container").show();
            $("#deliveryCharges").show();
            $("#total_amount").text('${{ number_format($cartTotal + $deliveryFee, 2) }}');
        });
    </script>

@endsection
