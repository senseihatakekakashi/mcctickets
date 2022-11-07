@extends('../layouts.app')
  
@section('content')    
    @include('../inc.side-bar')
    @include('../inc.header')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Agent</h3>                   
                </div>
                <div class="text-right my-5">
                    <a href="agent/create" class="btn btn-danger"><i class="fa fa-plus"></i> Add a new Agent</a>
                </div>                    
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">                            
                            <h2>Agent List</h2>                            
                            <ul class="nav navbar-right panel_toolbox">                                
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>                                
                            </ul>
                            <div class="clearfix"></div>
                        </div>
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
                                                    <th>Full Name</th>
                                                    <th>Email Address</th>
                                                    <th>Sex</th>
                                                    <th>Agent Type</th>
                                                    <th>Options</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>                                                
                                                @if ($agents)
                                                    @foreach ($agents as $agent)                                                        
                                                        <tr>
                                                            <td class="p-1 align-middle">{{$agent->full_name}}</td>
                                                            <td class="p-1 align-middle">{{$agent->email_address}}</td>
                                                            <td class="p-1 align-middle">{{$agent->sex}}</td>
                                                            <td class="p-1 align-middle">{{$agent->agent_type}}</td>
                                                            <td class="p-1 align-middle text-center">    
                                                                <a href="agent/{{Crypt::encryptString($agent->id)}}/edit" class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> Edit</a> 
                                                                <button type="button" class="btn btn-sm btn-warning modal-delete-record-trigger" data-toggle="modal" data-target="#modal-delete" data-button='{"id": "{{Crypt::encryptString($agent->id)}}", "full_name" : "{{$agent->full_name}}"}' onclick="updateDeleteModalData(this)"><i class="fa fa-trash"></i> Delete</button>
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
                        <li><b>Full Name: </b><span class="modal-full-name"></span></li>                        
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <form action="" method="POST" id="form-confirm-delete">
                        @csrf
                        @method('DELETE')
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

    <script>
        $(".hide-toast").click(function(){                
            $(".toast").toast('hide');
        }); 

        $('.toast').delay(5000).fadeOut('slow');

        // Custom Made JS for additional functionalities
        function updateDeleteModalData(args) {
            var data = $.parseJSON($(args).attr('data-button'));                                   
            $(".modal-full-name").text(data.full_name);
            $('#form-confirm-delete').attr('action', "agent/" + data.id);            
        }
    </script>
@endsection