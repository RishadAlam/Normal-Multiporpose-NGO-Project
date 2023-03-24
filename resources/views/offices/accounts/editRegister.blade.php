@extends('layouts.main')

@push('title')
    {{ $register->name }}Register Profile
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">
        {{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ $register->name }} Register Profile</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="intro-y d-flex align-items-center mt-8">
            <h2 class="fs-lg fw-medium me-auto">
                Update Profile
            </h2>
        </div>
        <div class="grid columns-12 gap-6">
            <div class="g-col-12">
                <!-- BEGIN: Personal Information -->
                <div class="intro-y box mt-5">
                    <div class="d-flex align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Credentials Information
                        </h2>
                    </div>
                    <div class="p-5">
                        <form id="credentials_update"
                            action="{{ Route('accounts.register.credentials.update', $register->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="grid columns-12 gap-x-5">
                                <div class="g-col-12">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="input-form">
                                                <label for="volume" class="form-label">Volume <span
                                                        class="text-danger">*</span></label>
                                                <select id="volume" name="volume"
                                                    data-placeholder="Select your favorite actors" class="select w-full"
                                                    required>
                                                    <option disabled selected>Choose Volume...</option>
                                                    @foreach ($volumes as $volume)
                                                        <option value="{{ $volume->id }}"
                                                            {{ $volume->id == $register->volume_id ? 'selected' : '' }}>
                                                            {{ $volume->name }}</option>
                                                    @endforeach
                                                </select>

                                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger volume_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="input-form">
                                                <label for="center" class="form-label">Center <span
                                                        class="text-danger">*</span></label>
                                                <select id="center" name="center"
                                                    data-placeholder="Select your favorite actors" class="select w-full"
                                                    required>
                                                    <option disabled selected>Choose Center...</option>
                                                    @foreach ($centers as $center)
                                                        <option value="{{ $center->id }}"
                                                            {{ $center->id == $register->center_id ? 'selected' : '' }}>
                                                            {{ $center->name }}</option>
                                                    @endforeach
                                                </select>

                                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger center_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="input-form">
                                                <label for="accNo" class="form-label">Account No. <span
                                                        class="text-danger">*</span></label>
                                                <input id="accNo" type="number" name="accNo" class="form-control"
                                                    value="{{ $register->acc_no }}" required>

                                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger accNo_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 my-3">
                                            <p class="text-danger">
                                                <i class="w-4 h-4 me-2" data-feather="alert-triangle"></i>
                                                This change will effect all over the account or every Saving
                                                And loan accounts
                                            </p>
                                        </div>
                                        <div class="d-flex justify-content-end mt-4">
                                            <button type="submit" class="btn btn-primary w-20 me-auto">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END: Personal Information -->
                <!-- BEGIN: Display Information -->
                <div class="intro-y box mt-lg-5">
                    <div class="d-flex align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Personal Information
                        </h2>
                    </div>
                    <div class="p-5">
                        <form id="register_update" action="{{ Route('accounts.register.update', $register->id) }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column-reverse flex-xl-row flex-column">

                                <div class="flex-1 mt-6 mt-xl-0">
                                    <div class="grid columns-12 gap-x-5 gap-y-0">
                                        <div class="g-col-12 g-col-xxl-6">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="name" class="form-label">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input id="name" type="text" name="name" class="form-control"
                                                        placeholder="Name" value="{{ $register->name }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger name_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="husbandName" class="form-label">Husband/father's Name <span
                                                            class="text-danger">*</span></label>
                                                    <input id="husbandName" type="text" name="husbandName"
                                                        class="form-control @error('husbandName') is-invalid @enderror"
                                                        placeholder="Husband/father's Name"
                                                        value="{{ $register->husband_or_father_name }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger husbandName_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="motherName" class="form-label">Mother's
                                                        Name <span class="text-danger">*</span></label>
                                                    <input id="motherName" type="text" name="motherName"
                                                        class="form-control" placeholder="Mother's Name"
                                                        value="{{ $register->mother_name }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger motherName_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="dob" class="form-label">Birth
                                                        Reg.No/Voter ID No <span class="text-danger">*</span></label>
                                                    <input id="nid" type="number" name="nid"
                                                        class="form-control" placeholder="xxx-xxxx-xxx" maxlength="20"
                                                        value="{{ $register->nid }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger nid_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="mobile" class="form-label">Mobile <span
                                                            class="text-danger">*</span></label>
                                                    <input id="mobile" type="number" name="mobile"
                                                        class="form-control" placeholder="01xxx-xxxxxxx" maxlength="11"
                                                        minlength="11" value="{{ $register->mobile }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger mobile_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="share" class="form-label">Share <span
                                                            class="text-danger">*</span></label>
                                                    <input id="share" type="number" name="share"
                                                        class="form-control" placeholder="01xxx-xxxxxxx" maxlength="11"
                                                        minlength="11" value="{{ $register->share }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger share_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="g-col-12 g-col-xxl-6">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="academyQualify" class="form-label">Academy
                                                        Qualifications</label>
                                                    <input id="academyQualify" type="text" name="qualifications"
                                                        class="form-control" placeholder="Academy Qualifications"
                                                        maxlength="20" value="{{ $register->academic_qualification }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="dob" class="form-label">Date of
                                                        Birth <span class="text-danger">*</span></label>
                                                    <input id="dob" name="dob" class="datepicker form-control"
                                                        data-single-mode="true"
                                                        value="{{ date('d M, Y', strtotime($register->dob)) }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger dob_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="dob" class="form-label">Religion
                                                        <span class="text-danger">*</span></label>
                                                    <div class="border p-3 rounded-3">
                                                        <div class="form-check d-inline-block me-2">
                                                            <input id="Islam" class="form-check-input" type="radio"
                                                                name="religion" value="Islam"
                                                                {{ $register->religion == 'Islam' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Islam">Islam</label>
                                                        </div>
                                                        <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                                            <input id="Hindu" class="form-check-input" type="radio"
                                                                name="religion" value="Hindu"
                                                                {{ $register->religion == 'Hindu' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Hindu">Hindu</label>
                                                        </div>
                                                        <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                                            <input id="Buddha" class="form-check-input" type="radio"
                                                                name="religion" value="Buddha"
                                                                {{ $register->religion == 'Buddha' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Buddha">Buddha</label>
                                                        </div>
                                                        <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                                            <input id="Christian" class="form-check-input" type="radio"
                                                                name="religion"value="Christian"
                                                                {{ $register->religion == 'Christian' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="Christian">Christian</label>
                                                        </div>
                                                    </div>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger religion_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="dob" class="form-label">Occupation
                                                        <span class="text-danger">*</span></label>
                                                    <div class="border p-3 rounded-3">
                                                        <div class="form-check me-2 d-inline-block">
                                                            <input id="Business" class="form-check-input" type="radio"
                                                                name="occupation" value="Business"
                                                                {{ $register->occupation == 'Business' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="Business">Business</label>
                                                        </div>
                                                        <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                                            <input id="Jobs" class="form-check-input" type="radio"
                                                                name="occupation" value="Jobs"
                                                                {{ $register->occupation == 'Jobs' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Jobs">Jobs</label>
                                                        </div>
                                                        <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                                            <input id="worker" class="form-check-input" type="radio"
                                                                name="occupation" value="worker"
                                                                {{ $register->occupation == 'worker' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="worker">Worker</label>
                                                        </div>
                                                        <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                                            <input id="Driver" class="form-check-input" type="radio"
                                                                name="occupation" value="Driver"
                                                                {{ $register->occupation == 'Driver' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Driver">Driver</label>
                                                        </div>
                                                        <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                                            <input id="Rickshaw-driver" class="form-check-input"
                                                                type="radio" name="occupation" value="Rickshaw-driver"
                                                                {{ $register->occupation == 'Rickshaw-driver' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Rickshaw-driver">Rickshaw
                                                                Driver</label>
                                                        </div>
                                                        <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                                            <input id="housewife" class="form-check-input" type="radio"
                                                                name="occupation"value="housewife"
                                                                {{ $register->occupation == 'housewife' ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="housewife">Housewife</label>
                                                        </div>
                                                        <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                                            <input id="Others" class="form-check-input" type="radio"
                                                                name="occupation" value="Others"
                                                                {{ $register->occupation == 'Others' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Others">Others</label>
                                                        </div>
                                                    </div>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger occupation_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="dob" class="form-label">Gender
                                                        <span class="text-danger">*</span></label>
                                                    <div
                                                        class="border p-3 rounded-3 @error('gender') is-invalid @enderror">
                                                        <div class="form-check me-2 d-inline-block">
                                                            <input id="Male" class="form-check-input" type="radio"
                                                                name="gender" value="Male"
                                                                {{ $register->gender == 'Male' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Male">Male</label>
                                                        </div>
                                                        <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                                            <input id="Female" class="form-check-input" type="radio"
                                                                name="gender" value="Female"
                                                                {{ $register->gender == 'Female' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="Female">Female</label>
                                                        </div>
                                                        <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                                            <input id="others" class="form-check-input" type="radio"
                                                                name="gender" value="others"
                                                                {{ $register->gender == 'others' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="others">others</label>
                                                        </div>
                                                    </div>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger gender_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="g-col-12">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="presend_address" class="form-label">Present
                                                        Address</label>
                                                    <textarea id="presend_address" class="summernote" rows="3" name="presend_address">{!! $register->Present_address !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="g-col-12">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="Permanent_address" class="form-label">Permanent
                                                        Address</label>
                                                    <textarea id="Permanent_address" class="summernote" rows="3" name="Permanent_address">{!! $register->permanent_address !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" id="form_submit"
                                            class="btn btn-primary w-20 me-auto">Update</button>
                                    </div>
                                </div>
                                <div class="w-52 mx-auto me-xl-0 ms-xl-6">
                                    <div class="input-form">
                                        <label for="client_image" class="form-label">Client Image <span
                                                class="text-danger">*</span></label>
                                        <div class="w-52 @error('client_image') is-invalid @enderror">
                                            <div
                                                class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                <div
                                                    class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                    <img class="rounded-2" id="preview_client_image" alt="client_image"
                                                        src="{{ asset('storage/register/' . $register->client_image) }}">
                                                </div>
                                                <div class="mx-auto position-relative mt-5">
                                                    {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                                    <input type="hidden" name="old_img"
                                                        value="{{ $register->client_image }}">
                                                    <label for="client_image" class="btn btn-primary form-control"
                                                        style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                                    <input type="file" id="client_image" name="client_image"
                                                        class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                        onchange="getImagePreview(event, 'preview_client_image')"
                                                        accept="image/*">
                                                </div>
                                            </div>
                                        </div>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger client_image_error"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END: Display Information -->
            </div>
        </div>
    </div>
@endsection
@section('customJS')
    <script>
        // For Preview
        function getImagePreview(event, path) {
            var image = URL.createObjectURL(event.target.files[0]);
            var imagediv = document.getElementById(path);
            imagediv.src = '';
            imagediv.src = image;
        }

        $(document).ready(function() {
            // Submit Form
            $('#register_update').on('submit', function(e) {
                e.preventDefault()
                var formData = new FormData(this)
                var btn = $("#form_submit")

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.attr('disabled', true)
                        $("#overlayer").fadeIn()
                        $("#preloader").fadeIn()
                    },
                    success: function(data) {
                        $("#overlayer").fadeOut()
                        $("#preloader").fadeOut()
                        btn.attr('disabled', false)
                        if (data.errors) {
                            // Validation Message
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: '<b class="text-danger">All fields are required!</b>',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            // Validation Message Loop
                            $("span.text-danger").text('')
                            $.each(data.errors, function(key, value) {
                                $("span." + key + "_error").text(value[0])
                                $("input[name=" + key + "]").addClass('is-invalid')
                            })
                        } else if (data.success) {
                            // Success Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: true,
                            }).then((result) => {
                                // location.reload()
                                $(location).prop("href",
                                    "{{ Route('accounts', ['name' => request()->name, 'id' => request()->id]) }}"
                                )
                            })
                        } else {
                            // Error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Register Update unsuccessfull!',
                                showConfirmButton: true,
                            })
                        }
                    },
                    error: function(data) {
                        $("#overlayer").fadeOut()
                        $("#preloader").fadeOut()
                        btn.attr('disabled', false)
                        console.log(data)
                        // Error Msg Show
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Register Update unsuccessfull!',
                            showConfirmButton: true,
                        })
                    }
                })
            })

            $('#credentials_update').on('submit', function(e) {
                e.preventDefault()
                var formData = new FormData(this)
                var btn = $("#form_submit")

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.attr('disabled', true)
                        $("#overlayer").fadeIn()
                        $("#preloader").fadeIn()
                    },
                    success: function(data) {
                        $("#overlayer").fadeOut()
                        $("#preloader").fadeOut()
                        btn.attr('disabled', false)
                        if (data.errors) {
                            // Validation Message
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: '<b class="text-danger">All fields are required!</b>',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            // Validation Message Loop
                            $("span.text-danger").text('')
                            $.each(data.errors, function(key, value) {
                                $("span." + key + "_error").text(value[0])
                                $("input[name=" + key + "]").addClass('is-invalid')
                            })
                        } else if (data.success) {
                            // Success Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: true,
                            }).then((result) => {
                                // location.reload()
                                $(location).prop("href",
                                    "{{ Route('accounts', ['name' => request()->name, 'id' => request()->id]) }}"
                                )
                            })
                        } else {
                            // Error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Register Update unsuccessfull!',
                                showConfirmButton: true,
                            })
                        }
                    },
                    error: function(data) {
                        $("#overlayer").fadeOut()
                        $("#preloader").fadeOut()
                        btn.attr('disabled', false)
                        console.log(data)
                        // Error Msg Show
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Register Update unsuccessfull!',
                            showConfirmButton: true,
                        })
                    }
                })
            })
        })
    </script>
@endsection
