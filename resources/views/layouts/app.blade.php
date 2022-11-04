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
    
    
    @yield('css')
    
    <link href="{{asset('vendors/nprogress/nprogress.css')}}" rel="stylesheet">                                           <!-- NProgress -->    
    <link href="{{asset('vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">                                       <!-- iCheck -->    
    <link href="{{asset('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">     <!-- bootstrap-progressbar -->    
    <link href="{{asset('vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>                                       <!-- JQVMap -->    
    <link href="{{asset('vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">                     <!-- bootstrap-daterangepicker -->    
    <link href="{{asset('build/css/custom.css')}}" rel="stylesheet">                                                      <!-- Custom Theme Style -->
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">                                          
            @yield('content')            
        </div>
    </div>

    <!-- Scripts -->        
    <!-- jQuery -->    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap -->    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js" integrity="sha512-mULnawDVcCnsk9a4aG1QLZZ6rcce/jSzEGqUkeOLy0b6q0+T6syHrxlsAGH7ZVoqC93Pd0lBqd6WguPWih7VHA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
    
    <script src="{{asset('build/js/moment.js')}}"></script>
    <script src="{{asset('build/js/custom.js')}}"></script>                                           <!-- Custom Theme Scripts -->
    @yield('javaScripts')
    <script>
        $(document).ready(function() {
            $('.left_col').css("height", $(document).height());
            
            notifiationListener();
            
            window.setInterval(notifiationListener, 5000);
            function notifiationListener() {
                $.ajax({                    
                    url: '/get-request-notification',
                    type: 'GET',
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function(response){                           
                        if(response.length > 0) {
                            $('#notificationCount').html('<span class="badge bg-danger text-white">' + response.length + '</span>');
                            
                            var notificationString = "";

                            $.each(response, function(key, value) {
                                notificationString += `
                                    <li class="nav-item border-bottom">
                                        <a class="" href="${value.data.link}">
                                            <span>
                                                <span class="font-weight-bold text-dark">${value.data.name}</span>
                                                <span class="small text-muted float-right">${moment(value.created_at).format('MMMM DD, YYYY hh:mm:ss A')}</span>
                                            </span>
                                            <span class="message">${value.data.message}</span>                                            
                                        </a>
                                        <a class="float-right small" href="mark-as-read/${value.id}">Mark as Read</small>
                                    </li>
                                `;
                            });

                            notificationString += `
                                <li class="nav-item">
                                    <div class="text-center">
                                        <a class="" href="mark-all-as-read">
                                            <strong>Mark all as Read</strong>
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    </div>
                                </li>
                            `;            
                            
                            $('#notification').html(notificationString)
                        }
                        else {
                            $('#notificationCount').empty();                            
                            var notificationString = `
                                <li class="nav-item">
                                    <div class="text-center">
                                        <a class="">
                                            <strong><i class="fa-solid fa-circle-info"></i> No Notification Found!</strong>                                            
                                        </a>
                                    </div>
                                </li>
                            `;

                            $('#notification').html(notificationString)
                        }                                                            
                    }
                });
            }

        });

        document.addEventListener('scroll', function (event) {
            $('.left_col').css("height", $(document).height());
        }, true /*Capture event*/);                  
    </script>
</body>
</html>
