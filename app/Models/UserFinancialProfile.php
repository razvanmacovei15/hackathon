<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFinancialProfile extends Model
{
    protected $fillable = [
        'user_id',
        'household_income',
        'food_expenses',
        'transport_expenses',
        'bills_expenses',
        'car_loan',
        'mortgage',
        'credit_card_debt',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
