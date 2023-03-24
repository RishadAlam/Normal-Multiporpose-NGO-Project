@extends('layouts.main')

@push('title')
    {{ $type->name }} Collection Volume Report
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Collection Reports') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a href="{{ Route('collectionsReport.pendingCollection') }}">{{ __('Pending Collection Report') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Loans') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ $type->name }} Collection Volume Report</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <h2 class="fs-lg fw-medium me-auto">{{ $type->name }} Collection Volume Report</h2>
        <p>Pending Collections</p>

        <!-- Pending Collection table -->
        <div class="card rounded rounded-3 my-5 pb-5 border-0 card-body-dark"
            style="background-color: rgba(var(--bs-theme-2-rgb),var(--bs-bg-opacity))">
            <div class="card-header py-5">
                <b class="text-uppercase" style="font-size: 18px;">{{ $type->name }} Collection Volume Report</b>
            </div>
            <div class="card-body p-0">
                <div class="intro-y overflow-x-auto">
                    <table class="table table-hover table-striped table-report">
                        <thead class="bg-theme-1 text-white border-b-0">
                            <tr>
                                <th style="width: 2%;" class="border-bottom-0 text-nowrap">#</th>
                                <th class="border-bottom-0 text-nowrap">Loan Type</th>
                                <th class="border-bottom-0 text-nowrap">Total Deposit</th>
                                <th class="border-bottom-0 text-nowrap">Total Loan</th>
                                <th class="border-bottom-0 text-nowrap">Total Interest</th>
                                <th class="border-bottom-0 text-nowrap">Sub Total</th>
                                <th class="border-bottom-0 text-nowrap">Reports</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $deposit = 0;
                                $loanss = 0;
                                $interest = 0;
                                $total = 0;
                            @endphp
                            @forelse ($loans as $key => $loan)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $loan->name }}</td>
                                    <td>৳{{ $loan->LoanCollection[0]->deposit ?? 0 }}/-</td>
                                    <td>৳{{ $loan->LoanCollection[0]->loan ?? 0 }}/-</td>
                                    <td>৳{{ $loan->LoanCollection[0]->interest ?? 0 }}/-</td>
                                    <td>৳{{ $loan->LoanCollection[0]->total ?? 0 }}/-</td>
                                    <td class="text-primary text-info cursor-pointer">
                                        <a
                                            href="{{ Route('collectionsReport.pendingCollection.loans.reports', ['type_id' => $type->id, 'volume_id' => $loan->id]) }}"><i
                                                data-feather="folder"></i></a>
                                    </td>
                                </tr>
                                @php
                                    $deposit += $loan->LoanCollection[0]->deposit ?? 0;
                                    $loanss += $loan->LoanCollection[0]->loan ?? 0;
                                    $interest += $loan->LoanCollection[0]->interest ?? 0;
                                    $total += $loan->LoanCollection[0]->total ?? 0;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No records found!</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="bg-theme-20 text-white text-end"><b>Total</b></td>
                                <td class="bg-theme-20 text-white"><b>৳{{ $deposit }}/-</b></td>
                                <td class="bg-theme-20 text-white"><b>৳{{ $loanss }}/-</b></td>
                                <td class="bg-theme-20 text-white"><b>৳{{ $interest }}/-</b></td>
                                <td colspan="2" class="bg-theme-20 text-white"><b>৳{{ $total }}/-</b></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <!-- Regular Collection table -->
    </div>
@endsection
