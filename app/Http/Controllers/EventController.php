<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = Event::latest();

        if (! auth()->user()->isAdmin()) {
            $user = auth()->user();
            $eventIds = EventParticipant::where('user_id', $user->user_id)
                ->where('user_type', $user->account_type)
                ->get()
                ->pluck('event_id')
                ->toArray();

            $events = $events->whereIn('id', $eventIds);
        }

        if ($request->has('keyword') && $request->keyword != null) {
            $events = $events->where('title', 'LIKE', '%'.$request->keyword.'%')
            ->orwhere('description', 'LIKE', '%'.$request->keyword.'%')
            ->orwhere('date', 'LIKE', '%'.$request->keyword.'%');
        }

        $events = $events->paginate(10);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'time_start' => 'required',
            'time_end' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $event = new Event;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->time_start = $request->time_start;
        $event->time_end = $request->time_end;
        $event->save();

        return redirect(route('events.index'))->with('success', 'Event added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',

        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $event = Event::find($id);
        if (! $event) {
            abort(404);
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
        ]);

        return redirect(route('events.index'))->with('success', 'Event has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $event = Event::find($id);
        if (! $event) {
            abort(404);
        }

        $event->delete();

        return redirect(route('events.index'))->with('success', 'Event has been successfully deleted');
    }
}
