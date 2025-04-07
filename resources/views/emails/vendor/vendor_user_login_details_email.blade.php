@extends('emails.vendor.vendorLayouts.app')

@section('title', 'Vendor User Login Details')

@section('content')
    <div class="email-body">
        <p style="font-size: 18px; margin: 10px 0 24px 0;">Dear <strong
                style="color: #118c97;">{{ $userData->firstname ?? 'Vendor' }}</strong>,</p>

        <p>Welcome to the e-commerce section of our marketplace platform.  The link below will log you into your account and any other vendor account you may become associated with.</p>

        <div class="credentials">
            <p>eMail/Username: <span style="color:#28405e;">{{ $userData->email ?? '' }}</span></p>
            @if (!empty($password))
                <p>Password: <span style="color:#28405e;">{{ $password ?? '' }}</span></p>
            @endif
        </div>

        <p>Administrative access will enable you to manage content in real time (i.e. Wine Catalogue, Business Hours, Media Gallery, Amenities, etc.).  You may also set your password to something more personal and soon you will also be able to assign admin access to other members of your staff or team.</p>

        <p>The listing of your wines will ultimately make it easier for resellers and other vendors to source your products (i.e. B2B sales).  Subscription and stocking fees are required before we actively recommend/broker the sale of your wines to resellers.  You can view plan options from the link on your dashboard.  Finally, you will need to initiate a Stripe, payment gateway account, to facilitate the direct sale of wines via our platform.</p>

        <div>
            <a href="{{ route('vendor.login') }}" target="_blank" class="button"
                style="display: inline-block; background-color: #118c97; color: #ffffff; 
        text-decoration: none; padding: 10px 20px; border-radius: 6px; 
        font-size: 14px; font-family: 'Inter Tight', Arial, sans-serif;">Log
                in to Your Account</a>
        </div>
        <br />
        <p>We look forward to your input and feedback.</p>

        <p>Cheers!</p>

        <h4 style="color: #118c97;">The WCW Marketing Team</h4>
    </div>
@endsection
