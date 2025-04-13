<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Baby Step 3: Save 3-6 Months of Expenses</h2>
        <span class="px-3 py-1 text-sm font-semibold text-white bg-blue-600 rounded-full">Step 3</span>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Your Progress</h3>
                <div class="mt-2">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">${{ number_format($currentEmergencyFund) }} / ${{ number_format($targetEmergencyFund) }}</span>
                        <span class="text-sm font-medium text-gray-700">{{ round($progress) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Why This Step Matters</h3>
                <p class="text-gray-600">
                    A fully funded emergency fund of 3-6 months of expenses will protect you from life's unexpected events and give you peace of mind.
                </p>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Tips to Complete This Step</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Calculate your total monthly expenses</li>
                    <li>Multiply by 3-6 months (depending on your situation)</li>
                    <li>Keep this money in a separate savings account</li>
                    <li>Only use it for true emergencies</li>
                </ul>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Next Steps</h3>
                <p class="text-gray-600">
                    Once you have your emergency fund fully funded, you'll be ready to move on to Baby Step 4: Invest 15% of household income into retirement.
                </p>
            </div>
        </div>
    </div>
</div> 