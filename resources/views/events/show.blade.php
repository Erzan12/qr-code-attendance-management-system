@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Event Details') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <hr>
                    <div class="d-md-flex">
                        <h3><b>{{ $event->title }}</b></h3>
                        <div class="ml-md-auto d-flex flex-column align-items-md-end">
                            <small>{{ $event->date }}</small>
                            <div class="d-flex">
                                <small>{{ Carbon\Carbon::parse($event->time_start)->format('h:i A') }}</small>
                                <small class="mx-1">-</small>
                                <small>{{ Carbon\Carbon::parse($event->time_end)->format('h:i A') }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow my-2">
                      <h6 class="card-header text-left">
                        Description
                      </h6>
                      <div class="card-body">
                        {{ $event->description }}
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection