@extends('emails.customer.customerLayouts.app')

@section('title', 'Order Cancelled')

@section('content')
    <div class="email-body">
        <h2 style="color: #38c172;">✅ Your Booking is Confirmed!</h2>

        <p>Hi {{ $booking->customer->firstname }},</p>

        <p>Thanks for booking with us! Your reservation for the following event has been confirmed:</p>

        <ul style="line-height: 1.8;">
            <li><strong>🗓 Event Name:</strong> {{ $booking->eventOrderDetail->name }}</li>
            <li><strong>📅 Date & Time:</strong>
                {{ \Carbon\Carbon::parse($booking->eventOrderDetail->start_date)->format('F j, Y g:i A') }}</li>
            <li><strong>📍 Location:</strong> {{ $booking->eventOrderDetail->street_address ?? '' }} 
                {{ $booking->eventOrderDetail->city ?? '' }}
                {{ $booking->eventOrderDetail->state ?? '' }}
                {{ $booking->eventOrderDetail->postal_code ?? '' }}
            </li>
            <li><strong>🎟 Tickets:</strong> {{ $booking->eventOrderDetail->no_of_tickets }}</li>
            <li><strong>💰 Total Paid:</strong> ${{ number_format($booking->total, 2) }}</li>
            <li><strong>🎤 Hosted by:</strong> {{ $booking->event->vendor->name ?? 'Organizer' }}</li>
        </ul>

        <p>You’ll receive updates if there are any changes to this event.</p>

        <p>
            <a href="{{ route('user.event-orderDetails', $booking->id) }}"
                style="display:inline-block; background:#3490dc; color:#fff; padding:10px 15px; border-radius:5px; text-decoration:none;">
                🔍 View Booking Details
            </a>
        </p>

        <p>Enjoy the event!<br>The Team</p>
    </div>
@endsection