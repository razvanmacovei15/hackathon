<div>
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Financial Profile')" :subheading="__('Set up your financial profile to get personalized recommendations')">
        <form wire:submit="save" class="space-y-6">
            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    @for($i = 1; $i <= $totalSteps; $i++)
                        <div class="flex items-center">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full {{ $currentStep >= $i ? 'bg-primary-600 text-white' : 'bg-gray-200 text-gray-600' }}">
                                {{ $i }}
                            </div>
                            @if($i < $totalSteps)
                                <div class="h-1 w-8 {{ $currentStep > $i ? 'bg-primary-600' : 'bg-gray-200' }}"></div>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Step 1: Household Income -->
            @if($currentStep === 1)
                <div class="space-y-4">
                    <flux:heading size="lg">{{ __('Household Income') }}</flux:heading>
                    <flux:subheading>{{ __('Please enter your monthly household income') }}</flux:subheading>
                    
                    <flux:input
                        wire:model="household_income"
                        type="number"
                        label="{{ __('Monthly Household Income (RON)') }}"
                        placeholder="0.00"
                        step="0.01"
                        required
                    />
                </div>
            @endif

            <!-- Step 2: Basic Needs -->
            @if($currentStep === 2)
                <div class="space-y-4">
                    <flux:heading size="lg">{{ __('Basic Needs Expenses') }}</flux:heading>
                    <flux:subheading>{{ __('Please enter your monthly expenses for basic needs') }}</flux:subheading>
                    
                    <flux:input
                        wire:model="food_expenses"
                        type="number"
                        label="{{ __('Food Expenses (RON)') }}"
                        placeholder="0.00"
                        step="0.01"
                        required
                    />

                    <flux:input
                        wire:model="transport_expenses"
                        type="number"
                        label="{{ __('Transportation Expenses (RON)') }}"
                        placeholder="0.00"
                        step="0.01"
                        required
                    />

                    <flux:input
                        wire:model="bills_expenses"
                        type="number"
                        label="{{ __('Bills (Utilities, Internet, etc.) (RON)') }}"
                        placeholder="0.00"
                        step="0.01"
                        required
                    />
                </div>
            @endif

            <!-- Step 3: Debt -->
            @if($currentStep === 3)
                <div class="space-y-4">
                    <flux:heading size="lg">{{ __('Debt Information') }}</flux:heading>
                    <flux:subheading>{{ __('Please enter your total current debt amounts') }}</flux:subheading>
                    
                    <flux:input
                        wire:model="car_loan"
                        type="number"
                        label="{{ __('Total Car Loan Remaining (RON)') }}"
                        placeholder="0.00"
                        step="0.01"
                        required
                    />

                    <flux:input
                        wire:model="mortgage"
                        type="number"
                        label="{{ __('Total Mortgage Remaining (RON)') }}"
                        placeholder="0.00"
                        step="0.01"
                        required
                    />

                    <flux:input
                        wire:model="credit_card_debt"
                        type="number"
                        label="{{ __('Total Credit Card Debt (RON)') }}"
                        placeholder="0.00"
                        step="0.01"
                        required
                    />
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex items-center justify-between">
                @if($currentStep > 1)
                    <flux:button type="button" wire:click="previousStep">
                        {{ __('Previous') }}
                    </flux:button>
                @else
                    <div></div>
                @endif

                @if($currentStep < $totalSteps)
                    <flux:button type="button" wire:click="nextStep" variant="primary">
                        {{ __('Next') }}
                    </flux:button>
                @else
                    <flux:button type="submit" variant="primary">
                        {{ __('Save Profile') }}
                    </flux:button>
                @endif
            </div>
        </form>

        <x-action-message class="me-3" on="profile-updated">
            {{ __('Profile saved successfully.') }}
        </x-action-message>
    </x-settings.layout>
</div>
