@extends('FrontEnd.layouts.mainapp')

@section('content')
    <section class="two-col-sec contact-sec">
        <div class="container">
            <div class="sec-head text-center mb-sm-5 mb-4">
                <h2 class="fw-bold theme-color text-uppercase">{{$vendor->vendor_name} QR Code}</h2>
                <img src="{{asset($vendor->qr_code)}}" width="300">
            </div>
        </div>
    </section>

@endsection