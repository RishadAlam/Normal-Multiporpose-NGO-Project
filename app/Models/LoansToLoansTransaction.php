<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoansToLoansTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'from_volume_id', 'from_center_id', 'from_type_id', 'from_client_id', 'from_loan_profile_id', 'from_acc_no', 'from_acc_main_balance', 'from_acc_trans_balance', 'to_volume_id', 'to_center_id', 'to_type_id', 'to_client_id', 'to_loan_profile_id', 'to_acc_no', 'to_acc_main_balance', 'to_acc_trans_balance', 'officer_id', 'amount', 'expression'
    ];

    /**
     * Relation with From Type Table
     */
    public function from_type()
    {
        return $this->belongsTo(Type::class, 'from_type_id', 'id');
    }

    /**
     * Relation with To Type Table
     */
    public function to_type()
    {
        return $this->belongsTo(Type::class, 'to_type_id', 'id');
    }


    /**
     * Relation with from_client_register Table
     */
    public function from_client_register()
    {
        return $this->belongsTo(ClientRegister::class, 'from_client_id', 'id');
    }

    /**
     * Relation with to_client_register Table
     */
    public function to_client_register()
    {
        return $this->belongsTo(ClientRegister::class, 'to_client_id', 'id');
    }

    /**
     * Relation with users Table
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'officer_id', 'id');
    }
}
