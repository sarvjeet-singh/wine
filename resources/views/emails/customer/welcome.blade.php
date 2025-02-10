@extends('emails.customer.customerLayouts.app')

@section('title', 'Welcome Email')

@section('content')
    <div class="email-body">
        <p style="font-size: 18px; margin: 10px 0 24px 0;">Dear <strong style="color: #c0a144;">{{ $name }}</strong>,
        </p>
        <p>Thank you for joining our Guest Rewards program. We look forward to treating you to some of the best experiences
            the
            Niagara region has to offer. </p>

        <p>Rest assured we don’t employ email marketing tactics. We prefer to engage you on whatever social media platform
            you
            use most. It's less intrusive and we really enjoy creating the content. Be sure to indicate your preferred
            social
            media platform(s) and if you're not too shy, we may even give you a role in one of our productions.</p>

        <p>We would also like to encourage you to post a testimonial or review of your experience at any of our listed
            vendors.
            You will need to upload a headshot to accompany any publicly accessible commentary. After all, we are just a
            group
            of oenophiles and travelers that like to see a face attached to the comments posted.</p>
        <br>
        Welcome to our community!

        Cheers,
        <div>
            <a href="{{ route('customer.login') }}" target="_blank" class="button">Log in to Your Account</a>
            <br>
            <br>
            <b>The WCW Marketing Team</b>
        </div>
    </div>


@endsection
