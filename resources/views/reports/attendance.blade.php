@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Event Records') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="get" class="row">
                                <select name="event" id="event" class="events col-md-4 col-lg-4 form-control my-2 my-md-0 mr-md-2">
                                    <option value="">Select event</option>
                                    @foreach ($events as $event)
                                        <option value="{{$event->id}}" @selected(request()->event == $event->id)>{{$event->title}}</option>
                                    @endforeach
                                </select>
                               
                                {{-- <select name="event" id="event" class="events col-md-4 col-lg-4 form-control my-2 my-md-0 mr-md-2">
                                    <option value="">Select Year</option>
                                </select> --}}

                                <button type="submit" class="col-md-2 col-lg-1 btn btn-sm btn-primary my-2 my-md-0 ml-md-2">Generate</button>
                            </form>
                        </div>
                    </div>

                    @if(count($participants) > 0)
                        <div class="card">
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        @foreach ($participants as $key => $value)
                                        <button class="nav-link" id="nav-{{$key}}-tab" data-toggle="tab" data-target="#nav-{{$key}}" type="button" role="tab" aria-controls="nav-{{$key}}" aria-selected="false">
                                            {{$key}}
                                            <div class="d-flex">
                                                <span class="mx-1 badge badge-success" title="Number of Present Participants">{{ $participantPresentCount[$key] }}</span>
                                                <span class="ml-1 badge badge-danger" title="Number of Absent Participants">{{ $participantAbsentCount[$key] }}</span>
                                            </div>
                                        </button>
                                        @endforeach
                                    </div>
                                </nav>

                                <div class="tab-content mt-1" id="nav-tabContent">
                                    @foreach ($participants as $key => $value)
                                        <div class="tab-pane fade show" id="nav-{{$key}}" role="tabpanel" aria-labelledby="nav-{{$key}}-tab">
                                            <table class="table table-responsive-sm table-striped-columns table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID Number</th>
                                                        <th>Participant Name</th>
                                                        <th>Participant Type</th>
                                                        <th>Participant Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($value as $participant)
                                                    <tr>
                                                        <td>{{$participant->id_number}}</td>
                                                        <td>{{$participant->name}}</td>
                                                        <td>{{$participant->getPrettyUserType() }}</td>
                                                        <td>{{$participant->getPrettyStatus() }}</td>
                                                    </tr>    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('styles')
    <style scoped>
        .select2-selection__rendered {
            line-height: 18px !important;
        }    
    </style>    
@endsection

@section('scripts')
    <script defer>
        $('.events').select2();
    </script>
@endsection