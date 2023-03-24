@extends('layouts.main')

@push('title')
    {{ __('Employee Permission') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Registrations') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Employee Permission') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="intro-y d-md-flex align-items-md-center mb-3">
            <h2 class="fs-lg fw-medium me-auto">
                {{ __('Employee Permission') }}
            </h2>
            <form action="{{ Route('employee.permissions') }}" method="GET">
                <div class="input-form">
                    <select id="employee" name="employee" data-placeholder="Select your favorite actors"
                        class="tom-select w-full">
                        <option disabled selected>Choose Employee...</option>
                        @forelse ($employees as $employee)
                            <option {{ request()->get('employee') == $employee->id ? 'selected' : '' }} value="{{ $employee->id }}">
                                {{ $employee->name }}</option>
                        @empty
                            <option disabled selected>No Roles Found!</option>
                        @endforelse
                    </select>
                </div>
                <button type="submit" class="form-control btn btn-primary mt-1">{{ __('GET') }}</button>
            </form>
        </div>

        <div class="card rounded-3">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">{{ __('Employee Permissions') }}</b>
            </div>
            <div class="card-body p-0">
                @isset($user_permissions)
                    <form action="{{ Route('employee.permissions.update', $_GET['employee']) }}" method="POST">
                        <div class="row m-0">
                            @csrf
                            @method('PUT')
                            @foreach ($groups as $group)
                                <div class="col-lg-6 border p-0 border-bottom-0">
                                    <div class="card-header">
                                        <b class="d-flex justify-content-between">
                                            <label for="permissions_{{ $group->group_name }}"
                                                style="cursor: pointer;">{{ $group->group_name }}</label>
                                            <input id="permissions_{{ $group->group_name }}" value="{{ $group->group_name }}"
                                                data-groupname="{{ str_replace(' ', '-', $group->group_name) }}"
                                                class="headerCheked" type="checkbox" />
                                        </b>
                                    </div>
                                    <div class="col-md-12 p-3">
                                        @foreach ($permissions as $permission)
                                            @if ($group->group_name == $permission->group_name)
                                                <p class="d-flex justify-content-between">
                                                    <label class="mb-1" for="permissions_{{ $permission->id }}"
                                                        style="cursor: pointer;">{{ $permission->name }} </label>
                                                    <input class="{{ str_replace(' ', '-', $group->group_name) }}"
                                                        id="permissions_{{ $permission->id }}" type="checkbox"
                                                        {{ $user_permissions->search($permission->name) > -1 ? 'checked' : '' }}
                                                        name="permissions[]" value="{{ $permission->id }}" />
                                                </p>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            <div class="card-footer text-muted text-center">
                                <button type="submit" class="form-control btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="col-12 text-center p-5">
                        <h2 style="font-size: 18px">Choose an employee</h2>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            $(".headerCheked").on('click', function() {
                var group = $(this).data('groupname')
                if ($(this).is(':checked')) {
                    $("." + group + "").prop('checked', true)
                } else {
                    $("." + group + "").prop('checked', false)
                }
            })
        })
    </script>
@endsection
