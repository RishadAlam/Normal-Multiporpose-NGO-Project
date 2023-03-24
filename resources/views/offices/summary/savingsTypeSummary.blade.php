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
                        href="{{ Route('savingsTypeSummary.activeSavingsAccounts', ['name' => request()->name, 'id' => request()->id]) }}">
                        <div class="box p-5 d-flex align-items-center justify-content-between">
                            <div>
                                <i data-feather="user-check" class="report-box__icon text-success"></i>
                            </div>
                            <div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">{{ $activeSavings }}</div>
                                <div class="fs-base text-gray-600 mt-1">Active Savings</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                <div class="report-box zoom-in">
                    <a
                        href="{{ Route('savingsTypeSummary.deactiveSavingsAccounts', ['name' => request()->name, 'id' => request()->id]) }}">
                        <div class="box p-5 d-flex align-items-center justify-content-between">
                            <div>
                                <i data-feather="user-x" class="report-box__icon text-danger"></i>
                            </div>
                            <div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">{{ $deactiveSavings }}</div>
                                <div class="fs-base text-gray-600 mt-1">Deactive Savings</div>
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
                            Current Month Savings Collection ৳{{ $savingCollectionsSum }}/-
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="savingsCollectionChart" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
                <div class="intro-y box mt-5">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Current Month Savings withdraw ৳{{ $savingWithdrawalsSum }}/-
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="savingsWithdrawalChart" class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="intro-y box mt-5">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Current Month Savings Admitted {{ $savingsAdmittedSum }}
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="savingsAdmittedChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="intro-y box mt-5">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center p-5 border-bottom border-gray-200 dark-border-dark-5">
                        <h2 class="fw-medium fs-base me-auto">
                            Current Month Savings Deactivated {{ $savingsDeactivetedSum }}
                        </h2>
                    </div>
                    <div id="vertical-bar-chart" class="p-5">
                        <div class="preview" style="display: block; opacity: 1;">
                            <canvas id="savingsDeactivatedChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJS')
    <script>
        // var data_table = [{
        //         year: 2010,
        //         count: 10
        //     },
        //     {
        //         year: 2011,
        //         count: 20
        //     },
        //     {
        //         year: 2012,
        //         count: 15
        //     },
        //     {
        //         year: 2013,
        //         count: 25
        //     },
        //     {
        //         year: 2014,
        //         count: 22
        //     },
        //     {
        //         year: 2015,
        //         count: 30
        //     },
        //     {
        //         year: 2016,
        //         count: 28
        //     },
        // ];
        // Savings Collection Chart
        var data_table = {!! $savingCollections !!}
        var savingsCollectionChart = document.getElementById('savingsCollectionChart').getContext('2d');


        saving_collection_chart_config = new Chart(savingsCollectionChart, {
            type: 'bar',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'Savings Collection',
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

        // Savings Withdrawal Chart
        var data_table = {!! $savingWithdrawals !!}
        var savingsWithdrawalChart = document.getElementById('savingsWithdrawalChart').getContext('2d');


        savingsWithdrawalChart_config = new Chart(savingsWithdrawalChart, {
            type: 'bar',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'Savings Withdrawal',
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

        // Savings Admitted Chart
        var data_table = {!! $savingsAdmitted !!}
        var savingsAdmittedChart = document.getElementById('savingsAdmittedChart').getContext('2d');


        savingsAdmittedChart_config = new Chart(savingsAdmittedChart, {
            type: 'line',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'Savings Admitted',
                    backgroundColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(201, 203, 207, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    color: '#fff',
                    data: data_table.map(row => row.total)
                }]
            }
        });

        // Savings Deactivated Chart
        var data_table = {!! $savingsDeactiveted !!}
        var savingsDeactivatedChart = document.getElementById('savingsDeactivatedChart').getContext('2d');


        savingsDeactivatedChart_config = new Chart(savingsDeactivatedChart, {
            type: 'line',
            data: {
                labels: data_table.map(row => row.date),
                datasets: [{
                    label: 'Savings Deactivated',
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(201, 203, 207, 1)',
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
