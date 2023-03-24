@extends('layouts.print')

@push('title')
    {{ $type->name }} Saving Accounts print
@endpush

@section('mainContent')
    <div class="row mb-3">
        <div class="col-6">
            <b class="text-uppercase">{{ $type->name }} Saving Accounts</b>
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
                    <th class="text-nowrap">Balance</th>
                    <th class="text-nowrap">Share</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $balance = 0;
                    $share = 0;
                @endphp
                @foreach ($activeSavingsList as $key => $SavingsProfile)
                    <tr>
                        <td class="text-nowrap">{{ ++$key }}</td>
                        <td class="text-nowrap">
                            {{ $SavingsProfile->ClientRegister->name }}</td>
                        <td class="text-nowrap">{{ $SavingsProfile->acc_no }}</td>
                        <td class="text-justify">{!! $SavingsProfile->balance !!}</td>
                        <td>
                            @if ($key > 1)
                                @if ($activeSavingsList[$key - 2]->client_id == $SavingsProfile->client_id)
                                    ৳0/-
                                @else
                                    ৳{{ $SavingsProfile->ClientRegister->share }}/-
                                @endif
                            @else
                                ৳{{ $SavingsProfile->ClientRegister->share }}/-
                            @endif
                        </td>
                    </tr>
                    @php
                        $balance += $SavingsProfile->balance;
                        $share += $SavingsProfile->share;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end"><b>Total</b></td>
                    <td><b>৳{{ $balance }}/-</b></td>
                    <td><b>৳{{ $share }}/-</b></td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
