<?php

namespace App\Observers;

use App\Models\UserMonthlyDebtPayment;

class MonthlyDebtPaymentObserver
{
    /**
     * Handle the UserMonthlyDebtPayment "created" event.
     */
    public function created(UserMonthlyDebtPayment $userMonthlyDebtPayment): void
    {
        //
    }

    /**
     * Handle the UserMonthlyDebtPayment "updated" event.
     */
    public function updated(UserMonthlyDebtPayment $userMonthlyDebtPayment): void
    {
        //
    }

    /**
     * Handle the UserMonthlyDebtPayment "deleted" event.
     */
    public function deleted(UserMonthlyDebtPayment $userMonthlyDebtPayment): void
    {
        //
    }

    /**
     * Handle the UserMonthlyDebtPayment "restored" event.
     */
    public function restored(UserMonthlyDebtPayment $userMonthlyDebtPayment): void
    {
        //
    }

    /**
     * Handle the UserMonthlyDebtPayment "force deleted" event.
     */
    public function forceDeleted(UserMonthlyDebtPayment $userMonthlyDebtPayment): void
    {
        //
    }
}
