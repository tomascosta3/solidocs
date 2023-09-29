<?php

namespace App\Console\Commands;

use App\Mail\EventReminder;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    
        /**
         * Get all events that are about to start and 
         * have not yet sent a reminder.
         */
        $events = Event::where('reminder_sent', false)
            ->whereNot('reminder', null)
            ->whereRaw('TIMESTAMPDIFF(MINUTE, NOW(), start) <= reminder')
                ->get();

        foreach($events as $event) {
            
            // Send email.
            $users = $event->users;
            foreach($users as $user) {
                Mail::to($user->email)->queue(new EventReminder($event));
            }

            // Send push notification.

            $event->update(['reminder_sent' => true]);
        }
    }
}
