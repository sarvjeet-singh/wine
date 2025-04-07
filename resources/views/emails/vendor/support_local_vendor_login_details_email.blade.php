@extends('emails.vendor.vendorLayouts.app')

@section('title', 'Winery Vendor Login Details')

@section('content')
    <div class="email-body">
        <p style="font-size: 18px; margin: 10px 0 24px 0;">Dear <strong
                style="color: #118c97;">{{ $vendorData['user']->firstname ?? 'Vendor' }}</strong>,</p>

        <p>Thank you for considering participation in our Support Local initiative. The credentials below will provide you
            with administrative access to the affiliate vendor account for <strong style="color: #118c97;">[{{ $vendorData['vendor']->vendor_name ?? 'Vendor' }}]</strong>.</p>

        <div class="credentials">
            <p>User Name: <span style="color:#28405e;">{{ $vendorData['user']->email ?? '' }}</span></p>
            <p>Password: <span style="color:#28405e;">{{ $vendorData['password'] ?? '' }}</span></p>
        </div>

        <p>Administrative access will enable you to manage your vendor content in real time (i.e. media gallery, business
            hours, amenities, guest engagements, etc.). Your profile in our directory will now also be adorned with a
            <strong style="color: #118c97;">“We Support Local”</strong> ribbon and your ranking position improved
            considerably.
        </p>

        <p>You will be better able to help support local in your community by purchasing locally produced wine directly from
            local vendors to make available to your patrons. Select vendor establishments like yours are being targeted to
            lead the way in providing access and support to local wineries.</p>

        <p>Supporting local will not only help stabilize our local economy by strengthening businesses, creating jobs and
            keeping more money in our respective communities. It will also allow your patrons to benefit from joining our
            region-wide <strong style="color: #118c97;">Guest Rewards</strong> program:</p>

        <ul>
            <li>Cashback rewards</li>
            <li>Savings on third-party booking fees</li>
            <li>Exciting prizes</li>
        </ul>

        <p>We look forward to working with you.</p>

        <p>Cheers!</p>

        <h4 style="color: #118c97;">The WCW Marketing Team</h4>

        <div>
            <a href="{{ route('vendor.login') }}" target="_blank" class="button">Log in to Your Account</a>
        </div>
    </div>
@endsection
