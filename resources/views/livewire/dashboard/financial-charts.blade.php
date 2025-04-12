@push('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

<div>
    <!-- Debug Info -->
    <div class="mb-4 rounded-lg bg-gray-100 p-4 text-sm">
        <div>User ID: {{ Auth::id() }}</div>
        <div>Has Profile: {{ Auth::user()->financialProfile ? 'Yes' : 'No' }}</div>
    </div>

    <!-- Financial Overview Section -->
    <div class="grid gap-6 mb-6 md:grid-cols-4">
        <!-- Household Income Card -->
        <div class="rounded-lg bg-white p-6 shadow dark:bg-zinc-800">
            <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Monthly Income') }}</h3>
            <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                {{ number_format($this->getHouseholdIncome(), 2) }} RON
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Per Year: {{ number_format($this->getHouseholdIncome() * 12, 2) }} RON
            </div>
        </div>

        <!-- Total Monthly Expenses Card -->
        <div class="rounded-lg bg-white p-6 shadow dark:bg-zinc-800">
            <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Monthly Expenses') }}</h3>
            <div class="text-2xl font-bold text-red-600 dark:text-red-400">
                {{ number_format($this->getTotalMonthlyExpenses(), 2) }} RON
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ number_format($this->getExpenseToIncomeRatio() * 100, 1) }}% of income
            </div>
        </div>

        <!-- Total Debt Card -->
        <div class="rounded-lg bg-white p-6 shadow dark:bg-zinc-800">
            <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Total Debt') }}</h3>
            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                {{ number_format($this->getTotalDebt(), 2) }} RON
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Debt-to-Income: {{ number_format($this->getDebtToIncomeRatio(), 1) }}x
            </div>
        </div>

        <!-- Monthly Savings Card -->
        <div class="rounded-lg bg-white p-6 shadow dark:bg-zinc-800">
            <h3 class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Monthly Savings') }}</h3>
            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                {{ number_format($this->getMonthlySavings(), 2) }} RON
            </div>
            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ number_format($this->getSavingsRate() * 100, 1) }}% savings rate
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <!-- Expenses Pie Chart -->
        <div class="rounded-lg bg-white p-6 shadow dark:bg-zinc-800">
            <h3 class="mb-4 text-lg font-semibold">{{ __('Monthly Expenses Breakdown') }}</h3>
            <div class="h-64">
                <canvas id="expensesChart"></canvas>
            </div>
        </div>

        <!-- Debt Pie Chart -->
        <div class="rounded-lg bg-white p-6 shadow dark:bg-zinc-800">
            <h3 class="mb-4 text-lg font-semibold">{{ __('Debt Breakdown') }}</h3>
            <div class="h-64">
                <canvas id="debtChart"></canvas>
            </div>
        </div>

        <!-- Income vs Expenses Bar Chart -->
        <div class="rounded-lg bg-white p-6 shadow dark:bg-zinc-800">
            <h3 class="mb-4 text-lg font-semibold">{{ __('Income vs Expenses') }}</h3>
            <div class="h-64">
                <canvas id="incomeVsExpensesChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.initializeCharts(
                @json($this->getExpensesData()),
                @json($this->getDebtData()),
                @json($this->getIncomeVsExpensesData())
            );
        });
    </script>
</div> 