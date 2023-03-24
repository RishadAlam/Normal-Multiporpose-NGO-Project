<?php

namespace App\Http\Controllers;

use App\Models\LoanCollection;
use App\Models\LoanProfile;
use App\Models\LoanSavingWithdrawal;
use App\Models\SavingsCollection;
use App\Models\SavingsProfile;
use App\Models\SavingWithdrawal;
use App\Models\Type;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClosingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function savingsFormShown()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $types = Type::where('savings', '1')->where('status', '1')->get(['id', 'name']);
        return view('offices.closing.savings', compact('volumes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function savingsClosing(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'savingType' => 'required|numeric',
                'saving_profile_id' => 'required|numeric',
                'client_id' => 'required|numeric',
                'acc_no' => 'required|numeric',
                'balance' => 'required|numeric',
                'interest' => 'required|numeric',
                'closing_balance' => 'required|numeric'
            ],
            [
                'saving_profile_id.required' => 'Account No is required',
                'client_id.required' => 'Name is required'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            DB::transaction(function () use ($request) {
                SavingsProfile::find($request->saving_profile_id)
                    ->update(
                        [
                            'status' => '0',
                            'closing_interest' => $request->interest,
                            'closing_balance_include_interest' => $request->closing_balance,
                            'closing_expression' => $request->description,
                        ]
                    );

                SavingsCollection::where('saving_profile_id', $request->saving_profile_id)->where('status', '2')->forceDelete();
                SavingsCollection::where('saving_profile_id', $request->saving_profile_id)->update(['status' => '0']);
                SavingsCollection::where('saving_profile_id', $request->saving_profile_id)->delete();

                SavingWithdrawal::where('saving_profile_id', $request->saving_profile_id)->where('status', '2')->forceDelete();
                SavingWithdrawal::where('saving_profile_id', $request->saving_profile_id)->update(['status' => '0']);
                SavingWithdrawal::where('saving_profile_id', $request->saving_profile_id)->delete();

                SavingsProfile::find($request->saving_profile_id)->delete();
            });

            return response()->json(['success' => true, 'message' => 'Account Closed Successfully']);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loanFormShown()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $types = Type::where('loans', '1')->where('status', '1')->get(['id', 'name']);
        return view('offices.closing.loans', compact('volumes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loanClosing(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'loanType' => 'required|numeric',
                'loan_profile_id' => 'required|numeric',
                'balance' => 'required|numeric|max:0',
                'loan_remaining' => 'required|numeric|max:0',
                'interest_remaining' => 'required|numeric|max:0'
            ],
            [
                'loan_profile_id.required' => 'Account No is required'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            DB::transaction(function () use ($request) {
                LoanProfile::find($request->loan_profile_id)
                    ->update(
                        [
                            'status' => '0',
                            'closing_expression' => $request->description
                        ]
                    );

                LoanCollection::where('loan_profile_id', $request->loan_profile_id)->where('status', '2')->forceDelete();
                LoanCollection::where('loan_profile_id', $request->loan_profile_id)->update(['status' => '0']);
                LoanCollection::where('loan_profile_id', $request->loan_profile_id)->delete();

                LoanSavingWithdrawal::where('loan_profile_id', $request->loan_profile_id)->where('status', '2')->forceDelete();
                LoanSavingWithdrawal::where('loan_profile_id', $request->loan_profile_id)->update(['status' => '0']);
                LoanSavingWithdrawal::where('loan_profile_id', $request->loan_profile_id)->delete();

                LoanProfile::find($request->loan_profile_id)->delete();
            });

            return response()->json(['success' => true, 'message' => 'Account Closed Successfully']);
        }
    }
}
