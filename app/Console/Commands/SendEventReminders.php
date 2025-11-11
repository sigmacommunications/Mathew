<?php

namespace App\Console\Commands;

use App\Mail\EventReminderMail;
use App\Models\Event;
use App\Models\EventRegistration;
use Carbon\Carbon;
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
        $now = Carbon::now();
        $start = $now->copy()->startOfMinute();
        $end = $now->copy()->endOfMinute();
        $this->info("Start: {$start->toDateTimeString()}, End: {$end->toDateTimeString()}");

        $events = Event::where('reminder_sent', false)->get();
        foreach ($events as $event) {
            $reminder_time_check = Carbon::parse($event->event_date)->subMinutes($event->reminder_time);
            $this->info("Reminder Timing: {$reminder_time_check}");

            if ($reminder_time_check->between($start, $end)) {
                $this->info("Sending Emails for Event ID: {$event->id}, Reminder Time: {$reminder_time_check->toDateTimeString()}");

                $registrations = EventRegistration::where('event_id', $event->id)->get();

                foreach ($registrations as $registration) {
                    Mail::to($registration->email)->send(new EventReminderMail($event));
                    $this->info("Email sent to: {$registration->email}");
                }

                $event->update(['reminder_sent' => true]);
            }
        }
    }
}
