<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingsCollection extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'saving_profile_id', 'volume_id', 'center_id', 'type_id', 'officer_id', 'client_id', 'acc_no', 'deposit', 'expression'
    ];

    /**
     * Relation with Volume Table
     */
    public function volume()
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
     * Relation with Center Table
     */
    public function SavingsProfile()
    {
        return $this->belongsTo(SavingsProfile::class, 'saving_profile_id', 'id');
    }

    /**
     * Relation with Center Table
     */
    public function Type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Relation with User Table
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'officer_id', 'id');
    }

    /**
     * Relation with Client register Table
     */
    public function ClientRegister()
    {
        return $this->belongsTo(ClientRegister::class, 'client_id', 'id');
    }

    /**
     * Local Scope Common Queries
     */
    private function CommonQueries($query, $field, $id)
    {
        return $query->where($field, $id)
            ->where('status', '1')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'));
    }

    /**
     * Savings Collection Chart Local Scope
     */
    public function scopeSavingCollectionsChart($query, $field, $id)
    {
        return $this->CommonQueries($query, $field, $id)
            ->select(
                DB::raw("(DATE_FORMAT(created_at, '%d-%m-%Y')) as date"),
                DB::raw("(sum(deposit)) as deposit")
            )
            ->groupBy('date')
            ->get()
            ->toJson();
    }

    /**
     * Savings Collection Sum Chart Local Scope
     */
    public function scopeSavingCollectionsSumChart($query, $field, $id)
    {
        return $this->CommonQueries($query, $field, $id)
            ->sum('deposit');
    }
}
