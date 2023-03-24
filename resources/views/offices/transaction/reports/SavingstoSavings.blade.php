@extends('layouts.main')

@push('title')
    Savings To Savings Transaction Report
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Transaction Report') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> Savings To Savings Transaction Report</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="row justify-items-center">
            <div class="col-md-6">
                <h2 class="fs-lg fw-medium me-auto">Pending Transaction</h2>
            </div>
            <div class="col-md-6 justify-content-md-between align-items-md-center d-md-flex">
                <form action="{{ Route('transactionReports.SavingstoSavings') }}" method="get" id="dateRangeForm">
                    @csrf

                    <input type="text" name="startDate" id="startDate" class="d-none" value="{{ request()->startDate }}">
                    <input type="text" name="endDate" id="endDate" class="d-none" value="{{ request()->endDate }}">
                    @if (auth()->user()->can('Transaction Report View as an Admin'))
                        <label for="Officers">Officers</label>
                        <select id="Officers" name="officer" data-placeholder="Select your favorite actors"
                            class="select w-full" required>
                            <option disabled selected>All Officer</option>
                            @foreach ($officers as $officer)
                                <option value="{{ $officer->id }}"
                                    @if (isset(request()->officer)) {{ request()->officer == $officer->id ? 'selected' : '' }} @endif>
                                    {{ $officer->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </form>
                <div id="daterange" class="d-inline-block box mt-3"
                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                    <i data-feather="calendar"></i>&nbsp;
                    <span id="dateRangeval"></span> <i class='bx bx-caret-down'></i></i>
                </div>
            </div>
        </div>

        <!-- Pending Collection table -->
        <div class="card rounded rounded-3 my-5 pb-5 border-0 card-body-dark"
            style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
            <div class="card-header py-5">
                <b class="text-uppercase" style="font-size: 18px;">Savings To Savings Transaction Report</b>
            </div>
            <div class="card-body p-0">
                <div class="intro-y overflow-x-auto">
                    <table class="table table-hover table-striped table-report">
                        <thead class="bg-theme-1 text-white border-b-0">
                            <tr>
                                <th colspan="4" class="bg-theme-20 text-center">TRANSACTION FROM ACCOUNT</th>
                                <th class="bg-theme-14"></th>
                                <th colspan="3" class="bg-theme-11 text-center">TRANSACTION TO ACCOUNT</th>
                                <th class="bg-theme-14"></th>
                                <th colspan="7" class="bg-theme-9 text-center">TRANSATION DETAILS</th>
                            </tr>
                            <tr>
                                <th style="width: 1%;" class="border-bottom-0 text-nowrap text-start">#</th>
                                <th class="border-bottom-0 text-nowrap">Client Name</th>
                                <th class="border-bottom-0 text-nowrap">Account No</th>
                                <th class="border-bottom-0 text-nowrap">Type</th>
                                <th class="border-bottom-0 text-nowrap bg-theme-14 text-dark"></th>
                                <th class="border-bottom-0 text-nowrap">Client Name</th>
                                <th class="border-bottom-0 text-nowrap">Account No</th>
                                <th class="border-bottom-0 text-nowrap">Type</th>
                                <th class="border-bottom-0 text-nowrap bg-theme-14 text-dark"></th>
                                <th class="border-bottom-0 text-nowrap">Description</th>
                                <th class="border-bottom-0 text-nowrap">Officer</th>
                                <th class="border-bottom-0 text-nowrap">Amount</th>
                                <th class="border-bottom-0 text-nowrap">Date</th>
                                @if (auth()->user()->can('Transaction Edit'))
                                    <th class="border-bottom-0 text-nowrap">Edit</th>
                                @endif
                                @if (auth()->user()->can('Transaction Delete'))
                                    <th class="border-bottom-0 text-nowrap">Delete</th>
                                @endif
                                @if (auth()->user()->can('Transaction Approval'))
                                    <th style="width: 140px;" class="border-bottom-0 text-nowrap">
                                        Action
                                        <div class="form-check form-switch">
                                            <input id="aprroval_switch"
                                                class="all_aprroval_switch form-check-input cursor-pointer" type="checkbox">
                                        </div>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total = 0;
                            @endphp
                            @forelse ($transactions as $key => $transaction)
                                <tr>
                                    <td class="border-bottom-0 text-nowrap">{{ ++$key }}</td>
                                    <td class="border-bottom-0 text-nowrap">
                                        {{ $transaction->from_client_register->name }}
                                    </td>
                                    <td class="border-bottom-0 text-nowrap">{{ $transaction->from_acc_no }}</td>
                                    <td class="border-bottom-0 text-nowrap">{{ $transaction->from_type->name }}</td>
                                    <td class="border-bottom-0 text-nowrap"></td>
                                    <td class="border-bottom-0 text-nowrap">
                                        {{ $transaction->to_client_register->name }}
                                    </td>
                                    <td class="border-bottom-0 text-nowrap">{{ $transaction->to_acc_no }}</td>
                                    <td class="border-bottom-0 text-nowrap">{{ $transaction->to_type->name }}</td>
                                    <td class="border-bottom-0 text-nowrap"></td>
                                    <td class="border-bottom-0 text-nowrap">{!! $transaction->expression !!}</td>
                                    <td class="border-bottom-0 text-nowrap">{{ $transaction->users->name }}</td>
                                    <td class="border-bottom-0 text-nowrap">{{ $transaction->amount }}</td>
                                    <td class="border-bottom-0 text-nowrap">
                                        {{ date('d M, Y (h:i A)', strtotime($transaction->created_at)) }}
                                    </td>
                                    @if (auth()->user()->can('Transaction Edit'))
                                        <td class="text-primary text-info cursor-pointer" data-bs-toggle="modal"
                                            data-bs-target="#update-transaction">
                                            <span class="cursor-pointer transaction-edit"
                                                data-id="{{ $transaction->id }}"><i data-feather="edit"></i></span>
                                        </td>
                                    @endif
                                    @if (auth()->user()->can('Transaction Delete'))
                                        <td class="text-danger cursor-pointer">
                                            <span class="cursor-pointer transaction-delete"
                                                data-id="{{ $transaction->id }}"><i data-feather="trash"></i></span>
                                        </td>
                                    @endif
                                    @if (auth()->user()->can('Transaction Approval'))
                                        <td class="text-primary text-info cursor-pointer text-end">
                                            <div class="form-check form-switch float-end">
                                                <input id="aprroval-switch" name="transactions_id[]"
                                                    class="aprroval_trigger form-check-input cursor-pointer"
                                                    type="checkbox" value="{{ $transaction->id }}">
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @php
                                    $total += $transaction->amount;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="16" class="text-center">No records found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11" class="bg-theme-20 text-white text-end"><b>Total</b></td>
                                <td colspan="2" class="bg-theme-20 text-white"><b>৳{{ $total }}/-</b></td>
                                @if (auth()->user()->can('Transaction Edit'))
                                    <td class="bg-theme-20"></td>
                                @endif
                                @if (auth()->user()->can('Transaction Delete'))
                                    <td class="bg-theme-20"></td>
                                @endif
                                @if (auth()->user()->can('Transaction Approval'))
                                    <td class="bg-theme-20 text-white text-end">
                                        <button id="aprroval_submit" type="button"
                                            class="aprroval_submit btn btn-sm btn-primary d-none">Save</button>
                                    </td>
                                @endif
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Regular Collection table -->


        @if (auth()->user()->can('Transaction Edit'))
            <!-- BEGIN: Edit Model -->
            <div id="update-transaction" class="modal fade" tabindex="-1" aria-hidden="true"
                style="z-index: 99999999 !important">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title">Transaction Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="update_transaction" method="POST">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3 rounded-3 shadow-inner py-3 form-head">
                                        <b class="text-uppercase">Transaction From Account</b>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="formSavingType" class="form-label">Saving Type <span
                                                    class="text-danger">*</span></label>
                                            <input id="formSavingType" name="formSavingType" type="text"
                                                class="form-control" readonly required>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger formSavingType_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="formAcc_no" class="form-label">Account No.
                                                <span class="text-danger">*</span></label>
                                            <input id="formAcc_no" name="formAcc_no" type="text" class="form-control"
                                                readonly required>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger formAcc_no_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="formName" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input id="formName" type="text" name="formName" class="form-control"
                                                placeholder="Name" readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger name_error"></span>

                                            <!-- Hidden Inputs -->
                                            <input type="hidden" id="formClient_id" name="client_id">
                                            <input type="hidden" id="formBalance" name="formBalance">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="transactionformBalance" class="form-label">Balance <span
                                                    class="text-danger">*</span></label>
                                            <input id="transactionformBalance" type="text" class="form-control"
                                                name="transactionformBalance" placeholder="xxxx" readonly required>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger transactionformBalance_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                        <b class="text-uppercase">Transaction To Account</b>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="toSavingType" class="form-label">Saving Type <span
                                                    class="text-danger">*</span></label>
                                            <input id="toSavingType" name="toSavingType" type="text"
                                                class="form-control" readonly required>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger toSavingType_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="toAcc_no" class="form-label">Account No.
                                                <span class="text-danger">*</span></label>
                                            <input id="toAcc_no" name="toAcc_no" type="text" class="form-control"
                                                readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger toAcc_no_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="toName" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input id="toName" type="text" name="toName" class="form-control"
                                                placeholder="Name" readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger toName_error"></span>

                                            <!-- Hidden Inputs -->
                                            <input type="hidden" id="toClient_id" name="toClient_id">
                                            <input type="hidden" id="toBalance" name="toBalance">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="transactiontoBalance" class="form-label">Balance <span
                                                    class="text-danger">*</span></label>
                                            <input id="transactiontoBalance" type="text" class="form-control"
                                                name="transactiontoBalance" placeholder="xxxx" readonly required>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger transactiontoBalance_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                        <b class="text-uppercase">Transation Details</b>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="transactionAmount" class="form-label">Transaction Amount <span
                                                    class="text-danger">*</span></label>
                                            <input id="transactionAmount" type="text" class="form-control"
                                                placeholder="xxxx" name="transactionAmount" required>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger transactionAmount_error"></span>

                                            <!-- Hidden Inputs -->
                                            <input type="hidden" id="transaction_id" name="transaction_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="officers" class="form-label">Transaction Officer <span
                                                    class="text-danger">*</span></label>
                                            <input id="officers" name="officers" type="text" class="form-control"
                                                readonly required>

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
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="update_btn_close" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="update_btn_submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- END: Edit Model -->
        @endif
    </div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            function cb() {
                $(".daterangepicker .ranges ul").addClass('box')
                $(".drp-buttons").addClass('box')
                $(".cancelBtn").addClass('btn-danger')
                $(".drp-calendar .calendar-table").addClass('box')

                @if (isset(request()->startDate) && isset(request()->endDate))
                    $("#daterange span").html(
                        "{{ request()->startDate }} -> {{ request()->endDate }}")
                @endif
            }
            cb()

            let isActive = false
            $("#daterange").on('click', function() {
                isActive = !isActive
                if (isActive) {

                    $('#dateRangeval').on("DOMSubtreeModified", function() {
                        let range = $(this).text()
                        if (range != '') {
                            let dateRange = range.split("->");
                            $("#startDate").val(dateRange[0]);
                            $("#endDate").val(dateRange[1]);
                            dateRangeFormSubmit()
                        }
                    })
                    // Daterange Form Submit
                    function dateRangeFormSubmit() {
                        $("#dateRangeForm").trigger('submit')
                    }
                }
            })

            // Transaction Delete
            $(".transaction-delete").on('click', function() {
                let id = $(this).data('id')
                let url = "{{ Route('transactionReports.SavingstoSavings.destroy', 'id') }}"
                url = url.replace('id', id)

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    customClass: {
                        popup: 'box',
                        title: 'text-color',
                        htmlContainer: 'text-color',
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: url,
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            dataType: "JSON",
                            beforeSend: function() {
                                $("#preloader").css('display', 'block')
                                $("#overlayer").css('display', 'block')
                            },
                            success: function(data) {
                                $("#preloader").css('display', 'none')
                                $("#overlayer").css('display', 'none')

                                if (data.success == true) {
                                    Swal.fire({
                                        title: 'Deleted!',
                                        text: 'Transaction has been deleted.',
                                        icon: 'success',
                                        confirmButtonColor: '#3085d6',
                                        customClass: {
                                            popup: 'box',
                                            title: 'text-color',
                                            htmlContainer: 'text-color',
                                        }
                                    }).then((result) => {
                                        location.reload()
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        confirmButtonColor: '#3085d6',
                                        customClass: {
                                            popup: 'box',
                                            title: 'text-color',
                                            htmlContainer: 'text-color',
                                        }
                                    })
                                }
                            },
                            error: function(data) {
                                $("#preloader").css('display', 'none')
                                $("#overlayer").css('display', 'none')

                                console.table(data)

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!',
                                    confirmButtonColor: '#3085d6',
                                    customClass: {
                                        popup: 'box',
                                        title: 'text-color',
                                        htmlContainer: 'text-color',
                                    }
                                })
                            }
                        })
                    }
                })
            })

            // Collection Edit
            $(".transaction-edit").on('click', function() {
                let id = $(this).data('id')
                let url = "{{ Route('transactionReports.SavingstoSavings.edit', 'id') }}"
                url = url.replace('id', id)

                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: "JSON",
                    success: function(data) {
                        // From
                        $("#formSavingType").val(data.from_type.name)
                        $("#formAcc_no").val(data.from_acc_no)
                        $("#formName").val(data.from_client_register.name)
                        $("#formClient_id").val(data.from_client_id)
                        $("#formBalance").val(data.from_acc_main_balance)
                        $("#transactionformBalance").val(data.from_acc_trans_balance)

                        // To
                        $("#toSavingType").val(data.to_type.name)
                        $("#toAcc_no").val(data.to_acc_no)
                        $("#toName").val(data.to_client_register.name)
                        $("#toClient_id").val(data.to_client_id)
                        $("#toBalance").val(data.to_acc_main_balance)
                        $("#transactiontoBalance").val(data.to_acc_trans_balance)

                        // Transaction
                        $("#transactionAmount").val(data.amount)
                        $("#transaction_id").val(data.id)
                        $("#officers").val(data.users.name)
                        $("#description").summernote('code', data.expression)
                    },
                    error: function(data) {
                        console.table(data)
                    }
                })
            })


            $("#transactionAmount").on('keyup', function() {
                transaction()
            })

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


            /**
             * Update Form Submit
             */
            $("#update_transaction").on("submit", function(e) {
                /**
                 * Form Preven Default
                 * Form Submit By Ajax
                 */
                e.preventDefault();
                let submit_btn = $('#update_btn_submit')
                let close_btn = $('#update_btn_close')
                let formData = $(this).serialize()
                let id = $('#transaction_id').val()
                let url = "{{ Route('transactionReports.SavingstoSavings.update', 'id') }}"
                url = url.replace('id', id)

                // Ajax Call
                $.ajax({
                    url: url,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: formData,
                    dataType: "JSON",
                    beforeSend: function() {
                        submit_btn.attr('disabled', true)
                        $("#preloader").css('display', 'block')
                        $("#overlayer").css('display', 'block')
                    },
                    success: function(data) {
                        $("#preloader").css('display', 'none')
                        $("#overlayer").css('display', 'none')
                        submit_btn.attr('disabled', false)

                        if (data.errors) {
                            // Validation Message
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: '<b>All fields are required!</b>',
                                showConfirmButton: false,
                                timer: 2000,
                                customClass: {
                                    popup: 'box',
                                    title: 'text-danger',
                                    htmlContainer: 'text-color',
                                }
                            })
                            // Validation Message Loop
                            $("span.text-danger").text('')
                            $("input").removeClass('is-invalid')
                            $.each(data.errors, function(key, value) {
                                $("span." + key + "_error").text(value[0])
                                $("input[name=" + key + "]").addClass('is-invalid')
                            })
                        } else if (data.success) {
                            close_btn.trigger('click')
                            // Success Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Transaction Update Successfully',
                                showConfirmButton: true,
                                confirmButtonColor: '#3085d6',
                                customClass: {
                                    popup: 'box',
                                    title: 'text-color',
                                    htmlContainer: 'text-color',
                                }
                            }).then((result) => {
                                location.reload()
                            })
                        } else {
                            close_btn.trigger('click')
                            // Error Msg Show
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                confirmButtonColor: '#3085d6',
                                customClass: {
                                    popup: 'box',
                                    title: 'text-color',
                                    htmlContainer: 'text-color',
                                }
                            })
                        }
                    },
                    error: function(data) {
                        $("#preloader").css('display', 'none')
                        $("#overlayer").css('display', 'none')
                        submit_btn.attr('disabled', false)
                        close_btn.trigger('click')
                        console.table(data);
                        // error Msg Show
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            confirmButtonColor: '#3085d6',
                            customClass: {
                                popup: 'box',
                                title: 'text-color',
                                htmlContainer: 'text-color',
                            }
                        })
                    }
                })
            })

            /**
             * Approval Check
             */
            $('.aprroval_trigger').on('change', function() {
                checked()
            })

            /**
             * ALL Approval Check
             */
            $(".all_aprroval_switch").on("change", function() {

                if ($(this).is(':checked')) {
                    $('input[name="transactions_id[]"]').prop('checked', true);
                } else {
                    $('input[name="transactions_id[]"]:checked').prop('checked', false);
                }

                checked()
            })

            /**
             * Approval Check function
             */
            function checked() {
                totalCheck = $('input[name="transactions_id[]"]').length;
                totalChecked = $('input[name="transactions_id[]"]:checked').length;
                if (totalCheck == totalChecked) {
                    $('#aprroval_switch').prop('checked', true);
                } else {
                    $('#aprroval_switch').prop('checked', false);
                }

                if (totalChecked > 0) {
                    $('#aprroval_submit').removeClass("d-none");
                } else {
                    $('#aprroval_submit').addClass("d-none");
                }
            }

            /**
             * Approval Check IDs Submit
             */
            $(".aprroval_submit").on('click', function(e) {
                e.preventDefault();
                /**
                 * Get Approval Check IDs
                 */
                let submit = $(this)
                let preloader = $("#preloader")
                let overlayer = $("#overlayer")
                let url = "{{ Route('transactionReports.SavingstoSavings.approve') }}"
                var id = [];
                $('input[name="transactions_id[]"]:checked').each(function() {
                    id.push(this.value);
                });

                // Ajax Call
                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        submit.attr('disabled', true)
                        preloader.fadeIn()
                        overlayer.fadeIn()
                    },
                    success: function(data) {
                        submit.attr('disabled', false)
                        preloader.fadeOut()
                        overlayer.fadeOut()

                        if (data.success) {
                            // Success Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Transaction Approved Successfully',
                                showConfirmButton: true,
                                confirmButtonColor: '#3085d6',
                                customClass: {
                                    popup: 'box',
                                    title: 'text-color',
                                    htmlContainer: 'text-color',
                                }
                            }).then((result) => {
                                location.reload()
                            })

                        } else {
                            // Error Msg Show
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                confirmButtonColor: '#3085d6',
                                customClass: {
                                    popup: 'box',
                                    title: 'text-color',
                                    htmlContainer: 'text-color',
                                }
                            })
                        }
                    },
                    error: function(data) {
                        submit.attr('disabled', false)
                        preloader.fadeOut()
                        overlayer.fadeOut()

                        // Error Msg Show
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            confirmButtonColor: '#3085d6',
                            customClass: {
                                popup: 'box',
                                title: 'text-color',
                                htmlContainer: 'text-color',
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection
