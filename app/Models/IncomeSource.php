<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeSource extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'amount',
        'frequency',
        'start_date',
        'end_date',
        'description',
        'is_active'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMonthlyAmountAttribute()
    {
        return match($this->frequency) {
            'monthly' => $this->amount,
            'yearly' => $this->amount / 12,
            'one_time' => 0,
            default => 0
        };
    }
} 