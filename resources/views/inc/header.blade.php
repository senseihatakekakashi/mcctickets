{{-- Header --}}
<div class="top_nav">
    <div class="nav_menu">
        <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>
        
        <nav class="nav navbar-nav">
            <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                    <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset('storage/users-photo/' . Auth::user()->photo)}}" onerror="this.onerror=null; this.src='{{asset('storage/users-photo/default.jpg')}}'">                        
                    </a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">                        
                        <a class="dropdown-item" href="/change-password"><i class="fa-solid fa-user-pen"></i> Change Password</a>
                        <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> {{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                
                <li role="presentation" class="nav-item dropdown open pt-1">                    
                    <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bell"></i>
                        <span id="notificationCount">                            
                        </span>                        
                    </a>
                    <ul id="notification" class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-142px, 17px, 0px)" >                        
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>  
