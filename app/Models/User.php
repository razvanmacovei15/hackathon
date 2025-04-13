<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'onboarded',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'onboarded' => 'boolean',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Mark the user as having completed onboarding
     */
    public function markOnboardingComplete(): void
    {
        $this->update(['onboarded' => true]);
    }

    public function monthlyEarnings()
    {
        return $this->hasMany(UserMonthlyEarning::class);
    }

    public function monthlyExpenses()
    {
        return $this->hasMany(EssentialMonthlyExpense::class);
    }

    public function mortgages()
    {
        return $this->hasMany(MonthlyHouseMortgage::class);
    }

    public function monthlyDebtPayments()
    {
        return $this->hasMany(UserMonthlyDebtPayment::class);
    }

    public function savings()
    {
        return $this->hasMany(UserSaving::class);
    }

    public function financialSituation()
    {
        return $this->hasOne(UserFinancialSituation::class);
    }
}
