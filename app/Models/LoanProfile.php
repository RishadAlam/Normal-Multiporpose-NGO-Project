<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanProfile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'client_id', 'acc_no', 'start_date', 'duration_date', 'deposit', 'loan_given', 'total_installment', 'interest', 'total_interest', 'total_loan_inc_int', 'loan_installment', 'interest_installment', 'collected_installment', 'installment_recovered', 'total_deposit', 'total_withdrawal', 'loan_recovered', 'interest_recovered', 'collection_ids', 'withdrawal_ids', 'status', 'closing_expression', 'closing_at'
    ];

    /**
     * Mutator for month
     */
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] =  date('Y-m-d', strtotime($value));
    }
    public function setDurationDateAttribute($value)
    {
        $this->attributes['duration_date'] =  date('Y-m-d', strtotime($value));
    }

    /**
     * accessor for date
     */
    public function getStartDateAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
    public function getDurationDateAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    /**
     * Relation with Volume Table
     */
    public function ClientRegister()
    {
        return $this->belongsTo(ClientRegister::class, 'client_id', 'id');
    }

    /**
     * Relation with User Table
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'registration_officer_id', 'id');
    }

    /**
     * Relation with Volume Table
     */
    public function Volume()
    {
        return $this->belongsTo(Volume::class);
    }

    /**
     * Relation with Center Table
     */
    public function Center()
    {
        return $this->belongsTo(Center::class);
    }

    /**
     * Relation with Type Table
     */
    public function Type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Relation with LoanCollection Table
     */
    public function LoanCollection()
    {
        return $this->hasMany(LoanCollection::class);
    }

    /**
     * Relation with LoanGuarantor Table
     */
    public function LoanGuarantor()
    {
        return $this->hasMany(LoanGuarantor::class);
    }

    /**
     * Local Scope Common Queries
     */
    private function CommonQueries($query, $field, $id, $status, $param)
    {
        return $query->where($field, $id)
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            }, function ($query) {
                return $query->onlyTrashed();
            })
            ->whereMonth($param, date('m'))
            ->whereYear($param, date('Y'));
    }

    /**
     * Savings Collection Chart Local Scope
     */
    public function scopeLoansAdmittedChart($query, $field, $id, $status, $param)
    {
        return $this->CommonQueries($query, $field, $id, $status, $param)
            ->select(
                DB::raw("(DATE_FORMAT($param, '%d-%m-%Y')) as date"),
                DB::raw("(count(*)) as total")
            )
            ->groupBy('date')
            ->get()
            ->toJson();
    }

    /**
     * Savings Admitted Sum Chart Local Scope
     */
    public function scopeLoanAdmittedSumChart($query, $field, $id, $status, $param)
    {
        return $this->CommonQueries($query, $field, $id, $status, $param)
            ->count();
    }

    /**
     * Accounts List Local Scope
     */
    public function scopeAccountLists($query, $id, $status, $param, $page)
    {
        return $query->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        }, function ($query) {
            return $query->onlyTrashed();
        })
            ->where($param, $id)
            ->with('ClientRegister:id,name')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->select('id', 'volume_id', 'center_id', 'type_id', 'client_id', 'acc_no', 'status', 'balance', 'loan_recovered', 'loan_remaining')
            ->orderBy('acc_no')
            ->paginate($page)
            ->withQueryString();
    }

    /**
     * Accounts Details Local Scope
     */
    public function scopeAccountdetails($query, $id, $status)
    {
        return $query->when($status, function ($query) use ($status) {
            return $query->where('status', $status);
        }, function ($query) {
            return $query->onlyTrashed();
        })
            ->where('client_id', $id)
            ->with('User:id,name')
            ->with('Type:id,name')
            ->with('LoanGuarantor:id,loan_profile_id,name,father_name,mother_name,nid,guarentor_image,address')
            ->get();
    }
}
