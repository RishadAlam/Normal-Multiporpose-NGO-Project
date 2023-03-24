@extends('layouts.main')

@push('title')
    {{ request()->name }} {{ $activeSavings->type->name }} Profile
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">
        {{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ request()->name }} {{ $activeSavings->type->name }} Profile</a>
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
                <!-- BEGIN: Display Information -->
                <div class="intro-y box mt-lg-5">
                    <div class="d-flex align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            {{ request()->name }} {{ $activeSavings->type->name }} Account Information
                        </h2>
                    </div>
                    <div class="p-5">
                        <form id="savings_update" action="{{ Route('accounts.activeSavings.update', $activeSavings->id) }}"
                            method="post">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column-reverse flex-xl-row flex-column">

                                <div class="flex-1 mt-6 mt-xl-0">
                                    <div class="grid columns-12 gap-x-5 gap-y-0">
                                        <div class="g-col-12 g-col-xxl-6">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="savingType" class="form-label">Saving Type <span
                                                            class="text-danger">*</span></label>
                                                    <select id="savingType" name="savingType"
                                                        data-placeholder="Select your favorite actors"
                                                        class="select w-full">
                                                        <option disabled selected>Choose Saving Type...</option>
                                                        @foreach ($types as $type)
                                                            <option value="{{ $type->id }}"
                                                                {{ $type->id == $activeSavings->type_id ? 'selected' : '' }}>
                                                                {{ $type->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger savingType_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="deposit" class="form-label">Deposit
                                                        <span class="text-danger">*</span></label>
                                                    <input id="deposit" type="number" name="deposit" class="form-control"
                                                        value="{{ $activeSavings->deposit }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger deposit_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="startDate" class="form-label">Start date <span
                                                            class="text-danger">*</span></label>
                                                    <input id="startDate" name="startDate" class="datepicker form-control"
                                                        data-single-mode="true"
                                                        value="{{ date('d M, Y', strtotime($activeSavings->start_date)) }}"
                                                        required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger startDate_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="installment" class="form-label">Duration date <span
                                                            class="text-danger">*</span></label>
                                                    <input id="Duration" name="duration" class="datepicker form-control"
                                                        data-single-mode="true"
                                                        value="{{ date('d M, Y', strtotime($activeSavings->duration_date)) }}"
                                                        required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger duration_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="g-col-12 g-col-xxl-6">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="installment" class="form-label">Installment
                                                        <span class="text-danger">*</span></label>
                                                    <input id="installment" type="number" name="installment"
                                                        class="form-control @error('installment') is-invalid @enderror"
                                                        value="{{ $activeSavings->installment }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger installment_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="totalWithoutInterest" class="form-label">Total except
                                                        Interest
                                                        <span class="text-danger">*</span></label>
                                                    <input id="totalWithoutInterest" type="number"
                                                        name="totalWithoutInterest" class="form-control"
                                                        value="{{ $activeSavings->total_except_interest }}" required
                                                        readonly>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger totalWithoutInterest_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="interest" class="form-label">Interest (%)
                                                        <span class="text-danger">*</span></label>
                                                    <input id="interest" type="number" name="interest"
                                                        class="form-control" value="{{ $activeSavings->interest }}"
                                                        required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger interest_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="totalWithInterest" class="form-label">Total include
                                                        Interest
                                                        <span class="text-danger">*</span></label>
                                                    <input id="totalWithInterest" type="number" name="totalWithInterest"
                                                        class="form-control"
                                                        value="{{ $activeSavings->total_include_interest }}" required
                                                        readonly>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger totalWithInterest_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" id="form_submit"
                                            class="btn btn-primary w-20 me-auto">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- END: Display Information -->

                @foreach ($activeSavings->SavingNominee as $key => $SavingNominee)
                    <div class="intro-y box mt-lg-5">
                        <div class="d-flex align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                            <h2 class="fw-medium fs-base me-auto">
                                Nominee-{{ ++$key }} Information
                            </h2>
                        </div>
                        <div class="p-5">
                            <form class="nominee_update"
                                action="{{ Route('accounts.activeSavingsNominee.update', $SavingNominee->id) }}"
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
                                                        <input id="name" type="text" name="name"
                                                            class="form-control" value="{{ $SavingNominee->name }}"
                                                            required>

                                                        <span
                                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger name_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-form">
                                                        <label for="dob" class="form-label">Date of
                                                            Birth <span class="text-danger">*</span></label>
                                                        <input id="dob" name="dob"
                                                            class="datepicker form-control"
                                                            value="{{ date('d M, Y', strtotime($SavingNominee->dob)) }}"
                                                            data-single-mode="true" required>

                                                        <span
                                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger dob_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="g-col-12 g-col-xxl-6">
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-form">
                                                        <label for="segment" class="form-label">Segment (%)</label>
                                                        <input id="segment" type="number" name="segment"
                                                            class="form-control" value="{{ $SavingNominee->segment }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-form">
                                                        <label for="relation" class="form-label">Relation <span
                                                                class="text-danger">*</span></label>
                                                        <select id="relation" name="relation"
                                                            class="form-control select">
                                                            <option value="Husband/Wife"
                                                                {{ $SavingNominee->relation == 'Husband/Wife' ? 'selected' : '' }}>
                                                                Husband/Wife</option>
                                                            <option value="Brother/sister"
                                                                {{ $SavingNominee->relation == 'Brother/sister' ? 'selected' : '' }}>
                                                                Brother/sister</option>
                                                            <option value="Father/Daughter"
                                                                {{ $SavingNominee->relation == 'Father/Daughter' ? 'selected' : '' }}>
                                                                Father/Daughter</option>
                                                            <option value="Mother/Daughter"
                                                                {{ $SavingNominee->relation == '' ? 'selected' : '' }}>
                                                                Mother/Daughter</option>
                                                            <option value="Father/Son"
                                                                {{ $SavingNominee->relation == 'Father/Son' ? 'selected' : '' }}>
                                                                Father/Son</option>
                                                            <option value="Mother/Son"
                                                                {{ $SavingNominee->relation == 'Mother/Son' ? 'selected' : '' }}>
                                                                Mother/Son</option>
                                                            <option value="Sister/Sister"
                                                                {{ $SavingNominee->relation == 'Sister/Sister' ? 'selected' : '' }}>
                                                                Sister/Sister</option>
                                                            <option value="Brother/Brother"
                                                                {{ $SavingNominee->relation == 'Brother/Brother' ? 'selected' : '' }}>
                                                                Brother/Brother</option>
                                                            <option value="Others"
                                                                {{ $SavingNominee->relation == 'Others' ? 'selected' : '' }}>
                                                                Others
                                                            </option>
                                                        </select>

                                                        <span
                                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger relation_error"></span>
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
                                            <label for="nominee_image" class="form-label">Client Image <span
                                                    class="text-danger">*</span></label>
                                            <div class="w-52">
                                                <div
                                                    class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                    <div
                                                        class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                        <img class="rounded-2"
                                                            id="preview_nominee_image_{{ $SavingNominee->id }}"
                                                            alt="nominee_image"
                                                            src="{{ asset('storage/nominee/' . $SavingNominee->nominee_image) }}">
                                                    </div>
                                                    <div class="mx-auto position-relative mt-5">
                                                        {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                                        <input type="hidden" name="old_img"
                                                            value="{{ $activeSavings->nominee_image }}">
                                                        <label for="nominee_image" class="btn btn-primary form-control"
                                                            style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                                        <input type="file" id="nominee_image" name="nominee_image"
                                                            class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                            onchange="getImagePreview(event, 'preview_nominee_image_{{ $SavingNominee->id }}')"
                                                            accept="image/*">
                                                    </div>
                                                </div>
                                            </div>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger client_image_error"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
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
            $("#installment").on("keyup", function() {
                totalValue();
            })

            $("#deposit").on("keyup", function() {
                totalValue();
            })

            $("#interest").on("keyup", function() {
                totalValue();
            })
            // Total Calculation
            function totalValue() {
                var installment = $("#installment").val();
                var deposit = $("#deposit").val();
                var interest = $("#interest").val();
                var ceil = Math.round(installment * deposit);
                var total = ceil;
                var total_int = ((total / 100) * interest);
                var total_with_int = Math.round(parseFloat(total) + parseFloat(total_int));
                $("#totalWithoutInterest").val(ceil);
                $("#totalWithInterest").val(total_with_int);
            }

            // Submit Form
            $('#savings_update').on('submit', function(e) {
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
                                    "{{ Route('accounts', ['name' => request()->name, 'id' => $activeSavings->client_id]) }}"
                                )
                            })
                        } else {
                            // Error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Update unsuccessfull!',
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
                            title: 'Update unsuccessfull!',
                            showConfirmButton: true,
                        })
                    }
                })
            })

            // Submit Form
            $('.nominee_update').on('submit', function(e) {
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
                                    "{{ Route('accounts', ['name' => request()->name, 'id' => $activeSavings->client_id]) }}"
                                )
                            })
                        } else {
                            // Error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Update unsuccessfull!',
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
                            title: 'Update unsuccessfull!',
                            showConfirmButton: true,
                        })
                    }
                })
            })
        })
    </script>
@endsection
