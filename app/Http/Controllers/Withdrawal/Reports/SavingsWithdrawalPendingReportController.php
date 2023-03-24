<?php

namespace App\Http\Controllers\Withdrawal\Reports;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\SavingsProfile;
use App\Models\SavingWithdrawal;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SavingsWithdrawalPendingReportController extends Controller
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
     * Get All Savings Withdrawal Pending Types
     * Return View
     */
    public function index()
    {
        $savings = SavingWithdrawal::where('status', '2')
            ->when((!Auth::user()->can('Withdrawal Report View as an Admin')), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->select(DB::raw('SUM(withdraw) AS withdraw, id, type_id'))
            ->with('Type:id,name')
            ->groupBy('type_id')
            ->get();

        return view('offices.withdrawal.reports.savingswithdrawalTypeReport', compact('savings'));
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
            $startDate = Carbon::parse($request->startDate)->startOfDay()->toDateTimeString();
            $endDate = Carbon::parse($request->endDate)->endOfDay()->toDateTimeString();
        }
        if (isset($request->officer)) {
            $officer_id = $request->officer;
        }

        $savings = SavingWithdrawal::where('saving_withdrawals.status', '2')
            ->where('saving_withdrawals.type_id', $type_id)
            ->when(isset($startDate), function ($query) use ($startDate, $endDate) {
                $query->whereBetween('saving_withdrawals.created_at', [$startDate, $endDate]);
            }, function ($query) {
                $query->whereMonth('saving_withdrawals.created_at', date('m'));
                $query->whereYear('saving_withdrawals.created_at', date('Y'));
            })
            ->when(isset($officer_id), function ($query) use ($officer_id) {
                $query->where('saving_withdrawals.officer_id', $officer_id);
            })
            ->when((!Auth::user()->can('Withdrawal Report View as an Admin')), function ($query) {
                $query->where('saving_withdrawals.officer_id', Auth::user()->id);
            })
            ->join('volumes', 'volumes.id', 'saving_withdrawals.volume_id')
            ->join('centers', 'centers.id', 'saving_withdrawals.center_id')
            ->join('client_registers', 'client_registers.id', 'saving_withdrawals.client_id')
            ->join('users', 'users.id', 'saving_withdrawals.officer_id')
            ->get(
                ['saving_withdrawals.id', 'saving_withdrawals.acc_no', 'saving_withdrawals.withdraw', 'saving_withdrawals.balance', 'saving_withdrawals.balance_remaining', 'saving_withdrawals.expression', 'saving_withdrawals.created_at', 'volumes.name AS volume_name', 'centers.name AS center_name', 'client_registers.name AS client_name', 'users.name AS officer_name']
            );

        $type = Type::find($type_id, ['id', 'name']);
        $officers = User::whereNotIn('email', ['admin@gmail.com'])
            ->where('status', '1')
            ->get();

        return view('offices.withdrawal.reports.savingsWithdrawalReport', compact('savings', 'type', 'officers'));
    }

    // Delete Savings Withdrawal
    public function delete(Request $request)
    {
        SavingWithdrawal::findOrFail($request->id)->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Get the withdrawal
     * return back
     */
    public function edit(Request $request)
    {
        $savings = SavingWithdrawal::where('id', $request->id)
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
            SavingWithdrawal::find($request->withdrawal_id)
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
            $withdrawals = SavingWithdrawal::whereIn('id', $request->id)
                ->select('id', 'saving_profile_id', 'withdraw')
                ->get();

            // Collection Deposit to account 
            foreach ($withdrawals as $withdrawal) {
                SavingsProfile::find($withdrawal->saving_profile_id)
                    ->update(
                        [
                            'total_withdrawal' => DB::raw('total_withdrawal + "' . $withdrawal->withdraw . '"')
                        ]
                    );
            }

            // Collection Approved
            SavingWithdrawal::whereIn('id', $request->id)->update(['status' => '1']);
        });

        return response()->json(['success' => true]);
    }
}
