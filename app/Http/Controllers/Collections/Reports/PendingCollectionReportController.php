<?php

namespace App\Http\Controllers\Collections\Reports;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\User;
use App\Models\Center;
use App\Models\Volume;
use App\Models\LoanProfile;
use Illuminate\Http\Request;
use App\Models\LoanCollection;
use App\Models\SavingsProfile;
use App\Models\SavingsCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PendingCollectionReportController extends Controller
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
     * Show Pending Collection report
     */
    public function showPendingCollectionReport()
    {
        $savings = Type::where('savings', true)
            ->where('status', true)
            ->with(
                [
                    'SavingsCollection' => function ($query) {
                        $query->select(
                            // 'id',
                            'type_id',
                            DB::raw('SUM(deposit) AS deposit')
                        );
                        $query->groupBy('type_id');
                        $query->where('status', '2');
                        $query->whereDate('created_at', '<', date('Y-m-d'));
                        if (!Auth::user()->can('Collection Report View as an Admin')) {
                            $query->where('officer_id', Auth::user()->id);
                        }
                    }
                ]
            )
            ->get(['id', 'name']);

        $loans = Type::where('loans', true)
            ->where('status', true)
            ->with(
                [
                    'LoanCollection' => function ($query) {
                        $query->select(
                            'id',
                            'type_id',
                            DB::raw(
                                'SUM(deposit) AS deposit,
                                SUM(loan) AS loan,
                                SUM(interest) AS interest,
                                SUM(total) AS total'
                            )
                        );
                        $query->groupBy('type_id');
                        $query->where('status', '2');
                        $query->whereDate('created_at', '<', date('Y-m-d'));
                        if (!Auth::user()->can('Collection Report View as an Admin')) {
                            $query->where('officer_id', Auth::user()->id);
                        }
                    }
                ]
            )
            ->get(['id', 'name']);

        return view('offices.collections.reports.panding.pendingCollection', compact('savings', 'loans'));
    }

    /**
     * Savings Report
     */
    public function showPendingCollectionReportSavingsVolumes($id)
    {
        $savings = Volume::where('status', true)
            ->with(
                [
                    'SavingsCollection' => function ($query) use ($id) {
                        $query->select(
                            'volume_id',
                            DB::raw('SUM(deposit) AS deposit')
                        );
                        $query->groupBy('volume_id');
                        $query->where('status', '2');
                        $query->where('type_id', $id);
                        $query->whereDate('created_at', '<', date('Y-m-d'));
                        if (!Auth::user()->can('Collection Report View as an Admin')) {
                            $query->where('officer_id', Auth::user()->id);
                        }
                    }
                ]
            )
            ->get(['id', 'name']);

        $type = Type::find($id, ['id', 'name']);

        return view('offices.collections.reports.panding.savings.volumeReports', compact('savings', 'type'));
    }

    /**
     * Savings Report
     */
    public function showPendingCollectionReportSavingsReports($type_id, $volume_id)
    {
        $startDate = null;
        $endDate = null;
        $officer_id = null;
        if (isset(request()->startDate)) {
            $startDate = Carbon::parse(request()->startDate)->startOfDay()->toDateTimeString();
            $endDate = Carbon::parse(request()->endDate)->endOfDay()->toDateTimeString();
        }
        if (isset(request()->officer)) {
            $officer_id = request()->officer;
        }

        $savings = Center::where('status', '1')
            ->where('volume_id', $volume_id)
            ->with(
                [
                    'SavingsProfile' => function ($query) use ($type_id, $volume_id, $startDate, $endDate, $officer_id) {
                        $query->where('status', '1');
                        $query->where('type_id', $type_id);
                        $query->where('volume_id', $volume_id);
                        $query->select(
                            'id',
                            'center_id',
                            'client_id',
                            'acc_no',
                            'deposit'
                        );
                        $query->with(
                            [
                                'ClientRegister' => function ($query) {
                                    $query->select(
                                        'id',
                                        'name'
                                    );
                                }
                            ]
                        );
                        $query->with(
                            [
                                'SavingsCollection' => function ($query) use ($type_id, $startDate, $endDate, $officer_id) {
                                    $query->select(
                                        'id',
                                        'saving_profile_id',
                                        'expression',
                                        'officer_id',
                                        'deposit',
                                        'created_at AS time'
                                    );
                                    $query->where('status', '2');
                                    $query->where('type_id', $type_id);
                                    $query->whereDate('created_at', '<', date('Y-m-d'));
                                    $query->when(isset($startDate), function ($query) use ($startDate, $endDate) {
                                        $query->whereBetween('created_at', [$startDate, $endDate]);
                                    }, function ($query) {
                                        $query->whereMonth('created_at', date('m'));
                                        $query->whereYear('created_at', date('Y'));
                                    });
                                    $query->when(isset($officer_id), function ($query) use ($officer_id) {
                                        $query->where('officer_id', $officer_id);
                                    });
                                    if (!Auth::user()->can('Collection Report View as an Admin')) {
                                        $query->where('officer_id', Auth::user()->id);
                                    }
                                    $query->with(
                                        [
                                            'User' => function ($query) {
                                                $query->select(
                                                    'id',
                                                    'name'
                                                );
                                            }
                                        ]
                                    );
                                }
                            ]
                        );
                    }
                ]
            )
            ->get(['id', 'name']);


        // dd($savings->toArray());

        $type = Type::find($type_id, ['id', 'name']);
        $volume = Volume::find($volume_id, ['id', 'name']);
        $officers = User::whereNotIn('email', ['admin@gmail.com'])
            ->where('status', '1')
            ->get();

        return view('offices.collections.reports.panding.savings.collectionReport', compact('savings', 'type', 'volume', 'officers'));
    }


    /**
     * Find Collection
     * Delete Saving Collection
     * Return Success
     */
    public function deleteSavingCollection(Request $request)
    {
        $savings = SavingsCollection::find($request->id)->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get Collection and other relationship
     * return to the view
     */
    public function editSavingCollection(Request $request)
    {
        $savings = SavingsCollection::where('id', $request->id)
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->first(
                ['id', 'saving_profile_id', 'volume_id', 'center_id', 'type_id', 'client_id', 'acc_no', 'deposit', 'expression']
            );

        return response()->json($savings);
    }


    /**
     * Validation Data
     * Get Collection
     * Update Collection
     * return success
     */
    public function updateSavingCollection(Request $request)
    {
        // Validate Data
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required',
                'center' => 'required',
                'acc_no' => 'required|numeric',
                'client_id' => 'required|numeric',
                'collection_id' => 'required|numeric',
                'savingType' => 'required',
                'deposit' => 'required|numeric',
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
            $savings = SavingsCollection::find($request->collection_id)
                ->update(
                    [
                        'deposit' => $request->deposit,
                        'expression' => $request->description
                    ]
                );

            // Return Success
            return response()->json(['success' => true]);
        }
    }

    /**
     * Saving Collection approve
     * Get Collection Profile Info
     * Collection Deposit to account 
     * Collection Approved
     * Return Success
     */
    public function approveSavingCollection(Request $request)
    {
        DB::transaction(function () use ($request) {

            // Get Collection Profile Info
            $collections = SavingsCollection::whereIn('id', $request->id)
                ->select('id', 'saving_profile_id', 'deposit')
                ->get();

            // Collection Deposit to account 
            foreach ($collections as $collection) {
                SavingsProfile::find($collection->saving_profile_id)
                    ->update(
                        [
                            'total_deposit' => DB::raw('total_deposit + "' . $collection->deposit . '"')
                        ]
                    );
            }

            // Collection Approved
            SavingsCollection::whereIn('id', $request->id)->update(['status' => '1']);
        });

        return response()->json(['success' => true]);
    }

    /**
     * Loan Collections Volume Report
     * Get the volume
     * Get Sum of collection
     * Get Type name
     * return view
     */
    public function showPendingCollectionReportLoansVolumes($id)
    {
        $loans = Volume::where('status', true)
            ->with(
                [
                    'LoanCollection' => function ($query) use ($id) {
                        $query->select(
                            'volume_id',
                            DB::raw(
                                'SUM(deposit) AS deposit,
                                SUM(loan) AS loan,
                                SUM(interest) AS interest,
                                SUM(total) AS total'
                            )
                        );
                        $query->groupBy('volume_id');
                        $query->where('status', '2');
                        $query->where('type_id', $id);
                        $query->whereDate('created_at', '<', date('Y-m-d'));
                        if (!Auth::user()->can('Collection Report View as an Admin')) {
                            $query->where('officer_id', Auth::user()->id);
                        }
                    }
                ]
            )
            ->get(['id', 'name']);

        $type = Type::find($id, ['id', 'name']);

        return view('offices.collections.reports.panding.loans.volumeReports', compact('loans', 'type'));
    }


    /**
     * Loan Collections Center Report
     */
    public function showPendingCollectionReportLoansReports(Request $request, $type_id, $volume_id)
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
        $loanCollections = Center::where('status', '1')
            ->where('volume_id', $volume_id)
            ->with(
                [
                    'LoanProfile' => function ($query) use ($type_id, $volume_id, $startDate, $endDate, $officer_id) {
                        $query->where('status', '1');
                        $query->where('type_id', $type_id);
                        $query->where('volume_id', $volume_id);
                        $query->select(
                            'id',
                            'center_id',
                            'client_id',
                            'acc_no',
                            'deposit',
                            'loan_installment',
                            'interest_installment'
                        );
                        $query->with(
                            [
                                'ClientRegister' => function ($query) {
                                    $query->select(
                                        'id',
                                        'name'
                                    );
                                }
                            ]
                        );
                        $query->with(
                            [
                                'LoanCollection' => function ($query) use ($type_id, $startDate, $endDate, $officer_id) {
                                    $query->select(
                                        'id',
                                        'loan_profile_id',
                                        'expression',
                                        'officer_id',
                                        'installment',
                                        'deposit',
                                        'loan',
                                        'interest',
                                        'total',
                                        'created_at AS time'
                                    );
                                    $query->where('status', '2');
                                    $query->where('type_id', $type_id);
                                    $query->whereDate('created_at', '<', date('Y-m-d'));
                                    $query->when(isset($startDate), function ($query) use ($startDate, $endDate) {
                                        $query->whereBetween('created_at', [$startDate, $endDate]);
                                    }, function ($query) {
                                        $query->whereMonth('created_at', date('m'));
                                        $query->whereYear('created_at', date('Y'));
                                    });
                                    $query->when(isset($officer_id), function ($query) use ($officer_id) {
                                        $query->where('officer_id', $officer_id);
                                    });
                                    if (!Auth::user()->can('Collection Report View as an Admin')) {
                                        $query->where('officer_id', Auth::user()->id);
                                    }
                                    $query->with(
                                        [
                                            'User' => function ($query) {
                                                $query->select(
                                                    'id',
                                                    'name'
                                                );
                                            }
                                        ]
                                    );
                                }
                            ]
                        );
                    }
                ]
            )
            ->get(['id', 'name']);


        // dd($loanCollections->toArray());

        $type = Type::find($type_id, ['id', 'name']);
        $volume = Volume::find($volume_id, ['id', 'name']);
        $officers = User::whereNotIn('email', ['admin@gmail.com'])
            ->where('status', '1')
            ->get();

        return view('offices.collections.reports.panding.loans.collectionReports', compact('loanCollections', 'type', 'volume', 'officers'));
    }

    /**
     * Find Collection
     * Delete Loan Collection
     * Return Success
     */
    public function deleteLoanCollection(Request $request)
    {
        $loans = LoanCollection::find($request->id)->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get Collection and other relationship
     * return to the view
     */
    public function editLoanCollection(Request $request)
    {
        $loans = LoanCollection::where('id', $request->id)
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->first(
                ['id', 'loan_profile_id', 'volume_id', 'center_id', 'type_id', 'client_id', 'acc_no', 'installment', 'deposit', 'loan', 'interest', 'total', 'expression']
            );

        return response()->json($loans);
    }

    /**
     * Validation Data
     * Get Collection
     * Update Collection
     * return success
     */
    public function updateLoansCollection(Request $request)
    {
        // Validate Data
        $validate = Validator::make(
            $request->all(),
            [
                'volume' => 'required',
                'center' => 'required',
                'acc_no' => 'required|numeric',
                'client_id' => 'required|numeric',
                'collection_id' => 'required|numeric',
                'loanType' => 'required',
                'installment' => 'required|numeric',
                'deposit' => 'required|numeric',
                'loan' => 'required|numeric',
                'interest' => 'required|numeric',
                'total' => 'required|numeric',
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
            $savings = LoanCollection::find($request->collection_id)
                ->update(
                    [
                        'installment' => $request->installment,
                        'deposit' => $request->deposit,
                        'loan' => $request->loan,
                        'interest' => $request->interest,
                        'total' => $request->total,
                        'expression' => $request->description
                    ]
                );

            // Return Success
            return response()->json(['success' => true]);
        }
    }

    /**
     * Saving Collection approve
     * Get Collection Profile Info
     * Collection Deposit to account 
     * Collection Approved
     * Return Success
     */
    public function approveLoanCollection(Request $request)
    {
        DB::transaction(function () use ($request) {

            // Get Collection Profile Info
            $collections = LoanCollection::whereIn('id', $request->id)
                ->select('id', 'loan_profile_id', 'deposit', 'installment', 'loan', 'interest')
                ->get();
            // Collection Deposit to account 
            foreach ($collections as $collection) {
                LoanProfile::find($collection->loan_profile_id)
                    ->update(
                        [
                            // 'collected_installment' => DB::raw('collected_installment + "' . $collection->installment . '"'),
                            'total_deposit' => DB::raw('total_deposit + "' . $collection->deposit . '"'),
                            'loan_recovered' => DB::raw('loan_recovered + "' . $collection->loan . '"'),
                            'interest_recovered' => DB::raw('interest_recovered + "' . $collection->interest . '"'),
                            'installment_recovered' => DB::raw('installment_recovered + "' . $collection->installment . '"')
                        ]
                    );
            }

            // Collection Approved
            LoanCollection::whereIn('id', $request->id)->update(['status' => '1']);
        });

        return response()->json(['success' => true]);
    }
}
