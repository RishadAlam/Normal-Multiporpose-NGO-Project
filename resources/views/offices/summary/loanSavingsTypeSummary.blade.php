@extends('layouts.main')

@push('title')
    {{ request()->name }} Current Month Summary
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ request()->name }} Current Month Summary</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <!-- Total Accounts -->
        <div>
            <h2 class="fs-lg fw-medium me-auto">{{ request()->name }} Client Accounts</h2>
        </div>
        <div class="grid columns-12 gap-6 my-5">
            <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                <div class="report-box zoom-in">
                    <a
                        href="{{ Route('loanSavingsTypeSummary.activeloanAccounts', ['name' => request()->name, 'id' => request()->id]) }}">
                        <div class="box p-5 d-flex align-items-center justify-content-between">
                            <div>
                                <i data-feather="user-check" class="report-box__icon text-success"></i>
                            </div>
                            <div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">{{ $activeLoans }}</div>
                                <div class="fs-base text-gray-600 mt-1">Active Loans</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                <div class="report-box zoom-in">
                    <a
                        href="{{ Route('loanSavingsTypeSummary.deactiveloanAccounts', ['name' => request()->name, 'id' => request()->id]) }}">
                        <div class="box p-5 d-flex align-items-center justify-content-between">
                            <div>
                                <i data-feather="user-x" class="report-box__icon text-danger"></i>
                            </div>
                            <div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">{{ $deactiveLoans }}</div>
                                <div class="fs-base text-gray-600 mt-1">Deactive Loans</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- Total Accounts -->

        <div class="row my-5">
            <div class="col-md-8">
                {{-- <div>
                    <h2 class="fs-lg fw-medium me-auto">{{ $name->name }} Client Accounts</h2>
                </div> --}}
                <div class="intro-y box mt-5">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Current Month Loan Collection ৳{{ $loanCollectionsSum }}/-
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="loanCollectionChart" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <div class="intro-y box mt-5">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Current Month Loan Savings Collection ৳{{ $loanSavingsCollectionsSum }}/-
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="loanSavingsCollectionChart" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <div class="intro-y box mt-5">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Current Month Loan Savings withdraw ৳{{ $loanSavingsWithdrawalsSum }}/-
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="loanSavingsWithdrawalChart" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="intro-y box mt-5">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Current Month Loans Admitted {{ $loansAdmittedSum }}
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="loansAdmittedChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="intro-y box mt-5">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Current Month Loans Deactivated {{ $loansDeactivetedSum }}
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="loansDeactivatedChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script>
        // Loan Collection Chart
        var data_table = {!! $loanCollections !!}
        var loanCollectionChart = document.getElementById('loanCollectionChart').getContext('2d');


        loanCollectionChart_config = new Chart(loanCollectionChart, {
            type: 'bar',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'Loan Collection',
                    backgroundColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    color: '#fff',
                    data: data_table.map(row => row.loan)
                }]
            }
        });

        // Loan Savings Collection Chart
        var data_table = {!! $loanSavingsCollections !!}
        var loanSavingsCollectionChart = document.getElementById('loanSavingsCollectionChart').getContext('2d');


        loanSavingsCollectionChart_config = new Chart(loanSavingsCollectionChart, {
            type: 'bar',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'Loan Savings Collection',
                    backgroundColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    color: '#fff',
                    data: data_table.map(row => row.deposit)
                }]
            }
        });

        // Loan Savings Withdrawal Chart
        var data_table = {!! $loanSavingsWithdrawals !!}
        var loanSavingsWithdrawalChart = document.getElementById('loanSavingsWithdrawalChart').getContext('2d');


        loanSavingsWithdrawalChart_config = new Chart(loanSavingsWithdrawalChart, {
            type: 'bar',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'Loan Savings Withdrawal',
                    backgroundColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    color: '#fff',
                    data: data_table.map(row => row.withdraw)
                }]
            }
        });

        // Loans Admiteed Chart
        var data_table = {!! $loansAdmitted !!}
        var loansAdmittedChart = document.getElementById('loansAdmittedChart').getContext('2d');


        loansAdmittedChart_config = new Chart(loansAdmittedChart, {
            type: 'line',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'loans Admitted',
                    backgroundColor: [
                        'rgba(255, 159, 64, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    color: '#fff',
                    data: data_table.map(row => row.total)
                }]
            }
        });

        // Loans Admiteed Chart
        var data_table = {!! $loansDeactiveted !!}
        var loansDeactivatedChart = document.getElementById('loansDeactivatedChart').getContext('2d');


        loansDeactivatedChart_config = new Chart(loansDeactivatedChart, {
            type: 'line',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'loans Deactivated',
                    backgroundColor: [
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    color: '#fff',
                    data: data_table.map(row => row.total)
                }]
            }
        });
    </script>
@endsection
