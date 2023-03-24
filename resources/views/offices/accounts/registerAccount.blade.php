@extends('layouts.main')

@push('title')
    {{ $account->name }}Register Profile
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">
        {{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ $account->name }} Register Profile</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="intro-y d-flex align-items-center">
            <h2 class="fs-lg fw-medium me-auto">
                {{ $account->name }}'s Register Profile
            </h2>
        </div>
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="d-flex flex-column flex-lg-row border-bottom border-gray-200 dark-border-dark-5 pb-5 mx-n5">
                <div class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                    <div class="w-20 h-20 w-sm-24 h-sm-24 flex-none w-lg-32 h-lg-32 image-fit position-relative">
                        <img alt="Rubick Bootstrap HTML Admin Template" class="rounded-circle"
                            src="{{ asset('storage/register/' . $account->client_image) }}">
                    </div>
                    <div class="ms-5">
                        <div class="w-24 w-sm-40 truncate white-space-sm-wrap fw-medium fs-lg">{{ $account->name }}</div>
                        <div class="text-gray-600">Account No: {{ $account->acc_no }}</div>
                    </div>
                </div>
                <div
                    class="mt-6 mt-lg-0 flex-1 dark-text-gray-300 px-5 border-start border-end border-gray-200 dark-border-dark-5 border-top border-top-lg-0 pt-5 pt-lg-0">
                    <div class="fw-medium text-center text-lg-start mt-lg-3">Details Summary</div>
                    <div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start mt-4">
                        <div class="truncate white-space-sm-normal d-flex align-items-center">
                            <i data-feather="rss" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Volume:</span>
                            {{ $account->volume->name }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="target" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Center:</span>
                            {{ $account->center->name }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="phone" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Phone:</span>
                            {{ $account->mobile }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="calendar" class="w-4 h-4 me-2"></i><span
                                class="fw-medium me-2">Registration:</span>
                            {{ date('d M, Y', strtotime($account->created_at)) }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="dollar-sign" class="w-4 h-4 me-2"></i><span
                                class="fw-medium me-2">Share:</span>
                            ৳{{ $account->share }}/-
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 mt-lg-0 flex-1 d-flex align-items-center justify-content-center px-5 border-top border-lg-0 border-gray-200 dark-border-dark-5 pt-5 pt-lg-0">
                    <div class="text-center rounded-2 py-3">
                        <div class="fw-medium text-primary fs-xl">{{ $totalActiveSavings }}</div>
                        <div class="text-gray-600">Active Saving Accounts</div>
                    </div>
                    <div class="text-center rounded-2 py-3">
                        <div class="fw-medium text-primary fs-xl">{{ $totalDeactiveSavings }}</div>
                        <div class="text-gray-600">Deactive Saving Accounts</div>
                    </div>
                    <div class="text-center rounded-2 py-3">
                        <div class="fw-medium text-primary fs-xl">{{ $totalActiveLoans }}</div>
                        <div class="text-gray-600">Active Loan Accounts</div>
                    </div>
                    <div class="text-center rounded-2 py-3">
                        <div class="fw-medium text-primary fs-xl">{{ $totalDeactiveLoans }}</div>
                        <div class="text-gray-600">Deactive Loan Accounts</div>
                    </div>
                </div>
            </div>
            <ul class="nav nav-link-tabs flex-column flex-sm-row justify-content-center justify-content-lg-start"
                role="tablist">
                <li id="register-tab" class="nav-item" role="presentation">
                    <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center active"
                        data-bs-toggle="pill" data-bs-target="#register" role="tab" aria-controls="register-tab"
                        aria-selected="true"> <i class="w-4 h-4 me-2" data-feather="user"></i> Register Profile </a>
                </li>
                <li id="active-savings-tab" class="nav-item" role="presentation">
                    <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center" data-bs-toggle="pill"
                        data-bs-target="#active-savings" role="tab" aria-controls="active-savings-tab"
                        aria-selected="false"> <i class="w-4 h-4 me-2" data-feather="user-check"></i> Active Saving Profiles
                    </a>
                </li>
                <li id="deactive-savings-tab" class="nav-item" role="presentation">
                    <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center" data-bs-toggle="pill"
                        data-bs-target="#deactive-savings" role="tab" aria-controls="deactive-savings-tab"
                        aria-selected="false"> <i class="w-4 h-4 me-2" data-feather="user-x"></i> Deactive Saving Profiles
                    </a>
                </li>
                <li id="active-loans-tab" class="nav-item" role="presentation">
                    <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center" data-bs-toggle="pill"
                        data-bs-target="#active-loans" role="tab" aria-controls="active-loans-tab"
                        aria-selected="false"> <i class="w-4 h-4 me-2" data-feather="user-check"></i> Active Loan
                        Profiles
                    </a>
                </li>
                <li id="deactive-loans-tab" class="nav-item" role="presentation">
                    <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center" data-bs-toggle="pill"
                        data-bs-target="#deactive-loans" role="tab" aria-controls="deactive-loans-tab"
                        aria-selected="false"> <i class="w-4 h-4 me-2" data-feather="user-x"></i> Dective Loan Profiles
                    </a>
                </li>
            </ul>
        </div>
        <!-- END: Profile Info -->
        <!-- START: Profile Details -->
        <div class="intro-y tab-content mt-5">
            <div class="tab-pane fade show active" id="register" role="tabpanel" aria-labelledby="register-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Client Register -->
                    <div class="intro-y box g-col-12">
                        <div class="d-flex align-items-center px-5 py-3 border-bottom border-gray-200 dark-border-dark-5">
                            <h2 class="fw-medium fs-base me-auto">
                                {{ $account->name }}'s Register Profile
                            </h2>
                        </div>
                        <div id="new-products" class="py-5">
                            <div class="px-5">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="truncate white-space-sm-normal mb-3">Name:
                                            <span class="float-end fw-medium">{{ $account->name }}</span>
                                        </p>
                                        <p class="truncate white-space-sm-normal mb-3">Father/Husband name:
                                            <span
                                                class="float-end fw-medium">{{ $account->husband_or_father_name }}</span>
                                        </p>
                                        <p class="truncate white-space-sm-normal mb-3">Mother name:
                                            <span class="float-end fw-medium">{{ $account->mother_name }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                        <p class="truncate white-space-sm-normal mb-3">NID:
                                            <span class="float-end fw-medium">{{ $account->nid }}</span>
                                        </p>
                                        <p class="truncate white-space-sm-normal mb-3">Dath of Birth:
                                            <span class="float-end fw-medium">{{ $account->dob }}</span>
                                        </p>
                                        <p class="truncate white-space-sm-normal mb-3">Gender:
                                            <span class="float-end fw-medium">{{ $account->gender }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="truncate white-space-sm-normal mb-3">Religion:
                                            <span class="float-end fw-medium">{{ $account->religion }}</span>
                                        </p>
                                        <p class="truncate white-space-sm-normal mb-3">Occapation:
                                            <span class="float-end fw-medium">{{ $account->occupation }}</span>
                                        </p>
                                        <p class="truncate white-space-sm-normal mb-3">Academic Qualification:
                                            <span
                                                class="float-end fw-medium">{{ $account->academic_qualification }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-12 mt-3 border-top border-gray-200 dark-border-dark-5">
                                        <p class="truncate white-space-sm-normal my-3">Present Address:
                                            <span class="float-end fw-medium">{!! $account->Present_address !!}</span>
                                        </p>
                                        <p class="truncate white-space-sm-normal">Permanent Address:
                                            <span class="float-end fw-medium">{!! $account->permanent_address !!}</span>
                                        </p>
                                        @if (auth()->user()->can('Client Register Edit'))
                                            <a href="{{ Route('accounts.register.edit', ['name' => $account->name, 'id' => $account->id]) }}"
                                                id="register-edit" type="submit"
                                                class="btn btn-warning text-light mt-5 w-full">Edit</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Client Register -->
                </div>
            </div>
            <div class="tab-pane fade" id="active-savings" role="tabpanel" aria-labelledby="active-savings-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Savings Account -->
                    <div class="intro-y box g-col-12">
                        <div class="px-5">
                            <ul class="nav nav-link-tabs flex-column flex-sm-row justify-content-center justify-content-lg-start"
                                role="tablist">
                                @forelse ($allActiveSavings as $keys => $activeSavings)
                                    <li id="activeSavings{{ $activeSavings->id }}-tab" class="nav-item"
                                        role="presentation">
                                        <a href="javascript:;"
                                            class="nav-link px-0 me-sm-8 d-flex align-items-center {{ $keys === 0 ? 'active' : '' }}"
                                            data-bs-toggle="pill" data-bs-target="#activeSavings{{ $activeSavings->id }}"
                                            role="tab" aria-controls="activeSavings{{ $activeSavings->id }}-tab"
                                            aria-selected="false">
                                            <i class="w-4 h-4 me-2" data-feather="command"></i>
                                            {{ $activeSavings->type->name }}
                                        </a>
                                    </li>
                                @empty
                                    <div class="d-flex justify-content-center align-items-center w-100"
                                        style="height: 200px;">
                                        <p class="text-center">No Records Found!</p>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="intro-y box g-col-12">
                        @foreach ($allActiveSavings as $key => $activeSavings)
                            <div class="tab-pane fade {{ $key === 0 ? 'show active' : '' }}"
                                id="activeSavings{{ $activeSavings->id }}" role="tabpanel"
                                aria-labelledby="activeSavings{{ $activeSavings->id }}-tab">
                                <div class="grid columns-12 gap-6">
                                    <div class="intro-y box g-col-12">
                                        <div
                                            class="d-flex align-items-center px-5 py-3 border-bottom border-gray-200 dark-border-dark-5">
                                            <h2 class="fw-medium fs-base me-auto">
                                                {{ $activeSavings->type->name }}
                                            </h2>
                                        </div>
                                        <div id="new-products" class="py-5">
                                            <div class="px-5">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p class="truncate white-space-sm-normal mb-3">Status:
                                                            <span class="float-end fw-medium">
                                                                @if ($activeSavings->status)
                                                                    <span
                                                                        class="badge rounded-3 bg-success p-2">ACTIVE</span>
                                                                @else
                                                                    <span
                                                                        class="badge rounded-3 bg-danger p-2">DACTIVE</span>
                                                                @endif
                                                            </span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">View:
                                                            <a href="{{ Route('accounts.savingProfile', ['name' => request()->name, 'id' => $activeSavings->id]) }}"
                                                                class="text-info float-end fw-medium">
                                                                <i data-feather="folder"></i>
                                                            </a>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Balance:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeSavings->balance }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Registration
                                                            Officer:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeSavings->User->name }}</span>
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                                        <p class="truncate white-space-sm-normal mb-3">deposit:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeSavings->deposit }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeSavings->interest }}%</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total Deposit
                                                            (Except
                                                            Interest)
                                                            :
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeSavings->total_except_interest }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total
                                                            Deposit (Included
                                                            Interest):
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeSavings->total_include_interest }}/-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="truncate white-space-sm-normal mb-3">Started at:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeSavings->start_date }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Duration:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeSavings->duration_date }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <div class="row">
                                                            @foreach ($activeSavings->SavingNominee as $index => $nominee)
                                                                <div
                                                                    class="d-flex align-items-center py-3 my-3 border-top border-bottom border-gray-200 dark-border-dark-5">
                                                                    <h2 class="fw-medium fs-base me-auto">
                                                                        Nominee-{{ ++$index }}
                                                                    </h2>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <p class="truncate white-space-sm-normal mb-3">Name:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $nominee->name }}</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">Date of
                                                                        Birth:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $nominee->dob }}</span>
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                                                    <p class="truncate white-space-sm-normal mb-3">Segment:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $nominee->segment }}%</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">
                                                                        Relation:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $nominee->relation }}</span>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="w-52">
                                                                        <div
                                                                            class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                                            <div
                                                                                class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                                                <img class="rounded-2"
                                                                                    id="preview_nominee_image"
                                                                                    alt="nominee_image"
                                                                                    src="{{ isset($nominee->nominee_image) ? asset('storage/nominee/' . $nominee->nominee_image) : asset('storage/placeholder/profile.png') }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @if (auth()->user()->can('Client Saving Account Edit'))
                                                            <a href="{{ Route('accounts.activeSavings.edit', ['name' => request()->name, 'id' => $activeSavings->id]) }}"
                                                                id="register-edit"
                                                                class="btn btn-warning text-light mt-5 w-full">Edit</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- END: Savings Account -->
                </div>
            </div>
            <div class="tab-pane fade" id="deactive-savings" role="tabpanel" aria-labelledby="deactive-savings-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Savings Account -->
                    <div class="intro-y box g-col-12">
                        <div class="px-5">
                            <ul class="nav nav-link-tabs flex-column flex-sm-row justify-content-center justify-content-lg-start"
                                role="tablist">
                                @forelse ($allDeactiveSavings as $keys => $deactiveSavings)
                                    <li id="deactiveSavings{{ $deactiveSavings->id }}-tab" class="nav-item"
                                        role="presentation">
                                        <a href="javascript:;"
                                            class="nav-link px-0 me-sm-8 d-flex align-items-center {{ $keys === 0 ? 'active' : '' }}"
                                            data-bs-toggle="pill"
                                            data-bs-target="#deactiveSavings{{ $deactiveSavings->id }}" role="tab"
                                            aria-controls="deactiveSavings{{ $deactiveSavings->id }}-tab"
                                            aria-selected="false">
                                            <i class="w-4 h-4 me-2" data-feather="command"></i>
                                            {{ $deactiveSavings->type->name }}
                                        </a>
                                    </li>
                                @empty
                                    <div class="d-flex justify-content-center align-items-center w-100"
                                        style="height: 200px;">
                                        <p class="text-center">No Records Found!</p>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="intro-y box g-col-12">
                        @foreach ($allDeactiveSavings as $key => $deactiveSavings)
                            <div class="tab-pane fade {{ $key === 0 ? 'show active' : '' }}"
                                id="deactiveSavings{{ $deactiveSavings->id }}" role="tabpanel"
                                aria-labelledby="deactiveSavings{{ $deactiveSavings->id }}-tab">
                                <div class="grid columns-12 gap-6">
                                    <div class="intro-y box g-col-12">
                                        <div
                                            class="d-flex align-items-center px-5 py-3 border-bottom border-gray-200 dark-border-dark-5">
                                            <h2 class="fw-medium fs-base me-auto">
                                                {{ $deactiveSavings->type->name }}
                                            </h2>
                                        </div>
                                        <div id="new-products" class="py-5">
                                            <div class="px-5">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p class="truncate white-space-sm-normal mb-3">Status:
                                                            <span class="float-end fw-medium">
                                                                @if ($deactiveSavings->status)
                                                                    <span
                                                                        class="badge rounded-3 bg-success p-2">ACTIVE</span>
                                                                @else
                                                                    <span
                                                                        class="badge rounded-3 bg-danger p-2">DACTIVE</span>
                                                                @endif
                                                            </span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">View:
                                                            <a href="{{ Route('accounts.savingProfile', ['name' => request()->name, 'id' => $deactiveSavings->id]) }}"
                                                                class="text-info float-end fw-medium">
                                                                <i data-feather="folder"></i>
                                                            </a>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Balance:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveSavings->balance }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Registration
                                                            Officer:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveSavings->User->name }}</span>
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                                        <p class="truncate white-space-sm-normal mb-3">deposit:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveSavings->deposit }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveSavings->interest }}%</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total Deposit
                                                            (Except
                                                            Interest)
                                                            :
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveSavings->total_except_interest }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total
                                                            Deposit (Included
                                                            Interest):
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveSavings->total_include_interest }}/-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="truncate white-space-sm-normal mb-3">Started at:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveSavings->start_date }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Duration:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveSavings->duration_date }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Closing at:
                                                            <span
                                                                class="float-end fw-medium">{{ date('d M, Y', strtotime($deactiveSavings->closing_at)) }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Description:
                                                            <span
                                                                class="float-end fw-medium">{!! $deactiveSavings->closing_expression !!}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Closing Interest:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveSavings->closing_interest }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Closing Balance
                                                            (included Inerest):
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveSavings->closing_balance_include_interest }}/-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <div class="row">
                                                            @foreach ($deactiveSavings->SavingNominee as $index => $nominee)
                                                                <div
                                                                    class="d-flex align-items-center py-3 my-3 border-top border-bottom border-gray-200 dark-border-dark-5">
                                                                    <h2 class="fw-medium fs-base me-auto">
                                                                        Nominee-{{ ++$index }}
                                                                    </h2>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <p class="truncate white-space-sm-normal mb-3">Name:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $nominee->name }}</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">Date of
                                                                        Birth:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $nominee->dob }}</span>
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                                                    <p class="truncate white-space-sm-normal mb-3">Segment:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $nominee->segment }}%</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">
                                                                        Relation:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $nominee->relation }}</span>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="w-52">
                                                                        <div
                                                                            class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                                            <div
                                                                                class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                                                <img class="rounded-2"
                                                                                    id="preview_client_image"
                                                                                    alt="client_image"
                                                                                    src="{{ isset($nominee->nominee_image) ? asset('storage/nominee/' . $nominee->nominee_image) : asset('storage/placeholder/profile.png') }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- END: Savings Account -->
                </div>
            </div>
            <div class="tab-pane fade" id="active-loans" role="tabpanel" aria-labelledby="active-loans-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Savings Account -->
                    <div class="intro-y box g-col-12">
                        <div class="px-5">
                            <ul class="nav nav-link-tabs flex-column flex-sm-row justify-content-center justify-content-lg-start"
                                role="tablist">
                                @forelse ($allActiveLoans as $keys => $activeLoan)
                                    <li id="activeLoans{{ $activeLoan->id }}-tab" class="nav-item" role="presentation">
                                        <a href="javascript:;"
                                            class="nav-link px-0 me-sm-8 d-flex align-items-center {{ $keys === 0 ? 'active' : '' }}"
                                            data-bs-toggle="pill" data-bs-target="#activeLoans{{ $activeLoan->id }}"
                                            role="tab" aria-controls="activeLoans{{ $activeLoan->id }}-tab"
                                            aria-selected="false">
                                            <i class="w-4 h-4 me-2" data-feather="command"></i>
                                            {{ $activeLoan->type->name }}
                                        </a>
                                    </li>
                                @empty
                                    <div class="d-flex justify-content-center align-items-center w-100"
                                        style="height: 200px;">
                                        <p class="text-center">No Records Found!</p>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="intro-y box g-col-12">
                        @foreach ($allActiveLoans as $key => $activeLoan)
                            <div class="tab-pane fade {{ $key === 0 ? 'show active' : '' }}"
                                id="activeLoans{{ $activeLoan->id }}" role="tabpanel"
                                aria-labelledby="activeLoans{{ $activeLoan->id }}-tab">
                                <div class="grid columns-12 gap-6">
                                    <div class="intro-y box g-col-12">
                                        <div
                                            class="d-flex align-items-center px-5 py-3 border-bottom border-gray-200 dark-border-dark-5">
                                            <h2 class="fw-medium fs-base me-auto">
                                                {{ $activeLoan->type->name }}
                                            </h2>
                                        </div>
                                        <div id="new-products" class="py-5">
                                            <div class="px-5">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p class="truncate white-space-sm-normal mb-3">Status:
                                                            <span class="float-end fw-medium">
                                                                @if ($activeLoan->status)
                                                                    <span
                                                                        class="badge rounded-3 bg-success p-2">ACTIVE</span>
                                                                @else
                                                                    <span
                                                                        class="badge rounded-3 bg-danger p-2">DACTIVE</span>
                                                                @endif
                                                            </span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">View:
                                                            <a href="{{ Route('accounts.loanProfile', ['name' => request()->name, 'id' => $activeLoan->id]) }}"
                                                                class="text-info float-end fw-medium">
                                                                <i data-feather="folder"></i>
                                                            </a>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Recovered
                                                            Installment:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeLoan->installment_recovered }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Balance:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->balance }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Loan Recovered:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->loan_recovered }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Loan Remaining:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->loan_remaining }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest Recovered:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->interest_recovered }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest Remaining:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->interest_remaining }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Registration
                                                            Officer:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeLoan->User->name }}</span>
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                                        <p class="truncate white-space-sm-normal mb-3">Loan Given:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->loan_given }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total Installment:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeLoan->total_installment }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeLoan->interest }}%</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total Interest:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->total_interest }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total Loan (Included
                                                            Interest):
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->total_loan_inc_int }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Deposit
                                                            (Installment)
                                                            :
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->deposit }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Loan (Installment)
                                                            :
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->loan_installment }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest
                                                            (Installment):
                                                            <span
                                                                class="float-end fw-medium">৳{{ $activeLoan->interest_installment }}/-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="truncate white-space-sm-normal mb-3">Started at:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeLoan->start_date }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Duration:
                                                            <span
                                                                class="float-end fw-medium">{{ $activeLoan->duration_date }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <div class="row">
                                                            @foreach ($activeLoan->LoanGuarantor as $index => $guarantor)
                                                                <div
                                                                    class="d-flex align-items-center py-3 my-3 border-top border-bottom border-gray-200 dark-border-dark-5">
                                                                    <h2 class="fw-medium fs-base me-auto">
                                                                        Guarantor-{{ ++$index }}
                                                                    </h2>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <p class="truncate white-space-sm-normal mb-3">Name:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $guarantor->name }}</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">Father
                                                                        Name:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $guarantor->father_name }}</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">Mother
                                                                        Name:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $guarantor->mother_name }}</span>
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                                                    <p class="truncate white-space-sm-normal mb-3">
                                                                        NID:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $guarantor->nid }}</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">
                                                                        Address:
                                                                        <span
                                                                            class="float-end fw-medium">{!! $guarantor->address !!}</span>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="w-52">
                                                                        <div
                                                                            class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                                            <div
                                                                                class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                                                <img class="rounded-2"
                                                                                    id="preview_client_image"
                                                                                    alt="client_image"
                                                                                    src="{{ isset($guarantor->guarentor_image) ? asset('storage/guarantor/' . $guarantor->guarentor_image) : asset('storage/placeholder/profile.png') }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        @if (auth()->user()->can('Client Loan Account Edit'))
                                                            <a href="{{ Route('accounts.activeLoans.edit', ['name' => request()->name, 'id' => $activeLoan->id]) }}"
                                                                id="register-edit"
                                                                class="btn btn-warning text-light mt-5 w-full">Edit</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- END: Savings Account -->
                </div>
            </div>
            <div class="tab-pane fade" id="deactive-loans" role="tabpanel" aria-labelledby="deactive-loans-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Savings Account -->
                    <div class="intro-y box g-col-12">
                        <div class="px-5">
                            <ul class="nav nav-link-tabs flex-column flex-sm-row justify-content-center justify-content-lg-start"
                                role="tablist">
                                @forelse ($allDeactiveLoans as $keys => $deactiveLoan)
                                    <li id="deactiveLoans{{ $deactiveLoan->id }}-tab" class="nav-item"
                                        role="presentation">
                                        <a href="javascript:;"
                                            class="nav-link px-0 me-sm-8 d-flex align-items-center {{ $keys === 0 ? 'active' : '' }}"
                                            data-bs-toggle="pill" data-bs-target="#deactiveLoans{{ $deactiveLoan->id }}"
                                            role="tab" aria-controls="deactiveLoans{{ $deactiveLoan->id }}-tab"
                                            aria-selected="false">
                                            <i class="w-4 h-4 me-2" data-feather="command"></i>
                                            {{ $deactiveLoan->type->name }}
                                        </a>
                                    </li>
                                @empty
                                    <div class="d-flex justify-content-center align-items-center w-100"
                                        style="height: 200px;">
                                        <p class="text-center">No Records Found!</p>
                                    </div>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="intro-y box g-col-12">
                        @foreach ($allDeactiveLoans as $key => $deactiveLoan)
                            <div class="tab-pane fade {{ $key === 0 ? 'show active' : '' }}"
                                id="deactiveLoans{{ $deactiveLoan->id }}" role="tabpanel"
                                aria-labelledby="deactiveLoans{{ $deactiveLoan->id }}-tab">
                                <div class="grid columns-12 gap-6">
                                    <div class="intro-y box g-col-12">
                                        <div
                                            class="d-flex align-items-center px-5 py-3 border-bottom border-gray-200 dark-border-dark-5">
                                            <h2 class="fw-medium fs-base me-auto">
                                                {{ $deactiveLoan->type->name }}
                                            </h2>
                                        </div>
                                        <div id="new-products" class="py-5">
                                            <div class="px-5">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p class="truncate white-space-sm-normal mb-3">Status:
                                                            <span class="float-end fw-medium">
                                                                @if ($deactiveLoan->status)
                                                                    <span
                                                                        class="badge rounded-3 bg-success p-2">ACTIVE</span>
                                                                @else
                                                                    <span
                                                                        class="badge rounded-3 bg-danger p-2">DACTIVE</span>
                                                                @endif
                                                            </span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">View:
                                                            <a href="{{ Route('accounts.loanProfile', ['name' => request()->name, 'id' => $deactiveLoan->id]) }}"
                                                                class="text-info float-end fw-medium">
                                                                <i data-feather="folder"></i>
                                                            </a>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Recovered
                                                            Installment:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveLoan->installment_recovered }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Balance:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->balance }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Loan Recovered:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->loan_recovered }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Loan Remaining:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->loan_remaining }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest Recovered:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->interest_recovered }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest Remaining:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->interest_remaining }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Registration
                                                            Officer:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveLoan->User->name }}</span>
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                                        <p class="truncate white-space-sm-normal mb-3">Loan Given:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->loan_given }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total Installment:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveLoan->total_installment }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveLoan->interest }}%</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total Interest:
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->total_interest }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Total Loan (Included
                                                            Interest):
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->total_loan_inc_int }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Deposit
                                                            (Installment)
                                                            :
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->deposit }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Loan (Installment)
                                                            :
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->loan_installment }}/-</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Interest
                                                            (Installment):
                                                            <span
                                                                class="float-end fw-medium">৳{{ $deactiveLoan->interest_installment }}/-</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="truncate white-space-sm-normal mb-3">Started at:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveLoan->start_date }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Duration:
                                                            <span
                                                                class="float-end fw-medium">{{ $deactiveLoan->duration_date }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Closing at:
                                                            <span
                                                                class="float-end fw-medium">{{ date('d M, Y', strtotime($deactiveLoan->deleted_at)) }}</span>
                                                        </p>
                                                        <p class="truncate white-space-sm-normal mb-3">Description:
                                                            <span
                                                                class="float-end fw-medium">{!! $deactiveLoan->closing_expression !!}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <div class="row">
                                                            @foreach ($deactiveLoan->LoanGuarantor as $index => $guarantor)
                                                                <div
                                                                    class="d-flex align-items-center py-3 my-3 border-top border-bottom border-gray-200 dark-border-dark-5">
                                                                    <h2 class="fw-medium fs-base me-auto">
                                                                        Guarantor-{{ ++$index }}
                                                                    </h2>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <p class="truncate white-space-sm-normal mb-3">Name:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $guarantor->name }}</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">Father
                                                                        Name:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $guarantor->father_name }}</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">Mother
                                                                        Name:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $guarantor->mother_name }}</span>
                                                                    </p>
                                                                </div>
                                                                <div
                                                                    class="col-md-4 border-start border-end border-gray-200 dark-border-dark-5">
                                                                    <p class="truncate white-space-sm-normal mb-3">
                                                                        NID:
                                                                        <span
                                                                            class="float-end fw-medium">{{ $guarantor->nid }}</span>
                                                                    </p>
                                                                    <p class="truncate white-space-sm-normal mb-3">
                                                                        Address:
                                                                        <span
                                                                            class="float-end fw-medium">{!! $guarantor->address !!}</span>
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="w-52">
                                                                        <div
                                                                            class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                                            <div
                                                                                class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                                                <img class="rounded-2"
                                                                                    id="preview_client_image"
                                                                                    alt="client_image"
                                                                                    src="{{ isset($guarantor->guarentor_image) ? asset('storage/guarantor/' . $guarantor->guarentor_image) : asset('storage/placeholder/profile.png') }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- END: Savings Account -->
                </div>
            </div>
        </div>
        <!-- END: Profile Details -->
    </div>
@endsection
