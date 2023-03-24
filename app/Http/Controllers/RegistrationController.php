<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\User;
use App\Models\Center;
use App\Models\Volume;
use Illuminate\Http\Request;
use App\Models\savingNominee;
use App\Models\ClientRegister;
use App\Models\LoanGuarantor;
use App\Models\LoanProfile;
use App\Models\SavingsProfile;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
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
     * New Customer Savings Form
     * Get All Volume
     * Get All center
     * Get all Saving Type
     */
    public function clientRegistration()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $officers = User::whereNotIn('email', ['admin@gmail.com'])->where('status', '1')->get(['id', 'name']);
        $types = Type::where('savings', '1')->where('status', '1')->get(['id', 'name']);
        return view('offices.registrations.clientRegistration', compact('volumes', 'officers', 'types'));
    }

    /**
     * Get Center with condition volume id 
     */
    public function clientRegistrationGetCenter($id)
    {
        $centers = Center::where('volume_id', $id)
            ->where('status', '1')
            ->get(['id', 'name']);

        return $centers;
    }

    /**
     * Get Client Account
     */
    public function savingsRegistrationGetAccount($volId, $centerID)
    {
        $savingsAcc = ClientRegister::where('volume_id', $volId)
            ->where('center_id', $centerID)
            ->get(['acc_no', 'id']);

        return json_encode($savingsAcc);
    }

    /**
     * Get Register information
     */
    public function savingsRegistrationGetAccountInfo($id)
    {
        $register = ClientRegister::where('acc_no', $id)->first();
        return json_encode($register);
    }

    /**
     * Savings ACCOUNT INFORMATION Validation
     */
    private function savingValidate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'accNo' => 'required|numeric',
                'officers' => 'required|numeric',
                'savingType' => 'required|numeric',
                'deposit' => 'required|numeric',
                'startDate' => 'required',
                'duration' => 'required',
                'installment' => 'required|numeric|max_digits:3',
                'totalWithoutInterest' => 'required|numeric',
                'interest' => 'required|numeric|max_digits:2',
                'totalWithInterest' => 'required|numeric',
            ],
            [
                'accNo.required' => 'The account no. field is required.',
                'officers.required' => 'The registration officer field is required.',
                'officers.required' => 'The registration officer field is required.',
                'installment.max_digits' => 'The installment must not be greater than 2 digit.',
                'interest.max_digits' => 'The interest must not be greater than 2 digit.',
                'totalWithoutInterest.required' => 'The total except interest field is required.',
                'totalWithInterest.required' => 'The total include interest field is required.',
            ]
        );
    }

    private function nomineeValidate($request, $index)
    {
        return Validator::make(
            $request->all(),
            [
                'name_' . $index => 'required',
                'dob_' . $index => 'required',
                'relation_' . $index => 'required',
            ],
            [
                'name_' . $index . '.required' => 'Nomine Name is required',
                'dob_' . $index . '.required' => 'Nomine Date of Birth is required',
                'relation_' . $index . '.required' => 'Nomine Relation is required',
            ]
        );
    }

    /**
     * Savings Profile Registration
     */
    private function savingsProfileRegistration($request, $client_id)
    {
        // Savings Profile Create
        $savings = new SavingsProfile();
        $savings->volume_id = $request->volume;
        $savings->center_id = $request->center;
        $savings->type_id = $request->savingType;
        $savings->registration_officer_id = $request->officers;
        $savings->client_id = $client_id;
        $savings->acc_no = $request->accNo;
        $savings->start_date = $request->startDate;
        $savings->duration_date = $request->duration;
        $savings->deposit = $request->deposit;
        $savings->installment = $request->installment;
        $savings->total_except_interest = $request->totalWithoutInterest;
        $savings->interest = $request->interest;
        $savings->total_include_interest = $request->totalWithInterest;
        $savings->save();
        $saving_id = $savings->id;

        return $saving_id;

        // return SavingsProfile::create(
        //     [
        //         'volume_id' => $request->volume,
        //         'center_id' => $request->center,
        //         'type_id' => $request->savingType,
        //         'registration_officer_id' => $request->officers,
        //         'client_id' => $request->client_id,
        //         'acc_no' => $request->accNo,
        //         'start_date' => $request->startDate,
        //         'duration_date' => $request->duration,
        //         'deposit' => $request->deposit,
        //         'installment' => $request->installment,
        //         'total_except_interest' => $request->totalWithoutInterest,
        //         'interest' => $request->interest,
        //         'total_include_interest' => $request->totalWithInterest,
        //         'status' => true,
        //     ]
        // );
    }

    /**
     * Savings Nominee Store
     */
    private function savingsNomineeStore($request, $saving_id)
    {
        // Nominee Image Store
        $image = null;
        if ($request->nomee_image_1) {
            $image = $this->nomineeImageStore($request->nomee_image_1);
        }

        // 1st Nominee Store
        savingNominee::create(
            [
                'saving_profile_id' => $saving_id,
                'name' => $request->name_1,
                'dob' => $request->dob_1,
                'segment' => $request->segment_1,
                'relation' => $request->relation_1,
                'nominee_image' => $image,
            ]
        );

        // 2nd Nominee Store
        if ($request->name_2) {
            // Nominee Image Store
            $image = null;
            if ($request->nomee_image_2) {
                $image = $this->nomineeImageStore($request->nomee_image_2);
            }

            // Nominee Store
            savingNominee::create(
                [
                    'saving_profile_id' => $saving_id,
                    'name' => $request->name_2,
                    'dob' => $request->dob_2,
                    'segment' => $request->segment_2,
                    'relation' => $request->relation_2,
                    'nominee_image' => $image,
                ]
            );
        }

        return true;
    }

    /**
     * Loan Guarantor Validation
     */
    private function guarantorValidate($request, $index)
    {
        return Validator::make(
            $request->all(),
            [
                // Guarantor Validate
                'guarantor_name_' . $index => 'required',
                'guarantor_fatherName_' . $index => 'required',
                'guarantor_motherName_' . $index => 'required',
                'guarantor_nid_' . $index => 'required|numeric',
                'guarantor_image_' . $index => 'mimes:jpeg,png,jpg,webp|max:2048',
                'g_house_' . $index => 'required',
                'g_village_' . $index => 'required',
                'g_postcodes_' . $index => 'required',
                'g_upazilas_' . $index => 'required',
                'g_districts_' . $index => 'required',
                'g_divisions_' . $index => 'required',
            ],
            [
                'guarantor_name_' . $index . '.required' => 'The name is required.',
                'guarantor_fatherName_' . $index . '.required' => 'The father name is required.',
                'guarantor_motherName_' . $index . '.required' => 'The mother name is required.',
                'guarantor_nid_' . $index . '.required' => 'The Birth Reg.No/Voter ID No  is required.',
                'g_house_' . $index . '.required' => 'The House/Appertment/Road is required.',
                'g_village_' . $index . '.required' => 'The village is required.',
                'g_postcodes_' . $index . '.required' => 'The post code is required.',
                'g_upazilas_' . $index . '.required' => 'The police station is required.',
                'g_districts_' . $index . '.required' => 'The district is required.',
                'g_divisions_' . $index . '.required' => 'The divition is required.',
            ]
        );
    }

    /**
     * Guarantor Image Store
     */
    private function gImageStore($image)
    {
        $guarantor_img_ext = $image->extension();
        $guarantor_img_name = 'guarantor_' . uniqid() . '.' . $guarantor_img_ext;
        $image->storeAs('guarantor/', $guarantor_img_name, 'public');
        return $guarantor_img_name;
    }

    /**
     * Nominee Image Store
     */
    public function nomineeImageStore($image)
    {
        // Nominee Image Store
        $nominee_img_ext = $image->extension();
        $nominee_img_name = 'nominee_' . uniqid() . '.' . $nominee_img_ext;
        $image->storeAs('nominee/', $nominee_img_name, 'public');
        return $nominee_img_name;
    }

    /**
     * Client Registrations
     * Validate Data
     * Address Concatenation
     * Client Register store
     * Savings Profile Create
     * Nominee Image Store
     * nominee store
     * return back with success msg
     */
    public function clientRegistrationStore(Request $request)
    {
        // dd($request->all());
        /**
         *  data Validation
         *  Savings ACCOUNT INFORMATION Validation
         */
        $validate = $this->savingValidate($request);

        // Saving Profile Validation Message 
        $errors = [];
        if ($validate->fails()) {
            $errors =  $validate->errors()->toArray();
        }

        // 1st Nominee Validation
        $validate = $this->nomineeValidate($request, 1);

        // 1st Nominee Validation message
        if ($validate->fails()) {
            $errors += $validate->errors()->toArray();
        }

        // 2nd Nominee Validation
        if (isset($request->name_2)) {
            $validate = $this->nomineeValidate($request, 2);
        }

        // 2nd Nominee Validation message
        if ($validate->fails()) {
            $errors += $validate->errors()->toArray();
        }

        // Register Info Validation
        $validate = Validator::make(
            $request->all(),
            [
                'accNo' => 'unique:client_registers,acc_no',
                // PERSONAL INFORMATION Validation
                'name' => 'required|string',
                'husbandName' => 'required|string',
                'motherName' => 'required|string',
                'nid' => 'required|numeric|max_digits:25|min_digits:10',
                'dob' => 'required',
                'religion' => 'required|string',
                'occupation' => 'required|string',
                'gender' => 'required|string',
                'mobile' => 'required|numeric|max_digits:11|min_digits:11',
                'client_image' => 'required|mimes:jpeg,png,jpg,webp|max:2048',

                // Present Address Validation
                'house' => 'required|string',
                'village' => 'required|string',
                'postcodes' => 'required|string',
                'upazilas' => 'required|string',
                'districts' => 'required|string',
                'divisions' => 'required|string',

                // Permanent Address Validation
                'p_house' => 'required|string',
                'p_village' => 'required|string',
                'p_postcodes' => 'required|string',
                'p_upazilas' => 'required|string',
                'p_districts' => 'required|string',
                'p_divisions' => 'required|string',
            ],
            [
                'accNo.unique' => 'This account is already exists.',
                'husbandName.required' => 'The husband/fathers name field is required.',
                'nid.required' => 'The birth reg.no/voter id no field is required.',
                'dob.required' => 'The date of birth field is required.',
                'mobile.max_digits' => 'The mobile number must not be greater than 11 digit.',
                'mobile.min_digits' => 'The mobile number must not be less than 11 digit.',
                'p_house.required' => 'The house field is required.',
                'p_village.required' => 'The village field is required.',
                'p_postcodes.required' => 'The postcodes field is required.',
                'p_upazilas.required' => 'The upazilas field is required.',
                'p_districts.required' => 'The districts field is required.',
                'p_divisions.required' => 'The divisions field is required.',
            ]
        );

        // Register Info Validation Message
        if ($validate->fails()) {
            $errors +=  $validate->errors()->toArray();
        }

        // Return Form Validation All messages
        if ($errors) {
            return response()->json(['errors' => $errors]);
        } else {

            // Addresses concat
            $Present_address = '<p><b>House/Appertment/Road:</b> ' . $request->house . ', <b>Village:</b> ' . $request->village . ', <b>Post Office:</b> ' . $request->postOffice . ', <b>Post Code:</b> ' . $request->postcodes . ', <b>Police Station:</b> ' . $request->upazilas . ', <b>District:</b> ' . $request->districts . ', <b>Division:</b> ' . $request->divisions . '.</p>';

            $permanent_address = '<p><b>House/Appertment/Road:</b> ' . $request->p_house . ', <b>Village:</b> ' . $request->p_village . ', <b>Post Office:</b> ' . $request->p_postOffice . ', <b>Post Code:</b> ' . $request->p_postcodes . ', <b>Police Station:</b> ' . $request->p_upazilas . ', <b>District:</b> ' . $request->p_districts . ', <b>Division:</b> ' . $request->p_divisions . '.</p>';

            // Client Image Store
            $client_img_ext = $request->client_image->extension();
            $client_img_name = 'client_' . uniqid() . '.' . $client_img_ext;
            $request->client_image->storeAs('register/', $client_img_name, 'public');
            // $dob = date('Y-m-d', strtotime($request->dob));

            // Begin DB Transection
            DB::transaction(function () use ($request, $client_img_name, $Present_address, $permanent_address) {
                // Client Register store

                $client = new ClientRegister();
                $client->volume_id = $request->volume;
                $client->center_id = $request->center;
                $client->registration_officer_id = $request->officers;
                $client->acc_no = $request->accNo;
                $client->share = $request->share;
                $client->name = $request->name;
                $client->husband_or_father_name = $request->husbandName;
                $client->mother_name = $request->motherName;
                $client->nid = $request->nid;
                $client->academic_qualification = $request->qualifications;
                $client->dob = $request->dob;
                $client->religion = $request->religion;
                $client->occupation = $request->occupation;
                $client->gender = $request->gender;
                $client->mobile = $request->mobile;
                $client->client_image = $client_img_name;
                $client->Present_address = $Present_address;
                $client->permanent_address = $permanent_address;
                $client->save();
                $client_id = $client->id;

                // Savings Profile Create
                $saving_id = $this->savingsProfileRegistration($request, $client_id);

                // Nominess Store
                $this->savingsNomineeStore($request, $saving_id);
            });

            return response()->json(['success' => true, 'message' => 'Client & Saving Account Registered successfull']);
        }
    }

    /**
     * New Customer Savings Form
     * Get All Volume
     * Get All officers
     * Get all Saving Type
     */
    public function savingsRegistration()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $officers = User::whereNotIn('email', ['admin@gmail.com'])->where('status', '1')->get(['id', 'name']);
        $types = Type::where('savings', '1')->where('status', '1')->get(['id', 'name']);
        return view('offices.registrations.savingsRegistration', compact('volumes', 'officers', 'types'));
    }

    /**
     * Savings account registration
     * Validate Data
     * Savings Profile Create
     * Nominee Image Store
     * nominee store
     * return back with success msg
     */
    public function savingsRegistrationStore(Request $request)
    {
        // dd($request->all());
        /**
         *  data Validation
         *  Savings ACCOUNT INFORMATION Validation
         */
        $validate = $this->savingValidate($request);

        // Saving Profile Validation Message 
        $errors = [];
        if ($validate->fails()) {
            $errors =  $validate->errors()->toArray();
        }

        // 1st Nominee Validation
        $validate = $this->nomineeValidate($request, 1);

        // 1st Nominee Validation message
        if ($validate->fails()) {
            $errors += $validate->errors()->toArray();
        }

        // 2nd Nominee Validation
        if (isset($request->name_2)) {
            $validate = $this->nomineeValidate($request, 2);
        }

        // 2nd Nominee Validation message
        if ($validate->fails()) {
            $errors += $validate->errors()->toArray();
        }

        // Return Form Validation All messages
        if ($errors) {
            return response()->json(['errors' => $errors]);
        } else {
            // Store Data
            DB::transaction(function () use ($request) {
                // Savings Profile Create
                $saving_id = $this->savingsProfileRegistration($request, $request->client_id);

                // Nominess Store
                $this->savingsNomineeStore($request, $saving_id);
            });

            return response()->json(['success' => true, 'message' => 'Saving Account Registered successfull']);
        }
    }

    /**
     * New Loan Account Form
     * Get All Volume
     * Get All officers
     * Get all Saving Type
     */
    public function loansRegistration()
    {
        $volumes = Volume::where('status', '1')->get(['id', 'name']);
        $officers = User::whereNotIn('email', ['admin@gmail.com'])->where('status', '1')->get(['id', 'name']);
        $types = Type::where('loans', '1')->where('status', '1')->get(['id', 'name']);
        return view('offices.registrations.loansRegistration', compact('volumes', 'officers', 'types'));
    }

    /**
     * Loan account registration
     * Validate Data
     * validation msg store
     * Loan Profile Create
     * Guarantor Image Store
     * Guarantor address marge
     * Guarantor store
     * return back with success msg
     */
    public function loansRegistrationStore(Request $request)
    {
        // dd($request->loanType);
        $validate = Validator::make(
            $request->all(),
            [
                // Loan Profile Validate
                'volume' => 'required|numeric',
                'center' => 'required|numeric',
                'accNo' => 'required|numeric',
                'client_id' => 'required|numeric',
                'officers' => 'required|numeric',
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
                'accNo.required' => 'The account no. field is required.',
                'officers.required' => 'The registration officer field is required.',
                'officers.required' => 'The registration officer field is required.',
                'totalWithInterest.required' => 'The Total Loan include Interest field is required.'
            ]
        );

        // loan Profile Validation Message 
        $errors = [];
        if ($validate->fails()) {
            $errors =  $validate->errors()->toArray();
        }

        // 1st Guarantor Validation
        $validate = $this->guarantorValidate($request, 1);

        // 1st Guarantor Validation message
        if ($validate->fails()) {
            $errors += $validate->errors()->toArray();
        }

        // 2nd Guarantor Validation
        if (isset($request->guarantor_name_2)) {
            $validate = $this->guarantorValidate($request, 2);
        }

        // 2nd Guarantor Validation message
        if ($validate->fails()) {
            $errors += $validate->errors()->toArray();
        }

        if ($errors) {
            return response()->json(['errors' => $errors]);
        } else {

            // Store DAta
            DB::transaction(function () use ($request) {
                // Create Loan profile
                $loan = new LoanProfile();
                $loan->volume_id = $request->volume;
                $loan->center_id = $request->center;
                $loan->type_id = $request->loanType;
                $loan->registration_officer_id = $request->officers;
                $loan->client_id = $request->client_id;
                $loan->acc_no = $request->accNo;
                $loan->start_date = $request->startDate;
                $loan->duration_date = $request->duration;
                $loan->deposit = $request->deposit;
                $loan->loan_given = $request->loan_giving;
                $loan->total_installment = $request->installment;
                $loan->interest = $request->interest;
                $loan->total_interest = $request->totalInterest;
                $loan->total_loan_inc_int = $request->totalWithInterest;
                $loan->loan_installment = $request->fixedLoanInstallment;
                $loan->interest_installment = $request->fixedInterestInstallment;
                $loan->save();
                $loanID = $loan->id;

                // $loanID = LoanProfile::create(
                //     [
                //         'volume_id' => $request->volume,
                //         'center_id' => $request->center,
                //         'type_id' => $request->loanType,
                //         'registration_officer_id' => $request->officers,
                //         'client_id' => $request->client_id,
                //         'acc_no' => $request->accNo,
                //         'start_date' => $request->startDate,
                //         'duration_date' => $request->duration,
                //         'deposit' => $request->deposit,
                //         'loan_given' => $request->loan_giving,
                //         'total_installment' => $request->installment,
                //         'interest' => $request->interest,
                //         'total_interest' => $request->totalInterest,
                //         'total_loan_inc_int' => $request->totalWithInterest,
                //         'loan_installment' => $request->fixedLoanInstallment,
                //         'interest_installment' => $request->fixedInterestInstallment,
                //     ]
                // );


                // Guarentor Store
                $address = '<p><b>House/Appertment/Road:</b> ' . $request->g_house_1 . ', <b>Village:</b> ' . $request->g_village_1 . ', <b>Post Office:</b> ' . $request->g_postOffice_1 . ', <b>Post Code:</b> ' . $request->g_postcodes_1 . ', <b>Police Station:</b> ' . $request->g_upazilas_1 . ', <b>District:</b> ' . $request->g_districts_1 . ', <b>Division:</b> ' . $request->g_divisions_1 . '.</p>';

                // guarantor Image Store
                $g_image = null;
                if ($request->guarantor_image_1) {
                    $g_image = $this->gImageStore($request->guarantor_image_1);
                }

                // Guarantor store
                // 1st Guarantor store
                LoanGuarantor::create(
                    [
                        'loan_profile_id' => $loanID,
                        'name' => $request->guarantor_name_1,
                        'father_name' => $request->guarantor_fatherName_1,
                        'mother_name' => $request->guarantor_motherName_1,
                        'nid' => $request->guarantor_nid_1,
                        'address' => $address,
                        'guarentor_image' => $g_image,
                    ]
                );

                // 2nd Guarantor store
                if ($request->guarantor_name_2) {

                    // Guarentor Store
                    $address = '<p><b>House/Appertment/Road:</b> ' . $request->g_house_2 . ', <b>Village:</b> ' . $request->g_village_2 . ', <b>Post Office:</b> ' . $request->g_postOffice_2 . ', <b>Post Code:</b> ' . $request->g_postcodes_2 . ', <b>Police Station:</b> ' . $request->g_upazilas_2 . ', <b>District:</b> ' . $request->g_districts_2 . ', <b>Division:</b> ' . $request->g_divisions_2 . '.</p>';

                    // guarantor Image Store
                    $g_image = null;
                    if ($request->guarantor_image_2) {
                        $g_image = $this->gImageStore($request->guarantor_image_2);
                    }

                    // 2nd Guarantor store
                    LoanGuarantor::create(
                        [
                            'loan_profile_id' => $loanID,
                            'name' => $request->guarantor_name_2,
                            'father_name' => $request->guarantor_fatherName_2,
                            'mother_name' => $request->guarantor_motherName_2,
                            'nid' => $request->guarantor_nid_2,
                            'address' => $address,
                            'guarentor_image' => $g_image,
                        ]
                    );
                }
            });

            return response()->json(['success' => true, 'message' => 'Loan Account Registered successfull']);
        }
    }

    /**
     * Create new volume
     */
    public function volumeCreate(Request $request)
    {
        /**
         * Validate Data
         * Mass Assignment
         * Return Message
         */
        $validate = Validator::make($request->all(), ['name' => 'unique:volumes,name']);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => 'Volume Name already exists!']);
        } else {
            Volume::create(
                [
                    'name' => $request->name,
                    'description' => $request->description,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Volume Registration Successfull']);
        }
    }

    /**
     * Create new Center
     */
    public function centerCreate(Request $request)
    {
        /**
         * Validate Data
         * Mass Assignment
         * Return Message
         */
        $rules = ['name' => 'unique:centers,name', 'vol_id' => 'required'];
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => $validate->getMessageBag()->toArray()]);
        } else {
            Center::create(
                [
                    'volume_id' => $request->vol_id,
                    'name' => $request->name,
                    'description' => $request->description,
                ]
            );

            return response()->json(['success' => true, 'message' => 'Center Registration Successfull']);
        }
    }

    /**
     * Create new Type
     */
    public function typeCreate(Request $request)
    {
        /**
         * Validate Data
         * Mass Assignment
         * Return Message
         */
        $validate = Validator::make($request->all(), ['name' => 'unique:types,name']);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => 'Type Name already exists!']);
        } else {
            $type = new Type();
            $type->name = $request->name;
            $type->description = $request->description;
            $type->savings = ($request->saving ? $request->saving : false);
            $type->loans = ($request->loan ? $request->loan : false);
            $type->time_period = $request->time;
            $type->save();

            return response()->json(['success' => true, 'message' => 'Type Registration Successfull']);
        }
    }

    /**
     * Employee Registration FORM
     */
    public function employeeRegistration()
    {
        $roles = Role::whereNotIn('name', ['Developer'])->get();
        return view('offices.registrations.createEmployee', compact('roles'));
    }

    /**
     * Employee Registration
     */
    public function employeeCreate(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8'],
            'role' => ['required']
        ]);
        if (!empty($request->mobile)) {
            $request->validate([
                'mobile' => ['min:11', 'max:11']
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile
        ]);

        $user->assignRole($request->role);
        $user->sendEmailVerificationNotification();

        return redirect(Route('employee'))->with('success', 'Employee has successfully registered');
    }
}
