<?php

namespace App\Http\Controllers\summary;

use App\Models\Center;
use App\Models\Volume;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\LoanCollection;
use App\Models\SavingsProfile;
use App\Models\SavingWithdrawal;
use App\Models\SavingsCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LoanSavingWithdrawal;

class VolumeSummaryController extends Controller
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

    // Volume Summary
    public function index($name = null, $id)
    {
        $activeSavings = SavingsProfile::where('volume_id', $id)->where('status', '1')->count();
        $deactiveSavings = SavingsProfile::onlyTrashed()->where('volume_id', $id)->count();

        $activeLoans = LoanProfile::where('volume_id', $id)->where('status', '1')->count();
        $deactiveLoans = LoanProfile::onlyTrashed()->where('volume_id', $id)->count();

        // Colelction / Withdrawal Chart Sum
        $savingCollectionsSum = SavingsCollection::savingCollectionsSumChart('volume_id', $id);
        $savingWithdrawalsSum = SavingWithdrawal::savingWithdrawalSumChart('volume_id', $id);
        $loanCollectionsSum = LoanCollection::loanCollectionsSumChart('volume_id', $id, 'loan');
        $loanSavingsCollectionsSum = LoanCollection::loanCollectionsSumChart('volume_id', $id, 'deposit');
        $loanSavingsWithdrawalsSum = LoanSavingWithdrawal::loanSavingsWithdrawalSumChart('volume_id', $id, 'withdraw');

        // Client Account Admitted / Deactivated Chart SUM
        $savingsAdmittedSum = SavingsProfile::savingAdmittedSumChart('volume_id', $id, '1', 'created_at');
        $savingsDeactivetedSum = SavingsProfile::savingAdmittedSumChart('volume_id', $id, '0', 'deleted_at');
        $loansAdmittedSum = LoanProfile::loanAdmittedSumChart('volume_id', $id, '1', 'created_at');
        $loansDeactivetedSum = LoanProfile::loanAdmittedSumChart('volume_id', $id, '0', 'deleted_at');

        // Colelction / Withdrawal Chart
        $savingCollections = SavingsCollection::savingCollectionsChart('volume_id', $id);
        $savingWithdrawals = SavingWithdrawal::savingWithdrawalChart('volume_id', $id);
        $loanCollections = LoanCollection::loanCollectionsChart('volume_id', $id, 'loan');
        $loanSavingsCollections = LoanCollection::loanCollectionsChart('volume_id', $id, 'deposit');
        $loanSavingsWithdrawals = LoanSavingWithdrawal::LoanSavingWithdrawalChart('volume_id', $id, 'withdraw');

        // Client Account Admitted / Deactivated Chart
        $savingsAdmitted = SavingsProfile::savingsAdmittedChart('volume_id', $id, '1', 'created_at');
        $savingsDeactiveted = SavingsProfile::savingsAdmittedChart('volume_id', $id, '0', 'deleted_at');
        $loansAdmitted = LoanProfile::loansAdmittedChart('volume_id', $id, '1', 'created_at');
        $loansDeactiveted = LoanProfile::loansAdmittedChart('volume_id', $id, '0', 'deleted_at');

        return view('offices.summary.volumeSummary', compact('activeSavings', 'deactiveSavings', 'activeLoans', 'deactiveLoans', 'savingCollectionsSum', 'savingWithdrawalsSum', 'loanCollectionsSum', 'loanSavingsCollectionsSum', 'loanSavingsWithdrawalsSum', 'savingsAdmittedSum', 'savingsDeactivetedSum', 'loansAdmittedSum', 'loansDeactivetedSum', 'savingCollections', 'savingWithdrawals', 'loanCollections', 'loanSavingsCollections', 'loanSavingsWithdrawals', 'savingsAdmitted', 'savingsDeactiveted', 'loansAdmitted', 'loansDeactiveted'));
    }

    // Active Savings Accounts
    public function activeSavingsAccounts($name = null, $id)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeSavings = SavingsProfile::accountLists($id, '1', 'volume_id', $limit);
        $name = "Active";

        return view('offices.summary.accounts.savingAccounts', compact('activeSavings', 'name'));
    }

    // Deactive Savings Accounts
    public function deactiveSavingsAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeSavings = SavingsProfile::accountLists($id, '0', 'volume_id', $limit);
        $name = "Deactive";

        return view('offices.summary.accounts.savingAccounts', compact('activeSavings', 'name'));
    }

    // Active Savings Accounts
    public function activeloanAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeLoans = LoanProfile::accountLists($id, '1', 'volume_id', $limit);

        $name = "Active";

        return view('offices.summary.accounts.loanAccounts', compact('activeLoans', 'name'));
    }

    // Active Savings Accounts
    public function deactiveloanAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeLoans = LoanProfile::accountLists($id, '0', 'volume_id', $limit);

        $name = "Deactive";

        return view('offices.summary.accounts.loanAccounts', compact('activeLoans', 'name'));
    }
}
