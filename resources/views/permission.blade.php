@extends('layouts.main')

@push('title')
    {{ __('Employee Register') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Registrations') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Employee Register') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        <!-- Modal -->
        <!-- BEGIN: Create Employee -->
        <div class="card rounded rounded-3 mx-auto" style="width: 80%;">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;"></b>
            </div>
            <form method="POST" action="{{ route('registration.create') }}">
                @csrf

                <div class="card-body">
                    <!-- START: Registration Form -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="name" class="form-label">Name
                                    <span class="text-danger">*</span></label>
                                <input id="name" type="Text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="new_group_name" class="form-label">Group name
                                    <span class="text-danger">*</span></label>
                                <input id="new_group_name" type="text" name="new_group_name"
                                    class="form-control @error('new_group_name') is-invalid @enderror"
                                    value="{{ old('new_group_name') }}">

                                @error('new_group_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="group_name" class="form-label">group_name <span
                                        class="text-danger">*</span></label>
                                <select id="group_name" name="group_name"
                                    class="tom-select w-full @error('group_name') is-invalid @enderror">
                                    <option disabled selected>Choose group_name...</option>
                                    @forelse ($permissions as $group_name)
                                        <option value="{{ $group_name }}">{{ $group_name }}</option>
                                    @empty
                                        <option disabled selected>No group_names Found!</option>
                                    @endforelse
                                </select>

                                @error('group_name')
                                    <span class="invalid-feedback" role="alert" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <!-- END: Registration Form -->
                </div>
                <div class="card-footer">
                    <button type="submit" class="form-control btn btn-primary mt-5">{{ __('Register') }}</button>
                </div>
            </form>
        </div>
        <!-- BEGIN: Create Employee -->
    </div>
@endsection

@section('customJS')
    <script>
        @if (session()->has('success'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: true,
            })
        @endif
    </script>
@endsection
