@extends('emails.vendor.vendorLayouts.app')

@section('title', 'New Subscription')

@section('content')
<div class="email-body">
    <h2>Hello {{ $vendorName }}, a new subscription has been made.</h2>
    <p><strong>Vendor Email:</strong> {{ $vendorEmail }}</p>
    <p><strong>Subscription:</strong> {{ $subscriptionName }}</p>
    <p><strong>Price:</strong> ${{ number_format($subscriptionPrice, 2) }}</p>
    <p><strong>Start Date:</strong> {{ $startDate }}</p>
    <p><strong>End Date:</strong> {{ $endDate }}</p>
</div>

@endsection