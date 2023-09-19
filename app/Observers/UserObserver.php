<?php

namespace App\Observers;

use App\Mail\AccountVerification;
use App\Models\Calendar;
use App\Models\Day;
use App\Models\DayUser;
use App\Models\Login;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $token = Str::random(60);

        // Create the login and link it to the user.
        $login = Login::create([
            'user_id' => $user->id,
            'verification_code' => $token,
            'verification_code_issue_date' => Carbon::now(),
            'verification_code_expiration_date' => Carbon::now()->addMinutes(30),
        ]);


        /**
         * Create days-user relations.
         */
        $days = Day::where('active', true)->get();

        foreach($days as $day) {

            DayUser::create([
                'user_id' => $user->id,
                'day_id' => $day->id,
                'days_available' => $day->default_amount,
            ]);
        }

        /**
         * Create user's personal calendar.
         */
        $calendar = Calendar::create([
            'user_id' => $user->id,
            'name' => 'Personal',
        ]);

        // Link calendar with user.
        $user->calendars()->attach($calendar);

        // Send email to account verification.
        Mail::to($user->email)->queue(new AccountVerification($login, $user));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
