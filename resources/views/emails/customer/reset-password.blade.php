@extends('emails.customer.customerLayouts.app')

@section('title', 'OTP')

@section('content')

    <div class="email-body">
        <h2 style="font-size: 24px; font-weight: 500; color: #bba253; text-align: center; margin: 0;">Reset Your Password?
        </h2>
        <p style="font-size: 18px; margin: 15px 0 15px 0;">Hey <strong
                style="color: #c0a144;">{{ $user->firstname }}</strong>,</p>
        <p>You recently requested to reset your password. Please click the button below to set a new password for your
            account.</p>
        <div style="margin-bottom: 15px; text-align: center;">
            <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        </div>
        <p style="margin-bottom: 30px;">If you did not make this request, you can safely ignore this email.</p>
        <p
            style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';line-height:1.5em;margin-top:0;text-align:left;font-size:14px">
            If you're having trouble clicking the "Reset Password" button, copy and paste the URL below
            into your web browser: <span
                style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';word-break:break-all"><a
                    href="{{ $resetUrl }}"
                    style="box-sizing:border-box;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';color:#3869d4"
                    target="_blank">{{ $resetUrl }}</a></span>
        </p>
        <p style="margin:0">Regards,</p>
        <p>Wine Country Weekends</p>
    </div>
