@extends('layouts.app')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js" integrity="sha512-16cHhHqb1CbkfAWbdF/jgyb/FDZ3SdQacXG8vaOauQrHhpklfptATwMFAc35Cd62CQVN40KDTYo9TIsQhDtMFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Generated QR Code') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <canvas id="qrcode"></canvas>
                            <h3 class="text-center text-info">{{ $user->name }}</h3>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-block my-3" onclick="printJS('qrcode', 'html')">Print</button>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

<script type="text/javascript">
    new QRious({element: document.getElementById("qrcode"), value: "{{$qrcode}}", size: 180,});
</script>
@endsection