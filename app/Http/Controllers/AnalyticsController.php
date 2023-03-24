<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\User;
use App\Models\Volume;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\LoanCollection;
use App\Models\SavingsProfile;
use App\Models\SavingWithdrawal;
use App\Models\SavingsCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\LoanSavingWithdrawal;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset(request()->startDate) && isset(request()->endDate)) {
            $startDate = Carbon::parse(request()->startDate)->startOfDay();
            $endDate = Carbon::parse(request()->endDate)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfDay();
        }

        // dd($startDate);
        // Savings Collections
        $savings = SavingsCollection::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->savingType) && request()->savingType != 0, function ($query) {
                $query->where('type_id', request()->savingType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->select('id', 'saving_profile_id', 'volume_id', 'center_id', 'type_id', 'officer_id', 'client_id', 'acc_no', 'expression', 'created_at', 'deposit', DB::raw('0 as withdraw'))
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name');

        // Savings Withdrawal
        $withdrawals = SavingWithdrawal::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->savingType) && request()->savingType != 0, function ($query) {
                $query->where('type_id', request()->savingType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->select('id', 'saving_profile_id', 'volume_id', 'center_id', 'type_id', 'officer_id', 'client_id', 'acc_no', 'expression', 'created_at', DB::raw('0 as deposit'), 'withdraw')
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name');

        // Savings Chart
        $savingsChart = SavingsCollection::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->savingType) && request()->savingType != 0, function ($query) {
                $query->where('type_id', request()->savingType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->groupBy('date')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(deposit) as deposit'), DB::raw('0 as withdraw'));

        $withdrawalsChart = SavingWithdrawal::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->savingType) && request()->savingType != 0, function ($query) {
                $query->where('type_id', request()->savingType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->groupBy('date')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('0 as deposit'), DB::raw('sum(withdraw) as withdraw'));

        // Saving Colelction Union
        $collections = $savings->union($withdrawals);
        $totalSavings = $collections->get()->sum('deposit');
        $totalWithdrawals = $collections->get()->sum('withdraw');
        $collectionsChart = $savingsChart->unionAll($withdrawalsChart)->orderBy('date')->get();
        $collectionsList = $collections->orderByDesc('created_at')->paginate('50')->withQueryString();
        // dd($collectionsChart->toArray());

        // Loan Collections
        $Loans = LoanCollection::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->loanType) && request()->loanType != 0, function ($query) {
                $query->where('type_id', request()->loanType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->select('id', 'loan_profile_id', 'volume_id', 'center_id', 'type_id', 'officer_id', 'client_id', 'acc_no', 'expression', 'created_at', 'deposit', DB::raw('0 as withdraw'), 'loan', 'interest', 'total')
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name');

        // Savings Withdrawal
        $LoansWithdrawals = LoanSavingWithdrawal::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->loanType) && request()->loanType != 0, function ($query) {
                $query->where('type_id', request()->loanType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->select('id', 'loan_profile_id', 'volume_id', 'center_id', 'type_id', 'officer_id', 'client_id', 'acc_no', 'expression', 'created_at', DB::raw('0 as deposit'), 'withdraw', DB::raw('0 as loan'), DB::raw('0 as interest'), DB::raw('0 as total'))
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name');

        // Loan Collections CHart
        $LoansChart = LoanCollection::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->loanType) && request()->loanType != 0, function ($query) {
                $query->where('type_id', request()->loanType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->groupBy('date')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(deposit) as deposit'), DB::raw('sum(loan) as loan'), DB::raw('sum(interest) as interest'), DB::raw('0 as withdraw'));

        // Savings Withdrawal
        $LoansWithdrawalsChart = LoanSavingWithdrawal::withTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->loanType) && request()->loanType != 0, function ($query) {
                $query->where('type_id', request()->loanType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->groupBy('date')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('0 as deposit'), DB::raw('0 as loan'), DB::raw('0 as interest'), DB::raw('sum(withdraw) as withdraw'));

        // Loan Collection Union
        $loanCollections = $Loans->union($LoansWithdrawals);
        $totalLoanDeposit = $loanCollections->get()->sum('deposit');
        $totalLoanSavingWithdrawals = $loanCollections->get()->sum('withdraw');
        $totalLoan = $loanCollections->get()->sum('loan');
        $totalInterest = $loanCollections->get()->sum('interest');
        $loanCollectionsChart = $LoansChart->unionAll($LoansWithdrawalsChart)->orderBy('date')->get();
        $loanCollectionsList = $loanCollections->paginate('50')->withQueryString();

        // Savings Admitted
        $savingsAdmitted = SavingsProfile::whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->savingType) && request()->savingType != 0, function ($query) {
                $query->where('type_id', request()->savingType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('registration_officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->select('id', 'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'client_id', 'acc_no', DB::raw('created_at as date'), 'deposit', 'interest', DB::raw('"Admitted" as status'))
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name');

        // Savings Admitted
        $savingsclossed = SavingsProfile::onlyTrashed()
            ->whereBetween('deleted_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->savingType) && request()->savingType != 0, function ($query) {
                $query->where('type_id', request()->savingType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('registration_officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->select('id', 'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'client_id', 'acc_no', DB::raw('deleted_at as date'), 'deposit', 'interest', DB::raw('"Closing" as status'))
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name');

        // Savings Count
        $savingsAdmitCount = SavingsProfile::whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->savingType) && request()->savingType != 0, function ($query) {
                $query->where('type_id', request()->savingType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('registration_officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->groupBy('date')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as Admitted'), DB::raw('0 as Closed'));

        // Savings Count
        $savingsClosedCount = SavingsProfile::onlyTrashed()
            ->whereBetween('deleted_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->savingType) && request()->savingType != 0, function ($query) {
                $query->where('type_id', request()->savingType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('registration_officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->groupBy('date')
            ->select(DB::raw('DATE(deleted_at) as date'), DB::raw('0 as Admitted'), DB::raw('count(*) as Closed'));

        // Saving Addmitted Union
        $SavingsUnion = $savingsAdmitted->union($savingsclossed);
        $SavingsUnionChart = $savingsAdmitCount->union($savingsClosedCount)->orderBy('date')->get();
        $totalSavingsAdmitted = $savingsAdmitted->count();
        $totalSavingsClossed = $savingsclossed->count();
        $SavingsUnionList = $SavingsUnion->paginate('50')->withQueryString();

        // Loan Admitted
        $loanAdmitted = LoanProfile::whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->loanType) && request()->loanType != 0, function ($query) {
                $query->where('type_id', request()->loanType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('registration_officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->select('id', 'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'client_id', 'acc_no', DB::raw('created_at as date'), 'loan_given', 'interest', DB::raw('"Admitted" as status'))
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name');

        // loan Admitted
        $loanclossed = LoanProfile::onlyTrashed()
            ->whereBetween('deleted_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->loanType) && request()->loanType != 0, function ($query) {
                $query->where('type_id', request()->loanType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('registration_officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->select('id', 'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'client_id', 'acc_no', DB::raw('deleted_at as date'), 'loan_given', 'interest', DB::raw('"Closing" as status'))
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name');

        // loan Count
        $loanAdmitCount = LoanProfile::whereBetween('created_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->loanType) && request()->loanType != 0, function ($query) {
                $query->where('type_id', request()->loanType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('registration_officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->groupBy('date')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as Admitted'), DB::raw('0 as Closed'));

        // loan Count
        $loanClosedCount = LoanProfile::onlyTrashed()
            ->whereBetween('deleted_at', [$startDate, $endDate])
            ->when(isset(request()->volume) && request()->volume != 0, function ($query) {
                $query->where('volume_id', request()->volume);
            })
            ->when(isset(request()->center) && request()->center != 0, function ($query) {
                $query->where('center_id', request()->center);
            })
            ->when(isset(request()->loanType) && request()->loanType != 0, function ($query) {
                $query->where('type_id', request()->loanType);
            })
            ->when(isset(request()->officers) && request()->officers != 0, function ($query) {
                $query->where('registration_officer_id', request()->officers);
            })
            ->when(!Auth::user()->can('Analytics View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->groupBy('date')
            ->select(DB::raw('DATE(deleted_at) as date'), DB::raw('0 as Admitted'), DB::raw('count(*) as Closed'));

        // Loan Addmitted Union
        $loanUnion = $loanAdmitted->union($loanclossed);
        $loanUnionChart = $loanAdmitCount->union($loanClosedCount)->orderBy('date')->get();
        $totalLoanAdmitted = $loanAdmitted->count();
        $totalLoanclossed = $loanclossed->count();
        $loanUnionList = $loanUnion->paginate('50')->withQueryString();

        // Filter
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $savingsTypes = Type::where('savings', '1')->where('status', '1')->get(['id', 'name']);
        $loanTypes = Type::where('loans', '1')->where('status', '1')->get(['id', 'name']);
        $users = User::whereNotIn('email', ['admin@gmail.com'])->where('status', '1')->get(['id', 'name']);
        // dd($loanUnionChart->toArray());

        return view('offices.analytics.analytics', compact('totalSavings', 'totalWithdrawals', 'collectionsChart', 'collectionsList', 'totalLoanDeposit', 'totalLoanSavingWithdrawals', 'totalLoan', 'totalInterest', 'loanCollectionsChart', 'loanCollectionsList', 'totalSavingsAdmitted', 'totalSavingsClossed', 'SavingsUnionChart', 'SavingsUnionList', 'totalLoanAdmitted', 'totalLoanclossed', 'loanUnionChart', 'loanUnionList', 'volumes', 'savingsTypes', 'loanTypes', 'users'));
    }
}
