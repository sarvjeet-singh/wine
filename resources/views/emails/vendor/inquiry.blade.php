@extends('emails.vendor.vendorLayouts.app')

@section('title', 'New User Inquiry for Accommodation')

@section('content')

    <div class="email-body">
        <p style="font-size: 18px; margin: 10px 0 24px 0;">Dear <strong
                style="color: #118c97;">{{ $vendor['vendor_name'] ?? 'Vendor' }}</strong>,</p>

        @if (!empty($inquiry['name']))
            <h2>New Inquiry from {{ $inquiry['name'] }}</h2>
        @endif

        @if (!empty($inquiry['email']))
            <p><strong>Email:</strong> {{ $inquiry['email'] }}</p>
        @endif

        @if (!empty($inquiry['phone']))
            <p><strong>Phone:</strong> {{ $inquiry['phone'] }}</p>
        @endif

        @if (!empty($inquiry['check_in_at']))
            <p><strong>Check-in:</strong> {{ $inquiry['check_in_at'] }}</p>
        @endif

        @if (!empty($inquiry['check_out_at']))
            <p><strong>Check-out:</strong> {{ $inquiry['check_out_at'] }}</p>
        @endif

        @if (!empty($inquiry['nights_count']))
            <p><strong>Nights:</strong> {{ $inquiry['nights_count'] }}</p>
        @endif

        @if (!empty($inquiry['experiences_selected']) && is_array(json_decode($inquiry['experiences_selected'], true)))
            <h3>Selected Experiences</h3>
            <ul>
                @foreach (json_decode($inquiry['experiences_selected'], true) as $experience)
                    @if (!empty($experience['name']) && isset($experience['value']))
                        <li>{{ $experience['name'] }} - ${{ $experience['value'] }}</li>
                    @endif
                @endforeach
            </ul>
        @endif

        @if (!empty($inquiry['experiences_total']))
            <p><strong>Total Amount:</strong> ${{ $inquiry['experiences_total'] }}</p>
        @endif

        <p>We look forward to working with you.</p>

        <h4 style="color: #118c97; margin-bottom: 16px;">Cheers!</h4>

        <h4 style="color: #118c97;">The WCW Marketing Team</h4>
    </div>

@endsection
