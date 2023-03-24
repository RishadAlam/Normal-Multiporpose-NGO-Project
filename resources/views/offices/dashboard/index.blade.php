@extends('layouts.main')

@push('title')
    {{ __('Dashboard') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}" class="breadcrumb--active">{{ __('Dashboard') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 g-col-xxl-9">
        <div class="grid columns-12 gap-6">
            <!-- BEGIN: General Report -->
            <div class="g-col-12 mt-8">
                <div class="intro-y d-flex align-items-center h-10">
                    <h2 class="fs-lg fw-medium truncate me-5">
                        General Report
                    </h2>
                    <a href="{{ Route('home') }}" class="ms-auto d-flex align-items-center text-theme-1 dark-text-theme-10">
                        <i data-feather="refresh-ccw" class="w-4 h-4 me-3"></i> Reload Data </a>
                </div>
                <div class="grid columns-12 gap-6 mt-5">
                    <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="d-flex">
                                    <i data-feather="dollar-sign" class="report-box__icon text-theme-10"></i>
                                </div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">৳{{ $totalLoan }}/-</div>
                                <div class="fs-base text-gray-600 mt-1">Loan Given</div>
                            </div>
                        </div>
                    </div>
                    <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="d-flex">
                                    <i data-feather="dollar-sign" class="report-box__icon text-theme-11"></i>
                                </div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">৳{{ $totalLoanCollection }}/-</div>
                                <div class="fs-base text-gray-600 mt-1">Loan Recovered</div>
                            </div>
                        </div>
                    </div>
                    <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="d-flex">
                                    <i data-feather="dollar-sign" class="report-box__icon text-theme-12"></i>
                                </div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">৳{{ $totalLoanSavingsCollection }}/-
                                </div>
                                <div class="fs-base text-gray-600 mt-1">Loan Saving Collection</div>
                            </div>
                        </div>
                    </div>
                    <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="d-flex">
                                    <i data-feather="dollar-sign" class="report-box__icon text-theme-9"></i>
                                </div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">৳{{ $totalSavingsCollection }}/-</div>
                                <div class="fs-base text-gray-600 mt-1">Saving Collection</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: General Report -->
            <!-- BEGIN: Saving Collection Report -->
            <div class="g-col-12 mt-8">
                <div class="intro-y d-block d-sm-flex align-items-center h-10">
                    <h2 class="fs-lg fw-medium truncate me-5">
                        Today Savings Collection Report
                    </h2>
                </div>
                <div class="intro-y overflow-x-auto">
                    <table class="table table-hover table-striped table-report">
                        <thead class="bg-theme-1 text-white border-b-0">
                            <tr>
                                <th style="width: 2%;" class="border-bottom-0 text-nowrap text-start">#</th>
                                <th class="border-bottom-0 text-nowrap">Client Name</th>
                                <th class="border-bottom-0 text-nowrap">Account No</th>
                                <th class="border-bottom-0 text-nowrap">Volume</th>
                                <th class="border-bottom-0 text-nowrap">Center</th>
                                <th class="border-bottom-0 text-nowrap">Type</th>
                                <th class="border-bottom-0 text-nowrap">Description</th>
                                <th class="border-bottom-0 text-nowrap">Deposit</th>
                                <th class="border-bottom-0 text-nowrap">Officer</th>
                                <th class="border-bottom-0 text-nowrap">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($savingsCollections as $keys => $savingsCollection)
                                <tr>
                                    <td class="text-nowrap">{{ ++$keys }}</td>
                                    <td class="text-nowrap">{{ $savingsCollection->ClientRegister->name }}</td>
                                    <td class="text-nowrap">{{ $savingsCollection->acc_no }}</td>
                                    <td class="text-nowrap">{{ $savingsCollection->Volume->name }}</td>
                                    <td class="text-nowrap">{{ $savingsCollection->Center->name }}</td>
                                    <td class="text-nowrap">{{ $savingsCollection->Type->name }}</td>
                                    <td class="text-nowrap">{!! $savingsCollection->expression !!}</td>
                                    <td class="text-nowrap">৳{{ $savingsCollection->deposit }}/-</td>
                                    <td class="text-nowrap">{{ $savingsCollection->User->name }}</td>
                                    <td class="text-nowrap">
                                        {{ date('h:i:s A', strtotime($savingsCollection->created_at)) }}</td>
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
            <!-- END: Saving Collection Report -->
            <!-- BEGIN: Loan Collection Report -->
            <div class="g-col-12 mt-8">
                <div class="intro-y d-block d-sm-flex align-items-center h-10">
                    <h2 class="fs-lg fw-medium truncate me-5">
                        Today Loan Collection Report
                    </h2>
                </div>
                <div class="intro-y overflow-x-auto">
                    <table class="table table-hover table-striped table-report">
                        <thead class="bg-theme-1 text-white border-b-0">
                            <tr>
                                <th style="width: 2%;" class="border-bottom-0 text-nowrap text-start">#</th>
                                <th class="border-bottom-0 text-nowrap">Client Name</th>
                                <th class="border-bottom-0 text-nowrap">Account No</th>
                                <th class="border-bottom-0 text-nowrap">Volume</th>
                                <th class="border-bottom-0 text-nowrap">Center</th>
                                <th class="border-bottom-0 text-nowrap">Type</th>
                                <th class="border-bottom-0 text-nowrap">Description</th>
                                <th class="border-bottom-0 text-nowrap">Deposit</th>
                                <th class="border-bottom-0 text-nowrap">Loan</th>
                                <th class="border-bottom-0 text-nowrap">Interest</th>
                                <th class="border-bottom-0 text-nowrap">Total</th>
                                <th class="border-bottom-0 text-nowrap">Officer</th>
                                <th class="border-bottom-0 text-nowrap">Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loanCollections as $keys => $loanCollection)
                                <tr>
                                    <td class="text-nowrap">{{ ++$keys }}</td>
                                    <td class="text-nowrap">{{ $loanCollection->ClientRegister->name }}</td>
                                    <td class="text-nowrap">{{ $loanCollection->acc_no }}</td>
                                    <td class="text-nowrap">{{ $loanCollection->Volume->name }}</td>
                                    <td class="text-nowrap">{{ $loanCollection->Center->name }}</td>
                                    <td class="text-nowrap">{{ $loanCollection->Type->name }}</td>
                                    <td class="text-nowrap">{!! $loanCollection->expression !!}</td>
                                    <td class="text-nowrap">৳{{ $loanCollection->deposit }}/-</td>
                                    <td class="text-nowrap">৳{{ $loanCollection->loan }}/-</td>
                                    <td class="text-nowrap">৳{{ $loanCollection->interest }}/-</td>
                                    <td class="text-nowrap">৳{{ $loanCollection->total }}/-</td>
                                    <td class="text-nowrap">{{ $loanCollection->User->name }}</td>
                                    <td class="text-nowrap">{{ date('h:i:s A', strtotime($loanCollection->created_at)) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="13" class="text-center">No Records Found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Loan Collection Report -->
        </div>
    </div>
    <div class="g-col-12 g-col-xxl-3">
        <div class="border-start-xxl border-theme-5 dark-border-dark-3 mb-n10 pb-10">
            <div class="ps-xxl-6 grid grid-cols-12 gap-6">
                <!-- BEGIN: Transactions -->
                <div class="g-col-12 g-col-md-6 g-col-xl-4 g-col-xxl-12 mt-3 mt-xxl-8">
                    <div class="intro-x d-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Today Officer's Total Collection
                        </h2>
                    </div>
                    <div class="mt-5">
                        @foreach ($officers as $officer)
                            @if (isset($officer->SavingsCollection[0]->deposit))
                                @php
                                    $deposit = $officer->SavingsCollection[0]->deposit;
                                @endphp
                            @else
                                @php
                                    $deposit = 0;
                                @endphp
                            @endif
                            @if (isset($officer->LoanCollection[0]->total))
                                @php
                                    $total = $officer->LoanCollection[0]->total;
                                @endphp
                            @else
                                @php
                                    $total = 0;
                                @endphp
                            @endif
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 d-flex align-items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-circle overflow-hidden">
                                        <img alt="Officer"
                                            src="{{ isset($officer->image) ? asset('storage/user/' . $officer->image) : asset('storage/placeholder/profile.png') }}">
                                    </div>
                                    <div class="ms-4 me-auto">
                                        <div class="fw-medium">{{ $officer->name }}</div>
                                        {{-- <div class="text-gray-600 fs-xs mt-0.5">16 July 2021</div> --}}
                                    </div>
                                    <div>৳{{ $deposit + $total }}/-</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- END: Transactions -->
                <!-- BEGIN: Recent Savings Withdrawals -->
                <div class="g-col-12 g-col-md-6 g-col-xl-4 g-col-xxl-12 mt-3">
                    <div class="intro-x d-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Today Savings Withdrawal
                        </h2>
                    </div>
                    <div class="report-timeline mt-5 position-relative">
                        @forelse ($savingsWithdrawals as $savingsWithdrawal)
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 d-flex align-items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-circle overflow-hidden">
                                        <img alt="Officer"
                                            src="{{ asset('storage/register/' . $savingsWithdrawal->ClientRegister->client_image) }}">
                                    </div>
                                    <div class="ms-4 me-auto">
                                        <div class="fw-medium">{{ $savingsWithdrawal->ClientRegister->name }}</div>
                                        <div class="text-gray-600 fs-xs mt-0.5">{{ $savingsWithdrawal->acc_no }}</div>
                                    </div>
                                    <div>৳{{ $savingsWithdrawal->withdraw }}/-</div>
                                </div>
                            </div>
                        @empty
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 d-flex align-items-center justify-content-center zoom-in">
                                    No Records Found!
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- END: Recent Savings Withdrawals -->
                <!-- BEGIN: Recent Loan Savings Withdrawals -->
                <div class="g-col-12 g-col-md-6 g-col-xl-4 g-col-xxl-12 mt-3">
                    <div class="intro-x d-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            Today Loan Savings Withdrawal
                        </h2>
                    </div>
                    <div class="report-timeline mt-5 position-relative">
                        @forelse ($loanSavingsWithdrawals as $loanSavingsWithdrawal)
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 d-flex align-items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-circle overflow-hidden">
                                        <img alt="Officer"
                                            src="{{ asset('storage/register/' . $loanSavingsWithdrawal->ClientRegister->client_image) }}">
                                    </div>
                                    <div class="ms-4 me-auto">
                                        <div class="fw-medium">{{ $loanSavingsWithdrawal->ClientRegister->name }}</div>
                                        <div class="text-gray-600 fs-xs mt-0.5">{{ $loanSavingsWithdrawal->acc_no }}</div>
                                    </div>
                                    <div>৳{{ $loanSavingsWithdrawal->withdraw }}/-</div>
                                </div>
                            </div>
                        @empty
                            <div class="intro-x">
                                <div class="box px-5 py-3 mb-3 d-flex align-items-center justify-content-center zoom-in">
                                    No Records Found!
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <!-- END: Recent Loan Savings Withdrawals -->
            </div>
        </div>
    </div>
@endsection
