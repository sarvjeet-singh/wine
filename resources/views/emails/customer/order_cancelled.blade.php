@extends('emails.customer.customerLayouts.app')

@section('title', 'Order Cancelled')

@section('content')
    <div class="email-body">

        <p>Hello {{ $recipientType == 'customer' ? $order->customer->name : $order->vendor->name }},</p>

        <p>Your order with ID <strong>#{{ $order->id }}</strong> has been cancelled.</p>

        <p><strong>Reason:</strong> {{ $order->cancel_reason }}</p>

        <p>If you have any questions, please contact support.</p>

        <p>Thank you,</p>

    </div>
@endsection
