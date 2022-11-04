@extends('../layouts.app')
  
@section('content')    
    @include('../inc.side-bar')
    @include('../inc.header')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Audit Trail</h3>              
                </div>                
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">                            
                            <h2>User List</h2>                            
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
                                                    <th class="col-1">User</th>
                                                    <th class="col-1">Event</th>
                                                    <th class="col-2">Module</th>
                                                    <th class="col-2">Old Values</th>
                                                    <th class="col-2">New Values</th>                                                                                                        
                                                    <th class="col-1">IP Address</th>
                                                    <th class="col-2">User Agent</th>
                                                    <th class="col-1">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>                                                                                               
                                                @if ($audits->isNotEmpty())
                                                    @foreach ($audits as $audit)                                                        
                                                        <tr>
                                                            <td>{{$audit->user->where('id', $audit->user_id)->first()->name}}</td>
                                                            <td>{{ucfirst($audit->event)}}</td>                                                            
                                                            <td>{{basename($audit->auditable_type)}}</td>
                                                            <td>
                                                                <ul class="pl-3">
                                                                @foreach (json_decode($audit->old_values) as $key => $old_value)
                                                                    <li>
                                                                        <b>{{ucfirst($key)}}: </b>
                                                                        {{$old_value}}
                                                                    </li>    
                                                                @endforeach                                                                
                                                                </ul>
                                                            </td>
                                                            <td>
                                                                <ul class="pl-3">
                                                                    @foreach (json_decode($audit->new_values) as $key => $new_value)
                                                                        <li>
                                                                            <b>{{ucfirst($key)}}: </b>
                                                                            {{$new_value}}
                                                                        </li>    
                                                                    @endforeach                                                                
                                                                </ul>                                                                
                                                            </td>
                                                            <td>{{$audit->ip_address}}</td>
                                                            <td>{{$audit->user_agent}}</td>
                                                            <td>{{custom_date_format($audit->created_at, "M d, Y h:i:s A")}}</td>                                                            
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

    <style>
        .modal-edit-delete-record-trigger {
            cursor: pointer;
            -webkit-touch-callout: none; /* iOS Safari */
            -webkit-user-select: none; /* Safari */
            -khtml-user-select: none; /* Konqueror HTML */
            -moz-user-select: none; /* Old versions of Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently supported by Chrome, Edge, Opera and Firefox */
        }
        .modal-edit-delete-record-trigger:hover { color: #fff; background-color: #4B5F71; }
    </style>
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

    <script src="{{asset('vendors/validator/multifield.js')}}"></script>
    <script src="{{asset('vendors/validator/validator.js')}}"></script>    

    <script src="{{asset('build/js/moment.js')}}"></script>
    <script src="{{asset('build/js/bootstrap4-toggle.js')}}"></script>

    <script>
        // initialize a validator instance from the "FormValidator" constructor.
        // A "<form>" element is optionally passed as an argument, but is not a must
            var validator = new FormValidator({
            "events": ['blur', 'input', 'change']
        }, document.forms[0]);
        

        // on form "submit" event
        $('#employee-dtr-add-time').submit(function (evt) {            
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

        // Custom Made JS for additional functionalities
        $( document ).ready(function() {
            $('.modal-edit-delete-record-trigger').dblclick(function(){
                $('#modal-edit-delete').modal('show');
                var data = $.parseJSON($(this).attr('data-button'));
                $('.employee_id').val(data.employee_id);
                $('#edit-date').val(data.date);
                $('#edit-time').val(data.time);
                
                // var momentNow = moment();                                
                $('#delete-date').text(moment(data.date).format('MMMM DD, YYYY'));
                $('#delete-time').text(moment(data.time, "HH:mm:ss").format('hh:mm:ss A'));

                if(data.type == "IN") {
                    $('#edit-type').bootstrapToggle('on');                    
                    $('#delete-type').text("IN");
                }
                else {
                    $('#edit-type').bootstrapToggle('off');                    
                    $('#delete-type').text("OUT");
                }
                $('#employee-dtr-edit-time').attr('action', data.id);
                $('#employee-dtr-delete-time').attr('action', data.id);                
            });
        });  
  
    </script>
@endsection