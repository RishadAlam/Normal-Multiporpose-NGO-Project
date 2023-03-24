<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    /**
     * Relation with Center Table
     */
    public function center()
    {
        return $this->hasMany(Center::class);
    }

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
     * Relation with LoanSavings Withdrawal Table
     */
    public function LoanSavingWithdrawal()
    {
        return $this->hasMany(LoanSavingWithdrawal::class, 'client_id', 'id');
    }

    /**
     * Relation with Savings Withdrawal Table
     */
    public function SavingWithdrawal()
    {
        return $this->hasMany(SavingWithdrawal::class, 'client_id', 'id');
    }
}
