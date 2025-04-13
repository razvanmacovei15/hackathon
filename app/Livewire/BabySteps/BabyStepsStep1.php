<?php

namespace App\Livewire\BabySteps;

use Livewire\Component;
use App\Models\UserFinancialSituation;
use App\Models\UserSaving;
use App\Models\SavingsType;
use Illuminate\Support\Facades\Auth;

class BabyStepsStep1 extends Component
{
    public $currentEmergencyFund = 0;
    public $targetEmergencyFund = 5000;
    public $progress = 0;

    public function mount()
    {
        // Get the emergency fund savings type
        $emergencyFundType = SavingsType::where('name', 'Emergency Fund')->first();
        
        if ($emergencyFundType) {
            // Get the emergency fund amount from the savings table
            $emergencyFund = UserSaving::where('user_id', Auth::id())
                ->where('savings_type_id', $emergencyFundType->id)
                ->first();
            
            if ($emergencyFund) {
                $this->currentEmergencyFund = $emergencyFund->amount;
            }
        }

        // Calculate progress
        if ($this->targetEmergencyFund > 0) {
            $this->progress = min(($this->currentEmergencyFund / $this->targetEmergencyFund) * 100, 100);
        } else {
            $this->progress = 0;
        }
    }

    public function render()
    {
        return view('livewire.baby-steps.step1');
    }
} 