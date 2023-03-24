@extends('layouts.print')

@push('title')
    {{ $type->name }} Saving Accounts print
@endpush

@section('mainContent')
    <div class="row mb-3">
        <div class="col-6">
            <b class="text-uppercase">{{ $type->name }} Loan Accounts</b>
        </div>
        <div class="col-6 text-end">
            <b>PRINT DATE: {{ date('d-m-Y') }}</b>
        </div>
    </div>
    <div class="row">
        <table class="table table-bordered m-0">
            <thead>
                <tr>
                    <th style="width: 2%;" class="text-start">#</th>
                    <th class="text-nowrap">Client Name</th>
                    <th class="text-nowrap">Account No</th>
                    <th class="text-nowrap text-end">Balance</th>
                    <th class="text-nowrap text-end">Loan Given</th>
                    <th class="text-nowrap text-end">Loan Recovered</th>
                    <th class="text-nowrap text-end">Loan Remaining</th>
                    <th class="text-nowrap text-end">Interest Recovered</th>
                    <th class="text-nowrap text-end">Interest Remaining</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $balance = 0;
                    $totalLoan = 0;
                    $loanRec = 0;
                    $loanRem = 0;
                    $interestRec = 0;
                    $interestRem = 0;
                @endphp
                @foreach ($activeLoanList as $key => $loanProfile)
                    <tr>
                        <td class="text-nowrap">{{ ++$key }}</td>
                        <td class="text-nowrap">
                            {{ $loanProfile->ClientRegister->name }}</td>
                        <td class="text-nowrap">{{ $loanProfile->acc_no }}</td>
                        <td class="text-justify text-end">৳{{ $loanProfile->balance }}/-</td>
                        <td class="text-justify text-end">৳{{ $loanProfile->loan_given }}/-</td>
                        <td class="text-justify text-end">৳{{ $loanProfile->loan_recovered }}/-</td>
                        <td class="text-justify text-end">৳{{ $loanProfile->loan_remaining }}/-</td>
                        <td class="text-justify text-end">৳{{ $loanProfile->interest_recovered }}/-</td>
                        <td class="text-justify text-end">৳{{ $loanProfile->interest_remaining }}/-</td>
                    </tr>
                    @php
                        $balance += $loanProfile->balance;
                        $totalLoan += $loanProfile->loan_given;
                        $loanRec += $loanProfile->loan_recovered;
                        $loanRem += $loanProfile->loan_remaining;
                        $interestRec += $loanProfile->interest_recovered;
                        $interestRem += $loanProfile->interest_remaining;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><b>Total</b></td>
                    <td class="text-end"><b>৳{{ $balance }}/-</b></td>
                    <td class="text-end"><b>৳{{ $totalLoan }}/-</b></td>
                    <td class="text-end"><b>৳{{ $loanRec }}/-</b></td>
                    <td class="text-end"><b>৳{{ $loanRem }}/-</b></td>
                    <td class="text-end"><b>৳{{ $interestRec }}/-</b></td>
                    <td class="text-end"><b>৳{{ $interestRem }}/-</b></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
