<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBadDebt extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'total_amount',
        'minimum_payment',
        'interest_rate',
        'current_balance',
        'start_date',
        'due_date',
        'term_months',
        'account_number',
        'lender_name',
        'notes',
        'is_active'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'minimum_payment' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'start_date' => 'date',
        'due_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(BadDebtCategory::class, 'category_id');
    }

    public function getMonthlyInterestAttribute()
    {
        return ($this->current_balance * ($this->interest_rate / 100)) / 12;
    }

    public function getTotalMonthlyPaymentAttribute()
    {
        return $this->minimum_payment + $this->monthly_interest;
    }
} 