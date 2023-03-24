<?php

namespace App\Http\Controllers\accounts;

use App\Models\Type;
use App\Models\Center;
use App\Models\Volume;
use GuzzleHttp\Client;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\ClientRegister;
use App\Models\SavingsProfile;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\LoanCollection;
use App\Models\LoanGuarantor;
use App\Models\LoanSavingWithdrawal;
use App\Models\LoansToLoansTransaction;
use App\Models\LoansToSavingsTransaction;
use App\Models\savingNominee;
use App\Models\SavingsCollection;
use App\Models\SavingsToLoansTransaction;
use App\Models\SavingsToSavingsTransaction;
use App\Models\SavingWithdrawal;
use Illuminate\Support\Facades\Validator;

class AccountsController extends Controller
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

    // Account Shown
    public function index($name = null, $id)
    {
        // Get Register
        $account = ClientRegister::with('Volume:id,name')
            ->with('Center:id,name')
            ->with('User:id,name')
            ->find($id);

        // Get Savings Sum
        $totalActiveSavings = SavingsProfile::where('status', '1')->where('client_id', $id)->count();
        $totalDeactiveSavings = SavingsProfile::onlyTrashed()->where('client_id', $id)->count();

        // Get Loan Sum
        $totalActiveLoans = LoanProfile::where('status', '1')->where('client_id', $id)->count();
        $totalDeactiveLoans = LoanProfile::where('status', '0')->where('client_id', $id)->count();

        // Get Active / Deactive Savings Account
        $allActiveSavings = SavingsProfile::accountdetails($id, '1');
        $allDeactiveSavings = SavingsProfile::accountdetails($id, '0');

        // Get Active / Deactive loans Account
        $allActiveLoans = LoanProfile::accountdetails($id, '1');
        $allDeactiveLoans = LoanProfile::accountdetails($id, '0');


        // dd($allActiveLoans->toArray());

        return view('offices.accounts.registerAccount', compact('account', 'totalActiveSavings', 'totalDeactiveSavings', 'totalActiveLoans', 'totalDeactiveLoans', 'allActiveSavings', 'allDeactiveSavings', 'allActiveLoans', 'allDeactiveLoans'));
    }

    // Register Edit
    public function registerEdit($name = null, $id)
    {

        $register = ClientRegister::with('Volume:id,name')
            ->with('Center:id,name')
            ->find($id);

        // Get All Volume And Center
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $centers = Center::where('status', '1')->get(['id', 'name']);
        return view('offices.accounts.editRegister', compact('register', 'volumes', 'centers'));
    }

    // Register udate
    public function registerUpdate(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
                'husbandName' => 'required|string',
                'motherName' => 'required|string',
                'nid' => 'required|numeric|max_digits:25|min_digits:10',
                'dob' => 'required',
                'religion' => 'required|string',
                'occupation' => 'required|string',
                'gender' => 'required|string',
                'mobile' => 'required|numeric|max_digits:11|min_digits:11',
                'client_image' => 'mimes:jpeg,png,jpg,webp|max:2048',
                'presend_address' => 'required|string',
                'Permanent_address' => 'required|string',
            ],
            [
                'husbandName.required' => 'The husband/fathers name field is required.',
                'nid.required' => 'The birth reg.no/voter id no field is required.',
                'dob.required' => 'The date of birth field is required.',
                'mobile.max_digits' => 'The mobile number must not be greater than 11 digit.',
                'mobile.min_digits' => 'The mobile number must not be less than 11 digit.',
            ]
        );

        // Register Info Validation Message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            if (!empty($request->client_image)) {
                if ($request->old_img != null) {
                    $path = public_path('storage/register/' . $request->old_img . '');
                    unlink($path);
                }
                $extention = $request->client_image->extension();
                $imgName = 'client_' . time() . '.' . $extention;
                $imagePath = $request->client_image->storeAs('register/', $imgName, 'public');

                ClientRegister::find($id)
                    ->update(
                        [
                            'client_image' => $imgName
                        ]
                    );
            }

            ClientRegister::find($id)
                ->update(
                    [
                        'share' => $request->share,
                        'name' => $request->name,
                        'husband_or_father_name' => $request->husbandName,
                        'mother_name' => $request->motherName,
                        'nid' => $request->nid,
                        'academic_qualification' => $request->qualifications,
                        'dob' => $request->dob,
                        'religion' => $request->religion,
                        'occupation' => $request->occupation,
                        'gender' => $request->gender,
                        'mobile' => $request->mobile,
                        'Present_address' => $request->presend_address,
                        'permanent_address' => $request->Permanent_address
                    ]
                );

            return response()->json(['success' => true, 'message' => 'Update successfull']);
        }
    }

    // Credentials update
    public function registerCredentialsUpdate(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'accNo' => 'required|numeric|unique:client_registers,acc_no,' . $id,
            ]
        );

        // Register Info Validation Message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            DB::transaction(function () use ($request, $id) {
                ClientRegister::find($id)
                    ->update(
                        [
                            'volume_id' => $request->volume,
                            'center_id' => $request->center,
                            'acc_no' => $request->accNo
                        ]
                    );

                SavingsProfile::find($id)
                    ->update(
                        [
                            'volume_id' => $request->volume,
                            'center_id' => $request->center,
                            'acc_no' => $request->accNo
                        ]
                    );

                SavingsCollection::where('saving_profile_id', $id)
                    ->update(
                        [
                            'volume_id' => $request->volume,
                            'center_id' => $request->center,
                            'acc_no' => $request->accNo
                        ]
                    );

                SavingWithdrawal::where('saving_profile_id', $id)
                    ->update(
                        [
                            'volume_id' => $request->volume,
                            'center_id' => $request->center,
                            'acc_no' => $request->accNo
                        ]
                    );

                SavingsToSavingsTransaction::where('from_saving_profile_id', $id)
                    ->update(
                        [
                            'from_volume_id' => $request->volume,
                            'from_center_id' => $request->center,
                            'from_acc_no' => $request->accNo
                        ]
                    );

                SavingsToSavingsTransaction::where('to_saving_profile_id', $id)
                    ->update(
                        [
                            'to_volume_id' => $request->volume,
                            'to_center_id' => $request->center,
                            'to_acc_no' => $request->accNo
                        ]
                    );

                SavingsToLoansTransaction::where('from_saving_profile_id', $id)
                    ->update(
                        [
                            'from_volume_id' => $request->volume,
                            'from_center_id' => $request->center,
                            'from_acc_no' => $request->accNo
                        ]
                    );

                LoansToSavingsTransaction::where('to_saving_profile_id', $id)
                    ->update(
                        [
                            'to_volume_id' => $request->volume,
                            'to_center_id' => $request->center,
                            'to_acc_no' => $request->accNo
                        ]
                    );

                LoanProfile::find($id)
                    ->update(
                        [
                            'volume_id' => $request->volume,
                            'center_id' => $request->center,
                            'acc_no' => $request->accNo
                        ]
                    );

                LoanCollection::where('loan_profile_id', $id)
                    ->update(
                        [
                            'volume_id' => $request->volume,
                            'center_id' => $request->center,
                            'acc_no' => $request->accNo
                        ]
                    );

                LoanSavingWithdrawal::where('loan_profile_id', $id)
                    ->update(
                        [
                            'volume_id' => $request->volume,
                            'center_id' => $request->center,
                            'acc_no' => $request->accNo
                        ]
                    );

                LoansToLoansTransaction::where('from_loan_profile_id', $id)
                    ->update(
                        [
                            'from_volume_id' => $request->volume,
                            'from_center_id' => $request->center,
                            'from_acc_no' => $request->accNo
                        ]
                    );

                LoansToLoansTransaction::where('to_loan_profile_id', $id)
                    ->update(
                        [
                            'to_volume_id' => $request->volume,
                            'to_center_id' => $request->center,
                            'to_acc_no' => $request->accNo
                        ]
                    );

                SavingsToLoansTransaction::where('to_loan_profile_id', $id)
                    ->update(
                        [
                            'to_volume_id' => $request->volume,
                            'to_center_id' => $request->center,
                            'to_acc_no' => $request->accNo
                        ]
                    );

                LoansToSavingsTransaction::where('from_loan_profile_id', $id)
                    ->update(
                        [
                            'from_volume_id' => $request->volume,
                            'from_center_id' => $request->center,
                            'from_acc_no' => $request->accNo
                        ]
                    );
            });
            return response()->json(['success' => true, 'message' => 'Update successfull']);
        }
    }

    // Active Savings Edit
    public function activeSavingsEdit($name = null, $id)
    {

        $activeSavings = SavingsProfile::with('Type:id,name')
            ->with('SavingNominee:id,saving_profile_id,name,dob,segment,relation,nominee_image')
            ->find($id, ['id', 'type_id', 'client_id', 'start_date', 'duration_date', 'deposit', 'installment', 'total_except_interest', 'interest', 'total_include_interest']);

        // dd($activeSavings->SavingNominee->toArray());
        // Get All Volume And Center
        $types = Type::where('status', '1')->where('savings', '1')->get(['id', 'name']);
        return view('offices.accounts.editSavings', compact('activeSavings', 'types'));
    }

    // Active Saving udate
    public function activeSavingsUpdate(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'savingType' => 'required|numeric',
                'deposit' => 'required|numeric',
                'startDate' => 'required',
                'duration' => 'required',
                'installment' => 'required|numeric|max_digits:2',
                'totalWithoutInterest' => 'required|numeric',
                'interest' => 'required|numeric|max_digits:2',
                'totalWithInterest' => 'required|numeric',
            ],
            [
                'installment.max_digits' => 'The installment must not be greater than 2 digit.',
                'interest.max_digits' => 'The interest must not be greater than 2 digit.',
                'totalWithoutInterest.required' => 'The total except interest field is required.',
                'totalWithInterest.required' => 'The total include interest field is required.',
            ]
        );

        // Register Info Validation Message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            $type_id = SavingsProfile::find($id, ['id', 'type_id']);
            if ($type_id->type_id != $request->savingType) {
                DB::transaction(function () use ($request, $id) {
                    SavingsProfile::find($id)
                        ->update(
                            [
                                'type_id' => $request->savingType
                            ]
                        );

                    SavingsCollection::where('saving_profile_id', $id)
                        ->update(
                            [
                                'type_id' => $request->savingType
                            ]
                        );

                    SavingWithdrawal::where('saving_profile_id', $id)
                        ->update(
                            [
                                'type_id' => $request->savingType
                            ]
                        );

                    SavingsToSavingsTransaction::where('from_saving_profile_id', $id)
                        ->update(
                            [
                                'from_type_id' => $request->savingType
                            ]
                        );

                    SavingsToSavingsTransaction::where('to_saving_profile_id', $id)
                        ->update(
                            [
                                'to_type_id' => $request->savingType
                            ]
                        );

                    SavingsToLoansTransaction::where('from_saving_profile_id', $id)
                        ->update(
                            [
                                'from_type_id' => $request->savingType
                            ]
                        );

                    LoansToSavingsTransaction::where('to_saving_profile_id', $id)
                        ->update(
                            [
                                'to_type_id' => $request->savingType
                            ]
                        );
                });
            }

            SavingsProfile::find($id)
                ->update(
                    [
                        'deposit' => $request->deposit,
                        'start_date' => $request->startDate,
                        'duration_date' => $request->duration,
                        'installment' => $request->installment,
                        'total_except_interest' => $request->totalWithoutInterest,
                        'interest' => $request->interest,
                        'total_include_interest' => $request->totalWithInterest
                    ]
                );

            return response()->json(['success' => true, 'message' => 'Update successfull']);
        }
    }

    // Savings Nominee Update
    public function activeSavingsNomineeUpdate(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'dob' => 'required',
                'relation' => 'required',
                'nominee_image' => 'mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'name' . '.required' => 'Nomine Name is required',
                'dob' . '.required' => 'Nomine Date of Birth is required',
                'relation' . '.required' => 'Nomine Relation is required',
            ]
        );

        // Nominee Validation Message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            if (!empty($request->nominee_image)) {
                if ($request->old_img != null) {
                    $path = public_path('storage/nominee/' . $request->old_img . '');
                    unlink($path);
                }
                $extention = $request->nominee_image->extension();
                $imgName = 'nominee_' . time() . '.' . $extention;
                $imagePath = $request->nominee_image->storeAs('nominee/', $imgName, 'public');
                dd($imagePath);
                savingNominee::find($id)
                    ->update(
                        [
                            'nominee_image' => $imgName
                        ]
                    );
            }

            savingNominee::find($id)
                ->update(
                    [
                        'name' => $request->name,
                        'dob' => $request->dob,
                        'segment' => $request->segment,
                        'relation' => $request->relation,
                    ]
                );

            return response()->json(['success' => true, 'message' => 'Update successfull']);
        }
    }

    // Active Loan Edit
    public function activeLoansEdit($name = null, $id)
    {

        $activeLoans = LoanProfile::with('Type:id,name')
            ->with('LoanGuarantor:id,loan_profile_id,name,father_name,mother_name,nid,guarentor_image,address')
            ->find($id, ['id', 'type_id', 'client_id', 'start_date', 'duration_date', 'deposit', 'loan_given', 'total_installment', 'interest', 'total_interest', 'total_loan_inc_int', 'loan_installment', 'interest_installment']);

        // Get All Volume And Center
        $types = Type::where('status', '1')->where('loans', '1')->get(['id', 'name']);
        return view('offices.accounts.editLoans', compact('activeLoans', 'types'));
    }

    // Active Loan udate
    public function activeLoansUpdate(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'loanType' => 'required|numeric',
                'deposit' => 'required|numeric',
                'startDate' => 'required',
                'duration' => 'required',
                'loan_giving' => 'required|numeric',
                'installment' => 'required|numeric',
                'interest' => 'required|numeric',
                'totalInterest' => 'required|numeric',
                'totalWithInterest' => 'required|numeric',
                'fixedLoanInstallment' => 'required|numeric',
                'fixedInterestInstallment' => 'required|numeric'
            ],
            [
                'totalWithInterest.required' => 'The Total Loan include Interest field is required.'
            ]
        );

        // Register Info Validation Message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            $type_id = SavingsProfile::find($id, ['id', 'type_id']);
            if ($type_id->type_id != $request->loanType) {
                DB::transaction(function () use ($request, $id) {
                    LoanProfile::find($id)
                        ->update(
                            [
                                'type_id' => $request->loanType
                            ]
                        );

                    LoanCollection::where('loan_profile_id', $id)
                        ->update(
                            [
                                'type_id' => $request->loanType
                            ]
                        );

                    LoanSavingWithdrawal::where('loan_profile_id', $id)
                        ->update(
                            [
                                'type_id' => $request->loanType
                            ]
                        );

                    LoansToLoansTransaction::where('from_loan_profile_id', $id)
                        ->update(
                            [
                                'from_type_id' => $request->loanType
                            ]
                        );

                    LoansToLoansTransaction::where('to_loan_profile_id', $id)
                        ->update(
                            [
                                'to_type_id' => $request->loanType
                            ]
                        );

                    SavingsToLoansTransaction::where('to_loan_profile_id', $id)
                        ->update(
                            [
                                'to_type_id' => $request->loanType
                            ]
                        );

                    LoansToSavingsTransaction::where('from_loan_profile_id', $id)
                        ->update(
                            [
                                'from_type_id' => $request->loanType
                            ]
                        );
                });
            }

            LoanProfile::find($id)
                ->update(
                    [
                        'deposit' => $request->deposit,
                        'start_date' => $request->startDate,
                        'duration_date' => $request->duration,
                        'loan_given' => $request->loan_giving,
                        'total_installment' => $request->installment,
                        'interest' => $request->interest,
                        'total_interest' => $request->totalInterest,
                        'total_loan_inc_int' => $request->totalWithInterest,
                        'loan_installment' => $request->fixedLoanInstallment,
                        'interest_installment' => $request->fixedInterestInstallment
                    ]
                );

            return response()->json(['success' => true, 'message' => 'Update successfull']);
        }
    }

    // Loan Guarantor update
    public function activeLoansGuarantorUpdate(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'guarantor_name' => 'required',
                'guarantor_fatherName' => 'required',
                'guarantor_motherName' => 'required',
                'guarantor_nid' => 'required|numeric',
                'guarantor_image' => 'mimes:jpeg,png,jpg,webp|max:2048',
                'address' => 'required',
            ],
            [
                'guarantor_name.required' => 'The name is required.',
                'guarantor_fatherName.required' => 'The father name is required.',
                'guarantor_motherName.required' => 'The mother name is required.',
                'guarantor_nid.required' => 'The Birth Reg.No/Voter ID No  is required.',
                'address.required' => 'The address is required.'
            ]
        );

        // Register Info Validation Message
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->toArray()]);
        } else {
            if (!empty($request->guarantor_image)) {
                if ($request->old_img != null) {
                    $path = public_path('storage/guarantor/' . $request->old_img . '');
                    unlink($path);
                }
                $extention = $request->guarantor_image->extension();
                $imgName = 'guarantor_' . time() . '.' . $extention;
                $imagePath = $request->guarantor_image->storeAs('guarantor/', $imgName, 'public');

                LoanGuarantor::find($id)
                    ->update(
                        [
                            'guarentor_image' => $imgName
                        ]
                    );
            }

            LoanGuarantor::find($id)
                ->update(
                    [
                        'name' => $request->guarantor_name,
                        'father_name' => $request->guarantor_fatherName,
                        'mother_name' => $request->guarantor_motherName,
                        'nid' => $request->guarantor_nid,
                        'address' => $request->address,
                    ]
                );

            return response()->json(['success' => true, 'message' => 'Update successfull']);
        }
    }

    // Search
    public function search()
    {
        $search = request()->search;
        $limit = isset(request()->limit) ? request()->limit : '25';
        $accounts = ClientRegister::query()
            ->where('acc_no', 'LIKE', "%{$search}%")
            ->orwhere('name', 'LIKE', "%{$search}%")
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->select('id', 'volume_id', 'center_id', 'name', 'acc_no')
            ->paginate($limit)
            ->withQueryString();

        return view('offices.summary.accounts.searchAccount', compact('accounts'));
    }

    // Live Search
    public function liveSearch(Request $request)
    {
        $search = $request->search;
        $accounts = ClientRegister::where('acc_no', 'LIKE', "%{$search}%")
            ->orwhere('name', 'LIKE', "%{$search}%")
            ->select('id', 'name', 'acc_no', 'client_image')
            ->take(25)
            ->get();

        return response()->json($accounts);
    }
}
