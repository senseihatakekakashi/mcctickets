@extends('../layouts.app')
  
@section('content')    
    @include('../inc.side-bar')
    @include('../inc.header')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>User Role</h3>
                </div>                                                
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/user-role"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"></i> Edit User Role</li>
                    </ol>
                    <div class="x_panel">
                        <div class="x_title">  
                            <h2> User Role <small>Information</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content mb-5">
                            <form id="form-user-role" action="/user-role/{{Crypt::encryptString($user_role->id)}}" method="POST" novalidate>
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="_id" value="{{Crypt::encryptString($user_role->id)}}">
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
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="user_role">
                                        User Role<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="user_role" id="user_role" value="{{ $user_role->user_role }}" required="required" autofocus />
                                    </div>
                                </div>

                                <div class="ln_solid">
                                    <div class="form-group mt-3">
                                        <div class="col-md-6 offset-md-3">
                                            <a href="/user-role" class="btn btn-info"><i class="fa fa-arrow-left"></i> Cancel / Go Back</a>
                                            <button type='submit' class="btn btn-dark"><i class="fa fa-save"></i> Save User Information</button>
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
        $('#form-user-role').submit(function (evt) {            
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