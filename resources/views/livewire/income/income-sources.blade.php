<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold">Income Sources</h2>
        <p class="text-gray-600">Total Monthly Income: ${{ number_format($totalMonthlyIncome, 2) }}</p>
    </div>

    <!-- Add New Income Source Form -->
    <div class="mb-8 bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-4">Add New Income Source</h3>
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select wire:model="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Select Type</option>
                        <option value="salary">Salary</option>
                        <option value="investment">Investment</option>
                        <option value="business">Business</option>
                        <option value="rental">Rental</option>
                        <option value="other">Other</option>
                    </select>
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Amount</label>
                    <input type="number" step="0.01" wire:model="amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Frequency</label>
                    <select wire:model="frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                        <option value="one_time">One Time</option>
                    </select>
                    @error('frequency') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" wire:model="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">End Date (Optional)</label>
                    <input type="date" wire:model="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <label class="ml-2 block text-sm text-gray-900">Active</label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Add Income Source
                </button>
            </div>
        </form>
    </div>

    <!-- Income Sources List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($incomeSources as $source)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $source->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($source->type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($source->amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($source->frequency) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $source->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $source->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <button wire:click="edit({{ $source->id }})" class="text-primary-600 hover:text-primary-900">Edit</button>
                            <button wire:click="delete({{ $source->id }})" class="ml-4 text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $incomeSources->links() }}
        </div>
    </div>
</div> 