<?php

namespace App\Http\Controllers\Collections;

use App\Models\Type;
use App\Models\User;
use App\Models\Volume;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\ClientRegister;
use App\Models\LoanCollection;
use App\Models\SavingsProfile;
use App\Models\SavingsCollection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CollectionController extends Controller
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

    // Get All Savings Accounts
    public function savingsAccountsLoad(Request $request)
    {
        $accounts = SavingsProfile::where('volume_id', $request->volume)
            ->where('center_id', $request->center)
            ->where('type_id', $request->savingType)
            ->where('status', '1')
            ->get(['id', 'acc_no']);

        return json_encode($accounts);
    }

    // Get All Loan Accounts
    public function loansAccountsLoad(Request $request)
    {
        $accounts = LoanProfile::where('volume_id', $request->volume)
            ->where('center_id', $request->center)
            ->where('type_id', $request->loanType)
            ->where('status', '1')
            ->get(['id', 'acc_no']);

        return json_encode($accounts);
    }

    // GET Savings Information
    public function savingsAccountsInfoLoad(Request $request)
    {
        $accounts = SavingsProfile::where('id', $request->id)
            ->with('ClientRegister:id,name')
            ->first(['acc_no', 'client_id', 'deposit', 'balance']);

        return json_encode($accounts);
    }

    // GET Loan Information
    public function loansAccountsInfoLoad(Request $request)
    {
        $accounts = LoanProfile::where('id', $request->id)
            ->with('ClientRegister:id,name')
            ->first(['acc_no', 'client_id', 'deposit', 'balance', 'loan_given', 'installment_recovered', 'loan_recovered', 'loan_remaining', 'interest_recovered', 'interest_remaining', 'loan_installment', 'interest_installment']);

        return json_encode($accounts);
    }

    /**
     * Get All Volume
     * Get All Savings Type
     * Show collection savings view file
     */
    public function showSavingsCollectionForm()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $types = Type::where('savings', '1')->where('status', '1')->get(['id', 'name']);
        return view('offices.collections.savingsForm', compact('volumes', 'types'));
    }

    /**
     * Store Savings Collection
     * Validate Data
     * Return Validation message
     */
    public function savingsCollectionStore(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'savingType' => 'required|numeric',
                'saving_profile_id' => 'required|numeric',
                'client_id' => 'required|numeric',
                'acc_no' => 'required|numeric',
                'deposit' => 'required|numeric'
            ],
            [
                'saving_profile_id.required' => 'Account No is required',
                'client_id.required' => 'Name is required'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            SavingsCollection::create(
                [
                    'saving_profile_id' => $request->saving_profile_id,
                    'volume_id' => $request->volume,
                    'center_id' => $request->center,
                    'type_id' => $request->savingType,
                    'officer_id' => auth()->user()->id,
                    'client_id' => $request->client_id,
                    'acc_no' => $request->acc_no,
                    'deposit' => $request->deposit,
                    'expression' => $request->description,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Collection successfully completed']);
        }
    }

    /**
     * Get All Volume
     * Get All Savings Type
     * Show collection savings view file
     */
    public function showLoanCollectionForm()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $types = Type::where('loans', '1')->where('status', '1')->get(['id', 'name']);
        return view('offices.collections.loansForm', compact('volumes', 'types'));
    }

    /**
     * Store Loan Collection
     * Validate Data
     * Return Validation message
     */
    public function loansCollectionStore(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'loanType' => 'required|numeric',
                'loan_profile_id' => 'required|numeric',
                'client_id' => 'required|numeric',
                'acc_no' => 'required|numeric',
                'installment' => 'required|numeric',
                'deposit' => 'required|numeric',
                'loan' => 'required|numeric',
                'interest' => 'required|numeric',
                'total' => 'required|numeric',
            ],
            [
                'loan_profile_id.required' => 'Account No is required',
                'client_id.required' => 'Name is required'
            ]
        );

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            LoanCollection::create(
                [
                    'loan_profile_id' => $request->loan_profile_id,
                    'volume_id' => $request->volume,
                    'center_id' => $request->center,
                    'type_id' => $request->loanType,
                    'officer_id' => auth()->user()->id,
                    'client_id' => $request->client_id,
                    'acc_no' => $request->acc_no,
                    'installment' => $request->installment,
                    'deposit' => $request->deposit,
                    'loan' => $request->loan,
                    'interest' => $request->interest,
                    'total' => $request->total,
                    'expression' => $request->description
                ]
            );

            return response()->json(['success' => true, 'message' => 'Collection successfully completed']);
        }
    }
}
