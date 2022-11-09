@extends('../layouts.app')
  
@section('content')    
    @include('../inc.side-bar')
    @include('../inc.header')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Slot</h3>
                </div>                                                
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/slot"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"></i> Edit Slot</li>
                    </ol>
                    <div class="x_panel">
                        <div class="x_title">  
                            <h2><i class="fa-solid fa-file-pen"></i> Edit Slot Details</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content mb-5">
                            <form id="form-slot" action="/slot/{{Crypt::encryptString($slot->id)}}/update" method="POST" novalidate>
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="_id" value="{{Crypt::encryptString($slot->id)}}">
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
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="date">
                                        Date<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="date" class="form-control" name="date" id="date" value="{{ $slot->date }}" required="required" autofocus />
                                    </div>
                                </div>

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="time_slot">
                                        Time Slot<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control" name="time_slot" id="time_slot" required>                                                                                        
                                            @if (isset($time_slots))
                                                <option value="" disabled selected>Select a Time Slot</option>
                                                @foreach ($time_slots as $time_slot)
                                                    @php $value = custom_date_format($time_slot->time_from, "h:i:s a") . ' - ' . custom_date_format($time_slot->time_to, "h:i:s a"); @endphp
                                                    <option value="{{$value}}" {{ ($slot->time_slot == $value ? 'selected' : '' ) }}>{{$value}}</option>        
                                                @endforeach
                                            @else
                                                <option value="" disabled selected>No Time Slot Found</option>
                                            @endif                                            
                                        </select>
                                    </div>
                                </div>  
                                
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="room_name">
                                        Room Name<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <select class="form-control" name="room_name" id="room_name" required>                                                                                        
                                            @if (isset($rooms))
                                                <option value="" disabled selected>Select a Room</option>
                                                @foreach ($rooms as $room)
                                                    {{-- @php
                                                        $value = $room->room_name;
                                                        $caption = $room->room_name . ' - (' . $room->capacity . ($room->capacity == 0 ? ' seater' : ' seaters') . ')'; 
                                                    @endphp --}}
                                                    <option value="{{$room->room_name}}" {{ ($slot->room_name == $room->room_name ? 'selected' : '' ) }}>{{$room->room_name}}</option>        
                                                @endforeach
                                            @else
                                                <option value="" disabled selected>No Room Found</option>
                                            @endif                                            
                                        </select>
                                    </div>
                                </div> 

                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="room_name">
                                        Room Capacity<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="hidden" name="capacity" id="capacity" value="{{$slot->capacity}}">
                                        <input type="text" class="form-control capacity" name="fee" id="fee" value="{{$slot->capacity}}" disabled/>                                        
                                    </div>
                                </div> 
                                
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align" for="fee">
                                        Fee<span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" class="form-control" name="fee" id="fee" value="{{ $slot->fee }}" required="required" onkeypress="return isNumberKey(this, event)"/>
                                    </div>
                                </div>                                

                                <div class="ln_solid">
                                    <div class="form-group mt-3">
                                        <div class="col-md-6 offset-md-3">
                                            <a href="/slot" class="btn btn-info"><i class="fa fa-arrow-left"></i> Cancel / Go Back</a>
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
        var rooms = [];

        // initialize a validator instance from the "FormValidator" constructor.
        // A "<form>" element is optionally passed as an argument, but is not a must
        var validator = new FormValidator({
            "events": ['blur', 'input', 'change']
        }, document.forms[0]);        

        function isNumberKey(txt, evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 46) {
                //Check if the text already contains the . character
                if (txt.value.indexOf('.') === -1) {
                return true;
                } else {
                return false;
                }
            } else {
                if (charCode > 31 &&
                (charCode < 48 || charCode > 57))
                return false;
            }
            return true;
        }

        function getAllRoomsData() {
            $.ajax({
                url: '/get-all-rooms-data',
                type: 'GET',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(response){
                    $.each(response, function(k, v) {
                        // rooms.push(v.room_name);
                        rooms[v.room_name] = v.capacity;
                    });
                }
            });
        }

        $(document).ready(function() {
            getAllRoomsData();

            // on form "submit" event
            $('#form-slot').submit(function (evt) {            
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

            $("#room_name").change(function () {                
                $(".capacity").val(rooms[this.value]);
                $("#capacity").val(rooms[this.value]);
            });
        });              
    </script>
@endsection