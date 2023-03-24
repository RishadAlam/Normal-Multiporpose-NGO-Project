@extends('layouts.print')

@push('title')
    {{ $volume->name . ' ' . $type->name }} Saving Collection Report print
@endpush

@section('mainContent')
    <div class="row mb-3">
        <div class="col-6">
            <b class="text-uppercase">{{ $volume->name . ' ' . $type->name }} Collection Report</b>
        </div>
        <div class="col-6 text-end">
            @if (isset($startDate) && isset($endDate))
                <b>PERIOD: {{ date('d-m-Y', strtotime($startDate)) . ' / ' . date('d-m-Y', strtotime($endDate)) }}</b>
            @else
                <b>DATE: {{ date('d-m-Y') }}</b>
            @endif
        </div>
    </div>
    <div class="row">
        @foreach ($loans as $loan)
            <table class="table" id="report">
                <tr>
                    <td class="border border-bottom-0"><b>{{ $loan->name }}</b></td>
                </tr>
                <tr>
                    <td class="p-0">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th style="width: 2%;" class="text-start">#</th>
                                    <th class="text-nowrap">Client Name</th>
                                    <th class="text-nowrap">Account</th>
                                    <th class="text-nowrap">Description</th>
                                    <th style="width: 2%;" class="text-nowrap text-end">Installment</th>
                                    <th class="text-nowrap text-end">Deposit</th>
                                    <th class="text-nowrap text-end">Loan</th>
                                    <th class="text-nowrap text-end">Interest</th>
                                    <th class="text-nowrap text-end">Total</th>
                                    <th class="text-nowrap">Officer</th>
                                    <th class="text-nowrap">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $deposit = 0;
                                    $loanss = 0;
                                    $interest = 0;
                                    $total = 0;
                                @endphp
                                @forelse ($loan->LoanProfile as $key => $LoanProfile)
                                    @forelse ($LoanProfile->LoanCollection as $LoanCollection)
                                        @php
                                            $deposit_installment = $LoanCollection->installment * $LoanProfile->deposit;
                                            $loan_installment = $LoanCollection->installment * $LoanProfile->loan_installment;
                                            $interest_installment = $LoanCollection->installment * $LoanProfile->interest_installment;
                                            $total_intallment = $deposit_installment + $loan_installment + $interest_installment;
                                        @endphp
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td class="text-nowrap">{{ $LoanProfile->ClientRegister->name }}</td>
                                            <td class="text-nowrap">{{ $LoanProfile->acc_no }}</td>
                                            <td class="text-justify">{!! $LoanCollection->expression !!}</td>
                                            <td class="text-nowrap text-end">{{ $LoanCollection->installment }}</td>
                                            <td class="text-nowrap text-end">৳{{ $LoanCollection->deposit }}/-</td>
                                            <td class="text-nowrap text-end">৳{{ $LoanCollection->loan }}/-</td>
                                            <td class="text-nowrap text-end">৳{{ $LoanCollection->interest }}/-</td>
                                            <td class="text-nowrap text-end">৳{{ $LoanCollection->total }}/-</td>
                                            <td>{{ $LoanCollection->user->name }}</td>
                                            <td class="text-nowrap">
                                                {{ date('d-m-Y h:i A', strtotime($LoanCollection->time)) }}
                                            </td>
                                        </tr>
                                        @php
                                            $deposit += $LoanCollection->deposit;
                                            $loanss += $LoanCollection->loan;
                                            $interest += $LoanCollection->interest;
                                            $total += $LoanCollection->total;
                                        @endphp
                                    @empty
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $LoanProfile->ClientRegister->name }}</td>
                                            <td>{{ $LoanProfile->acc_no }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforelse
                                @empty
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-end"><b>Total</b></td>
                                    <td class="text-end"><b>{{ $deposit != 0 ? '৳' . $deposit . '/-' : '' }}</b></td>
                                    <td class="text-end"><b>{{ $loanss != 0 ? '৳' . $loanss . '/-' : '' }}</b></td>
                                    <td class="text-end"><b>{{ $interest != 0 ? '৳' . $interest . '/-' : '' }}</b></td>
                                    <td colspan="3" class="text-start">
                                        <b>{{ $total != 0 ? '৳' . $total . '/-' : '' }}</b>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </table>
        @endforeach
    </div>
@endsection
