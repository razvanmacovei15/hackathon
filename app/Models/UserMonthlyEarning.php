<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMonthlyEarning extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'earning_type_id',
        'name',
        'amount',
        'frequency',
    ];

    /**
     * Get the user that owns the monthly earning.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the earning type associated with the monthly earning.
     */
    public function earningType()
    {
        return $this->belongsTo(EarningType::class);
    }
}
