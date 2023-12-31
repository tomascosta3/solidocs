<?php

namespace App\Observers;

use App\Mail\AccountVerification;
use App\Models\Calendar;
use App\Models\Day;
use App\Models\DayUser;
use App\Models\Folder;
use App\Models\Login;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
            'name' => 'Calendario de ' . $user->first_name . ' ' . $user->last_name,
        ]);

        // Link calendar with user.
        $user->calendars()->attach($calendar);

        /**
         * Create user's personal folder.
         */
        $folder = Folder::create([
            'name' => $user->first_name . ' ' . $user->last_name,
        ]);

        $user->folders()->attach($folder->id, [
            'can_read' => true,
            'can_write' => true,
        ]);

        $sub_folder = Folder::create([
            'name' => 'Certificados',
            'parent_id' => $folder->id,
        ]);

        $user->folders()->attach($sub_folder->id, [
            'can_read' => true,
            'can_write' => true,
        ]);

        // Create local folder.
        $folderPath = config('folders.folders.users') . $user->id;
        Storage::disk('local')->makeDirectory($folderPath);

        $subfolderPath = $folderPath . '/Certificados';
        Storage::disk('local')->makeDirectory($subfolderPath);

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
