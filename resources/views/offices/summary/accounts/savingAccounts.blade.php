@extends('layouts.main')

@push('title')
    {{ request()->name }} {{ $name }} Savings Accounts
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ request()->name }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> {{ request()->name }} {{ $name }} Savings Accounts</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="row justify-items-center">
            <div class="col-md-6">
                <h2 class="fs-lg fw-medium me-auto">{{ request()->name }} {{ $name }} Savings Accounts</h2>
                @if (request()->routeIs('savingsTypeSummary.activeSavingsAccounts'))
                    <a target="__blank"
                        href="{{ Route('savingsTypeSummary.activeSavingsAccounts.print', ['name' => request()->name, 'id' => request()->id]) }}"><span
                            class="text-primary"><i data-feather="printer"></i></span></a>
                @endif
            </div>
            <div class="col-md-6">
                @php
                    $url = explode('/', request()->url());
                    if (array_search('savings-type-analysis', $url)) {
                        if (array_search('active-savings-accounts', $url)) {
                            $route = Route('savingsTypeSummary.activeSavingsAccounts', ['name' => request()->name, 'id' => request()->id]);
                        } elseif (array_search('deactive-savings-accounts', $url)) {
                            $route = Route('savingsTypeSummary.deactiveSavingsAccounts', ['name' => request()->name, 'id' => request()->id]);
                        }
                    } elseif (array_search('volume-analysis', $url)) {
                        if (array_search('active-savings-accounts', $url)) {
                            $route = Route('volumeSummary.activeSavingsAccounts', ['name' => request()->name, 'id' => request()->id]);
                        } elseif (array_search('deactive-savings-accounts', $url)) {
                            $route = Route('volumeSummary.deactiveSavingsAccounts', ['name' => request()->name, 'id' => request()->id]);
                        }
                    } elseif (array_search('center-analysis', $url)) {
                        if (array_search('active-savings-accounts', $url)) {
                            $route = Route('centerSummary.activeSavingsAccounts', ['name' => request()->name, 'id' => request()->id]);
                        } elseif (array_search('deactive-savings-accounts', $url)) {
                            $route = Route('centerSummary.deactiveSavingsAccounts', ['name' => request()->name, 'id' => request()->id]);
                        }
                    }
                @endphp

                <form action="{{ $route }}" method="get" class="float-end">
                    <div class="input-group">
                        <select name="limit" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ request()->limit == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request()->limit == 20 ? 'selected' : '' }}>20</option>
                            <option value="25" {{ request()->limit == null ? 'selected' : '' }}
                                {{ request()->limit == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request()->limit == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request()->limit == 100 ? 'selected' : '' }}>100</option>
                            <option value="500" {{ request()->limit == 500 ? 'selected' : '' }}>500</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <!-- Accounts Table-->
        <div class="intro-y overflow-x-auto">
            <table class="table table-hover table-striped table-report">
                <thead class="bg-theme-1 text-white border-b-0">
                    <tr>
                        <th style="width: 1%;" class="border-bottom-0 text-nowrap text-start">#</th>
                        <th class="border-bottom-0 text-nowrap">Client Name</th>
                        <th class="border-bottom-0 text-nowrap">Account No</th>
                        <th class="border-bottom-0 text-nowrap">Volume</th>
                        <th class="border-bottom-0 text-nowrap">Center</th>
                        <th class="border-bottom-0 text-nowrap">Type</th>
                        <th class="border-bottom-0 text-nowrap">Status</th>
                        <th class="border-bottom-0 text-nowrap">Balance</th>
                        <th class="border-bottom-0 text-nowrap">Share</th>
                        <th class="border-bottom-0 text-nowrap">View</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activeSavings as $key => $accounts)
                        <tr>
                            <td class="border-bottom-0 text-nowrap">{{ ++$key }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $accounts->ClientRegister->name }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $accounts->acc_no }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $accounts->Volume->name }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $accounts->Center->name }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $accounts->Type->name }}</td>
                            <td class="border-bottom-0 text-nowrap">
                                @if ($accounts->status)
                                    <span class="badge rounded-3 bg-success p-3">ACTIVE</span>
                                @else
                                    <span class="badge rounded-3 bg-danger p-3">DACTIVE</span>
                                @endif
                            </td>
                            <td class="border-bottom-0 text-nowrap">৳{{ $accounts->balance }}/-</td>
                            <td class="border-bottom-0 text-nowrap">
                                @if ($key > 1)
                                    @if ($activeSavings[$key - 2]->client_id == $accounts->client_id)
                                        ৳0/-
                                    @else
                                        ৳{{ $accounts->ClientRegister->share }}/-
                                    @endif
                                @else
                                    ৳{{ $accounts->ClientRegister->share }}/-
                                @endif
                            </td>
                            <td class="border-bottom-0 text-nowrap">
                                <a href="{{ Route('accounts', ['name' => $accounts->ClientRegister->name, 'id' => $accounts->client_id]) }}"
                                    class="text-info"><i data-feather="folder"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No records found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $activeSavings->links('pagination::bootstrap-5') }}
        </div>
        <!-- Accounts Table -->
    </div>
@endsection
