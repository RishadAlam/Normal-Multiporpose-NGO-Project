<?php

namespace App\Models;

use App\Models\SavingsProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientRegister extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'volume_id', 'center_id', 'type_id', 'registration_officer_id', 'acc_no', 'share', 'name', 'husband_or_father_name', 'mother_name', 'nid', 'academic_qualification', 'dob', 'religion', 'occupation', 'gender', 'mobile', 'client_image', 'client_image', 'permanent_address'
    ];

    /**
     * Mutator for month
     */
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] =  date('Y-m-d', strtotime($value));
    }

    /**
     * accessor for date
     */
    public function getDobAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    /**
     * Relation with Savings profile Table
     */
    public function SavingsProfile()
    {
        return $this->hasMany(SavingsProfile::class, 'client_id', 'id');
    }

    /**
     * Relation with Savings Collection Table
     */
    public function SavingsCollection()
    {
        return $this->hasMany(SavingsCollection::class, 'client_id', 'id');
    }

    /**
     * Relation with Savings Withdrawal Table
     */
    public function SavingWithdrawal()
    {
        return $this->hasMany(SavingWithdrawal::class, 'client_id', 'id');
    }

    /**
     * Relation with LoanSavings Withdrawal Table
     */
    public function LoanSavingWithdrawal()
    {
        return $this->hasMany(LoanSavingWithdrawal::class, 'client_id', 'id');
    }

    /**
     * Relation with Loan Collection Table
     */
    public function LoanCollection()
    {
        return $this->hasMany(LoanCollection::class, 'client_id', 'id');
    }

    /**
     * Relation with Loan profile Table
     */
    public function LoanProfile()
    {
        return $this->hasMany(LoanProfile::class);
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
     * Relation with SavingsToLoansTransaction Table
     */
    public function SavingsToSavingsTransaction()
    {
        return $this->hasMany(SavingsToSavingsTransaction::class);
    }

    /**
     * Relation with SavingsToLoansTransaction Table
     */
    public function SavingsToLoansTransaction()
    {
        return $this->hasMany(SavingsToLoansTransaction::class);
    }

    /**
     * Relation with LoansToLoansTransaction Table
     */
    public function LoansToLoansTransaction()
    {
        return $this->hasMany(LoansToLoansTransaction::class);
    }

    /**
     * Relation with LoansToSavingsTransaction Table
     */
    public function LoansToSavingsTransaction()
    {
        return $this->hasMany(LoansToSavingsTransaction::class);
    }
}
