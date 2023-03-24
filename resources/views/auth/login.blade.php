@extends('layouts.app')

@push('appTitle')
    {{ __('Login') }}
@endpush

@section('AuthenticateContent')
    <!-- BEGIN: Login Form -->
    <div class="g-col-2 g-col-xl-1 h-screen h-xl-auto d-flex py-5 py-xl-0 my-10 my-xl-0">
        <div
            class="my-auto mx-auto ms-xl-20 bg-white dark-bg-dark-1 bg-xl-transparent px-5 px-sm-8 py-8 p-xl-0 rounded-2 shadow-md shadow-xl-none w-full w-sm-3/4 w-lg-2/4 w-xl-auto">
            <h2 class="intro-x fw-bold fs-2xl fs-xl-3xl text-center text-xl-start">
                {{ __('Login') }}

                @error('g-recaptcha-response')
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mt-2" role="alert"
                        style="font-size: 16px;">
                        <i data-feather="alert-octagon" class="w-6 h-6 me-2"></i>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i data-feather="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                @enderror
            </h2>
            <form method="POST" action="{{ route('login') }}">
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


                    <input type="password" id="password-field" class="intro-x login__input form-control py-3 px-4 border-gray-300 d-block mt-4 @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">
                    <span toggle="#password-field" class="field-icon toggle-password cursor-pointer" style="color: var(--primary_color);"><i class='bx bx bx-lock'></i> Show/Hide Password</span>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="intro-x d-flex text-gray-700 dark-text-gray-600 fs-xs fs-sm-sm mt-4">
                    <div class="d-flex align-items-center me-auto">
                        <input id="remember-me" type="checkbox" class="form-check-input border me-2" name="remember"
                            id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="cursor-pointer select-none" for="remember-me">{{ __('Remember Me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                    @endif
                </div>
                <div class="intro-x mt-5 mt-xl-8 text-center text-xl-start">
                    {{-- <button type="submit"
                        class="btn btn-primary py-3 px-4 w-full w-xl-32 me-xl-3 align-top">{{ __('Login') }}</button> --}}
                    {!! RecaptchaV3::field('Login') !!}
                    <input type="submit" class="btn btn-primary py-3 px-4 w-full w-xl-32 me-xl-3 align-top"
                        value="Login"></input>
                    {{-- <!--<a href="{{ route('register') }}"
                                                        class="btn btn-outline-secondary py-3 px-4 w-full w-xl-32 mt-3 mt-xl-0 align-top">{{ _('Sign
                                                                                                                                                                                                                                                                                                                                                                                                                                                up') }}</a>--> --}}
                </div>
            </form>
        </div>
    </div>
    <!-- END: Login Form -->
@endsection

@section('appCustomJS')
    <!-- My script -->
  <script type="text/javascript">
    (function($) {
      // "use strict";
      $(".toggle-password").click(function() {
        //   $(this).children("i").toggle('<i class="bx bx-lock-open"></i>');
        if ($(this).children("i").hasClass("bx bx-lock")) {
          $(this).children("i").removeClass();
          $(this).children("i").addClass("bx bx-key");
        } else {
          $(this).children("i").removeClass();
          $(this).children("i").addClass("bx bx-lock");
        }
        //   $(this).html() == '<i class="bx bx-lock">'
        //     ? $(this).html('<i class="bx bx-lock-open"></i>')
        //     : $(this).html('<i class="bx bx-lock">');

        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });
    })(jQuery);
  </script>
@endsection
