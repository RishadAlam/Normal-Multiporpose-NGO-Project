@extends('layouts.main')

@push('title')
    {{ __('Center') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Center') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        @if (auth()->user()->can('Center Create'))
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#create-Center"
                class="btn btn-primary me-1 mb-2">Create Center <span><i data-feather="plus"></i></span></a>
        @endif
        <div class="card rounded-3 border-0 card-body-dark" style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Center List</b>
            </div>
            <div class="card-body p-0">
                <div class="intro-y overflow-x-auto">
                    <table class="table table-hover table-striped table-report">
                        <thead class="bg-theme-1 text-white border-b-0">
                            <tr>
                                <th style="width: 2%;" class="border-bottom-0 text-nowrap">#</th>
                                <th style="width: 18%;" class="border-bottom-0 text-nowrap">Center Name</th>
                                <th style="width: 18%;" class="border-bottom-0 text-nowrap">Volume Name</th>
                                <th style="width: 40%;" class="border-bottom-0 text-nowrap">Description</th>
                                <th style="width: 8%;"class="border-bottom-0 text-nowrap">Status</th>
                                @if (auth()->user()->can('Center Edit'))
                                    <th style="width: 7%;"class="border-bottom-0 text-nowrap">Edit</th>
                                @endif
                                @if (auth()->user()->can('Center Status Edit'))
                                    <th style="width: 7%;"class="border-bottom-0 text-nowrap">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($centers as $key => $center)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $center->name }}</td>
                                    <td>{{ $center->volume->name }}</td>
                                    <td>{!! $center->description !!}</td>
                                    <td>
                                        @if ($center->status)
                                            <span class="badge rounded-3 bg-success p-3">ACTIVE</span>
                                        @else
                                            <span class="badge rounded-3 bg-danger p-3">DACTIVE</span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->can('Center Edit'))
                                        <td data-bs-toggle="modal" data-bs-target="#update-center">
                                            <span class="cursor-pointer center-edit" data-id="{{ $center->id }}"><i
                                                    data-feather="edit"></i></span>
                                        </td>
                                    @endif
                                    @if (auth()->user()->can('Center Status Edit'))
                                        <td>
                                            <div class="form-check form-switch">
                                                <input id="status-switch"
                                                    class="status-trigger form-check-input cursor-pointer" type="checkbox"
                                                    {{ $center->status == true ? 'checked' : '' }}>

                                                <form action="{{ Route('center.status.switch', $center->id) }}"
                                                    method="get" class="d-none">
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if (auth()->user()->can('Center Create'))
            <!-- Modal -->
            <!-- BEGIN: Create Center -->
            <div id="create-Center" class="modal fade" tabindex="-1" aria-hidden="true"
                style="z-index: 99999999 !important">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title">Create Center</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="create_center">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="name" class="form-label">Center Name
                                                <span class="text-danger">*</span></label>
                                            <input id="name" type="Text" name="name" class="form-control"
                                                placeholder="Center Name" required>

                                            <span id="center_name" class="invalid-feedback" role="alert">
                                                <strong>The Center Name field is required.</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="vol_id" class="form-label">Volume <span
                                                    class="text-danger">*</span></label>
                                            <select id="vol_id" name="vol_id"
                                                data-placeholder="Select your favorite actors"
                                                class="tom-select w-full @error('vol_id') is-invalid @enderror" required>
                                                <option disabled selected>Choose Volume...</option>
                                                @forelse ($vols as $vol)
                                                    <option value="{{ $vol->id }}">{{ $vol->name }}</option>
                                                @empty
                                                    <option disabled selected>No Volume Found!</option>
                                                @endforelse
                                            </select>

                                            <span id="vol_id_error" class="invalid-feedback" role="alert">
                                                <strong>The Volume Name field is required.</strong>
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
                                <button type="button" id="create_center_close" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="create_center_submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Create Center -->
        @endif
        @if (auth()->user()->can('Center Edit'))
            <!-- BEGIN: Update Center -->
            <div id="update-center" class="modal fade" tabindex="-1" aria-hidden="true"
                style="z-index: 99999999 !important">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title">Update Center</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="update_center">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="up_name" class="form-label">Center Name
                                                <span class="text-danger">*</span></label>
                                            <input id="up_id" type="hidden" name="up_id" required>
                                            <input id="up_name" type="Text" name="up_name" class="form-control"
                                                placeholder="Center Name" required>

                                            <span id="up_center_name" class="invalid-feedback" role="alert">
                                                <strong>The Center Name field is required.</strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="up_vol_id" class="form-label">Volume <span
                                                    class="text-danger">*</span></label>
                                            <select id="up_vol_id" name="up_vol_id" class="tom-select w-full">
                                                <option disabled selected>Choose Volume...</option>
                                                @forelse ($vols as $vol)
                                                    <option value="{{ $vol->id }}">{{ $vol->name }}</option>
                                                @empty
                                                    <option disabled selected>No Volume Found!</option>
                                                @endforelse
                                            </select>

                                            <span id="up_vol_id_error" class="invalid-feedback" role="alert">
                                                <strong>The Volume Name field is required.</strong>
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
                                <button type="button" id="update_center_close" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="update_center_submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Update Center -->
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
            $("#create_center").on("submit", function(e) {
                /**
                 * Form Preven Default
                 * Validation Data
                 * Form Submit By Ajax
                 */
                e.preventDefault();
                let url = "{{ Route('registration.center.create') }}"
                let center_form = $(this)
                let submit_btn = $('#create_center_submit')
                let close_btn = $('#create_center_close')
                let summernote = $('.summernote')

                if ($("#name").val() == '') {
                    $("#name").addClass('is-invalid')
                    $('#center_name').css('display', 'block')
                } else {
                    // Ajax Call
                    $.ajax({
                        url: url,
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: center_form.serialize(),
                        dataType: "JSON",
                        beforeSend: function() {
                            submit_btn.attr('disabled', true)
                        },
                        success: function(data) {
                            submit_btn.attr('disabled', false)
                            close_btn.trigger('click')

                            if (data.success) {
                                // Form Reset & Reaload the page
                                center_form.trigger('reset')
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
                                // console.log(data.message.vol_id[0])
                                let message = ''
                                if (data.message.vol_id) {
                                    message = 'Volume Name is required!'
                                } else if (typeof(data.message.name) != "undefined" && data
                                    .message.name[0] !== null) {
                                    message = 'Center Name is already exists!'
                                }
                                // Error Msg Show
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: message,
                                    showConfirmButton: true,
                                })
                            }
                        },
                        error: function(data) {
                            submit_btn.attr('disabled', false)
                            console.log(data)
                            // error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Center Registration Unsuccessfull!',
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
            $(".center-edit").on('click', function() {
                let id = $(this).data('id')
                let up_id = $("#up_id")
                let up_name = $("#up_name")
                let up_vol_id = $("#up_vol_id")
                let up_description = $("#up_description")
                let url = "{{ Route('center.edit', 'id') }}"
                url = url.replace('id', id)

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        // console.table(data)
                        up_id.val(data.id)
                        $("#up_vol_id option[value='" + data.volume_id + "']").attr('selected',
                            true)
                        up_name.val(data.name)
                        up_description.summernote('code', data.description)
                    }
                })
            })

            /**
             * Update Form Submit
             */
            $("#update_center").on("submit", function(e) {
                /**
                 * Form Preven Default
                 * Validation Data
                 * Form Submit By Ajax
                 */
                e.preventDefault();
                let url = "{{ Route('center.update') }}"
                let center_form = $(this)
                let submit_btn = $('#update_center_submit')
                let close_btn = $('#update_center_close')
                let summernote = $('.summernote')

                if ($("#up_name").val() == '') {
                    $("#up_name").addClass('is-invalid')
                    $('#up_center_name').css('display', 'block')
                } else {
                    // Ajax Call
                    $.ajax({
                        url: url,
                        type: "PUT",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        data: center_form.serialize(),
                        dataType: "JSON",
                        beforeSend: function() {
                            submit_btn.attr('disabled', true)
                        },
                        success: function(data) {
                            submit_btn.attr('disabled', false)
                            close_btn.trigger('click')

                            if (data.success) {
                                // Form Reset & Reaload the page
                                center_form.trigger('reset')

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
                                // console.log(data.message.vol_id[0])
                                let message = ''
                                if (data.message.vol_id) {
                                    message = 'Volume Name is required!'
                                } else if (typeof(data.message.name) != "undefined" && data
                                    .message.name[0] !== null) {
                                    message = 'Center Name is already exists!'
                                }
                                // Error Msg Show
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: message,
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
                                title: 'Center update Unsuccessfull!',
                                showConfirmButton: true,
                            })
                        }
                    })
                }

            })
        })
    </script>
@endsection
