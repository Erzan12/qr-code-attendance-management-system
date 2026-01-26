<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceReportController extends Controller
{
    public function __invoke(Request $request)
    {
        $events = Event::select(['id', 'title'])->get();
        $participants = [];
        $participantAbsentCount = $participantPresentCount = 0;
        if ($request->has('event')) {
            $studentParticipants = EventParticipant::leftJoin('students', 'event_participants.user_id', '=', 'students.id')
                ->select([
                    'id_number',
                    'name',
                    'department',
                    DB::raw('(CASE WHEN students.id > 0 THEN 2 END) as user_type'),
                    'is_present',
                ])
                ->where('event_id', $request->event)
                ->where('user_type', 2);

            $facultyParticipants = EventParticipant::leftJoin('faculties', 'event_participants.user_id', '=', 'faculties.id')
                ->select([
                    'employee_id as id_number',
                    'name',
                    'department',
                    DB::raw('(CASE WHEN faculties.id > 0 THEN 3 END) as user_type'),
                    'is_present',
                ])
                ->where('event_id', $request->event)
                ->where('user_type', 3);

            $participants = $facultyParticipants->union($studentParticipants)
                ->get()
                // ->where('is_present', true)
                ->groupBy('department');

            $participantPresentCount = $participants->map(function ($value, $key) {
                return $value->filter(function ($value, $key) {
                    return $value->is_present == true;
                })->count();
            });

            $participantAbsentCount = $participants->map(function ($value, $key) {
                return $value->filter(function ($value, $key) {
                    return $value->is_present == false;
                })->count();
            });

            // foreach($participants as $key => $value) {
            //     dd($participantPresentCount[$key]. '-'.$participantAbsentCount[$key]);
            // }
        }

        return view('reports.attendance', compact('events', 'participants', 'participantAbsentCount', 'participantPresentCount'));
    }
}
