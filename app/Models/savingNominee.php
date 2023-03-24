<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class savingNominee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'saving_profile_id', 'name', 'dob', 'segment', 'relation', 'nominee_image'
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
}
