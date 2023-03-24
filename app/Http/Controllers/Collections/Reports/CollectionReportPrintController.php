<?php

namespace App\Http\Controllers\Collections\Reports;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\Center;
use App\Models\Volume;
use Illuminate\Http\Request;
use App\Models\SavingsProfile;
use App\Http\Controllers\Controller;
use App\Models\LoanProfile;
use Illuminate\Support\Facades\Auth;

class CollectionReportPrintController extends Controller
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

    private function SavingsReport($type_id, $volume_id, $officer, $start_date = null, $end_date = null)
    {
        return Center::where('status', '1')
            ->where('volume_id', $volume_id)
            ->with(
                [
                    'SavingsProfile' => function ($query) use ($type_id, $volume_id, $officer, $start_date, $end_date) {
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
                                'SavingsCollection' => function ($query) use ($type_id, $officer, $start_date, $end_date) {
                                    $query->select(
                                        'id',
                                        'saving_profile_id',
                                        'expression',
                                        'officer_id',
                                        'deposit',
                                        'created_at AS date'
                                    );
                                    $query->where('status', '2');
                                    $query->where('type_id', $type_id);
                                    $query->when($start_date != null, function ($query) use ($start_date, $end_date) {
                                        $query->whereBetween('created_at', [$start_date, $end_date]);
                                    }, function ($query) {
                                        $query->whereDate('created_at', date('Y-m-d'));
                                    });
                                    $query->when($officer != 0, function ($query) use ($officer) {
                                        $query->where('officer_id', $officer);
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
    }
    private function LoansReport($type_id, $volume_id, $officer, $start_date = null, $end_date = null)
    {
        return Center::where('status', '1')
            ->where('volume_id', $volume_id)
            ->with(
                [
                    'LoanProfile' => function ($query) use ($type_id, $volume_id, $officer, $start_date, $end_date) {
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
                                'LoanCollection' => function ($query) use ($type_id, $officer, $start_date, $end_date) {
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
                                    $query->when($start_date != null, function ($query) use ($start_date, $end_date) {
                                        $query->whereBetween('created_at', [$start_date, $end_date]);
                                    }, function ($query) {
                                        $query->whereDate('created_at', date('Y-m-d'));
                                    });
                                    $query->when($officer != 0, function ($query) use ($officer) {
                                        $query->where('officer_id', $officer);
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
    }

    // Regular Saving Collection Print
    public function regularSavingsPrint($type_id, $volume_id, $officer)
    {
        $savings = $this->SavingsReport($type_id, $volume_id, $officer);
        $type = Type::find($type_id, ['id', 'name']);
        $volume = Volume::find($volume_id, ['id', 'name']);

        // dd($officer);
        return view('offices.collections.reports.regular.savings.collectionReportPrint', compact('savings', 'type', 'volume'));
    }

    // Pending Saving Collection Print
    public function pendingSavingsPrint($type_id, $volume_id, $officer, $start_date = null, $end_date = null)
    {
        if ($start_date == 'null' && $end_date == 'null') {
            $startDate = Carbon::now()->startOfMonth()->toDateTimeString();
            $endDate = Carbon::now()->subDay()->endOfDay()->toDateTimeString();
        } else {
            $startDate = Carbon::parse($start_date)->startOfDay()->toDateTimeString();
            $endDate = Carbon::parse($end_date)->startOfDay()->toDateTimeString();
        }

        $savings = $this->SavingsReport($type_id, $volume_id, $officer, $startDate, $endDate);
        $type = Type::find($type_id, ['id', 'name']);
        $volume = Volume::find($volume_id, ['id', 'name']);

        // dd($officer);
        return view('offices.collections.reports.regular.savings.collectionReportPrint', compact('savings', 'type', 'volume', 'startDate', 'endDate'));
    }

    // Regular Loan Collection Print
    public function regularLoanPrint($type_id, $volume_id, $officer)
    {
        $loans = $this->LoansReport($type_id, $volume_id, $officer);
        $type = Type::find($type_id, ['id', 'name']);
        $volume = Volume::find($volume_id, ['id', 'name']);

        return view('offices.collections.reports.regular.loans.loanCollectionReportPrint', compact('loans', 'type', 'volume'));
    }

    // Pending Loan Collection print
    public function pendingLoanPrint($type_id, $volume_id, $officer, $start_date = null, $end_date = null)
    {
        if ($start_date == 'null' && $end_date == 'null') {
            $startDate = Carbon::now()->startOfMonth()->toDateTimeString();
            $endDate = Carbon::now()->subDay()->endOfDay()->toDateTimeString();
        } else {
            $startDate = Carbon::parse($start_date)->startOfDay()->toDateTimeString();
            $endDate = Carbon::parse($end_date)->startOfDay()->toDateTimeString();
        }

        $loans = $this->LoansReport($type_id, $volume_id, $officer, $startDate, $endDate);
        $type = Type::find($type_id, ['id', 'name']);
        $volume = Volume::find($volume_id, ['id', 'name']);

        return view('offices.collections.reports.regular.loans.loanCollectionReportPrint', compact('loans', 'type', 'volume'));
    }

    // Saving Account Print
    public function activeSavingsAccountsPrint($name = null, $id)
    {
        $activeSavingsList = SavingsProfile::where('status', '1')
            ->where('type_id', $id)
            ->with('ClientRegister:id,name,share')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->select('id', 'volume_id', 'center_id', 'type_id', 'client_id', 'acc_no', 'status', 'balance')
            ->orderBy('acc_no')
            ->get();

        $type = Type::find($id, ['id', 'name']);

        return view('offices.summary.accounts.activeSavingsAccountPrint', compact('activeSavingsList', 'type'));
    }

    // Loan Account Print
    public function activeloanAccountsPrint($name = null, $id)
    {
        $activeLoanList = LoanProfile::where('status', '1')
            ->where('type_id', $id)
            ->with('ClientRegister:id,name,share')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->select('id', 'volume_id', 'center_id', 'type_id', 'client_id', 'acc_no', 'status', 'balance', 'loan_given', 'loan_recovered', 'loan_remaining', 'interest_recovered', 'interest_remaining')
            ->orderBy('acc_no')
            ->get();

        $type = Type::find($id, ['id', 'name']);

        return view('offices.summary.accounts.activeLoanAccountPrint', compact('activeLoanList', 'type'));
    }
}
