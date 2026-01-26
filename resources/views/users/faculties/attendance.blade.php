@extends('layouts.app')

@section('content')
    
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Preview Attendances') }}</h1>
                </div>
            </div>
        </div>
    </div>
    
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
                            <table class="table table-responsive-sm table-striped-columns table-bordered table-hover" id="participants_table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Logged In</th>
                                        <th>Logged Out</th>
                                        <th>Attendance Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr>
                                        <td>{{ Str::title($attendance->title) }}</td>
                                        <td>{{ Carbon\Carbon::parse($attendance->date)->format('Y-m-d') }}</td>
                                        <td>{{ Carbon\Carbon::parse($attendance->time_start)->format('h:i A') }} - {{ Carbon\Carbon::parse($attendance->time_end)->format('h:i A') }}</td>
                                        <td>{{ $attendance->time_in ? Carbon\Carbon::parse($attendance->time_in)->format('h:i A'): null }}</td>
                                        <td>{{ $attendance->time_out ? Carbon\Carbon::parse($attendance->time_out)->format('h:i A'): null }}</td>
                                        <td>{{ Str::title($attendance->getPrettyStatus()) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready( function () {
        $('#participants_table').DataTable();
    } );
</script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('scripts')
    @if($message = Session::get('error'))
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            toastr.options = {
                "closeButton": true,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.error('{{ $message }}')
        </script>
    @enderror
@endsection