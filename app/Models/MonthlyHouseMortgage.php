<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyHouseMortgage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_amount',
        'remaining_amount',
        'minimum_payment',
        'due_month',
        'due_year',
    ];

    /**
     * Get the user that owns the house mortgage.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
