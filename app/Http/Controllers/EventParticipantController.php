<?php

namespace App\Http\Controllers;

use App\Mail\InviteParticipantEmail;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventParticipantController extends Controller
{
    public function index($event_id)
    {
        $participants = EventParticipant::where('event_id', $event_id)->get();

        return view('events.participants.index', compact('participants', 'event_id'));
    }

    public function create()
    {
        $participants = EventParticipant::where('event_id', request()->event)->get();
        $faculties = Faculty::select([
            'id',
            'employee_id as id_number',
            'name',
            'department',
            DB::raw('(CASE WHEN faculties.id > 0 THEN 3 END) as user_type'),
        ])->whereNotIn('id', $participants->where('user_type', 3)->pluck('user_id')->all());

        $students = Student::select([
            'id',
            'id_number',
            'name',
            'department',
            DB::raw('(CASE WHEN students.id > 0 THEN 2 END) as user_type'),
        ])
        ->whereNotIn('id', $participants->where('user_type', 2)->pluck('user_id')->all())
        ->union($faculties)
        ->get();
        $participants = $students;

        return view('events.participants.create', compact('participants'));
    }

    public function store(Request $request)
    {
        if (! $request->has('participants')) {
            return redirect()->back()->withErrors(['participants' => 'Must select at least one participant.']);
        }

        $event = Event::find($request->event);

        $participants = collect($request->participants)->map(function ($value) use ($request, $event) {
            $datum = explode('-', $value);
            $participant['event_id'] = $request->event;
            $participant['user_id'] = $datum[0];
            $participant['user_type'] = $datum[1];
            $participant['created_at'] = now();
            $participant['updated_at'] = now();

            $user = '';
            if ($datum[1] == User::STUDENT) {
                $user = Student::find($datum[0]);
            } elseif ($datum[1] == User::FACULTY) {
                $user = Faculty::find($datum[0]);
            }

            if ($user) {
                Mail::to($user->email)->send(new InviteParticipantEmail($event, $user));
            }

            return $participant;
        });

        EventParticipant::insert($participants->all());

        return redirect()->route('event-participants.index', ['event' => $request->event])->with('success', 'Successfully added participants.');
    }

    public function destroy(Request $request)
    {
        $participantIds = $request->input('participants');
        if (! $participantIds || count($participantIds) < 1) {
            return redirect()->back()->with('error', 'Select at least one participant ID is required.');
        }

        EventParticipant::whereIn('id', $participantIds)->delete();

        return redirect()->back()->with('success', 'Participants have been successfully deleted.');
    }
}
