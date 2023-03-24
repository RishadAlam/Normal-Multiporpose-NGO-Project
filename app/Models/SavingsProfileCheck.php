<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsProfileCheck extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'saving_profile_id', 'officer_id', 'acc_no', 'balance', 'expression'
    ];

    /**
     * Relation with User Table
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'officer_id', 'id');
    }
}
