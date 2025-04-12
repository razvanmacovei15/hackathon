<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseholdMember extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'relationship',
        'is_primary',
        'occupation',
        'employer',
        'base_salary',
        'salary_frequency',
        'notes'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'base_salary' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function incomes()
    {
        return $this->hasMany(HouseholdMemberIncome::class);
    }

    public function getMonthlyBaseSalaryAttribute()
    {
        if (!$this->base_salary) return 0;
        
        return $this->salary_frequency === 'yearly' 
            ? $this->base_salary / 12 
            : $this->base_salary;
    }

    public function getTotalMonthlyIncomeAttribute()
    {
        $baseSalary = $this->monthly_base_salary;
        $additionalIncome = $this->incomes()
            ->where('is_active', true)
            ->get()
            ->sum(function ($income) {
                return match($income->frequency) {
                    'monthly' => $income->amount,
                    'yearly' => $income->amount / 12,
                    'one_time' => 0,
                    default => 0
                };
            });

        return $baseSalary + $additionalIncome;
    }
} 