<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Database\Seeder;

class EventParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faculties = Faculty::first();

        $events = Event::inRandomOrder()->limit(3)->get();
        foreach ($events as $event) {
            EventParticipant::create([
                'event_id' => $event->id,
                'user_id' => $faculties->id,
                'user_type' => 3,
            ]);
        }

        $students = Student::first();
        $events = Event::inRandomOrder()->limit(3)->get();
        foreach ($events as $event) {
            EventParticipant::create([
                'event_id' => $event->id,
                'user_id' => $students->id,
                'user_type' => 2,
            ]);
        }
    }
}
