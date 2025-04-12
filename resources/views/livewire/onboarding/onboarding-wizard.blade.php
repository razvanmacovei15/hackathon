<div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    @for($i = 1; $i <= $totalSteps; $i++)
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full {{ $currentStep >= $i ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                {{ $i }}
                            </div>
                            @if($i < $totalSteps)
                                <div class="h-1 w-8 {{ $currentStep > $i ? 'bg-indigo-600' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            @if($currentStep === 1)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome to Your Financial Journey</h2>
                    <p class="text-gray-600">Let's get started by understanding your financial situation.</p>
                </div>
            @endif

            @if($currentStep === 1)
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Primary Income</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="primary_income" class="block text-sm font-medium text-gray-700">Monthly Income (RON)</label>
                                <input type="number" id="primary_income" wire:model="primary_income" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('primary_income') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="income_type" class="block text-sm font-medium text-gray-700">Income Type</label>
                                <select id="income_type" wire:model="income_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select income type</option>
                                    <option value="salary">Salary</option>
                                    <option value="business">Business</option>
                                    <option value="investments">Investments</option>
                                    <option value="freelance">Freelance</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('income_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="income_frequency" class="block text-sm font-medium text-gray-700">Income Frequency</label>
                                <select id="income_frequency" wire:model="income_frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select frequency</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="bi_weekly">Bi-weekly</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                                @error('income_frequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Income Sources</h3>
                        <button type="button" wire:click="addIncomeSource" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Income Source
                        </button>

                        @foreach($additionalIncomeSources as $index => $source)
                            <div class="mt-4 p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-md font-medium text-gray-900">Income Source #{{ $index + 1 }}</h4>
                                    <button type="button" wire:click="removeIncomeSource({{ $index }})" class="text-red-600 hover:text-red-800">
                                        Remove
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Amount (RON)</label>
                                        <input type="number" wire:model="additionalIncomeSources.{{ $index }}.amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error("additionalIncomeSources.{$index}.amount") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Type</label>
                                        <select wire:model="additionalIncomeSources.{{ $index }}.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select income type</option>
                                            <option value="salary">Salary</option>
                                            <option value="business">Business</option>
                                            <option value="investments">Investments</option>
                                            <option value="freelance">Freelance</option>
                                            <option value="other">Other</option>
                                        </select>
                                        @error("additionalIncomeSources.{$index}.type") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Frequency</label>
                                        <select wire:model="additionalIncomeSources.{{ $index }}.frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select frequency</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="bi_weekly">Bi-weekly</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                        @error("additionalIncomeSources.{$index}.frequency") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Family Members</h3>
                        <button type="button" wire:click="addFamilyMember" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Family Member
                        </button>

                        @foreach($familyMembers as $index => $member)
                            <div class="mt-4 p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-md font-medium text-gray-900">Family Member #{{ $index + 1 }}</h4>
                                    <button type="button" wire:click="removeFamilyMember({{ $index }})" class="text-red-600 hover:text-red-800">
                                        Remove
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" wire:model="familyMembers.{{ $index }}.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error("familyMembers.{$index}.name") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Relationship</label>
                                        <select wire:model="familyMembers.{{ $index }}.relationship" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select relationship</option>
                                            <option value="spouse">Spouse</option>
                                            <option value="child">Child</option>
                                            <option value="parent">Parent</option>
                                            <option value="sibling">Sibling</option>
                                            <option value="other">Other</option>
                                        </select>
                                        @error("familyMembers.{$index}.relationship") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Monthly Income (RON)</label>
                                        <input type="number" wire:model="familyMembers.{{ $index }}.income" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error("familyMembers.{$index}.income") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Income Type</label>
                                        <select wire:model="familyMembers.{{ $index }}.income_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select income type</option>
                                            <option value="salary">Salary</option>
                                            <option value="business">Business</option>
                                            <option value="investments">Investments</option>
                                            <option value="freelance">Freelance</option>
                                            <option value="other">Other</option>
                                        </select>
                                        @error("familyMembers.{$index}.income_type") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif($currentStep === 2)
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Essential Monthly Expenses</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="food_expenses" class="block text-sm font-medium text-gray-700">Food Expenses (RON)</label>
                                <input type="number" id="food_expenses" wire:model="food_expenses" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('food_expenses') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="transport_expenses" class="block text-sm font-medium text-gray-700">Transport Expenses (RON)</label>
                                <input type="number" id="transport_expenses" wire:model="transport_expenses" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('transport_expenses') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="bills_expenses" class="block text-sm font-medium text-gray-700">Bills (RON)</label>
                                <input type="number" id="bills_expenses" wire:model="bills_expenses" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('bills_expenses') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Other Essential Expenses</h3>
                        <button type="button" wire:click="addOtherEssentialExpense" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Add Other Expense
                        </button>

                        @foreach($other_essential_expenses as $index => $expense)
                            <div class="mt-4 p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-md font-medium text-gray-900">Expense #{{ $index + 1 }}</h4>
                                    <button type="button" wire:click="removeOtherEssentialExpense({{ $index }})" class="text-red-600 hover:text-red-800">
                                        Remove
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Amount (RON)</label>
                                        <input type="number" wire:model="other_essential_expenses.{{ $index }}.amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error("other_essential_expenses.{$index}.amount") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <input type="text" wire:model="other_essential_expenses.{{ $index }}.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error("other_essential_expenses.{$index}.description") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @elseif($currentStep === 3)
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Do you have a house mortgage?</h3>
                        <div class="flex items-center space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model="has_mortgage" value="1" class="form-radio h-4 w-4 text-indigo-600">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model="has_mortgage" value="0" class="form-radio h-4 w-4 text-indigo-600">
                                <span class="ml-2">No</span>
                            </label>
                        </div>
                    </div>

                    @if($has_mortgage)
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="mortgage_amount" class="block text-sm font-medium text-gray-700">Total Mortgage Amount (RON)</label>
                                <input type="number" id="mortgage_amount" wire:model="mortgage_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('mortgage_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="mortgage_remaining" class="block text-sm font-medium text-gray-700">Remaining Amount to Pay (RON)</label>
                                <input type="number" id="mortgage_remaining" wire:model="mortgage_remaining" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('mortgage_remaining') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="mortgage_start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="mortgage_start_date" wire:model="mortgage_start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('mortgage_start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="mortgage_monthly_payment" class="block text-sm font-medium text-gray-700">Monthly Payment (RON)</label>
                                <input type="number" id="mortgage_monthly_payment" wire:model="mortgage_monthly_payment" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('mortgage_monthly_payment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif
                </div>
            @elseif($currentStep === 4)
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Other Debts</h3>
                        <p class="text-gray-600 mb-6">Add your other debts by category. You can use the default categories or create your own.</p>

                        <!-- Add New Category Form -->
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Add New Debt Category</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="newCategoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
                                    <input type="text" id="newCategoryName" wire:model="newCategoryName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('newCategoryName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="newCategoryDescription" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                                    <textarea id="newCategoryDescription" wire:model="newCategoryDescription" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                                <div>
                                    <button type="button" wire:click="addBadDebtCategory" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add Category
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Categories and Debts -->
                        <div class="space-y-6">
                            @foreach($badDebtCategories as $category)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="text-md font-medium text-gray-900">{{ $category['name'] }}</h4>
                                        <button type="button" wire:click="selectCategory({{ $category['id'] }})" class="text-indigo-600 hover:text-indigo-900">
                                            Add Debt
                                        </button>
                                    </div>
                                    
                                    @if($selectedCategory === $category['id'])
                                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                            <h5 class="text-sm font-medium text-gray-900 mb-4">Add New Debt</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Total Amount (RON)</label>
                                                    <input type="number" wire:model="newDebt.total_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @error('newDebt.total_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Minimum Payment (RON)</label>
                                                    <input type="number" wire:model="newDebt.minimum_payment" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @error('newDebt.minimum_payment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Current Balance (RON)</label>
                                                    <input type="number" wire:model="newDebt.current_balance" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @error('newDebt.current_balance') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                                    <input type="date" wire:model="newDebt.start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @error('newDebt.start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                                    <textarea wire:model="newDebt.notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="button" wire:click="addDebtToCategory({{ $category['id'] }})" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Save Debt
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @elseif($currentStep === 5)
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Savings Goals</h3>
                        <p class="text-gray-600 mb-6">Add your savings goals by category. You can use the default categories or create your own.</p>

                        <!-- Add New Category Form -->
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Add New Savings Category</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label for="newSavingsCategoryName" class="block text-sm font-medium text-gray-700">Category Name</label>
                                    <input type="text" id="newSavingsCategoryName" wire:model="newSavingsCategoryName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('newSavingsCategoryName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="newSavingsCategoryDescription" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                                    <textarea id="newSavingsCategoryDescription" wire:model="newSavingsCategoryDescription" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                                <div>
                                    <button type="button" wire:click="addSavingsCategory" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add Category
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Categories and Savings -->
                        <div class="space-y-6">
                            @foreach($savingsCategories as $category)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <h4 class="text-md font-medium text-gray-900">{{ $category['name'] }}</h4>
                                            @if($category['description'])
                                                <p class="text-sm text-gray-500">{{ $category['description'] }}</p>
                                            @endif
                                        </div>
                                        <button type="button" wire:click="selectSavingsCategory({{ $category['id'] }})" class="text-indigo-600 hover:text-indigo-900">
                                            Add Savings Goal
                                        </button>
                                    </div>
                                    
                                    @if($selectedSavingsCategory === $category['id'])
                                        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                                            <h5 class="text-sm font-medium text-gray-900 mb-4">Add New Savings Goal</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Current Amount (RON)</label>
                                                    <input type="number" wire:model="newSaving.amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @error('newSaving.amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Target Amount (RON)</label>
                                                    <input type="number" wire:model="newSaving.target_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @error('newSaving.target_amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                                    <input type="date" wire:model="newSaving.start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @error('newSaving.start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Target Date</label>
                                                    <input type="date" wire:model="newSaving.target_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    @error('newSaving.target_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                                    <textarea wire:model="newSaving.notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button type="button" wire:click="addSavingToCategory({{ $category['id'] }})" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Save Savings Goal
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-8 flex justify-between">
                @if($currentStep > 1)
                    <button type="button" wire:click="previousStep" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Previous
                    </button>
                @else
                    <div></div>
                @endif

                @if($currentStep < $totalSteps)
                    <button type="button" wire:click="nextStep" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Next
                    </button>
                @else
                    <button type="button" wire:click="completeOnboarding" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Complete Onboarding
                    </button>
                @endif
            </div>
        </div>
    </div>
</div> 