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
                
                
                @if (session('message'))                        
                    <div style="position: fixed; top: 70px; right: 20px; z-index: 99999;">                                        
                        <div class="toast fade show">
                            <div class="toast-header">
                                <strong class="mr-auto"><i class="fa fa-info-circle"></i> MCC Admin System</strong>                                    
                                <button type="button" class="ml-2 mb-1 close hide-toast" data-dismiss="toast">&times;</button>
                            </div>
                            <div class="toast-body">
                                {{session('message')}}
                            </div>
                        </div>                            
                    </div>
                @endif 
            </div>
            <div class="clearfix"></div>

            <div class="row">                                
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">                            
                            <h2>Assigned Ticket Slots List</h2>                            
                            <ul class="nav navbar-right panel_toolbox">                                
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>                                
                            </ul>
                            <div class="clearfix"></div>
                        </div>

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

                        <div class="x_content">
                            <div class="row">
                                <div class="col-sm-12">

                                    @if (session('message'))                        
                                        <div style="position: fixed; top: 70px; right: 20px; z-index: 99999;">                                        
                                            <div class="toast fade show">
                                                <div class="toast-header">
                                                    <strong class="mr-auto"><i class="fa fa-info-circle"></i> MCC Admin System</strong>                                    
                                                    <button type="button" class="ml-2 mb-1 close hide-toast" data-dismiss="toast">&times;</button>
                                                </div>
                                                <div class="toast-body">
                                                    {{session('message')}}
                                                </div>
                                            </div>                            
                                        </div>
                                    @endif 

                                    <div class="x_content">
                                        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="slot-tab" data-toggle="tab" href="#slot" role="tab" aria-controls="slot" aria-selected="true">Active Slots</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="expired-slot-tab" data-toggle="tab" href="#expired-slot" role="tab" aria-controls="expired-slot" aria-selected="false">Expired Slots</a>
                                            </li>                                            
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade active show" id="slot" role="tabpanel" aria-labelledby="slot-tab">
                                                <div class="card-box table-responsive mt-5">
                                                    <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>       
                                                                <th>Date</th>                                             
                                                                <th>Time</th>
                                                                <th>Room Name</th>
                                                                <th>Capacity</th>
                                                                <th>Fee</th>
                                                                <th>Sold Tickets</th>
                                                                <th>Options</th>                                                    
                                                            </tr>
                                                        </thead>
                                                        <tbody>                                                
                                                            @if ($slots)
                                                                @foreach ($slots as $slot)                                                        
                                                                    <tr>
                                                                        <td class="p-1 align-middle">{{custom_date_format($slot->date, "F d Y")}}</td>
                                                                        <td class="p-1 align-middle">{{$slot->time_slot}}</td>
                                                                        <td class="p-1 align-middle">{{$slot->room_name}}</td>
                                                                        <td class="p-1 align-middle">{{$slot->capacity}}</td>
                                                                        <td class="p-1 align-middle">{{$slot->fee}}</td>
                                                                        <td class="p-1 align-middle">{{$slot->ticketSales()->count()}}</td>                                                                        
                                                                        <td class="p-1 d-flex justify-content-center">    
                                                                            @if ($slot->ticketSales()->count() < $slot->capacity)
                                                                                <a href="/ticket-sales/{{Crypt::encryptString($slot->id)}}/create" class="btn btn-sm btn-primary btn-block"><i class="fa-solid fa-ticket mr-2"></i> Sell Ticket</a> 
                                                                            @else
                                                                                <a href="/ticket-sales/{{Crypt::encryptString($slot->id)}}/create" class="btn btn-sm btn-info btn-block"><i class="fa-solid fa-eye mr-2"></i></i> View Sold Tickets</a> 
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif                                                
                                                        </tbody>
                                                    </table>                                    
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="expired-slot" role="tabpanel" aria-labelledby="expired-slot-tab">
                                                <div class="card-box table-responsive mt-5">
                                                    <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                                        <thead>
                                                            <tr>       
                                                                <th>Date</th>                                             
                                                                <th>Time</th>
                                                                <th>Room Name</th>
                                                                <th>Capacity</th>
                                                                <th>Fee</th>    
                                                                <th>Sold Tickets</th>                                                            
                                                            </tr>
                                                        </thead>
                                                        <tbody>                                                
                                                            @if ($expired_slots)
                                                                @foreach ($expired_slots as $expired_slot)                                                        
                                                                    <tr>
                                                                        <td class="p-1 align-middle">{{custom_date_format($expired_slot->date, "F d Y")}}</td>
                                                                        <td class="p-1 align-middle">{{$expired_slot->time_slot}}</td>
                                                                        <td class="p-1 align-middle">{{$expired_slot->room_name}}</td>
                                                                        <td class="p-1 align-middle">{{$expired_slot->capacity}}</td>
                                                                        <td class="p-1 align-middle">{{$expired_slot->fee}}</td>                                                                        
                                                                        <td class="p-1 align-middle">{{$expired_slot->ticketSales()->count()}}</td>                                                                        
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
                    </div>
                </div>               
            </div>            
        </div>
    </div>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">            
                <div class="modal-header">
                    <img src="{{asset('img/logo.png')}}" style="height: 40px;">
                    <h4 class="modal-title pl-2" id="myModalLabel">MCC Admin System</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="text-danger">Delete Record Confirmation</h4>
                    <p>Are you sure you want to permanently delete this record?</p>
                    <ul>                        
                        <li><b>Date: </b><span class="modal_date"></span></li>
                        <li><b>Time Slot: </b><span class="modal_time_slot"></span></li>
                        <li><b>Room Name: </b><span class="modal_room_name"></span></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <form action="" method="POST" id="form-confirm-delete">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="url" value="{{URL::to('/')}}">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i> Confirm Delete</button>                                                                    
                    </form>
                </div>            
            </div>
        </div>
    </div>
    
    @include('../inc.footer')
@endsection


@section('css')
    <!-- Datatables -->    
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('build/css/bootstrap4-toggle.css')}}" rel="stylesheet">
@endsection

@section('javaScripts')
    <!-- Datatables -->
    <script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{asset('vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{asset('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/pdfmake/build/vfs_fonts.js')}}"></script>
    <script src="{{asset('build/js/bootstrap4-toggle.js')}}"></script>

    <script>
        var url = $("#url").val();
        
        $(".hide-toast").click(function(){                
            $(".toast").toast('hide');
        }); 

        $('.toast').delay(5000).fadeOut('slow');     
        
        function updateDeleteModalData(args) {
            var data = $.parseJSON($(args).attr('data-button'));                                   
            $(".modal_date").text(data.date);
            $(".modal_time_slot").text(data.time_slot);
            $(".modal_room_name").text(data.room_name);
            $('#form-confirm-delete').attr('action', url + "/ticket-allotment/" + data.id + "/destroy");            
        }
    </script>
@endsection