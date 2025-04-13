<?php

namespace App\Livewire\BabySteps;

use Livewire\Component;
use App\Models\UserFinancialSituation;
use Illuminate\Support\Facades\Auth;

class BabyStepsStep2 extends Component
{
    public $totalDebt = 0;
    public $debtBreakdown = [];

    public function mount()
    {
        $financialSituation = UserFinancialSituation::where('user_id', Auth::id())->first();
        if ($financialSituation) {
            $this->totalDebt = $financialSituation->total_debt ?? 0;
            $this->debtBreakdown = $financialSituation->debt_breakdown ?? [];
        }
    }

    public function render()
    {
        return view('livewire.baby-steps.step2');
    }
} 