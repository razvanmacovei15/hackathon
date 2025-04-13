<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMonthlyDebtPayment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'debt_type_id',
        'name',
        'total_amount',
        'remaining_amount',
        'minimum_payment',
    ];

    /**
     * Get the user that owns the monthly debt payment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the debt type associated with the monthly debt payment.
     */
    public function debtType()
    {
        return $this->belongsTo(DebtType::class);
    }
}
