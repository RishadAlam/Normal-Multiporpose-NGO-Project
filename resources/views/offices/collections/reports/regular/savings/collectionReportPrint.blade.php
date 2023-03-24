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
        @foreach ($savings as $saving)
            <table class="table" id="report">
                <tr>
                    <td class="border border-bottom-0"><b>{{ $saving->name }}</b></td>
                </tr>
                <tr>
                    <td class="p-0">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th style="width: 2%;" class="text-start">#</th>
                                    <th class="text-nowrap">Client Name</th>
                                    <th class="text-nowrap">Account No</th>
                                    <th class="text-nowrap">Description</th>
                                    <th class="text-nowrap">Deposit</th>
                                    <th class="text-nowrap">Officer</th>
                                    <th class="text-nowrap">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @forelse ($saving->SavingsProfile as $key => $SavingsProfile)
                                    @forelse ($SavingsProfile->SavingsCollection as $SavingsCollection)
                                        <tr>
                                            <td class="text-nowrap">{{ ++$key }}</td>
                                            <td class="text-nowrap">
                                                {{ $SavingsProfile->ClientRegister->name }}</td>
                                            <td class="text-nowrap">{{ $SavingsProfile->acc_no }}</td>
                                            <td class="text-justify">{!! $SavingsCollection->expression !!}</td>
                                            <td>৳{{ $SavingsCollection->deposit }}/-</td>
                                            <td>{{ $SavingsCollection->user->name }}
                                            </td>
                                            <td class="text-nowrap">
                                                {{ date('d-m-Y h:i A', strtotime($SavingsCollection->date)) }}
                                        </tr>
                                        @php
                                            $total += $SavingsCollection->deposit;
                                        @endphp
                                    @empty
                                        <tr>
                                            <td class="text-nowrap">{{ ++$key }}</td>
                                            <td class="text-nowrap">
                                                {{ $SavingsProfile->ClientRegister->name }}</td>
                                            <td class="text-nowrap">{{ $SavingsProfile->acc_no }}</td>
                                            <td class="text-nowrap"></td>
                                            <td class="text-nowrap"></td>
                                            <td class="text-nowrap"></td>
                                            <td class="text-nowrap"></td>
                                        </tr>
                                    @endforelse
                                @empty
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><b>Total</b></td>
                                    <td colspan="3"><b>{{ $total != 0 ? '৳' . $total . '/-' : '' }}</b></td>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </table>
        @endforeach
    </div>
@endsection
