<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Faculty;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ScanController extends Controller
{
    private const LATE_THRESHOLD_MINUTES = 10; // 0-10 min after start = on time
    private const LOGIN_CUTOFF_MINUTES = 30; // 30+ min after start = rejected

    public function show(Request $request)
    {
        $request->validate(['qr_code' => 'required|string']);
        $qrCode = $request->query('qr_code');

        try {
            $decodedString = Crypt::decryptString($qrCode);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Invalid or unreadable QR code'], 422);
        }

        $codes = explode('-', $decodedString);

        if (count($codes) != 2) {
            return response()->json(['status' => false, 'message' => 'Malformed QR code'], 422);
        }

        $user = $codes[1] == '2'
            ? Student::select(['id_number', 'name'])->find($codes[0])
            : Faculty::select(['employee_id as id_number', 'name'])->find($codes[0]);

        if (! $user) {
            return response()->json(['status' => false, 'message' => 'No matching user found'], 404);
        }

        $user['user_id'] = $codes[0];
        $user['user_type'] = $codes[1];

        return response()->json([
            'status' => true,
            'information' => $user,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'user_type' => 'required',
            'event' => 'required',
        ]);

        $participant = EventParticipant::where([
            'user_id' => $request->user_id,
            'user_type' => $request->user_type,
            'event_id' => $request->event,
        ])->first();

        if (! $participant) {
            return response()->json(['status' => false, 'message' => 'Participant was not included in the event'], 404);
        }

        $event = Event::find($request->event);

        if (! $event) {
            return response()->json(['status' => false, 'message' => 'Event not found'], 404);
        }

        if ($event->date != now('Asia/Singapore')->format('Y-m-d')) {
            return response()->json(['status' => false, 'message' => 'Unable to proceed, event date does not match today\'s date'], 422);
        }

        // $timeNow = now('Asia/Singapore')->format('Y-m-d H:i:s');
        $now = now('Asia/Singapore');
        $startTime = Carbon::parse($event->date.' '.$event->time_start, 'Asia/Singapore');
        $endTime = Carbon::parse($event->date.' '.$event->time_end, 'Asia/Singapore');

        // if ($participant->is_present == EventParticipant::STATUS_NONE) {
        //     if ($timeNow <= Carbon::parse($event->date.' '.$event->time_start)->addHour()->format('Y-m-d H:i:s')) {
        //         $participant->update([
        //             'time_in' => now('Asia/Singapore')->format('Y-m-d H:i:s'),
        //             'is_present' => 1,
        //         ]);

        //         return response()->json(['status' => true, 'message' => 'Participant successfully logged in', 'participant' => $participant]);
        //     }

        //     return response()->json(['status' => false, 'message' => 'Login window has passed'], 422);
        // }

        if ($participant->is_present == EventParticipant::STATUS_NONE) {
            $minutesSinceStart = $now->greaterThan($startTime) ? $startTime->diffInMinutes($now) : 0;

            if ($minutesSinceStart >= self::LOGIN_CUTOFF_MINUTES) {
                $participant->update(['is_present' => EventParticipant::STATUS_ABSENT]);

                return response()->json(['status' => false, 'message' => 'Login window has closed. Marked as absent.'], 422);
            }

            $remark = $minutesSinceStart >= self::LATE_THRESHOLD_MINUTES ? 'late' : 'on_time';

            $participant->update([
                'time_in' => $now->format('Y-m-d H:i:s'),
                'is_present' => EventParticipant::STATUS_LOGIN_ONLY,
                'login_remark' => $remark,
            ]);

            return response()->json([
                'status' => true,
                'message' => $remark === 'late' ? 'Logged in - mark as LATE' : 'Sucessfully logged in - on time',
                'remark' => $remark,
                'partipant' => $participant,
            ]);
        }

        // if ($participant->is_present == EventParticipant::STATUS_LOGIN_ONLY) {
        //     if ($timeNow <= Carbon::parse($event->date.' '.$event->time_end)->addHour()->format('Y-m-d H:i:s')) {
        //         $participant->update([
        //             'time_out' => now('Asia/Singapore')->format('Y-m-d H:i:s'),
        //             'is_present' => 2,
        //         ]);

        //         return response()->json(['status' => true, 'message' => 'Participant successfully logged out', 'participant' => $participant]);
        //     }

        //     return response()->json(['status' => false, 'message' => 'Logout window has passed'], 422);
        // }

        if ($participant->is_present == EventParticipant::STATUS_LOGIN_ONLY) {
            // Logout window opens at event end time, not before
            if ($now->lessThan($endTime)) {
                return response()->json(['status' => false, 'message' => 'Logout is only available once the event has ended'], 422);
            }

            if ($now->lessThanOrEqualTo($endTime->copy()->addHour())) {
                $participant->update([
                    'time_out' => $now->format('Y-m-d H:i:s'),
                    'is_present' => EventParticipant::STATUS_PRESENT,
                ]);

                return response()->json(['status' => true, 'message' => 'Successfully logged out', 'participant' => $participant]);
            }

            return response()->json(['status' => false, 'message' => 'Logout window has passed'], 422);
        }

        if ($participant->is_present == EventParticipant::STATUS_ABSENT) {
            return response()->json(['status' => false, 'message' => 'Participant was marked absent'], 422);
        }

        return response()->json(['status' => true, 'message' => 'Participant has already attended the event']);
    }
}
