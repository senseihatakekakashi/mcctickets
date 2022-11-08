{{-- Side Bar --}}
<div class="col-md-3 left_col">
    <div class="scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="#" class="site_title">
                <i><img src="{{asset('img/logo-white.png')}}" style="height: 40px;"></i> 
                <span>MCC Ticket System</span>
            </a>            
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">                
                <img src="{{asset('storage/users-photo/' . Auth::user()->photo)}}" onerror="this.onerror=null; this.src='{{asset('storage/users-photo/default.jpg')}}'" class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{Auth::user()->name}}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li>
                        <a href="/"><i class="fa fa-tachometer-alt fa-fw mr-2"></i>Dashboard</a>
                    </li>
                    
                    @if (check_user_access(['Super Admin', 'Admin']))
                        <li>
                            <a><i class="fa-solid fa-file fa-fw mr-2"></i>File Maintenance <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">                                
                                <li><a href="/time-slot">Time</a></li>
                                <li><a href="/room">Room</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (check_user_access(['Super Admin', 'Admin']))
                        <li>
                            <a><i class="fa-solid fa-chalkboard-user fa-fw mr-2"></i>Transaction <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/slots">Slots</a></li>
                                <li><a href="/ticket-allotment">Ticket Allotment</a></li>                                
                            </ul>
                        </li>
                    @endif

                    @if (check_user_access(['Super Admin', 'Agent']))
                        <li>
                            <a href="/ticket-sales"><i class="fa-solid fa-ticket fa-fw mr-2"></i>Ticket Sales</a>
                        </li>
                    @endif

                    @if (check_user_access(['Super Admin']))
                        <li>
                            <a><i class="fa-solid fa-cogs fa-fw mr-2"></i>System Setup <span class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <li><a href="/user-role">User Role</a></li>
                                <li><a href="/system-user">System User</a></li>
                                <li><a href="/audit-trail">Audit Trail</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->                 
    </div>
</div>
