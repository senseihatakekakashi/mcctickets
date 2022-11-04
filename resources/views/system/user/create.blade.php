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
                        <li class="breadcrumb-item active" aria-current="page"></i> Add a new user</li>
                    </ol>
                    <div class="x_panel">
                        <div class="x_title">  
                            <h2> User <small>Information</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content mb-5">
                            <form id="user-information-form" action="/system-user" method="POST" novalidate enctype="multipart/form-data">
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
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="name">
                                        Name<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required="required" aria-describedby="help_name" autofocus />
                                        <small id="help_name" class="form-text text-muted">First Name <span class="mx-5"></span> Last Name</small>
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="email">
                                        Email Address<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" required="required" />
                                    </div>
                                </div>
                                
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="user_role">
                                        User Role<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control" name="user_role" id="user_role" required>                                                                                        
                                            @if (isset($user_roles))
                                                <option value="" disabled selected>Select a User Role</option>
                                                @foreach ($user_roles as $user_role)
                                                    <option value="{{$user_role->user_role}}" {{ (old('user_role') == $user_role->user_role ? 'selected' : '' ) }}>{{$user_role->user_role}}</option>        
                                                @endforeach
                                            @else
                                                <option value="" disabled selected>No User Role Found</option>
                                            @endif                                            
                                        </select>
                                    </div>
                                </div>  
                                
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="photo">
                                        Photo<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" class="form-control" name="photo" id="photo" value="{{ old('photo') }}" />
                                    </div>
                                </div>
                                                                
                                <div class="ln_solid">
                                    <div class="form-group mt-3">
                                        <div class="col-md-6 offset-md-3">
                                            <a href="/system-user" class="btn btn-info"><i class="fa fa-arrow-left"></i> Cancel / Go Back</a>
                                            <button type='submit' class="btn btn-danger"><i class="fa fa-save"></i> Save User Information</button>
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
        // initialize a validator instance from the "FormValidator" constructor.
        // A "<form>" element is optionally passed as an argument, but is not a must
        var validator = new FormValidator({
            "events": ['blur', 'input', 'change']
        }, document.forms[0]);
        

        // on form "submit" event
        $('#user-information-form').submit(function (evt) {            
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