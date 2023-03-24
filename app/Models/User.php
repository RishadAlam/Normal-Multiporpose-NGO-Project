<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'father_name',
        'mother_name',
        'nid',
        'dob',
        'bloog_group',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation with Savngs Collection Table
     */
    public function SavingsCollection()
    {
        return $this->hasMany(SavingsCollection::class, 'officer_id', 'id');
    }

    /**
     * Relation with LoanCollection Table
     */
    public function LoanCollection()
    {
        return $this->hasMany(LoanCollection::class, 'officer_id', 'id');
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
