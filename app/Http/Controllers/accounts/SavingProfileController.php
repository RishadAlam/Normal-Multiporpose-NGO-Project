<?php

namespace App\Http\Controllers\accounts;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ClientRegister;
use App\Models\SavingsProfile;
use App\Models\SavingWithdrawal;
use App\Models\SavingsCollection;
use Illuminate\Support\Facades\DB;
use App\Models\SavingsProfileCheck;
use App\Http\Controllers\Controller;
use App\Models\LoansToSavingsTransaction;
use App\Models\SavingsToLoansTransaction;
use Illuminate\Support\Facades\Validator;
use App\Models\SavingsToSavingsTransaction;
use App\Http\Controllers\transaction\forms\LoanSavingsToSavingsTransactionController;

class SavingProfileController extends Controller
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
        $account = SavingsProfile::withTrashed()
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->with('User:id,name')
            ->with('ClientRegister:id,name,mobile,client_image')
            ->find($id, ['id', 'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'client_id', 'acc_no', 'start_date', 'duration_date', 'deposit', 'installment', 'total_except_interest', 'interest', 'total_include_interest', 'total_withdrawal', 'balance', 'status']);

        // Installment
        $totalInstallment = SavingsCollection::withTrashed()->where('status', '!=', '2')->where('saving_profile_id', $id)->count();
        $totalWithdrawal = SavingWithdrawal::withTrashed()->where('status', '!=', '2')->where('saving_profile_id', $id)->count();
        $lastCheck = SavingsProfileCheck::where('saving_profile_id', $id)->orderBy('created_at', 'DESC')->first('created_at');

        $toSavingsTrans = SavingsToSavingsTransaction::where('status', '1')->where('from_saving_profile_id', $id)->count();
        $fromSavingsTrans = SavingsToSavingsTransaction::where('status', '1')->where('to_saving_profile_id', $id)->count();
        $ToLoansTrans = SavingsToLoansTransaction::where('status', '1')->where('from_saving_profile_id', $id)->count();
        $FromLoansTrans = LoansToSavingsTransaction::where('status', '1')->where('to_saving_profile_id', $id)->count();
        $totalTransaction = ($toSavingsTrans + $fromSavingsTrans + $ToLoansTrans + $FromLoansTrans);

        // Account Past Balance
        $savingsCollectionSum = SavingsCollection::withTrashed()
            ->where('status', '!=', '2')
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->where('saving_profile_id', $id)
            ->sum('deposit');

        $savingsWithdrawalSum = SavingWithdrawal::withTrashed()
            ->where('status', '!=', '2')
            ->where('saving_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('withdraw');

        $transToSavingsSum = SavingsToSavingsTransaction::where('status', '!=', '2')
            ->where('from_saving_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $transFromSavingsSum = SavingsToSavingsTransaction::where('status', '!=', '2')
            ->where('to_saving_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $transToLoansSum = SavingsToLoansTransaction::where('status', '!=', '2')
            ->where('from_saving_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $transFromLoansSum = LoansToSavingsTransaction::where('status', '!=', '2')
            ->where('to_saving_profile_id', $id)
            ->whereNotBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        // Statement Union Query
        $savingsCollection = SavingsCollection::withTrashed()
            ->where('status', '!=', '2')
            ->where('saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                'deposit',
                DB::raw('0 as withdraw'),
                'expression',
                'created_at',
                DB::raw('"Deposit" as type')
            );

        $savingsWithdrawal = SavingWithdrawal::withTrashed()
            ->where('status', '!=', '2')
            ->where('saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                DB::raw('0 as deposit'),
                'withdraw',
                'expression',
                'created_at',
                DB::raw('"Withdrawal" as type')
            );

        $transToSavings = SavingsToSavingsTransaction::where('status', '!=', '2')
            ->where('from_saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                DB::raw('0 as deposit'),
                'amount as withdraw',
                'expression',
                'created_at',
                DB::raw('"Transaction to Saving Account" as type')
            );

        $transFromSavings = SavingsToSavingsTransaction::where('status', '!=', '2')
            ->where('to_saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                'amount as deposit',
                DB::raw('0 as withdraw'),
                'expression',
                'created_at',
                DB::raw('"Transaction from Saving Account" as type')
            );

        $transToLoan = SavingsToLoansTransaction::where('status', '!=', '2')
            ->where('from_saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                DB::raw('0 as deposit'),
                'amount as withdraw',
                'expression',
                'created_at',
                DB::raw('"Transaction to Loan Account" as type')
            );

        $transFromLoan = LoansToSavingsTransaction::where('status', '!=', '2')
            ->where('to_saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'officer_id',
                'amount as deposit',
                DB::raw('0 as withdraw'),
                'expression',
                'created_at',
                DB::raw('"Transaction from Loan Account" as type')
            );

        $statements = $savingsCollection
            ->union($savingsWithdrawal)
            ->union($transToSavings)
            ->union($transFromSavings)
            ->union($transToLoan)
            ->union($transFromLoan)
            ->with('User:id,name')
            ->orderby('created_at')
            ->get();

        $accountBalance = ($savingsCollectionSum + $transFromSavingsSum + $transFromLoansSum) - ($savingsWithdrawalSum + $transToSavingsSum + $transToLoansSum);

        // Account Saving collections
        $savingsCollectionTables = SavingsCollection::withTrashed()
            ->where('status', '!=', '2')
            ->where('saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->select(
                'id',
                'officer_id',
                'deposit',
                'expression',
                'created_at'
            )
            ->orderBy('created_at')
            ->paginate(30)
            ->withQueryString();

        // Account Withdrawal
        $savingsWithdrawalTables = SavingWithdrawal::withTrashed()
            ->where('status', '!=', '2')
            ->where('saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->select(
                'id',
                'officer_id',
                'withdraw',
                'expression',
                'created_at'
            )
            ->orderBy('created_at')
            ->paginate(30)
            ->withQueryString();

        // Account check Table
        $accountCheckTables = SavingsProfileCheck::where('saving_profile_id', $id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with('User:id,name')
            ->select(
                'id',
                'officer_id',
                'balance',
                'expression',
                'created_at'
            )
            ->orderBy('created_at')
            ->paginate(30)
            ->withQueryString();

        // Account Transaction
        $transactionToSavings = SavingsToSavingsTransaction::where('status', '!=', '2')
            ->where('from_saving_profile_id', $id)
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

        $transactionFromSavings = SavingsToSavingsTransaction::where('status', '!=', '2')
            ->where('to_saving_profile_id', $id)
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

        $transactionToLoan = SavingsToLoansTransaction::where('status', '!=', '2')
            ->where('from_saving_profile_id', $id)
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

        $transactionFromLoan = LoansToSavingsTransaction::where('status', '!=', '2')
            ->where('to_saving_profile_id', $id)
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

        $transactionTable = $transactionToSavings
            ->union($transactionFromSavings)
            ->union($transactionToLoan)
            ->union($transactionFromLoan)
            ->orderby('created_at')
            ->paginate(30)
            ->withQueryString();

        // dd($accountCheckTables->toArray());

        return view('offices.accounts.stm.savingProfile', compact('account', 'totalInstallment', 'totalWithdrawal', 'totalTransaction', 'lastCheck', 'statements', 'accountBalance', 'savingsCollectionTables', 'savingsWithdrawalTables', 'transactionTable', 'accountCheckTables'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accCheck(Request $request, $id)
    {
        SavingsProfileCheck::create(
            [
                'saving_profile_id' => $id,
                'officer_id' => auth()->user()->id,
                'acc_no' => $request->acc_no,
                'balance' => $request->balance,
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
        $collection = SavingsCollection::with('SavingsProfile:id,total_deposit,balance')
            ->find($request->id, ['id', 'saving_profile_id', 'deposit', 'expression']);

        return response()->json($collection);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $saving_id)
    {
        // Validate Data
        $validate = Validator::make(
            $request->all(),
            [
                'present_balance' => 'required|numeric',
                'present_total_deposit' => 'required|numeric',
                'deposit' => 'required|numeric',
                'savingProfile_id' => 'required|numeric',
            ],
            [
                'present_balance.required' => 'The Balance field is required.',
                'deposit.required' => 'The deposit field is required.',
            ]
        );

        // Return Validation message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            DB::transaction(function () use ($request, $id, $saving_id) {
                SavingsProfile::find($saving_id)
                    ->update(
                        [
                            "total_deposit" => $request->present_total_deposit
                        ]
                    );

                SavingsCollection::find($id)
                    ->update(
                        [
                            "deposit" => $request->deposit,
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
            $saving_profile_id  = SavingsCollection::find($id, ['saving_profile_id', 'deposit']);

            SavingsProfile::find($saving_profile_id->saving_profile_id)
                ->update(
                    [
                        "total_deposit" => DB::raw('total_deposit - "' . $saving_profile_id->deposit . '"')
                    ]
                );

            SavingsCollection::find($id)->forceDelete();
        });
        return response()->json(['success' => true, 'message' => 'Delete successfull']);
    }
}
