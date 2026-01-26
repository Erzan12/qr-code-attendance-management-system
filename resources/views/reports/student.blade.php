@extends('layouts.app')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('Attendance Report') }}</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="get" class="row">
                            <input type="search" name="student_id" id="student_id" placeholder="Student ID" class="form-control col-12 col-md-3 col-lg-2 my-1 mr-md-1" title="student_id" value="{{ request()->student_id }}">
                            <button type="submit" class="btn btn-primary col-12 col-md-2 col-lg-1 my-1 ml-md-1"  title="Search Student">Search</button>
                           
                            
                           
                       
                        </form>
                    </div>
                </div>
                <div>
                    <h4>{{ $student?->name }}</h4
                    <span>{{ $student?->id_number }}</span>
                    
                

                    @if(count($attendances) > 0)
                    <div class="container">
                        <div class="text-right">
                            <h6>
                                LEGEND: 
                            </h6>
                        </div>
                    </div>
                    <div class="container">
                        <div class="text-right">
                            <span class="text-success">
                                X-Absent 
                            </span>
                        </div>
                    </div>
                <div class="container">
                    <div class="text-right">
                        <span class="text-success">
                           H-Half Day Only
                        </span>
                    </div>
                </div>
                <div class="container">
                    <div class="text-right">
                        <span class="text-success">
                           P-Present
                        </span>
                    </div>
                </div>
                        <table class="table-outline table table-responsive-sm table-striped-columns table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Event Title</th>
                                    <th>Event Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                <tr>
                                    <td>{{$attendance->event->title}}</td> 
                                    <td>{{$attendance->event->date}}</td> 
                                    <td>{{$attendance->getPrettyStatus2() }}</td>
                                </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                
         
        </div>
               

                <canvas id="myChart" style="width:100%;"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection