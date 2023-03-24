@extends('layouts.main')

@push('title')
    {{ __('Settings') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Registrations') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Settings') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        <!-- Modal -->
        <!-- BEGIN: Create Employee -->
        <div class="card rounded rounded-3 mx-auto" style="width: 80%;">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Settings</b>
            </div>
            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <!-- START: Registration Form -->
                    <div class="row">
                        <div class="col-md-12 mb-4 text-center">
                            <div class="w-52 mx-auto @error('logo') is-invalid @enderror">
                                <div
                                    class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                    <div class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                        <img class="rounded-2" id="preview_logo" alt="logo"
                                            src="{{ asset('storage/settings/' . $setting->logo) }}">
                                    </div>
                                    <div class="mx-auto position-relative mt-5">
                                        {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                        <label for="logo" class="btn btn-primary w-full">Change Logo</label>
                                        <input type="file" id="logo" name="logo"
                                            class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                            onchange="getImagePreview(event)">
                                        <input type="hidden" name="old_logo" value="{{ $setting->logo }}" />
                                    </div>
                                </div>
                            </div>
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="full_name" class="form-label">Company Full Name
                                    <span class="text-danger">*</span></label>
                                <input id="full_name" type="Text" name="full_name"
                                    class="form-control @error('full_name') is-invalid @enderror"
                                    value="{{ $setting->full_name }}" required autocomplete="full_name" autofocus>

                                @error('full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="short_name" class="form-label">Company Short Name
                                    <span class="text-danger">*</span></label>
                                <input id="short_name" type="Text" name="short_name"
                                    class="form-control @error('short_name') is-invalid @enderror"
                                    value="{{ $setting->short_name }}" required autocomplete="short_name" autofocus>

                                @error('short_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="tagline" class="form-label">Company Tagline
                                    <span class="text-danger">*</span></label>
                                <input id="tagline" type="Text" name="tagline"
                                    class="form-control @error('tagline') is-invalid @enderror"
                                    value="{{ $setting->tagline }}" required autocomplete="tagline" autofocus>

                                @error('tagline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="input-form">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <textarea id="address" class="summernote" rows="3" name="address">{!! $setting->address !!}</textarea>

                                @error('address')
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
                    <button type="submit" class="form-control btn btn-primary mt-5">{{ __('Update') }}</button>
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

        // For Preview
        function getImagePreview(event) {
            var image = URL.createObjectURL(event.target.files[0]);
            var imagediv = document.getElementById('preview_logo');
            imagediv.src = '';
            imagediv.src = image;
        }
    </script>
@endsection
