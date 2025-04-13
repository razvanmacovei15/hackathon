<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\FinancialOverview;
use App\Livewire\Onboarding\OnboardingWizard;
use App\Livewire\BabySteps\BabyStepsOverview;
use App\Livewire\BabySteps\BabyStepsStep1;
use App\Livewire\BabySteps\BabyStepsStep2;
use App\Livewire\BabySteps\BabyStepsStep3;
use App\Livewire\BabySteps\BabyStepsStep4;
use App\Livewire\BabySteps\BabyStepsStep5;
use App\Livewire\BabySteps\BabyStepsStep6;
use App\Livewire\BabySteps\BabyStepsStep7;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', FinancialOverview::class)->name('dashboard');
    
    // Onboarding
    Route::get('/onboarding', OnboardingWizard::class)->name('onboarding');

    // 7 Baby Steps
    Route::prefix('baby-steps')->group(function () {
        Route::get('/overview', BabyStepsOverview::class)->name('baby-steps.overview');
        Route::get('/step1', BabyStepsStep1::class)->name('baby-steps.step1');
        Route::get('/step2', BabyStepsStep2::class)->name('baby-steps.step2');
        Route::get('/step3', BabyStepsStep3::class)->name('baby-steps.step3');
        Route::get('/step4', BabyStepsStep4::class)->name('baby-steps.step4');
        Route::get('/step5', BabyStepsStep5::class)->name('baby-steps.step5');
        Route::get('/step6', BabyStepsStep6::class)->name('baby-steps.step6');
        Route::get('/step7', BabyStepsStep7::class)->name('baby-steps.step7');
    });

    // Settings
    Route::prefix('settings')->group(function () {
        Route::get('/profile', Profile::class)->name('settings.profile');
        Route::get('/password', Password::class)->name('settings.password');
        Route::get('/appearance', Appearance::class)->name('settings.appearance');
    });
});

require __DIR__.'/auth.php';
