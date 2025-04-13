<?php

namespace App\Livewire\Onboarding;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\EarningType;
use App\Models\UserMonthlyEarning;
use App\Models\EssentialMonthlyExpense;
use App\Models\MonthlyHouseMortgage;
use App\Models\DebtType;
use App\Models\UserMonthlyDebtPayment;
use App\Models\SavingsType;
use App\Models\UserSaving;

class OnboardingWizard extends Component
{
    public $currentStep = 1;
    public $totalSteps = 5;
    public $user;

    // Income properties
    public $incomes = [];
    public $newIncome = [
        'type_name' => '',
        'name' => '',
        'amount' => '',
        'frequency' => 'monthly',
        'description' => ''
    ];

    // Expense properties
    public $expenses = [];
    public $expenseTypes = [];
    public $newExpense = [
        'type_id' => '',
        'name' => '',
        'amount' => '',
        'new_type_name' => ''
    ];

    // Mortgage properties
    public $hasMortgage = false;
    public $mortgage = [
        'total_amount' => '',
        'remaining_amount' => '',
        'minimum_payment' => '',
        'due_month' => '',
        'due_year' => ''
    ];

    public $mortgages = [];

    // Debt properties
    public $debts = [];
    public $debtTypes = [];
    public $newDebt = [
        'type_id' => '',
        'name' => '',
        'total_amount' => '',
        'remaining_amount' => '',
        'minimum_payment' => '',
        'new_type_name' => ''
    ];

    // Savings properties
    public $hasSavings = false;
    public $savings = [];
    public $savingsTypes = [];
    public $newSaving = [
        'type_id' => '',
        'name' => '',
        'amount' => '',
        'target_amount' => '',
        'new_type_name' => ''
    ];

    public $isCalculating = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->incomes = UserMonthlyEarning::where('user_id', $this->user->id)
            ->with('earningType')
            ->get()
            ->toArray();
        $this->loadDefaultCategories();
        $this->loadExistingExpenses();
        $this->loadMortgages();
        $this->loadDebtTypes();
        $this->loadDebts();
        $this->loadSavingsTypes();
        $this->loadSavings();
    }

    private function loadDefaultCategories()
    {
        // Load default expense types if they don't exist
        $defaultExpenseTypes = ['Groceries', 'Transportation', 'Bills'];
        foreach ($defaultExpenseTypes as $type) {
            \App\Models\ExpenseType::firstOrCreate(['name' => $type]);
        }

        // Load all expense types
        $this->expenseTypes = \App\Models\ExpenseType::all();
    }

    private function loadExistingExpenses()
    {
        $this->expenses = \App\Models\EssentialMonthlyExpense::where('user_id', $this->user->id)
            ->with('expenseType')
            ->get()
            ->map(function ($expense) {
                return [
                    'id' => $expense->id,
                    'name' => $expense->name,
                    'amount' => $expense->amount,
                    'expense_type' => [
                        'id' => $expense->expenseType->id,
                        'name' => $expense->expenseType->name
                    ]
                ];
            })
            ->toArray();
    }

    private function loadMortgages()
    {
        $this->mortgages = $this->user->mortgages()->get()->toArray();
    }

    private function loadDebtTypes()
    {
        // Load default debt types if they don't exist
        $defaultDebtTypes = ['Credit Card', 'Personal Loan', 'Car Loan', 'Student Loan'];
        foreach ($defaultDebtTypes as $type) {
            \App\Models\DebtType::firstOrCreate(['name' => $type]);
        }

        // Load all debt types
        $this->debtTypes = \App\Models\DebtType::all();
    }

    private function loadDebts()
    {
        $this->debts = \App\Models\UserMonthlyDebtPayment::where('user_id', $this->user->id)
            ->with('debtType')
            ->get()
            ->map(function ($debt) {
                return [
                    'id' => $debt->id,
                    'name' => $debt->name,
                    'total_amount' => $debt->total_amount,
                    'remaining_amount' => $debt->remaining_amount,
                    'minimum_payment' => $debt->minimum_payment,
                    'debt_type' => [
                        'id' => $debt->debtType->id,
                        'name' => $debt->debtType->name
                    ]
                ];
            })
            ->toArray();
    }

    private function loadSavingsTypes()
    {
        // Load default savings types if they don't exist
        $defaultSavingsTypes = ['Emergency Fund', 'Retirement', 'Vacation', 'Education', 'Home Down Payment'];
        foreach ($defaultSavingsTypes as $type) {
            \App\Models\SavingsType::firstOrCreate(['name' => $type]);
        }

        // Load all savings types
        $this->savingsTypes = \App\Models\SavingsType::all();
    }

    private function loadSavings()
    {
        $this->savings = \App\Models\UserSaving::where('user_id', $this->user->id)
            ->with('savingsType')
            ->get()
            ->map(function ($saving) {
                return [
                    'id' => $saving->id,
                    'name' => $saving->name,
                    'amount' => $saving->amount,
                    'target_amount' => $saving->target_amount,
                    'savings_type' => [
                        'id' => $saving->savingsType->id,
                        'name' => $saving->savingsType->name
                    ]
                ];
            })
            ->toArray();
    }

    public function addIncome()
    {
        $this->validate([
            'newIncome.type_name' => 'required|string|max:255',
            'newIncome.name' => 'required|string|max:255',
            'newIncome.amount' => 'required|numeric|min:0',
            'newIncome.frequency' => 'required|in:weekly,biweekly,monthly,annually',
            'newIncome.description' => 'nullable|string|max:255'
        ]);

        // Find or create the earning type
        $earningType = EarningType::firstOrCreate(
            ['name' => $this->newIncome['type_name']],
            ['name' => $this->newIncome['type_name']]
        );

        // Create the monthly earning
        UserMonthlyEarning::create([
            'user_id' => $this->user->id,
            'earning_type_id' => $earningType->id,
            'name' => $this->newIncome['name'],
            'amount' => $this->newIncome['amount'],
            'frequency' => $this->newIncome['frequency'],
            'description' => $this->newIncome['description']
        ]);

        $this->incomes = UserMonthlyEarning::where('user_id', $this->user->id)
            ->with('earningType')
            ->get()
            ->toArray();
        $this->reset('newIncome');
    }

    public function removeIncome($id)
    {
        UserMonthlyEarning::where('id', $id)->delete();
        $this->incomes = UserMonthlyEarning::where('user_id', $this->user->id)
            ->with('earningType')
            ->get()
            ->toArray();
    }

    public function addExpense()
    {
        $this->validate([
            'newExpense.type_id' => 'required_without:newExpense.new_type_name',
            'newExpense.new_type_name' => 'required_without:newExpense.type_id|string|max:255',
            'newExpense.name' => 'required|string|max:255',
            'newExpense.amount' => 'required|numeric|min:0',
        ]);

        try {
            // Create new expense type if needed
            if (!empty($this->newExpense['new_type_name'])) {
                $expenseType = \App\Models\ExpenseType::create([
                    'name' => $this->newExpense['new_type_name']
                ]);
                $this->newExpense['type_id'] = $expenseType->id;
            }

            // Create the expense
            $expense = \App\Models\EssentialMonthlyExpense::create([
                'user_id' => $this->user->id,
                'expense_type_id' => $this->newExpense['type_id'],
                'name' => $this->newExpense['name'],
                'amount' => $this->newExpense['amount']
            ]);

            // Add to local array
            $this->expenses[] = [
                'id' => $expense->id,
                'name' => $expense->name,
                'amount' => $expense->amount,
                'expense_type' => [
                    'id' => $expense->expenseType->id,
                    'name' => $expense->expenseType->name
                ]
            ];

            // Reset form
            $this->newExpense = [
                'type_id' => '',
                'name' => '',
                'amount' => '',
                'new_type_name' => ''
            ];

            // Reload expense types
            $this->expenseTypes = \App\Models\ExpenseType::all();

            // Show success message
            session()->flash('message', 'Expense added successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add expense. Please try again.');
        }
    }

    public function removeExpense($expenseId)
    {
        $expense = EssentialMonthlyExpense::find($expenseId);
        if ($expense && $expense->user_id === $this->user->id) {
            $expense->delete();
            $this->loadExpenses();
        }
    }

    public function removeMortgage($mortgageId)
    {
        $mortgage = MonthlyHouseMortgage::find($mortgageId);
        if ($mortgage && $mortgage->user_id === $this->user->id) {
            $mortgage->delete();
            $this->loadMortgages();
        }
    }

    public function addDebt()
    {
        $this->validate([
            'newDebt.type_id' => 'required_without:newDebt.new_type_name',
            'newDebt.new_type_name' => 'required_without:newDebt.type_id|string|max:255',
            'newDebt.name' => 'required|string|max:255',
            'newDebt.total_amount' => 'required|numeric|min:0',
            'newDebt.remaining_amount' => 'required|numeric|min:0|lte:newDebt.total_amount',
            'newDebt.minimum_payment' => 'required|numeric|min:0'
        ]);

        try {
            // Create new debt type if needed
            if (!empty($this->newDebt['new_type_name'])) {
                $debtType = \App\Models\DebtType::create([
                    'name' => $this->newDebt['new_type_name']
                ]);
                $this->newDebt['type_id'] = $debtType->id;
            }

            // Create the debt
            $debt = \App\Models\UserMonthlyDebtPayment::create([
                'user_id' => $this->user->id,
                'debt_type_id' => $this->newDebt['type_id'],
                'name' => $this->newDebt['name'],
                'total_amount' => $this->newDebt['total_amount'],
                'remaining_amount' => $this->newDebt['remaining_amount'],
                'minimum_payment' => $this->newDebt['minimum_payment']
            ]);

            // Reset form
            $this->newDebt = [
                'type_id' => '',
                'name' => '',
                'total_amount' => '',
                'remaining_amount' => '',
                'minimum_payment' => '',
                'new_type_name' => ''
            ];

            // Reload debt types and debts
            $this->loadDebtTypes();
            $this->loadDebts();

            session()->flash('message', 'Debt added successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add debt. Please try again.');
        }
    }

    public function removeDebt($debtId)
    {
        $debt = \App\Models\UserMonthlyDebtPayment::find($debtId);
        if ($debt && $debt->user_id === $this->user->id) {
            $debt->delete();
            $this->loadDebts();
        }
    }

    public function addSaving()
    {
        $this->validate([
            'newSaving.type_id' => 'required_without:newSaving.new_type_name',
            'newSaving.new_type_name' => 'required_without:newSaving.type_id|string|max:255',
            'newSaving.name' => 'required|string|max:255',
            'newSaving.amount' => 'required|numeric|min:0',
            'newSaving.target_amount' => 'required|numeric|min:0|gte:newSaving.amount'
        ]);

        try {
            // Create new savings type if needed
            if (!empty($this->newSaving['new_type_name'])) {
                $savingsType = \App\Models\SavingsType::create([
                    'name' => $this->newSaving['new_type_name']
                ]);
                $this->newSaving['type_id'] = $savingsType->id;
            }

            // Create the saving
            \App\Models\UserSaving::create([
                'user_id' => $this->user->id,
                'savings_type_id' => $this->newSaving['type_id'],
                'name' => $this->newSaving['name'],
                'amount' => $this->newSaving['amount'],
                'target_amount' => $this->newSaving['target_amount']
            ]);

            // Reset form
            $this->newSaving = [
                'type_id' => '',
                'name' => '',
                'amount' => '',
                'target_amount' => '',
                'new_type_name' => ''
            ];

            // Reload savings types and savings
            $this->loadSavingsTypes();
            $this->loadSavings();

            session()->flash('message', 'Savings goal added successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add savings goal. Please try again.');
        }
    }

    public function removeSaving($savingId)
    {
        $saving = \App\Models\UserSaving::find($savingId);
        if ($saving && $saving->user_id === $this->user->id) {
            $saving->delete();
            $this->loadSavings();
        }
    }

    public function nextStep()
    {
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function updatedNewExpenseTypeId()
    {
        if (!empty($this->newExpense['type_id'])) {
            $this->newExpense['new_type_name'] = '';
        }
    }

    public function updatedNewExpenseNewTypeName()
    {
        if (!empty($this->newExpense['new_type_name'])) {
            $this->newExpense['type_id'] = '';
        }
    }

    public function updatedNewSavingTypeId()
    {
        if (!empty($this->newSaving['type_id'])) {
            $this->newSaving['new_type_name'] = '';
        }
    }

    public function updatedNewSavingNewTypeName()
    {
        if (!empty($this->newSaving['new_type_name'])) {
            $this->newSaving['type_id'] = '';
        }
    }

    public function saveMortgage()
    {
        if (!$this->hasMortgage) {
            // If user doesn't have a mortgage, we can proceed to next step
            $this->nextStep();
            return;
        }

        $this->validate([
            'mortgage.total_amount' => 'required|numeric|min:0',
            'mortgage.remaining_amount' => 'required|numeric|min:0|lte:mortgage.total_amount',
            'mortgage.minimum_payment' => 'required|numeric|min:0',
            'mortgage.due_month' => 'required|integer|between:1,12',
            'mortgage.due_year' => 'required|integer|min:' . date('Y')
        ]);

        try {
            \App\Models\MonthlyHouseMortgage::create([
                'user_id' => $this->user->id,
                'total_amount' => $this->mortgage['total_amount'],
                'remaining_amount' => $this->mortgage['remaining_amount'],
                'minimum_payment' => $this->mortgage['minimum_payment'],
                'due_month' => $this->mortgage['due_month'],
                'due_year' => $this->mortgage['due_year']
            ]);

            // Reset form fields
            $this->hasMortgage = false;
            $this->mortgage = [
                'total_amount' => '',
                'remaining_amount' => '',
                'minimum_payment' => '',
                'due_month' => '',
                'due_year' => ''
            ];

            // Reload mortgages list
            $this->loadMortgages();

            session()->flash('message', 'Mortgage information saved successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save mortgage information. Please try again.');
        }
    }

    public function updatedHasMortgage()
    {
        if (!$this->hasMortgage) {
            $this->mortgage = [
                'total_amount' => '',
                'remaining_amount' => '',
                'minimum_payment' => '',
                'due_month' => '',
                'due_year' => ''
            ];
        }
    }

    public function completeOnboarding()
    {
        $this->isCalculating = true;

        try {
            // Calculate total monthly income
            $totalMonthlyIncome = 0;
            foreach ($this->incomes as $income) {
                $amount = $income['amount'];
                switch ($income['frequency']) {
                    case 'weekly':
                        $totalMonthlyIncome += $amount * 4.33;
                        break;
                    case 'biweekly':
                        $totalMonthlyIncome += $amount * 2.17;
                        break;
                    case 'monthly':
                        $totalMonthlyIncome += $amount;
                        break;
                    case 'annually':
                        $totalMonthlyIncome += $amount / 12;
                        break;
                }
            }

            // Calculate total monthly expenses
            $totalMonthlyExpenses = 0;
            foreach ($this->expenses as $expense) {
                $totalMonthlyExpenses += $expense['amount'];
            }

            // Calculate total monthly debt payments
            $totalMonthlyDebtPayments = 0;
            foreach ($this->debts as $debt) {
                $totalMonthlyDebtPayments += $debt['minimum_payment'];
            }

            // Calculate total savings
            $totalSavings = 0;
            foreach ($this->savings as $saving) {
                $totalSavings += $saving['amount'];
            }

            // Calculate total target savings
            $totalTargetSavings = 0;
            foreach ($this->savings as $saving) {
                $totalTargetSavings += $saving['target_amount'];
            }

            // Calculate disposable income
            $disposableIncome = $totalMonthlyIncome - $totalMonthlyExpenses - $totalMonthlyDebtPayments;

            // Calculate savings rate
            $savingsRate = $totalMonthlyIncome > 0 ? ($totalSavings / $totalMonthlyIncome) * 100 : 0;

            // Calculate debt-to-income ratio
            $debtToIncomeRatio = $totalMonthlyIncome > 0 ? ($totalMonthlyDebtPayments / $totalMonthlyIncome) * 100 : 0;

            // Update or create financial situation
            \App\Models\UserFinancialSituation::updateOrCreate(
                ['user_id' => $this->user->id],
                [
                    'total_monthly_income' => $totalMonthlyIncome,
                    'total_monthly_expenses' => $totalMonthlyExpenses,
                    'total_monthly_debt_payments' => $totalMonthlyDebtPayments,
                    'total_savings' => $totalSavings,
                    'total_target_savings' => $totalTargetSavings,
                    'disposable_income' => $disposableIncome,
                    'savings_rate' => $savingsRate,
                    'debt_to_income_ratio' => $debtToIncomeRatio,
                    'last_updated' => now(),
                ]
            );

            // Mark user as onboarded
            $this->user->update(['onboarded' => true]);

            // Dispatch event for loading screen
            $this->dispatch('onboarding-completed');

            // Reset calculating state
            $this->isCalculating = false;
            
        } catch (\Exception $e) {
            $this->isCalculating = false;
            session()->flash('error', 'There was an error calculating your financial situation. Please try again.');
            return;
        }
    }

    public function render()
    {
        return view('livewire.onboarding.onboarding-wizard');
    }
} 