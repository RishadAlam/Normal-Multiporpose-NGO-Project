<?php

namespace App\Http\Controllers\Withdrawal\Reports;

use App\Models\Type;
use App\Models\User;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LoanSavingWithdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoanSavingsWithdrawalPendingReportController extends Controller
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

    /**
     * Get All Savings Withdrawal Pending Types
     * Return View
     */
    public function index()
    {
        $loans = LoanSavingWithdrawal::where('status', '2')
            ->when((!Auth::user()->can('Withdrawal Report View as an Admin')), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->select(DB::raw('SUM(withdraw) AS withdraw, id, type_id'))
            ->with('Type:id,name')
            ->groupBy('type_id')
            ->get();

        return view('offices.withdrawal.reports.loanSavingswithdrawalTypeReport', compact('loans'));
    }

    /**
     * Get All Savings Withdrawal
     * return view
     */
    public function report(Request $request, $type_id)
    {
        $startDate = null;
        $endDate = null;
        $officer_id = null;
        if (isset($request->startDate)) {
            $startDate = date('Y-m-d', strtotime($request->startDate));
            $endDate = date('Y-m-d', strtotime($request->endDate));
        }
        if (isset($request->officer)) {
            $officer_id = $request->officer;
        }

        $savings = LoanSavingWithdrawal::where('loan_saving_withdrawals.status', '2')
            ->when((!Auth::user()->can('Withdrawal Report View as an Admin')), function ($query) {
                $query->where('loan_saving_withdrawals.officer_id', Auth::user()->id);
            })
            ->where('loan_saving_withdrawals.type_id', $type_id)
            ->when(isset($startDate), function ($query) use ($startDate, $endDate) {
                $query->whereBetween('loan_saving_withdrawals.created_at', [$startDate, $endDate]);
            }, function ($query) {
                $query->whereMonth('loan_saving_withdrawals.created_at', date('m'));
                $query->whereYear('loan_saving_withdrawals.created_at', date('Y'));
            })
            ->when(isset($officer_id), function ($query) use ($officer_id) {
                $query->where('loan_saving_withdrawals.officer_id', $officer_id);
            })
            ->join('volumes', 'volumes.id', 'loan_saving_withdrawals.volume_id')
            ->join('centers', 'centers.id', 'loan_saving_withdrawals.center_id')
            ->join('client_registers', 'client_registers.id', 'loan_saving_withdrawals.client_id')
            ->join('users', 'users.id', 'loan_saving_withdrawals.officer_id')
            ->get(
                ['loan_saving_withdrawals.id', 'loan_saving_withdrawals.acc_no', 'loan_saving_withdrawals.withdraw', 'loan_saving_withdrawals.balance', 'loan_saving_withdrawals.balance_remaining', 'loan_saving_withdrawals.expression', 'loan_saving_withdrawals.created_at', 'volumes.name AS volume_name', 'centers.name AS center_name', 'client_registers.name AS client_name', 'users.name AS officer_name']
            );

        $type = Type::find($type_id, ['id', 'name']);
        $officers = User::whereNotIn('email', ['admin@gmail.com'])
            ->where('status', '1')
            ->get();

        return view('offices.withdrawal.reports.loanSavingWithdrawalReport', compact('savings', 'type', 'officers'));
    }

    // Delete Savings Withdrawal
    public function delete(Request $request)
    {
        LoanSavingWithdrawal::findOrFail($request->id)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Get the withdrawal
     * return back
     */
    public function edit(Request $request)
    {
        $savings = LoanSavingWithdrawal::where('id', $request->id)
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->first(['id', 'client_id', 'volume_id', 'center_id', 'type_id', 'acc_no', 'balance', 'withdraw', 'balance_remaining', 'expression']);

        return response()->json($savings);
    }

    /**
     * Validation Data
     * Get withdrawal
     * Update withdrawal
     * return success
     */
    public function update(Request $request)
    {
        // Validate Data
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required',
                'center' => 'required',
                'acc_no' => 'required|numeric',
                'client_id' => 'required|numeric',
                'withdrawal_id' => 'required|numeric',
                'savingType' => 'required',
                'balance' => 'required|numeric',
                'withdraw' => 'required|numeric',
                'balance_remaining' => 'required|numeric',
                'name' => 'required',
            ],
            [
                'acc_no.required' => 'The account no. field is required.',
            ]
        );

        // Return Validation message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            // Update Collection
            LoanSavingWithdrawal::find($request->withdrawal_id)
                ->update(
                    [
                        'withdraw' => $request->withdraw,
                        'balance_remaining' => $request->balance_remaining,
                        'expression' => $request->description
                    ]
                );

            // Return Success
            return response()->json(['success' => true]);
        }
    }

    /**
     * Saving Withdrawal approve
     * Get Withdrawal Profile Info
     * Withdrawal Deposit to account 
     * Withdrawal Approved
     * Return Success
     */
    public function approve(Request $request)
    {
        DB::transaction(function () use ($request) {

            // Get Collection Profile Info
            $withdrawals = LoanSavingWithdrawal::whereIn('id', $request->id)
                ->select('id', 'loan_profile_id', 'withdraw')
                ->get();

            // Collection Deposit to account 
            foreach ($withdrawals as $withdrawal) {
                LoanProfile::find($withdrawal->loan_profile_id)
                    ->update(
                        [
                            'total_withdrawal' => DB::raw('total_withdrawal + "' . $withdrawal->withdraw . '"')
                        ]
                    );
            }

            // Collection Approved
            LoanSavingWithdrawal::whereIn('id', $request->id)->update(['status' => '1']);
        });

        return response()->json(['success' => true]);
    }
}
