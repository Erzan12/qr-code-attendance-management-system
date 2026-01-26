<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParticipantStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currentDate = now();

        $fiveDaysAgo = $currentDate->subDays(5);
        //$tenDaysAgo = $currentDate->subDays(5);

        /*
                $events = Event::where(function ($query) use ($fiveDaysAgo) {
                    $query->where('date', $fiveDaysAgo->toDateString());

                })
                ->get();
                */

        $events = Event::whereDate('date', '<', now()->format('Y-m-d'))
        //->where('time_end','>',now()->format('H:i:s'))
        ->get();

        foreach ($events as $event) {
            if ($event->eventParticipants()->count() > 0) {
                $event->eventParticipants()->update(['is_present' => 3]);
            }
            // echo $event->title . ' - ' . $event->date . '<br>';
        }

        // return view('events.index', ['events' => $events]);
    }
}
