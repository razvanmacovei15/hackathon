<?php

namespace App\Livewire\Settings;

use App\Models\UserFinancialProfile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Onboarding extends Component
{
    public $currentStep = 1;
    public $totalSteps = 3;

    // Step 1: Household Income
    public $household_income;

    // Step 2: Basic Needs
    public $food_expenses;
    public $transport_expenses;
    public $bills_expenses;

    // Step 3: Debt
    public $car_loan;
    public $mortgage;
    public $credit_card_debt;

    public function mount()
    {
        $profile = Auth::user()->financialProfile;
        if ($profile) {
            $this->household_income = $profile->household_income;
            $this->food_expenses = $profile->food_expenses;
            $this->transport_expenses = $profile->transport_expenses;
            $this->bills_expenses = $profile->bills_expenses;
            $this->car_loan = $profile->car_loan;
            $this->mortgage = $profile->mortgage;
            $this->credit_card_debt = $profile->credit_card_debt;
        }
    }

    public function nextStep()
    {
        $this->validateStep();
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

    public function validateStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validate([
                    'household_income' => 'required|numeric|min:0',
                ]);
                break;
            case 2:
                $this->validate([
                    'food_expenses' => 'required|numeric|min:0',
                    'transport_expenses' => 'required|numeric|min:0',
                    'bills_expenses' => 'required|numeric|min:0',
                ]);
                break;
            case 3:
                $this->validate([
                    'car_loan' => 'required|numeric|min:0',
                    'mortgage' => 'required|numeric|min:0',
                    'credit_card_debt' => 'required|numeric|min:0',
                ]);
                break;
        }
    }

    public function save()
    {
        $this->validateStep();

        $profile = Auth::user()->financialProfile()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'household_income' => $this->household_income,
                'food_expenses' => $this->food_expenses,
                'transport_expenses' => $this->transport_expenses,
                'bills_expenses' => $this->bills_expenses,
                'car_loan' => $this->car_loan,
                'mortgage' => $this->mortgage,
                'credit_card_debt' => $this->credit_card_debt,
            ]
        );

        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.settings.onboarding');
    }
}
