<?php

namespace App\Livewire\BabySteps;

use Livewire\Component;
use App\Models\UserFinancialSituation;
use Illuminate\Support\Facades\Auth;

class BabyStepsStep4 extends Component
{
    public $currentRetirementSavings = 0;
    public $targetRetirementSavings = 0;
    public $progress = 0;

    public function mount()
    {
        $financialSituation = UserFinancialSituation::where('user_id', Auth::id())->first();
        if ($financialSituation) {
            $this->currentRetirementSavings = $financialSituation->retirement_savings ?? 0;
            $this->targetRetirementSavings = $financialSituation->monthly_income * 0.15 * 12; // 15% of annual income
            if ($this->targetRetirementSavings > 0) {
                $this->progress = min(($this->currentRetirementSavings / $this->targetRetirementSavings) * 100, 100);
            } else {
                $this->progress = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.baby-steps.step4');
    }
} 