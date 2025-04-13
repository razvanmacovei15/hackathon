<?php

namespace App\Observers;

use App\Models\EssentialMonthlyExpense;

class MonthlyExpenseObserver
{
    /**
     * Handle the EssentialMonthlyExpense "created" event.
     */
    public function created(EssentialMonthlyExpense $essentialMonthlyExpense): void
    {
        //
    }

    /**
     * Handle the EssentialMonthlyExpense "updated" event.
     */
    public function updated(EssentialMonthlyExpense $essentialMonthlyExpense): void
    {
        //
    }

    /**
     * Handle the EssentialMonthlyExpense "deleted" event.
     */
    public function deleted(EssentialMonthlyExpense $essentialMonthlyExpense): void
    {
        //
    }

    /**
     * Handle the EssentialMonthlyExpense "restored" event.
     */
    public function restored(EssentialMonthlyExpense $essentialMonthlyExpense): void
    {
        //
    }

    /**
     * Handle the EssentialMonthlyExpense "force deleted" event.
     */
    public function forceDeleted(EssentialMonthlyExpense $essentialMonthlyExpense): void
    {
        //
    }
}
