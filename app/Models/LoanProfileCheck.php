<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanProfileCheck extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'loan_profile_id', 'officer_id', 'acc_no', 'balance', 'loan_recovered', 'loan_remaining', 'interest_recovered', 'interest_remaining', 'expression'
    ];

    /**
     * Relation with User Table
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'officer_id', 'id');
    }
}
