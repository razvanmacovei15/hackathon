<?php

namespace App\Livewire\Dashboard;

use App\Models\UserFinancialProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\IncomeSource;
use App\Models\Expense;
use App\Models\Debt;
use Livewire\Component;

class FinancialCharts extends Component
{
    public function mount()
    {
        \Log::info('User ID in mount:', ['id' => Auth::id()]);
        \Log::info('Has Financial Profile:', ['has_profile' => Auth::user()->financialProfile ? 'Yes' : 'No']);
    }

    public function getHouseholdIncome()
    {
        $profile = Auth::user()->financialProfile;
        return $profile ? $profile->household_income : 0;
    }

    public function getTotalMonthlyIncome()
    {
        $user = auth()->user();
        $total = 0;

        // Get user's primary income
        $total += $user->financialProfile->monthly_income ?? 0;

        // Get additional income sources
        $total += IncomeSource::where('user_id', $user->id)
            ->whereNull('household_member_id')
            ->sum('amount');

        // If user has household members, include their income
        if ($user->has_household_members) {
            $total += IncomeSource::where('user_id', $user->id)
                ->whereNotNull('household_member_id')
                ->sum('amount');
        }

        return $total;
    }

    public function getTotalMonthlyExpenses()
    {
        return Expense::where('user_id', auth()->id())
            ->sum('amount');
    }

    public function getTotalDebt()
    {
        return Debt::where('user_id', auth()->id())
            ->sum('amount');
    }

    public function getMonthlySavings()
    {
        return $this->getTotalMonthlyIncome() - $this->getTotalMonthlyExpenses();
    }

    public function getExpenseToIncomeRatio()
    {
        $income = $this->getHouseholdIncome();
        return $income > 0 ? $this->getTotalMonthlyExpenses() / $income : 0;
    }

    public function getDebtToIncomeRatio()
    {
        $annualIncome = $this->getHouseholdIncome() * 12;
        return $annualIncome > 0 ? $this->getTotalDebt() / $annualIncome : 0;
    }

    public function getSavingsRate()
    {
        $income = $this->getHouseholdIncome();
        return $income > 0 ? $this->getMonthlySavings() / $income : 0;
    }

    public function getExpensesData()
    {
        $profile = Auth::user()->financialProfile;
        
        if (!$profile) {
            return [
                'labels' => [],
                'data' => [],
                'colors' => [],
            ];
        }

        return [
            'labels' => ['Food', 'Transport', 'Bills'],
            'data' => [
                $profile->food_expenses ?? 0,
                $profile->transport_expenses ?? 0,
                $profile->bills_expenses ?? 0,
            ],
            'colors' => [
                '#FF6384', // Red for Food
                '#36A2EB', // Blue for Transport
                '#FFCE56'  // Yellow for Bills
            ],
        ];
    }

    public function getDebtData()
    {
        $profile = Auth::user()->financialProfile;
        
        if (!$profile) {
            return [
                'labels' => [],
                'data' => [],
                'colors' => [],
            ];
        }

        return [
            'labels' => ['Car Loan', 'Mortgage', 'Credit Card'],
            'data' => [
                $profile->car_loan ?? 0,
                $profile->mortgage ?? 0,
                $profile->credit_card_debt ?? 0,
            ],
            'colors' => [
                '#4BC0C0', // Teal for Car Loan
                '#9966FF', // Purple for Mortgage
                '#FF9F40'  // Orange for Credit Card
            ],
        ];
    }

    public function getIncomeVsExpensesData()
    {
        $income = $this->getHouseholdIncome();
        $expenses = $this->getTotalMonthlyExpenses();
        $savings = $this->getMonthlySavings();

        return [
            'labels' => ['Income', 'Expenses', 'Savings'],
            'income' => [$income, 0, 0],
            'expenses' => [0, $expenses, 0],
            'savings' => [0, 0, $savings]
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.financial-charts', [
            'totalMonthlyIncome' => $this->getTotalMonthlyIncome(),
            'totalMonthlyExpenses' => $this->getTotalMonthlyExpenses(),
            'totalDebt' => $this->getTotalDebt(),
            'monthlySavings' => $this->getMonthlySavings(),
        ]);
    }
}
