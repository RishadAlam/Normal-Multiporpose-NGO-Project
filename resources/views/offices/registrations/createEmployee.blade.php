@extends('layouts.main')

@push('title')
    {{ __('Employee Register') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Registrations') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Employee Register') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}
        <!-- BEGIN: Create Employee -->
        <div class="card rounded rounded-3 mx-auto" style="max-width: 1000px;">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Employee Register</b>
            </div>
            <form method="POST" action="{{ route('registration.employee.create') }}">
                @csrf

                <div class="card-body">
                    <!-- START: Registration Form -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="name" class="form-label">Employee Name
                                    <span class="text-danger">*</span></label>
                                <input id="name" type="Text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    placeholder="Employee Name" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="email" class="form-label">Email Address
                                    <span class="text-danger">*</span></label>
                                <input id="email" type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    placeholder="Email Address" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input id="mobile" type="number" name="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror" placeholder="mobile Number"
                                    value="{{ old('mobile') }}" autocomplete="mobile" autofocus maxlength="11"
                                    minlength="11">

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="Role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select id="Role" name="role" data-placeholder="Select your favorite actors"
                                    class="tom-select w-full @error('Role') is-invalid @enderror">
                                    <option disabled selected>Choose Role...</option>
                                    @forelse ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $role->id == old('role') ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @empty
                                        <option disabled selected>No Roles Found!</option>
                                    @endforelse
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form position-relative">
                                <label for="password" class="form-label">Password
                                    <span class="text-danger">*</span></label>
                                <input id="password" type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="password"
                                    required autocomplete="new-password" autofocus>

                                <span toggle="#password" class="field-icon toggle-password cursor-pointer"
                                    style="color: var(--primary_color);"><i class='bx bx bx-lock'></i></span>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form position-relative">
                                <label for="password-confirm" class="form-label">Confirm Password
                                    <span class="text-danger">*</span></label>
                                <input id="password-confirm" type="password" name="password_confirmation"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    placeholder="Confirm Password" required autocomplete="new-password" autofocus>

                                <span toggle="#password-confirm" class="field-icon toggle-password cursor-pointer"
                                    style="color: var(--primary_color);"><i class='bx bx bx-lock'></i></span>
                            </div>
                        </div>
                    </div>
                    <!-- END: Registration Form -->
                </div>
                <div class="card-footer">
                    <button type="submit" class="form-control btn btn-primary mt-5">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
        <!-- BEGIN: Create Employee -->
    </div>
@endsection

@section('customJS')
    <script>
        @if (session()->has('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: true,
            })
        @endif
    </script>
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
