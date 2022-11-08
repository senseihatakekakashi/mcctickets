@extends('../layouts.app')
  
@section('content')    
    @include('../inc.side-bar')
    @include('../inc.header')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Time Slot</h3>
                </div>                                                
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/time-slot"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"></i> Edit Time Slot</li>
                    </ol>
                    <div class="x_panel">
                        <div class="x_title">  
                            <h2><i class="fa-solid fa-file-pen"></i> Time Slot Details</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content mb-5">
                            <form id="form-time-slot" action="/time-slot/{{Crypt::encryptString($time_slot->id)}}/update" method="POST" novalidate>
                                @csrf
                                {{-- @method('PUT') --}}
                                <input type="hidden" name="_id" value="{{Crypt::encryptString($time_slot->id)}}">
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
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="time_from">
                                        Time From<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="time" class="form-control" name="time_from" id="time_from" value="{{ custom_date_format($time_slot->time_from, "H:i") }}" required="required" autofocus />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="time_to">
                                        Time To<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="time" class="form-control" name="time_to" id="time_to" value="{{ custom_date_format($time_slot->time_to, "H:i") }}" required="required" />
                                    </div>
                                </div>

                                <div class="ln_solid">
                                    <div class="form-group mt-3">
                                        <div class="col-md-6 offset-md-3">
                                            <a href="/time-slot" class="btn btn-info"><i class="fa fa-arrow-left"></i> Cancel / Go Back</a>
                                            <button type='submit' class="btn btn-danger"><i class="fa fa-save"></i> Save Record</button>
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
        $('#form-time-slot').submit(function (evt) {            
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