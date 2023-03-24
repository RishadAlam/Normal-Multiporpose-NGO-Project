@extends('layouts.main')

@push('title')
    {{ __('Edit Employee Information') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Employee') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Edit Employee Information') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        <!-- Modal -->
        <!-- BEGIN: Create Employee -->
        <div class="card rounded rounded-3 mx-auto" style="width: 80%;">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Edit Employee Information</b>
            </div>
            <form method="POST" action="{{ route('employee.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <!-- START: Registration Form -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="name" class="form-label">Employee Name
                                    <span class="text-danger">*</span></label>
                                <input id="name" type="Text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}"
                                    placeholder="Employee Name" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input id="mobile" type="number" name="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror" placeholder="mobile Number"
                                    value="{{ $user->mobile }}" autocomplete="mobile" autofocus maxlength="11"
                                    minlength="11">

                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="Role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select id="Role" name="role" data-placeholder="Select your favorite actors"
                                    class="tom-select w-full @error('Role') is-invalid @enderror">
                                    <option disabled selected>Choose Role...</option>
                                    @forelse ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $role->id == $user->roles[0]->id ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @empty
                                        <option disabled selected>No Roles Found!</option>
                                    @endforelse
                                </select>

                                @error('role')
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
                    <button type="submit" class="form-control btn btn-primary mt-5">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
        <!-- BEGIN: Create Employee -->
    </div>
@endsection
