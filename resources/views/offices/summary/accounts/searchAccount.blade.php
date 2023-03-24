@extends('layouts.main')

@push('title')
    "{{ request()->search }}" Searching Accounts Shown
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active"> "{{ request()->search }}" Searching Accounts Shown</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="row justify-items-center">
            <div class="col-md-6">
                <h2 class="fs-lg fw-medium me-auto">"{{ request()->search }}" Searching Accounts Shown</h2>
            </div>
            <div class="col-md-6">
                <form action="{{ Route('accounts.search', request()->search) }}" method="get" class="float-end">
                    <div class="input-group">
                        <input type="hidden" name="search" value="{{ request()->search }}">
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
                        <th class="border-bottom-0 text-nowrap">View</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($accounts as $key => $account)
                        <tr>
                            <td class="border-bottom-0 text-nowrap">{{ ++$key }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $account->name }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $account->acc_no }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $account->Volume->name }}</td>
                            <td class="border-bottom-0 text-nowrap">{{ $account->Center->name }}</td>
                            <td class="border-bottom-0 text-nowrap">
                                <a href="{{ Route('accounts', ['name' => $account->name, 'id' => $account->id]) }}"
                                    class="text-info"><i data-feather="folder"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No records found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $accounts->links('pagination::bootstrap-5') }}
        </div>
        <!-- Accounts Table -->
    </div>
@endsection
