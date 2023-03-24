@extends('layouts.main')

@push('title')
    {{ __('Loans Account CLosing Form') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('CLosing Form') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Loans Account CLosing Form') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        <!-- Modal -->
        <!-- BEGIN: Create Employee -->
        <div class="card rounded rounded-3 mx-auto" style="max-width: 1000px;">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Loans Account CLosing Form</b>
            </div>
            <form id="closing_form" method="POST" action="{{ route('closing.Loan.closing') }}">
                @csrf

                <div class="card-body">
                    <!-- START: Registration Form -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="volume" class="form-label">Volume <span class="text-danger">*</span></label>
                                <select id="volume" name="volume" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>Choose Volume...</option>
                                    @foreach ($volumes as $volume)
                                        <option value="{{ $volume->id }}">{{ $volume->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger volume_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="center" class="form-label">Center <span class="text-danger">*</span></label>
                                <select id="center" name="center" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>First Choose volume...</option>
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger center_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="loanType" class="form-label">Loan Type <span
                                        class="text-danger">*</span></label>
                                <select id="loanType" name="loanType" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>Choose Loan Type...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loanType_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="loan_profile_id" class="form-label">Account No.
                                    <span class="text-danger">*</span></label>
                                <select id="loan_profile_id" name="loan_profile_id"
                                    data-placeholder="Select your favorite actors" class="select w-full" required>
                                    <option disabled selected>Choose Account...</option>
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loan_profile_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control" placeholder="Name" readonly
                                    required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger client_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="balance" class="form-label">balance <span class="text-danger">*</span></label>
                                <input id="balance" type="text" class="form-control" placeholder="xxxx" name="balance"
                                    required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger balance_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="installment" class="form-label">Installment Recovered <span
                                        class="text-danger">*</span></label>
                                <input id="installment" type="text" class="form-control" placeholder="xxxx"
                                    name="installment" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger installment_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="loan_given" class="form-label">Total Loan <span
                                        class="text-danger">*</span></label>
                                <input id="loan_given" type="text" class="form-control" placeholder="xxxx"
                                    name="loan_given" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loan_given_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="loan_recovered" class="form-label">Loan Recovered <span
                                        class="text-danger">*</span></label>
                                <input id="loan_recovered" type="text" class="form-control" placeholder="xxxx"
                                    name="loan_recovered" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loan_recovered_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="loan_remaining" class="form-label">Loan Remaining <span
                                        class="text-danger">*</span></label>
                                <input id="loan_remaining" type="text" class="form-control" placeholder="xxxx"
                                    name="loan_remaining" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loan_remaining_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="interest_recovered" class="form-label">Interest Recovered <span
                                        class="text-danger">*</span></label>
                                <input id="interest_recovered" type="text" class="form-control" placeholder="xxxx"
                                    name="interest_recovered" readonly required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger interest_recovered_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="interest_remaining" class="form-label">Interest Remaining <span
                                        class="text-danger">*</span></label>
                                <input id="interest_remaining" type="text" class="form-control" placeholder="xxxx"
                                    name="interest_remaining" readonly required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger interest_remaining_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="input-form">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" class="summernote" rows="3" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- END: Registration Form -->
                </div>
                <div class="card-footer">
                    <button id="form_submit" type="submit"
                        class="form-control btn btn-primary mt-5">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
        <!-- BEGIN: Create Employee -->
    </div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            @if (session()->has('success'))
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: true,
                })
            @endif

            // Get Centers by ajax
            $("#volume").on('change', function() {
                accountsLoad()
                var vol = $(this).val()
                var url = "{{ Route('registration.newCustomer.get.center', 'id') }}"
                url = url.replace('id', vol)

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        if (data != '') {
                            var options = []
                            options[0] = '<option disabled selected>Choose Center...</option>'
                            $.each(data, function(key, value) {
                                options[++key] = '<option value="' + value.id + '">' +
                                    value.name + '</option>'
                            })
                        } else {
                            options = '<option disabled selected>No Records Found!</option>'
                        }

                        $('#center').html('')
                        $('#center').html(options)
                    },
                    error: function(data) {
                        console.table(data)
                    }
                })
            })

            $("#center").on('change', function() {
                accountsLoad()
            })
            $("#loanType").on('change', function() {
                accountsLoad()
            })

            // Account Load
            function accountsLoad() {
                let vol = $("#volume").val()
                let center = $("#center").val()
                let loanType = $("#loanType").val()
                let accounts = $("#loan_profile_id")
                let url = "{{ Route('collectionForm.loansForm.accLoad') }}"

                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    data: {
                        volume: vol,
                        center: center,
                        loanType: loanType
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data != '') {
                            var options = []
                            options[0] = '<option disabled selected>Choose Account...</option>'
                            $.each(data, function(key, value) {
                                options[++key] = '<option value="' + value.id + '">' + value
                                    .acc_no + '</option>'
                            })
                        } else {
                            options = '<option disabled selected>No Records Found!</option>'
                        }

                        accounts.html('')
                        accounts.html(options)
                    }
                })
            }

            // Load Saving Account Info
            $("#loan_profile_id").on('change', function() {
                let id = $(this).val()
                let name = $('#name')
                let balance = $('#balance')
                let installment = $('#installment')
                let loan_given = $('#loan_given')
                let loan_recovered = $('#loan_recovered')
                let loan_remaining = $('#loan_remaining')
                let interest_recovered = $('#interest_recovered')
                let interest_remaining = $('#interest_remaining')
                let url = "{{ Route('collectionForm.loansForm.accInfoLoad') }}"

                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        // Result Print
                        name.val(data.client_register.name)
                        balance.val(data.balance)
                        installment.val(data.installment_recovered)
                        loan_given.val(data.loan_given)
                        loan_recovered.val(data.loan_recovered)
                        loan_remaining.val(data.loan_remaining)
                        interest_recovered.val(data.interest_recovered)
                        interest_remaining.val(data.interest_remaining)
                    }
                })
            })

            // Submit form
            $('#closing_form').on('submit', function(e) {
                e.preventDefault()
                var formData = new FormData(this)
                var btn = $("#form_submit")

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.attr('disabled', true)
                        $("#overlayer").fadeIn();
                        $("#preloader").fadeIn();
                    },
                    success: function(data) {
                        btn.attr('disabled', false)
                        $("#overlayer").fadeOut();
                        $("#preloader").fadeOut();
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
                                accountsLoad()
                                $("#name").val('')
                                $("#client_id").val('')
                                $("#acc_no").val('')
                                $("#hiddenLoan").val('')
                                $("#hiddenInterest").val('')
                                $("#deposit").val('')
                                $("#installment").val('')
                                $("#loan").val('')
                                $("#interest").val('')
                                $("#total").val('')
                                $("#description").summernote('reset')
                            })
                        } else {
                            // Error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Collection not completed!',
                                showConfirmButton: true,
                            })
                        }
                    },
                    error: function(data) {
                        btn.attr('disabled', false)
                        $("#overlayer").fadeOut();
                        $("#preloader").fadeOut();
                        console.log(data)
                        // Error Msg Show
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Collection not completed!',
                            showConfirmButton: true,
                        })
                    }
                })
            })
        })
    </script>
@endsection
