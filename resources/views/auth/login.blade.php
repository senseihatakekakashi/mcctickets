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

        .brand-wrapper {
            margin-bottom: 19px;
        }
        
        .brand-wrapper .logo{
            height: 100px;
        }

        .login-card {
            border: 0;
            border-radius: 27.5px;
            box-shadow: 0 10px 30px 0 rgba(172, 168, 168, 0.43);
            overflow: hidden;
        }
        
        .login-card-img {
            border-radius: 0;
            position: absolute;            
            width: 100%;
            height: 100%;            
            -o-object-fit: cover;
            object-fit: cover;
            object-position: 0%;
        }
        
        .login-card .card-body {
            padding: 85px 60px 60px;
        }
        
        @media (max-width: 422px) {
            .login-card .card-body {
                padding: 35px 24px;
            }
        }
        
        .login-card-description {
            font-size: 25px;
            color: #000;
            font-weight: normal;            
        }
        
        .login-card form {
            max-width: 326px;
        }
        
        .login-card .form-control {
            border: 1px solid #d5dae2;
            padding: 15px 25px;
            margin-bottom: 20px;
            min-height: 45px;
            font-size: 13px;
            line-height: 15;
            font-weight: normal;
        }

        .login-card .form-control::-webkit-input-placeholder {
            color: #919aa3;
        }
        
        .login-card .form-control::-moz-placeholder {
            color: #919aa3;
        }
        
        .login-card .form-control:-ms-input-placeholder {
            color: #919aa3;
        }
        
        .login-card .form-control::-ms-input-placeholder {
            color: #919aa3;
        }
        
        .login-card .form-control::placeholder {
            color: #919aa3;
        }
        
        .login-card .login-btn {
            padding: 13px 20px 12px;
            background-color: #000;
            border-radius: 4px;
            font-size: 17px;
            font-weight: bold;
            line-height: 20px;
            color: #fff;
            margin-bottom: 24px;
        }
        
        .login-card .login-btn:hover {
            border: 1px solid #000;
            background-color: transparent;
            color: #000;
        }
        
        .login-card .forgot-password-link {
            font-size: 14px;
            color: #919aa3;
            margin-bottom: 12px;
        }
        
        .login-card-footer-text {
            font-size: 16px;
            color: #0d2366;
            margin-bottom: 60px;
        }
        
        @media (max-width: 767px) {
            .login-card-footer-text {
                margin-bottom: 24px;
            }
        }    
    </style>
</head>
<body>
    <main class="d-flex align-items-center min-vh-100 py-3 py-md-0">        
        <div class="container">
            <div class="card login-card">
                <div class="row no-gutters">
                    <div class="col-md-6">
                        <img src="{{asset('img/login-bg.jpg')}}" class="login-card-img">                
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <div class="brand-wrapper">
                                <img src="{{asset('img/logo.png')}}" alt="logo" class="logo">                            
                            </div>
                            
                            <p class="login-card-description m-0"><i class="fa-solid fa-ticket"></i> Ticketing System</p>
                            <p class="text-muted mb-5">Sign into your account</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <input type="hidden" id="limit" name="{{\App\Http\Middleware\SetSessionLength::SESSION_LIFETIME_PARAM}}" value="">
                                <div class="form-group">   
                                    <input type="email" id="email" name="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" id="password" name="password" placeholder="***********" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">                                    
                                </div>
                                <button type="submit" class="btn btn-block login-btn mb-4">
                                    <i class="fas fa-sign-in-alt"></i> 
                                    {{ __('Login') }}
                                </button>                                
                            </form>

                            

                            {{-- <a href="#!" class="forgot-password-link">Forgot password?</a>
                            <p class="login-card-footer-text">Don't have an account? <a href="#!" class="text-reset">Register here</a></p>                     --}}
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