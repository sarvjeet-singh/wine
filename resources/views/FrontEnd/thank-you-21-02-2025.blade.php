@extends('FrontEnd.layouts.mainapp')

@section('content')
    <section class="order-thankyou-content my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h1 class="text-success">Thank You for Your Order!</h1>
                    
                    @if(isset($order_id))
                        <p class="lead">Your booking order <strong>#{{ $order_id }}</strong> has been successfully confirmed.</p>
                    @else
                        <p class="lead">Your booking has been successfully confirmed.</p>
                    @endif

                    <p>We appreciate your purchase with Wine Country Weekends! A confirmation email has been sent to your registered email address.</p>

                    <div class="my-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Return to Home</a>
                        <a href="{{ route('user.orderDetail', $order_id ?? 0) }}" class="btn btn-outline-success">View Order Details</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
