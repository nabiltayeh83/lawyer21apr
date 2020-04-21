@extends('layout.adminLayout')

@section('title')
    {{ucwords(__('cp.lawyer_offices'))}} 
@endsection

@section('css')
@endsection

@section('content')
    <div class="portlet light bordered">
        <div class="portlet-body">
            <div class="table-toolbar">

                <div class="row">
                    <div class="col-sm-9">
                        <div class="btn-group">
                            <a href="{{url(app()->getLocale().'/admin/users/create')}}" style="margin-right: 5px" class="btn sbold green">{{__('cp.add')}}
                               <i class="fa fa-plus"></i>
                            </a>
                            <button class="btn sbold blue btn--filter">{{__('cp.filter')}}
                                <i class="fa fa-search"></i>
                            </button>
                                  
                            <button class="btn sbold green event" data-action="active" href="#activation" role="button" data-toggle="modal">
                                {{__('cp.active')}}
                                <i class="fa fa-check"></i>
                            </button>
                            
                            <button class="btn sbold default event"  href="#cancel_activation" role="button" data-toggle="modal" data-action="not_active">
                                {{__('cp.not_active')}}
                                <i class="fa fa-minus"></i>
                            </button>
                            
                              <button class="btn sbold red event" data-action="delete" href="#deleteAll" role="button"  data-toggle="modal">
                            {{__('cp.delete')}}
                                <i class="fa fa-times"></i>
                            </button>
                            
                        </div>
                    </div>
                </div>


                <div class="box-filter-collapse">
                    <form class="form-horizontal" method="get" action="{{url(getLocal().'/admin/users')}}">
                        <div class="row">
                            
                            
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.name')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name" placeholder="{{__('cp.name')}}">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.email')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="{{__('cp.email')}}">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.mobile')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="mobile" placeholder="{{__('cp.mobile')}}">
                                    </div>
                                </div>
                            </div>
                            
                            
                            

                        </div>
                        
                        <div class="row">
                        
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-md-3 control-label">{{__('cp.address')}}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="address" placeholder="{{__('cp.address')}}">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4">
                                <div class="row">
                                    <label class="col-md-3 control-label">{{__('cp.country')}}</label>
                                    <div class="col-md-3 col-md-9">
                                        <select name="country_id" id="country_id" class="form-control">
                                            <option value=""></option>
                                            @if(isset($countries))
                                            @foreach($countries as $one)
                                                <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach   
                                            @endif
                                        </select>  
                                    </div>
                                </div>
                            </div>
                        
                            
                            
                            <div class="col-md-4">
                                <label class="col-md-3 control-label">{{__('cp.status')}}</label>
                                <div class="col-md-3 col-md-9">
                                    <select name="status" id="satus" class="form-control">
                                        <option value=""></option>
                                        <option value="active">{{__('cp.active')}}</option>
                                        <option value="not_active">{{__('cp.not_active')}}</option>
                                    </select>  
                                </div>
                            </div>
                        
                        
                        </div>
                        
                        
                        <div class="row">
                            
                            
                            <div class="col-md-4">
                                <div class="col-md-offset-3 col-md-9">
                                    <button type="submit" class="btn sbold blue">{{__('cp.search')}}
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <a href="{{url('admin/users')}}" type="submit" class="btn sbold btn-default">
                                        {{__('cp.reset')}} <i class="fa fa-refresh"></i>
                                    </a>
                                </div>
                            </div>
                            
                            
                        </div>
                        
                    </form>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover table-checkable order-column" id="toolsTable">
                <thead>
                <tr>
                    <th></th>
                    <th>{{ucwords(__('cp.logo'))}}</th>
                    <th>{{ucwords(__('cp.name'))}}</th>
                    <th>{{ucwords(__('cp.email'))}}</th>
                    <th>{{ucwords(__('cp.mobile'))}}</th>
                    <th>{{ucwords(__('cp.country'))}}</th>
                    <th>{{ucwords(__('cp.status'))}}</th>
                    <th>{{ucwords(__('cp.created'))}}</th>
                    <th>{{ucwords(__('cp.actions'))}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr class="odd gradeX" id="tr-{{$item->id}}">
                        <td>
                            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" name="chkBox"/>
                                <span></span>
                            </label>
                        </td>
                        <td> <img src="{{@$item->image}}"style="width: 50px;"> </td>
                        <td> {{$item->name}}</td>
                        <td><a href="mailto:{{$item->email}}">{{$item->email}}</a></td>
                        <td> {{$item->mobile}}</td>
                        <td> {{@$item->country->name}}</td>
                        <td> <span class="label label-sm <?php echo ($item->status == "active")
                                ? "label-info" : "label-danger"?>" id="label-{{$item->id}}">
                               {{__('cp.'.$item->status)}}
                            </span></td>
                        <td class="center">{{substr($item->created_at, 0, 10)}}</td>
                        <td>
                            <div class="btn-group btn-action">
                                
                                <a href="{{url(getLocal().'/admin/users/'.$item->id)}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.view')}}"><i class="glyphicon glyphicon-eye-open"></i>
                                 </a>


                                <a href="{{url(getLocal().'/admin/users/'.$item->id.'/edit')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit')}}"><i class="fa fa-edit"></i></a>

                                   <a href="{{url(getLocal().'/admin/users/'.$item->id.'/edit_password')}}"
                                   class="btn btn-xs blue tooltips" data-container="body" data-placement="top"
                                   data-original-title="{{__('cp.edit')}} {{__('cp.password')}}"><i class="fa fa-expeditedssl"></i></a>

                                <a href="#myModal{{$item->id}}" role="button"  data-toggle="modal" class="btn btn-xs red tooltips">
                                    &nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i>
                                </a>

                            </div>
                        </td>
                    </tr>


<div id="myModal{{$item->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{__('cp.delete')}}</h4> 
            </div>
            <div class="modal-body">
                <p>{{__('cp.confirm')}} </p> 
            </div>
            <div class="modal-footer">
                <button class="btn default" data-dismiss="modal" aria-hidden="true">{{__('cp.cancel')}}</button>
                <a href="#" onclick="delete_adv('{{$item->id}}','{{$item->id}}',event)"><button class="btn btn-danger">
                {{__('cp.delete')}}</button></a>
            </div>
        </div>
    </div>
</div>


                @empty
                    {{__('cp.no')}}
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
@endsection
@section('script')
    <script>


        function delete_adv(id, iss_id, e) {
            //alert(id);
            e.preventDefault();
            console.log(id);
            console.log(iss_id);
            var url = '{{url(getLocal()."/admin/users")}}/' + id;
            var csrf_token = '{{csrf_token()}}';
            $.ajax({
                type: 'delete',
                headers: {'X-CSRF-TOKEN': csrf_token},
                url: url,
                data: {_method: 'delete'},
                success: function (response) {
                    console.log(response);
                    if (response === 'success') {
                        $('#tr-' + id).hide(500);
                        $('#myModal' + id).modal('toggle');
                        //swal("القضية حذفت!", {icon: "success"});
                    } else {
                        // swal('Error', {icon: "error"});
                    }
                },
                error: function (e) {
                    // swal('exception', {icon: "error"});
                }
            });

        }


    </script>
@endsection
