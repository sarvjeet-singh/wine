@extends('FrontEnd.layouts.mainapp')

@section('content')

<section class="forgot-pwd-sec border-top">
    <div class="container">
        <div class="inner-sec text-center">
            <img src="{{asset('images/icons/forgot-pwd.png')}}" class="w-25">
            <h3 class="fs-4 fw-bold mt-4">Forgot Password</h3>
            <p class="mb-4">Enter your email and we'll send you a link to reset your password.</p>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form method="POST" action="{{ route('customer.password.email') }}">
                @csrf
                <div class="mb-2">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn theme-btn w-100"">
                        {{ __('Send Password Reset Link') }}
                    </button>
				</div>
			</form>
			<div class=" back-btn mt-4">
                <a href="{{ route('login') }}" class="text-decoration-none"><i class="fa-solid fa-angle-left"></i> Back to Login</a>
            </div>
        </div>
    </div>

</section>
@endsection
