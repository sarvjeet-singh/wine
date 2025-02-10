@extends('emails.customer.customerLayouts.app')

@section('title', 'OTP')

@section('content')
    <h1>Hello, {{ $name }}</h1>
    <p>Your OTP code is:</p>
    <h2>{{ $otp }}</h2>
    <p>Please enter this code to proceed. This code will expire in 10 minutes.</p>
    <br>
    <p>Thank you,</p>
@endsection
