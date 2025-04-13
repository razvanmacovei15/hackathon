<?php

namespace App\Observers;

use App\Models\UserSaving;

class UserSavingObserver
{
    /**
     * Handle the UserSaving "created" event.
     */
    public function created(UserSaving $userSaving): void
    {
        //
    }

    /**
     * Handle the UserSaving "updated" event.
     */
    public function updated(UserSaving $userSaving): void
    {
        //
    }

    /**
     * Handle the UserSaving "deleted" event.
     */
    public function deleted(UserSaving $userSaving): void
    {
        //
    }

    /**
     * Handle the UserSaving "restored" event.
     */
    public function restored(UserSaving $userSaving): void
    {
        //
    }

    /**
     * Handle the UserSaving "force deleted" event.
     */
    public function forceDeleted(UserSaving $userSaving): void
    {
        //
    }
}
