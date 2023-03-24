@extends('layouts.app')

@push('appTitle')
    {{ __('Reset Password') }}
@endpush

@section('AuthenticateContent')
    <!-- BEGIN: Reset Password Form -->
    <div class="g-col-2 g-col-xl-1 h-screen h-xl-auto d-flex py-5 py-xl-0 my-10 my-xl-0">
        <div
            class="my-auto mx-auto ms-xl-20 bg-white dark-bg-dark-1 bg-xl-transparent px-5 px-sm-8 py-8 p-xl-0 rounded-2 shadow-md shadow-xl-none w-full w-sm-3/4 w-lg-2/4 w-xl-auto">
            <h2 class="intro-x fw-bold fs-2xl fs-xl-3xl text-center text-xl-start">
                {{ __('Reset Password') }}
            </h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="intro-x mt-8">
                    <input type="email"
                        class="intro-x login__input form-control py-3 px-4 border-gray-300 d-block @error('email') is-invalid @enderror"
                        placeholder="{{ __('Email Address') }}" name="email" value="{{ $email ?? old('email') }}" required
                        autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    <input type="password"
                        class="intro-x login__input form-control py-3 px-4 border-gray-300 d-block mt-4 @error('password') is-invalid @enderror"
                        placeholder="Password" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="intro-x w-full grid columns-12 gap-4 h-1 mt-3">
                        <div class="g-col-3 h-full rounded bg-theme-9"></div>
                        <div class="g-col-3 h-full rounded bg-theme-9"></div>
                        <div class="g-col-3 h-full rounded bg-theme-9"></div>
                        <div class="g-col-3 h-full rounded bg-gray-200 dark-bg-dark-2"></div>
                    </div>
                    <a href="login-light-register.html" class="intro-x text-gray-600 d-block mt-2 fs-xs fs-sm-sm">What is a
                        secure password?</a>
                    <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 d-block mt-4"
                        placeholder="Password Confirmation" name="password_confirmation" required
                        autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="intro-x mt-5 mt-xl-8 text-center text-xl-start">
                    <button type="submit" class="btn btn-primary py-3 px-4 w-full w-xl-32 me-xl-3 align-top"
                        style="width: 100% !important;">{{ __('Reset Password') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END: Reset Password Form -->
@endsection
{{-- @section('AuthenticateContent')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
