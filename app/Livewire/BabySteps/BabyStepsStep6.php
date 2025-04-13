<?php

namespace App\Livewire\BabySteps;

use Livewire\Component;
use App\Models\UserFinancialSituation;
use App\Models\MonthlyHouseMortgage;
use Illuminate\Support\Facades\Auth;

class BabyStepsStep6 extends Component
{
    public $remainingMortgage = 0;
    public $originalMortgage = 0;
    public $progress = 0;

    public function mount()
    {
        $financialSituation = UserFinancialSituation::where('user_id', Auth::id())->first();
        if ($financialSituation) {
            // Get the mortgage details
            $mortgage = MonthlyHouseMortgage::where('user_id', Auth::id())->first();
            if ($mortgage) {
                $this->remainingMortgage = $mortgage->remaining_amount;
                $this->originalMortgage = $mortgage->original_amount;
            }
            
            // Calculate progress, preventing division by zero
            if ($this->originalMortgage > 0) {
                $this->progress = min((($this->originalMortgage - $this->remainingMortgage) / $this->originalMortgage) * 100, 100);
            } else {
                $this->progress = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.baby-steps.step6');
    }
} 