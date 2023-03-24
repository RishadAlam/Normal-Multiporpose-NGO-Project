@extends('layouts.main')

@push('title')
    {{ $account->type->name }} Loan Profile
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">
        {{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ $account->type->name }} Loan Profile</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="intro-y d-flex align-items-center">
            <h2 class="fs-lg fw-medium me-auto">
                {{ $account->type->name }} Loan Profile
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
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Started
                                At:</span>
                            {{ date('d M, Y', strtotime($account->start_date)) }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Duration:</span>
                            {{ date('d M, Y', strtotime($account->duration_date)) }}
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
                    <div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start">
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Loan Given:</span>
                            ৳{{ $account->loan_given }}/-
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Interest:</span>
                            {{ $account->interest }}%
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Total
                                Interest:</span>
                            ৳{{ $account->total_interest }}/-
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Total
                                Installment:</span>
                            {{ $account->total_installment }}
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Deposit
                                (Installment):</span>
                            ৳{{ $account->deposit }}/-
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Loan
                                (Installment):</span>
                            ৳{{ $account->loan_installment }}/-
                        </div>
                        <div class="truncate white-space-sm-normal d-flex align-items-center mt-3">
                            <i data-feather="list" class="w-4 h-4 me-2"></i><span class="fw-medium me-2">Interest
                                (Installment):</span>
                            ৳{{ $account->interest_installment }}/-
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
                    <div class="fw-medium fs-base">{{ $account->installment_recovered }}/{{ $account->total_installment }}
                    </div>
                    <div class="text-gray-600">Installment Recovered</div>
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
                    <div class="fw-medium fs-base">৳{{ $account->loan_recovered }}/- / ৳{{ $account->loan_given }}/-
                    </div>
                    <div class="text-gray-600">Loan Recovered</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">৳{{ $account->loan_remaining }}/- / ৳{{ $account->loan_given }}/-
                    </div>
                    <div class="text-gray-600">Loan Remaining</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">৳{{ $account->interest_recovered }}/- /
                        ৳{{ $account->total_interest }}/-
                    </div>
                    <div class="text-gray-600">Interest Recovered</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">৳{{ $account->interest_remaining }}/- /
                        ৳{{ $account->total_interest }}/-
                    </div>
                    <div class="text-gray-600">Interest Remaining</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">৳{{ $account->loan_recovered + $account->interest_recovered }}/- /
                        ৳{{ $account->loan_given + $account->total_interest }}/-
                    </div>
                    <div class="text-gray-600">Total Recovered (Loan + Interest)</div>
                </div>
                <div class="g-col-12 g-col-sm-4 g-col-xxl-3 box p-5 cursor-pointer zoom-in">
                    <div class="fw-medium fs-base">৳{{ $account->loan_remaining + $account->interest_remaining }}/- /
                        ৳{{ $account->loan_given + $account->total_interest }}/-
                    </div>
                    <div class="text-gray-600">Total Remaining (Loan + Interest)</div>
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
                            aria-selected="false"> <i class="w-4 h-4 me-2" data-feather="bar-chart"></i> Loan
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
                                                <th class="border-bottom-0 text-nowrap text-end">Loan Recovered</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Loan Remaining</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Interest Recovered</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Interest Remaining</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Total Recovered</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Total Remaining</th>
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
                                                $totalLoanrecovered = $loanCollectionSum;
                                                $totalinterestrecovered = $interestCollectionSum;
                                                $totalLoanRemaining = $account->loan_given - $loanCollectionSum;
                                                $totalinterestRemaining = $account->total_interest - $interestCollectionSum;
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
                                                    <td class="text-end">৳{{ $totalLoanrecovered }}/-</td>
                                                    <td class="text-end">৳{{ $totalLoanRemaining }}/-</td>
                                                    <td class="text-end">৳{{ $totalinterestrecovered }}/-</td>
                                                    <td class="text-end">৳{{ $totalinterestRemaining }}/-</td>
                                                    <td class="text-end">
                                                        ৳{{ $totalLoanrecovered + $totalinterestrecovered }}/-
                                                    </td>
                                                    <td class="text-end">
                                                        ৳{{ $totalLoanRemaining + $totalinterestRemaining }}/-
                                                    </td>
                                                </tr>
                                            @endif
                                            @forelse ($statements as $key => $statement)
                                                @php
                                                    $deposit += $statement->deposit;
                                                    $withdrawal += $statement->withdraw;
                                                    $totalLoanrecovered += $statement->loan;
                                                    $totalinterestrecovered += $statement->interest;
                                                    $balance += $statement->deposit - $statement->withdraw;
                                                    $totalLoanRemaining -= $statement->loan;
                                                    $totalinterestRemaining -= $statement->interest;
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td class="text-nowrap">
                                                        {{ date('d-m-Y h:i:s A', strtotime($statement->created_at)) }}</td>
                                                    <td class="text-nowrap">{{ $statement->User->name }}</td>
                                                    <td>{{ $statement->type }}</td>
                                                    <td>{!! $statement->expression !!}</td>
                                                    <td
                                                        class="text-end 
                                                    @if ($statement->deposit < $account->deposit && $statement->type == 'Deposit') {{ 'bg-danger text-white' }} 
                                                @elseif ($statement->deposit > $account->deposit && $statement->type == 'Deposit') {{ 'bg-success text-white' }} @endif">
                                                        ৳{{ $statement->deposit }}/-
                                                    </td>
                                                    <td class="text-end">৳{{ $statement->withdraw }}/-</td>
                                                    <td class="text-end">৳{{ $balance }}/-</td>
                                                    <td
                                                        class="text-end 
                                                        @if ($statement->loan < $account->loan_installment && $statement->type == 'Deposit') {{ 'bg-danger text-white' }} 
                                                @elseif ($statement->loan > $account->loan_installment && $statement->type == 'Deposit') {{ 'bg-success text-white' }} @endif">
                                                        ৳{{ $statement->loan }}/-
                                                    </td>
                                                    <td class="text-end">৳{{ $totalLoanRemaining }}/-</td>
                                                    <td
                                                        class="text-end @if ($statement->interest < $account->interest_installment && $statement->type == 'Deposit') {{ 'bg-danger text-white' }} 
                                                @elseif ($statement->interest > $account->interest_installment && $statement->type == 'Deposit') {{ 'bg-success text-white' }} @endif">
                                                        ৳{{ $statement->interest }}/-</td>
                                                    <td class="text-end">৳{{ $totalinterestRemaining }}/-</td>
                                                    <td class="text-end">৳{{ $statement->loan + $statement->interest }}/-
                                                    </td>
                                                    <td class="text-end">
                                                        ৳{{ $totalLoanRemaining + $totalinterestRemaining }}/-
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="14" class="text-center">No records found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-end"><b>TOTAL:</b></td>
                                                <td class="text-end"><b>৳{{ $deposit }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $withdrawal }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $balance }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $totalLoanrecovered }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $totalLoanRemaining }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $totalinterestrecovered }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $totalinterestRemaining }}/-</b></td>
                                                <td class="text-end">
                                                    <b>৳{{ $totalLoanrecovered + $totalinterestrecovered }}/-</b>
                                                </td>
                                                <td class="text-end">
                                                    <b>৳{{ $totalLoanRemaining + $totalinterestRemaining }}/-</b>
                                                </td>
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
                                                <th class="border-bottom-0 text-nowrap text-end">Installment</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Deposit</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Loan</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Interest</th>
                                                <th class="border-bottom-0 text-nowrap text-end">Total</th>
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
                                                $total_installment = 0;
                                                $total_deposit = 0;
                                                $total_loan = 0;
                                                $total_interest = 0;
                                                $total = 0;
                                            @endphp
                                            @forelse ($loanCollectionTables as $key => $loanCollection)
                                                @php
                                                    $total_installment += $loanCollection->installment;
                                                    $total_deposit += $loanCollection->deposit;
                                                    $total_loan += $loanCollection->loan;
                                                    $total_interest += $loanCollection->interest;
                                                    $total += $loanCollection->total;
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ date('d-m-Y h:i:s A', strtotime($loanCollection->created_at)) }}
                                                    </td>
                                                    <td>{{ $loanCollection->User->name }}</td>
                                                    <td>{!! $loanCollection->expression !!}</td>
                                                    <td class="text-end">{{ $loanCollection->installment }}</td>
                                                    <td class="text-end">৳{{ $loanCollection->deposit }}/-</td>
                                                    <td class="text-end">৳{{ $loanCollection->loan }}/-</td>
                                                    <td class="text-end">৳{{ $loanCollection->interest }}/-</td>
                                                    <td class="text-end">৳{{ $loanCollection->total }}/-</td>
                                                    @if (auth()->user()->can('Account Collection Edit'))
                                                        <td class="text-primary text-info cursor-pointer text-center"
                                                            data-bs-toggle="modal" data-bs-target="#update-collection">
                                                            <span class="cursor-pointer collection-edit"
                                                                data-id="{{ $loanCollection->id }}"><i
                                                                    data-feather="edit"></i></span>
                                                        </td>
                                                    @endif
                                                    @if (auth()->user()->can('Account Collection Delete'))
                                                        <td class="text-primary text-info cursor-pointer text-center">
                                                            <span class="cursor-pointer collection-delete"
                                                                data-id="{{ $loanCollection->id }}"><i
                                                                    data-feather="trash"></i></span>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11" class="text-center">No records found!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4" class="text-end"><b>TOTAL:</b></td>
                                                <td class="text-end"><b>{{ $total_installment }}</b></td>
                                                <td class="text-end"><b>৳{{ $total_deposit }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $total_loan }}/-</b></td>
                                                <td class="text-end"><b>৳{{ $total_interest }}/-</b></td>
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
                            {{ $loanCollectionTables->links('pagination::bootstrap-5') }}
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
                                            @forelse ($loanSavingsWithdrawalTables as $key => $loanSavingsWithdrawal)
                                                @php
                                                    $total += $loanSavingsWithdrawal->withdraw;
                                                @endphp
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ date('d-m-Y h:i:s A', strtotime($loanSavingsWithdrawal->created_at)) }}
                                                    </td>
                                                    <td>{{ $loanSavingsWithdrawal->User->name }}</td>
                                                    <td>{!! $loanSavingsWithdrawal->expression !!}</td>
                                                    <td class="text-end">৳{{ $loanSavingsWithdrawal->withdraw }}/-</td>
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
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            {{ $loanSavingsWithdrawalTables->links('pagination::bootstrap-5') }}
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
                                                <th class="border-bottom-0 text-nowrap">Loan Recovered</th>
                                                <th class="border-bottom-0 text-nowrap">Loan Remaining</th>
                                                <th class="border-bottom-0 text-nowrap">Interest Recovered</th>
                                                <th class="border-bottom-0 text-nowrap">Interest Remaining</th>
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
                                                    <td>৳{{ $accountCheck->loan_recovered }}/-</td>
                                                    <td>৳{{ $accountCheck->loan_remaining }}/-</td>
                                                    <td>৳{{ $accountCheck->interest_recovered }}/-</td>
                                                    <td>৳{{ $accountCheck->interest_remaining }}/-</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No records found!</td>
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
                        <form action="{{ Route('accounts.loanProfile.check', $account->id) }}" method="POST">
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
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="loan_recovered" class="form-label">Loan Recovered
                                                <span class="text-danger">*</span></label>
                                            <input id="loan_recovered" type="Text" name="loan_recovered"
                                                class="form-control" value="{{ $account->loan_recovered }}" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="loan_remaining" class="form-label">Loan Remaining
                                                <span class="text-danger">*</span></label>
                                            <input id="loan_remaining" type="Text" name="loan_remaining"
                                                class="form-control" value="{{ $account->loan_remaining }}" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="interest_recovered" class="form-label">Interest Recovered
                                                <span class="text-danger">*</span></label>
                                            <input id="interest_recovered" type="Text" name="interest_recovered"
                                                class="form-control" value="{{ $account->interest_recovered }}" required
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="interest_remaining" class="form-label">Interest Remaining
                                                <span class="text-danger">*</span></label>
                                            <input id="interest_remaining" type="Text" name="interest_remaining"
                                                class="form-control" value="{{ $account->interest_remaining }}" required
                                                readonly>
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
                                            <label for="past_installment" class="form-label">Past Installment <span
                                                    class="text-danger">*</span></label>
                                            <input id="past_installment" type="text" class="form-control"
                                                placeholder="xxxx" name="past_installment" required readonly>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger past_installment_error"></span>
                                        </div>
                                    </div>
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
                                            <label for="past_loan_recovery" class="form-label">Past Loan Recovery <span
                                                    class="text-danger">*</span></label>
                                            <input id="past_loan_recovery" type="text" class="form-control"
                                                placeholder="xxxx" name="past_loan_recovery" required readonly>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger past_loan_recovery_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="past_interest_recovery" class="form-label">Past Interest Recovery
                                                <span class="text-danger">*</span></label>
                                            <input id="past_interest_recovery" type="text" class="form-control"
                                                placeholder="xxxx" name="past_interest_recovery" required readonly>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger past_interest_recovery_error"></span>
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
                                            <label for="deposit" class="form-label">Deposit <span
                                                    class="text-danger">*</span></label>
                                            <input id="deposit" type="text" class="form-control" placeholder="xxxx"
                                                name="deposit" required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger deposit_error"></span>
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
                                                name="interest" required>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger interest_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="total" class="form-label">Total <span
                                                    class="text-danger">*</span></label>
                                            <input id="total" type="text" class="form-control" placeholder="xxxx"
                                                name="total" required readonly>

                                            <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger total_error"></span>
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
                                            <input type="hidden" id="loanProfile_id" name="loanProfile_id">

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger present_balance_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="present_installment" class="form-label">Total Installment <span
                                                    class="text-danger">*</span></label>
                                            <input id="present_installment" type="text" class="form-control"
                                                placeholder="xxxx" name="present_installment" required readonly>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger present_installment_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="present_loan_recovery" class="form-label">Total Loan Recovery
                                                <span class="text-danger">*</span></label>
                                            <input id="present_loan_recovery" type="text" class="form-control"
                                                placeholder="xxxx" name="present_loan_recovery" required readonly>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger present_loan_recovery_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-form">
                                            <label for="present_interest_recovery" class="form-label">Total Interest
                                                Recovery
                                                <span class="text-danger">*</span></label>
                                            <input id="present_interest_recovery" type="text" class="form-control"
                                                placeholder="xxxx" name="present_interest_recovery" required readonly>

                                            <span
                                                class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger present_interest_recovery_error"></span>
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
                let url = "{{ Route('accounts.loanProfile.delete', 'id') }}"
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

            $('#installment').on('keyup', function() {
                total_loan()
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
                let pastInstallment = $("#past_installment").val()
                let pastLoanRec = $("#past_loan_recovery").val()
                let pastInterestRec = $("#past_interest_recovery").val()
                let PartBalance = $("#past_balance").val()
                let PartTotalDeposit = $("#past_total_deposit").val()
                let deposit = $('#deposit').val()
                let loan = $('#loan').val()
                let interest = $('#interest').val()
                let installment = $('#installment').val()

                $('#total').val(parseInt(deposit) + parseInt(loan) + parseInt(interest))
                $("#present_balance").val(parseInt(PartBalance) + parseInt(deposit))
                $("#present_total_deposit").val(parseInt(PartTotalDeposit) + parseInt(deposit))
                $("#present_installment").val(parseInt(pastInstallment) + parseInt(installment))
                $("#present_loan_recovery").val(parseInt(pastLoanRec) + parseInt(loan))
                $("#present_interest_recovery").val(parseInt(pastInterestRec) + parseInt(interest))
            }

            // Collection Edit
            $(".collection-edit").on('click', function() {
                let id = $(this).data('id')

                $.ajax({
                    url: "{{ Route('accounts.loanProfile.edit') }}",
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
                        $("#loanProfile_id").val(data.loan_profile_id)
                        $("#past_installment").val(
                            parseInt(data.loan_profile.installment_recovered) - parseInt(
                                data.installment)
                        )
                        $("#past_balance").val(
                            parseInt(data.loan_profile.balance) - parseInt(data
                                .deposit)
                        )
                        $("#past_loan_recovery").val(
                            parseInt(data.loan_profile.loan_recovered) - parseInt(data
                                .loan)
                        )
                        $("#past_interest_recovery").val(
                            parseInt(data.loan_profile.interest_recovered) - parseInt(data
                                .interest)
                        )
                        $("#installment").val(data.installment)
                        $("#deposit").val(data.deposit)
                        $("#loan").val(data.loan)
                        $("#interest").val(data.interest)
                        $("#total").val(data.total)
                        $("#present_balance").val(data.loan_profile.balance)
                        $("#present_installment").val(data.loan_profile.installment_recovered)
                        $("#present_loan_recovery").val(data.loan_profile.loan_recovered)
                        $("#present_interest_recovery").val(data.loan_profile
                            .interest_recovered)
                        $("#description").summernote('code', data.expression)

                        $("#past_total_deposit").val(
                            parseInt(data.loan_profile.total_deposit) - parseInt(data
                                .deposit)
                        )
                        $("#present_total_deposit").val(data.loan_profile.total_deposit)
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
                let loanID = $('#loanProfile_id').val()
                let submit_btn = $('#update_btn_submit')
                let close_btn = $('#update_btn_close')
                let formData = $("#update_collection").serialize()
                let url =
                    "{{ Route('accounts.loanProfile.update', ['id' => ':id', 'loan_id' => ':loanID']) }}"
                url = url.replace(':id', id)
                url = url.replace(':loanID', loanID)

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

            $(window).on('load', function() {
                cb()

                function cb() {
                    $(".daterangepicker .ranges ul").addClass('box')
                    $(".drp-buttons").addClass('box')
                    $(".cancelBtn").addClass('btn-danger')
                    $(".drp-calendar .calendar-table").addClass('box')

                    @if (isset(request()->startDate))
                        $("#daterange span").html(
                            "{{ request()->startDate }} -> {{ request()->endDate }}")
                    @endif
                }

                $('#dateRangeval').on("DOMSubtreeModified", function() {
                    let range = $(this).text()
                    if (range != '') {
                        let dateRange = range.split("->");
                        $("#startDate").val(dateRange[0]);
                        $("#endDate").val(dateRange[1]);
                        dateRangeFormSubmit()
                    }
                })

                $("#Officers").on("change", function() {
                    dateRangeFormSubmit()
                })

                // Daterange Form Submit
                function dateRangeFormSubmit() {
                    $("#dateRangeForm").trigger('submit')
                }
            })
        })
    </script>
@endsection
