@extends('emails.vendor.vendorLayouts.app')

@section('title', 'Winery Vendor Login Details')

@section('content')
<div class="email-body">
    <p style="font-size: 18px; margin: 10px 0 24px 0;">Dear <strong style="color: #118c97;">{{ $vendorData['user']->firstname ?? 'Vendor' }}</strong>,</p>

    <p>Thank you for considering participation in our region-wide Guest Rewards program.  The credentials below will provide you with administrative access to the affiliate vendor account for <strong style="color: #118c97;">[{{ $vendorData['vendor']->vendor_name ?? 'Vendor' }}]</strong>.</p>

    <div class="credentials">
        <p>User Name: <span style="color:#28405e;">{{ $vendorData['user']->email ?? '' }}</span></p>
        <p>Password: <span style="color:#28405e;">{{ $vendorData['password'] ?? '' }}</span></p>
    </div>

    <p>Administrative access will enable you to manage vendor content in real time (i.e. media gallery, business hours, guest engagements, list wines in our B2B wine catalogue, etc.).  Your profile in our directory will now be adorned with a 
        <strong style="color: #118c97;">“Guest Rewards Program”</strong> ribbon and your ranking position improved considerably.</p>

    <p>You will also be able to initiate a subscription plan to unlock B2B ecommerce opportunities and allow our team to go to work placing your listed wines with participating resellers.  Select restaurant establishments will be targeted to support local and join our Domestic Wine Distribution Network (DWDN).  Our Support Local initiative will enable us to not only move more products but also introduce partnering wineries to the patrons of our resellers, in their own local communities.</p>

    <p>We look forward to working with you.</p>

    <h4 style="color: #118c97; margin-bottom: 16px;">Cheers!</h4>

    <h4 style="color: #118c97;">The WCW Marketing Team</h4>

    <div>
        <a href="{{ route('vendor.login') }}" target="_blank" class="button">Log in to Your Account</a>
    </div>
</div>
@endsection
