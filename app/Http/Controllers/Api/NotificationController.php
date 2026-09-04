<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //

    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json(
            Notification::forUser($user->user_id, $user->account_type)
                ->latest()
                ->paginate(15)
        );
    }

    public function unreadCount(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'count' => Notification::forUser(
                $user->user_id,
                $user->user_account_type
            )
            ->unread()
            ->count(),
        ]);
    }

    public function markUnread(Request $request, Notification $notification)
    {
        $user = $request->user();

        if (
            $notification->user_id != $user->user_id ||
            $notification->user_type !== $user->account_type
        ) {
            abort(403);
        }

        $notification->update([
            'read_at' => null,
        ]);

        return response()->json([
            'status' => true,
        ]);
    }

    public function markRead(Request $request, Notification $notification)
    {
        $user = $request->user();

        if ($notification->user_id != $user->user_id || $notification->user_type !== $user->account_type) {
            abort(403);
        }

        $notification->update(['read_at' => now()]);

        return response()->json(['status' => true]);
    }

    public function markAllRead(Request $request)
    {
        $user = $request->user();

        Notification::forUser($user->user_id, $user->account_type)
            ->unread()
            ->update(['read_at' => now()]);

        return response()->json(['status' => true]);
    }

    public function destroy(Request $request, Notification $notification)
    {
        $user = $request->user();

        if (
            $notification->user_id != $user->user_id ||
            $notification->user_type !== $user->account_type
        ) {
            abort(403);
        }

        $notification->delete();

        return response()->json([
            'status' => true,
        ]);
    }
}
