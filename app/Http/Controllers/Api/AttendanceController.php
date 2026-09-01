<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\EventParticipant;
use App\Http\Controllers\Controller;

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
