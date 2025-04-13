<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Baby Step 1: Save 5000RON for Emergencies</h2>
        <span class="px-3 py-1 text-sm font-semibold text-white bg-blue-600 rounded-full">Step 1</span>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Your Progress</h3>
                <div class="mt-2">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ number_format($currentEmergencyFund) }} RON / {{ number_format($targetEmergencyFund) }} RON</span>
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
                    Having 5000RON in emergency savings is your first step toward financial security. This fund will help you handle unexpected expenses without going into debt.
                </p>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Tips to Complete This Step</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Cut unnecessary expenses temporarily</li>
                    <li>Sell items you no longer need</li>
                    <li>Take on extra work or side gigs</li>
                    <li>Save any windfalls or tax refunds</li>
                </ul>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Next Steps</h3>
                <p class="text-gray-600">
                    Once you've saved your 5000RON emergency fund, you'll be ready to move on to Baby Step 2: Paying off all debt (except the house) using the debt snowball method.
                </p>
            </div>
        </div>
    </div>
</div> 