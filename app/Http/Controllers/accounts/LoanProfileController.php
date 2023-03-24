<?php

namespace App\Http\Controllers\accounts;

use Carbon\Carbon;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\LoanCollection;
use App\Models\LoanProfileCheck;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LoanSavingWithdrawal;
use App\Models\LoansToLoansTransaction;
use App\Models\LoansToSavingsTransaction;
use App\Models\SavingsToLoansTransaction;
use Illuminate\Support\Facades\Validator;

class LoanProfileController extends Controller
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
    public function index($name = null, $id)
    {
        if (isset(request()->startDate) && isset(request()->endDate)) {
            $startDate = Carbon::parse(request()->startDate)->startOfDay();
            $endDate = Carbon::parse(request()->endDate)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfDay();
        }

        // Get Register
        $account = LoanProfile::withTrashed()
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name')
            ->with('ClientRegister:id,name,mobile,client_image')
            ->find(
                $id,
                ['id', 'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'client_id', 'acc_no', 'start_date', 'duration_date', 'deposit', 'loan_given', 'total_installment', 'interest', 'total_interest', 'total_loan_inc_int', 'loan_installment', 'interest_installment', 'installment_recovered', 'total_withdrawal', 'balance', 'loan_recovered', 'loan_remaining', 'interest_recovered', 'interest_remaining', 'status']
            );

        // // Installment
        $totalWithdrawal = LoanSavingWithdrawal::withTrashed()->where('status', '!=', '2')->where('loan_profile_id', $id)->count();
        $lastCheck = LoanProfileCheck::where('loan_profile_id', $id)->orderBy('created_at', 'DESC')->first('created_at');

        $toLoanTrans = LoansToLoansTransaction::where('status', '1')->where('from_loan_profile_id', $id)->count();
        $fromLoanTrans = LoansToLoansTransaction::where('status', '1')->where('to_loan_profile_id', $id)->count();
        $fromSavingTrans = SavingsToLoansTransaction::where('status', '1')->where('to_loan_profile_id', $id)->count();
        $ToSavingTrans = LoansToSavingsTransaction::where('status', '1')->where('from_loan_profile_id', $id)->count();
        $totalTransaction = ($toLoanTrans + $fromLoanTrans + $fromSavingTrans + $ToSavingTrans);

        // Account Past Balance
        $loanSavingsCollectionSum = LoanCollection::withTrashed()
            ->where('status', '!=', '2')
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->where('loan_profile_id', $id)
            ->sum('deposit');

        $loanSavingsWithdrawalSum = LoanSavingWithdrawal::withTrashed()
            ->where('status', '!=', '2')
            ->where('loan_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('withdraw');

        $transToLoansSum = LoansToLoansTransaction::where('status', '!=', '2')
            ->where('from_loan_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $transFromLoansSum = LoansToLoansTransaction::where('status', '!=', '2')
            ->where('to_loan_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $transfromSavingsSum = SavingsToLoansTransaction::where('status', '!=', '2')
            ->where('to_loan_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $transToSavingsSum = LoansToSavingsTransaction::where('status', '!=', '2')
            ->where('from_loan_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $loanCollectionSum = LoanCollection::withTrashed()
            ->where('status', '!=', '2')
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->where('loan_profile_id', $id)
            ->sum('loan');

        $interestCollectionSum = LoanCollection::withTrashed()
            ->where('status', '!=', '2')
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->where('loan_profile_id', $id)
            ->sum('interest');

        // Statement Union Query
        $loanCollection = LoanCollection::withTrashed()
            ->where('status', '!=', '2')
            ->where('loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                'deposit',
                DB::raw('0 as withdraw'),
                'loan',
                'interest',
                'expression',
                'created_at',
                DB::raw('"Deposit" as type')
            );

        $loanSavingsWithdrawal = LoanSavingWithdrawal::withTrashed()
            ->where('status', '!=', '2')
            ->where('loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                DB::raw('0 as deposit'),
                'withdraw',
                DB::raw('0 as loan'),
                DB::raw('0 as interest'),
                'expression',
                'created_at',
                DB::raw('"Withdrawal" as type')
            );

        $transToLoans = LoansToLoansTransaction::where('status', '!=', '2')
            ->where('from_loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                DB::raw('0 as deposit'),
                'amount as withdraw',
                DB::raw('0 as loan'),
                DB::raw('0 as interest'),
                'expression',
                'created_at',
                DB::raw('"Transaction to Loan Account" as type')
            );

        $transFromLoans = LoansToLoansTransaction::where('status', '!=', '2')
            ->where('to_loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                'amount as deposit',
                DB::raw('0 as withdraw'),
                DB::raw('0 as loan'),
                DB::raw('0 as interest'),
                'expression',
                'created_at',
                DB::raw('"Transaction from Loan Account" as type')
            );

        $transFromSavings = SavingsToLoansTransaction::where('status', '!=', '2')
            ->where('to_loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                'amount as deposit',
                DB::raw('0 as withdraw'),
                DB::raw('0 as loan'),
                DB::raw('0 as interest'),
                'expression',
                'created_at',
                DB::raw('"Transaction from Saving Account" as type')
            );

        $transToSavings = LoansToSavingsTransaction::where('status', '!=', '2')
            ->where('from_loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                DB::raw('0 as deposit'),
                'amount as withdraw',
                DB::raw('0 as loan'),
                DB::raw('0 as interest'),
                'expression',
                'created_at',
                DB::raw('"Transaction to Saving Account" as type')
            );

        $statements = $loanCollection
            ->union($loanSavingsWithdrawal)
            ->union($transToLoans)
            ->union($transFromLoans)
            ->union($transFromSavings)
            ->union($transToSavings)
            ->with('User:id,name')
            ->orderby('created_at')
            ->get();

        $accountBalance = ($loanSavingsCollectionSum + $transFromLoansSum + $transfromSavingsSum) - ($loanSavingsWithdrawalSum + $transToSavingsSum + $transToLoansSum);

        // Account Loan collections
        $loanCollectionTables = LoanCollection::withTrashed()
            ->where('status', '!=', '2')
            ->where('loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->select(
                'id',
                'officer_id',
                'installment',
                'deposit',
                'loan',
                'interest',
                'total',
                'expression',
                'created_at'
            )
            ->paginate(30)
            ->withQueryString();

        // Account Withdrawal
        $loanSavingsWithdrawalTables = LoanSavingWithdrawal::withTrashed()
            ->where('status', '!=', '2')
            ->where('loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->select(
                'id',
                'officer_id',
                'withdraw',
                'expression',
                'created_at'
            )
            ->paginate(30)
            ->withQueryString();

        // Account check Table
        $accountCheckTables = LoanProfileCheck::where('loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->select(
                'id',
                'officer_id',
                'balance',
                'loan_recovered',
                'loan_remaining',
                'interest_recovered',
                'interest_remaining',
                'expression',
                'created_at'
            )
            ->orderBy('created_at')
            ->paginate(30)
            ->withQueryString();

        // Account Transactions
        $transactionToLoans = LoansToLoansTransaction::where('status', '!=', '2')
            ->where('from_loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->with('to_client_register:id,name')
            ->with('to_type:id,name')
            ->select(
                'officer_id',
                'to_client_id',
                DB::raw('0 as deposit'),
                'amount as withdraw',
                'to_acc_no as acc_no',
                'to_type_id',
                'expression',
                'created_at',
                DB::raw('"Sanded to Loan Account" as type')
            );

        $tarnsactionFromLoans = LoansToLoansTransaction::where('status', '!=', '2')
            ->where('to_loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->with('from_client_register:id,name')
            ->with('from_type:id,name')
            ->select(
                'officer_id',
                'from_client_id',
                'amount as deposit',
                DB::raw('0 as withdraw'),
                'from_acc_no as acc_no',
                'from_type_id',
                'expression',
                'created_at',
                DB::raw('"Received from Loan Account" as type')
            );

        $transactionFromSavings = SavingsToLoansTransaction::where('status', '!=', '2')
            ->where('to_loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->with('from_client_register:id,name')
            ->with('from_type:id,name')
            ->select(
                'officer_id',
                'from_client_id',
                'amount as deposit',
                DB::raw('0 as withdraw'),
                'from_acc_no as acc_no',
                'from_type_id',
                'expression',
                'created_at',
                DB::raw('"Received from Saving Account" as type')
            );

        $transactionToSavings = LoansToSavingsTransaction::where('status', '!=', '2')
            ->where('from_loan_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->with('to_client_register:id,name')
            ->with('to_type:id,name')
            ->select(
                'officer_id',
                'to_client_id',
                DB::raw('0 as deposit'),
                'amount as withdraw',
                'to_acc_no as acc_no',
                'to_type_id',
                'expression',
                'created_at',
                DB::raw('"Sanded to Saving Account" as type')
            );

        $transactionTable = $transactionToLoans
            ->union($tarnsactionFromLoans)
            ->union($transactionFromSavings)
            ->union($transactionToSavings)
            ->orderby('created_at')
            ->paginate(30)
            ->withQueryString();

        // dd($transactionTable->toArray());

        return view('offices.accounts.stm.loanProfile', compact('account', 'totalWithdrawal', 'totalTransaction', 'lastCheck', 'statements', 'accountBalance', 'loanCollectionSum', 'interestCollectionSum', 'loanCollectionTables', 'loanSavingsWithdrawalTables', 'transactionTable', 'accountCheckTables'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accCheck(Request $request, $id)
    {
        LoanProfileCheck::create(
            [
                'loan_profile_id' => $id,
                'officer_id' => auth()->user()->id,
                'acc_no' => $request->acc_no,
                'balance' => $request->balance,
                'loan_recovered' => $request->loan_recovered,
                'loan_remaining' => $request->loan_remaining,
                'interest_recovered' => $request->interest_recovered,
                'interest_remaining' => $request->interest_remaining,
                'expression' => $request->description
            ]
        );

        return back()->with('success', 'Account Checked Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $collection = LoanCollection::with('LoanProfile:id,total_deposit,balance,installment_recovered,loan_recovered,interest_recovered')
            ->find($request->id, ['id', 'loan_profile_id', 'installment', 'deposit', 'loan', 'interest', 'total', 'expression']);

        return response()->json($collection);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $loan_id)
    {
        // Validate Data
        $validate = Validator::make(
            $request->all(),
            [
                'past_installment' => 'required|numeric',
                'present_balance' => 'required|numeric',
                'past_loan_recovery' => 'required|numeric',
                'past_interest_recovery' => 'required|numeric',
                'installment' => 'required|numeric',
                'loan' => 'required|numeric',
                'interest' => 'required|numeric',
                'total' => 'required|numeric',
                'present_total_deposit' => 'required|numeric',
                'present_installment' => 'required|numeric',
                'present_loan_recovery' => 'required|numeric',
                'present_interest_recovery' => 'required|numeric',
                'deposit' => 'required|numeric'
            ],
            [
                'present_balance.required' => 'The Balance field is required.'
            ]
        );

        // Return Validation message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            DB::transaction(function () use ($request, $id, $loan_id) {
                LoanProfile::find($loan_id)
                    ->update(
                        [
                            "installment_recovered" => $request->present_installment,
                            "total_deposit" => $request->present_total_deposit,
                            "loan_recovered" => $request->present_loan_recovery,
                            "interest_recovered" => $request->present_interest_recovery,
                        ]
                    );

                LoanCollection::find($id)
                    ->update(
                        [
                            "installment" => $request->installment,
                            "deposit" => $request->deposit,
                            "loan" => $request->loan,
                            "interest" => $request->interest,
                            "total" => $request->total,
                            "expression" => $request->description
                        ]
                    );
            });

            return response()->json(['success' => true, 'message' => 'Update successfull']);
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
        DB::transaction(function () use ($id) {
            $collection  = LoanCollection::find($id, ['loan_profile_id', 'installment', 'deposit', 'loan', 'interest']);

            LoanProfile::find($collection->loan_profile_id)
                ->update(
                    [
                        "installment_recovered" => DB::raw('installment_recovered - "' . $collection->installment . '"'),
                        "total_deposit" => DB::raw('total_deposit - "' . $collection->deposit . '"'),
                        "loan_recovered" => DB::raw('loan_recovered - "' . $collection->loan . '"'),
                        "interest_recovered" => DB::raw('interest_recovered - "' . $collection->interest . '"'),
                    ]
                );

            LoanCollection::find($id)->delete();
        });
        return response()->json(['success' => true, 'message' => 'Delete successfull']);
    }
}
