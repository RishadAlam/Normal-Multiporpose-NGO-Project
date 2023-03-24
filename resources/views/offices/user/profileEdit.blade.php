@extends('layouts.main')

@push('title')
    Profile Edit
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Profile') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Profile Edit') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}
        <!-- BEGIN: Create Employee -->
        <div class="card rounded rounded-3 mx-auto" style="max-width: 1000px;">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Profile Edit</b>
            </div>
            <form method="POST" action="{{ route('userProfile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <!-- START: Registration Form -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="name" class="form-label">Name
                                    <span class="text-danger">*</span></label>
                                <input id="name" type="Text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ auth()->user()->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="father_name" class="form-label">Father Name</label>
                                <input id="father_name" type="text" name="father_name"
                                    class="form-control @error('father_name') is-invalid @enderror"
                                    value="{{ auth()->user()->father_name }}" autocomplete="father_name">

                                @error('father_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="mother_name" class="form-label">Mother Name</label>
                                <input id="mother_name" type="text" name="mother_name"
                                    class="form-control @error('mother_name') is-invalid @enderror"
                                    value="{{ auth()->user()->mother_name }}" autocomplete="mother_name">

                                @error('mother_name')
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
                                    value="{{ auth()->user()->mobile }}" autocomplete="mobile" autofocus maxlength="11"
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
                                <label for="nid" class="form-label">NID</label>
                                <input id="nid" type="number" name="nid"
                                    class="form-control @error('nid') is-invalid @enderror" placeholder="NID Number"
                                    value="{{ auth()->user()->nid }}" autocomplete="nid" autofocus maxlength="11"
                                    minlength="11">

                                @error('nid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Date of
                                    Birth <span class="text-danger">*</span></label>
                                <input id="dob" name="dob"
                                    class="datepicker form-control @error('dob') is-invalid @enderror"
                                    data-single-mode="true" value="{{ date('d M, Y', strtoTime(auth()->user()->dob)) }}">

                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label class="small mb-1" for="bloog_group">রক্তের গ্রুপ</label>
                                <select class="form-control select @error('bloog_group') is-invalid @enderror"
                                    style="height: 50px;" id="bloog_group" name="bloog_group">
                                    <option disabled selected>Choose Blood Group...</option>
                                    <option {{ auth()->user()->bloog_group == 'A+' ? 'selected' : '' }} value="A+">A+
                                    </option>
                                    <option {{ auth()->user()->bloog_group == 'A-' ? 'selected' : '' }} value="A-">A-
                                    </option>
                                    <option {{ auth()->user()->bloog_group == 'B+' ? 'selected' : '' }} value="B+">B+
                                    </option>
                                    <option {{ auth()->user()->bloog_group == 'B-' ? 'selected' : '' }} value="B-">B-
                                    </option>
                                    <option {{ auth()->user()->bloog_group == 'AB+' ? 'selected' : '' }} value="AB+">
                                        AB+
                                    </option>
                                    <option {{ auth()->user()->bloog_group == 'AB' ? 'selected' : '' }} value="AB">AB
                                    </option>
                                    <option {{ auth()->user()->bloog_group == 'O+' ? 'selected' : '' }} value="O+">O+
                                    </option>
                                    <option {{ auth()->user()->bloog_group == 'O-' ? 'selected' : '' }} value="O-">O-
                                    </option>
                                </select>

                                @error('bloog_group')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                                <div class="w-52 @error('image') is-invalid @enderror">
                                    <div
                                        class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                        <div class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                            <img class="rounded-2" id="preview_image" alt="image"
                                                src="{{ asset('storage/user/' . auth()->user()->image) }}">
                                        </div>
                                        <div class="mx-auto position-relative mt-5">
                                            {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                            <label for="image" class="btn btn-primary form-control"
                                                style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                            <input type="file" id="image" name="image"
                                                class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                onchange="getImagePreview(event, 'preview_image')" accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                @error('image')
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
            }).then((result) => {
                $(location).prop("href",
                    "{{ Route('userProfile') }}"
                )
            })
        @endif

        // For Preview
        function getImagePreview(event, path) {
            var image = URL.createObjectURL(event.target.files[0]);
            var imagediv = document.getElementById(path);
            imagediv.src = '';
            imagediv.src = image;
        }
    </script>
@endsection
