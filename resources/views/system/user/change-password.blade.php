@extends('../layouts.app')
  
@section('content')    
    @include('../inc.side-bar')
    @include('../inc.header')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>System Users</h3>
                </div>                                                
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/system-user"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"></i> Change Password</li>
                    </ol>
                    <div class="x_panel">
                        <div class="x_title">  
                            <h2> User <small>Password Configuration</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content mb-5">
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

                            <form id="change-password-form" action="/change-password" method="POST" novalidate>
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
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="current_password">
                                        Current Password<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="password" class="form-control" name="current_password" id="current_password" value="{{ old('current_password') }}" required="required" autofocus />                                        
                                    </div>
                                </div>                                

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="new_password">
                                        New Password<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="password" class="form-control" name="new_password" id="new_password" value="{{ old('new_password') }}" required="required" />
                                    </div>
                                </div>                                                                                               

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="confirm_new_password">
                                        Confirm New Password<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" value="{{ old('confirm_new_password') }}" required="required" data-validate-linked='new_password'/>
                                    </div>
                                </div>                                

                                <div class="ln_solid">
                                    <div class="form-group mt-3">
                                        <div class="col-md-6 offset-md-3">
                                            <a href="/" class="btn btn-info"><i class="fa fa-arrow-left"></i> Cancel / Go Back</a>
                                            <button type='submit' class="btn btn-danger"><i class="fa-solid fa-user-pen"></i> Change Password</button>
                                        </div>
                                    </div>
                                </div>
                            </form>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
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
        $(".hide-toast").click(function(){                
            $(".toast").toast('hide');
        }); 

        $('.toast').delay(5000).fadeOut('slow');

        // initialize a validator instance from the "FormValidator" constructor.
        // A "<form>" element is optionally passed as an argument, but is not a must
        var validator = new FormValidator({
            "events": ['blur', 'input', 'change']
        }, document.forms[0]);
        

        // on form "submit" event
        $('#change-password-form').submit(function (evt) {            
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
    </script>
@endsection