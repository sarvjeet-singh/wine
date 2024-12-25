@extends('emails.vendor.vendorLayouts.app')

@section('title', 'Winery Vendor Login Details')

@section('content')
<div class="email-body">
    <p style="font-size: 18px; margin: 10px 0 24px 0;">Dear <strong style="color: #118c97;">{{ $vendorData['user']->firstname ?? 'Vendor' }}</strong>,</p>

    <p>Welcome to the vendor admin section of our marketplace platform.  You have been assigned administrative access and are now able to use the following credentials to manage the <strong style="color: #118c97;">[{{ $vendorData['vendor']->vendor_name ?? 'Vendor' }}]</strong> account and any other vendor account you may be associated with.</p>

    <div class="credentials">
        <p>eMail/Username: <span style="color:#28405e;">{{ $vendorData['user']->email ?? '' }}</span></p>
        <p>Password: <span style="color:#28405e;">{{ $vendorData['password'] ?? '' }}</span></p>
    </div>

    <p>Your participation in our <strong style="color: #118c97;">“Guest Rewards Program”</strong> and/or <strong style="color: #118c97;">Support Local Initiative”</strong> also means an improved ranking position for your vendor profile in our directories.  Administrative access will enable you to manage content in real time (i.e. media gallery, business hours, B2B wine catalogue, amenities, etc.)..</p>

    <p>You may update your password to something more suitable after logging in for the first time..</p>

    <div>
        <a href="{{ route('vendor.login') }}" target="_blank" class="button" style="display: inline-block; background-color: #118c97; color: #ffffff; 
        text-decoration: none; padding: 10px 20px; border-radius: 6px; 
        font-size: 14px; font-family: 'Inter Tight', Arial, sans-serif;">Log in to Your Account</a>
    </div>

    <p>We look forward to working with you.</p>

    <h4 style="color: #118c97; margin-bottom: 16px;">Cheers!</h4>

    <h4 style="color: #118c97;">The WCW Marketing Team</h4>

    <p>Please DO NOT REPLY to any email from this address.  It is for outgoing mail only and is not monitored.</p>
    
</div>
@endsection
