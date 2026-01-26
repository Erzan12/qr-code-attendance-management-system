<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $eventAttendedCount = 0;
        $eventAbsentCount = 0;
        $numberOfEvents = 0;
        $numberOfUsers = 0;
        $todayEvents = [];
        $upcomingEvents = [];

        if (! auth()->user()->isAdmin()) {
            $user = auth()->user();
            $eventAttendedCount = EventParticipant::where('is_present', 2)
            ->where('user_id', auth()->user()->user_id)
            ->where('user_type', auth()->user()->account_type)
            ->count();

            $eventAbsentCount = EventParticipant::leftJoin('events', 'event_participants.event_id', '=', 'events.id')
            ->where('is_present', 0)
            ->where('user_id', auth()->user()->user_id)
            ->where('user_type', auth()->user()->account_type)
            ->whereDate('date', '<', now()->format('Y-m-d'))
            ->count();

            $todayEvents = Event::join('event_participants', 'events.id', '=', 'event_participants.event_id')
            ->select([
                'events.id as id',
                'title',
                'date',
                'time_start',
                'time_end',
                'description',
            ])
            ->whereDate('date', now()->format('Y-m-d'))
            ->where('user_id', auth()->user()->user_id)
            ->where('user_type', auth()->user()->account_type)
            ->get();

            $upcomingEvents = Event::join('event_participants', 'events.id', '=', 'event_participants.event_id')
            ->whereDate('date', '>', now('Asia/Singapore')->format('Y-m-d'))
            ->where('user_id', auth()->user()->user_id)
            ->where('user_type', auth()->user()->account_type)
            ->get();
        }
        if (auth()->user()->isAdmin()) {
            $numberOfEvents = Event::count();
            $numberOfUsers = User::where('account_type', '!=', '1')->count();
            $upcomingEvents = Event::whereDate('date', '>=', now()->format('Y-m-d'))->get();
        }

        return view('home', [
            'eventAttendedCount' => $eventAttendedCount,
            'eventAbsentCount' => $eventAbsentCount,
            'numberOfEvents' => $numberOfEvents,
            'numberOfUsers' => $numberOfUsers,
            'todayEvents' => $todayEvents,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }

    public function redirect()
    {
        $user = auth()->user();

        if ($user->account_type == 2) {
            return redirect(route('students.attendance', ['student' => $user->user_id]));
        }

        return redirect(route('faculties.attendance', ['faculty' => $user->user_id]));
    }
}
