@extends('layout.siteLayout')
@section('title', __('website.hours'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3"> @if($item->project_id) {{$item->project->name}} @endif </h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/hourInvoice/' . $item->id )}}'">
                        <i class="material-icons">storage</i><span>{{__('website.Billing')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/hours/' . $item->id . '/edit')}}'">
        		        <i class="material-icons">edit</i><span>{{__('website.edit')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" data-target="#modalSlideLeft" data-toggle="modal">
                        <i class="material-icons">close</i> <span>{{__('website.delete')}}</span>
                    </button>

                </div>
                <div class="btn-group m-l-20"></div>
            </div>
		</div>
	</div>
</div>
@endsection



@section('content')
<div class="content ">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/hours')}}">
                    {{__('website.hours')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.hours_data')}}</li>
              </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row no-gutters dashboard-no-gutters mt-4">
                <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                    <div class="card no-border m-0">
                        <div class="card-header">
                            <h3 class="text-success justify-content-between d-flex align-items-center">
                                {{__('website.hours')}}
                            </h3>
                        </div>
                        <div class="card-body no-padding">
                            <div class="card no-border m-0">
                                <div class="card-body pb-1">
                                    <div class="row dashboard-no-gutters">
                                        <div class="col-lg-6 secDataProject">
                                            <p>
                                                <strong>{{__('website.project')}}</strong>
                                                @if($item->project_id)
                                                    <a href="{{url(getLocal(). '/projects/' . $item->project_id)}}">{{@$item->project->name}}</a>
                                                @endif
                                            </p>

                                            @if($item->task_id)
                                                <p>
                                                    <strong>{{__('website.task')}}</strong>
                                                    <span><a href="{{url(getLocal(). '/tasks/' . $item->task_id)}}">{{@$item->task->name}}</a></span>
                                                </p>
                                            @endif

                                            <p><strong>{{__('website.responsible_emp')}}</strong><span>{{@$item->employee->name}}</span></p>
                                            <p><strong>{{__('website.range')}} </strong><span>{{@$item->price}}</span></p>
                                            <p><strong>{{__('website.hours_details')}}</strong><span>{{@$item->hour_details}}</span></p>
                                        </div>

                                        <div class="col-lg-6 secDataProject">
                                            <p><strong>{{__('website.date')}}</strong><span>

                                                {{Arr::get(getDates(substr($item->start_date, 0, 10)), 'hijri_date')}}

                                            </span></p>
                                            <p><strong>{{__('website.amount')}}</strong><span>{{($item->hours_count*$item->price)}}</span></p>
                                            <p><strong>{{__('website.status')}}</strong><span> {{__('website.'.$item->hour_status)}}</span></p>
                                            <p><strong>{{__('website.hours')}}</strong><span>{{@$item->hours_count}}</span></p>
                                            <p><strong>{{__('website.hours_office_details')}}</strong><span>{{@$item->hour_office_details}}</span></p>
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

<input type="checkbox" class="checkboxes chkBox" value="{{@$item->id}}" id="chkBox{{@$item->id}}" name="chkBox" checked style="display:none;" />

<div class="modal fade slide-right" id="modalToEditNote" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content-wrapper">
		    <div class="modal-content">
			    <div class="modal-header mb-3">
					<h6>{{__('website.edit')}} {{__('website.note')}}</h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
				        <div class="modal-body col-xs-height">
                            <form id="formCalendar11" method="post" action="{{url(app()->getLocale().'/clients/note_note')}}" >
                            {{csrf_field()}}
                                <input type="hidden" name="note_id" value="">

    							<div class="form-group form-group-default required">
    								<label>{{__('website.write_note')}}</label>
    								<input type="text" class="form-control" id="note" name="note">
    							</div>

    							<div class="form-group form-group-default required">
    								<label>{{__('website.date')}}</label>
    								<input type="text" class="input-sm form-control start_date" name="note_date"  autocomplete="off" />
    							</div>

    						    <button type="submit" class="btn btn-complete btn-block" >{{__('website.save')}}</button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                            </form>
				        </div>
				    </div>
			    </div>
		    </div>
		</div>
	</div>
</div>




<div class="modal fade slide-right" id="modalAddNote" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
		    <div class="modal-content">
			    <div class="modal-header mb-3">
					<h6>{{__('website.add_new_note')}}</h6>
				</div>

				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
				        <div class="modal-body col-xs-height">
                            <form id="formCalendar11" method="post" action="{{url(app()->getLocale().'/clients/create_note')}}" >
                            {{csrf_field()}}
                                <input type="hidden" name="client_id" value="{{$item->id}}">

    							<div class="form-group form-group-default required">
    								<label>{{__('website.write_note')}}</label>
    								<input type="text" class="form-control" id="note" name="note">
    							</div>

    							<div class="form-group form-group-default required">
    								<label>{{__('website.date')}}</label>
    								<input type="text" class="input-sm form-control start_date" name="note_date" autocomplete="off" />
    							</div>

						        <button type="submit" class="btn btn-complete btn-block" >{{__('website.save')}}</button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                            </form>
				        </div>
				    </div>
			    </div>
		    </div>
	    </div>
	</div>
</div>




<!-- modal-->
<div class="modal fade slide-right" id="modalToDeleteNote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.are_you_sure_to_delete_this_note')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block deleteNote" data-dismiss="modal" data-id="0"  data-action="delete">
                                {{__('website.agree')}}
                            </button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">
                                {{__('website.cancel')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- modal-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.are_you_sure_to_delete_this_hours')}}
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll deleteHourFromDetPage" data-dismiss="modal" data-action="delete">
                                {{__('website.agree')}}
                            </button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">
                                {{__('website.cancel')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection
