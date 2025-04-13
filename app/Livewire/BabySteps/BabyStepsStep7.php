<?php

namespace App\Livewire\BabySteps;

use Livewire\Component;
use App\Models\UserFinancialSituation;
use Illuminate\Support\Facades\Auth;

class BabyStepsStep7 extends Component
{
    public $currentGiving = 0;
    public $targetGiving = 0;
    public $currentWealth = 0;
    public $targetWealth = 0;
    public $givingProgress = 0;
    public $wealthProgress = 0;

    public function mount()
    {
        $financialSituation = UserFinancialSituation::where('user_id', Auth::id())->first();
        if ($financialSituation) {
            // Calculate giving progress
            $this->currentGiving = $financialSituation->monthly_giving ?? 0;
            $this->targetGiving = $financialSituation->monthly_income * 0.1; // 10% of monthly income
            
            if ($this->targetGiving > 0) {
                $this->givingProgress = min(($this->currentGiving / $this->targetGiving) * 100, 100);
            } else {
                $this->givingProgress = 0;
            }

            // Calculate wealth building progress
            $this->currentWealth = $financialSituation->savings + $financialSituation->retirement_savings;
            $this->targetWealth = $financialSituation->monthly_income * 12 * 3; // 3x annual income
            
            if ($this->targetWealth > 0) {
                $this->wealthProgress = min(($this->currentWealth / $this->targetWealth) * 100, 100);
            } else {
                $this->wealthProgress = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.baby-steps.step7');
    }
} 