@extends('layouts.main')

@push('title')
    Analytics
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> Analytics</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <!-- Total Accounts -->
        <div>
            <h2 class="fs-lg fw-medium me-auto">Analytics</h2>
        </div>
        <!-- Total Accounts -->
        <div class="row">
            <div class="col-md-12">
                <div class="intro-y box mt-5">
                    <div class="p-5 pb-0">
                        <h2 class="fs-lg fw-medium me-auto">Filter</h2>
                    </div>
                    <div class="mt-6 mt-lg-0 px-5">
                        <form action="" method="get" id="dateRangeForm">
                            <input type="text" name="startDate" id="startDate" class="d-none"
                                value="{{ request()->startDate }}">
                            <input type="text" name="endDate" id="endDate" class="d-none"
                                value="{{ request()->endDate }}">
                            <div
                                class="d-flex flex-column flex-lg-row border-bottom border-gray-200 dark-border-dark-5 pb-5 mx-n5">
                                <div
                                    class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                                    <div class="d-inline-block input-form">
                                        <label for="volume" class="form-label">Date Range <span
                                                class="text-danger">*</span></label>
                                        <div id="daterange" class="d-inline-block box mt-3"
                                            style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                            <i data-feather="calendar"></i>&nbsp;
                                            <span id="dateRangeval"></span> <i class='bx bx-caret-down'></i></i>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                                    <div class="d-inline-block input-form">
                                        <label for="volume" class="form-label">Volume <span
                                                class="text-danger">*</span></label>
                                        <select id="volume" name="volume" data-placeholder="Select your favorite actors"
                                            class="select w-full">
                                            <option selected value="0">All Volume...</option>
                                            @foreach ($volumes as $volume)
                                                <option value="{{ $volume->id }}"
                                                    {{ request()->volume == $volume->id ? 'selected' : '' }}>
                                                    {{ $volume->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                                    <div class="d-inline-block input-form">
                                        <label for="center" class="form-label">Center <span
                                                class="text-danger">*</span></label>
                                        <select id="center" name="center" data-placeholder="Select your favorite actors"
                                            class="select w-full">
                                            <option selected value="0">all Center...</option>
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                                    <div class="d-inline-block input-form">
                                        <label for="savingType" class="form-label">Saving Type <span
                                                class="text-danger">*</span></label>
                                        <select id="savingType" name="savingType"
                                            data-placeholder="Select your favorite actors" class="select w-full">
                                            <option selected value="0">All Saving Type...</option>
                                            @foreach ($savingsTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ request()->savingType == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                                    <div class="d-inline-block input-form">
                                        <label for="loanType" class="form-label">Loan Type <span
                                                class="text-danger">*</span></label>
                                        <select id="loanType" name="loanType"
                                            data-placeholder="Select your favorite actors" class="select w-full">
                                            <option selected value="0">All Loan Type...</option>
                                            @foreach ($loanTypes as $type)
                                                <option
                                                    value="{{ $type->id }}"{{ request()->loanType == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                                    <div class="d-inline-block input-form">
                                        <label for="officers" class="form-label">Withdrawal Officer <span
                                                class="text-danger">*</span></label>
                                        <select id="officers" name="officers"
                                            data-placeholder="Select your favorite actors" class="select w-full">
                                            @if (auth()->user()->can('Analytics View as an Admin'))
                                                <option selected value="0">All Officer...</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ request()->officers == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="{{ auth()->user()->id }}" selected>
                                                    {{ auth()->user()->name }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div
                                    class="d-flex flex-1 px-5 align-items-center justify-content-center justify-content-lg-start">
                                    <div class="d-inline-block input-form">
                                        <button id="form_submit" type="submit"
                                            class="form-control btn btn-primary mt-5">{{ __('GET') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="intro-y box mt-5">
                    <div class="mt-6 mt-lg-0 px-5">
                        <ul class="nav nav-link-tabs flex-column flex-sm-row justify-content-center justify-content-lg-start"
                            role="tablist">
                            <li id="savings-collection-tab" class="nav-item" role="presentation">
                                <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center active"
                                    data-bs-toggle="pill" data-bs-target="#savings-collection" role="tab"
                                    aria-controls="savings-collection-tab" aria-selected="true"> <i class="w-4 h-4 me-2"
                                        data-feather="dollar-sign"></i> Savings Collection </a>
                            </li>
                            <li id="loan-collection-tab" class="nav-item" role="presentation">
                                <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center"
                                    data-bs-toggle="pill" data-bs-target="#loan-collection" role="tab"
                                    aria-controls="loan-collection-tab" aria-selected="false"> <i class="w-4 h-4 me-2"
                                        data-feather="bar-chart"></i> Loan Cllection
                                </a>
                            </li>
                            <li id="savings-admitted-tab" class="nav-item" role="presentation">
                                <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center"
                                    data-bs-toggle="pill" data-bs-target="#savings-admitted" role="tab"
                                    aria-controls="savings-admitted-tab" aria-selected="false"> <i class="w-4 h-4 me-2"
                                        data-feather="bar-chart-2"></i> Savings
                                    Admitted/Closing
                                </a>
                            </li>
                            <li id="loan-admitted-tab" class="nav-item" role="presentation">
                                <a href="javascript:;" class="nav-link px-0 me-sm-8 d-flex align-items-center"
                                    data-bs-toggle="pill" data-bs-target="#loan-admitted" role="tab"
                                    aria-controls="loan-admitted-tab" aria-selected="false"> <i class="w-4 h-4 me-2"
                                        data-feather="globe"></i> Loan Admitted/Closing
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="intro-y tab-content mt-5">
                    <div class="tab-pane fade show active" id="savings-collection" role="tabpanel"
                        aria-labelledby="savings-collection-tab">
                        <div class="grid columns-12 gap-6">
                            <!-- BEGIN: Saving Collection Table -->
                            <div class="intro-y box g-col-12">
                                <div class="card rounded rounded-3 border-0 card-body-dark"
                                    style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                                    <div class="card-header py-5">
                                        <b class="text-uppercase" style="font-size: 18px;">Savings Collection</b>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="intro-y box mt-5">
                                            <div class="shadow text-center py-10">
                                                <h2 class="font-bold" style="font-size: 22px">Total Saving Colections
                                                    ৳{{ $totalSavings }}/-</h2>
                                                <h2 class="font-bold" style="font-size: 22px">Total Saving Withdrawals
                                                    ৳{{ $totalWithdrawals }}/-</h2>
                                            </div>
                                            <div id="vertical-bar-chart" class="p-5">
                                                <div class="preview" style="display: block; opacity: 1;">
                                                    <canvas id="savingsCollectionChart"
                                                        class="chartjs-render-monitor"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="intro-y overflow-x-auto">
                                            <table class="table table-hover table-striped table-report">
                                                <thead class="bg-theme-1 text-white border-b-0">
                                                    <tr>
                                                        <th style="width: 2%;"
                                                            class="border-bottom-0 text-nowrap text-start">
                                                            #</th>
                                                        <th class="border-bottom-0 text-nowrap">Client name</th>
                                                        <th class="border-bottom-0 text-nowrap">Account No</th>
                                                        <th class="border-bottom-0 text-nowrap">Volume</th>
                                                        <th class="border-bottom-0 text-nowrap">Center</th>
                                                        <th class="border-bottom-0 text-nowrap">Type</th>
                                                        <th class="border-bottom-0 text-nowrap">Description</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Deposit</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Withdrawal</th>
                                                        <th class="border-bottom-0 text-nowrap">Officer</th>
                                                        <th class="border-bottom-0 text-nowrap">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($collectionsList as $key => $savingsCollection)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td class="text-nowrap">
                                                                {{ $savingsCollection->ClientRegister->name }}
                                                            </td>
                                                            <td class="text-nowrap">{{ $savingsCollection->acc_no }}</td>
                                                            <td class="text-nowrap">{{ $savingsCollection->Volume->name }}
                                                            </td>
                                                            <td class="text-nowrap">{{ $savingsCollection->Center->name }}
                                                            </td>
                                                            <td class="text-nowrap">{{ $savingsCollection->Type->name }}
                                                            </td>
                                                            <td>{!! $savingsCollection->expression !!}</td>
                                                            <td class="text-end">৳{{ $savingsCollection->deposit }}/-</td>
                                                            <td class="text-end">৳{{ $savingsCollection->withdraw }}/-
                                                            </td>
                                                            <td class="text-nowrap">{{ $savingsCollection->User->name }}
                                                            </td>
                                                            <td class="text-nowrap">
                                                                {{ date('d-m-Y h:i:s A', strtotime($savingsCollection->created_at)) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="11" class="text-center">No records found!</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{ $collectionsList->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Saving Collection Table -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="loan-collection" role="tabpanel"
                        aria-labelledby="loan-collection-tab">
                        <div class="grid columns-12 gap-6">
                            <!-- BEGIN: Loan Collection Table -->
                            <div class="intro-y box g-col-12">
                                <div class="card rounded rounded-3 border-0 card-body-dark"
                                    style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                                    <div class="card-header py-5">
                                        <b class="text-uppercase" style="font-size: 18px;">Loan Collection</b>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="intro-y box mt-5">
                                            <div class="shadow text-center py-10">
                                                <h2 class="font-bold" style="font-size: 22px">Total Loan Colections
                                                    <span>৳{{ $totalLoan }}/-</span>, Total Interest Colections
                                                    <span>৳{{ $totalInterest }}/-</span>
                                                </h2>
                                                <h2 class="font-bold" style="font-size: 22px">Total Loan Saving
                                                    Collections
                                                    <span>৳{{ $totalLoanDeposit }}/-</span>, Total Loan Saving Withdrawals
                                                    <span>৳{{ $totalLoanSavingWithdrawals }}/-</span>
                                                </h2>
                                            </div>
                                            <div id="vertical-bar-chart" class="p-5">
                                                <div class="preview" style="display: block; opacity: 1;">
                                                    <canvas id="loanCollectionChart"
                                                        class="chartjs-render-monitor"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="intro-y overflow-x-auto">
                                            <table class="table table-hover table-striped table-report">
                                                <thead class="bg-theme-1 text-white border-b-0">
                                                    <tr>
                                                        <th style="width: 2%;"
                                                            class="border-bottom-0 text-nowrap text-start">
                                                            #</th>
                                                        <th class="border-bottom-0 text-nowrap">Client name</th>
                                                        <th class="border-bottom-0 text-nowrap">Account No</th>
                                                        <th class="border-bottom-0 text-nowrap">Volume</th>
                                                        <th class="border-bottom-0 text-nowrap">Center</th>
                                                        <th class="border-bottom-0 text-nowrap">Type</th>
                                                        <th class="border-bottom-0 text-nowrap">Description</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Deposit</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Loan</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Interest</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Total</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Withdrawal</th>
                                                        <th class="border-bottom-0 text-nowrap">Officer</th>
                                                        <th class="border-bottom-0 text-nowrap">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($loanCollectionsList as $key => $loanCollection)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td class="text-nowrap">
                                                                {{ $loanCollection->ClientRegister->name }}
                                                            </td>
                                                            <td class="text-nowrap">{{ $loanCollection->acc_no }}</td>
                                                            <td class="text-nowrap">{{ $loanCollection->Volume->name }}
                                                            </td>
                                                            <td class="text-nowrap">{{ $loanCollection->Center->name }}
                                                            </td>
                                                            <td class="text-nowrap">{{ $loanCollection->Type->name }}</td>
                                                            <td>{!! $loanCollection->expression !!}</td>
                                                            <td class="text-end">৳{{ $loanCollection->deposit }}/-</td>
                                                            <td class="text-end">৳{{ $loanCollection->loan }}/-</td>
                                                            <td class="text-end">৳{{ $loanCollection->interest }}/-</td>
                                                            <td class="text-end">৳{{ $loanCollection->total }}/-</td>
                                                            <td class="text-end">৳{{ $loanCollection->withdraw }}/-</td>
                                                            <td class="text-nowrap">{{ $loanCollection->User->name }}</td>
                                                            <td class="text-nowrap">
                                                                {{ date('d-m-Y h:i:s A', strtotime($loanCollection->created_at)) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="14" class="text-center">No records found!</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{ $loanCollectionsList->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Loan Collection Table -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="savings-admitted" role="tabpanel"
                        aria-labelledby="savings-admitted-tab">
                        <div class="grid columns-12 gap-6">
                            <!-- BEGIN: Saving Addmitted Table -->
                            <div class="intro-y box g-col-12">
                                <div class="card rounded rounded-3 border-0 card-body-dark"
                                    style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                                    <div class="card-header py-5">
                                        <b class="text-uppercase" style="font-size: 18px;">Savings Admitted/Closing</b>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="intro-y box mt-5">
                                            <div class="shadow text-center py-10">
                                                <h2 class="font-bold" style="font-size: 22px">Total Saving Account
                                                    Admitted
                                                    ৳{{ $totalSavingsAdmitted }}/-</h2>
                                                <h2 class="font-bold" style="font-size: 22px">Total Saving Account Closed
                                                    ৳{{ $totalSavingsClossed }}/-</h2>
                                            </div>
                                            <div id="vertical-bar-chart" class="p-5">
                                                <div class="preview" style="display: block; opacity: 1;">
                                                    <canvas id="savingsUnionChart"
                                                        class="chartjs-render-monitor"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="intro-y overflow-x-auto">
                                            <table class="table table-hover table-striped table-report">
                                                <thead class="bg-theme-1 text-white border-b-0">
                                                    <tr>
                                                        <th style="width: 2%;"
                                                            class="border-bottom-0 text-nowrap text-start">
                                                            #</th>
                                                        <th class="border-bottom-0 text-nowrap">Client name</th>
                                                        <th class="border-bottom-0 text-nowrap">Account No</th>
                                                        <th class="border-bottom-0 text-nowrap">Volume</th>
                                                        <th class="border-bottom-0 text-nowrap">Center</th>
                                                        <th class="border-bottom-0 text-nowrap">Type</th>
                                                        <th class="border-bottom-0 text-nowrap">Status</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Deposit</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Interest</th>
                                                        <th class="border-bottom-0 text-nowrap">Officer</th>
                                                        <th class="border-bottom-0 text-nowrap">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($SavingsUnionList as $key => $savingsUnion)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td class="text-nowrap">
                                                                {{ $savingsUnion->ClientRegister->name }}
                                                            </td>
                                                            <td class="text-nowrap">{{ $savingsUnion->acc_no }}</td>
                                                            <td class="text-nowrap">{{ $savingsUnion->Volume->name }}</td>
                                                            <td class="text-nowrap">{{ $savingsUnion->Center->name }}</td>
                                                            <td class="text-nowrap">{{ $savingsUnion->Type->name }}</td>
                                                            <td>{{ $savingsUnion->status }}</td>
                                                            <td class="text-end">৳{{ $savingsUnion->deposit }}/-</td>
                                                            <td class="text-end">{{ $savingsUnion->interest }}%</td>
                                                            <td class="text-nowrap">{{ $savingsUnion->User->name }}</td>
                                                            <td class="text-nowrap">
                                                                {{ date('d-m-Y h:i:s A', strtotime($savingsUnion->date)) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="11" class="text-center">No records found!</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{ $SavingsUnionList->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Saving Addmitted Table -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="loan-admitted" role="tabpanel" aria-labelledby="loan-admitted-tab">
                        <div class="grid columns-12 gap-6">
                            <!-- BEGIN: Loans Admitted Table -->
                            <div class="intro-y box g-col-12">
                                <div class="card rounded rounded-3 border-0 card-body-dark"
                                    style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
                                    <div class="card-header py-5">
                                        <b class="text-uppercase" style="font-size: 18px;">Loans Admitted/Closing</b>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="intro-y box mt-5">
                                            <div class="shadow text-center py-10">
                                                <h2 class="font-bold" style="font-size: 22px">Total Loan Account Admitted
                                                    ৳{{ $totalLoanAdmitted }}/-</h2>
                                                <h2 class="font-bold" style="font-size: 22px">Total Loan Account Closed
                                                    ৳{{ $totalLoanclossed }}/-</h2>
                                            </div>
                                            <div id="vertical-bar-chart" class="p-5">
                                                <div class="preview" style="display: block; opacity: 1;">
                                                    <canvas id="loansUnionChart" class="chartjs-render-monitor"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="intro-y overflow-x-auto">
                                            <table class="table table-hover table-striped table-report">
                                                <thead class="bg-theme-1 text-white border-b-0">
                                                    <tr>
                                                        <th style="width: 2%;"
                                                            class="border-bottom-0 text-nowrap text-start">
                                                            #</th>
                                                        <th class="border-bottom-0 text-nowrap">Client name</th>
                                                        <th class="border-bottom-0 text-nowrap">Account No</th>
                                                        <th class="border-bottom-0 text-nowrap">Volume</th>
                                                        <th class="border-bottom-0 text-nowrap">Center</th>
                                                        <th class="border-bottom-0 text-nowrap">Type</th>
                                                        <th class="border-bottom-0 text-nowrap">Status</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Loan Given</th>
                                                        <th class="border-bottom-0 text-nowrap text-end">Interest</th>
                                                        <th class="border-bottom-0 text-nowrap">Officer</th>
                                                        <th class="border-bottom-0 text-nowrap">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse ($loanUnionList as $key => $loanUnion)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td class="text-nowrap">{{ $loanUnion->ClientRegister->name }}
                                                            </td>
                                                            <td class="text-nowrap">{{ $loanUnion->acc_no }}</td>
                                                            <td class="text-nowrap">{{ $loanUnion->Volume->name }}</td>
                                                            <td class="text-nowrap">{{ $loanUnion->Center->name }}</td>
                                                            <td class="text-nowrap">{{ $loanUnion->Type->name }}</td>
                                                            <td>{{ $loanUnion->status }}</td>
                                                            <td class="text-end">৳{{ $loanUnion->loan_given }}/-</td>
                                                            <td class="text-end">{{ $loanUnion->interest }}%</td>
                                                            <td class="text-nowrap">{{ $loanUnion->User->name }}</td>
                                                            <td class="text-nowrap">
                                                                {{ date('d-m-Y h:i:s A', strtotime($loanUnion->date)) }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="11" class="text-center">No records found!</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{ $loanUnionList->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END: Loans Admitted Table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script>
        // Get Centers by ajax
        $("#volume").on('change', function() {
            centerLoad()
        })
        centerLoad()

        function centerLoad() {
            var vol = $("#volume").val()
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
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [day, month, year].join('-');
        }

        // Savings Collection Chart
        var data_table = {!! $collectionsChart !!}
        var savingsCollectionChart = document.getElementById('savingsCollectionChart').getContext('2d');


        saving_collection_chart_config = new Chart(savingsCollectionChart, {
            type: 'line',
            data: {
                labels: data_table.map(row => formatDate(row.date)),
                datasets: [{
                    label: 'Savings Collection',
                    backgroundColor: [
                        '#48C9B0'
                    ],
                    borderColor: '#48C9B0',
                    color: '#fff',
                    data: data_table.map(row => row.deposit)
                }, {
                    label: 'withdrawal',
                    backgroundColor: [
                        '#E74C3C'
                    ],
                    borderColor: '#E74C3C',
                    color: '#fff',
                    data: data_table.map(row => row.withdraw)
                }]
            }
        });

        // Loan Collection Chart
        var data_table = {!! $loanCollectionsChart !!}
        var loanCollectionChart = document.getElementById('loanCollectionChart').getContext('2d');


        loanCollectionChart_config = new Chart(loanCollectionChart, {
            type: 'line',
            data: {
                labels: data_table.map(row => formatDate(row.date)),
                datasets: [{
                    label: 'Loan Saving Collections',
                    backgroundColor: [
                        '#21618C'
                    ],
                    borderColor: '#21618C',
                    color: '#fff',
                    data: data_table.map(row => row.deposit)
                }, {
                    label: 'Loan Collections',
                    backgroundColor: [
                        '#5DADE2'
                    ],
                    borderColor: '#5DADE2',
                    color: '#fff',
                    data: data_table.map(row => row.loan)
                }, {
                    label: 'Interest Collections',
                    backgroundColor: [
                        '#C39BD3'
                    ],
                    borderColor: '#C39BD3',
                    color: '#fff',
                    data: data_table.map(row => row.interest)
                }, {
                    label: 'Loan Saving Withdrawals',
                    backgroundColor: [
                        '#E74C3C'
                    ],
                    borderColor: '#E74C3C',
                    color: '#fff',
                    data: data_table.map(row => row.withdraw)
                }]
            }
        });

        // Savings Admitted /Closing Chart
        var data_table = {!! $SavingsUnionChart !!}
        var savingsUnionChart = document.getElementById('savingsUnionChart').getContext('2d');


        saving_collection_chart_config = new Chart(savingsUnionChart, {
            type: 'line',
            data: {
                labels: data_table.map(row => formatDate(row.date)),
                datasets: [{
                    label: 'Savings Admitted',
                    backgroundColor: [
                        '#48C9B0'
                    ],
                    borderColor: '#48C9B0',
                    color: '#fff',
                    data: data_table.map(row => row.Admitted)
                }, {
                    label: 'Savings Closed',
                    backgroundColor: [
                        '#E74C3C'
                    ],
                    borderColor: '#E74C3C',
                    color: '#fff',
                    data: data_table.map(row => row.Closed)
                }]
            }
        });
        // Savings Admitted /Closing Chart
        var data_table = {!! $loanUnionChart !!}
        var loanUnionChart = document.getElementById('loansUnionChart').getContext('2d');


        saving_collection_chart_config = new Chart(loansUnionChart, {
            type: 'line',
            data: {
                labels: data_table.map(row => formatDate(row.date)),
                datasets: [{
                    label: 'Loan Admitted',
                    backgroundColor: [
                        '#48C9B0'
                    ],
                    borderColor: '#48C9B0',
                    color: '#fff',
                    data: data_table.map(row => row.Admitted)
                }, {
                    label: 'Loan Closed',
                    backgroundColor: [
                        '#E74C3C'
                    ],
                    borderColor: '#E74C3C',
                    color: '#fff',
                    data: data_table.map(row => row.Closed)
                }]
            }
        });

        $(window).on('load', function() {
            cb()

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

            $('#dateRangeval').on("DOMSubtreeModified", function() {
                let range = $(this).text()
                if (range != '') {
                    let dateRange = range.split("->");
                    $("#startDate").val(dateRange[0]);
                    $("#endDate").val(dateRange[1]);
                }
            })
        })
    </script>
@endsection
