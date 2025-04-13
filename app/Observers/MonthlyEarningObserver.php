<?php

namespace App\Observers;

use App\Models\UserMonthlyEarning;
use App\Models\UserFinancialSituation;

class MonthlyEarningObserver
{
    /**
     * Handle the UserMonthlyEarning "created" event.
     */
    public function created(UserMonthlyEarning $userMonthlyEarning): void
    {
        $this->updateFinancialSituation($userMonthlyEarning->user_id);
    }

    /**
     * Handle the UserMonthlyEarning "updated" event.
     */
    public function updated(UserMonthlyEarning $userMonthlyEarning): void
    {
        $this->updateFinancialSituation($userMonthlyEarning->user_id);
    }

    /**
     * Handle the UserMonthlyEarning "deleted" event.
     */
    public function deleted(UserMonthlyEarning $userMonthlyEarning): void
    {
        $this->updateFinancialSituation($userMonthlyEarning->user_id);
    }

    /**
     * Handle the UserMonthlyEarning "restored" event.
     */
    public function restored(UserMonthlyEarning $userMonthlyEarning): void
    {
        //
    }

    /**
     * Handle the UserMonthlyEarning "force deleted" event.
     */
    public function forceDeleted(UserMonthlyEarning $userMonthlyEarning): void
    {
        //
    }

    /**
     * Update the financial situation
     */
    private function updateFinancialSituation(int $userId): void
    {
        $financialSituation = UserFinancialSituation::where('user_id', $userId)->first();
        if ($financialSituation) {
            $financialSituation->touch();
        }
    }
}
