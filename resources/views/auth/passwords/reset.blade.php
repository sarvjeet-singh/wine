@extends('FrontEnd.layouts.mainapp')

@section('content')
<section class="forgot-pwd-sec border-top">
	<div class="container">
		<div class="inner-sec text-center">
			<img src="{{asset('images/icons/reset-pwd.png')}}" class="w-25">
			<h3 class="fs-4 fw-bold mt-4">Create Your Password</h3>
			<p class="mb-4">Your new password should different from old password</p>
			<form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
				<div class="mb-2">
					<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>
				<div class="mb-2">
					<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
				</div>
				<div class="mb-2">
					 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
				</div>
				<div>
					<button type="submit" class="btn theme-btn w-100">
	                    {{ __('Reset Password') }}
	                </button>
				</div>
			</form>
		</div>
	</div>
</section>
@endsection
