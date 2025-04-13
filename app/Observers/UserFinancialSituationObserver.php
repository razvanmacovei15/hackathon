<?php

namespace App\Observers;

use App\Models\UserFinancialSituation;
use App\Models\UserMonthlyEarning;
use App\Models\EssentialMonthlyExpense;
use App\Models\MonthlyHouseMortgage;
use App\Models\UserMonthlyDebtPayment;
use App\Models\UserSaving;

class UserFinancialSituationObserver
{
    /**
     * Handle the UserFinancialSituation "created" event.
     */
    public function created(UserFinancialSituation $userFinancialSituation): void
    {
        $this->updateFinancialSituation($userFinancialSituation->user_id);
    }

    /**
     * Handle the UserFinancialSituation "updated" event.
     */
    public function updated(UserFinancialSituation $userFinancialSituation): void
    {
        $this->updateFinancialSituation($userFinancialSituation->user_id);
    }

    /**
     * Handle the UserFinancialSituation "deleted" event.
     */
    public function deleted(UserFinancialSituation $userFinancialSituation): void
    {
        $this->updateFinancialSituation($userFinancialSituation->user_id);
    }

    /**
     * Update the financial situation for a user
     */
    private function updateFinancialSituation(int $userId): void
    {
        // Calculate total earnings
        $totalEarnings = UserMonthlyEarning::where('user_id', $userId)
            ->sum('amount');

        // Calculate total expenses
        $totalExpenses = EssentialMonthlyExpense::where('user_id', $userId)
            ->sum('amount');

        // Calculate total mortgage
        $totalMortgage = MonthlyHouseMortgage::where('user_id', $userId)
            ->sum('total_amount');

        // Calculate total remaining mortgage
        $totalRemainingMortgage = MonthlyHouseMortgage::where('user_id', $userId)
            ->sum('remaining_amount');

        // Calculate total debt
        $totalDebt = UserMonthlyDebtPayment::where('user_id', $userId)
            ->sum('total_amount');

        // Calculate total remaining debt
        $totalRemainingDebt = UserMonthlyDebtPayment::where('user_id', $userId)
            ->sum('remaining_amount');

        // Calculate total savings
        $totalSavings = UserSaving::where('user_id', $userId)
            ->sum('amount');

        // Calculate total remaining savings goal
        $totalRemainingSavingsGoal = UserSaving::where('user_id', $userId)
            ->sum('target_amount') - $totalSavings;

        // Update or create the financial situation
        UserFinancialSituation::updateOrCreate(
            ['user_id' => $userId],
            [
                'total_earnings' => $totalEarnings,
                'total_expenses' => $totalExpenses,
                'total_mortgage' => $totalMortgage,
                'total_remaining_mortgage' => $totalRemainingMortgage,
                'total_debt' => $totalDebt,
                'total_remaining_debt' => $totalRemainingDebt,
                'total_savings' => $totalSavings,
                'total_remaining_savings_goal' => $totalRemainingSavingsGoal,
            ]
        );
    }
}
