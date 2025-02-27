@extends('FrontEnd.layouts.mainapp')



@section('content')

    <section class="order-thankyou-content d-flex align-items-center justify-content-center my-sm-5 py-5">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-8 text-center">

                    <h1 class="theme-color">Thank you for your booking!</h1>

                    

                    @if(isset($order_id))

                        <p class="lead">Your booking order <strong>#{{ $order_id }}</strong> has been successfully confirmed.</p>

                    @else

                        <p class="lead">Your booking has been successfully confirmed.</p>

                    @endif



                    <p>We appreciate your booking with Wine Country Weekends! A confirmation email has been sent to your registered email address.</p>



                    <div class="my-4">

                        <a href="{{ route('home') }}" class="btn btn-primary return-btn mx-1">Return to Home</a>

                        <a href="{{ route('user.orderDetail', $order_id ?? 0) }}" class="btn view-order-btn mx-1">View Order Details</a>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection

