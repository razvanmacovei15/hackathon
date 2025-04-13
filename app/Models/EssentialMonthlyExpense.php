<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EssentialMonthlyExpense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'expense_type_id',
        'name',
        'amount',
    ];

    /**
     * Get the user that owns the monthly expense.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the expense type associated with the monthly expense.
     */
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }
}
