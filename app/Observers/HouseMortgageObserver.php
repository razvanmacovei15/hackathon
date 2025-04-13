<?php

namespace App\Observers;

use App\Models\MonthlyHouseMortgage;

class HouseMortgageObserver
{
    /**
     * Handle the MonthlyHouseMortgage "created" event.
     */
    public function created(MonthlyHouseMortgage $monthlyHouseMortgage): void
    {
        //
    }

    /**
     * Handle the MonthlyHouseMortgage "updated" event.
     */
    public function updated(MonthlyHouseMortgage $monthlyHouseMortgage): void
    {
        //
    }

    /**
     * Handle the MonthlyHouseMortgage "deleted" event.
     */
    public function deleted(MonthlyHouseMortgage $monthlyHouseMortgage): void
    {
        //
    }

    /**
     * Handle the MonthlyHouseMortgage "restored" event.
     */
    public function restored(MonthlyHouseMortgage $monthlyHouseMortgage): void
    {
        //
    }

    /**
     * Handle the MonthlyHouseMortgage "force deleted" event.
     */
    public function forceDeleted(MonthlyHouseMortgage $monthlyHouseMortgage): void
    {
        //
    }
}
