<?php

namespace App\Livewire\BabySteps;

use Livewire\Component;
use App\Models\UserFinancialSituation;
use Illuminate\Support\Facades\Auth;

class BabyStepsStep5 extends Component
{
    public $currentCollegeSavings = 0;
    public $targetCollegeSavings = 0;
    public $progress = 0;

    public function mount()
    {
        $financialSituation = UserFinancialSituation::where('user_id', Auth::id())->first();
        if ($financialSituation) {
            $this->currentCollegeSavings = $financialSituation->college_savings ?? 0;
            $this->targetCollegeSavings = $financialSituation->monthly_income * 12 * 0.1; // 10% of annual income
            if ($this->targetCollegeSavings > 0) {
                $this->progress = min(($this->currentCollegeSavings / $this->targetCollegeSavings) * 100, 100);
            } else {
                $this->progress = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.baby-steps.step5');
    }
} 