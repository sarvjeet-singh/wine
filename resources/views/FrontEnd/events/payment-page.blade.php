@extends('FrontEnd.layouts.mainapp')
@section('content')
    <style>
        body :is(p, h1, h2, h3, h4, h5, h6) {
            color: #212529;
        }

        .theme-color {
            color: #c0a144 !important;
        }

        .card-detail-wrapper .card-inner-wrapper {
            max-width: 480px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
        }

        .card-detail-wrapper .form-label {
            font-weight: bold;
        }

        .card-detail-wrapper .form-control {
            border-radius: 8px;
        }

        .card-detail-wrapper .btn-primary {
            background-color: #bba253;
            border-color: #bba253;
            border-radius: 8px;
        }


        @media screen and (max-width: 576px) {
            .card-detail-wrapper .card-inner-wrapper {
                padding: 20px;
            }
        }
    </style>
    <section class="card-detail-wrapper my-5">
        <div class="container">
            <div class="card-inner-wrapper rounded-4 shadow">
                <h2 class="card-title text-center theme-color fs-3 mb-4">Enter Card Details</h2>
                <div id="checkout-payment-form" class="d-none">
                    <!-- "Back to Saved Cards" Option -->
                    <div class="form-check mb-2">
                        <input type="radio" name="payment_method_select" value="saved" id="back-to-saved"
                            class="form-check-input">
                        <label for="back-to-saved" class="form-check-label fw-bold">Use a Saved Card</label>
                    </div>
                    <div class="cart-box p-4">
                        <div class="checkout-box border-top mt-3 pt-3">

                            <form action="" id="payment-form" method="POST">
                                @csrf
                                <input type="hidden" id="selectedPaymentMethodId" name="payment_method_id" value="">
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

                                </div>

                            </form>

                        </div>
                        <button id="save-card-button" type="button"
                            class="btn book-btn wine-btn w-100 text-uppercase mt-2">Save Card</button>
                    </div>
                </div>
                <div id="payment-methods-container" class="mt-4">
                    <h4 class="fw-bold">Saved Payment Methods</h4>
                    <input type="hidden" id="selectedPaymentMethodId" name="payment_method_id" value="">
                    <!-- Payment Methods List (Will be populated by AJAX) -->
                    <ul id="payment-methods-list" class="list-group"></ul>
                    <!-- "Use a New Card" Option -->
                    <div class="form-check my-2">
                        <input type="radio" name="payment_method_select" value="new" id="use-new-card"
                            class="form-check-input">
                        <label for="use-new-card" class="form-check-label fw-bold">Save a New
                            Card</label>
                    </div>
                    <button id="submit-button" type="button"
                        class="btn book-btn wine-btn w-100 text-uppercase mt-2">Pay</button>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    {{-- <script src="{{ asset('asset/js/select2.min.js') }}"></script> --}}


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
    <script>
        function storeTransactionDetails(details = null) {
            fetch('{{ route('events.store-order-transaction-details') }}', {
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
        // AJAX call to load payment methods
        function loadPaymentMethods() {
            $.ajax({
                url: "{{ route('customer.list-payment-methods') }}",
                type: "GET",
                success: function(data) {
                    let response = data.data;
                    let methodsList = $("#payment-methods-list");
                    methodsList.empty(); // Clear existing payment methods

                    if (response.length === 0) {
                        methodsList.append(
                            '<li class="list-group-item">No saved payment methods.</li>');
                    } else {
                        response.forEach(function(method) {
                            // Check if it's the default method
                            let isDefault = method.is_default;
                            $("#selectedPaymentMethodId").val(method.id);
                            // If the payment method is default, show a badge and disable the buttons
                            let defaultBadge = isDefault ?
                                '<span class="badge bg-success">Default</span>' : '';

                            let buttonSection = !isDefault ? `
                    <div class="d-flex justify-content-end gap-2">
                        <button class="btn btn-sm btn-primary make-default-payment" data-id="${method.id}">
                            <i class="fa-solid fa-star"></i>
                        </button>
                        <button class="btn btn-sm btn-danger remove-payment" data-id="${method.id}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                ` : ''; // If default, no buttons will be shown

                            // Format the expiry date
                            let expDate = method.exp_month && method.exp_year ?
                                `${method.exp_month}/${method.exp_year}` :
                                'N/A';

                            // Add the payment method list item
                            methodsList.append(`
                    <li class="list-group-item">
                        <!-- Button Section (only for non-default methods) -->
                        ${buttonSection}
                        <!-- Radio Button + Card Details -->
                        <div class="d-flex align-items-center">
                            <input type="radio" name="payment-method" value="${method.id}" id="payment-method-${method.id}" 
                                class="select-payment-method me-2" ${isDefault ? 'checked' : ''}>
                            <span class="fw-bold">${method.brand} •••• ${method.last4} ${defaultBadge}</span>
                        </div>
                        <!-- Expiry Date -->
                        <div class="mt-2">
                            <span>Expiry: ${expDate}</span>
                        </div>
                    </li>
                `);
                        });
                    }
                },
                error: function() {
                    $("#payment-methods-list").html(
                        '<li class="list-group-item text-danger">Failed to load payment methods.</li>'
                    );
                }
            });
        }
        $(document).ready(function() {
            // Fetch and display saved payment methods
            // Switch to new card form
            $("#use-new-card").on("change", function() {
                $("#checkout-payment-form").removeClass("d-none");
                $("#payment-methods-container").addClass("d-none");
                $("#selectedPaymentMethodId").val('');
            });

            // Switch back to saved cards
            $("#back-to-saved").on("change", function() {
                $("#payment-methods-container").removeClass("d-none");
                $("#checkout-payment-form").addClass("d-none");

                const selectedPaymentMethodId = $("input[name='payment-method']:checked").val();

                // Set the hidden field with the selected payment method ID
                if (selectedPaymentMethodId) {
                    $("#selectedPaymentMethodId").val(selectedPaymentMethodId);
                }
            });

            // Call function to load payment methods
            loadPaymentMethods();

            // Remove payment method
            $(document).on("click", ".remove-payment", function() {
                let methodId = $(this).data("id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This payment method will be removed permanently.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, remove it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('customer.remove-payment-method') }}",
                            type: "POST",
                            data: {
                                payment_method_id: methodId
                            },
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content") // For Laravel CSRF protection
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Your payment method has been removed.",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                loadPaymentMethods(); // Refresh the list
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to remove payment method.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
            $(document).on("click", ".make-default-payment", function() {
                let methodId = $(this).data("id");

                Swal.fire({
                    title: "Set as Default?",
                    text: "Do you want to set this card as your default payment method?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Set as Default"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('customer.set-default-payment-method') }}",
                            type: "POST",
                            data: {
                                payment_method_id: methodId
                            },
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content") // CSRF Protection
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Updated!",
                                    text: "Your default payment method has been updated.",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                loadPaymentMethods(); // Refresh the list
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to update default payment method.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });
            $(document).on('change', '.select-payment-method', function() {
                let selectedPaymentMethodId = $(this).val();

                // Optionally, update some element or send an AJAX request to set the selected payment method
                $("#selectedPaymentMethodId").val(selectedPaymentMethodId);
                // You can use AJAX here to update the backend or handle further logic
            });
        });
        async function savePaymentMethod(paymentMethodId) {
            const response = await fetch("{{ route('customer.save-payment-method') }}", {
                method: 'POST',
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethodId
                }),
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire({
                    title: "Success",
                    text: "Payment method saved successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    loadPaymentMethods();
                    $("#back-to-saved").trigger("click");
                });
                // Switch back to saved cards();
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Failed to save payment method.",
                    icon: "error",
                    confirmButtonText: "OK"
                })
            }
        }
        async function createPaymentIntent(paymentMethodId, order_id) {
            try {
                const response = await fetch(
                    "{{ route('customer.create-payment-intent', $vendor->id) }}", {
                        method: 'POST',
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        body: JSON.stringify({
                            payment_method_id: paymentMethodId,
                            order_id: order_id,
                            order_type: "event",
                        }),
                    });

                const data = await response.json();
                if (data.client_secret) {
                    return data; // Return the payment intent data
                } else {
                    console.error("Error creating payment intent:", data.error);
                    return null;
                }
            } catch (error) {
                console.error("Request failed:", error);
                return null;
            }
        }
        async function proceedWithPayment(paymentMethod, intent, order_id) {
            try {
                if (intent.error) {
                    await Swal.fire({
                        title: "Payment failed",
                        text: intent.error.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    restorePayButton();
                    return;
                }

                if (intent.status === "requires_action") {
                    const result = await stripe.confirmCardPayment(intent.client_secret);
                    console.log("requires_action");

                    if (result.error) {
                        await Swal.fire({
                            title: "Authentication failed",
                            text: result.error.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                        restorePayButton();
                        return;
                    }

                    await storeTransactionDetails({
                        order_id: order_id,
                        payment_intent_id: intent.id,
                        status: "succeeded",
                    });

                    await Swal.fire({
                        title: "Payment successful!",
                        text: "Your payment has been processed successfully.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    window.location.href = '{{ route('order.thankyou', ['id' => ':id', 'orderType' => 'event']) }}'.replace(':id', order_id);
                    // resetCheckoutForm();
                    restorePayButton();
                } else if (intent.status === "succeeded") {
                    await storeTransactionDetails({
                        order_id: order_id,
                        payment_intent_id: intent.id,
                        status: "succeeded",
                    });

                    await Swal.fire({
                        title: "Payment successful!",
                        text: "Your payment has been processed successfully.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    window.location.href = '{{ route('order.thankyou', ['id' => ':id']) }}'.replace(':id', order_id);
                    // resetCheckoutForm();
                    restorePayButton();
                } else if (intent.status === "requires_capture") {
                    await storeTransactionDetails({
                        order_id: order_id,
                        payment_intent_id: intent.id,
                        status: "requires_capture",
                    });

                    await Swal.fire({
                        title: "Payment authorized!",
                        text: "Your payment has been authorized successfully.",
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    window.location.href = '{{ route('order.thankyou', ['id' => ':id']) }}'.replace(':id', order_id);
                    // resetCheckoutForm();
                    restorePayButton();
                }
            } catch (error) {
                console.error("Error in proceedWithPayment:", error);

                await Swal.fire({
                    title: "Error",
                    text: "There was an issue processing your payment.",
                    icon: "error",
                    confirmButtonText: "OK"
                });

                restorePayButton();
            }
        }
        function confirmPayment(paymentIntentId, order_id) {
            fetch('{{ route('customer.confirm-payment') }}', {
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
                        // Payment was successful
                        storeTransactionDetails({
                            order_id: order_id,
                            payment_intent_id: paymentIntentId,
                            status: "requires_capture",
                        });

                        Swal.fire({
                            title: "Payment confirmed successfully!",
                            text: "Your payment has been confirmed.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href =
                                '{{ route('order.thankyou', ['id' => ':orderid']) }}'.replace(':orderid',
                                    order_id);
                            // resetCheckoutForm(); // Reset the checkout form
                            restorePayButton(); // Restore the button after success
                        });
                    } else if (data.requires_action) {
                        // If 3D Secure or any additional authentication is needed
                        handlePayment(order_id);
                    } else {
                        // Payment confirmation failed
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
        $("#save-card-button").click(async function() {
            try {
                // Create a new payment method
                let result = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardNumber, // Use your Stripe Elements card element here
                    billing_details: {
                        name: $('#cc-name').val(), // Cardholder name
                    }
                });

                if (result.error) {
                    Swal.fire({
                        title: "Payment failed",
                        text: result.error.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    restorePayButton();
                    return; // Stop execution if there's an error
                }

                paymentMethod = result.paymentMethod.id; // Get the created payment method ID
                savePaymentMethod(paymentMethod); // Save the payment method if needed

            } catch (error) {
                console.error("Error creating payment method:", error);
                Swal.fire({
                    title: "Error",
                    text: "There was an error creating the payment method.",
                    icon: "error",
                    confirmButtonText: "OK"
                });;
                return;
            }
        });

        $("#submit-button").on("click", function() {
            handlePayment({{$order->id}});
        })
        async function handlePayment(order_id) {
            const paymentMethodId = $("#selectedPaymentMethodId").val(); // Get selected payment method ID
            let paymentMethod = null;

            if (paymentMethodId) {
                // Use saved payment method
                paymentMethod = paymentMethodId;
            }

            try {
                let intent = await createPaymentIntent(paymentMethod, order_id);

                console.log("✅ Payment Intent Created:", intent);

                if (!intent || !intent.client_secret) {
                    console.error("❌ Missing client_secret in PaymentIntent response.");
                    throw new Error("Missing client_secret in PaymentIntent response.");
                }

                console.log("🚀 Proceeding with Payment Intent...");
                await proceedWithPayment(paymentMethod, intent, order_id);
            } catch (error) {
                console.error("⚠️ Error creating PaymentIntent:", error);
                Swal.fire({
                    title: "Error",
                    text: error.message || "There was an issue creating the payment intent.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        }
        function restorePayButton() {

        }
    </script>
@endsection
