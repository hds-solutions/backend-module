@extends('backend::layouts.app')

@section('body-class', 'bg-gradient-primary')

@section('app')

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }}</h1>
                                </div>

                                <form method="POST" action="{{ route( config('backend.login') ) }}" class="user">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email" name="email" required autofocus
                                            value="{{ old('email') }}"
                                            placeholder="{{ __('E-Mail Address') }}"
                                            class="form-control form-control-user @error('email') is-invalid @enderror">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" required autocomplete="current-password"
                                            placeholder="{{ __('Password') }}"
                                            class="form-control form-control-user @error('password') is-invalid @enderror">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="remember-check">
                                            <label class="custom-control-label" for="remember-check">{{ __('Remember Me') }}</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">{{ __('Login') }}</button>

                                    @if (Route::has('backend.login.provider'))
                                    <div>
                                        <hr>
                                        <a href="#" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="#" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </div>
                                    @endif

                                </form>

                                @if (Route::has('backend.password.request'))
                                    <hr>
                                    <a class="small" href="{{ route('backend.password.request') }}">{{ __('Forgot Your Password?') }}</a>
                                    <a class="d-block small mt-3" href="{{ route('backend.password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection