<?php

namespace App\Http\Controllers\summary;

use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\LoanCollection;
use App\Models\SavingsProfile;
use App\Models\SavingWithdrawal;
use App\Models\SavingsCollection;
use App\Http\Controllers\Controller;
use App\Models\LoanSavingWithdrawal;

class CenterSummaryController extends Controller
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

    // Center Summary
    public function index($name = null, $id)
    {
        $activeSavings = SavingsProfile::where('center_id', $id)->where('status', '1')->count();
        $deactiveSavings = SavingsProfile::onlyTrashed()->where('center_id', $id)->count();

        $activeLoans = LoanProfile::where('center_id', $id)->where('status', '1')->count();
        $deactiveLoans = LoanProfile::onlyTrashed()->where('center_id', $id)->count();

        // Colelction / Withdrawal Chart Sum
        $savingCollectionsSum = SavingsCollection::savingCollectionsSumChart('center_id', $id);
        $savingWithdrawalsSum = SavingWithdrawal::savingWithdrawalSumChart('center_id', $id);
        $loanCollectionsSum = LoanCollection::loanCollectionsSumChart('center_id', $id, 'loan');
        $loanSavingsCollectionsSum = LoanCollection::loanCollectionsSumChart('center_id', $id, 'deposit');
        $loanSavingsWithdrawalsSum = LoanSavingWithdrawal::loanSavingsWithdrawalSumChart('center_id', $id, 'withdraw');

        // Client Account Admitted / Deactivated Chart SUM
        $savingsAdmittedSum = SavingsProfile::savingAdmittedSumChart('center_id', $id, '1', 'created_at');
        $savingsDeactivetedSum = SavingsProfile::savingAdmittedSumChart('center_id', $id, '0', 'deleted_at');
        $loansAdmittedSum = LoanProfile::loanAdmittedSumChart('center_id', $id, '1', 'created_at');
        $loansDeactivetedSum = LoanProfile::loanAdmittedSumChart('center_id', $id, '0', 'deleted_at');

        // Colelction / Withdrawal Chart
        $savingCollections = SavingsCollection::savingCollectionsChart('center_id', $id);
        $savingWithdrawals = SavingWithdrawal::savingWithdrawalChart('center_id', $id);
        $loanCollections = LoanCollection::loanCollectionsChart('center_id', $id, 'loan');
        $loanSavingsCollections = LoanCollection::loanCollectionsChart('center_id', $id, 'deposit');
        $loanSavingsWithdrawals = LoanSavingWithdrawal::LoanSavingWithdrawalChart('center_id', $id, 'withdraw');

        // Client Account Admitted / Deactivated Chart
        $savingsAdmitted = SavingsProfile::savingsAdmittedChart('center_id', $id, '1', 'created_at');
        $savingsDeactiveted = SavingsProfile::savingsAdmittedChart('center_id', $id, '0', 'deleted_at');
        $loansAdmitted = LoanProfile::loansAdmittedChart('center_id', $id, '1', 'created_at');
        $loansDeactiveted = LoanProfile::loansAdmittedChart('center_id', $id, '0', 'deleted_at');

        return view('offices.summary.centerSummary', compact('activeSavings', 'deactiveSavings', 'activeLoans', 'deactiveLoans', 'savingCollectionsSum', 'savingWithdrawalsSum', 'loanCollectionsSum', 'loanSavingsCollectionsSum', 'loanSavingsWithdrawalsSum', 'savingsAdmittedSum', 'savingsDeactivetedSum', 'loansAdmittedSum', 'loansDeactivetedSum', 'savingCollections', 'savingWithdrawals', 'loanCollections', 'loanSavingsCollections', 'loanSavingsWithdrawals', 'savingsAdmitted', 'savingsDeactiveted', 'loansAdmitted', 'loansDeactiveted'));
    }

    // Active Savings Accounts
    public function activeSavingsAccounts($name = null, $id)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeSavings = SavingsProfile::accountLists($id, '1', 'center_id', $limit);
        $name = "Active";

        return view('offices.summary.accounts.savingAccounts', compact('activeSavings', 'name'));
    }

    // Deactive Savings Accounts
    public function deactiveSavingsAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeSavings = SavingsProfile::accountLists($id, '0', 'center_id', $limit);
        $name = "Deactive";

        return view('offices.summary.accounts.savingAccounts', compact('activeSavings', 'name'));
    }

    // Active Savings Accounts
    public function activeloanAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeLoans = LoanProfile::accountLists($id, '1', 'center_id', $limit);

        $name = "Active";

        return view('offices.summary.accounts.loanAccounts', compact('activeLoans', 'name'));
    }

    // Active Savings Accounts
    public function deactiveloanAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeLoans = LoanProfile::accountLists($id, '0', 'center_id', $limit);

        $name = "Deactive";

        return view('offices.summary.accounts.loanAccounts', compact('activeLoans', 'name'));
    }
}
