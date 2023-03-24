<?php

namespace App\Models;

use App\Models\ClientRegister;
use App\Models\SavingNominee;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingsProfile extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'client_id', 'acc_no', 'start_date', 'duration_date', 'deposit', 'installment', 'total_except_interest', 'interest', 'total_include_interest', 'status', 'total_deposit', 'total_withdrawal', 'collection_ids', 'withdrawal_ids', 'closing_interest', 'closing_balance_include_interest', 'closing_expression', 'closing_at'
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
     * Relation with SavingNominee Table
     */
    public function SavingNominee()
    {
        return $this->hasMany(savingNominee::class, 'saving_profile_id', 'id');
    }

    /**
     * Relation with SavingsCollection Table
     */
    public function SavingsCollection()
    {
        return $this->hasMany(SavingsCollection::class, 'saving_profile_id', 'id');
    }

    /**
     * Relation with SavingWithdrawal Table
     */
    public function SavingWithdrawal()
    {
        return $this->hasMany(SavingWithdrawal::class, 'saving_profile_id', 'id');
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
     * Savings Admitted Chart Local Scope
     */
    public function scopeSavingsAdmittedChart($query, $field, $id, $status, $param)
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
    public function scopeSavingAdmittedSumChart($query, $field, $id, $status, $param)
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
            ->with('ClientRegister:id,name,share')
            ->with('Volume:id,name')
            ->with('Center:id,name')
            ->with('Type:id,name')
            ->select('id', 'volume_id', 'center_id', 'type_id', 'client_id', 'acc_no', 'status', 'balance')
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
            ->with('SavingNominee:id,saving_profile_id,name,dob,segment,relation,nominee_image')
            ->get();
    }
}
