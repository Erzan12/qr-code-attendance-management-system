@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Event History') }}</h1>
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
                                <input type="month" name="month_start" id="month" class="form-control col-12 col-md-3 col-lg-2 my-1 mr-md-1" title="Month Start" value="{{ request()->month_start }}">
                                <input type="month" name="month_end" id="month" class="form-control col-12 col-md-3 col-lg-2 my-1 mx-md-1" title="Month End" value="{{ request()->month_end }}">
                                <button type="submit" class="btn btn-primary col-12 col-md-2 col-lg-1 my-1 ml-md-1">Generate</button>
                            </form>
                        </div>
                    </div>

                    <canvas id="myChart" style="width:100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

   

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="list-group">
                                 <form action="" method="get" class="row">
                                       <h6 > Events </h6>
                                        <button type="button" class="list-group-item list-group-item-action" >{{ request()->month_start}}
                                        {{ request()->event_title}}
                                        </button> 
                                </form>
                        </div>
        </div>
            </div>
            </div>
            </div>
        </div>
 
@endsection



@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <script>
        var xValues = @json($eventKeys);
        var yValues = @json($eventItems);
        
        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        let barColors = [];
        xValues.forEach((item) => {
            barColors.push(getRandomColor());
        });
        

        new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
        });
        
    </script>
@endsection



