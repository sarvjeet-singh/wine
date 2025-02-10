@extends('emails.customer.customerLayouts.app')

@section('title', 'Approved Inquiry')

@section('content')
    <div class="email-body">

        <h1>Inquiry Approved</h1>

        <p>Dear <strong>{{ $inquiry->name }}</strong>,</p>

        <p>We are pleased to inform you that your inquiry has been approved.</p>

        <div class="details">
            <p><strong>Check-in:</strong> {{ $inquiry->check_in_at ?? 'N/A' }}</p>
            <p><strong>Check-out:</strong> {{ $inquiry->check_out_at ?? 'N/A' }}</p>
            <p><strong>Nights:</strong> {{ $inquiry->nights_count ?? 'N/A' }}</p>
        </div>

        @if (!empty($inquiry->experiences_selected))
            <h3>Selected Experiences:</h3>
            <ul class="experiences">
                @foreach (json_decode($inquiry->experiences_selected, true) as $experience)
                    <li>{{ $experience['name'] }} - ${{ $experience['value'] }}</li>
                @endforeach
            </ul>
        @endif

        <p><strong>Total Amount:</strong> ${{ $inquiry->experiences_total ?? '0.00' }}</p>

        <p>Thank you for choosing us!</p>

        <h4 style="color: #118c97; margin-bottom: 16px;">Cheers!</h4>

        <h4 style="color: #118c97;">The WCW Marketing Team</h4>
    </div>
@endsection
