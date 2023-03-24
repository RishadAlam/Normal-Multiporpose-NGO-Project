@extends('layouts.main')

@push('title')
    {{ $type->name }} Collection Report
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Collection Reports') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ Route('collectionsReport.regularCollection') }}">{{ __('Regular Collection Report') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Loans') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ Route('collectionsReport.regularCollection.savings.volumes', request()->type_id) }}">{{ $type->name }}
        Collection Volume
        Report</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ $type->name }} Collection Center Report</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="row justify-items-center">
            <div class="col-md-8">
                <h2 class="fs-lg fw-medium me-auto">{{ $type->name }} Collection Report</h2>
                <p>
                    {{ Carbon\carbon::now()->format('d M, Y') }} &nbsp;
                    <a target="__blank"
                        href="{{ Route('collectionsReport.regularCollection.loans.reports.print', ['type_id' => request()->type_id, 'volume_id' => request()->volume_id, 'officer' => isset(request()->officer) ? request()->officer : '0']) }}"><span
                            class="text-primary"><i data-feather="printer"></i></span></a>
                </p>
            </div>
            <div class="col-md-4">
                @if (auth()->user()->can('Collection Report View as an Admin'))
                    <form
                        action="{{ Route('collectionsReport.regularCollection.loans.reports', ['type_id' => request()->type_id, 'volume_id' => request()->volume_id]) }}"
                        method="get" id="dateRangeForm">

                        <label for="Officers">Officers</label>
                        <select id="Officers" name="officer" data-placeholder="Select your favorite actors"
                            class="select w-full" required>
                            <option selected value="0">All Officer</option>
                            @foreach ($officers as $officer)
                                <option value="{{ $officer->id }}"
                                    @if (isset(request()->officer)) {{ request()->officer == $officer->id ? 'selected' : '' }} @endif>
                                    {{ $officer->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>
        </div>

        <!-- Regular Collection table -->
        {{-- @dd($loanCollections->toArray()) --}}
        @forelse ($loanCollections as $loan)
            <div class="card rounded rounded-3 my-5 pb-5 border-0 card-body-dark"
                style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                <div class="card-header py-5">
                    <b class="text-uppercase" style="font-size: 18px;">{{ $loan->name }}</b>
                </div>
                <div class="card-body p-0">
                    <div class="intro-y overflow-x-auto">
                        <table class="table table-hover table-striped table-report">
                            <thead class="bg-theme-1 text-white border-b-0">
                                <tr>
                                    <th style="width: 2%;" class="border-bottom-0 text-nowrap text-start">#</th>
                                    <th class="border-bottom-0 text-nowrap">Client Name</th>
                                    <th class="border-bottom-0 text-nowrap">Account No</th>
                                    <th class="border-bottom-0 text-nowrap">Description</th>
                                    <th class="border-bottom-0 text-nowrap">Installment</th>
                                    <th class="border-bottom-0 text-nowrap">Deposit</th>
                                    <th class="border-bottom-0 text-nowrap">Loan</th>
                                    <th class="border-bottom-0 text-nowrap">Interest</th>
                                    <th class="border-bottom-0 text-nowrap">Total</th>
                                    <th class="border-bottom-0 text-nowrap">Officer</th>
                                    <th class="border-bottom-0 text-nowrap">Time</th>
                                    @if (auth()->user()->can('Collection Edit'))
                                        <th class="border-bottom-0 text-nowrap">Edit</th>
                                    @endif
                                    @if (auth()->user()->can('Collection Delete'))
                                        <th class="border-bottom-0 text-nowrap">Delete</th>
                                    @endif
                                    @if (auth()->user()->can('Collection Approval'))
                                        <th style="width: 140px;" class="border-bottom-0 text-nowrap">
                                            Action
                                            <div class="form-check form-switch float-end">
                                                <input id="{{ $loan->id }}_aprroval_switch"
                                                    class="all_aprroval_switch form-check-input cursor-pointer"
                                                    type="checkbox" data-center="{{ $loan->id }}">
                                            </div>
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $deposit = 0;
                                    $loanss = 0;
                                    $interest = 0;
                                    $total = 0;
                                @endphp
                                @forelse ($loan->LoanProfile as $key => $LoanProfile)
                                    @forelse ($LoanProfile->LoanCollection as $LoanCollection)
                                        @php
                                            $deposit_installment = $LoanCollection->installment * $LoanProfile->deposit;
                                            $loan_installment = $LoanCollection->installment * $LoanProfile->loan_installment;
                                            $interest_installment = $LoanCollection->installment * $LoanProfile->interest_installment;
                                            $total_intallment = $deposit_installment + $loan_installment + $interest_installment;
                                        @endphp
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $LoanProfile->ClientRegister->name }}</td>
                                            <td>{{ $LoanProfile->acc_no }}</td>
                                            <td class="text-justify">{!! $LoanCollection->expression !!}</td>
                                            <td>{{ $LoanCollection->installment }}</td>
                                            <td
                                                class="@if ($deposit_installment > $LoanCollection->deposit) {{ 'bg-danger text-white' }} 
                                                @elseif ($deposit_installment < $LoanCollection->deposit) {{ 'bg-success text-white' }} @endif">
                                                ৳{{ $LoanCollection->deposit }}/-
                                            </td>
                                            <td
                                                class="@if ($loan_installment > $LoanCollection->loan) {{ 'bg-danger text-white' }} 
                                                @elseif ($loan_installment < $LoanCollection->loan) {{ 'bg-success text-white' }} @endif">
                                                ৳{{ $LoanCollection->loan }}/-
                                            </td>
                                            <td
                                                class="@if ($interest_installment > $LoanCollection->interest) {{ 'bg-danger text-white' }} 
                                                @elseif ($interest_installment < $LoanCollection->interest) {{ 'bg-success text-white' }} @endif">
                                                ৳{{ $LoanCollection->interest }}/-
                                            </td>
                                            <td
                                                class="@if ($total_intallment > $LoanCollection->total) {{ 'bg-danger text-white' }} 
                                                @elseif ($total_intallment < $LoanCollection->total) {{ 'bg-success text-white' }} @endif">
                                                ৳{{ $LoanCollection->total }}/-
                                            </td>
                                            <td>{{ $LoanCollection->user->name }}</td>
                                            <td>
                                                {{ date('h:i A', strtotime($LoanCollection->time)) }}
                                            </td>
                                            @if (auth()->user()->can('Collection Edit'))
                                                <td class="text-primary text-info cursor-pointer" data-bs-toggle="modal"
                                                    data-bs-target="#update-collection">
                                                    <span class="cursor-pointer collection-edit"
                                                        data-id="{{ $LoanCollection->id }}"><i
                                                            data-feather="edit"></i></span>
                                                </td>
                                            @endif
                                            @if (auth()->user()->can('Collection Delete'))
                                                <td class="text-primary text-info cursor-pointer">
                                                    <span class="cursor-pointer collection-delete"
                                                        data-id="{{ $LoanCollection->id }}"><i
                                                            data-feather="trash"></i></span>
                                                </td>
                                            @endif
                                            @if (auth()->user()->can('Collection Approval'))
                                                <td class="text-primary text-info cursor-pointer text-end">
                                                    <div class="form-check form-switch float-end">
                                                        <input id="aprroval-switch" name="{{ $loan->id }}_Savings_id[]"
                                                            class="aprroval_trigger form-check-input cursor-pointer"
                                                            type="checkbox" value="{{ $LoanCollection->id }}"
                                                            data-center="{{ $loan->id }}">
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                        @php
                                            $deposit += $LoanCollection->deposit;
                                            $loanss += $LoanCollection->loan;
                                            $interest += $LoanCollection->interest;
                                            $total += $LoanCollection->total;
                                        @endphp
                                    @empty
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $LoanProfile->ClientRegister->name }}</td>
                                            <td>{{ $LoanProfile->acc_no }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            @if (auth()->user()->can('Collection Edit'))
                                                <td></td>
                                            @endif
                                            @if (auth()->user()->can('Collection Delete'))
                                                <td></td>
                                            @endif
                                            @if (auth()->user()->can('Collection Approval'))
                                                <td></td>
                                            @endif
                                        </tr>
                                    @endforelse
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No records found!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="bg-theme-20 text-white text-end"><b>Total</b></td>
                                    <td class="bg-theme-20 text-white"><b>৳{{ $deposit }}/-</b></td>
                                    <td class="bg-theme-20 text-white"><b>৳{{ $loanss }}/-</b></td>
                                    <td class="bg-theme-20 text-white"><b>৳{{ $interest }}/-</b></td>
                                    <td colspan="3" class="bg-theme-20 text-white"><b>৳{{ $total }}/-</b></td>
                                    @if (auth()->user()->can('Collection Edit'))
                                        <td class="bg-theme-20"></td>
                                    @endif
                                    @if (auth()->user()->can('Collection Delete'))
                                        <td class="bg-theme-20"></td>
                                    @endif
                                    @if (auth()->user()->can('Collection Approval'))
                                        <td class="bg-theme-20 text-white text-end">
                                            <button id="{{ $loan->id }}_aprroval_submit" type="button"
                                                class="aprroval_submit btn btn-sm btn-primary d-none"
                                                data-center="{{ $loan->id }}">Save</button>
                                        </td>
                                    @endif
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
        <!-- Regular Collection table -->


        @if (auth()->user()->can('Collection Edit'))
            <!-- BEGIN: Edit Model -->
            <div id="update-collection" class="modal fade" tabindex="-1" aria-hidden="true"
                style="z-index: 99999999 !important">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title">Collection Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="update_collection"
                            action="{{ Route('collectionsReport.pendingCollection.loans.reports.update') }}"
                            method="POST">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="volume" class="form-label">Volume <span
                                                    class="text-danger">*</span></label>
                                            <input id="volume" name="volume" type="text" class="form-control"
                                                readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger volume_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="center" class="form-label">Center <span
                                                    class="text-danger">*</span></label>
                                            <input id="center" name="center" type="text" class="form-control"
                                                readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger center_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="loanType" class="form-label">Saving Type <span
                                                    class="text-danger">*</span></label>
                                            <input id="loanType" name="loanType" type="text" class="form-control"
                                                readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loanType_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="acc_no" class="form-label">Account No.
                                                <span class="text-danger">*</span></label>
                                            <input id="acc_no" name="acc_no" type="text" class="form-control"
                                                readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger acc_no_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="name" class="form-label">Name <span
                                                    class="text-danger">*</span></label>
                                            <input id="name" type="text" name="name" class="form-control"
                                                placeholder="Name" readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger name_error"></span>

                                            <!-- Hidden Inputs -->
                                            <input type="hidden" id="client_id" name="client_id">
                                            <input type="hidden" id="collection_id" name="collection_id">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="deposit" class="form-label">Deposit <span
                                                    class="text-danger">*</span></label>
                                            <input id="deposit" type="text" class="form-control" placeholder="xxxx"
                                                name="deposit" required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger deposit_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="installment" class="form-label">Installment <span
                                                    class="text-danger">*</span></label>
                                            <input id="installment" type="text" class="form-control"
                                                placeholder="xxxx" name="installment" required>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger installment_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="loan" class="form-label">Loan <span
                                                    class="text-danger">*</span></label>
                                            <input id="loan" type="text" class="form-control" placeholder="xxxx"
                                                name="loan" required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loan_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="interest" class="form-label">Interest <span
                                                    class="text-danger">*</span></label>
                                            <input id="interest" type="text" class="form-control" placeholder="xxxx"
                                                name="interest" readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger interest_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="total" class="form-label">Total (Deposit + Loan + Interest)
                                                <span class="text-danger">*</span></label>
                                            <input id="total" type="text" class="form-control" placeholder="xxxx"
                                                name="total" readonly required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger total_error"></span>
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

            $("#Officers").on("change", function() {
                dateRangeFormSubmit()
            })

            // Daterange Form Submit
            function dateRangeFormSubmit() {
                $("#dateRangeForm").trigger('submit')
            }

            // Collection Delete
            $(".collection-delete").on('click', function() {
                let id = $(this).data('id')

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
                            url: "{{ Route('collectionsReport.pendingCollection.loans.reports.delete') }}",
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                id: id
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
                                        text: 'Collection has been deleted.',
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
            $(".collection-edit").on('click', function() {
                let id = $(this).data('id')

                $.ajax({
                    url: "{{ Route('collectionsReport.pendingCollection.loans.reports.edit') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $("#volume").val(data.volume.name)
                        $("#center").val(data.center.name)
                        $("#loanType").val(data.type.name)
                        $("#collection_id").val(data.id)
                        $("#name").val(data.client_register.name)
                        $("#client_id").val(data.client_id)
                        $("#acc_no").val(data.acc_no)
                        $("#deposit").val(data.deposit)
                        $("#installment").val(data.installment)
                        $("#loan").val(data.loan)
                        $("#interest").val(data.interest)
                        $("#total").val(data.total)
                        $("#description").summernote('code', data.expression)
                    },
                    error: function(data) {
                        console.table(data)
                    }
                })
            })

            $('#deposit').on('keyup', function() {
                total_loan()
            })
            $('#loan').on('keyup', function() {
                total_loan()
            })
            $('#interest').on('keyup', function() {
                total_loan()
            })

            // Total Loan
            function total_loan() {
                let deposit = $('#deposit').val()
                let loan = $('#loan').val()
                let interest = $('#interest').val()
                let total = $('#total')

                total.val(parseInt(deposit) + parseInt(loan) + parseInt(interest))
            }

            /**
             * Update Form Submit
             */
            $("#update_collection").on("submit", function(e) {
                /**
                 * Form Preven Default
                 * Form Submit By Ajax
                 */
                e.preventDefault();
                let submit_btn = $('#update_btn_submit')
                let close_btn = $('#update_btn_close')
                let formData = $("#update_collection").serialize()

                // Ajax Call
                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
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
                                title: 'Collection Update Successfully',
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
                let center = $(this).data('center')
                checked(center)
            })

            /**
             * ALL Approval Check
             */
            $(".all_aprroval_switch").on("change", function() {
                let center = $(this).data('center')

                if ($(this).is(':checked')) {
                    $('input[name="' + center + '_Savings_id[]"]').prop('checked', true);
                } else {
                    $('input[name="' + center + '_Savings_id[]"]:checked').prop('checked', false);
                }

                checked(center)
            })

            /**
             * Approval Check function
             */
            function checked(center) {
                totalCheck = $('input[name="' + center + '_Savings_id[]"]').length;
                totalChecked = $('input[name="' + center + '_Savings_id[]"]:checked').length;
                if (totalCheck == totalChecked) {
                    $('#' + center + '_aprroval_switch').prop('checked', true);
                } else {
                    $('#' + center + '_aprroval_switch').prop('checked', false);
                }

                if (totalChecked > 0) {
                    $('#' + center + '_aprroval_submit').removeClass("d-none");
                } else {
                    $('#' + center + '_aprroval_submit').addClass("d-none");
                }
            }

            /**
             * Approval Check IDs Submit
             */
            $(".aprroval_submit").on('click', function(e) {
                e.preventDefault();
                /**
                 * Get Approval Center ID
                 * Get Approval Check IDs
                 */
                let center = $(this).data('center')
                let submit = $(this)
                let preloader = $("#preloader")
                let overlayer = $("#overlayer")
                let url = "{{ Route('collectionsReport.regularCollection.loans.reports.approve') }}"
                var id = [];
                $('input[name="' + center + '_Savings_id[]"]:checked').each(function() {
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
                                title: 'Collection Approved Successfully',
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
