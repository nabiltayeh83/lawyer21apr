@extends('layout.siteLayout')

@section('title', __('website.staff'))

@section('topfixed')

<div class="page-top-fixed">
	<div class="container-fluid">
    	<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.staff')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>
          		<a data-target="#addStaff" data-toggle="modal">
					<button class="btn btn-complete has-icon mb-2 m-md-0">
						<i class="material-icons">add</i><span> {{__('website.add_employee')}}  </span>
					</button>
				</a>
            </div>
		</div>
	</div>
</div>
@endsection



@section('content')
<div class="content allclients">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/settings')}}">
                {{__('website.settings')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.staff')}}</li>
            </ol>
        </div>
    </div>

	<div class="row no-gutters container-fluid dashboard-no-gutters mt-4">
        <div class="card card-borderless">
			<div class="tab-content" style="padding:0">
                <div class="tab-pane active" id="DataStaff">
				    <div class="">
						<div class="row no-gutters mt-4">
							<div class="col-lg-12">
							    <div class="card m-0 no-border">
									<div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
										<div>
											<h5> {{__('website.view_employees')}} </h5> <p> {{__('website.view_employees_data')}} </p>
										</div>
										<div class="btn-group">
										    <form class="input-group">
												<input type="text" class="form-control" placeholder="{{__('website.search')}}">
												<div class="input-group-append">
													<button class="btn btn-secondary" type="button">
														<i class="material-icons">search</i>
													</button>
												</div>
											</form>
										</div>
									</div>
									<div class="card-body p-0">
									    <div class="table-responsive">
											<table class="table table-hover tableWithSearch" id="tableWithSearch">
											    <thead>
													<tr>
                                                        <th class="wd-5p no-sort">
								                            <div class="checkbox checkMain text-center">
                                                                <input type="checkbox" value="" id="checkboxall" name="client" class="chkBox">
									                            <label for="checkboxall" class="no-padding no-margin"></label>
									                        </div>
								                        </th>
														<th class="wd-10p">{{__('website.employee_ID')}}</th>
														<th class="wd-20p">{{__('website.employee_name')}}</th>
														<th class="wd-15p"> {{__('website.address')}}</th>
														<th class="wd-15p">{{__('website.email')}}</th>
														<th class="wd-10p">{{__('website.mobile')}} </th>
														<th class="wd-15p">{{__('website.roles')}}</th>
														<th class="wd-10p">{{__('website.action')}}</th>
													</tr>
												</thead>
											    
											    <tbody>
                                                @foreach($users as $user)
                                                    <tr id="tr-{{@$user->id}}">
      					                                <td class="v-align-middle wd-5p">
									                        <div class="checkbox checkMain text-center">
                                                                <input type="checkbox" class="checkboxes chkBox" value="{{@$user->id}}" id="chkBox{{@$user->id}}" data name="chkBox"/>
                                                                <label for="chkBox{{@$user->id}}" class="no-padding no-margin"></label>
									                        </div>
                                                        </td>
								                        <td class="v-align-middle wd-10p">
									                        <p>{{@$user->id}}</p>
										                </td>
										                <td class="v-align-middle wd-20p">
											                <a href="">{{@$user->name}}</a>
												        </td>
										    
										                <td class="v-align-middle wd-25p">
							                                <a href="">{{@$user->address}}</a>
								                        </td>
								                        
                        								<td class="v-align-middle wd-15p">
                        									<p>{{@$user->email}}</p>
                        								</td>
                        								
                        						        <td class="v-align-middle wd-10p">
                        							        <p>{{@$user->mobile}}</p>
                        							    </td>
                        								
                        								<td class="v-align-middle wd-15p">
                        								    <p> {{@$user->role->name}} </p>
                        							    </td>
                        							
                        								<td class="v-align-middle wd-10p">
                        								    <a href="{{url(getLocal(). '/staff/' . $user->id . '/edit')}}">
                                                                <i class="material-icons editTask">edit</i>
                                                            </a>
                        							    </td>
				                                    </tr>
                                                    @endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
					    </div>
					</div>
				</div>
			</div>
	    </div>
	</div>
</div>



<!--     modal-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle tءذext-center">
                            <p>{{__('website.are_you_sure_to_delete_this_task')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5>
                            <br>
                            <button type="button" class="btn btn-danger btn-block confirmAll"
                            data-dismiss="modal" data-action="delete">{{__('website.agree')}}</button>
                            <button type="button" class="btn btn-default btn-block"
                            data-dismiss="modal">{{__('website.cancel')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade slide-right" id="filterTask" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6> {{__('website.filter')}} </h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height  ">
					        <form id="formAddTask" action="{{url(app()->getLocale().'/tasks/')}}" method="get">
							    <div class="form-group form-group-default form-group-default-select2 required">
								    <label> {{__('website.task_ended')}} </label>
								    <select class="full-width" data-init-plugin="select2" id="task_ended" name="task_ended">
								        <optgroup label="{{__('website.choose_task_ended')}}">
									        <option value=""></option>
									        <option value="today">{{__('website.today')}}</option>
									        <option value="after_week">{{__('website.after_week')}}</option>
								        </optgroup>
								    </select>
                                </div>

							    <div class="form-group form-group-default form-group-default-select2 required">
								    <label> {{__('website.task_status')}} </label>
                                    <select class="full-width" data-init-plugin="select2" id="task_status_id" name="task_status_id">
                                        <optgroup label="{{__('website.select_task_status')}}">
                                        <option value=""></option>
                                        @foreach(Auth::user()->office_task_status as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>
                                        @endforeach
                                        </optgroup>
                                    </select>
                                </div>

							    <div class="form-group form-group-default form-group-default-select2 required">
								    <label> {{__('website.responsible_lawyer')}} </label>
                                    <select class="full-width" data-init-plugin="select2" id="responsible_employee" name="responsible_employee">
                                        <optgroup label="{{__('website.choose_emp_name')}}">
                                        <option value=""></option>
                                        @foreach(Auth::user()->office_employees as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>
                                        @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label> {{__('website.from_date')}} </label>
                                            <input type="text" class="form-control start_date" name='from_date'>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label> {{__('website.to_date')}} </label>
                                            <input type="text" class="form-control end_date" name='to_date'>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-complete btn-block"> {{__('website.search')}} </button>
						        <button type="button" class="btn btn-default btn-block" data-dismiss="modal"> {{__('website.cancel')}} </button>
						    </form>
					    </div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>


	<div class="modal fade slide-right" id="addStaff" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content-wrapper">
				<div class="modal-content">
					<div class="modal-header mb-3">
						<h6> {{__('website.add_new_emp')}} </h6>
					</div>
					<div class="container-xs-height full-height">
						<div class="row-xs-height">
							<div class="modal-body col-xs-height  ">

                             <form action="{{url(app()->getLocale() . '/staff')}}" method="post" id="newClientForm" autocomplete="off" enctype="multipart/form-data">
                            {{csrf_field()}}							
							
							    <div class="form-group form-group-default">
									<label>{{__('website.name')}}</label>
									<input type="text" name="name" class="form-control" />
								</div>
									
								<div class="form-group form-group-default">
									<label>  {{__('website.address')}} </label>
									<input type="text" name="address" class="form-control" />
								</div>
								
								<div class="form-group form-group-default">
									<label>  {{__('website.email')}} </label>
									<input type="email" name="email" class="form-control" />
								</div>
								
								<div class="form-group form-group-default">
									<label>   {{__('website.phone')}} </label>
									<input type="text" name="mobile" class="form-control" />
								</div>
									
								<div class="form-group form-group-default">
									<label>   {{__('website.hour_price')}} </label>
									<input type="text" name="hour_price" class="form-control" />
								</div>
									
								<div class="form-group form-group-default form-group-default-select2">
									<label>  {{__('website.roles')}} </label>
									<select class="full-width" data-init-plugin="select2" id="role_group_id" name="role_group_id">
										<optgroup label="{{__('website.roles')}}">
											<option value=""></option>
											@if(isset($roles))
											@foreach($roles as $one)
												<option value="{{$one->id}}">{{ $one->name }}</option>
											@endforeach
											@endif
										</optgroup>
									</select>
								</div>
                            
                                <button type="submit" class="btn btn-complete btn-block"> {{__('website.save')}} </button>
						        <button type="button" class="btn btn-default btn-block" data-dismiss="modal"> {{__('website.cancel')}} </button>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection


@section('js')
<script>

$(document).ready(function(){

    var pureUrl    = "{{ url(app()->getLocale().'/'.Request::segment(2)) }}";
    var currentUrl = window.location.href;


    if (window.location.href.indexOf("priority=viewUrgentItems") > -1) {
      $('#viewUrgentItems').addClass('active');
      $('#viewAllItems').removeClass('active');
      $('#viewNormalItems').removeClass('active');
    }
    if (window.location.href.indexOf("priority=viewNormalItems") > -1) {
      $('#viewNormalItems').addClass('active');
      $('#viewAllItems').removeClass('active');
      $('#viewUrgentItems').removeClass('active');
    }
    if (window.location.href.indexOf("priority") == -1) {
        $('#viewAllItems').addClass('active');
        $('#viewUrgentItems').removeClass('active');
        $('#viewNormalItems').removeClass('active');
    }



    /////////////////////// View All items ////////////////////
    $(document).on('click','#viewAllItems',function(e){
      $(location).attr('href', pureUrl);
    });

    /////////////////////// viewUrgentItems ////////////////////
    $(document).on('click','#viewUrgentItems',function(e){
      $(location).attr('href', pureUrl+'?priority=urgent');
    });

    /////////////////////// viewNormalItems ////////////////////
    $(document).on('click','#viewNormalItems',function(e){
      $(location).attr('href', pureUrl+'?priority=normal');
    });


});
</script>
@endsection
