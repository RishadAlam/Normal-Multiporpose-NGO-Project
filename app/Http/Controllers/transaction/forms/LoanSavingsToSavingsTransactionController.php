<?php

namespace App\Http\Controllers\transaction\forms;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\User;
use App\Models\Volume;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\SavingsProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LoansToSavingsTransaction;
use Illuminate\Support\Facades\Validator;

class LoanSavingsToSavingsTransactionController extends Controller
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
     * 
     * Get Volume
     * Get Saving Type
     * Get Users
     * Return View
     */
    public function index()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $savingsTypes = Type::where('savings', '1')->where('status', '1')->get(['id', 'name']);
        $loansTypes = Type::where('loans', '1')->where('status', '1')->get(['id', 'name']);
        $users = User::whereNotIn('email', ['admin@gmail.com'])->where('status', '1')->get(['id', 'name']);

        return view('offices.transaction.forms.loanstoSavings', compact('volumes', 'savingsTypes', 'loansTypes', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validation Form
        $validate = Validator::make(
            $request->all(),
            [
                // From
                'formVolume' => 'required|numeric',
                'formCenter' => 'required|numeric',
                'formLoanType' => 'required|numeric',
                'formLoan_profile_id' => 'required|numeric',
                'formClient_id' => 'required|numeric',
                'formAcc_no' => 'required|numeric',
                // 'transactionformBalance' => 'required|numeric|min:0',

                // To
                'toVolume' => 'required|numeric',
                'toCenter' => 'required|numeric',
                'toSavingType' => 'required|numeric',
                'toSaving_profile_id' => 'required|numeric',
                'toClient_id' => 'required|numeric',
                'toAcc_no' => 'required|numeric',
                'transactiontoBalance' => 'required|numeric|min:0',

                // Transaction
                'transactionAmount' => 'required|numeric|gt:0',
                'officers' => 'required|numeric',
            ],
            [
                'toVolume' => 'The volume field is required.',
                'toCenter' => 'The center field is required.',
                'toSavingType' => 'The saving type field is required.',
                'toSaving_profile_id' => 'The account no field is required.',
                'toClient_id' => 'The name field is required.',
                'transactiontoBalance' => 'The balance field is required.',
                'transactiontoBalance.min' => 'The balance must be gratter then 0 or equal.',

                // To
                'formVolume' => 'The volume field is required.',
                'formCenter' => 'The center field is required.',
                'formLoanType' => 'The loan type field is required.',
                'formLoan_profile_id' => 'The account no field is required.',
                'formClient_id' => 'The name field is required.',
                'transactionformBalance' => 'The balance field is required.',
                'transactionformBalance.min' => 'The balance must be gratter then 0 or equal.',
            ]
        );

        // Validation Message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            LoansToSavingsTransaction::create(
                [
                    'from_volume_id' => $request->formVolume,
                    'from_center_id' => $request->formCenter,
                    'from_type_id' => $request->formLoanType,
                    'from_client_id' => $request->formClient_id,
                    'from_loan_profile_id' => $request->formLoan_profile_id,
                    'from_acc_no' => $request->formAcc_no,
                    'from_acc_main_balance' => $request->formBalance,
                    'from_acc_trans_balance' => $request->transactionformBalance,

                    'to_volume_id' => $request->toVolume,
                    'to_center_id' => $request->toCenter,
                    'to_type_id' => $request->toSavingType,
                    'to_client_id' => $request->toClient_id,
                    'to_saving_profile_id' => $request->toSaving_profile_id,
                    'to_acc_no' => $request->toAcc_no,
                    'to_acc_main_balance' => $request->toBalance,
                    'to_acc_trans_balance' => $request->transactiontoBalance,

                    'officer_id' => $request->officers,
                    'amount' => $request->transactionAmount,
                    'expression' => $request->description,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Transaction successfully completed']);
        }
    }

    /**
     * Get All Transaction
     * Get All Officer
     * Report show
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
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

        $transactions = LoansToSavingsTransaction::where('status', '2')
            ->when((!Auth::user()->can('Transaction Report View as an Admin')), function ($query) {
                $query->where('officer_id', Auth::user()->id);
            })
            ->when(isset($officer_id), function ($query) use ($officer_id) {
                $query->where('officer_id', $officer_id);
            })
            ->when(isset($startDate), function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->with('from_client_register', function ($query) {
                $query->select('id', 'name');
            })
            ->with('from_type', function ($query) {
                $query->select('id', 'name');
            })
            ->with('to_client_register', function ($query) {
                $query->select('id', 'name');
            })
            ->with('to_type', function ($query) {
                $query->select('id', 'name');
            })
            ->with('users', function ($query) {
                $query->select('id', 'name');
            })
            ->get(
                ['id', 'from_type_id', 'from_client_id', 'from_acc_no', 'to_type_id', 'to_client_id', 'to_acc_no', 'officer_id', 'amount', 'expression', 'created_at']
            );

        $officers = User::whereNotIn('email', ['admin@gmail.com'])
            ->where('status', '1')
            ->get();

        // dd($transactions->toArray());
        return view('offices.transaction.reports.loanstoSavings', compact('transactions', 'officers'));
    }

    /**
     * Approve the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        DB::transaction(function () use ($request) {

            // Get The Transactions
            $transactions = LoansToSavingsTransaction::whereIn('id', $request->id)
                ->get(['id', 'from_loan_profile_id', 'to_saving_profile_id', 'amount']);

            foreach ($transactions as $transaction) {
                // From Sending Account
                LoanProfile::find($transaction->from_loan_profile_id)
                    ->update(
                        [
                            'total_withdrawal' => DB::raw('total_withdrawal + "' . $transaction->amount . '"')
                        ]
                    );

                // From Recieving Account
                SavingsProfile::find($transaction->to_saving_profile_id)
                    ->update(
                        [
                            'total_deposit' => DB::raw('total_deposit + "' . $transaction->amount . '"')
                        ]
                    );
            }

            // Transaction Approved
            LoansToSavingsTransaction::whereIn('id', $request->id)->update(['status' => '1']);
        });

        return response()->json(['success' => true, 'message' => 'Transaction successfully Approved']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transactions = LoansToSavingsTransaction::with('from_client_register:id,name')
            ->with('to_client_register:id,name')
            ->with('from_type:id,name')
            ->with('to_type:id,name')
            ->with('users:id,name')
            ->find(
                $id,
                ['id', 'from_type_id', 'from_client_id', 'from_acc_no', 'to_type_id', 'to_client_id', 'to_acc_no', 'officer_id', 'amount', 'expression', 'from_acc_main_balance', 'from_acc_trans_balance', 'to_acc_main_balance', 'to_acc_trans_balance']
            );

        return response()->json($transactions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validation Form
        $validate = Validator::make(
            $request->all(),
            [
                // From
                'transactionformBalance' => 'required|numeric|min:0',

                // To
                'transactiontoBalance' => 'required|numeric|min:0',

                // Transaction
                'transactionAmount' => 'required|numeric|gt:0',
            ],
            [
                'transactionformBalance' => 'The balance field is required.',
                'transactionformBalance.min' => 'The balance must be gratter then 0 or equal.',

                // To~
                'transactiontoBalance' => 'The balance field is required.',
                'transactiontoBalance.min' => 'The balance must be gratter then 0 or equal.',
            ]
        );

        // Validation Message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            LoansToSavingsTransaction::find($id)
                ->update(
                    [
                        'from_acc_main_balance' => $request->formBalance,
                        'from_acc_trans_balance' => $request->transactionformBalance,

                        'to_acc_main_balance' => $request->toBalance,
                        'to_acc_trans_balance' => $request->transactiontoBalance,

                        'amount' => $request->transactionAmount,
                        'expression' => $request->description,
                    ]
                );

            return response()->json(['success' => true, 'message' => 'Transaction successfully Updated']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoansToSavingsTransaction::find($id)->delete();

        return response()->json(['success' => true]);
    }
}
