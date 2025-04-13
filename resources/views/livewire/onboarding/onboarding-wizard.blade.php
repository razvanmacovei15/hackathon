<div class="max-w-4xl mx-auto py-12">
    <!-- Progress Bar -->
    <div class="mb-8 w-full">
        <div class="flex items-center justify-between">
            @for($i = 1; $i <= $totalSteps; $i++)
                <div class="flex items-center flex-1">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full border-2 {{ $currentStep > $i ? 'border-green-600 text-green-600' : ($currentStep == $i ? 'border-red-600 text-red-600' : 'border-gray-600 text-gray-600') }}">
                        {{ $i }}
                    </div>
                    @if($i < $totalSteps)
                        <div class="flex-1 h-1 {{ $currentStep > $i ? 'bg-green-600' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Step Content -->
    <div class="bg-white rounded-lg shadow-lg p-6 border">
        @if($currentStep == 1)
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Income Information</h2>
                <p class="text-gray-600 mb-6">Tell us about your income sources.</p>
            </div>

            <!-- Add Income Form -->
            <div class="mb-8 p-4 border rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Add New Income Source</h3>
                <form wire:submit="addIncome" class="space-y-4">
                    <div>
                        <label for="type_name" class="block text-sm font-medium text-gray-700">Income Type</label>
                        <input type="text" wire:model="newIncome.type_name" id="type_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Salary, Freelance, Investments">
                        @error('newIncome.type_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Income Name</label>
                        <input type="text" wire:model="newIncome.name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Main Job, Side Project, Stock Dividends">
                        @error('newIncome.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" wire:model="newIncome.amount" id="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                        @error('newIncome.amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency</label>
                        <select wire:model="newIncome.frequency" id="frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="weekly">Weekly</option>
                            <option value="biweekly">Bi-weekly</option>
                            <option value="monthly" selected>Monthly</option>
                            <option value="annually">Annually</option>
                        </select>
                        @error('newIncome.frequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Add Income Source
                    </button>
                </form>
            </div>

            <!-- Income List -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold mb-4">Your Income Sources</h3>
                @forelse($incomes as $income)
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div>
                            <h4 class="font-medium">{{ $income['name'] }}</h4>
                            <p class="text-gray-600">{{ $income['earning_type']['name'] }} - {{ number_format($income['amount'], 2) }} RON {{ ucfirst($income['frequency']) }}</p>
                        </div>
                        <button wire:click="removeIncome({{ $income['id'] }})" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No income sources added yet.</p>
                @endforelse
            </div>
        @elseif($currentStep == 2)
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Essential Expenses</h2>
                <p class="text-gray-600 mb-6">Tell us about your essential monthly expenses.</p>
            </div>

            <!-- Add Expense Form -->
            <div class="mb-8 p-4 border rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Add New Expense</h3>
                
                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit="addExpense" class="space-y-4">
                    <div>
                        <label for="expense_type" class="block text-sm font-medium text-gray-700">Expense Type</label>
                        <select wire:model.live="newExpense.type_id" id="expense_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ !empty($newExpense['new_type_name']) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !empty($newExpense['new_type_name']) ? 'disabled' : '' }}>
                            <option value="">Select an existing type</option>
                            @foreach($expenseTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('newExpense.type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="new_type_name" class="block text-sm font-medium text-gray-700">Or Create New Type</label>
                        <input type="text" wire:model.live="newExpense.new_type_name" id="new_type_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ !empty($newExpense['type_id']) ? 'opacity-50 cursor-not-allowed' : '' }}" placeholder="e.g. Entertainment, Healthcare" {{ !empty($newExpense['type_id']) ? 'disabled' : '' }}>
                        @error('newExpense.new_type_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="expense_name" class="block text-sm font-medium text-gray-700">Expense Name</label>
                        <input type="text" wire:model="newExpense.name" id="expense_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Monthly Groceries, Car Insurance">
                        @error('newExpense.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="expense_amount" class="block text-sm font-medium text-gray-700">Amount</label>
                        <input type="number" wire:model="newExpense.amount" id="expense_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                        @error('newExpense.amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Add Expense
                    </button>
                </form>
            </div>

            <!-- Expenses List -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold mb-4">Your Essential Expenses</h3>
                @forelse($expenses as $expense)
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div>
                            <h4 class="font-medium">{{ $expense['name'] }}</h4>
                            <p class="text-gray-600">{{ $expense['expense_type']['name'] }} - {{ number_format($expense['amount'], 2) }} RON</p>
                        </div>
                        <button wire:click="removeExpense({{ $expense['id'] }})" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No expenses added yet.</p>
                @endforelse
            </div>
        @elseif($currentStep == 3)
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Mortgage Information</h2>
                <p class="text-gray-600 mb-6">Do you have a mortgage? Let us know the details.</p>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-8">
                <label class="flex items-center space-x-3">
                    <input type="checkbox" wire:model.live="hasMortgage" class="form-checkbox h-5 w-5 text-blue-600">
                    <span class="text-gray-700">{{ count($mortgages) > 0 ? 'Add Another Mortgage' : 'I have a mortgage' }}</span>
                </label>
            </div>

            @if($hasMortgage)
                <div class="space-y-6">
                    <div>
                        <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Mortgage Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model="mortgage.total_amount" id="total_amount" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">RON</span>
                            </div>
                        </div>
                        @error('mortgage.total_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="remaining_amount" class="block text-sm font-medium text-gray-700">Remaining Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model="mortgage.remaining_amount" id="remaining_amount" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">RON</span>
                            </div>
                        </div>
                        @error('mortgage.remaining_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="minimum_payment" class="block text-sm font-medium text-gray-700">Minimum Monthly Payment</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model="mortgage.minimum_payment" id="minimum_payment" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">RON</span>
                            </div>
                        </div>
                        @error('mortgage.minimum_payment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="due_month" class="block text-sm font-medium text-gray-700">Due Month</label>
                            <select wire:model="mortgage.due_month" id="due_month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select month</option>
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                @endfor
                            </select>
                            @error('mortgage.due_month') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="due_year" class="block text-sm font-medium text-gray-700">Due Year</label>
                            <select wire:model="mortgage.due_year" id="due_year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select year</option>
                                @for($i = date('Y'); $i <= date('Y') + 30; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('mortgage.due_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800">Mortgage Summary</h4>
                        <div class="mt-2 space-y-2">
                            <p class="text-sm text-blue-700">
                                Original Amount: {{ $mortgage['total_amount'] ? number_format((float)$mortgage['total_amount'], 2) : '0.00' }} RON
                            </p>
                            <p class="text-sm text-blue-700">
                                Remaining: {{ $mortgage['remaining_amount'] ? number_format((float)$mortgage['remaining_amount'], 2) : '0.00' }} RON
                            </p>
                            <p class="text-sm text-blue-700">
                                Monthly Payment: {{ $mortgage['minimum_payment'] ? number_format((float)$mortgage['minimum_payment'], 2) : '0.00' }} RON
                            </p>
                            @if($mortgage['due_month'] && $mortgage['due_year'])
                                <p class="text-sm text-blue-700">
                                    Next Payment Due: {{ date('F Y', mktime(0, 0, 0, $mortgage['due_month'], 1, $mortgage['due_year'])) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mortgages List -->
            <div class="space-y-4 mt-8">
                <h3 class="text-lg font-semibold mb-4">Your Mortgages</h3>
                @forelse($mortgages as $mortgage)
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div>
                            <h4 class="font-medium">Mortgage #{{ $mortgage['id'] }}</h4>
                            <p class="text-gray-600">
                                Original: {{ number_format($mortgage['total_amount'], 2) }} RON | 
                                Remaining: {{ number_format($mortgage['remaining_amount'], 2) }} RON | 
                                Monthly: {{ number_format($mortgage['minimum_payment'], 2) }} RON
                            </p>
                            @if($mortgage['due_month'] && $mortgage['due_year'])
                                <p class="text-sm text-gray-500">
                                    Last Payment Due: {{ date('F Y', mktime(0, 0, 0, $mortgage['due_month'], 1, $mortgage['due_year'])) }}
                                </p>
                            @endif
                        </div>
                        <button wire:click="removeMortgage({{ $mortgage['id'] }})" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No mortgages added yet.</p>
                @endforelse
            </div>

            <!-- Mortgage Navigation -->
            <div class="flex justify-between mt-8">
                @if($hasMortgage)
                    
                    <button wire:click="saveMortgage" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Save
                    </button>
                @endif
            </div>
        @elseif($currentStep == 4)
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Other Debts</h2>
                <p class="text-gray-600 mb-6">Tell us about any other debts you have.</p>
            </div>

            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Add Debt Form -->
            <div class="mb-8 p-4 border rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Add New Debt</h3>
                <form wire:submit="addDebt" class="space-y-4">
                    <div>
                        <label for="debt_type" class="block text-sm font-medium text-gray-700">Debt Type</label>
                        <select wire:model.live="newDebt.type_id" id="debt_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ !empty($newDebt['new_type_name']) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !empty($newDebt['new_type_name']) ? 'disabled' : '' }}>
                            <option value="">Select an existing type</option>
                            @foreach($debtTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('newDebt.type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="new_type_name" class="block text-sm font-medium text-gray-700">Or Create New Type</label>
                        <input type="text" wire:model.live="newDebt.new_type_name" id="new_type_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ !empty($newDebt['type_id']) ? 'opacity-50 cursor-not-allowed' : '' }}" placeholder="e.g. Medical Debt, Business Loan" {{ !empty($newDebt['type_id']) ? 'disabled' : '' }}>
                        @error('newDebt.new_type_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="debt_name" class="block text-sm font-medium text-gray-700">Debt Name</label>
                        <input type="text" wire:model="newDebt.name" id="debt_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Chase Credit Card, Car Loan">
                        @error('newDebt.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model="newDebt.total_amount" id="total_amount" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">RON</span>
                            </div>
                        </div>
                        @error('newDebt.total_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="remaining_amount" class="block text-sm font-medium text-gray-700">Remaining Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model="newDebt.remaining_amount" id="remaining_amount" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">RON</span>
                            </div>
                        </div>
                        @error('newDebt.remaining_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="minimum_payment" class="block text-sm font-medium text-gray-700">Minimum Monthly Payment</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model="newDebt.minimum_payment" id="minimum_payment" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">RON</span>
                            </div>
                        </div>
                        @error('newDebt.minimum_payment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Add Debt
                    </button>
                </form>
            </div>

            <!-- Debts List -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold mb-4">Your Debts</h3>
                @forelse($debts as $debt)
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div>
                            <h4 class="font-medium">{{ $debt['name'] }}</h4>
                            <p class="text-gray-600">
                                {{ $debt['debt_type']['name'] }} | 
                                Total: {{ number_format($debt['total_amount'], 2) }} RON | 
                                Remaining: {{ number_format($debt['remaining_amount'], 2) }} RON | 
                                Monthly: {{ number_format($debt['minimum_payment'], 2) }} RON
                            </p>
                        </div>
                        <button wire:click="removeDebt({{ $debt['id'] }})" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No debts added yet.</p>
                @endforelse
            </div>
        @elseif($currentStep == 5)
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Savings Goals</h2>
                <p class="text-gray-600 mb-6">Tell us about your savings goals.</p>
            </div>

            <!-- Add Savings Form -->
            <div class="mb-8 p-4 border rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Add New Savings Goal</h3>
                <form wire:submit="addSaving" class="space-y-4">
                    <div>
                        <label for="savings_type" class="block text-sm font-medium text-gray-700">Savings Type</label>
                        <select wire:model.live="newSaving.type_id" id="savings_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ !empty($newSaving['new_type_name']) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !empty($newSaving['new_type_name']) ? 'disabled' : '' }}>
                            <option value="">Select an existing type</option>
                            @foreach($savingsTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('newSaving.type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="new_savings_type" class="block text-sm font-medium text-gray-700">Or Create New Type</label>
                        <input type="text" wire:model.live="newSaving.new_type_name" id="new_savings_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 {{ !empty($newSaving['type_id']) ? 'opacity-50 cursor-not-allowed' : '' }}" placeholder="e.g. Emergency Fund, Vacation" {{ !empty($newSaving['type_id']) ? 'disabled' : '' }}>
                        @error('newSaving.new_type_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="savings_name" class="block text-sm font-medium text-gray-700">Savings Name</label>
                        <input type="text" wire:model="newSaving.name" id="savings_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Emergency Fund 2024">
                        @error('newSaving.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="current_amount" class="block text-sm font-medium text-gray-700">Current Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model="newSaving.amount" id="current_amount" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">RON</span>
                            </div>
                        </div>
                        @error('newSaving.amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="target_amount" class="block text-sm font-medium text-gray-700">Target Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" wire:model="newSaving.target_amount" id="target_amount" class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">RON</span>
                            </div>
                        </div>
                        @error('newSaving.target_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Add Savings Goal
                    </button>
                </form>
            </div>

            <!-- Savings List -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold mb-4">Your Savings Goals</h3>
                @forelse($savings as $saving)
                    <div class="flex items-center justify-between p-4 border rounded-lg">
                        <div>
                            <h4 class="font-medium">{{ $saving['name'] }}</h4>
                            <p class="text-gray-600">
                                {{ $saving['savings_type']['name'] }} | 
                                Current: {{ number_format($saving['amount'], 2) }} RON | 
                                Target: {{ number_format($saving['target_amount'], 2) }} RON
                            </p>
                        </div>
                        <button wire:click="removeSaving({{ $saving['id'] }})" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No savings goals added yet.</p>
                @endforelse
            </div>
        @endif
    </div>

    <!-- Loading Screen -->
    @if($isCalculating)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-xl max-w-md w-full text-center">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Calculating Your Financial Situation</h2>
                <p class="text-gray-600">We're analyzing your income, expenses, debts, and savings to provide you with a comprehensive financial overview.</p>
                <div class="mt-4 space-y-2">
                    <div class="flex items-center justify-center">
                        <div class="w-4 h-4 bg-blue-600 rounded-full mr-2 animate-bounce"></div>
                        <div class="w-4 h-4 bg-blue-600 rounded-full mr-2 animate-bounce" style="animation-delay: 0.2s"></div>
                        <div class="w-4 h-4 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Navigation -->
    <div class="mt-8 flex justify-between">
        @if($currentStep > 1)
            <button wire:click="previousStep" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                Previous
            </button>
        @else
            <div></div>
        @endif

        @if($currentStep < $totalSteps)
            <button wire:click="nextStep" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                Next
            </button>
        @else
            <button wire:click="completeOnboarding" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                Complete
            </button>
        @endif
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('onboarding-completed', () => {
            // Show loading screen for 2 seconds
            setTimeout(() => {
                window.location.href = '/dashboard';
            }, 2000);
        });
    });
</script> 