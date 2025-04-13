<div class="container mx-auto px-4 py-8">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Monthly Income</h3>
            <p class="text-2xl font-bold text-green-600">{{ number_format($all_incomes_sum ?? 0, 2) }} RON</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Monthly Essential Expenses</h3>
            <p class="text-2xl font-bold text-red-600">{{ number_format($total_monthly_essensial_expenses ?? 0, 2) }} RON</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Savings</h3>
            <p class="text-2xl font-bold text-purple-600">{{ number_format($savings_sum ?? 0, 2) }} RON</p>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Income Breakdown -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Income Breakdown</h3>
            <canvas id="incomeChart" height="300"></canvas>
        </div>

        <!-- Expense Breakdown -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Expense Breakdown</h3>
            <canvas id="expenseChart" height="300"></canvas>
        </div>

        <!-- Debt Overview -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Debt Overview</h3>
            <canvas id="debtChart" height="300"></canvas>
        </div>

        <!-- Savings Progress -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Savings Progress</h3>
            <canvas id="savingsChart" height="300"></canvas>
        </div>
    </div>

    <!-- Financial Health Indicators -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Financial Health Indicators</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Expenses-to-Income Ratio -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-semibold text-gray-700 mb-2">Expenses-to-Income Ratio</h4>
                <div class="relative pt-1">
                    <div class="flex mb-2 items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                                @php
                                    $ratio = 0;
                                    if (($all_incomes_sum ?? 0) > 0) {
                                        $ratio = ($total_monthly_expenses ?? 0) / $all_incomes_sum * 100;
                                    }
                                @endphp
                                {{ number_format($ratio, 1) }}%
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                        <div style="width:{{ min($ratio, 100) }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-600"></div>
                    </div>
                    <p class="text-sm text-gray-600">
                        @php
                            $expenseRatio = $ratio;
                        @endphp
                        @if($expenseRatio <= 50)
                            <span class="text-green-600">Healthy</span> - Your expenses are well within your income.
                        @elseif($expenseRatio <= 70)
                            <span class="text-yellow-600">Moderate</span> - Consider reducing expenses or increasing income.
                        @else
                            <span class="text-red-600">High</span> - Your expenses are too high relative to your income.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Emergency Fund Progress -->
            <div class="bg-white rounded-lg shadow p-6">
                <h4 class="text-lg font-semibold text-gray-700 mb-2">Emergency Fund Progress</h4>
                <div class="relative pt-1">
                    @php
                        $emergencyFund = $savings->firstWhere('type', 'Emergency Fund');
                    @endphp
                    
                    @if($emergencyFund)
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200">
                                    {{ number_format($emergencyFund['amount'] ?? 0, 2) }} / {{ number_format($emergencyFund['target_amount'] ?? 0, 2) }} RON
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200">
                            <div style="width:{{ $emergencyFund['progress'] }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-600"></div>
                        </div>
                        <p class="text-sm text-gray-600">
                            @if($emergencyFund['progress'] >= 100)
                                <span class="text-green-600">Complete</span> - Your emergency fund is fully funded!
                            @elseif($emergencyFund['progress'] >= 50)
                                <span class="text-yellow-600">In Progress</span> - You're making good progress on your emergency fund.
                            @else
                                <span class="text-red-600">Needs Attention</span> - Consider prioritizing your emergency fund savings.
                            @endif
                        </p>
                    @else
                        <div class="text-center py-4">
                            <p class="text-red-600 font-semibold">You don't have an emergency fund started yet.</p>
                            <p class="text-sm text-gray-600 mt-2">It's recommended to have 3-6 months of expenses saved in an emergency fund.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@fluxScripts
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:initialized', () => {
        // Income Chart
        const incomeCtx = document.getElementById('incomeChart');
        if (incomeCtx) {
            new Chart(incomeCtx, {
                type: 'pie',
                data: {
                    labels: @json($incomeBreakdown?->pluck('name') ?? []),
                    datasets: [{
                        data: @json($incomeBreakdown?->pluck('amount') ?? []),
                        backgroundColor: [
                            '#4F46E5',
                            '#7C3AED',
                            '#EC4899',
                            '#F59E0B',
                            '#10B981'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw.toLocaleString() + ' RON';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Expense Chart
        const expenseCtx = document.getElementById('expenseChart');
        if (expenseCtx) {
            // Combine essential expenses with mortgage and debt payments
            const expenseLabels = [
                ...@json($essential_monthly_expenses?->pluck('name') ?? []),
                ...@json($mortgages?->map(function($mortgage) { return 'Mortgage #' . $mortgage->id; }) ?? []),
                ...@json($debts?->pluck('name') ?? [])
            ];
            const expenseData = [
                ...@json($essential_expenses ?? []),
                ...@json($mortgage_minimum_payments ?? []),
                ...@json($debt_minimum_payments ?? [])
            ];

            new Chart(expenseCtx, {
                type: 'doughnut',
                data: {
                    labels: expenseLabels,
                    datasets: [{
                        data: expenseData,
                        backgroundColor: [
                            '#EF4444',
                            '#F97316',
                            '#F59E0B',
                            '#10B981',
                            '#3B82F6',
                            '#8B5CF6',
                            '#EC4899',
                            '#6366F1'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.raw.toLocaleString() + ' RON';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Debt Overview Chart
        const debtCtx = document.getElementById('debtChart');
        if (debtCtx) {
            new Chart(debtCtx, {
                type: 'bar',
                data: {
                    labels: @json($debts?->pluck('name') ?? []),
                    datasets: [{
                        label: 'Total Amount (RON)',
                        data: @json($debts?->pluck('total_amount') ?? []),
                        backgroundColor: '#EF4444'
                    }, {
                        label: 'Remaining (RON)',
                        data: @json($debts?->pluck('remaining_amount') ?? []),
                        backgroundColor: '#F97316'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' RON';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw.toLocaleString() + ' RON';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Savings Progress Chart
        const savingsCtx = document.getElementById('savingsChart');
        if (savingsCtx) {
            new Chart(savingsCtx, {
                type: 'bar',
                data: {
                    labels: @json($savings?->pluck('name') ?? []),
                    datasets: [{
                        label: 'Current Amount (RON)',
                        data: @json($savings?->pluck('amount') ?? []),
                        backgroundColor: '#10B981'
                    }, {
                        label: 'Target Amount (RON)',
                        data: @json($savings?->pluck('target_amount') ?? []),
                        backgroundColor: '#3B82F6'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString() + ' RON';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.raw.toLocaleString() + ' RON';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script> 