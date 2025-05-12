@extends('emails.vendor.vendorLayouts.app')

@section('title', 'Your Stripe Account is Ready for Payouts!')

@section('content')
    <div class="email-body">
        <p>Hello {{ $vendor->vendor_name }},</p>

        <p>Good news! Your Stripe account has been verified and is now ready to receive payouts.</p>    

        <p>You can now start accepting payments and receive payouts directly to your bank account.</p>

        <p>If you have any questions or need assistance, feel free to contact our support team.</p>
    </div>
@endsection
