<?php

namespace App\Livewire\BabySteps;

use Livewire\Component;
use App\Models\UserFinancialSituation;
use Illuminate\Support\Facades\Auth;

class BabyStepsStep1 extends Component
{
    public $currentEmergencyFund = 0;
    public $targetEmergencyFund = 5000;
    public $progress = 0;

    public function mount()
    {
        $financialSituation = UserFinancialSituation::where('user_id', Auth::id())->first();
        if ($financialSituation) {
            $this->currentEmergencyFund = $financialSituation->emergency_fund ?? 0;
            if ($this->targetEmergencyFund > 0) {
                $this->progress = min(($this->currentEmergencyFund / $this->targetEmergencyFund) * 100, 100);
            } else {
                $this->progress = 0;
            }
        }
    }

    public function render()
    {
        return view('livewire.baby-steps.step1');
    }
} 