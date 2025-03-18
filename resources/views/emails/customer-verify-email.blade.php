@extends('emails.customer.customerLayouts.app')

@section('content')

    <!-- Email Body -->

    <div class="email-body">

        <p style="font-size: 18px; margin: 10px 0 24px 0;">Dear <strong style="color: #c0a144;">{{ $username }}</strong>,

        </p>

        <p>Thank you for joining our Guest Rewards program.  We look forward to treating you to some of the best experiences

            the Niagara region has to offer.</p>



        <p>This may very well be the only email you receive from us because we do not employ email marketing tactics.  We

            prefer to engage you on whatever social media platform you use most.  It's less intrusive and we really enjoy

            creating the content.</p>



        <p>Just make sure you indicate in your personal profile which social media platforms you prefer to use and if you're

            not too shy, we may even invite you to play a role in one of our productions.</p>



        <p>If you would like to post a public testimonial or review about an experience at any of our listed vendors, you

            will need to upload a headshot to accompany your post.  We are a community of fun loving travelers that like to

            see a face attached to the comments posted.</p>

        <p>Please follow the link below to login to your personal account dashboard and update/manage your account

            accordingly.</p>

        <p>Thank you for signing up! Please verify your email address by clicking the button below:</p>

        <a href="{{ $verificationUrl }}"

            style="display: inline-block; background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">

            Verify Email

        </a>

        <p style="margin-top: 10px;">Cheers!</p>

        <h4 style="color: #c0a144;">The WCW Marketing Team</h4>



        <div>

            <a href="{{ route('customer.login') }}" target="_blank" class="button">Log in to Your Account</a>

        </div>

    </div>

    <!-- /Email Body -->

@endsection

