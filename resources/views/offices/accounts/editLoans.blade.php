@extends('layouts.main')

@push('title')
    {{ request()->name }} {{ $activeLoans->type->name }} Profile
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">
        {{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ request()->name }} {{ $activeLoans->type->name }} Profile</a>
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
                            {{ request()->name }} {{ $activeLoans->type->name }} Account Information
                        </h2>
                    </div>
                    <div class="p-5">
                        <form id="loans_update" action="{{ Route('accounts.activeLoans.update', $activeLoans->id) }}"
                            method="post">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column-reverse flex-xl-row flex-column">

                                <div class="flex-1 mt-6 mt-xl-0">
                                    <div class="grid columns-12 gap-x-5 gap-y-0">
                                        <div class="g-col-12 g-col-xxl-6">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="loanType" class="form-label">Loan Type <span
                                                            class="text-danger">*</span></label>
                                                    <select id="loanType" name="loanType" class="select w-full">
                                                        <option disabled selected>Choose Loan Type...</option>
                                                        @foreach ($types as $type)
                                                            <option value="{{ $type->id }}"
                                                                {{ $type->id == $activeLoans->type_id ? 'selected' : '' }}>
                                                                {{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loanType_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="deposit" class="form-label">Deposit (Installment)
                                                        <span class="text-danger">*</span></label>
                                                    <input id="deposit" type="number" name="deposit" class="form-control"
                                                        value="{{ $activeLoans->deposit }}" required>

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
                                                        value="{{ date('d M, Y', strtotime($activeLoans->start_date)) }}"
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
                                                        value="{{ date('d M, Y', strtotime($activeLoans->duration_date)) }}"
                                                        required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger duration_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="loan_giving" class="form-label">Loan Given
                                                        <span class="text-danger">*</span></label>
                                                    <input id="loan_giving" type="number" name="loan_giving"
                                                        class="form-control" placeholder="xxxx"
                                                        value="{{ $activeLoans->loan_given }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loan_giving_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="installment" class="form-label">Total Installment
                                                        <span class="text-danger">*</span></label>
                                                    <input id="installment" type="number" name="installment"
                                                        class="form-control" placeholder="xxxx"
                                                        value="{{ $activeLoans->total_installment }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger installment_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="g-col-12 g-col-xxl-6">
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="interest" class="form-label">Interest (%)
                                                        <span class="text-danger">*</span></label>
                                                    <input id="interest" type="number" name="interest"
                                                        class="form-control" value="{{ $activeLoans->interest }}" required>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger interest_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="totalInterest" class="form-label">Total Interest
                                                        <span class="text-danger">*</span></label>
                                                    <input id="totalInterest" type="number" name="totalInterest"
                                                        class="form-control" value="{{ $activeLoans->total_interest }}"
                                                        required readonly>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger totalInterest_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="totalWithInterest" class="form-label">Total Loan include
                                                        Interest
                                                        <span class="text-danger">*</span></label>
                                                    <input id="totalWithInterest" type="number" name="totalWithInterest"
                                                        class="form-control"
                                                        value="{{ $activeLoans->total_loan_inc_int }}" required readonly>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger totalWithInterest_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="fixedLoanInstallment" class="form-label">Loan
                                                        (Installment)
                                                        <span class="text-danger">*</span></label>
                                                    <input id="fixedLoanInstallment" type="number"
                                                        name="fixedLoanInstallment" class="form-control"
                                                        value="{{ $activeLoans->loan_installment }}" required readonly>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger fixedLoanInstallment_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <div class="input-form">
                                                    <label for="fixedInterestInstallment" class="form-label">Interest
                                                        (Installment)
                                                        <span class="text-danger">*</span></label>
                                                    <input id="fixedInterestInstallment" type="number"
                                                        name="fixedInterestInstallment" class="form-control"
                                                        value="{{ $activeLoans->interest_installment }}" required
                                                        readonly>

                                                    <span
                                                        class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger fixedInterestInstallment_error"></span>
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

                @foreach ($activeLoans->LoanGuarantor as $key => $LoanGuarantor)
                    <div class="intro-y box mt-lg-5">
                        <div class="d-flex align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                            <h2 class="fw-medium fs-base me-auto">
                                Guarantor-{{ ++$key }} Information
                            </h2>
                        </div>
                        <div class="p-5">
                            <form class="guarantor_update"
                                action="{{ Route('accounts.activeLoansGuarantor.update', $LoanGuarantor->id) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="d-flex flex-column-reverse flex-xl-row flex-column">

                                    <div class="flex-1 mt-6 mt-xl-0">
                                        <div class="grid columns-12 gap-x-5 gap-y-0">
                                            <div class="g-col-12 g-col-xxl-6">
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-form">
                                                        <label for="guarantor_name" class="form-label">Name <span
                                                                class="text-danger">*</span></label>
                                                        <input id="guarantor_name" type="text" name="guarantor_name"
                                                            class="form-control" value="{{ $LoanGuarantor->name }}"
                                                            required>

                                                        <span
                                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_name_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-form">
                                                        <label for="guarantor_fatherName" class="form-label">Father's
                                                            Name <span class="text-danger">*</span></label>
                                                        <input id="guarantor_fatherName" type="text"
                                                            name="guarantor_fatherName" class="form-control"
                                                            value="{{ $LoanGuarantor->father_name }}" required>

                                                        <span
                                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_fatherName_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="g-col-12 g-col-xxl-6">
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-form">
                                                        <label for="guarantor_motherName" class="form-label">Mother's
                                                            Name <span class="text-danger">*</span></label>
                                                        <input id="guarantor_motherName" type="text"
                                                            name="guarantor_motherName" class="form-control"
                                                            value="{{ $LoanGuarantor->mother_name }}" required>

                                                        <span
                                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_motherName_error"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-form">
                                                        <label for="guarantor_nid" class="form-label">Birth
                                                            Reg.No/Voter ID No <span class="text-danger">*</span></label>
                                                        <input id="guarantor_nid" type="number" name="guarantor_nid"
                                                            class="form-control" value="{{ $LoanGuarantor->nid }}"
                                                            maxlength="20" required>

                                                        <span
                                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_nid_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="g-col-12">
                                                <div class="col-md-12 mb-3">
                                                    <div class="input-form">
                                                        <label for="address" class="form-label">Address</label>
                                                        <textarea id="address" class="summernote" rows="3" name="address">{!! $LoanGuarantor->address !!}</textarea>
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
                                            <label for="guarantor_image" class="form-label">Image <span
                                                    class="text-danger">*</span></label>
                                            <div class="w-52">
                                                <div
                                                    class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                    <div
                                                        class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                        <img class="rounded-2"
                                                            id="preview_guarantor_image_{{ $LoanGuarantor->id }}"
                                                            alt="guarantor_image"
                                                            src="{{ asset('storage/guarantor/' . $LoanGuarantor->guarentor_image) }}">
                                                    </div>
                                                    <div class="mx-auto position-relative mt-5">
                                                        {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                                        <input type="hidden" name="old_img"
                                                            value="{{ $LoanGuarantor->guarentor_image }}">
                                                        <label for="guarantor_image" class="btn btn-primary form-control"
                                                            style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                                        <input type="file" id="guarantor_image" name="guarantor_image"
                                                            class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                            onchange="getImagePreview(event, 'preview_guarantor_image_{{ $LoanGuarantor->id }}')"
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

            $("#loan_giving").on("keyup", function() {
                totalValue();
            })

            $("#interest").on("keyup", function() {
                totalValue();
            })
            // Total Calculation
            function totalValue(total_loan, loan_ints) {
                var expiry_date = $("#installment").val();
                var interest = $("#interest").val();
                var total = $("#loan_giving").val();
                var total_int = ((total / 100) * interest);
                var total_interest = Math.round(total_int);
                var ceil = Math.ceil(parseInt(total) / parseInt(expiry_date));
                console.log(ceil)
                if (ceil % 1 == 0) {
                    var ceil_i = ceil;
                } else {
                    var ceil_i = Math.round(parseFloat(ceil) + parseFloat(1));
                };
                var total_with_int = Math.round(parseFloat(total) + parseFloat(total_int));
                var interest_ints = total_int / expiry_date;
                if (interest_ints % 1 == 0) {
                    var interest_i = interest_ints;
                } else {
                    var interest_i = Math.round(parseFloat(interest_ints) + parseFloat(1));
                };
                $("#fixedLoanInstallment").val(ceil_i);
                $("#totalInterest").val(total_interest);

                $("#totalWithInterest").val(total_with_int);
                $("#fixedInterestInstallment").val(interest_i);
            }

            // Submit Form
            $('#loans_update').on('submit', function(e) {
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
                                    "{{ Route('accounts', ['name' => request()->name, 'id' => $activeLoans->client_id]) }}"
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
            $('.guarantor_update').on('submit', function(e) {
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
                                    "{{ Route('accounts', ['name' => request()->name, 'id' => $activeLoans->client_id]) }}"
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
