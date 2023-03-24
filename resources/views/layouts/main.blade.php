<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<!-- BEGIN: Head -->

<head>
    <meta charset="utf-8">
    <link href="{{ asset('storage/settings/' . $infos->logo) }}" rel="shortcut icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Title -->
    <title>@stack('title'){{ __(' - ' . $infos->full_name) }}</title>
    <!-- BEGIN: CSS Assets-->
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/mdtimepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/summernote-lite.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/boxicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/style.css') }}" />
    <!-- END: CSS Assets-->
    <script>
        var darkmode = localStorage.getItem('darkmode')
        var classs = document.querySelector('html')
        if (darkmode === 'enable') {
            classs.classList.add("dark")
            classs.classList.remove('light')
        } else {
            classs.classList.remove('dark')
            classs.classList.add('light')
        }
        window.addEventListener('DOMContentLoaded', (event) => {
            var dark_switch = document.querySelector('input.dark_mood_switch')
            if (darkmode === 'enable') {
                dark_switch.checked = true
            } else {
                dark_switch.checked = false
            }
        });
    </script>
</head>
<!-- END: Head -->

<body class="main">
    <!-- PreLoader -->
    <div id="preloader">
        <div id="overlayer"></div>
        <div id="loader"></div>
    </div>

    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu d-md-none">
        <div class="mobile-menu-bar">
            <a href="{{ Route('home') }}" class="d-flex me-auto">
                <img alt="Rubick Bootstrap HTML Admin Template" class="w-6"
                    src="{{ asset('storage/settings/' . $infos->logo) }}">
            </a>
            <a href="javascript:;" id="mobile-menu-toggler" class="mobile-menu-bar__toggler"> <i
                    data-feather="bar-chart-2" class="w-8 h-8 text-white"></i> </a>
        </div>
        <ul class="mobile-menu-wrapper border-top border-theme-29 dark-border-dark-3 py-5">
            <li>
                <a href="{{ Route('home') }}" class="menu {{ request()->routeIs('home') ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="home"></i> </div>
                    <div class="menu__title"> {{ __('Dashboard') }} </div>
                </a>
            </li>
            @if (auth()->user()->hasAnyPermission([
                        'New Client Registration',
                        'Saving Account Registration',
                        'Loan Account Registration',
                        'Employee Registration',
                        'Savings Collection',
                        'Loans Collection',
                        'Savings Withdrawal',
                        'Loan Savings Withdrawal',
                        'Savings to Savings',
                        'Savings to Loan Savings',
                        'Loan Savings to Loan Savings',
                        'Loan Savings to Savings',
                        'Saving Account Closing',
                        'Loan Account Closing',
                    ]))
                <li class="menu__devider my-6"></li>
            @endif
            @if (auth()->user()->hasAnyPermission([
                        'New Client Registration',
                        'Saving Account Registration',
                        'Loan Account Registration',
                        'Employee Registration',
                    ]))
                <li>
                    <a href="javascript:;"
                        class="menu {{ request()->routeIs('registration*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="book"></i> </div>
                        <div class="menu__title"> Registrations <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('registration*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('New Client Registration'))
                            <li>
                                <a href="{{ Route('registration.newCustomer') }}"
                                    class="menu {{ request()->routeIs('registration.newCustomer') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="edit-3"></i> </div>
                                    <div class="menu__title"> Create New Client </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Saving Account Registration'))
                            <li>
                                <a href="{{ Route('registration.newSavings') }}"
                                    class="menu {{ request()->routeIs('registration.newSavings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="edit-3"></i> </div>
                                    <div class="menu__title"> Create Saving Account </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loan Account Registration'))
                            <li>
                                <a href="{{ Route('registration.newLoans') }}"
                                    class="menu {{ request()->routeIs('registration.newLoans') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="edit-3"></i> </div>
                                    <div class="menu__title"> Create Loan Account </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Employee Registration'))
                            <li>
                                <a href="{{ Route('registration.employee') }}"
                                    class="menu {{ request()->routeIs('registration.employee') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="edit-3"></i> </div>
                                    <div class="menu__title"> Create Employee </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasAnyPermission(['Savings Collection', 'Loans Collection']))
                <li>
                    <a href="javascript:;"
                        class="menu {{ request()->routeIs('collectionForm*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="hard-drive"></i> </div>
                        <div class="menu__title"> Collection Form <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('collectionForm*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('Savings Collection'))
                            <li>
                                <a href="{{ Route('collectionForm.savingsForm') }}"
                                    class="menu {{ request()->routeIs('collectionForm.savingsForm') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="bar-chart"></i> </div>
                                    <div class="menu__title"> Savings Collection </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loans Collection'))
                            <li>
                                <a href="{{ Route('collectionForm.loansForm') }}"
                                    class="menu {{ request()->routeIs('collectionForm.loansForm') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="bar-chart-2"></i> </div>
                                    <div class="menu__title"> Loans Collection </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasAnyPermission(['Savings Withdrawal', 'Loan Savings Withdrawal']))
                <li>
                    <a href="javascript:;"
                        class="menu {{ request()->routeIs('withdrawalForm*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="aperture"></i> </div>
                        <div class="menu__title"> Withdrawal Forms <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('withdrawalForm*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('Savings Withdrawal'))
                            <li>
                                <a href="{{ Route('withdrawalForm.savingsForm') }}"
                                    class="menu {{ request()->routeIs('withdrawalForm.savingsForm') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="credit-card"></i> </div>
                                    <div class="menu__title"> Savings Withdrawal </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loan Savings Withdrawal'))
                            <li>
                                <a href="{{ Route('withdrawalForm.loanSavingsForm') }}"
                                    class="menu {{ request()->routeIs('withdrawalForm.loanSavingsForm') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="credit-card"></i> </div>
                                    <div class="menu__title"> Loan Savings Withdrawal </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasAnyPermission([
                        'Savings to Savings',
                        'Savings to Loan Savings',
                        'Loan Savings to Loan Savings',
                        'Loan Savings to Savings',
                    ]))
                <li>
                    <a href="javascript:;"
                        class="menu {{ request()->routeIs('transactionForms*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="dollar-sign"></i> </div>
                        <div class="menu__title"> Transaction Forms <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('transactionForms*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('Savings to Savings'))
                            <li>
                                <a href="{{ Route('transactionForms.SavingstoSavings') }}"
                                    class="menu {{ request()->routeIs('transactionForms.SavingstoSavings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="hash"></i> </div>
                                    <div class="menu__title"> Savings to Savings </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Savings to Loan Savings'))
                            <li>
                                <a href="{{ Route('transactionForms.SavingstoLoans') }}"
                                    class="menu {{ request()->routeIs('transactionForms.SavingstoLoans') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="hash"></i> </div>
                                    <div class="menu__title"> Savings to Loan Savings </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loan Savings to Loan Savings'))
                            <li>
                                <a href="{{ Route('transactionForms.loanSavingstoLoanSavings') }}"
                                    class="menu {{ request()->routeIs('transactionForms.loanSavingstoLoanSavings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="hash"></i> </div>
                                    <div class="menu__title"> Loan Savings to Loan Savings </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loan Savings to Savings'))
                            <li>
                                <a href="{{ Route('transactionForms.loanSavingstoSavings') }}"
                                    class="menu {{ request()->routeIs('transactionForms.loanSavingstoSavings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="hash"></i> </div>
                                    <div class="menu__title"> Loan Savings to Savings </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasAnyPermission(['Saving Account Closing', 'Loan Account Closing']))
                <li>
                    <a href="javascript:;" class="menu {{ request()->routeIs('closing*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="zap-off"></i> </div>
                        <div class="menu__title"> Closing Forms <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('closing*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('Saving Account Closing'))
                            <li>
                                <a href="{{ Route('closing.Savings') }}"
                                    class="menu {{ request()->routeIs('closing.Savings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="x-octagon"></i> </div>
                                    <div class="menu__title"> Saving Account Closing </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loan Account Closing'))
                            <li>
                                <a href="{{ Route('closing.Loan') }}"
                                    class="menu {{ request()->routeIs('closing.Loan') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="x-octagon"></i> </div>
                                    <div class="menu__title"> Loan Account Closing </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasAnyPermission([
                        'Regular Collections',
                        'Pending Collections',
                        'Regular Savings Withdrawal Report',
                        'Loan Savings Withdrawal Report',
                        'Savings to Savings Report',
                        'Savings to Loan Savings Report',
                        'Loan Savings to Loan Savings Report',
                    ]))
                <li class="menu__devider my-6"></li>
            @endif
            @if (auth()->user()->hasAnyPermission(['Regular Collections', 'Pending Collections']))
                <li>
                    <a href="javascript:;"
                        class="menu {{ request()->routeIs('collectionsReport*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="credit-card"></i> </div>
                        <div class="menu__title"> Collection Reports <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('collectionsReport*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('Regular Collections'))
                            <li>
                                <a href="{{ Route('collectionsReport.regularCollection') }}"
                                    class="menu {{ request()->routeIs('collectionsReport.regularCollection') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="bookmark"></i> </div>
                                    <div class="menu__title"> Regular Collections </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Pending Collections'))
                            <li>
                                <a href="{{ Route('collectionsReport.pendingCollection') }}"
                                    class="menu {{ request()->routeIs('collectionsReport.pendingCollection') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="archive"></i> </div>
                                    <div class="menu__title"> Loan Account collectionsReport </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasAnyPermission(['Regular Savings Withdrawal Report', 'Loan Savings Withdrawal Report']))
                <li>
                    <a href="javascript:;"
                        class="menu {{ request()->routeIs('withdrawalReports*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="airplay"></i> </div>
                        <div class="menu__title"> Withdrawal Reports <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('withdrawalReports*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('Regular Savings Withdrawal Report'))
                            <li>
                                <a href="{{ Route('withdrawalReports.savings') }}"
                                    class="menu {{ request()->routeIs('withdrawalReports.savings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="menu__title"> Regular Collections </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loan Savings Withdrawal Report'))
                            <li>
                                <a href="{{ Route('withdrawalReports.loanSavings') }}"
                                    class="menu {{ request()->routeIs('withdrawalReports.loanSavings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="menu__title"> Loan Account withdrawalReports </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->hasAnyPermission([
                        'Savings to Savings Report',
                        'Savings to Loan Savings Report',
                        'Loan Savings to Loan Savings Report',
                        'Loan Savings to Savings Report',
                    ]))
                <li>
                    <a href="javascript:;"
                        class="menu {{ request()->routeIs('transactionReports*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="airplay"></i> </div>
                        <div class="menu__title"> Transaction Reports <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('transactionReports*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('Savings to Savings Report'))
                            <li>
                                <a href="{{ Route('transactionReports.SavingstoSavings') }}"
                                    class="menu {{ request()->routeIs('transactionReports.SavingstoSavings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="menu__title"> Savings to Savings </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Savings to Loan Savings Report'))
                            <li>
                                <a href="{{ Route('transactionReports.SavingstoLoans') }}"
                                    class="menu {{ request()->routeIs('transactionReports.SavingstoLoans') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="menu__title"> Savings to Loan Savings</div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loan Savings to Loan Savings Report'))
                            <li>
                                <a href="{{ Route('transactionReports.loanSavingstoLoanSavings') }}"
                                    class="menu {{ request()->routeIs('transactionReports.loanSavingstoLoanSavings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="menu__title"> Loan Savings to Loan Savings </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Loan Savings to Savings Report'))
                            <li>
                                <a href="{{ Route('transactionReports.loanSavingstoSavings') }}"
                                    class="menu {{ request()->routeIs('transactionReports.loanSavingstoSavings') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="menu__title"> Loan Savings to Savings </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            <li class="menu__devider my-6"></li>
            @if (auth()->user()->can('Analytics View'))
                <li>
                    <a href="{{ Route('analytics') }}"
                        class="menu {{ request()->routeIs('analytics*') ? 'side-menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="menu__title"> Analytics </div>
                    </a>
                </li>
            @endif
            <li>
                <a href="javascript:;" class="menu {{ request()->routeIs('volumeSummary*') ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="activity"></i> </div>
                    <div class="menu__title"> Volume Analytics <i data-feather="chevron-down"
                            class="menu__sub-icon "></i> </div>
                </a>
                <ul class="{{ request()->routeIs('volumeSummary*') ? 'menu__sub-open' : '' }}">
                    @forelse ($vol_lists as $vol)
                        <li>
                            <a href="{{ Route('volumeSummary', ['name' => $vol->name, 'id' => $vol->id]) }}"
                                class="menu {{ request()->routeIs('volumeSummary*') ? 'menu--active' : '' }}">
                                <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                <div class="menu__title"> {{ $vol->name }} </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            <a hclass="menu">
                                <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                <div class="menu__title"> No Records Found! </div>
                            </a>
                        </li>
                    @endforelse
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu {{ request()->routeIs('centerSummary*') ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="activity"></i> </div>
                    <div class="menu__title"> Center Analytics <i data-feather="chevron-down"
                            class="menu__sub-icon "></i> </div>
                </a>
                <ul class="{{ request()->routeIs('centerSummary*') ? 'menu__sub-open' : '' }}">
                    @forelse ($center_lists as $center)
                        <li>
                            <a href="{{ Route('centerSummary', ['name' => $center->name, 'id' => $center->id]) }}"
                                class="menu {{ request()->routeIs('centerSummary*') ? 'menu--active' : '' }}">
                                <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                <div class="menu__title"> {{ $center->name }} </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            <a hclass="menu">
                                <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                <div class="menu__title"> No Records Found! </div>
                            </a>
                        </li>
                    @endforelse
                </ul>
            </li>
            <li>
                <a href="javascript:;"
                    class="menu {{ request()->routeIs('savingsTypeSummary*') ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="activity"></i> </div>
                    <div class="menu__title"> Saving Type Analytics <i data-feather="chevron-down"
                            class="menu__sub-icon "></i> </div>
                </a>
                <ul class="{{ request()->routeIs('savingsTypeSummary*') ? 'menu__sub-open' : '' }}">
                    @forelse ($savingTypes_lists as $savingTypes)
                        <li>
                            <a href="{{ Route('savingsTypeSummary', ['name' => $savingTypes->name, 'id' => $savingTypes->id]) }}"
                                class="menu {{ request()->routeIs('savingsTypeSummary*') ? 'menu--active' : '' }}">
                                <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                <div class="menu__title"> {{ $savingTypes->name }} </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            <a hclass="menu">
                                <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                <div class="menu__title"> No Records Found! </div>
                            </a>
                        </li>
                    @endforelse
                </ul>
            </li>
            <li>
                <a href="javascript:;"
                    class="menu {{ request()->routeIs('loanSavingsTypeSummary*') ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="activity"></i> </div>
                    <div class="menu__title"> Loan Type Analytics <i data-feather="chevron-down"
                            class="menu__sub-icon "></i> </div>
                </a>
                <ul class="{{ request()->routeIs('loanSavingsTypeSummary*') ? 'menu__sub-open' : '' }}">
                    @forelse ($loanTypes_lists as $loanTypes)
                        <li>
                            <a href="{{ Route('loanSavingsTypeSummary', ['name' => $loanTypes->name, 'id' => $loanTypes->id]) }}"
                                class="menu {{ request()->routeIs('loanSavingsTypeSummary*') ? 'menu--active' : '' }}">
                                <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                <div class="menu__title"> {{ $loanTypes->name }} </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            <a hclass="menu">
                                <div class="menu__icon"> <i data-feather="terminal"></i> </div>
                                <div class="menu__title"> No Records Found! </div>
                            </a>
                        </li>
                    @endforelse
                </ul>
            </li>
            @if (auth()->user()->hasAnyPermission(['Volume View', 'Center View', 'Type View']))
                <li class="menu__devider my-6"></li>
            @endif
            @if (auth()->user()->can('Volume View'))
                <li>
                    <a href="{{ Route('volume') }}"
                        class="menu {{ request()->routeIs('volume*') ? 'side-menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="rss"></i> </div>
                        <div class="menu__title"> Volume </div>
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('Center View'))
                <li>
                    <a href="{{ Route('center') }}"
                        class="menu {{ request()->routeIs('center*') ? 'side-menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="target"></i> </div>
                        <div class="menu__title"> Center </div>
                    </a>
                </li>
            @endif
            @if (auth()->user()->can('Type View'))
                <li>
                    <a href="{{ Route('type') }}"
                        class="menu {{ request()->routeIs('type*') ? 'side-menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="wind"></i> </div>
                        <div class="menu__title"> Type </div>
                    </a>
                </li>
            @endif
            @if (auth()->user()->hasAnyPermission(['Employee Permissions', 'Employee View']))
                <li class="menu__devider my-6"></li>
                <li>
                    <a href="javascript:;" class="menu {{ request()->routeIs('employee*') ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="users"></i> </div>
                        <div class="menu__title"> {{ __('Employee') }} <i data-feather="chevron-down"
                                class="menu__sub-icon "></i> </div>
                    </a>
                    <ul class="{{ request()->routeIs('employee*') ? 'menu__sub-open' : '' }}">
                        @if (auth()->user()->can('Employee View'))
                            <li>
                                <a href="{{ Route('employee') }}"
                                    class="menu {{ request()->routeIs('employee') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="user"></i> </div>
                                    <div class="menu__title"> {{ __('Employee List') }} </div>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('Employee Permissions'))
                            <li>
                                <a href="{{ Route('employee.permissions') }}"
                                    class="menu {{ request()->routeIs('employee.permissions') ? 'menu--active' : '' }}">
                                    <div class="menu__icon"> <i data-feather="sliders"></i> </div>
                                    <div class="menu__title"> {{ __('Employee Permissions') }} </div>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (auth()->user()->can('Settings'))
                <li>
                    <a href="{{ Route('settings') }}"
                        class="menu {{ request()->routeIs('settings*') ? 'side-menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="settings"></i> </div>
                        <div class="menu__title"> Settings </div>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <!-- END: Mobile Menu -->
    <div class="d-flex">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <a href="{{ Route('home') }}" class="intro-x d-flex align-items-center ps-5 pt-4">
                <img alt="Rubick Tailwind HTML Admin Template" class="w-6"
                    src="{{ asset('storage/settings/' . $infos->logo) }}">
                <span
                    class="d-none d-xl-block text-justify text-white fs-lg ms-3 text-uppercase">{{ $infos->short_name }}</span>
            </a>
            <div class="side-nav__devider my-6"></div>
            <ul>
                <li>
                    <a href="{{ Route('home') }}"
                        class="side-menu {{ request()->routeIs('home') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="side-menu__title">
                            {{ __('Dashboard') }}
                        </div>
                    </a>
                </li>
                @if (auth()->user()->hasAnyPermission([
                            'New Client Registration',
                            'Saving Account Registration',
                            'Loan Account Registration',
                            'Employee Registration',
                            'Savings Collection',
                            'Loans Collection',
                            'Savings Withdrawal',
                            'Loan Savings Withdrawal',
                            'Savings to Savings',
                            'Savings to Loan Savings',
                            'Loan Savings to Loan Savings',
                            'Loan Savings to Savings',
                            'Saving Account Closing',
                            'Loan Account Closing',
                        ]))
                    <li class="side-nav__devider my-6"></li>
                @endif
                @if (auth()->user()->hasAnyPermission([
                            'New Client Registration',
                            'Saving Account Registration',
                            'Loan Account Registration',
                            'Employee Registration',
                        ]))
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('registration*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="book"></i> </div>
                            <div class="side-menu__title">
                                Registrations
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('registration*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('New Client Registration'))
                                <li>
                                    <a href="{{ Route('registration.newCustomer') }}"
                                        class="side-menu {{ request()->routeIs('registration.newCustomer') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="edit-3"></i> </div>
                                        <div class="side-menu__title"> Create New Client </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Saving Account Registration'))
                                <li>
                                    <a href="{{ Route('registration.newSavings') }}"
                                        class="side-menu {{ request()->routeIs('registration.newSavings') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="edit-3"></i> </div>
                                        <div class="side-menu__title"> Create Saving Account </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loan Account Registration'))
                                <li>
                                    <a href="{{ Route('registration.newLoans') }}"
                                        class="side-menu {{ request()->routeIs('registration.newLoans') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="edit-3"></i> </div>
                                        <div class="side-menu__title"> Create Loan Account </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Employee Registration'))
                                <li>
                                    <a href="{{ Route('registration.employee') }}"
                                        class="side-menu {{ request()->routeIs('registration.employee') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="user-plus"></i> </div>
                                        <div class="side-menu__title"> Create Employee </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasAnyPermission(['Savings Collection', 'Loans Collection']))
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('collectionForm*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="clipboard"></i> </div>
                            <div class="side-menu__title">
                                Collection Forms
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('collectionForm*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('Savings Collection'))
                                <li>
                                    <a href="{{ Route('collectionForm.savingsForm') }}"
                                        class="side-menu {{ request()->routeIs('collectionForm.savingsForm') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="bar-chart"></i> </div>
                                        <div class="side-menu__title"> Savings Collection </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loans Collection'))
                                <li>
                                    <a href="{{ Route('collectionForm.loansForm') }}"
                                        class="side-menu {{ request()->routeIs('collectionForm.loansForm') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="bar-chart-2"></i> </div>
                                        <div class="side-menu__title"> Loans Collection </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasAnyPermission(['Savings Withdrawal', 'Loan Savings Withdrawal']))
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('withdrawalForm*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="aperture"></i> </div>
                            <div class="side-menu__title">
                                Withdrawal Forms
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('withdrawalForm*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('Savings Withdrawal'))
                                <li>
                                    <a href="{{ Route('withdrawalForm.savingsForm') }}"
                                        class="side-menu {{ request()->routeIs('withdrawalForm.savingsForm') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="credit-card"></i> </div>
                                        <div class="side-menu__title"> Savings Withdrawal </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loan Savings Withdrawal'))
                                <li>
                                    <a href="{{ Route('withdrawalForm.loanSavingsForm') }}"
                                        class="side-menu {{ request()->routeIs('withdrawalForm.loanSavingsForm') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="credit-card"></i> </div>
                                        <div class="side-menu__title"> Loan Savings Withdrawal </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasAnyPermission([
                            'Savings to Savings',
                            'Savings to Loan Savings',
                            'Loan Savings to Loan Savings',
                            'Loan Savings to Savings',
                        ]))
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('transactionForms*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="dollar-sign"></i> </div>
                            <div class="side-menu__title">
                                Transaction Forms
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('transactionForms*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('Savings to Savings'))
                                <li>
                                    <a href="{{ Route('transactionForms.SavingstoSavings') }}"
                                        class="side-menu {{ request()->routeIs('transactionForms.SavingstoSavings') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="hash"></i> </div>
                                        <div class="side-menu__title"> Savings to Savings </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Savings to Loan Savings'))
                                <li>
                                    <a href="{{ Route('transactionForms.SavingstoLoans') }}"
                                        class="side-menu {{ request()->routeIs('transactionForms.SavingstoLoans') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="hash"></i> </div>
                                        <div class="side-menu__title"> Savings to Loan Savings </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loan Savings to Loan Savings'))
                                <li>
                                    <a href="{{ Route('transactionForms.loanSavingstoLoanSavings') }}"
                                        class="side-menu {{ request()->routeIs('transactionForms.loanSavingstoLoanSavings') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="hash"></i> </div>
                                        <div class="side-menu__title"> Loan Savings to Loan Savings </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loan Savings to Savings'))
                                <li>
                                    <a href="{{ Route('transactionForms.loanSavingstoSavings') }}"
                                        class="side-menu {{ request()->routeIs('transactionForms.loanSavingstoSavings') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="hash"></i> </div>
                                        <div class="side-menu__title"> Loan Savings to Savings </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasAnyPermission(['Saving Account Closing', 'Loan Account Closing']))
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('closing*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="zap-off"></i> </div>
                            <div class="side-menu__title">
                                Closing Forms
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('closing*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('Saving Account Closing'))
                                <li>
                                    <a href="{{ Route('closing.Savings') }}"
                                        class="side-menu {{ request()->routeIs('closing.Savings') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="x-octagon"></i> </div>
                                        <div class="side-menu__title"> Saving Account Closing </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loan Account Closing'))
                                <li>
                                    <a href="{{ Route('closing.Loan') }}"
                                        class="side-menu {{ request()->routeIs('closing.Loan') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="x-octagon"></i> </div>
                                        <div class="side-menu__title"> Loan Account Closing </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasAnyPermission([
                            'Regular Collections',
                            'Pending Collections',
                            'Regular Savings Withdrawal Report',
                            'Loan Savings Withdrawal Report',
                            'Savings to Savings Report',
                            'Savings to Loan Savings Report',
                            'Loan Savings to Loan Savings Report',
                        ]))
                    <li class="side-nav__devider my-6"></li>
                @endif
                @if (auth()->user()->hasAnyPermission(['Regular Collections', 'Pending Collections']))
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('collectionsReport*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="credit-card"></i> </div>
                            <div class="side-menu__title">
                                Collection Reports
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('collectionsReport*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('Regular Collections'))
                                <li>
                                    <a href="{{ Route('collectionsReport.regularCollection') }}"
                                        class="side-menu {{ request()->routeIs('collectionsReport.regularCollection*') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="bookmark"></i> </div>
                                        <div class="side-menu__title"> Regular Collections </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Pending Collections'))
                                <li>
                                    <a href="{{ Route('collectionsReport.pendingCollection') }}"
                                        class="side-menu {{ request()->routeIs('collectionsReport.pendingCollection*') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="archive"></i> </div>
                                        <div class="side-menu__title"> Pending Collections </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasAnyPermission(['Regular Savings Withdrawal Report', 'Loan Savings Withdrawal Report']))
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('withdrawalReports*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="airplay"></i> </div>
                            <div class="side-menu__title">
                                Withdrawal Reports
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('withdrawalReports*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('Regular Savings Withdrawal Report'))
                                <li>
                                    <a href="{{ Route('withdrawalReports.savings') }}"
                                        class="side-menu {{ request()->routeIs('withdrawalReports.savings*') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                        <div class="side-menu__title"> Regular Savings Withdrawal Report </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loan Savings Withdrawal Report'))
                                <li>
                                    <a href="{{ Route('withdrawalReports.loanSavings') }}"
                                        class="side-menu {{ request()->routeIs('withdrawalReports.loanSavings*') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                        <div class="side-menu__title"> Loan Savings Withdrawal Report </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->hasAnyPermission([
                            'Savings to Savings Report',
                            'Savings to Loan Savings Report',
                            'Loan Savings to Loan Savings Report',
                            'Loan Savings to Savings Report',
                        ]))
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('transactionReports*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="airplay"></i> </div>
                            <div class="side-menu__title">
                                Transaction Reports
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('transactionReports*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('Savings to Savings Report'))
                                <li>
                                    <a href="{{ Route('transactionReports.SavingstoSavings') }}"
                                        class="side-menu {{ request()->routeIs('transactionReports.SavingstoSavings*') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                        <div class="side-menu__title"> Savings to Savings </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Savings to Loan Savings Report'))
                                <li>
                                    <a href="{{ Route('transactionReports.SavingstoLoans') }}"
                                        class="side-menu {{ request()->routeIs('transactionReports.SavingstoLoans*') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                        <div class="side-menu__title"> Savings to Loan Savings </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loan Savings to Loan Savings Report'))
                                <li>
                                    <a href="{{ Route('transactionReports.loanSavingstoLoanSavings') }}"
                                        class="side-menu {{ request()->routeIs('transactionReports.loanSavingstoLoanSavings*') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                        <div class="side-menu__title"> Loan Savings to Loan Savings </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Loan Savings to Savings Report'))
                                <li>
                                    <a href="{{ Route('transactionReports.loanSavingstoSavings') }}"
                                        class="side-menu {{ request()->routeIs('transactionReports.loanSavingstoSavings*') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                        <div class="side-menu__title"> Loan Savings to Savings </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                <li class="side-nav__devider my-6"></li>
                @if (auth()->user()->can('Analytics View'))
                    <li>
                        <a href="{{ Route('analytics') }}"
                            class="side-menu {{ request()->routeIs('analytics*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Analytics </div>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="javascript:;.html"
                        class="side-menu {{ request()->routeIs('volumeSummary*') ? 'side-menu--active side-menu--open' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title">
                            Volume Analytics
                            <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ request()->routeIs('volumeSummary*') ? 'side-menu__sub-open' : '' }}">
                        @forelse ($vol_lists as $vol)
                            <li>
                                <a href="{{ Route('volumeSummary', ['name' => $vol->name, 'id' => $vol->id]) }}"
                                    class="side-menu {{ request()->routeIs('volumeSummary*') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="side-menu__title"> {{ $vol->name }} </div>
                                </a>
                            </li>
                        @empty
                            <li>
                                <a class="side-menu">
                                    <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="side-menu__title"> No Records Found! </div>
                                </a>
                            </li>
                        @endforelse
                    </ul>
                </li>
                <li>
                    <a href="javascript:;.html"
                        class="side-menu {{ request()->routeIs('centerSummary*') ? 'side-menu--active side-menu--open' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title">
                            Center Analytics
                            <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ request()->routeIs('centerSummary*') ? 'side-menu__sub-open' : '' }}">
                        @forelse ($center_lists as $center)
                            <li>
                                <a href="{{ Route('centerSummary', ['name' => $center->name, 'id' => $center->id]) }}"
                                    class="side-menu {{ request()->routeIs('centerSummary*') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="side-menu__title"> {{ $center->name }} </div>
                                </a>
                            </li>
                        @empty
                            <li>
                                <a
                                    class="side-menu {{ request()->routeIs('transactionReports.SavingstoSavings*') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="side-menu__title"> No Records Found! </div>
                                </a>
                            </li>
                        @endforelse
                    </ul>
                </li>
                <li>
                    <a href="javascript:;.html"
                        class="side-menu {{ request()->routeIs('savingsTypeSummary*') ? 'side-menu--active side-menu--open' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title">
                            Saving Type Analytics
                            <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ request()->routeIs('savingsTypeSummary*') ? 'side-menu__sub-open' : '' }}">
                        @forelse ($savingTypes_lists as $savingTypes)
                            <li>
                                <a href="{{ Route('savingsTypeSummary', ['name' => $savingTypes->name, 'id' => $savingTypes->id]) }}"
                                    class="side-menu {{ request()->routeIs('savingsTypeSummary*') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="side-menu__title"> {{ $savingTypes->name }} </div>
                                </a>
                            </li>
                        @empty
                            <li>
                                <a
                                    class="side-menu {{ request()->routeIs('transactionReports.SavingstoSavings*') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="side-menu__title"> No Records Found! </div>
                                </a>
                            </li>
                        @endforelse
                    </ul>
                </li>
                <li>
                    <a href="javascript:;.html"
                        class="side-menu {{ request()->routeIs('loanSavingsTypeSummary*') ? 'side-menu--active side-menu--open' : '' }}">
                        <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                        <div class="side-menu__title">
                            Loan Type Analytics
                            <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                        </div>
                    </a>
                    <ul class="{{ request()->routeIs('loanSavingsTypeSummary*') ? 'side-menu__sub-open' : '' }}">
                        @forelse ($loanTypes_lists as $loanTypes)
                            <li>
                                <a href="{{ Route('loanSavingsTypeSummary', ['name' => $loanTypes->name, 'id' => $loanTypes->id]) }}"
                                    class="side-menu {{ request()->routeIs('loanSavingsTypeSummary*') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="side-menu__title"> {{ $loanTypes->name }} </div>
                                </a>
                            </li>
                        @empty
                            <li>
                                <a
                                    class="side-menu {{ request()->routeIs('loanSavingsTypeSummary*') ? 'side-menu--active' : '' }}">
                                    <div class="side-menu__icon"> <i data-feather="terminal"></i> </div>
                                    <div class="side-menu__title"> No Records Found! </div>
                                </a>
                            </li>
                        @endforelse
                    </ul>
                </li>
                @if (auth()->user()->hasAnyPermission(['Volume View', 'Center View', 'Type View']))
                    <li class="side-nav__devider my-6"></li>
                @endif
                @if (auth()->user()->can('Volume View'))
                    <li>
                        <a href="{{ Route('volume') }}"
                            class="side-menu {{ request()->routeIs('volume*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="rss"></i> </div>
                            <div class="side-menu__title"> Volume </div>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->can('Center View'))
                    <li>
                        <a href="{{ Route('center') }}"
                            class="side-menu {{ request()->routeIs('center*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="target"></i> </div>
                            <div class="side-menu__title"> Center </div>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->can('Type View'))
                    <li>
                        <a href="{{ Route('type') }}"
                            class="side-menu {{ request()->routeIs('type*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="wind"></i> </div>
                            <div class="side-menu__title"> Type </div>
                        </a>
                    </li>
                @endif
                @if (auth()->user()->hasAnyPermission(['Employee Permissions', 'Employee View']))
                    <li class="side-nav__devider my-6"></li>
                    <li>
                        <a href="javascript:;.html"
                            class="side-menu {{ request()->routeIs('employee*') ? 'side-menu--active side-menu--open' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="users"></i> </div>
                            <div class="side-menu__title">
                                {{ __('Employee') }}
                                <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                            </div>
                        </a>
                        <ul class="{{ request()->routeIs('employee*') ? 'side-menu__sub-open' : '' }}">
                            @if (auth()->user()->can('Employee View'))
                                <li>
                                    <a href="{{ Route('employee') }}"
                                        class="side-menu {{ request()->routeIs('employee') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="user"></i> </div>
                                        <div class="side-menu__title">
                                            {{ __('Employee List') }}
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if (auth()->user()->can('Employee Permissions'))
                                <li>
                                    <a href="{{ Route('employee.permissions') }}"
                                        class="side-menu {{ request()->routeIs('employee.permissions') ? 'side-menu--active' : '' }}">
                                        <div class="side-menu__icon"> <i data-feather="sliders"></i> </div>
                                        <div class="side-menu__title">
                                            {{ __('Employee Permissions') }}
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->can('Settings'))
                    <li>
                        <a href="{{ Route('settings') }}"
                            class="side-menu {{ request()->routeIs('settings*') ? 'side-menu--active' : '' }}">
                            <div class="side-menu__icon"> <i data-feather="settings"></i> </div>
                            <div class="side-menu__title"> Settings </div>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            <!-- BEGIN: Top Bar -->
            <div class="top-bar">
                <!-- BEGIN: Breadcrumb -->
                <div class="-intro-x breadcrumb me-auto d-none d-sm-flex">
                    @yield('breadcrumb')
                </div>
                <!-- END: Breadcrumb -->
                <!-- BEGIN: Search -->
                <div class="intro-x position-relative me-3 me-sm-6">
                    <form action="{{ Route('accounts.search') }}" method="get">
                        <div class="search d-none d-sm-block">
                            <input type="text" class="search__input form-control border-transparent"
                                placeholder="Search..." name="search" id="liveSearch"
                                value="{{ request()->search }}">
                            <i data-feather="search" class="search__icon dark-text-gray-300"></i>
                        </div>
                    </form>
                    <a class="notification d-sm-none" href="index.html"> <i data-feather="search"
                            class="notification__icon dark-text-gray-300"></i> </a>
                    <div class="search-result">
                        <div class="search-result__content">
                            <div class="search-result__content__title">Accounts</div>
                            <div class="mb-5" id="liveSearchtearm">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Search -->
                <!-- BEGIN: Notifications -->
                {{-- <div class="intro-x dropdown me-auto me-sm-6">
                    <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button"
                        aria-expanded="false" data-bs-toggle="dropdown"> <i data-feather="bell"
                            class="notification__icon dark-text-gray-300"></i> </div>
                    <div class="notification-content pt-2 dropdown-menu">
                        <div class="notification-content__box dropdown-content">
                            <div class="notification-content__title dark-text-gray-300">Notifications</div>
                            <div class="cursor-pointer position-relative d-flex align-items-center ">
                                <div class="w-12 h-12 flex-none image-fit me-1">
                                    <img alt="Rubick Bootstrap HTML Admin Template" class="rounded-pill"
                                        src="{{ asset('dist/images/profile-14.jpg') }}">
                                    <div
                                        class="w-3 h-3 bg-theme-9 position-absolute end-0 bottom-0 rounded-pill border-2 border-white dark-border-dark-3">
                                    </div>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:;"
                                            class="fw-medium truncate me-5 dark-text-gray-300">Robert De Niro</a>
                                        <div class="fs-xs text-gray-500 ms-auto text-nowrap">01:10 PM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">Lorem Ipsum is simply dummy text
                                        of the printing and typesetting industry. Lorem Ipsum has been the
                                        industry&#039;s standard dummy text ever since the 1500</div>
                                </div>
                            </div>
                            <div class="cursor-pointer position-relative d-flex align-items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit me-1">
                                    <img alt="Rubick Bootstrap HTML Admin Template" class="rounded-pill"
                                        src="{{ asset('dist/images/profile-3.jpg') }}">
                                    <div
                                        class="w-3 h-3 bg-theme-9 position-absolute end-0 bottom-0 rounded-pill border-2 border-white dark-border-dark-3">
                                    </div>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:;"
                                            class="fw-medium truncate me-5 dark-text-gray-300">Angelina Jolie</a>
                                        <div class="fs-xs text-gray-500 ms-auto text-nowrap">06:05 AM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact
                                        that a reader will be distracted by the readable content of a page when looking
                                        at its layout. The point of using Lorem </div>
                                </div>
                            </div>
                            <div class="cursor-pointer position-relative d-flex align-items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit me-1">
                                    <img alt="Rubick Bootstrap HTML Admin Template" class="rounded-pill"
                                        src="{{ asset('dist/images/profile-5.jpg') }}">
                                    <div
                                        class="w-3 h-3 bg-theme-9 position-absolute end-0 bottom-0 rounded-pill border-2 border-white dark-border-dark-3">
                                    </div>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:;"
                                            class="fw-medium truncate me-5 dark-text-gray-300">Robert De Niro</a>
                                        <div class="fs-xs text-gray-500 ms-auto text-nowrap">05:09 AM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact
                                        that a reader will be distracted by the readable content of a page when looking
                                        at its layout. The point of using Lorem </div>
                                </div>
                            </div>
                            <div class="cursor-pointer position-relative d-flex align-items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit me-1">
                                    <img alt="Rubick Bootstrap HTML Admin Template" class="rounded-pill"
                                        src="{{ asset('dist/images/profile-1.jpg') }}">
                                    <div
                                        class="w-3 h-3 bg-theme-9 position-absolute end-0 bottom-0 rounded-pill border-2 border-white dark-border-dark-3">
                                    </div>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:;"
                                            class="fw-medium truncate me-5 dark-text-gray-300">Bruce Willis</a>
                                        <div class="fs-xs text-gray-500 ms-auto text-nowrap">03:20 PM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">Lorem Ipsum is simply dummy text
                                        of the printing and typesetting industry. Lorem Ipsum has been the
                                        industry&#039;s standard dummy text ever since the 1500</div>
                                </div>
                            </div>
                            <div class="cursor-pointer position-relative d-flex align-items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit me-1">
                                    <img alt="Rubick Bootstrap HTML Admin Template" class="rounded-pill"
                                        src="{{ asset('dist/images/profile-5.jpg') }}">
                                    <div
                                        class="w-3 h-3 bg-theme-9 position-absolute end-0 bottom-0 rounded-pill border-2 border-white dark-border-dark-3">
                                    </div>
                                </div>
                                <div class="ms-2 overflow-hidden">
                                    <div class="d-flex align-items-center">
                                        <a href="javascript:;"
                                            class="fw-medium truncate me-5 dark-text-gray-300">Kevin Spacey</a>
                                        <div class="fs-xs text-gray-500 ms-auto text-nowrap">01:10 PM</div>
                                    </div>
                                    <div class="w-full truncate text-gray-600 mt-0.5">It is a long established fact
                                        that a reader will be distracted by the readable content of a page when looking
                                        at its layout. The point of using Lorem </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- END: Notifications -->
                <!-- BEGIN: Account Menu -->
                <div class="intro-x dropdown w-8 h-8">
                    <div class="dropdown-toggle w-8 h-8 rounded-pill overflow-hidden shadow-lg image-fit zoom-in"
                        role="button" aria-expanded="false" data-bs-toggle="dropdown">
                        <img alt="User"
                            src="{{ isset(auth()->user()->image) ? asset('storage/user/' . auth()->user()->image) : asset('storage/placeholder/profile.png') }}">
                    </div>
                    <div class="dropdown-menu w-56">
                        <ul class="dropdown-content bg-theme-26 dark-bg-dark-6 text-white">
                            <li class="p-2">
                                <div class="fw-medium text-white">{{ auth()->user()->name }}</div>
                                <div class="fs-xs text-theme-28 mt-0.5 dark-text-gray-600">
                                    {{ auth()->user()->roles[0]->name }}
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-theme-27 dark-border-dark-3">
                            </li>
                            <li>
                                <a href="{{ Route('userProfile') }}"
                                    class="dropdown-item text-white bg-theme-1-hover dark-bg-dark-3-hover"> <i
                                        data-feather="user" class="w-4 h-4 me-2"></i> Profile </a>
                            </li>
                            <li>
                                <a href="{{ Route('userProfile') }}"
                                    class="dropdown-item text-white bg-theme-1-hover dark-bg-dark-3-hover"> <i
                                        data-feather="lock" class="w-4 h-4 me-2"></i> Reset Password </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-theme-27 dark-border-dark-3">
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item text-white bg-theme-1-hover dark-bg-dark-3-hover"> <i
                                        data-feather="toggle-right" class="w-4 h-4 me-2"></i> {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Account Menu -->
            </div>
            <!-- END: Top Bar -->
            <div class="grid columns-12 gap-6">
                @yield('main_content')
            </div>
        </div>
        <!-- END: Content -->
    </div>
    <!-- BEGIN: Dark Mode Switcher-->
    <div
        class="shadow-md position-fixed bottom-0 end-0 box dark-bg-dark-2 border rounded-pill w-md-40 h-12 d-flex align-items-center px-3 px-md-4 z-50 mb-10 me-10">
        {{-- <div class="me-4 text-gray-700 dark-text-gray-300">Dark Mode</div> --}}
        <label class="form-check-label cursor-pointer dark-text-gray-300 d-md-block d-none"
            for="dark_mood_switch">Dark Mode</label>
        <div class="form-check form-switch">
            <input id="dark_mood_switch" class="form-check-input cursor-pointer dark_mood_switch" type="checkbox">
        </div>
    </div>
    <!-- END: Dark Mode Switcher-->
    <!-- BEGIN: JS Assets-->
    <script src="{{ asset('dist/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dist/js/popper.min.js') }}"></script>
    <script src="{{ asset('dist/js/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('dist/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('dist/js/mdtimepicker.min.js') }}"></script>
    <script src="{{ asset('dist/js/boxicons.js') }}"></script>
    <script src="{{ asset('dist/js/moment.min.js') }}"></script>
    <script src="{{ asset('dist/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('dist/js/script.js') }}"></script>
    <!-- END: JS Assets-->
    <!-- START: Custom JS-->
    <script>
        // PreLoader
        window.onload = function() {
            document.querySelector("#preloader").style.display = "none";
            document.querySelector("#overlayer").style.display = "none";
        }

        // Jquery Codes
        $(document).ready(function() {
            $("#dark_mood_switch").on('change', function() {
                darkmode = localStorage.getItem('darkmode')
                console.log(darkmode)
                if (darkmode != 'enable') {
                    $('html').addClass('dark')
                    $('html').removeClass('light')
                    darkmode = localStorage.setItem('darkmode', 'enable')
                } else {
                    $('html').removeClass('dark')
                    $('html').addClass('light')
                    darkmode = localStorage.setItem('darkmode', null)
                }
            })

            // Live Search
            $("#liveSearch").on('keyup', function() {
                let search = $(this).val()
                if (search.length > 0) {
                    // $(".search-result").removeClass('show')
                    $(".search-result").css('opacity', 1)
                    $(".search-result").css('visibility', 'visible')

                    $.ajax({
                        url: "{{ Route('accounts.search.live') }}",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: {
                            search: search
                        },
                        dataType: "JSON",
                        success: function(data) {
                            console.table(data)
                            var searchTearm = []
                            $.each(data, function(key, value) {
                                let img = ""
                                let url = ""
                                img = "{{ asset('storage/register/:image') }}"
                                img = img.replace(':image', value.client_image)
                                url =
                                    "{{ Route('accounts', ['name' => 'accountName', 'id' => 'accountID']) }}"
                                url = url.replace('accountName', value.name)
                                url = url.replace('accountID', value.id)

                                searchTearm +=
                                    '<a href="' + url +
                                    '" class="d-flex align-items-center mt-2"><div class="w-8 h-8 image-fit"><img alt="Rubick Tailwind HTML Admin Template" class="rounded-circle" src="' +
                                    img + '"></div><div class="ms-3">' +
                                    value.name +
                                    '</div><div class="ms-auto w-48 truncate text-gray-600 fs-xs text-end">' +
                                    value.acc_no +
                                    '</div></a>'
                            })
                            $("#liveSearchtearm").html('')
                            $("#liveSearchtearm").html(searchTearm)
                            console.log(searchTearm)
                        }
                    })
                } else {
                    $(".search-result").css('opacity', 0)
                    $(".search-result").css('visibility', 'hidden')
                }
            })

            /**
             * Get ALl Divition
             */
            function divisions(division) {
                $.ajax({
                    url: "{{ asset('json/bd-divisions.json') }}",
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        var divisions = "<option disabled selected>Choose a Division...</option>"
                        $.each(data.divisions, function(key, value) {
                            divisions += "<option data-id='" + value.id + "' value='" +
                                value.name + "'>" + value.name +
                                "</option>"
                        })
                        $("#" + division).html('')
                        $("#" + division).html(divisions)
                    }
                })
            }

            /**
             * Get ALl District
             */
            function districts(district, division_id = null) {
                $.ajax({
                    url: "{{ asset('json/bd-districts.json') }}",
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        var districts =
                            "<option disabled selected>Choose a Districts...</option>"
                        $.each(data.districts, function(key, value) {
                            if (value.division_id == division_id) {
                                districts += "<option data-id='" + value.id +
                                    "' value='" +
                                    value.name + "'>" + value.name +
                                    "</option>"
                            }
                        })
                        $("#" + district).html('')
                        $("#" + district).html(districts)
                    }
                })
            }

            /**
             * Get ALl Upazila
             * Get ALl Post Codes
             */
            function policePost(postcode, district_id) {
                /**
                 * Get ALl Post Codes
                 */
                $.ajax({
                    url: "{{ asset('json/bd-postcodes.json') }}",
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        // console.table(data.districts)
                        var postcodes =
                            "<option disabled selected>Choose a Post Code...</option>"
                        $.each(data.postcodes, function(key, value) {
                            if (value.district_id == district_id) {
                                postcodes += "<option value='" +
                                    value.postOffice + ' - ' + value.postCode + "'>" +
                                    value
                                    .postOffice + ' - ' + value.postCode +
                                    "</option>"
                            }
                        })
                        $("#" + postcode).html('')
                        $("#" + postcode).html(postcodes)
                    }
                })
            }
            @yield('customFunctions')
        })
    </script>
    @yield('customJS')
    <!-- END: Custom JS-->
</body>

</html>
