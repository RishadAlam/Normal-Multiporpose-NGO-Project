<?php

namespace App\Http\Controllers\summary;

use Illuminate\Http\Request;
use App\Models\SavingsProfile;
use App\Models\SavingWithdrawal;
use App\Models\SavingsCollection;
use App\Http\Controllers\Controller;

class SavingTypeSummaryController extends Controller
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

    // savingsType Summary
    public function index($name = null, $id)
    {
        $activeSavings = SavingsProfile::where('type_id', $id)->where('status', '1')->count();
        $deactiveSavings = SavingsProfile::onlyTrashed()->where('type_id', $id)->count();

        // Colelction / Withdrawal Chart Sum
        $savingCollectionsSum = SavingsCollection::savingCollectionsSumChart('type_id', $id);
        $savingWithdrawalsSum = SavingWithdrawal::savingWithdrawalSumChart('type_id', $id);

        // Client Account Admitted / Deactivated Chart SUM
        $savingsAdmittedSum = SavingsProfile::savingAdmittedSumChart('type_id', $id, '1', 'created_at');
        $savingsDeactivetedSum = SavingsProfile::savingAdmittedSumChart('type_id', $id, '0', 'deleted_at');

        // Colelction / Withdrawal Chart
        $savingCollections = SavingsCollection::savingCollectionsChart('type_id', $id);
        $savingWithdrawals = SavingWithdrawal::savingWithdrawalChart('type_id', $id);

        // Client Account Admitted / Deactivated Chart
        $savingsAdmitted = SavingsProfile::savingsAdmittedChart('type_id', $id, '1', 'created_at');
        $savingsDeactiveted = SavingsProfile::savingsAdmittedChart('type_id', $id, '0', 'deleted_at');

        return view('offices.summary.savingsTypeSummary', compact('activeSavings', 'deactiveSavings', 'savingCollectionsSum', 'savingWithdrawalsSum', 'savingsAdmittedSum', 'savingsDeactivetedSum', 'savingCollections', 'savingWithdrawals', 'savingsAdmitted', 'savingsDeactiveted'));
    }

    // Active Savings Accounts
    public function activeSavingsAccounts($name = null, $id)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeSavings = SavingsProfile::accountLists($id, '1', 'type_id', $limit);
        $name = "Active";

        return view('offices.summary.accounts.savingAccounts', compact('activeSavings', 'name'));
    }

    // Deactive Savings Accounts
    public function deactiveSavingsAccounts($name = null, $id,)
    {
        $limit = isset(request()->limit) ? request()->limit : '25';
        $activeSavings = SavingsProfile::accountLists($id, '0', 'type_id', $limit);
        $name = "Deactive";

        return view('offices.summary.accounts.savingAccounts', compact('activeSavings', 'name'));
    }
}
