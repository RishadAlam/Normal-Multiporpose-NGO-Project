@extends('layouts.main')

@push('title')
    {{ auth()->user()->name }} Profile
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">
        {{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ auth()->user()->name }} Profile</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="intro-y d-flex align-items-center">
            <h2 class="fs-lg fw-medium me-auto">
                {{ auth()->user()->name }}'s Profile
            </h2>
        </div>
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="d-flex flex-column flex-lg-row border-bottom border-gray-200 dark-border-dark-5 pb-5 mx-n5">
                <div class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                    <div class="w-20 h-20 w-sm-24 h-sm-24 flex-none w-lg-32 h-lg-32 image-fit position-relative">
                        <img alt="User" class="rounded-circle"
                            src="{{ asset('storage/user/' . auth()->user()->image) }}">
                    </div>
                    <div class="ms-5">
                        <div class="w-24 w-sm-40 truncate white-space-sm-wrap fw-medium fs-lg">{{ auth()->user()->name }}
                        </div>
                        <div class="text-gray-600">{{ auth()->user()->roles[0]->name }}</div>
                    </div>
                </div>
                <div
                    class="mt-6 mt-lg-0 flex-1 dark-text-gray-300 px-5 border-start border-end border-gray-200 dark-border-dark-5 border-top border-top-lg-0 pt-5 pt-lg-0">
                    <div class="fw-medium text-center text-lg-start mt-lg-3">Contact Details</div>
                    <div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start mt-4">
                        <div class="truncate white-space-sm-normal d-flex align-items-center">
                            <i data-feather="mail" class="w-4 h-4 me-2"></i>
                            {{ auth()->user()->email }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="phone-call" class="w-4 h-4 me-2"></i>
                            {{ auth()->user()->mobile }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 mt-lg-0 flex-1 dark-text-gray-300 px-5 border-start border-end border-gray-200 dark-border-dark-5 border-top border-top-lg-0 pt-5 pt-lg-0">
                    <div class="fw-medium text-center text-lg-start mt-lg-3">Personal Details</div>
                    <div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start mt-4">
                        <div class="truncate white-space-sm-normal d-flex align-items-center">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Father:</span>
                            {{ auth()->user()->father_name }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Mother:</span>
                            {{ auth()->user()->mother_name }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">NID:</span>
                            {{ auth()->user()->nid }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Date of
                                Birth:</span>
                            {{ date('d M, Y', strtotime(auth()->user()->dob)) }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Blood Group:</span>
                            {{ auth()->user()->bloog_group }}
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ Route('userProfile.edit') }}" class="btn btn-warning text-light mt-5 w-full">Edit Profile</a>
        </div>
        <!-- END: Profile Info -->
        <!-- START: Profile Details -->
        <div class="intro-y tab-content mt-5">
            <!-- BEGIN: Create Employee -->
            <div class="card rounded rounded-3 mx-auto" style="max-width: 500px;">
                <div class="card-header py-5 text-center">
                    <b class="text-uppercase" style="font-size: 22px;">Change Your Password</b>
                </div>
                <form method="POST" action="{{ route('userProfile.passwordChenge') }}">
                    @csrf

                    <div class="card-body">
                        <!-- START: Registration Form -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="input-form position-relative">
                                    <label for="current_password" class="form-label">Current Password
                                        <span class="text-danger">*</span></label>
                                    <input id="current_password" type="password" name="current_password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        placeholder="Current Password" required autofocus>

                                    <span toggle="#current_password" class="field-icon toggle-password cursor-pointer"
                                        style="color: var(--primary_color);"><i class='bx bx bx-lock'></i></span>

                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-form position-relative">
                                    <label for="new_password" class="form-label">New Password
                                        <span class="text-danger">*</span></label>
                                    <input id="new_password" type="password" name="new_password"
                                        class="form-control @error('new_password') is-invalid @enderror"
                                        placeholder="New Password" required autocomplete="new_password" autofocus>

                                    <span toggle="#new_password" class="field-icon toggle-password cursor-pointer"
                                        style="color: var(--primary_color);"><i class='bx bx bx-lock'></i></span>

                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="input-form position-relative">
                                    <label for="confirm_password" class="form-label">Confirm Password
                                        <span class="text-danger">*</span></label>
                                    <input id="confirm_password" type="password" name="confirm_password"
                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                        placeholder="Confirm Password" required autocomplete="new-password" autofocus>

                                    @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- END: Registration Form -->
                    </div>
                    <div class="card-footer">
                        <button type="submit"
                            class="form-control btn btn-primary mt-5">{{ __('Change Password') }}</button>
                    </div>
                </form>
            </div>
            <!-- BEGIN: Create Employee -->
        </div>
    </div>
    <!-- END: Profile Details -->
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
        @if (Session::has('errors'))
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: "{{ Session::get('errors')->first() }}",
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
