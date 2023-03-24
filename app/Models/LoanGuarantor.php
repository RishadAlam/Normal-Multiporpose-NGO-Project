<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanGuarantor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'loan_profile_id', 'name', 'father_name', 'mother_name', 'nid', 'address', 'guarentor_image'
    ];
    
}
