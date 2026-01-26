@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Manage Events') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{$message}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="my-2 d-flex">
                                <form action="" type="get" class="d-flex">
                                    <input type="text" name="keyword" id="keyword" placeholder="Keyword" class="form-control" value="{{ request()->keyword }}">
                                    <button type="submit" class="btn btn-primary mx-2" title="Search Event">
                                        <i class="fas fa-search"></i>
                                    </button>  
                                </form>
                                    
                                @if(auth()->user()->isAdmin())
                                    <a href="{{route('events.create')}}" class="btn btn-success ml-auto" title="Add Event">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                @endif
                            </div>

                            <table class="table table-responsive-sm table-striped-columns table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Time Start</th>
                                        <th>Time End</th>                                        
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($events as $event)
                                    <tr>
                                        <td>
                                            <a class="btn btn-sm mr-2 btn-primary rounded-circle" data-toggle="collapse" href="#collapseEvent-{{$event->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            {{ $event->title }}
                                        </td>
                                        <td>{{ Carbon\Carbon::parse($event->date)->format('Y-m-d') }}</td>
                                        <td>{{ Carbon\Carbon::parse($event->time_start)->format('h:i A') }}</td>
                                        <td>{{ Carbon\Carbon::parse($event->time_end)->format('h:i A') }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{ route('events.show', ['event' => $event]) }}" class="btn btn-sm btn-primary mx-1" title="Show">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(auth()->user()->isAdmin())
                                                <a href="{{ route('event-participants.index', ['event' => $event]) }}" class="btn btn-sm btn-success mx-1" title="Manage participant">
                                                    <i class="fas fa-users"></i>
                                                </a>
                                                <a href="{{ route('scan.index', ['event' => $event]) }}" class="btn btn-sm btn-primary mx-1" title="Scan QRCode">
                                                    <i class="fa fa-camera"></i>
                                                </a>
                                                <a href="{{ route('events.edit', ['event' => $event]) }}" class="btn btn-sm btn-warning mx-1">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <form action="{{ route('events.destroy', ['event' => $event]) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mx-1">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="collapse" id="collapseEvent-{{$event->id}}">
                                        <td colspan="5">{{ $event->description }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No record</td>
                                    </tr>  
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{ $events->withQueryString()->links() }}
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection