<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanSavingWithdrawal extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'loan_profile_id', 'volume_id', 'center_id', 'type_id', 'officer_id', 'client_id', 'acc_no', 'balance',
        'withdraw', 'balance_remaining', 'expression'
    ];

    /**
     * Relation with Type Table
     */
    public function Type()
    {
        return $this->belongsTo(Type::class);
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
     * Relation with ClientRegister Table
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
        return $this->belongsTo(User::class, 'officer_id', 'id');
    }

    /**
     * Local Scope Common Queries
     */
    private function CommonQueries($query, $field, $id)
    {
        return $query->where($field, $id)
            ->where('status', '1')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'));
    }

    /**
     * Savings Collection Chart Local Scope
     */
    public function scopeLoanSavingWithdrawalChart($query, $field, $id, $param)
    {
        return $this->CommonQueries($query, $field, $id)
            ->select(
                DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as date"),
                DB::raw("(sum($param)) as $param")
            )
            ->groupBy('date')
            ->get()
            ->toJson();
    }

    /**
     * Loan Saving withdrawal Sum Chart Local Scope
     */
    public function scopeLoanSavingsWithdrawalSumChart($query, $field, $id, $param)
    {
        return $this->CommonQueries($query, $field, $id)
            ->sum($param);
    }
}
