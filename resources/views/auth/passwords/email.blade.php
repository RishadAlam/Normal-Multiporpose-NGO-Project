@extends('layouts.app')

@push('appTitle')
    {{ __('Reset Password') }}
@endpush

@section('AuthenticateContent')
    <!-- BEGIN: Login Form -->
    <div class="g-col-2 g-col-xl-1 h-screen h-xl-auto d-flex py-5 py-xl-0 my-10 my-xl-0">
        <div
            class="my-auto mx-auto ms-xl-20 bg-white dark-bg-dark-1 bg-xl-transparent px-5 px-sm-8 py-8 p-xl-0 rounded-2 shadow-md shadow-xl-none w-full w-sm-3/4 w-lg-2/4 w-xl-auto">
            <h2 class="intro-x fw-bold fs-2xl fs-xl-3xl text-center text-xl-start">
                {{ __('Reset Password') }}
            </h2>
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-2" role="alert">
                    <i data-feather="send" class="d-block mx-auto"></i> &nbsp;&nbsp;
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i data-feather="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="intro-x mt-8">
                    <input type="email"
                        class="intro-x login__input form-control py-3 px-4 border-gray-300 d-block @error('email') is-invalid @enderror"
                        placeholder="{{ __('Email Address') }}" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <div class="intro-x mt-xl-8 text-center text-xl-start">
                    <button type="submit" class="btn btn-primary py-3 px-4 w-full w-xl-32 me-xl-3 align-top"
                        style="width: 100% !important;">{{ __('Send Password Reset Link') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- END: Login Form -->
@endsection
{{-- @section('AuthenticateContent')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
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
