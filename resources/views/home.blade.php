@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            @if(auth()->user()->isAdmin())
            <div class="row">
                <div class="col-lg-3 p-3 m-2 bg-success text-light">
                    <div class="d-flex align-items-center">
                        <p>Number of Events</p>
                        <h2 class="ml-auto">{{ $numberOfEvents }}</h2>
                    </div>
                </div>
                <div class="col-lg-3 p-3 m-2 bg-danger text-light">
                    <div class="d-flex align-items-center">
                        <p>Number of Users</p>
                        <h2 class="ml-auto">{{ $numberOfUsers }}</h2>
                    </div>
                </div>
            </div>
            @endif

            @if(!auth()->user()->isAdmin())
            <div class="row">
                <div class="col-md-4 col-lg-3 card m-2 p-3 bg-success text-light">
                    <div class="d-flex align-items-center">
                        <p>Event Attended</p>
                        <h2 class="ml-auto">{{ $eventAttendedCount }}</h2>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3 card m-2 p-3 bg-danger text-light">
                    <div class="d-flex align-items-center">
                        <p>Missed Attendances</p>
                        <h2 class="ml-auto">{{ $eventAbsentCount }}</h2>
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <h4 class="card-text">
                                    {{ __("Todays Events") }}
                                </h4>
                                <a href="{{route('events.index')}}" class="ml-auto">View Events</a>
                            </div>
                            <hr>
                            <div class="lists">
                                @forelse ($todayEvents as $event)
                                    <div class="card p-2">
                                        <h5>{{ Str::title($event->title) }}</h5>
                                        <small>{{ Carbon\Carbon::parse($event->date)->format('Y-m-d') }}</small>
                                        <div class="d-flex">
                                            <small class="mr-1">{{ Carbon\Carbon::parse($event->time_start)->format('h:i A') }}</small>
                                            <small>-</small>
                                            <small class="ml-1">{{ Carbon\Carbon::parse($event->time_end)->format('h:i A') }}</small>
                                        </div>
                                        <a href="{{ route('events.show', ['event' => $event->id]) }}" class="stretched-link"></a>
                                    </div>
                                @empty
                                    <div class="d-flex h-100 w-100 justify-content-center align-items-center">
                                        No Event
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <h4 class="card-text">
                                    {{ __("Upcoming Events") }}
                                </h4>
                            </div>
                            <hr>
                            <div class="lists">
                                @forelse ($upcomingEvents as $event)
                                    <div class="card p-2">
                                        <h5>{{ Str::title($event->title) }}</h5>
                                        <small>{{ Carbon\Carbon::parse($event->date)->format('Y-m-d') }}</small>
                                        <div class="d-flex">
                                            <small class="mr-1">{{ Carbon\Carbon::parse($event->time_start)->format('h:i A') }}</small>
                                            <small>-</small>
                                            <small class="ml-1">{{ Carbon\Carbon::parse($event->time_end)->format('h:i A') }}</small>
                                        </div>
                                        <a href="{{ route('events.show', ['event' => $event->id]) }}" class="stretched-link"></a>
                                    </div>
                                @empty
                                    <div class="d-flex h-100 w-100 justify-content-center align-items-center">
                                        No Event
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style scoped>
        .lists {
            padding: 3px 10px;
            overflow-y: auto;
            height: calc(100vh - 55vh);
        }

    </style>
@endsection