import Chart from 'chart.js/auto';

window.initializeCharts = function(expensesData, debtData, incomeVsExpensesData) {
    // Initialize Expenses Chart
    const expensesCtx = document.getElementById('expensesChart')?.getContext('2d');
    if (expensesCtx) {
        new Chart(expensesCtx, {
            type: 'pie',
            data: {
                labels: expensesData.labels,
                datasets: [{
                    data: expensesData.data,
                    backgroundColor: expensesData.colors,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
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

    // Initialize Debt Chart
    const debtCtx = document.getElementById('debtChart')?.getContext('2d');
    if (debtCtx) {
        new Chart(debtCtx, {
            type: 'pie',
            data: {
                labels: debtData.labels,
                datasets: [{
                    data: debtData.data,
                    backgroundColor: debtData.colors,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
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

    // Initialize Income vs Expenses Chart
    const incomeVsExpensesCtx = document.getElementById('incomeVsExpensesChart')?.getContext('2d');
    if (incomeVsExpensesCtx) {
        new Chart(incomeVsExpensesCtx, {
            type: 'bar',
            data: {
                labels: incomeVsExpensesData.labels,
                datasets: [
                    {
                        label: 'Income',
                        data: incomeVsExpensesData.income,
                        backgroundColor: '#4BC0C0',
                    },
                    {
                        label: 'Expenses',
                        data: incomeVsExpensesData.expenses,
                        backgroundColor: '#FF6384',
                    },
                    {
                        label: 'Savings',
                        data: incomeVsExpensesData.savings,
                        backgroundColor: '#36A2EB',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw.toLocaleString() + ' RON';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' RON';
                            }
                        }
                    }
                }
            }
        });
    }
}; 