@extends('emails.vendor.vendorLayouts.app')

@section('title', 'Vendor Subscription Confirmation')

@section('content')
    <div class="email-body">
        <h2 style="color: #6366f1;">📢 New Booking Received!</h2>

        <p>Hi {{ $booking->vendor->vendor_name ?? 'Vendor' }},</p>

        <p>You’ve received a new booking for your event!</p>

        <ul style="line-height: 1.8;">
            <li><strong>🗓 Event Name:</strong> {{ $booking->eventOrderDetail->name ?? '' }}</li>
            <li><strong>📅 Booking Date:</strong> {{ $booking->created_at->format('F j, Y g:i A') }}</li>
            <li><strong>👤 Booked By:</strong> {{ $booking->customer->firstname ?? ''  }} {{ $booking->customer->lastname ?? '' }}</li>
            <li><strong>📧 User Email:</strong> {{ $booking->customer->email ?? '' }}</li>
            <li><strong>🎟 Tickets Booked:</strong> {{ $booking->eventOrderDetail->no_of_tickets ?? '' }}</li>
            <li><strong>💰 Total Price:</strong> ${{ number_format($booking->total, 2) ?? '' }}</li>
        </ul>

        <p>
            Please log in to your vendor dashboard to view more details or manage the booking.
        </p>

        <p>Thanks,<br>The Team</p>
    </div>
@endsection