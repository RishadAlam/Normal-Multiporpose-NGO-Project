@extends('layouts.main')

@push('title')
    {{ __('Type') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Type') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        @if (auth()->user()->can('Type Create'))
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#create-type" class="btn btn-primary me-1 mb-2">Create
                Type <span><i data-feather="plus"></i></span></a>
        @endif

        <div class="card rounded-3 border-0 card-body-dark" style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Type List</b>
            </div>
            <div class="card-body p-0">
                <div class="intro-y overflow-x-auto">
                    <table class="table table-hover table-striped table-report">
                        <thead class="bg-theme-1 text-white border-b-0">
                            <tr>
                                <th style="width: 2%;" class="border-bottom-0 text-nowrap">#</th>
                                <th style="width: 18%;" class="border-bottom-0 text-nowrap">Type Name</th>
                                <th style="width: 30%;" class="border-bottom-0 text-nowrap">Description</th>
                                <th style="width: 10%;" class="border-bottom-0 text-nowrap">Time Period</th>
                                <th style="width: 5%;" class="border-bottom-0 text-nowrap">Savings</th>
                                <th style="width: 5%;" class="border-bottom-0 text-nowrap">Loans</th>
                                <th style="width: 10%;"class="border-bottom-0 text-nowrap">Status</th>
                                @if (auth()->user()->can('Type Edit'))
                                    <th style="width: 10%;"class="border-bottom-0 text-nowrap">Edit</th>
                                @endif
                                @if (auth()->user()->can('Type Status Edit'))
                                    <th style="width: 10%;"class="border-bottom-0 text-nowrap">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($types as $key => $type)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>{!! $type->description !!}</td>
                                    <td>{{ $type->time_period }} days</td>
                                    <td>
                                        {!! $type->savings
                                            ? '<span class="text-success" style="font-size: 24px"><i class="bx bx-check-circle"></i></span>'
                                            : '<span class="text-danger" style="font-size: 24px"><i class="bx bx-x-circle"></i></span>' !!}
                                    </td>
                                    <td>
                                        {!! $type->loans
                                            ? '<span class="text-success" style="font-size: 24px"><i class="bx bx-check-circle"></i></span>'
                                            : '<span class="text-danger" style="font-size: 24px"><i class="bx bx-x-circle"></i></span>' !!}
                                    </td>
                                    <td>
                                        @if ($type->status)
                                            <span class="badge rounded-3 bg-success p-3">ACTIVE</span>
                                        @else
                                            <span class="badge rounded-3 bg-danger p-3">DACTIVE</span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->can('Type Edit'))
                                        <td data-bs-toggle="modal" data-bs-target="#update-type">
                                            <span class="cursor-pointer vol-edit" data-id="{{ $type->id }}"><i
                                                    data-feather="edit"></i></span>
                                        </td>
                                    @endif
                                    @if (auth()->user()->can('Type Status Edit'))
                                        <td>
                                            <div class="form-check form-switch">
                                                <input id="status-switch"
                                                    class="status-trigger form-check-input cursor-pointer" type="checkbox"
                                                    {{ $type->status == true ? 'checked' : '' }}>

                                                <form action="{{ Route('type.status.switch', $type->id) }}" method="get"
                                                    class="d-none">
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No records found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if (auth()->user()->can('Type Create'))
            <!-- Modal -->
            <!-- BEGIN: Create Volume -->
            <div id="create-type" class="modal fade" tabindex="-1" aria-hidden="true" style="z-index: 99999999 !important">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title">Create Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="create_types">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="input-form">
                                            <label for="name" class="form-label">Type Name
                                                <span class="text-danger">*</span></label>
                                            <input id="name" type="Text" name="name" class="form-control"
                                                placeholder="Type Name" required>

                                            <span id="type_name" class="invalid-feedback" role="alert">
                                                <strong>The type Name field is required.</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label>Types <span class="text-danger">*</span></label>
                                            <div class="d-flex flex-column flex-sm-row mt-2 border px-3 py-2 rounded-2">
                                                <div class="form-check me-2">
                                                    <input id="saving" name="saving"
                                                        class="form-check-input cursor-pointer" type="checkbox"
                                                        value="1">
                                                    <label class="form-check-label cursor-pointer"
                                                        for="saving">Saving</label>
                                                </div>
                                                <div class="form-check me-2 mt-2 mt-sm-0">
                                                    <input id="loan" name="loan"
                                                        class="form-check-input cursor-pointer" type="checkbox"
                                                        value="1">
                                                    <label class="form-check-label cursor-pointer"
                                                        for="loan">Loan</label>
                                                </div>
                                            </div>
                                            <span id="types_error" class="invalid-feedback" role="alert">
                                                <strong>The types field is required.</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="time" class="form-label">Time Period <span
                                                    class="text-danger">*</span> (1day, 7days, 15days, 30days)
                                            </label>
                                            <input id="time" type="number" name="time" class="form-control"
                                                placeholder="Time Period" required>

                                            <span id="time_error" class="invalid-feedback" role="alert">
                                                <strong>The time period field is required.</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="input-form">
                                            <label for="description" class="form-label">Description
                                                <span class="text-danger">*</span></label>
                                            <textarea class="summernote" rows="3" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="create_type_close" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="create_type_submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Create Type -->
        @endif
        @if (auth()->user()->can('Type Edit'))
            <!-- BEGIN: Update Type -->
            <div id="update-type" class="modal fade" tabindex="-1" aria-hidden="true"
                style="z-index: 99999999 !important">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title">Update Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="update_type">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="input-form">
                                            <label for="up_name" class="form-label">Type Name
                                                <span class="text-danger">*</span></label>
                                            <input id="up_id" type="hidden" name="up_id" required>
                                            <input id="up_name" type="Text" name="up_name" class="form-control"
                                                placeholder="Type Name" required>

                                            <span id="up_vol_name" class="invalid-feedback" role="alert">
                                                <strong>The Type Name field is required.</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label>Types <span class="text-danger">*</span></label>
                                            <div class="d-flex flex-column flex-sm-row mt-2 border px-3 py-2 rounded-2">
                                                <div class="form-check me-2">
                                                    <input id="up_saving" name="up_saving"
                                                        class="form-check-input cursor-pointer" type="checkbox"
                                                        value="1">
                                                    <label class="form-check-label cursor-pointer"
                                                        for="up_saving">Saving</label>
                                                </div>
                                                <div class="form-check me-2 mt-2 mt-sm-0">
                                                    <input id="up_loan" name="up_loan"
                                                        class="form-check-input cursor-pointer" type="checkbox"
                                                        value="1">
                                                    <label class="form-check-label cursor-pointer"
                                                        for="up_loan">Loan</label>
                                                </div>
                                            </div>
                                            <span id="up_types_error" class="invalid-feedback" role="alert">
                                                <strong>The types field is required.</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="up_time" class="form-label">Time Period <span
                                                    class="text-danger">*</span> (1day, 7days, 15days, 30days)
                                            </label>
                                            <input id="up_time" type="number" name="up_time" class="form-control"
                                                placeholder="Time Period" required>

                                            <span id="up_time_error" class="invalid-feedback" role="alert">
                                                <strong>The time period field is required.</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="input-form">
                                            <label for="up_description" class="form-label">Description
                                                <span class="text-danger">*</span></label>
                                            <textarea id="up_description" class="summernote" rows="3" name="up_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="update_type_close" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="update_type_submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Update Volume -->
        @endif
    </div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            /**
             * Status Switch
             */
            $('.status-trigger').on('click', function() {
                $(this).siblings('form').trigger('submit')
            })

            /**
             * Registration Form Submit
             */
            $("#create_types").on("submit", function(e) {
                /**
                 * Form Preven Default
                 * Validation Data
                 * Form Submit By Ajax
                 */
                e.preventDefault();
                let url = "{{ Route('registration.type.create') }}"
                let types_form = $(this)
                let submit_btn = $('#create_type_submit')
                let close_btn = $('#create_type_close')
                let summernote = $('.summernote')

                if ($("#name").val() == '') {
                    $("#name").addClass('is-invalid')
                    $('#type_name').css('display', 'block')
                } else if (!$('#saving').is(":checked") && !$('#loan').is(":checked")) {
                    $("#saving").addClass('is-invalid')
                    $("#loan").addClass('is-invalid')
                    $('#types_error').css('display', 'block')
                } else if ($("#time").val() == '') {
                    $("#time").addClass('is-invalid')
                    $('#time_error').css('display', 'block')
                } else {
                    // Ajax Call
                    $.ajax({
                        url: url,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: types_form.serialize(),
                        dataType: "JSON",
                        beforeSend: function() {
                            submit_btn.attr('disabled', true)
                        },
                        success: function(data) {
                            submit_btn.attr('disabled', false)
                            close_btn.trigger('click')

                            if (data.success) {
                                // Form Reset & Reaload the page
                                types_form.trigger('reset')
                                summernote.summernote('code', '')
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
                                    title: data.message,
                                    showConfirmButton: true,
                                })
                            }
                        },
                        error: function(data) {
                            submit_btn.attr('disabled', false)

                            // error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Volume Registration Unsuccessfull!',
                                showConfirmButton: true,
                            })
                        }
                    })
                }

            })

            /**
             * Volume Edit 
             * Get volume id
             * Fetch volume data by ajax call
             */
            $(".vol-edit").on('click', function() {
                let id = $(this).data('id')
                let up_id = $("#up_id")
                let up_name = $("#up_name")
                let up_saving = $("#up_saving")
                let up_loan = $("#up_loan")
                let up_time = $("#up_time")
                let up_description = $("#up_description")
                let url = "{{ Route('type.edit', 'id') }}"
                url = url.replace('id', id)

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        up_id.val(data.id)
                        up_name.val(data.name)
                        up_time.val(data.time_period)
                        up_description.summernote('code', data.description)
                        if (data.savings) {
                            up_saving.prop('checked', true)
                        } else {
                            up_saving.prop('checked', false)
                        }
                        if (data.loans) {
                            up_loan.prop('checked', true)
                        } else {
                            up_loan.prop('checked', false)
                        }
                    }
                })
            })

            /**
             * Update Form Submit
             */
            $("#update_type").on("submit", function(e) {
                /**
                 * Form Preven Default
                 * Validation Data
                 * Form Submit By Ajax
                 */
                e.preventDefault();
                let url = "{{ Route('type.update') }}"
                let types_form = $(this)
                let submit_btn = $('#update_type_submit')
                let close_btn = $('#update_type_close')
                let summernote = $('.summernote')

                if ($("#up_name").val() == '') {
                    $("#up_name").addClass('is-invalid')
                    $('#up_vol_name').css('display', 'block')
                } else if (!$('#up_saving').is(":checked") && !$('#up_loan').is(":checked")) {
                    $("#up_saving").addClass('is-invalid')
                    $("#up_loan").addClass('is-invalid')
                    $('#up_types_error').css('display', 'block')
                } else if ($("#up_time").val() == '') {
                    $("#up_time").addClass('is-invalid')
                    $('#up_time_error').css('display', 'block')
                } else {
                    // Ajax Call
                    $.ajax({
                        url: url,
                        type: "PUT",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: types_form.serialize(),
                        dataType: "JSON",
                        beforeSend: function() {
                            submit_btn.attr('disabled', true)
                        },
                        success: function(data) {
                            submit_btn.attr('disabled', false)
                            close_btn.trigger('click')

                            if (data.success) {
                                // Form Reset & Reaload the page
                                types_form.trigger('reset')

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
                                    title: data.message,
                                    showConfirmButton: true,
                                })
                            }
                        },
                        error: function(data) {
                            submit_btn.attr('disabled', false)
                            console.log(data);
                            // error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Volume update Unsuccessfull!',
                                showConfirmButton: true,
                            })
                        }
                    })
                }

            })
        })
    </script>
@endsection
