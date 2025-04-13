<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFinancialSituation;
use App\Models\UserMonthlyEarning;

class FinancialOverview extends Component
{
    public $mortgages;     // Collection of all mortgage records from mortgages table
    public $mortgage_minimum_payment; // Sum of minimum payments from all mortgages
    public $mortgage_minimum_payments;    // Array of minimum payments from all mortgages

    public $debts;    //debt table user monthly debt payments
    public $debt_minimum_payment; // Sum of minimum payments from all debts
    public $debt_minimum_payments;    // Array of minimum payments from all debts

    public $incomeBreakdown; //monthly earnings table
    public $all_incomes; // array with all the incomes 
    public $all_incomes_sum; // sum of all the incomes

    public $essential_monthly_expenses; // table with all the essential monthly expenses
    public $essential_expenses; // array with all the essential expenses
    public $essential_expenses_sum; // sum of all the essential expenses

    public $savings; // array with all the savings
    public $savings_sum; // sum of all the savings

    public $total_monthly_expenses; //total monthly expenses
    public $total_monthly_essensial_expenses; //total monthly essensial expenses


    public function mount()
    {
        $this->loadFinancialData();
    }

    private function loadFinancialData()
    {
        // Get all mortgages and their minimum payments
        $this->mortgages = Auth::user()->mortgages()->get();
        $this->mortgage_minimum_payments = $this->mortgages->pluck('minimum_payment')->toArray();
        $this->mortgage_minimum_payment = $this->mortgages->sum('minimum_payment');

        // Get all debts and their minimum payments
        $this->debts = Auth::user()->monthlyDebtPayments()->with('debtType')->get();
        $this->debt_minimum_payments = $this->debts->pluck('minimum_payment')->toArray();
        $this->debt_minimum_payment = $this->debts->sum('minimum_payment');

        // Get all incomes and calculate total
        $this->incomeBreakdown = Auth::user()->monthlyEarnings()
            ->with('earningType')
            ->get()
            ->map(function ($income) {
                return [
                    'name' => $income->name,
                    'type' => $income->earningType->name,
                    'amount' => $income->amount,
                    'frequency' => $income->frequency
                ];
            });
        $this->all_incomes = $this->incomeBreakdown->pluck('amount')->toArray();
        $this->all_incomes_sum = array_sum($this->all_incomes);

        // Get all essential monthly expenses
        $this->essential_monthly_expenses = Auth::user()->monthlyExpenses()
            ->with('expenseType')
            ->get()
            ->map(function ($expense) {
                return [
                    'name' => $expense->name,
                    'type' => $expense->expenseType->name,
                    'amount' => $expense->amount
                ];
            });
        $this->essential_expenses = $this->essential_monthly_expenses->pluck('amount')->toArray();
        $this->essential_expenses_sum = array_sum($this->essential_expenses);

        // Get all savings
        $this->savings = Auth::user()->savings()
            ->with('savingsType')
            ->get()
            ->map(function ($saving) {
                return [
                    'name' => $saving->name,
                    'type' => $saving->savingsType->name,
                    'amount' => $saving->amount,
                    'target_amount' => $saving->target_amount,
                    'progress' => $saving->target_amount > 0 ? ($saving->amount / $saving->target_amount) * 100 : 0
                ];
            });
        $this->savings_sum = $this->savings->sum('amount');

        // Calculate total monthly expenses (essential + mortgage + debt payments)
        $this->total_monthly_essensial_expenses = $this->essential_expenses_sum;
        $this->total_monthly_expenses = $this->total_monthly_essensial_expenses + 
                                      $this->mortgage_minimum_payment + 
                                      $this->debt_minimum_payment;
    }

    public function render()
    {
        return view('livewire.dashboard.financial-overview');
    }
} 