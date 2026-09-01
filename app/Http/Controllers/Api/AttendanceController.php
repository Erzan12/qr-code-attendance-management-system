<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventParticipant;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function myAttendance(Request $request)
    {
        $user = $request->user();
        $perPage = $request->integer('per_page', 5);

        $records = EventParticipant::where('user_id', $user->user_id)
            ->where('user_type', $user->account_type)
            ->with('event')
            ->latest('created_at')
            ->paginate($perPage);

        return response()->json($records);
    }
}
