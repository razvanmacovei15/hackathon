<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the monthly debt payments for the debt type.
     */
    public function monthlyDebtPayments()
    {
        return $this->hasMany(UserMonthlyDebtPayment::class);
    }
}
