@extends('../layouts.app')
  
@section('content')    
    @include('../inc.side-bar')
    @include('../inc.header')

    <div class="right_col" role="main">
        <div class="">
            <form id="form-ticket-assignment" action="/ticket-allotment/{{Crypt::encryptString($user->id)}}/setup" method="POST" novalidate>
                @csrf                                
                <div class="page-title">
                    <div class="title_left">
                        <h3>Agent</h3>                    
                    </div>
                    <div class="text-right my-5">
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-circle-check"></i> Assign Ticket Slot to Agent
                        </button>
                        {{-- <a href="system-user/create" class="btn btn-danger"><i class="fa-solid fa-circle-check"></i> Assign Ticket Slot to Agent</a> --}}
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
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/ticket-allotment"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"></i> Assign Ticket to Agent</li>
                        </ol>
                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="card-box table-responsive">                            
                            <div class="card bg-light mb-3">                                            
                                <div class="card-body">                                                                                                                                                                      
                                    <div class="row">                                    
                                        <span class="col-12 col-lg-6"><b>Agent Name:</b> {{$user->name}}</span>
                                        <span class="col-12 col-lg-6"><b>Email Address:</b> {{$user->email}}</span>
                                    </div>
                                </div>                                                    
                            </div>                                    
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_title">                            
                                <h2>Ticket Slot List</h2>                            
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

                                        <div class="card-box table-responsive">
                                            <table id="datatable-fixed-header" class="table table-striped table-bordered" style="width:100%">
                                                <thead>
                                                    <tr>       
                                                        <th>Date</th>                                             
                                                        <th>Time</th>
                                                        <th>Room Name</th>
                                                        <th>Capacity</th>
                                                        <th>Fee</th>
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
                                                                <td class="p-1 d-flex justify-content-center">    
                                                                    <input type="checkbox" name="assign_ticket[]" value="{{$slot->id}}" class="assign_ticket" data-toggle="toggle" data-off="<i class='fa-regular fa-circle-check'></i> Assign" data-on="<i class='fa fa-circle-check'></i> Assigned" data-offstyle="secondary" data-onstyle="danger" >
                                                                </td>
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
            </form>
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
        $(".hide-toast").click(function(){                
            $(".toast").toast('hide');
        }); 

        $('.toast').delay(5000).fadeOut('slow');

        $('.assign_ticket').bootstrapToggle({
            width: 150,
            height: 31
        });        
    </script>
@endsection