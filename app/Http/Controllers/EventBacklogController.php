<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;

class EventBacklogController extends Controller
{
    public function __invoke()
    {
        $eventKeys = $eventItems = [];
        if (request()->has('month_start') && request()->has('month_end')) {
            if (request()->month_start > request()->month_end) {
                return redirect(route('report.event'));
            }

            $start = explode('-', request()->input('month_start'));
            $yearStart = $start[0];
            $monthStart = $start[1];

            $end = explode('-', request()->input('month_end'));
            $yearEnd = $end[0];
            $monthEnd = $end[1];

            $events = Event::whereYear('date', '>=', $yearStart)
                ->whereMonth('date', '>=', $monthStart)
                ->whereYear('date', '<=', $yearEnd)
                ->whereMonth('date', '<=', $monthEnd)
                ->oldest('date')
                ->get();

            $events = $events->map(function ($event) {
                $event->occassion = Carbon::parse($event->date)->format('Y F');

                return $event;
            })->groupBy('occassion');

            $events = $events->map(function ($occassion) {
                return $occassion->count();
            });

            $eventKeys = $this->loopArray($events, 'key');
            $eventItems = $this->loopArray($events, 'value');
        }

        return view('reports.events', compact('eventKeys', 'eventItems'));
    }

    private function loopArray($array, $name)
    {
        $items = [];

        foreach ($array as $key => $value) {
            if ($name == 'value') {
                $items[] = $value;
            } else {
                $items[] = $key;
            }
        }

        return $items;
    }
}
