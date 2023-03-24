@extends('layouts.main')

@push('title')
    {{ __('Create Volume') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Registrations') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Create Employee') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        {{-- <h2 class="intro-y fs-lg fw-medium mb-3 dropdown-toggle btn px-2 box text-gray-700 dark-text-gray-300">Create Volume</h2> --}}

        @if (auth()->user()->can('Employee Registration'))
            <a href="{{ Route('registration.employee') }}" class="btn btn-primary me-1 mb-2">Employee Registration <span><i
                        data-feather="plus"></i></span></a>
        @endif

        <div class="card rounded-3 border-0 card-body-dark" style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Employee List</b>
            </div>
            <div class="card-body p-0">
                <div class="intro-y overflow-auto">
                    <table class="table table-hover table-report table-striped">
                        <thead class="bg-theme-1 text-white border-b-0">
                            <tr>
                                <th style="width: 2%;" class="border-bottom-0 text-nowrap">#</th>
                                <th style="width: 10%;" class="border-bottom-0 text-nowrap">Employee Name</th>
                                <th style="width: 15%;" class="border-bottom-0 text-nowrap">Email</th>
                                <th style="width: 10%;" class="border-bottom-0 text-nowrap">Role</th>
                                <th style="width: 10%;" class="border-bottom-0 text-nowrap">Mobile</th>
                                <th style="width: 10%;" class="border-bottom-0 text-nowrap">Photo</th>
                                <th style="width: 25%;" class="border-bottom-0 text-nowrap">Permissions</th>
                                <th style="width: 8%;"class="border-bottom-0 text-nowrap">Status</th>
                                @if (auth()->user()->can('Employee Edit'))
                                    <th style="width: 5%;"class="border-bottom-0 text-nowrap">Edit</th>
                                @endif
                                @if (auth()->user()->can('Employee Status Edit'))
                                    <th style="width: 5%;"class="border-bottom-0 text-nowrap">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles[0]->name }}</td>
                                    <td>{{ $user->mobile }}</td>
                                    <td>{{ $user->image }}</td>
                                    <td>
                                        @foreach ($user->permissions as $permission)
                                            <span class="badge rounded-pill bg-success">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($user->status == true)
                                            <span class="badge rounded-3 bg-success p-3">ACTIVE</span>
                                        @else
                                            <span class="badge rounded-3 bg-danger p-3">DEACTIVE</span>
                                        @endif
                                    </td>
                                    @if (auth()->user()->can('Employee Edit'))
                                        <td>
                                            <a href="{{ Route('employee.edit', $user->id) }}" class="cursor-pointer"><i
                                                    data-feather="edit"></i></a>
                                        </td>
                                    @endif
                                    @if (auth()->user()->can('Employee Status Edit'))
                                        <td>
                                            <div class="form-check form-switch">
                                                <input id="status-switch"
                                                    class="status-trigger form-check-input cursor-pointer" type="checkbox"
                                                    {{ $user->status == true ? 'checked' : '' }}>
        
                                                <form action="{{ Route('employee.status.switch', $user->id) }}"
                                                    method="get" class="d-none">
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No Records Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script>
        $(document).ready(function() {
            $('.status-trigger').on('click', function() {
                $(this).siblings('form').trigger('submit')
            })

            @if (session()->has('success'))
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: true,
                })
            @endif
        })
    </script>
@endsection
