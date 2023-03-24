<?php

namespace App\Http\Controllers\withdrawal;

use App\Models\Type;
use App\Models\User;
use App\Models\Volume;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\SavingsProfile;
use App\Models\SavingWithdrawal;
use App\Http\Controllers\Controller;
use App\Models\LoanSavingWithdrawal;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
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
     *  Get all volume
     * Get all Types
     *  return Regular Savings view file  
     */
    public function showSavingsWithdrawalForm()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $types = Type::where('savings', '1')->where('status', '1')->get(['id', 'name']);
        $users = User::whereNotIn('email', ['admin@gmail.com'])->where('status', '1')->get(['id', 'name']);

        return view('offices.withdrawal.savingsWithdrawal', compact('volumes', 'types', 'users'));
    }

    // GET Savings Information
    public function savingsAccountsInfoLoad(Request $request)
    {
        $accounts = SavingsProfile::where('id', $request->id)
            ->with('ClientRegister:id,name')
            ->first(['acc_no', 'client_id', 'balance']);

        return json_encode($accounts);
    }

    /**
     *  Get all volume
     * Get all Types
     *  return Loan Savings view file  
     */
    public function showLoanSavingsWithdrawalForm()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $types = Type::where('loans', '1')->where('status', '1')->get(['id', 'name']);
        $users = User::whereNotIn('email', ['admin@gmail.com'])->where('status', '1')->get(['id', 'name']);

        return view('offices.withdrawal.loanSavingsWithdrawal', compact('volumes', 'types', 'users'));
    }

    // GET Savings Information
    public function loanSavingsAccountsInfoLoad(Request $request)
    {
        $accounts = LoanProfile::where('id', $request->id)
            ->with('ClientRegister:id,name')
            ->first(['acc_no', 'client_id', 'balance']);

        return json_encode($accounts);
    }

    /**
     * Store Savings Withdrawal
     * Validate Data
     * Return Validation message
     * Store Withdrawal
     */
    public function savingsWithdrawalStore(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'savingType' => 'required|numeric',
                'officers' => 'required|numeric',
                'saving_profile_id' => 'required|numeric',
                'client_id' => 'required|numeric',
                'acc_no' => 'required|numeric',
                'balance' => 'required|numeric',
                'withdraw' => 'required|numeric|gt:0',
                'balance_remaining' => 'required|numeric|min:0'
            ],
            [
                'officers.required' => 'Withdrawal Officer is required',
                'saving_profile_id.required' => 'Account No is required',
                'client_id.required' => 'Name is required'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            SavingWithdrawal::create(
                [
                    'saving_profile_id' => $request->saving_profile_id,
                    'volume_id' => $request->volume,
                    'center_id' => $request->center,
                    'type_id' => $request->savingType,
                    'officer_id' => $request->officers,
                    'client_id' => $request->client_id,
                    'acc_no' => $request->acc_no,
                    'balance' => $request->balance,
                    'withdraw' => $request->withdraw,
                    'balance_remaining' => $request->balance_remaining,
                    'expression' => $request->description,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Balance Withdrawal successfully completed']);
        }
    }

    /**
     * Store Loan Savings Withdrawal
     * Validate Data
     * Return Validation message
     * Store Withdrawal
     */
    public function loanSavingsWithdrawalStore(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'loanType' => 'required|numeric',
                'officers' => 'required|numeric',
                'loan_profile_id' => 'required|numeric',
                'client_id' => 'required|numeric',
                'acc_no' => 'required|numeric',
                'balance' => 'required|numeric',
                'withdraw' => 'required|numeric|gt:0',
                'balance_remaining' => 'required|numeric|min:0'
            ],
            [
                'officers.required' => 'Withdrawal Officer is required',
                'loan_profile_id.required' => 'Account No is required',
                'client_id.required' => 'Name is required'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            LoanSavingWithdrawal::create(
                [
                    'loan_profile_id' => $request->loan_profile_id,
                    'volume_id' => $request->volume,
                    'center_id' => $request->center,
                    'type_id' => $request->loanType,
                    'officer_id' => $request->officers,
                    'client_id' => $request->client_id,
                    'acc_no' => $request->acc_no,
                    'balance' => $request->balance,
                    'withdraw' => $request->withdraw,
                    'balance_remaining' => $request->balance_remaining,
                    'expression' => $request->description,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Balance Withdrawal successfully completed']);
        }
    }
}
