<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\LoanCollection;
use App\Models\SavingWithdrawal;
use App\Models\SavingsCollection;
use Illuminate\Support\Facades\DB;
use App\Models\LoanSavingWithdrawal;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalLoan = LoanProfile::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('registration_officer_id', Auth::user()->id);
            })
            ->where('status', '1')
            ->sum('loan_given');

        $totalLoanCollection = LoanCollection::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->where('status', '1')
            ->sum('loan');

        $totalLoanSavingsCollection = LoanCollection::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->where('status', '1')
            ->sum('deposit');

        $totalSavingsCollection = SavingsCollection::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->where('status', '1')
            ->sum('deposit');

        $savingsCollections = SavingsCollection::whereDate('created_at', date('Y-m-d'))
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('ClientRegister:id,name')
            ->with('User:id,name')
            ->select('id', 'volume_id', 'center_id', 'type_id', 'officer_id', 'client_id', 'acc_no', 'deposit', 'expression', 'created_at')
            ->get();

        $loanCollections = LoanCollection::whereDate('created_at', date('Y-m-d'))
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('ClientRegister:id,name')
            ->with('User:id,name')
            ->select('id', 'volume_id', 'center_id', 'type_id', 'officer_id', 'client_id', 'acc_no', 'deposit', 'loan', 'interest', 'total', 'expression', 'created_at')
            ->get();

        $officers = User::whereNotIn('email', ['admin@gmail.com'])
            ->where('status', '1')
            ->with(
                [
                    'SavingsCollection' => function ($query) {
                        $query->whereDate('created_at', date('Y-m-d'));
                        $query->select(DB::raw('IFNULL(sum(deposit),0) as deposit,id,officer_id'));
                    },
                    'LoanCollection' => function ($query) {
                        $query->whereDate('created_at', date('Y-m-d'));
                        $query->select(DB::raw('IFNULL(sum(total),0) as total,id,officer_id'));
                    },
                ]
            )
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('id', Auth::user()->id);
            })
            ->get(['id', 'name', 'image']);

        $savingsWithdrawals = SavingWithdrawal::whereDate('created_at', date('Y-m-d'))
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->with('ClientRegister:id,name,client_image')
            ->get(['id', 'acc_no', 'client_id', 'withdraw']);

        $loanSavingsWithdrawals = LoanSavingWithdrawal::whereDate('created_at', date('Y-m-d'))
            ->when(!Auth::user()->can('Dashboard View as an Admin'), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->with('ClientRegister:id,name,client_image')
            ->get(['id', 'acc_no', 'client_id', 'withdraw']);

        // dd($officers->toArray());
        return view('offices.dashboard.index', compact('totalLoan', 'totalLoanCollection', 'totalLoanSavingsCollection', 'totalSavingsCollection', 'savingsCollections', 'loanCollections', 'officers', 'savingsWithdrawals', 'loanSavingsWithdrawals'));
    }

    public function permission()
    {
        $permissions = Permission::all()->pluck('group_name');

        return view('permission', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        if (isset($request->new_group_name)) {
            $group_name = $request->new_group_name;
        } else {
            $group_name = $request->group_name;
        }

        Permission::create(
            [
                'name' => $request->name,
                'group_name' => $group_name
            ]
        );

        return back()->with('success', 'success');
    }
}
