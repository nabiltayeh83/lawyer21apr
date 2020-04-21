@extends('layout.adminLayout')
@section('title') {{ucwords(__('cp.view'))}} {{__('cp.lawyer_offices')}}
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
                        <span class="caption-subject font-dark sbold uppercase"
                              style="color: #e02222 !important;">{{ucwords(__('cp.view'))}} {{__('cp.lawyer_offices')}}</span>
                    </div>
                </div>
                <div class="portlet-body form">
                 

                        <fieldset style="padding:10px; background-color:#f2f2f2;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="order">{{__('cp.name')}}</label>
                                <div class="col-md-6 bold">{{@$item->name}}</div>
                            </div>
                        </fieldset>
                        
                        
                        <fieldset style="padding:10px;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="order">{{__('cp.email')}}</label>
                                <div class="col-md-6 bold">{{@$item->email}}</div>
                            </div>
                        </fieldset>


                        <fieldset style="padding:10px; background-color:#f2f2f2;">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="order">{{__('cp.mobile')}}</label>
                                <div class="col-md-6 bold">{{@$item->mobile}}</div>
                            </div>
                        </fieldset>


                     <fieldset style="padding:10px;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">{{__('cp.country')}}</label>
                            <div class="col-md-6 bold">{{@$item->country->name}}</div>
                        </div>
                    </fieldset>


                    <fieldset style="padding:10px; background-color:#f2f2f2;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">{{__('cp.city')}}</label>
                            <div class="col-md-6 bold">{{@$item->city->name}}</div>
                        </div>
                    </fieldset>


                    <fieldset style="padding:10px;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">{{__('cp.address')}}</label>
                            <div class="col-md-6 bold">{{@$item->address}}</div>
                        </div>
                    </fieldset>

                    
                    <fieldset style="padding:10px; background-color:#f2f2f2;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">{{__('cp.status')}}</label>
                            <div class="col-md-6 bold">{{__('cp.'.$item->status)}}</div>
                        </div>
                    </fieldset>
                        
                        
                    <fieldset style="padding:10px;">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="order">{{__('cp.zone')}}</label>
                            <div class="col-md-6 bold">{{__('cp.'.$item->zone->name)}}</div>
                        </div>
                    </fieldset>
                        
                       
                    @if(isset($item->office_employees))    
                    <fieldset style="padding:10px; background-color:#ccc; #color:#fff; margin-top:5px;">
                        <div class="form-group">
                            <div class="col-md-12 bold">{{__('cp.employees')}} / {{@$item->name}}</div>
                        </div>
                    </fieldset>    
                    
                    @foreach($item->office_employees as $one)
                    <fieldset style="padding:10px; background-color:#fff;">
                        <div class="form-group">
                            <div class="col-md-1 bold">{{ @$loop->iteration }}- </div>
                            <div class="col-md-4 bold">{{ @$one->name }} </div>
                            <div class="col-md-3 bold">{{ @$one->email }} </div>
                            <div class="col-md-2 bold">{{ @$one->mobile }} </div>
                            <div class="col-md-2 bold">{{ @$one->role->name }} </div>
                        </div>
                    </fieldset>
                    @endforeach
                    @endif
      
      
                    @if(isset($item->office_clients))
                    <fieldset style="padding:10px; background-color:#ccc; #color:#fff; margin-top:5px;">
                        <div class="form-group">
                            <div class="col-md-12 bold">{{__('cp.clients')}}</div>
                        </div>
                    </fieldset>  

                    @foreach($item->office_clients as $one)
                    <fieldset style="padding:10px; background-color:#fff;">
                        <div class="form-group">
                            <div class="col-md-1 bold">{{ @$loop->iteration }}- </div>
                            <div class="col-md-4 bold">{{ @$one->name }} </div>
                            <div class="col-md-3 bold">{{ @$one->email }} </div>
                            <div class="col-md-2 bold">{{ @$one->mobile }} </div>
                            <div class="col-md-2 bold">{{ @$one->country->name }} </div>
                        </div>
                    </fieldset>
                    @endforeach
                    @endif
                    
                    
                    @if(isset($item->office_projects))
                    <fieldset style="padding:10px; background-color:#ccc; #color:#fff; margin-top:5px;">
                        <div class="form-group">
                            <div class="col-md-12 bold">{{__('cp.projects')}}</div>
                        </div>
                    </fieldset>  

                    @foreach($item->office_projects as $one)
                    <fieldset style="padding:10px; background-color:#fff;">
                        <div class="form-group">
                            <div class="col-md-1 bold">{{ @$loop->iteration }}- </div>
                            <div class="col-md-4 bold">{{ @$one->name }} </div>
                            <div class="col-md-3 bold">{{ @$one->email }} </div>
                            <div class="col-md-2 bold">{{ @$one->mobile }} </div>
                            <div class="col-md-2 bold">{{ @$one->country->name }} </div>
                        </div>
                    </fieldset>
                    @endforeach
                    @endif
                    
                    
                    @if(isset($item->office_hours))
                    <fieldset style="padding:10px; background-color:#ccc; #color:#fff; margin-top:5px;">
                        <div class="form-group">
                            <div class="col-md-12 bold">{{__('cp.hours')}}</div>
                        </div>
                    </fieldset>  

                    @foreach($item->office_hours as $one)
                    <fieldset style="padding:10px; background-color:#fff;">
                        <div class="form-group">
                            <div class="col-md-1 bold">{{ @$loop->iteration }}- </div>
                            <div class="col-md-4 bold">{{ @$one->project->name }} </div>
                            <div class="col-md-3 bold">{{ @$one->hours_count }} </div>
                            <div class="col-md-2 bold">{{ @$one->price }} {{__('cp.rs')}} </div>
                            <div class="col-md-2 bold">{{ ($one->hours_count*$one->price) }} {{__('cp.rs')}}</div>
                        </div>
                    </fieldset>
                    @endforeach
                    @endif



                </div>
            </div>
        </div>
    </div>



@endsection
@section('js')
@endsection
@section('script')

@endsection
