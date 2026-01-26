@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('New Event') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">

                        <form action="{{ route('events.index') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="{{ __('Title') }}" value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="error invalid-feedback">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="date">Date</label>
                                    <input type="date" name="date"
                                           class="form-control @error('date') is-invalid @enderror"
                                           placeholder="{{ __('Date') }}" value="{{ old('date') }}" required>
                                    @error('date')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="time_start">Time Start</label>
                                    <input type="time" name="time_start"
                                           class="form-control @error('time_start') is-invalid @enderror"
                                           placeholder="{{ __('Time Start') }}" value="{{ old('time_start') }}" required>
                                    @error('time_start')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="time_end">Time End</label>
                                    <input type="time" name="time_end"
                                           class="form-control @error('time_end') is-invalid @enderror"
                                           placeholder="{{ __('Time End') }}" value="{{ old('time_end') }}" required>
                                    @error('time_end')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" cols="30" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                    @error('time_end')
                                    <span class="error invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection