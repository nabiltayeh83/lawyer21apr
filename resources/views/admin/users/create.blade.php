@extends('layout.adminLayout')

@section('title')
    {{__('cp.add')}}  {{__('cp.lawyer_offices')}}
@endsection

@section('css')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdjdB1HwQZU5ZBvmWLFli1h89JP2OPKzA&sensor=false&libraries=places"></script>
    <style type="text/css">
        .input-controls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        #searchInput {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 50%;
        }

        #searchInput:focus {
            border-color: #4d90fe;
        }

    </style>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject font-dark sbold uppercase" style="color: #e02222 !important;"> 
                            {{__('cp.add')}}  {{__('cp.user')}}
                        </span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form method="post" action="{{url(app()->getLocale().'/admin/users')}}" enctype="multipart/form-data" class="form-horizontal" role="form" id="form" >
                    {{ csrf_field() }}

                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">{{__('cp.name')}}
                                <span class="symbol">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="{{__('cp.name')}}"  value="{{old('name')}}" required>            
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">
                                {{__('cp.email')}}
                                <span class="symbol">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text"  class="form-control" name="email" value="{{ old('email') }}" placeholder="{{__('cp.email')}}"  required>
                            </div>
                        </div>
                    </fieldset>


                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">
                                {{__('cp.mobile')}}
                                <span class="symbol">*</span>
                            </label>
                            <div class="col-md-6">
                                <input onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" type="text" class="form-control" name="mobile" value="{{old('mobile')}}" placeholder="{{__('cp.mobile')}}" {{ old('mobile') }} required>
                            </div>
                        </div>
                    </fieldset>
                    
                    
                                                <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="code">
                                        {{__('cp.country')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">  
                                        <select name="country_id" id="country_id" class="form-control country">
                                        <option value=""></option>
                                        @if(isset($countries))
                                            @foreach($countries as $one)
                                                <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach   
                                            @endif
                                        </select>           
                                    </div>
                                </div>
                            </fieldset> 



                            
                        <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="code">
                                        {{__('cp.city')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">  
                                        <select name="city_id" id="city_id" class="form-control city">
                                        </select>           
                                    </div>
                                </div>
                            </fieldset> 


             <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">{{__('cp.address')}}
                                <span class="symbol">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="address" placeholder="{{__('cp.address')}}"  value="{{old('address')}}" required>            
                            </div>
                        </div>
                    </fieldset>



                 <fieldset>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="code">
                                        {{__('cp.zone')}}
                                        <span class="symbol">*</span>
                                    </label>
                                    <div class="col-md-6">  
                                        <select name="zone_id" id="zone_id" class="form-control">
                                        <option value=""></option>
                                        @if(isset($zones))
                                            @foreach($zones as $one)
                                                <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach   
                                            @endif
                                        </select>           
                                    </div>
                                </div>
                            </fieldset> 
                            
                            
                    
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">
                                {{__('cp.password')}}
                                <span class="symbol">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="{{__('cp.password')}}" required>
                            </div>
                        </div>
                    </fieldset>


                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">
                                {{__('cp.confirm_password')}}
                                <span class="symbol">*</span>
                            </label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="{{__('cp.confirm_password')}}" required>
                            </div>
                        </div>
                    </fieldset>


                    <fieldset>
                        <legend>{{__('cp.image')}}</legend>
                        <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                            <div class="col-md-6 col-md-offset-3">
                                @if ($errors->has('image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                                <div class="fileinput-new thumbnail" onclick="document.getElementById('edit_image').click()" style="cursor:pointer">
                                    <img src=" {{url(admin_assets('/images/ChoosePhoto.png'))}}"  id="editImage">
                                </div>
                                <div class="btn red" onclick="document.getElementById('edit_image').click()">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <input type="file" class="form-control" name="image" id="edit_image" required style="display:none">
                            </div>
                        </div>
                    </fieldset>


                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green">
                                    {{__('cp.submit')}}
                                </button>
                                <a href="{{url(getLocal().'/admin/users')}}" class="btn default">
                                    {{__('cp.cancel')}}
                                </a>
                            </div>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
    @section('js')
@endsection



@section('script')

<script>
$(document).ready(function(){

  	if($(".country").val() != ''){
			$('.country').change();
		}

});
</script>

    <script>
        $('#edit_image').on('change', function (e) {
            readURL(this, $('#editImage'));
        });

    </script>




@endsection
