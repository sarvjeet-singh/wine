@extends('emails.vendor.vendorLayouts.app')

@section('title', 'Vendor Subscription Confirmation')

@section('content')
    <div class="email-body">
        <h2>Hello {{ $vendorName }},</h2>
        <p>Thank you for subscribing to our service.</p>
        <p><strong>Subscription Details:</strong></p>
        <ul>
            <li><strong>Start Date:</strong> {{ $startDate }}</li>
            <li><strong>End Date:</strong> {{ $endDate }}</li>
            <li><strong>Price Type:</strong> {{ $priceType }}</li>
            <li><strong>Charge Amount:</strong> ${{ number_format($chargeAmount, 2) }}</li>
        </ul>
    </div>
@endsection
