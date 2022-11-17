@extends('../layouts.app')
  
@section('content')    
    @include('../inc.side-bar')
    @include('../inc.header')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Ticket Sales</h3>
                </div>                                                
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/ticket-sales"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"></i> Sell Ticket</li>
                    </ol>
                </div>
                <div class="col-12 col-sm-12">
                    <div class="card-box table-responsive">                            
                        <div class="card bg-light mb-3">                                            
                            <div class="card-body">                                                                                                                                                                      
                                <div class="row">                                    
                                    <span class="col-12 col-lg-3"><b>Date:</b> {{custom_date_format($slot->date, "F d Y")}}</span>
                                    <span class="col-12 col-lg-3"><b>Time Slot:</b> {{$slot->time_slot}}</span>
                                    <span class="col-12 col-lg-2"><b>Room Name:</b> {{$slot->room_name}}</span>
                                    <span class="col-12 col-lg-2"><b>Capacity:</b> {{$slot->capacity}}</span>
                                    <span class="col-12 col-lg-2"><b>Fee:</b> {{$slot->fee}}</span>
                                </div>
                            </div>                                                    
                        </div>                                    
                    </div>
                </div>

                @if ($slot->ticketSales()->count() < $slot->capacity)
                    <div class="col-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_title">  
                                <h2><i class="fa-solid fa-cart-plus"></i> Sell Ticket</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                </ul>                            
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content mb-5">
                                <form id="form-sell-ticket" action="/ticket-sales/{{Crypt::encryptString($slot->id)}}/create" method="POST" novalidate>
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-info alert-dismissible " role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <h4><strong><i class="fa fa-exclamation-triangle"></i> The following error(s) were found:</strong></h4>
                                            <hr>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                @endforeach
                                            </ul>                                        
                                        </div>
                                    @endif
                                    
                                    <div class="field item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3  label-align" for="email_address">
                                            Email Address<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="email" class="form-control" name="email_address" id="email_address" value="{{ old('email_address') }}" required="required" autofocus />
                                        </div>
                                    </div>                                
                                                                    
                                    <div class="ln_solid">
                                        <div class="form-group mt-3">
                                            <div class="col-md-6 offset-md-3">
                                                <a href="/ticket-sales" class="btn btn-info"><i class="fa fa-arrow-left"></i> Cancel / Go Back</a>
                                                <button type='submit' class="btn btn-danger"><i class="fa-solid fa-cart-plus"></i> Sell Ticket</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>                            
                            </div>
                        </div>
                    </div>
                @endif                

                <div class="col-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">  
                            <h2><i class="fa-solid fa-file-invoice"></i> Sold Ticket(s)</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content mb-5">
                            <div class="card-box table-responsive">
                                <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>       
                                            <th>Date</th>                                             
                                            <th>Time</th>
                                            <th>Room Name</th>
                                            <th>Capacity</th>
                                            <th>Fee</th>
                                            <th>Email Address</th>
                                            <th>Reference Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                                
                                        @if ($ticket_sales)
                                            @foreach ($ticket_sales as $ticket_sale)                                                        
                                                <tr>
                                                    <td class="p-1 align-middle">{{custom_date_format($ticket_sale->date, "F d Y")}}</td>
                                                    <td class="p-1 align-middle">{{$ticket_sale->time_slot}}</td>
                                                    <td class="p-1 align-middle">{{$ticket_sale->room_name}}</td>
                                                    <td class="p-1 align-middle">{{$ticket_sale->capacity}}</td>
                                                    <td class="p-1 align-middle">{{$ticket_sale->fee}}</td>
                                                    <td class="p-1 align-middle">{{$ticket_sale->email_address}}</td>
                                                    <td class="p-1 align-middle">{{$ticket_sale->reference_number}}</td>
                                                </tr>
                                            @endforeach
                                        @endif                                                
                                    </tbody>
                                </table>                    
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>

    @if (session('message'))
        <div class="modal fade show" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">            
                    <div class="modal-header">
                        <img src="{{asset('img/logo.png')}}" style="height: 40px;">
                        <h4 class="modal-title pl-2" id="myModalLabel">MCC Admin System</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="text-danger">Ticket Sale Confirmation</h4>
                        <p>Ticket Sale is successfull, below are the details of the sale transaction.</p>
                        <ul>                        
                            <li><b>Reference Number: </b><span>{{session('message')->reference_number}}</span></li>
                            <li><b>Date: </b><span>{{custom_date_format(session('message')->date, "F d Y")}}</span></li>
                            <li><b>Time Slot: </b><span>{{session('message')->time_slot}}</span></li>
                            <li><b>Room Name: </b><span>{{session('message')->room_name}}</span></li>                            
                        </ul>
                        <hr>
                        <div class="text-center">
                            {!! QrCode::size(300)->generate(URL::to('/') . '/e-ticket/' . session('message')->reference_number); !!}    
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>                    
                    </div>            
                </div>
            </div>
        </div>
    @endif
        
    @include('../inc.footer')
@endsection


@section('css')        
@endsection

@section('javaScripts')
    {{-- Validator --}}
    <script src="{{asset('vendors/validator/multifield.js')}}"></script>
    <script src="{{asset('vendors/validator/validator.js')}}"></script>    
    <script src="{{asset('build/js/countries.js')}}"></script>

    <!-- Javascript functions	-->
    <script>        
        // initialize a validator instance from the "FormValidator" constructor.
        // A "<form>" element is optionally passed as an argument, but is not a must
        var validator = new FormValidator({
            "events": ['blur', 'input', 'change']
        }, document.forms[0]);
        

        // on form "submit" event
        $('#form-sell-ticket').submit(function (evt) {            
            var submit = true,
                validatorResult = validator.checkAll(this);            
            return !!validatorResult.valid;
        });
        
        // stuff related ONLY for this demo page:
        $('.toggleValidationTooltips').change(function() {
            validator.settings.alerts = !this.checked;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);  
        
        $(window).on('load', function() {
            $('#modal-success').modal({backdrop: 'static', keyboard: false}, 'show');
        });
    </script>
@endsection