@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Qr Code Scanner') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            @if ($message = Session::get('fail'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{$message}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{$message}}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div id="reader" width="600px"></div>
                            
                            <div class="mt-2 loading-container" hidden>
                                <div class="d-flex justify-content-center">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <h5 class="text-center loading-text">Loading...</h5>
                            </div>

                            <div class="mb-2 detail-container mx-3 px-3" hidden>
                                <form action="{{ route('scan.store', ['event' => request()->event]) }}" method="post">
                                    @csrf
                                    <input type="hidden" name="user_id">
                                    <input type="hidden" name="user_type">
                                    <div class="form-group">
                                        <label>ID Number</label>
                                        <h6 class="id_number">12345</h6>
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <h6 class="user_name">Developer</h6>
                                    </div>
                                    <div class="form-group d-flex justify-content-center">
                                        <button type="button" class="btn btn-danger mx-2 btn-cancel" onclick="cancelProcess()">Cancel</button>
                                        <button type="submit"  class="btn btn-success mx-2">Accept</button>
                                    </div>
                                </form>
                            </div>

                            <div class="d-flex justify-content-center mt-2">
                                <button onclick="scanQr()" type="button" class="btn btn-primary btn-scan" >Scan QR Code</button>
                                <button onclick="stopScan()" type="button" class="btn btn-danger btn-stop" hidden>Stop Scanning</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.7/html5-qrcode.min.js"></script>
    <script>
        let html5QrcodeScanner = new Html5Qrcode("reader");
        let btnScan = document.querySelector('.btn-scan');
        let btnStop = document.querySelector('.btn-stop');
        let loading = document.querySelector('.loading-container');
        let formContainer = document.querySelector('.detail-container');

        function toggleLoading(value)
        {
            if(value) {
                btnStop.setAttribute('hidden', true);
                btnScan.setAttribute('hidden', true);
                loading.removeAttribute('hidden', true);
                return;
            }

            btnStop.removeAttribute('hidden', true);
            btnScan.removeAttribute('hidden', true);
            loading.setAttribute('hidden', true);
        }

        function scanQr() {
            btnScan.setAttribute('hidden', true);
            btnStop.removeAttribute('hidden', true);
            html5QrcodeScanner.start({ facingMode: "environment" }, { fps: 10, qrbox: {width: 250, height: 250} }, onScanSuccess)
        }

        function stopScan() {
            btnStop.setAttribute('hidden', true);
            btnScan.removeAttribute('hidden', true);
            html5QrcodeScanner.stop();
        }

        function setInformation(information) {
            document.querySelector('input[name="user_id"]').value = information.user_id
            document.querySelector('input[name="user_type"]').value = information.user_type
            document.querySelector('h6[class="id_number"]').innerText = information.id_number
            document.querySelector('h6[class="user_name"]').innerText = information.name
        }

        function cancelProcess() {
            btnStop.setAttribute('hidden', true);
            btnScan.removeAttribute('hidden', true);
            loading.setAttribute('hidden', true);
            formContainer.setAttribute('hidden', true);
        }

        function onScanSuccess(decodedText) {
            html5QrcodeScanner.stop();
            toggleLoading(true)

            axios.get(`/scan/${decodedText}`)
                .then(function (response) {
                    loading.setAttribute('hidden', true);
                    response = response.data
                    console.log(response);
                    
                    if(response.status) {
                        formContainer.removeAttribute('hidden', true);
                        setInformation(response.information)
                    }else {
                        cancelProcess()
                    }
                })
                .catch(function (error) {
                    cancelProcess()

                    console.log(error);
                }); 
        }
    </script>
@endsection