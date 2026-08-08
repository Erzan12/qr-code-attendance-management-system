<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Event::latest('date');

        if ($user->account_type != User::ADMIN) {
            $eventIds = EventParticipant::where('user_id', $user->user_id)
                ->where('user_type', $user->account_type)
                ->pluck('event_id');

            $query->whereIn('id', $eventIds);
        }

        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%'.$request->keyword.'%')
                  ->orWhere('description', 'LIKE', '%'.$request->keyword.'%')
                  ->orWhere('date', 'LIKE', '%'.$request->keyword.'%');
            });
        }

        return response()->json($query->paginate(10));
    }

    public function show(Event $event, Request $request)
    {
        $user = $request->user();

        if ($user->account_type != User::ADMIN) {
            $isParticipant = EventParticipant::where('event_id', $event->id)
                ->where('user_id', $user->user_id)
                ->where('user_type', $user->account_type)
                ->exists();

            if (! $isParticipant) {
                return response()->json(['message' => 'Not authorized to view this event'], 403);
            }
        }

        return response()->json($event);
    }
}