<?php

namespace App\Livewire\Income;

use App\Models\IncomeSource;
use Livewire\Component;
use Livewire\WithPagination;

class IncomeSources extends Component
{
    use WithPagination;

    public $name;
    public $type;
    public $amount;
    public $frequency = 'monthly';
    public $start_date;
    public $end_date;
    public $description;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'frequency' => 'required|in:monthly,yearly,one_time',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after:start_date',
        'description' => 'nullable|string',
        'is_active' => 'boolean'
    ];

    public function save()
    {
        $this->validate();

        auth()->user()->incomeSources()->create([
            'name' => $this->name,
            'type' => $this->type,
            'amount' => $this->amount,
            'frequency' => $this->frequency,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
            'is_active' => $this->is_active
        ]);

        $this->reset();
        session()->flash('message', 'Income source added successfully.');
    }

    public function render()
    {
        return view('livewire.income.income-sources', [
            'incomeSources' => auth()->user()->incomeSources()->paginate(10),
            'totalMonthlyIncome' => auth()->user()->total_monthly_income
        ]);
    }
} 