@extends('layouts.main')

@push('title')
    {{ __('Savings Collection Form') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Registrations') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Savings Collection Form') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        <!-- Modal -->
        <!-- BEGIN: Create Employee -->
        <div class="card rounded rounded-3 mx-auto" style="max-width: 1000px;">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Savings Collection Form</b>
            </div>
            <form id="collection_form" method="POST" action="{{ route('collectionForm.savingsForm.collection.store') }}">
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
                                <label for="savingType" class="form-label">Saving Type <span
                                        class="text-danger">*</span></label>
                                <select id="savingType" name="savingType" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>Choose Saving Type...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger savingType_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="saving_profile_id" class="form-label">Account No.
                                    <span class="text-danger">*</span></label>
                                <select id="saving_profile_id" name="saving_profile_id"
                                    data-placeholder="Select your favorite actors" class="select w-full" required>
                                    <option disabled selected>Choose Account...</option>
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger saving_profile_id_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control" placeholder="Name" readonly
                                    required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger client_id_error"></span>

                                <!-- Hidden Inputs -->
                                <input type="hidden" id="client_id" name="client_id">
                                <input type="hidden" id="acc_no" name="acc_no">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="deposit" class="form-label">Deposit <span class="text-danger">*</span></label>
                                <input id="deposit" type="text" class="form-control" placeholder="xxxx" name="deposit"
                                    required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger deposit_error"></span>
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
            $("#savingType").on('change', function() {
                accountsLoad()
            })

            // Account Load
            function accountsLoad() {
                let vol = $("#volume").val()
                let center = $("#center").val()
                let savingType = $("#savingType").val()
                let accounts = $("#saving_profile_id")
                let url = "{{ Route('collectionForm.savingsForm.accLoad') }}"

                $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    data: {
                        volume: vol,
                        center: center,
                        savingType: savingType
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
            $("#saving_profile_id").on('change', function() {
                let id = $(this).val()
                let name = $('#name')
                let deposit = $('#deposit')
                let client_id = $('#client_id')
                let acc_no = $('#acc_no')
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
                        deposit.val(data.deposit)
                        client_id.val(data.client_id)
                        acc_no.val(data.acc_no)
                    }
                })
            })

            // Submit form
            $('#collection_form').on('submit', function(e) {
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
                                $("#deposit").val('')
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
