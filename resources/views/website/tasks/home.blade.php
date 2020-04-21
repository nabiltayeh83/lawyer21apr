@extends('layout.siteLayout')
@section('title', __('website.tasks'))
@section('topfixed')

<div class="page-top-fixed">
	<div class="container-fluid">
    	<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.tasks')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/exportAllTasksPDF')}}'">
				        <i class="material-icons">description</i><span>{{__('website.export')}}</span>
					</button>

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>

                <button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale() . '/tasks/create')}}'">
                    <i class="material-icons">add</i> <span>{{__('website.add_task')}}</span>
                </button>
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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/tasks')}}">{{__('website.tasks')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.view_all_tasks')}}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <div class=" card m-0 no-border">
                    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
						<div>
						    <h5>{{__('website.view_tasks')}}</h5><p>{{__('website.view_all_tasks_types')}}</p>
                        </div>

						<div class="btn-group">
                            <form class="input-group" id="taskFilterText" action="javascript:avoid(0)" method="get">
                                <input type="text" name="text" id="textKey" class="form-control" placeholder="{{__('website.search')}}">
							    <div class="input-group-append">
							        <button class="btn btn-secondary" type="submit"><i class="material-icons">search</i></button>
							    </div>
                            </form>

                            <button class="btn btn-sm btn-default filter has-icon" data-target="#filterModalTasks" data-toggle="modal">
                                <i class="material-icons">filter_list</i><span>{{__('website.filter')}}</span>
                            </button>

                            <button class="btn btn-sm btn-default filterTabTasks active" data-action="all">{{__('website.all')}}</button>
						    <button class="btn btn-sm btn-default filterTabTasks" data-action="urgent">{{__('website.urgent')}}</button>
						    <button class="btn btn-sm btn-default filterTabTasks" data-action="normal">{{__('website.normal')}}</button>
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
                                        <th class="wd-15p">{{__('website.task_name')}}</th>
                                        <th class="wd-15p">{{__('website.project')}}</th>
                                        <th class="wd-15p">{{__('website.responsible_emp')}}</th>
                                        <th class="wd-10p">{{__('website.delivery_date')}}</th>
                                        <th class="wd-10p">{{__('website.remaining_time')}}</th>
                                        <th class="wd-10p">{{__('website.task_status')}}</th>
                                        <th class="wd-5p">{{__('website.priority')}}</th>
                                        <th class="wd-15p">{{__('website.action')}}</th>
                                    </tr>
							    </thead>

                                <tbody class="viewAllTasks">

                                    @include('website.extraBlade.filters.taskFilter')

                                    @if(isset($items))
                                    @forelse($items as $item)
                                    <tr id="tr-{{@$item->id}}" class="taskRow">
								        <td class="v-align-middle wd-5p">
									        <div class="checkbox checkMain text-center">
                                                <input type="checkbox" class="checkboxes chkBox" value="{{@$item->id}}" id="chkBox{{@$item->id}}" data name="chkBox"/>
                                                <label for="chkBox{{@$item->id}}" class="no-padding no-margin"></label>
									        </div>
                                        </td>
								        <td class="v-align-middle wd-15p name{{@$item->id}}">
                                            <a href="{{url(getLocal(). '/tasks/' . $item->id)}}">{{@$item->name}}</a>
                                        </td>
                                        <td class="v-align-middle wd-15p">
                                            @if(isset($item->project_id))
                                                <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}">
                                                    <p>{{@$item->project->name}}</p>
                                                </a>
                                            @endif
						                </td>
                                        <td class="v-align-middle wd-15p typeClients">
                                            @if(isset($item->responsible_employee))
                                                <p>{{@$item->employee->name}}</p>
                                            @endif
                                        </td>
								        <td class="v-align-middle wd-10p">
                                            <p>
                                                {{Arr::get(getDates(substr($item->end_date, 0, 10)), 'hijri_date')}}
                                            </p>
								        </td>

                                        <td class="v-align-middle wd-10p">
									        <p>
                                            @if($item->end_date < date("Y-m-d", strtotime(Carbon\Carbon::now())))
                                                {{__('website.done')}}
                                            @else
                                                @if(Carbon\Carbon::now()->diffInDays($item->end_date) == 0)
                                                    {{__('website.one_day')}}
                                                @endif
                                                @if(Carbon\Carbon::now()->diffInDays($item->end_date) == 1)
                                                    {{__('website.two_days')}}
                                                @endif
                                                @if(Carbon\Carbon::now()->diffInDays($item->end_date) > 1 && Carbon\Carbon::now()->diffInDays($item->end_date) <= 10)
                                                    {{Carbon\Carbon::now()->diffInDays($item->end_date)}} {{__('website.days')}}
                                                @endif
                                                @if(Carbon\Carbon::now()->diffInDays($item->end_date) > 10)
                                                    {{Carbon\Carbon::now()->diffInDays($item->end_date)}} {{__('website.day')}}
                                                @endif
                                            @endif
                                            </p>
                                        </td>

								        <td class="v-align-middle wd-10p taskStatus-{{@$item->id}}">
									        <p> @if(isset($item->task_status_id)) {{@$item->task_status->name}} @endif</p>
                                        </td>

								        <td class="v-align-middle wd-5p">
                                            <span class="badge badge-pill
                                            {{@$item->priority == 'urgent'? 'badge-success' : 'badge-info'}}" id="label-{{@$item->id}}">
                                            {{__('website.'.$item->priority)}}
                                            </span>
								        </td>

								        <td class="v-align-middle wd-15p optionAddHours">

                                            <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.add_hours')}}">
                                                <i data-target="#modalAddHours" data-id="{{@$item->id}}" id="addHoursFromHome" data-toggle="modal" class="material-icons">add</i>
                                            </div>

                                            <div class="note-options completeTask" data-id="{{@$item->id}}" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.complete_it')}}">
                                                <i class="material-icons">check</i>
                                            </div>

                                            <a href="{{url(getLocal(). '/tasks/' . $item->id . '/edit')}}">
                                                <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.edit')}}">
                                                    <i class="material-icons editTask">edit</i>
                                                </div>
                                            </a>

                                            <a href="{{url(getLocal(). '/tasks/' . $item->id)}}">
                                                <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                                                    <i class="material-icons showDitails">visibility</i>
                                                </div>
                                            </a>
                                        </td>
								    </tr>
                                    @empty
                                    @endforelse
                                    @endif
                                </tbody>
							</table>
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



<div class="modal fade slide-right" id="filterModalTasks" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6> {{__('website.filter')}} </h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
					        <form id="taskFilterForm" action="javascript:avoid(0)" method="get">
							    <div class="form-group form-group-default form-group-default-select2 required">
								    <label> {{__('website.task_ended')}} </label>
								    <select class="full-width" data-init-plugin="select2" id="task_ended" name="task_ended">
								        <optgroup label="{{__('website.choose_task_ended')}}">
									        <option value=""></option>
									        <option value="today">{{__('website.today')}}</option>
									        <option value="after_week">{{__('website.this_week')}}</option>
								        </optgroup>
								    </select>
                                </div>

							    <div class="form-group form-group-default form-group-default-select2 required">
								    <label> {{__('website.task_status')}} </label>
                                    <select class="full-width" data-init-plugin="select2" id="task_status_id" name="task_status_id">
                                        <optgroup label="{{__('website.select_task_status')}}">
                                            <option value=""></option>
                                       		@if(isset(Auth::user()->office_task_status))
                                    		@foreach(Auth::user()->office_task_status as $one)
                                    		    <option value="{{@$one->task_status_id}}">{{@$one->task_status->name}}</option>
                                    		@endforeach
                                    		@endif
                                        </optgroup>
                                    </select>
                                </div>

							    <div class="form-group form-group-default form-group-default-select2 required">
								    <label> {{__('website.responsible_lawyer')}} </label>
                                    <select class="full-width" data-init-plugin="select2" id="responsible_employee" name="responsible_employee">
                                        <optgroup label="{{__('website.choose_emp_name')}}">
                                        <option value=""></option>
                                        @foreach(Auth::user()->office_employees as $one)
                                            <option value="{{@$one->id}}">{{@$one->name}}</option>
                                        @endforeach
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label> {{__('website.from_date')}} </label>
                                            <input type="text" class="form-control hijri-date-input" name='from_date'>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label> {{__('website.to_date')}} </label>
                                            <input type="text" class="form-control hijri-date-input" name='to_date'>
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


@endsection






@section('js')
<script>

$(document).ready(function(){

    /////////////////////// filter Tab Tasks ////////////////////
    $(document).on('click','.filterTabTasks',function(e){
        var status = $(this).data("action");
        $('.filterTabTasks').removeClass('active');
        $(this).addClass('active');
        var url = "{{ url(app()->getLocale().'/taskFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                $(".taskRow").hide();
                $('.viewAllTasks').append(response.taskFilter);
            }
        });
    });

    /////////////////////// filter Text Tasks ////////////////////
    $(document).on('submit','#taskFilterText',function(e){
        var text = $('#textKey').val();
        var url = "{{ url(app()->getLocale().'/taskFilterText/') }}";

        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".taskRow").hide();
                $('.viewAllTasks').append(response.taskFilter);
            }
        });
    });


    /////////////////////// filter Form Clients ////////////////////
    $(document).on('submit','#taskFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/taskFilterForm/') }}";
        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".taskRow").hide();

                $('#filterModalTasks').fadeOut(500,function(){
                    $('#filterModalTasks').modal('hide');
                });

                $('.viewAllTasks').append(response.taskFilter);

                $("#taskFilterForm #task_ended").val('').select2();
                $("#taskFilterForm #task_status_id").val('').select2();
                $("#taskFilterForm #responsible_employee").val('').select2();
                $("#taskFilterForm").trigger("reset");
            }
        });
    });


});
</script>
@endsection
