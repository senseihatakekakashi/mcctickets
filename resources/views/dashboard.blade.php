@extends('layouts.app')
  
@section('content')    
    @include('inc.side-bar')
    @include('inc.header')

        <div class="right_col" role="main">            
            <div class="page-title">
                <div class="title_left">
                <h3>Dashboard</h3>
                </div>

                {{-- <div class="title_right">
                <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                    <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </div>
                </div> --}}
            </div>

            <div class="clearfix"></div>

            @if (check_user_access(['Super Admin', 'Admin']))
                <div class="row">
                    <div class="col-md-12 col-sm-12 bootstrap snippets bootdey">                    
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="panel panel-dark panel-colorful">
                                    <div class="panel-body text-center">
                                        <p class="text-uppercase mar-btm text-sm">Active Agents</p>
                                        <i class="fa-solid fa-user-tie fa-5x"></i>                                        
                                        <hr>
                                        <p class="h2 text-thin">{{$data['active_agents']}}</p>
                                        <small><span class="text-semibold">Total number of Active Agents</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="panel panel-danger panel-colorful">
                                    <div class="panel-body text-center">
                                        <p class="text-uppercase mar-btm text-sm">Active Ticket Slots</p>
                                        <i class="fa-solid fa-calendar-check fa-5x"></i>
                                        <hr>
                                        <p class="h2 text-thin">{{$data['slots']}}</p>
                                        <small>Active Ticket Slots that you can assign</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="panel panel-warning panel-colorful">
                                    <div class="panel-body text-center">
                                        <p class="text-uppercase mar-btm text-sm">Active E-Tickets</p>
                                        <i class="fa-solid fa-ticket fa-5x"></i>                                    
                                        <hr>
                                        <p class="h2 text-thin">{{$data['total_active_ticket_slots']}}</p>
                                        <small>Active E-Tickets that can be assigned</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="panel panel-info panel-colorful">
                                    <div class="panel-body text-center">
                                        <p class="text-uppercase mar-btm text-sm">Total Earnings</p>
                                        <i class="fa-solid fa-peso-sign fa-5x"></i>                                    
                                        <hr>
                                        <p class="h2 text-thin">{{number_format($data['total_earnings'], 2)}}</p>
                                        <small>Total Amount of Ticket Sales</small>
                                    </div>
                                </div>
                            </div>        
                        </div>                    
                    </div>
                </div>
            @elseif (check_user_access(['Agent']))
                <div class="row">
                    <div class="col-md-12 col-sm-12 bootstrap snippets bootdey">                    
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="panel panel-dark panel-colorful">
                                    <div class="panel-body text-center">
                                        <p class="text-uppercase mar-btm text-sm">Todays Sales</p>
                                        <i class="fa-solid fa-cubes-stacked fa-5x"></i>
                                        <hr>
                                        <p class="h2 text-thin">{{$data['ticket_sales']}}</p>
                                        <small><span class="text-semibold">Today's Date:</span> {{date("F d, Y")}}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="panel panel-danger panel-colorful">
                                    <div class="panel-body text-center">
                                        <p class="text-uppercase mar-btm text-sm">Active Ticket Slots</p>
                                        <i class="fa-solid fa-calendar-check fa-5x"></i>
                                        <hr>
                                        <p class="h2 text-thin">{{$data['slots']}}</p>
                                        <small>Active Ticket Slots that you can sell</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="panel panel-warning panel-colorful">
                                    <div class="panel-body text-center">
                                        <p class="text-uppercase mar-btm text-sm">Assigned Active E-Tickets</p>
                                        <i class="fa-solid fa-ticket fa-5x"></i>                                    
                                        <hr>
                                        <p class="h2 text-thin">{{$data['total_assigned_active_ticket_slots']}}</p>
                                        <small>Total number of assigned active E-Tickets to you</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <div class="panel panel-info panel-colorful">
                                    <div class="panel-body text-center">
                                        <p class="text-uppercase mar-btm text-sm">Total Earnings</p>
                                        <i class="fa-solid fa-peso-sign fa-5x"></i>                                    
                                        <hr>
                                        <p class="h2 text-thin">{{number_format($data['total_earnings'], 2)}}</p>
                                        <small>Total Ticket Sales you have sold</small>
                                    </div>
                                </div>
                            </div>        
                        </div>                    
                    </div>
                </div>
            @endif
            @if (check_user_access(['Super Admin', 'Admin']))
                <div class="row">
                    <div class="col-md-12 col-sm-12  ">
                    <div class="x_panel">
                        <div class="x_title">
                        <h2>Agents List</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Settings 1</a>
                                <a class="dropdown-item" href="#">Settings 2</a>
                                </div>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="card-box table-responsive">
                                <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>                                                    
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Total Slots</th>                                            
                                            <th>Total Sold Tickets</th>
                                            <th>Total Earnings</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>                                                
                                        @if ($agents)
                                            @foreach ($agents as $agent)                                                        
                                                <tr>
                                                    <td class="p-1 align-middle">{{$agent->name}}</td>
                                                    <td class="p-1 align-middle">{{$agent->email}}</td>                                                    
                                                    <td class="p-1 align-middle">{{$agent->ticketAllotment->count()}}</td>                                                    
                                                    <td class="p-1 align-middle">{{$agent->ticketSales->count()}}</td>
                                                    <td class="p-1 align-middle">₱ {{number_format($agent->ticketSales->sum('fee'), 2)}}</td>
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
            @endif            
        </div>
        
    @include('inc.footer')
@endsection

@section('css')
    <link href="{{asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <style>
        .panel {
            box-shadow: 0 2px 0 rgba(0,0,0,0.05);
            border-radius: 0;
            border: 0;
            margin-bottom: 24px;
        }

        .panel-dark.panel-colorful {
            background-color: #1C1D21;
            border-color: #1C1D21;
            color: #fff;
        }

        .panel-danger.panel-colorful {
            background-color: #BF1E2E;
            border-color: #BF1E2E;
            color: #fff;
        }

        .panel-warning.panel-colorful {
            background-color: #ffb80d;
            border-color: #ffb80d;
            color: #fff;
        }

        .panel-info.panel-colorful {
            background-color: #008080;
            border-color: #008080;
            color: #fff;
        }

        .panel-body {
            padding: 25px 20px;
        }

        .panel hr {
            border-color: rgba(0,0,0,0.1);
        }

        .mar-btm {
            margin-bottom: 15px;
        }

        h2, .h2 {
        font-size: 28px;
        }

        .small, small {
            font-size: 85%;
        }

        .text-sm {
            font-size: .9em;
        }

        .text-thin {
            font-weight: 300;
        }

        .text-semibold {
            font-weight: 600;
        }

        #datatable-buttons_length, #datatable-buttons_filter { float: right; margin-left: 20px;}
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
@endsection