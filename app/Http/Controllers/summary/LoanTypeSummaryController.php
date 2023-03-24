<?php

namespace App\Http\Controllers\summary;

use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\LoanCollection;
use App\Http\Controllers\Controller;
use App\Models\LoanSavingWithdrawal;

class LoanTypeSummaryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    // loan savingsType Summary
    public function index($name = null, $id)
    {
        $activeLoans = LoanProfile::where('type_id', $id)->where('status', '1')->count();
        $deactiveLoans = LoanProfile::onlyTrashed()->where('type_id', $id)->count();

        // Colelction / Withdrawal Chart Sum
        $loanCollectionsSum = LoanCollection::loanCollectionsSumChart('type_id', $id, 'loan');
        $loanSavingsCollectionsSum = LoanCollection::loanCollectionsSumChart('type_id', $id, 'deposit');
        $loanSavingsWithdrawalsSum = LoanSavingWithdrawal::loanSavingsWithdrawalSumChart('type_id', $id, 'withdraw');

        // Client Account Admitted / Deactivated Chart SUM
        $loansAdmittedSum = LoanProfile::loanAdmittedSumChart('type_id', $id, '1', 'created_at');
        $loansDeactivetedSum = LoanProfile::loanAdmittedSumChart('type_id', $id, '0', 'deleted_at');

        // Colelction / Withdrawal Chart
        $loanCollections = LoanCollection::loanCollectionsChart('type_id', $id, 'loan');
        $loanSavingsCollections = LoanCollection::loanCollectionsChart('type_id', $id, 'deposit');
        $loanSavingsWithdrawals = LoanSavingWithdrawal::LoanSavingWithdrawalChart('type_id', $id, 'withdraw');

        // Client Account Admitted / Deactivated Chart
        $loansAdmitted = LoanProfile::loansAdmittedChart('type_id', $id, '1', 'created_at');
        $loansDeactiveted = LoanProfile::loansAdmittedChart('type_id', $id, '0', 'deleted_at');

        return view('offices.summary.loanSavingsTypeSummary', compact('activeLoans', 'deactiveLoans', 'loanCollectionsSum', 'loanSavingsCollectionsSum', 'loanSavingsWithdrawalsSum', 'loansAdmittedSum', 'loansDeactivetedSum', 'loanCollections', 'loanSavingsCollections', 'loanSavingsWithdrawals', 'loansAdmitted', 'loansDeactiveted'));
    }

    // Active Savings Accounts
    public function activeloanAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeLoans = LoanProfile::accountLists($id, '1', 'type_id', $limit);

        $name = "Active";

        return view('offices.summary.accounts.loanAccounts', compact('activeLoans', 'name'));
    }

    // Active Savings Accounts
    public function deactiveloanAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeLoans = LoanProfile::accountLists($id, '0', 'type_id', $limit);

        $name = "Deactive";

        return view('offices.summary.accounts.loanAccounts', compact('activeLoans', 'name'));
    }
}
