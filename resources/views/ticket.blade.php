<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">    

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link href="{{asset('img/favicon.png')}}" rel="icon">
    <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->        
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css" integrity="sha512-T584yQ/tdRR5QwOpfvDfVQUidzfgc2339Lc8uBDtcp/wYu80d7jwBgAxbyMh0a9YM9F8N3tdErpFI8iaGx6x5g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    {{-- <link href="{{asset('build/css/custom.css')}}" rel="stylesheet"> --}}
    <!-- Custom Theme Style -->

    <style>
        body {
            font-family: "Karla", sans-serif;
            background-color: #d0d0ce;
            min-height: 100vh;
        }     
        
        .card {
            border-radius: 40px;
            border: none;
        }

        .border-top-dashed {
            border-top: dashed #1c1d21 2px;
        }
    </style>
</head>
<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">        
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-6 offset-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="bg-danger text-white rounded-pill p-2 text-center">MCC E-Ticket</h3>
                                    <div class="p-4">
                                        <h4 class="font-weight-bold border-bottom">Ticket Details</h4>
                                        <span class="d-block"><b>Reference Number: </b>{{$ticket->reference_number}}</span>
                                        <span class="d-block"><b>Date: </b>{{custom_date_format($ticket->date, "F d Y")}}</span>
                                        <span class="d-block"><b>Time Slot: </b>{{$ticket->time_slot}}</span>
                                        <span class="d-block"><b>Room Name: </b>{{$ticket->room_name}}</span>
                                        <span class="d-block"><b>Ticket Status: </b>
                                            @if (Carbon::parse($ticket->date)->toDateString() < Carbon::now()->toDateString())
                                                <span class="badge badge-pill badge-warning">Ticket not yet Valid</span>
                                            @elseif (Carbon::parse($ticket->date)->toDateString() > Carbon::now()->toDateString())
                                                <span class="badge badge-pill badge-danger">Expired Ticket</span>
                                            @else
                                                <span class="badge badge-pill badge-success">Valid for Today</span>
                                            @endif                                            
                                        </span>
                                    </div>
                                </div>                                
                            </div>                
                            @if (Carbon::parse($ticket->date)->toDateString() == Carbon::now()->toDateString())              
                                <div class="card border-top-dashed">
                                    <div class="card-body text-center">
                                        {!! QrCode::size(300)->generate(URL::to('/') . '/e-ticket/' . $ticket->reference_number); !!}    
                                    </div>                                
                                </div>
                            @endif                                            
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </main>
    <!-- Scripts -->        
    <!-- jQuery -->    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap -->    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js" integrity="sha512-mULnawDVcCnsk9a4aG1QLZZ6rcce/jSzEGqUkeOLy0b6q0+T6syHrxlsAGH7ZVoqC93Pd0lBqd6WguPWih7VHA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>        
    <script src="{{asset('build/js/custom.js')}}"></script>     
</body>
</html>