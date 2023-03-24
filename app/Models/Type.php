<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'savings',
        'loans',
        'time_period',
        'status'
    ];

    /**
     * Relation with Savngs Collection Table
     */
    public function SavingsCollection()
    {
        return $this->hasMany(SavingsCollection::class);
    }

    /**
     * Relation with Savngs Collection Table
     */
    public function LoanCollection()
    {
        return $this->hasMany(LoanCollection::class);
    }

    /**
     * Relation with Savngs Withdrawal Table
     */
    public function SavingWithdrawal()
    {
        return $this->hasMany(SavingWithdrawal::class);
    }

    /**
     * Relation with Loan Savngs Withdrawal Table
     */
    public function LoanSavingWithdrawal()
    {
        return $this->hasMany(LoanSavingWithdrawal::class);
    }

    /**
     * Relation with SavingsToSavingsTransaction Table
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
