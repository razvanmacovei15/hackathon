<?php

namespace App\Livewire\Onboarding;

use App\Models\HouseholdMember;
use App\Models\IncomeSource;
use App\Models\EssentialExpense;
use App\Models\User;
use App\Models\BadDebtCategory;
use App\Models\UserBadDebt;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OnboardingWizard extends Component
{
    public $currentStep = 1;
    public $totalSteps = 5;
    public $user;

    // Step 1: Income Information
    public $primary_income = '';
    public $income_type = '';
    public $income_frequency = '';
    
    // Additional Income Sources
    public $additionalIncomeSources = [];
    
    // Family Members
    public $familyMembers = [];

    // Step 2: Essential Expenses
    public $food_expenses;
    public $transport_expenses;
    public $bills_expenses;
    public $other_essential_expenses = [];

    // Step 3: Mortgage Information
    public $has_mortgage = false;
    public $mortgage_amount;
    public $mortgage_remaining;
    public $mortgage_start_date;
    public $mortgage_monthly_payment;

    // Step 4: Bad Debts
    public $badDebtCategories = [];
    public $newCategoryName = '';
    public $newCategoryDescription = '';
    public $selectedCategory = null;
    public $newDebt = [
        'total_amount' => '',
        'minimum_payment' => '',
        'current_balance' => '',
        'start_date' => '',
        'notes' => ''
    ];

    // Step 5: Savings
    public $savingsCategories = [];
    public $newSavingsCategoryName = '';
    public $newSavingsCategoryDescription = '';
    public $selectedSavingsCategory = null;
    public $newSaving = [
        'amount' => '',
        'target_amount' => '',
        'start_date' => '',
        'target_date' => '',
        'notes' => ''
    ];

    protected $rules = [
        'primary_income' => 'required|numeric|min:0',
        'income_type' => 'required|string',
        'income_frequency' => 'required|string',
        'additionalIncomeSources.*.amount' => 'required|numeric|min:0',
        'additionalIncomeSources.*.type' => 'required|string',
        'additionalIncomeSources.*.frequency' => 'required|string',
        'familyMembers.*.name' => 'required|string',
        'familyMembers.*.relationship' => 'required|string',
        'familyMembers.*.income' => 'required|numeric|min:0',
        'familyMembers.*.income_type' => 'required|string',
        'food_expenses' => 'required|numeric|min:0',
        'transport_expenses' => 'required|numeric|min:0',
        'bills_expenses' => 'required|numeric|min:0',
        'other_essential_expenses.*.amount' => 'required|numeric|min:0',
        'other_essential_expenses.*.description' => 'required|string',
        'mortgage_amount' => 'required|numeric|min:0',
        'mortgage_remaining' => 'required|numeric|min:0|lte:mortgage_amount',
        'mortgage_start_date' => 'required|date',
        'mortgage_monthly_payment' => 'required|numeric|min:0',
    ];

    protected $messages = [
        'primary_income.required' => 'Please enter your income amount.',
        'primary_income.numeric' => 'Income must be a valid number.',
        'primary_income.min' => 'Income cannot be negative.',
        'income_type.required' => 'Please select your income type.',
        'income_frequency.required' => 'Please select how often you receive this income.',
        'additionalIncomeSources.*.amount.required' => 'Please enter the income amount.',
        'additionalIncomeSources.*.type.required' => 'Please select the income type.',
        'additionalIncomeSources.*.frequency.required' => 'Please select the income frequency.',
        'familyMembers.*.name.required' => 'Please enter the family member\'s name.',
        'familyMembers.*.relationship.required' => 'Please select the relationship.',
        'familyMembers.*.income.required' => 'Please enter the family member\'s income.',
        'familyMembers.*.income_type.required' => 'Please select the income type.',
        'food_expenses.required' => 'Please enter your food expenses.',
        'food_expenses.numeric' => 'Food expenses must be a valid number.',
        'food_expenses.min' => 'Food expenses cannot be negative.',
        'transport_expenses.required' => 'Please enter your transport expenses.',
        'transport_expenses.numeric' => 'Transport expenses must be a valid number.',
        'transport_expenses.min' => 'Transport expenses cannot be negative.',
        'bills_expenses.required' => 'Please enter your bills expenses.',
        'bills_expenses.numeric' => 'Bills expenses must be a valid number.',
        'bills_expenses.min' => 'Bills expenses cannot be negative.',
        'other_essential_expenses.*.amount.required' => 'Please enter the expense amount.',
        'other_essential_expenses.*.description.required' => 'Please enter the expense description.',
        'mortgage_amount.required' => 'Please enter the mortgage amount.',
        'mortgage_remaining.required' => 'Please enter the remaining mortgage amount.',
        'mortgage_remaining.lte' => 'The remaining amount cannot be greater than the total mortgage amount.',
        'mortgage_start_date.required' => 'Please enter the mortgage start date.',
        'mortgage_monthly_payment.required' => 'Please enter the mortgage monthly payment.',
        'mortgage_monthly_payment.min' => 'Mortgage monthly payment must be a valid number.',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        
        // Initialize arrays
        $this->additionalIncomeSources = [];
        $this->familyMembers = [];
        $this->other_essential_expenses = [];

        // Load default bad debt categories
        $this->badDebtCategories = [
            ['id' => 1, 'name' => 'Credit Card', 'description' => 'Credit card debt'],
            ['id' => 2, 'name' => 'Personal Loan', 'description' => 'Personal loan debt'],
            ['id' => 3, 'name' => 'Car Loan', 'description' => 'Car loan debt'],
            ['id' => 4, 'name' => 'Student Loan', 'description' => 'Student loan debt'],
            ['id' => 5, 'name' => 'Other', 'description' => 'Other types of debt'],
        ];

        // Load default savings categories
        $this->savingsCategories = [
            ['id' => 1, 'name' => 'Emergency Fund', 'description' => 'Savings for unexpected expenses'],
            ['id' => 2, 'name' => 'Retirement', 'description' => 'Long-term savings for retirement'],
            ['id' => 3, 'name' => 'Education', 'description' => 'Savings for education expenses'],
            ['id' => 4, 'name' => 'Vacation', 'description' => 'Savings for travel and leisure'],
            ['id' => 5, 'name' => 'Major Purchase', 'description' => 'Savings for large purchases like a car or home'],
        ];
    }

    public function addIncomeSource()
    {
        $this->additionalIncomeSources[] = [
            'amount' => '',
            'type' => '',
            'frequency' => '',
        ];
    }

    public function removeIncomeSource($index)
    {
        unset($this->additionalIncomeSources[$index]);
        $this->additionalIncomeSources = array_values($this->additionalIncomeSources);
    }

    public function addFamilyMember()
    {
        $this->familyMembers[] = [
            'name' => '',
            'relationship' => '',
            'income' => '',
            'income_type' => '',
        ];
    }

    public function removeFamilyMember($index)
    {
        unset($this->familyMembers[$index]);
        $this->familyMembers = array_values($this->familyMembers);
    }

    public function addOtherEssentialExpense()
    {
        $this->other_essential_expenses[] = [
            'amount' => '',
            'description' => '',
        ];
    }

    public function removeOtherEssentialExpense($index)
    {
        unset($this->other_essential_expenses[$index]);
        $this->other_essential_expenses = array_values($this->other_essential_expenses);
    }

    public function addBadDebtCategory()
    {
        $this->validate([
            'newCategoryName' => 'required|string|min:3',
            'newCategoryDescription' => 'nullable|string'
        ]);

        $category = BadDebtCategory::create([
            'name' => $this->newCategoryName,
            'description' => $this->newCategoryDescription,
            'is_default' => false
        ]);

        $this->badDebtCategories[] = $category->toArray();
        $this->newCategoryName = '';
        $this->newCategoryDescription = '';
    }

    public function addDebtToCategory($categoryId)
    {
        $this->validate([
            'newDebt.total_amount' => 'required|numeric|min:0',
            'newDebt.minimum_payment' => 'required|numeric|min:0',
            'newDebt.current_balance' => 'required|numeric|min:0',
            'newDebt.start_date' => 'required|date',
            'newDebt.notes' => 'nullable|string'
        ]);

        UserBadDebt::create([
            'user_id' => Auth::id(),
            'category_id' => $categoryId,
            'total_amount' => $this->newDebt['total_amount'],
            'minimum_payment' => $this->newDebt['minimum_payment'],
            'current_balance' => $this->newDebt['current_balance'],
            'start_date' => $this->newDebt['start_date'],
            'notes' => $this->newDebt['notes']
        ]);

        $this->newDebt = [
            'total_amount' => '',
            'minimum_payment' => '',
            'current_balance' => '',
            'start_date' => '',
            'notes' => ''
        ];
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
    }

    public function addSavingsCategory()
    {
        $this->validate([
            'newSavingsCategoryName' => 'required|string|min:3',
            'newSavingsCategoryDescription' => 'nullable|string'
        ]);

        $this->savingsCategories[] = [
            'id' => count($this->savingsCategories) + 1,
            'name' => $this->newSavingsCategoryName,
            'description' => $this->newSavingsCategoryDescription
        ];

        $this->newSavingsCategoryName = '';
        $this->newSavingsCategoryDescription = '';
    }

    public function selectSavingsCategory($categoryId)
    {
        $this->selectedSavingsCategory = $categoryId;
    }

    public function addSavingToCategory($categoryId)
    {
        $this->validate([
            'newSaving.amount' => 'required|numeric|min:0',
            'newSaving.target_amount' => 'required|numeric|min:0',
            'newSaving.start_date' => 'required|date',
            'newSaving.target_date' => 'required|date|after:newSaving.start_date',
            'newSaving.notes' => 'nullable|string'
        ]);

        $this->user->savings()->create([
            'category_id' => $categoryId,
            'amount' => $this->newSaving['amount'],
            'target_amount' => $this->newSaving['target_amount'],
            'start_date' => $this->newSaving['start_date'],
            'target_date' => $this->newSaving['target_date'],
            'notes' => $this->newSaving['notes']
        ]);

        $this->newSaving = [
            'amount' => '',
            'target_amount' => '',
            'start_date' => '',
            'target_date' => '',
            'notes' => ''
        ];
    }

    public function nextStep()
    {
        if ($this->currentStep === 1) {
            $this->validate([
                'primary_income' => 'required|numeric|min:0',
                'income_type' => 'required|string',
                'income_frequency' => 'required|string',
                'additionalIncomeSources.*.amount' => 'required|numeric|min:0',
                'additionalIncomeSources.*.type' => 'required|string',
                'additionalIncomeSources.*.frequency' => 'required|string',
                'familyMembers.*.name' => 'required|string',
                'familyMembers.*.relationship' => 'required|string',
                'familyMembers.*.income' => 'required|numeric|min:0',
                'familyMembers.*.income_type' => 'required|string',
            ]);
        } elseif ($this->currentStep === 2) {
            $this->validate([
                'food_expenses' => 'required|numeric|min:0',
                'transport_expenses' => 'required|numeric|min:0',
                'bills_expenses' => 'required|numeric|min:0',
                'other_essential_expenses.*.amount' => 'required|numeric|min:0',
                'other_essential_expenses.*.description' => 'required|string',
            ]);
        } elseif ($this->currentStep === 3) {
            if ($this->has_mortgage) {
                $this->validate([
                    'mortgage_amount' => 'required|numeric|min:0',
                    'mortgage_remaining' => 'required|numeric|min:0|lte:mortgage_amount',
                    'mortgage_start_date' => 'required|date',
                    'mortgage_monthly_payment' => 'required|numeric|min:0',
                ]);
            }
        }

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

    public function completeOnboarding()
    {
        $this->validate([
            'primary_income' => 'required|numeric|min:0',
            'income_type' => 'required|string',
            'income_frequency' => 'required|string',
            'food_expenses' => 'required|numeric|min:0',
            'transport_expenses' => 'required|numeric|min:0',
            'bills_expenses' => 'required|numeric|min:0',
            'has_mortgage' => 'required|boolean',
        ]);

        if ($this->has_mortgage) {
            $this->validate([
                'mortgage_amount' => 'required|numeric|min:0',
                'mortgage_remaining' => 'required|numeric|min:0|lte:mortgage_amount',
                'mortgage_start_date' => 'required|date',
                'mortgage_monthly_payment' => 'required|numeric|min:0',
            ]);
        }

        // Create financial profile
        $profile = $this->user->financialProfile()->create([
            'primary_income' => $this->primary_income,
            'income_type' => $this->income_type,
            'income_frequency' => $this->income_frequency,
            'food_expenses' => $this->food_expenses,
            'transport_expenses' => $this->transport_expenses,
            'bills_expenses' => $this->bills_expenses,
        ]);

        // Save mortgage as a debt if user has one
        if ($this->has_mortgage) {
            $this->user->debts()->create([
                'amount' => $this->mortgage_amount,
                'remaining_amount' => $this->mortgage_remaining,
                'type' => 'mortgage',
                'description' => 'House Mortgage',
                'start_date' => $this->mortgage_start_date,
                'minimum_payment' => $this->mortgage_monthly_payment,
            ]);
        }

        // Save additional income sources
        foreach ($this->additionalIncomeSources as $source) {
            $profile->incomeSources()->create([
                'amount' => $source['amount'],
                'type' => $source['type'],
                'frequency' => $source['frequency'],
            ]);
        }

        // Save family members
        foreach ($this->familyMembers as $member) {
            $profile->householdMembers()->create([
                'name' => $member['name'],
                'relationship' => $member['relationship'],
                'income' => $member['income'],
                'income_type' => $member['income_type'],
            ]);
        }

        // Mark onboarding as complete
        $this->user->update(['went_through_onboarding' => true]);

        // Redirect to dashboard
        return redirect()->route('dashboard');
    }

    private function convertToMonthly($amount, $frequency)
    {
        return match($frequency) {
            'monthly' => $amount,
            'bi_weekly' => $amount * 26 / 12,
            'weekly' => $amount * 52 / 12,
            'yearly' => $amount / 12,
            default => $amount,
        };
    }

    public function render()
    {
        return view('livewire.onboarding.onboarding-wizard');
    }
} 