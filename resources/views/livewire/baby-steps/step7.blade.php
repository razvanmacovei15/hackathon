<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Baby Step 7: Build Wealth and Give Generously</h2>
        <span class="px-3 py-1 text-sm font-semibold text-white bg-blue-600 rounded-full">Step 7</span>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Your Progress</h3>
                <div class="mt-2 space-y-4">
                    <!-- Wealth Building Progress -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Current Wealth: ${{ number_format($currentWealth) }}</span>
                            <span class="text-sm font-medium text-gray-700">Target: ${{ number_format($targetWealth) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $wealthProgress }}%"></div>
                        </div>
                    </div>

                    <!-- Giving Progress -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">Monthly Giving: ${{ number_format($currentGiving) }}</span>
                            <span class="text-sm font-medium text-gray-700">Target: ${{ number_format($targetGiving) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $givingProgress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Why This Step Matters</h3>
                <p class="text-gray-600">
                    Building wealth and giving generously allows you to live and give like no one else, creating a lasting legacy.
                </p>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Tips to Complete This Step</h3>
                <ul class="list-disc list-inside text-gray-600 space-y-1">
                    <li>Continue investing and growing your wealth</li>
                    <li>Set up a giving plan</li>
                    <li>Consider creating a family foundation</li>
                    <li>Teach others about financial peace</li>
                </ul>
            </div>

            <div class="space-y-2">
                <h3 class="text-lg font-semibold text-gray-900">Congratulations!</h3>
                <p class="text-gray-600">
                    You've completed all seven baby steps! Continue building wealth and giving generously to make a lasting impact.
                </p>
            </div>
        </div>
    </div>
</div> 