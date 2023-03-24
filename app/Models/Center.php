<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'volume_id',
        'name',
        'description',
        'status'
    ];

    /**
     * Relation with Volume Table
     */
    public function volume()
    {
        return $this->belongsTo(Volume::class);
    }

    /**
     * Relation with Savngs Collection Table
     */
    public function SavingsCollection()
    {
        return $this->hasMany(SavingsCollection::class);
    }

    /**
     * Relation with Loan Collection Table
     */
    public function LoanCollection()
    {
        return $this->hasMany(LoanCollection::class);
    }

    /**
     * Relation with Savngs Collection Table
     */
    public function ClientRegister()
    {
        return $this->hasMany(ClientRegister::class);
    }

    /**
     * Relation with Savngs Collection Table
     */
    public function SavingsProfile()
    {
        return $this->hasMany(SavingsProfile::class);
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
     * Relation with Savngs Collection Table
     */
    public function LoanProfile()
    {
        return $this->hasMany(LoanProfile::class);
    }
}
