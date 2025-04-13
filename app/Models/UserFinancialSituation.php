<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFinancialSituation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_earnings',
        'total_debt',
        'total_remaining_debt',
        'total_savings',
        'total_remaining_savings_goal',
        'total_expenses',
        'total_mortgage',
        'total_remaining_mortgage',
    ];

    /**
     * Get the user that owns the financial situation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
