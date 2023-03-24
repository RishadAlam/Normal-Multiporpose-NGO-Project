@extends('layouts.main')

@push('title')
    {{ $account->type->name }} Saving Profile
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">
        {{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ $account->type->name }} Saving Profile</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="intro-y d-flex align-items-center">
            <h2 class="fs-lg fw-medium me-auto">
                {{ $account->type->name }} Saving Profile
            </h2>
            @if (auth()->user()->can('Check Account'))
                <button type="button" data-bs-toggle="modal" data-bs-target="#account-checked"
                    class="btn btn-primary w-40 ms-auto">Check this Account</button>
            @endif
        </div>
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="d-flex flex-column flex-lg-row border-bottom border-gray-200 dark-border-dark-5 pb-5 mx-n5">
                <div class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                    <div class="w-20 h-20 w-sm-24 h-sm-24 flex-none w-lg-32 h-lg-32 image-fit position-relative">
                        <img alt="Client" class="rounded-circle"
                            src="{{ asset('storage/register/' . $account->ClientRegister->client_image) }}">
                    </div>
                    <div class="ms-5">
                        <div class="w-24 w-sm-40 truncate white-space-sm-wrap fw-medium fs-lg">
                            {{ $account->ClientRegister->name }}</div>
                        <div class="text-gray-600">Account No: {{ $account->acc_no }}</div>
                        <p class="truncate white-space-sm-normal">
                            <span class="fw-medium">
                                @if ($account->status)
                                    <span class="badge rounded-3 bg-success p-2">ACTIVE</span>
                                @else
                                    <span class="badge rounded-3 bg-danger p-2">DACTIVE</span>
                                @endif
                            </span>
                        </p>
                    </div>
                </div>
                <div
                    class="mt-6 mt-lg-0 flex-1 dark-text-gray-300 px-5 border-start border-end border-gray-200 dark-border-dark-5 border-top border-top-lg-0 pt-5 pt-lg-0">
                    <div class="fw-medium text-center text-lg-start mt-lg-3">Details Summary</div>
                    <div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start mt-4">
                        <div class="truncate white-space-sm-normal d-flex align-items-center">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Volume:</span>
                            {{ $account->volume->name }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Center:</span>
                            {{ $account->center->name }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Type:</span>
                            {{ $account->type->name }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Phone:</span>
                            {{ $account->ClientRegister->mobile }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Registration
                                officer:</span>
                            {{ $account->user->name }}
                        </div>
                    </div>
                </div>
                <div
                    class="mt-6 mt-lg-0 flex-1 dark-text-gray-300 px-5 border-start border-end border-gray-200 dark-border-dark-5 border-top border-top-lg-0 pt-5 pt-lg-0">
                    <div class="fw-medium text-center text-lg-start mt-lg-3">Details Summary</div>
                    <div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start mt-4">
                        <div class="truncate white-space-sm-normal d-flex align-items-center">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">deposit:</span>
                            ৳{{ $account->deposit }}/-
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Interest:</span>
                            {{ $account->interest }}%
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Total Deposit
                                (Except Interest):</span>
                            ৳{{ $account->total_except_interest }}/-
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Total Deposit
                                (Included Interest):</span>
                            ৳{{ $account->total_include_interest }}/-
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Started
                                At:</span>
                            {{ date('d M, Y', strtotime($account->start_date)) }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Duration:</span>
                            {{ date('d M, Y', strtotime($account->duration_date)) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Profile Info -->
        <!-- START: Profile Details -->
        <div class="intro-y tab-content mt-5">
            <div class="grid grid-cols-12 gap-5 my-5">
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">{{ $totalInstallment }}</div>
                    <div class="text-gray-600">Saving Installment</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">{{ $totalWithdrawal }}</div>
                    <div class="text-gray-600">Withdrawal (Number)</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">{{ $totalTransaction }}</div>
                    <div class="text-gray-600">Transaction (Number)</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">৳{{ $account->total_withdrawal }}/-</div>
                    <div class="text-gray-600">Total Withdrawal</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">৳{{ $account->balance }}/-</div>
                    <div class="text-gray-600">Balance</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">
                        @if (isset($lastCheck->created_at))
                            {{ date('d M, Y h:i:s A', strtotime($lastCheck->created_at)) }}
                        @endif
                    </div>
                    <div class="text-gray-600">Last Check</div>
                </div>
            </div>
        </div>
        <!-- END: Profile Details -->
        <!-- START: Accounts Details -->
        <div class="intro-y box mt-5">
            <div class="mt-6 mt-lg-0 px-5">
                <div class="float-end">
                    <form action="" method="get" id="dateRangeForm">
                        <input type="text" name="startDate" id="startDate" class="d-none"
                            value="{{ request()->startDate }}">
                        <input type="text" name="endDate" id="endDate" class="d-none"
                            value="{{ request()->endDate }}">
                    </form>
                    <div id="daterange" class="d-inline-block box mt-3"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                        <i data-feather="calendar"></i>&nbsp;
                        <span id="dateRangeval"></span> <i class='bx bx-caret-down'></i></i>
                    </div>
                </div>
                <ul class="nav nav-link-tabs flex-column flex-sm-row justify-content-center justify-content-lg-start"
                    role="tablist">
                    <li id="statement-tab" class="nav-item" role="presentation">
                        <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center active"
                            data-bs-toggle="pill" data-bs-target="#statement" role="tab"
                            aria-controls="statement-tab" aria-selected="true"> <i class="w-4 h-4 me-2"
                                data-feather="dollar-sign"></i> Statement </a>
                    </li>
                    <li id="savings-tab" class="nav-item" role="presentation">
                        <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center"
                            data-bs-toggle="pill" data-bs-target="#savings" role="tab" aria-controls="savings-tab"
                            aria-selected="false"> <i class="w-4 h-4 me-2" data-feather="bar-chart"></i> Savings
                        </a>
                    </li>
                    <li id="Withdrawal-tab" class="nav-item" role="presentation">
                        <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center"
                            data-bs-toggle="pill" data-bs-target="#Withdrawal" role="tab"
                            aria-controls="Withdrawal-tab" aria-selected="false"> <i class="w-4 h-4 me-2"
                                data-feather="bar-chart-2"></i> Withdrawal
                        </a>
                    </li>
                    <li id="Transactions-tab" class="nav-item" role="presentation">
                        <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center"
                            data-bs-toggle="pill" data-bs-target="#Transactions" role="tab"
                            aria-controls="Transactions-tab" aria-selected="false"> <i class="w-4 h-4 me-2"
                                data-feather="globe"></i> Transactions
                        </a>
                    </li>
                    <li id="account-check-tab" class="nav-item" role="presentation">
                        <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center"
                            data-bs-toggle="pill" data-bs-target="#account-check" role="tab"
                            aria-controls="account-check-tab" aria-selected="false"> <i class="w-4 h-4 me-2"
                                data-feather="layers"></i> Check
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="intro-y tab-content mt-5">
            <div class="tab-pane fade show active" id="statement" role="tabpanel" aria-labelledby="statement-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Statement Table -->
                    <div class="intro-y box g-col-12">
                        <div class="card rounded rounded-3 border-0 card-body-dark"
                            style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                            <div class="card-header py-5">
                                <b class="text-uppercase" style="font-size: 18px;">Account Statement</b>
                            </div>
                            <div class="card-body p-0">
                                <div class="intro-y overflow-x-auto">
                                    <table class="table table-hover table-striped table-report">
                                        <thead class="bg-theme-1 text-white border-b-0">
                                            <tr>
                                                <th style="width: 2%;" class="border-bottom-0 text-nowrap text-start">
                                                    #</th>
                                                <th class="border-bottom-0 text-nowrap">Date</th>
                                                <th class="border-bottom-0 text-nowrap">Officer</th>
                                                <th class="border-bottom-0 text-nowrap">Transaction Type</th>
                                                <th class="border-bottom-0 text-nowrap">Description</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Deposit</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Withdraw</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                if (isset(request()->startDate)) {
                                                    $balanceDate = carbon\Carbon::parse(request()->startDate)->subDay();
                                                } else {
                                                    $balanceDate = carbon\Carbon::now()
                                                        ->startOfMonth()
                                                        ->subDay();
                                                }
                                                $deposit = 0;
                                                $withdrawal = 0;
                                                $balance = $accountBalance;
                                            @endphp
                                            @if ($accountBalance > 0)
                                                <tr>
                                                    <td>0</td>
                                                    <td class="text-nowrap">
                                                        {{ date('d-m-Y h:i:s A', strtotime($balanceDate)) }}</td>
                                                    <td></td>
                                                    <td>Account Balance</td>
                                                    <td></td>
                                                    <td class="text-end">৳{{ $accountBalance }}/-</td>
                                                    <td class="text-end">৳{{ 0 }}/-</td>
                                                    <td class="text-end">৳{{ $accountBalance }}/-</td>
                                                </tr>
                                            @endif
                                            @forelse ($statements as $key => $statement)
                                                @php
                                                    $deposit += $statement->deposit;
                                                    $withdrawal += $statement->withdraw;
                                                    $balance += $statement->deposit - $statement->withdraw;
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td class="text-nowrap">
                                                        {{ date('d-m-Y h:i:s A', strtotime($statement->created_at)) }}</td>
                                                    <td class="text-nowrap">{{ $statement->User->name }}</td>
                                                    <td>{{ $statement->type }}</td>
                                                    <td>{!! $statement->expression !!}</td>
                                                    <td
                                                        class="text-end @if ($statement->deposit < $account->deposit && $statement->type == 'Deposit') {{ 'bg-danger text-white' }} 
                                                @elseif ($statement->deposit > $account->deposit && $statement->type == 'Deposit') {{ 'bg-success text-white' }} @endif">
                                                        ৳{{ $statement->deposit }}/-</td>
                                                    <td class="text-end">৳{{ $statement->withdraw }}/-</td>
                                                    <td class="text-end">৳{{ $balance }}/-</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No records found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-end"><b>TOTAL:</b></td>
                                                <td class="text-end"><b>৳{{ $deposit }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $withdrawal }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $balance }}/-</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Statement Table -->
                </div>
            </div>
            <div class="tab-pane fade" id="savings" role="tabpanel" aria-labelledby="savings-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Saving Collection Table -->
                    <div class="intro-y box g-col-12">
                        <div class="card rounded rounded-3 border-0 card-body-dark"
                            style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                            <div class="card-header py-5">
                                <b class="text-uppercase" style="font-size: 18px;">Account Saving Collection</b>
                            </div>
                            <div class="card-body p-0">
                                <div class="intro-y overflow-x-auto">
                                    <table class="table table-hover table-striped table-report">
                                        <thead class="bg-theme-1 text-white border-b-0">
                                            <tr>
                                                <th style="width: 2%;" class="border-bottom-0 text-nowrap text-start">
                                                    #</th>
                                                <th class="border-bottom-0 text-nowrap">Date</th>
                                                <th class="border-bottom-0 text-nowrap">Officer</th>
                                                <th class="border-bottom-0 text-nowrap">Description</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Deposit</th>
                                                @if (auth()->user()->can('Account Collection Edit'))
                                                    <th class="border-bottom-0 text-nowrap text-center">Edit</th>
                                                @endif
                                                @if (auth()->user()->can('Account Collection Delete'))
                                                    <th class="border-bottom-0 text-nowrap text-center">Delete</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @forelse ($savingsCollectionTables as $key => $savingsCollection)
                                                @php
                                                    $total += $savingsCollection->deposit;
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td class="text-nowrap">
                                                        {{ date('d-m-Y h:i:s A', strtotime($savingsCollection->created_at)) }}
                                                    </td>
                                                    <td class="text-nowrap">{{ $savingsCollection->User->name }}</td>
                                                    <td>{!! $savingsCollection->expression !!}</td>
                                                    <td class="text-end">৳{{ $savingsCollection->deposit }}/-</td>
                                                    @if (auth()->user()->can('Account Collection Edit'))
                                                        <td class="text-primary text-info cursor-pointer text-center"
                                                            data-bs-toggle="modal" data-bs-target="#update-collection">
                                                            <span class="cursor-pointer collection-edit"
                                                                data-id="{{ $savingsCollection->id }}"><i
                                                                    data-feather="edit"></i></span>
                                                        </td>
                                                    @endif
                                                    @if (auth()->user()->can('Account Collection Delete'))
                                                        <td class="text-primary text-info cursor-pointer text-center">
                                                            <span class="cursor-pointer collection-delete"
                                                                data-id="{{ $savingsCollection->id }}"><i
                                                                    data-feather="trash"></i></span>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No records found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><b>TOTAL:</b></td>
                                                <td class="text-end"><b>৳{{ $total }}/-</b></td>
                                                @if (auth()->user()->can('Account Collection Edit'))
                                                    <td></td>
                                                @endif
                                                @if (auth()->user()->can('Account Collection Delete'))
                                                    <td></td>
                                                @endif
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            {{ $savingsCollectionTables->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    <!-- END: Saving Collection Table -->
                </div>
            </div>
            <div class="tab-pane fade" id="Withdrawal" role="tabpanel" aria-labelledby="Withdrawal-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Withdrawal Table -->
                    <div class="intro-y box g-col-12">
                        <div class="card rounded rounded-3 border-0 card-body-dark"
                            style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                            <div class="card-header py-5">
                                <b class="text-uppercase" style="font-size: 18px;">Account Withdrawal</b>
                            </div>
                            <div class="card-body p-0">
                                <div class="intro-y overflow-x-auto">
                                    <table class="table table-hover table-striped table-report">
                                        <thead class="bg-theme-1 text-white border-b-0">
                                            <tr>
                                                <th style="width: 2%;" class="border-bottom-0 text-nowrap text-start">
                                                    #</th>
                                                <th class="border-bottom-0 text-nowrap">Date</th>
                                                <th class="border-bottom-0 text-nowrap">Officer</th>
                                                <th class="border-bottom-0 text-nowrap">Description</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Withdrawal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total = 0;
                                            @endphp
                                            @forelse ($savingsWithdrawalTables as $key => $savingsWithdrawal)
                                                @php
                                                    $total += $savingsWithdrawal->withdraw;
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td class="text-nowrap">
                                                        {{ date('d-m-Y h:i:s A', strtotime($savingsWithdrawal->created_at)) }}
                                                    </td>
                                                    <td class="text-nowrap">{{ $savingsWithdrawal->User->name }}</td>
                                                    <td>{!! $savingsWithdrawal->expression !!}</td>
                                                    <td class="text-end">৳{{ $savingsWithdrawal->withdraw }}/-</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No records found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><b>TOTAL:</b></td>
                                                <td class="text-end"><b>৳{{ $total }}/-</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            {{ $savingsWithdrawalTables->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    <!-- END: Withdrawal Table -->
                </div>
            </div>
            <div class="tab-pane fade" id="Transactions" role="tabpanel" aria-labelledby="Transactions-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Transaction Table -->
                    <div class="intro-y box g-col-12">
                        <div class="card rounded rounded-3 border-0 card-body-dark"
                            style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                            <div class="card-header py-5">
                                <b class="text-uppercase" style="font-size: 18px;">Account Transactions</b>
                            </div>
                            <div class="card-body p-0">
                                <div class="intro-y overflow-x-auto">
                                    <table class="table table-hover table-striped table-report">
                                        <thead class="bg-theme-1 text-white border-b-0">
                                            <tr>
                                                <th style="width: 2%;" class="border-bottom-0 text-nowrap text-start">
                                                    #</th>
                                                <th class="border-bottom-0 text-nowrap">Date</th>
                                                <th class="border-bottom-0 text-nowrap">Officer</th>
                                                <th class="border-bottom-0 text-nowrap">Transacion Type</th>
                                                <th class="border-bottom-0 text-nowrap">Account No</th>
                                                <th class="border-bottom-0 text-nowrap">Account Name</th>
                                                <th class="border-bottom-0 text-nowrap">Type</th>
                                                <th class="border-bottom-0 text-nowrap">Description</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Received</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Sanded</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $Received = 0;
                                                $sandad = 0;
                                            @endphp
                                            @forelse ($transactionTable as $key => $savingsTransaction)
                                                @php
                                                    $Received += $savingsTransaction->deposit;
                                                    $sandad += $savingsTransaction->withdraw;
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td class="text-nowrap">
                                                        {{ date('d-m-Y h:i:s A', strtotime($savingsTransaction->created_at)) }}
                                                    </td>
                                                    <td class="text-nowrap">{{ $savingsTransaction->User->name }}</td>
                                                    <td>{{ $savingsTransaction->type }}</td>
                                                    <td>{{ $savingsTransaction->acc_no }}</td>
                                                    <td class="text-nowrap">
                                                        {{ $savingsTransaction->to_client_register->name }}</td>
                                                    <td>{{ $savingsTransaction->to_type->name }}</td>
                                                    <td>{!! $savingsTransaction->expression !!}</td>
                                                    <td class="text-end">৳{{ $savingsTransaction->deposit }}/-</td>
                                                    <td class="text-end">৳{{ $savingsTransaction->withdraw }}/-</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center">No records found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8" class="text-end"><b>TOTAL:</b></td>
                                                <td class="text-end"><b>৳{{ $Received }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $sandad }}/-</b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            {{ $transactionTable->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    <!-- END: Transaction Table -->
                </div>
            </div>
            <div class="tab-pane fade" id="account-check" role="tabpanel" aria-labelledby="account-check-tab">
                <div class="grid columns-12 gap-6">
                    <!-- BEGIN: Transaction Table -->
                    <div class="intro-y box g-col-12">
                        <div class="card rounded rounded-3 border-0 card-body-dark"
                            style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                            <div class="card-header py-5">
                                <b class="text-uppercase" style="font-size: 18px;">Account Transactions</b>
                            </div>
                            <div class="card-body p-0">
                                <div class="intro-y overflow-x-auto">
                                    <table class="table table-hover table-striped table-report">
                                        <thead class="bg-theme-1 text-white border-b-0">
                                            <tr>
                                                <th style="width: 2%;" class="border-bottom-0 text-nowrap text-start">
                                                    #</th>
                                                <th class="border-bottom-0 text-nowrap">Date</th>
                                                <th class="border-bottom-0 text-nowrap">Officer</th>
                                                <th class="border-bottom-0 text-nowrap">Description</th>
                                                <th class="border-bottom-0 text-nowrap">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($accountCheckTables as $key => $accountCheck)
                                                @php
                                                    $balance += $accountCheck->balance;
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td class="text-nowrap">
                                                        {{ date('d-m-Y h:i:s A', strtotime($accountCheck->created_at)) }}
                                                    </td>
                                                    <td class="text-nowrap">{{ $accountCheck->User->name }}</td>
                                                    <td>{!! $accountCheck->expression !!}</td>
                                                    <td>৳{{ $accountCheck->balance }}/-</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No records found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $accountCheckTables->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                    <!-- END: Transaction Table -->
                </div>
            </div>
        </div>
        <!-- END: Accounts Details -->


        @if (auth()->user()->can('Check Account'))
            <div id="account-checked" class="modal fade" tabindex="-1" aria-hidden="true"
                style="z-index: 99999999 !important">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <h5 class="modal-title">Saving Account Check</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ Route('accounts.savingProfile.check', $account->id) }}" method="POST">
                            @csrf

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="name" class="form-label">Name
                                                <span class="text-danger">*</span></label>
                                            <input id="name" type="Text" name="name" class="form-control"
                                                value="{{ $account->ClientRegister->name }}" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="acc_no" class="form-label">Account No
                                                <span class="text-danger">*</span></label>
                                            <input id="acc_no" type="Text" name="acc_no" class="form-control"
                                                value="{{ $account->acc_no }}" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="balance" class="form-label">Balance
                                                <span class="text-danger">*</span></label>
                                            <input id="balance" type="Text" name="balance" class="form-control"
                                                value="{{ $account->balance }}" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="input-form">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="summernote" rows="3" name="description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Check</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        @if (auth()->user()->can('Account Collection Edit'))
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
                        <form id="update_collection">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="past_balance" class="form-label">Past Balance <span
                                                    class="text-danger">*</span></label>
                                            <input id="past_balance" type="text" class="form-control"
                                                placeholder="xxxx" name="past_balance" required readonly>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger past_balance_error"></span>
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
                                            <label for="present_balance" class="form-label">Balance <span
                                                    class="text-danger">*</span></label>
                                            <input id="present_balance" type="text" class="form-control"
                                                placeholder="xxxx" name="present_balance" required readonly>

                                            <input type="hidden" id="past_total_deposit" name="past_total_deposit">
                                            <input type="hidden" id="present_total_deposit"
                                                name="present_total_deposit">
                                            <input type="hidden" id="collection_id" name="collection_id">
                                            <input type="hidden" id="savingProfile_id" name="savingProfile_id">

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger present_balance_error"></span>
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


        $(document).ready(function() {
            // Success Msg Show
            @if (session()->has('success'))
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: true,
                })
            @endif

            // Collection Delete
            $(".collection-delete").on('click', function() {
                let id = $(this).data('id')
                let url = "{{ Route('accounts.savingProfile.delete', 'id') }}"
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

            $("#deposit").on('keyup', function() {
                collectionEdit()
            })

            function collectionEdit() {
                let PartBalance = $("#past_balance").val()
                let PartTotalDeposit = $("#past_total_deposit").val()
                let deposit = $("#deposit").val()

                $("#present_balance").val(parseInt(PartBalance) + parseInt(deposit))
                $("#present_total_deposit").val(parseInt(PartTotalDeposit) + parseInt(deposit))
            }

            // Collection Edit
            $(".collection-edit").on('click', function() {
                let id = $(this).data('id')

                $.ajax({
                    url: "{{ Route('accounts.savingProfile.edit') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $("#collection_id").val(data.id)
                        $("#savingProfile_id").val(data.savings_profile.id)
                        $("#past_balance").val(
                            parseInt(data.savings_profile.balance) - parseInt(data
                                .deposit)
                        )
                        $("#deposit").val(data.deposit)
                        $("#present_balance").val(data.savings_profile.balance)
                        $("#description").summernote('code', data.expression)

                        $("#past_total_deposit").val(
                            parseInt(data.savings_profile.total_deposit) - parseInt(data
                                .deposit)
                        )
                        $("#present_total_deposit").val(data.savings_profile.total_deposit)
                    },
                    error: function(data) {
                        console.table(data)
                    }
                })
            })

            /**
             * Update Form Submit
             */
            $("#update_collection").on("submit", function(e) {
                /**
                 * Form Preven Default
                 * Form Submit By Ajax
                 */
                e.preventDefault();
                let id = $('#collection_id').val()
                let savingID = $('#savingProfile_id').val()
                let submit_btn = $('#update_btn_submit')
                let close_btn = $('#update_btn_close')
                let formData = $("#update_collection").serialize()
                let url =
                    "{{ Route('accounts.savingProfile.update', ['id' => ':id', 'saving_id' => ':savingID']) }}"
                url = url.replace(':id', id)
                url = url.replace(':savingID', savingID)

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
        })
    </script>
@endsection
