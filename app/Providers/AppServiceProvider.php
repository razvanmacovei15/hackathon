<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\UserMonthlyEarning;
use App\Models\EssentialMonthlyExpense;
use App\Models\MonthlyHouseMortgage;
use App\Models\UserMonthlyDebtPayment;
use App\Models\UserSaving;
use App\Models\UserFinancialSituation;
use App\Observers\MonthlyEarningObserver;
use App\Observers\MonthlyExpenseObserver;
use App\Observers\HouseMortgageObserver;
use App\Observers\MonthlyDebtPaymentObserver;
use App\Observers\UserSavingObserver;
use App\Observers\UserFinancialSituationObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        UserMonthlyEarning::observe(MonthlyEarningObserver::class);
        EssentialMonthlyExpense::observe(MonthlyExpenseObserver::class);
        MonthlyHouseMortgage::observe(HouseMortgageObserver::class);
        UserMonthlyDebtPayment::observe(MonthlyDebtPaymentObserver::class);
        UserSaving::observe(UserSavingObserver::class);
        UserFinancialSituation::observe(UserFinancialSituationObserver::class);
    }
}
