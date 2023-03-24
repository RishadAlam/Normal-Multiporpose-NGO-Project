@extends('layouts.main')

@push('title')
    {{ __('Loan Savings To Savings Transaction') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Transaction') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Loan Savings To Savings Transaction') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        <!-- Modal -->
        <!-- BEGIN: Create Employee -->
        <div class="card rounded rounded-3 mx-auto">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Loan Savings To Savings Transaction</b>
            </div>
            <form id="transaction_form" method="POST" action="{{ route('transactionForms.loanSavingstoSavings.store') }}">
                @csrf

                <div class="card-body">
                    <!-- START: Registration Form -->
                    <div class="row">
                        <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                            <b class="text-uppercase">Transaction From Account</b>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="formVolume" class="form-label">Volume <span class="text-danger">*</span></label>
                                <select id="formVolume" name="formVolume" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>Choose Volume...</option>
                                    @foreach ($volumes as $volume)
                                        <option value="{{ $volume->id }}">{{ $volume->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger formVolume_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="formCenter" class="form-label">Center <span class="text-danger">*</span></label>
                                <select id="formCenter" name="formCenter" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>First Choose volume...</option>
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger formCenter_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="formLoanType" class="form-label">Loan Type <span
                                        class="text-danger">*</span></label>
                                <select id="formLoanType" name="formLoanType" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>Choose Loan Type...</option>
                                    @foreach ($loansTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger formLoanType_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="formLoan_profile_id" class="form-label">Account No.
                                    <span class="text-danger">*</span></label>
                                <select id="formLoan_profile_id" name="formLoan_profile_id"
                                    data-placeholder="Select your favorite actors" class="select w-full" required>
                                    <option disabled selected>Choose Account...</option>
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger formLoan_profile_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="formName" class="form-label">Name <span class="text-danger">*</span></label>
                                <input id="formName" type="text" class="form-control" placeholder="Name" readonly
                                    required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger formClient_id_error"></span>

                                <!-- Hidden Inputs -->
                                <input type="hidden" id="formClient_id" name="formClient_id">
                                <input type="hidden" id="formAcc_no" name="formAcc_no">
                                <input type="hidden" id="formBalance" name="formBalance">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="transactionformBalance" class="form-label">Balance <span
                                        class="text-danger">*</span></label>
                                <input id="transactionformBalance" type="number" class="form-control" placeholder="xxxx"
                                    name="transactionformBalance" readonly required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger transactionformBalance_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                            <b class="text-uppercase">Transaction To Account</b>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="toVolume" class="form-label">Volume <span class="text-danger">*</span></label>
                                <select id="toVolume" name="toVolume" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>Choose Volume...</option>
                                    @foreach ($volumes as $volume)
                                        <option value="{{ $volume->id }}">{{ $volume->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger toVolume_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="toCenter" class="form-label">Center <span
                                        class="text-danger">*</span></label>
                                <select id="toCenter" name="toCenter" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>First Choose volume...</option>
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger toCenter_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="toSavingType" class="form-label">Saving Type <span
                                        class="text-danger">*</span></label>
                                <select id="toSavingType" name="toSavingType"
                                    data-placeholder="Select your favorite actors" class="select w-full" required>
                                    <option disabled selected>Choose Saving Type...</option>
                                    @foreach ($savingsTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger toSavingType_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="toSaving_profile_id" class="form-label">Account No.
                                    <span class="text-danger">*</span></label>
                                <select id="toSaving_profile_id" name="toSaving_profile_id"
                                    data-placeholder="Select your favorite actors" class="select w-full" required>
                                    <option disabled selected>Choose Account...</option>
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger toSaving_profile_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="toName" class="form-label">Name <span class="text-danger">*</span></label>
                                <input id="toName" type="text" class="form-control" placeholder="Name" readonly
                                    required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger toClient_id_error"></span>

                                <!-- Hidden Inputs -->
                                <input type="hidden" id="toClient_id" name="toClient_id">
                                <input type="hidden" id="toAcc_no" name="toAcc_no">
                                <input type="hidden" id="toBalance" name="toBalance">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="transactiontoBalance" class="form-label">Balance <span
                                        class="text-danger">*</span></label>
                                <input id="transactiontoBalance" type="number" class="form-control"
                                    name="transactiontoBalance" placeholder="xxxx" readonly required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger transactiontoBalance_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                            <b class="text-uppercase">Transation Details</b>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="transactionAmount" class="form-label">Transaction Amount <span
                                        class="text-danger">*</span></label>
                                <input id="transactionAmount" type="number" class="form-control"
                                    name="transactionAmount" value="0" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger transactionAmount_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="input-form">
                                <label for="officers" class="form-label">Transaction Officer <span
                                        class="text-danger">*</span></label>
                                <select id="officers" name="officers" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    @if (auth()->user()->can('Officer Selection in Transaction Forms'))
                                        <option disabled selected>Choose Officer...</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}
                                        </option>
                                    @endif
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger officers_error"></span>
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

            $("#formVolume").on('change', function() {
                accountsLoad('form', 'loans')
                centerLoad('form')
            })
            $("#toVolume").on('change', function() {
                accountsLoad('to', 'savings')
                centerLoad('to')
            })
            $("#formCenter").on('change', function() {
                accountsLoad('form', 'loans')
            })
            $("#toCenter").on('change', function() {
                accountsLoad('to', 'savings')
            })
            $("#formLoanType").on('change', function() {
                accountsLoad('form', 'loans')
            })
            $("#toSavingType").on('change', function() {
                accountsLoad('to', 'savings')
            })
            $("#formLoan_profile_id").on('change', function() {
                accountInfoLoad('form', 'loans')
            })
            $("#toSaving_profile_id").on('change', function() {
                accountInfoLoad('to', 'savings')
            })
            $("#transactionAmount").on('keyup', function() {
                transaction()
            })

            // Center Load
            function centerLoad(prefix) {
                var vol = $("#" + prefix + "Volume").val()
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

                        $("#" + prefix + "Center").html('')
                        $("#" + prefix + "Center").html(options)
                    },
                    error: function(data) {
                        console.table(data)
                    }
                })
            }

            // Account Load
            function accountsLoad(prefix, type) {
                let vol = $("#" + prefix + "Volume").val()
                let center = $("#" + prefix + "Center").val()
                let accounts = null
                let url = null
                let types = null
                if (type == 'savings') {
                    types = $("#" + prefix + "SavingType").val()
                    url = "{{ Route('collectionForm.savingsForm.accLoad') }}"
                    accounts = $("#" + prefix + "Saving_profile_id")

                    $.ajax({
                        url: url,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: {
                            volume: vol,
                            center: center,
                            savingType: types
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
                } else {
                    types = $("#" + prefix + "LoanType").val()
                    url = "{{ Route('collectionForm.loansForm.accLoad') }}"
                    accounts = $("#" + prefix + "Loan_profile_id")

                    $.ajax({
                        url: url,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: {
                            volume: vol,
                            center: center,
                            loanType: types
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


            }

            // Load Saving Account Info
            function accountInfoLoad(prefix, type) {
                if (type == 'savings') {
                    let id = $("#" + prefix + "Saving_profile_id").val()
                    let name = $("#" + prefix + "Name")
                    let balance = $("#" + prefix + "Balance")
                    let transactionBalance = $("#transaction" + prefix + "Balance")
                    let client_id = $("#" + prefix + "Client_id")
                    let acc_no = $("#" + prefix + "Acc_no")
                    let url = "{{ Route('collectionForm.savingsForm.accInfoLoad') }}"

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
                            transactionBalance.val(data.balance)
                            client_id.val(data.client_id)
                            acc_no.val(data.acc_no)
                            transaction()
                        }
                    })
                } else {
                    let id = $("#" + prefix + "Loan_profile_id").val()
                    let name = $("#" + prefix + "Name")
                    let balance = $("#" + prefix + "Balance")
                    let transactionBalance = $("#transaction" + prefix + "Balance")
                    let client_id = $("#" + prefix + "Client_id")
                    let acc_no = $("#" + prefix + "Acc_no")
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
                            transactionBalance.val(data.balance)
                            client_id.val(data.client_id)
                            acc_no.val(data.acc_no)
                            transaction()
                        }
                    })
                }
            }

            // Transaction Balance Calculation
            function transaction() {
                let transactionAmount = $("#transactionAmount").val()

                let formBalance = $("#formBalance").val()
                let toBalance = $("#toBalance").val()

                let transactionformBalance = $("#transactionformBalance")
                let transactiontoBalance = $("#transactiontoBalance")

                $("#transactionformBalance").val(parseInt(formBalance) - parseInt(transactionAmount))
                $("#transactiontoBalance").val(parseInt(toBalance) + parseInt(transactionAmount))
            }

            // Submit form
            $('#transaction_form').on('submit', function(e) {
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
                            $("input").removeClass('is-invalid')
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
                                location.reload()
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
                        $("#overlayer").fadeOut()
                        $("#preloader").fadeOut()
                        btn.attr('disabled', false)
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
