@extends('layout.siteLayout')
@section('title', __('website.hours'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
    	<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.hours')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/exportAllHoursPDF')}}'">
				        <i class="material-icons">description</i><span>{{__('website.export')}}</span>
					</button>

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>

			    </div>

                <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddHours" data-toggle="modal">
                    <i class="material-icons">add</i> <span>{{__('website.add_hours')}}</span>
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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/hours')}}">
                    {{__('website.hours')}}
                </a></li>
                <li class="breadcrumb-item active">{{__('website.view_all_hours')}}</li>
            </ol>
        </div>
    </div>

    <div class=" container-fluid">
        <div class="row no-gutters  mt-4">
            <div class="col-lg-12">
                <div class=" card m-0 no-border">
                    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
					    <div>
						    <h5>{{__('website.view_hours')}}</h5>
						    <p>{{__('website.view_all_hours')}}</p>
                        </div>

					    <div class="btn-group">
                            <form class="input-group" id="hourFilterText" action="javascript:avoid(0)" method="get">
                                <input type="text" name="text" id="textKey" class="form-control" placeholder="{{__('website.search')}}">
							    <div class="input-group-append">
							        <button class="btn btn-secondary" type="submit">
							            <i class="material-icons">search</i>
							        </button>
							    </div>
                            </form>

						    <button class="btn btn-sm btn-default filter has-icon" data-target="#filterModalHours" data-toggle="modal">
                                <i class="material-icons">filter_list</i><span>{{__('website.filter')}}</span>
                            </button>

                            <button class="btn btn-sm btn-default filterTabHours active" data-action="all">{{__('website.all')}}</button>
						    <button class="btn btn-sm btn-default filterTabHours" data-action="thisWeek">{{__('website.thisWeek')}}</button>
						    <button class="btn btn-sm btn-default filterTabHours" data-action="thisMonth">{{__('website.thisMonth')}}</button>
					    </div>
					</div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover tableWithSearch allHours" id="tableWithSearch">
                                <thead>
								    <tr>
								        <th class="wd-5p no-sort">
								            <div class="checkbox checkMain text-center">
                                                <input type="checkbox" value="" id="checkboxall" name="client" class="chkBox">
									            <label for="checkboxall" class="no-padding no-margin"></label>
									        </div>
								      </th>
                                      <th class="wd-20p">{{__('website.project')}}</th>
								      <th class="wd-20p">{{__('website.task')}}</th>
                                      <th class="wd-15p">{{__('website.responsible_emp')}}</th>
                                      <th class="wd-5p">{{__('website.hours')}}</th>
                                      <th class="wd-5p">{{__('website.range')}}</th>
								      <th class="wd-10p">{{__('website.date')}}</th>
								      <th class="wd-10p">{{__('website.amount')}}</th>
								      <th class="wd-5p">{{__('website.status')}}</th>
                                      <th class="wd-5p">{{__('website.action')}}</th>
                                    </tr>
							    </thead>


                                <tbody class="viewAllHours">

                                @include('website.extraBlade.filters.hourFilter')

                                @if(isset($items))
                                @forelse($items as $item)

                                    <tr id="tr-{{$item->id}}" class="hourRow">
                                        <td class="v-align-middle wd-5p">
									        <div class="checkbox checkMain text-center">
                                                <input type="checkbox" class="checkboxes chkBox" value="{{@$item->id}}" id="chkBox{{@$item->id}}" data name="chkBox"/>
                                                <label for="chkBox{{@$item->id}}" class="no-padding no-margin"></label>
									        </div>
                                        </td>

                                        <td class="v-align-middle wd-20p name{{@$item->id}}">
                                            @if($item->project_id)
                                                <a href="{{url(getLocal(). '/projects/' . $item->project_id)}}">{{@$item->project->name}}</a>
                                            @endif
                                        </td>

                                        <td class="v-align-middle wd-20p">
                                            @if($item->task_id)
                                                <p><a href="{{url(getLocal(). '/tasks/' . $item->task_id)}}">{{@$item->task->name}}</a></p>
                                            @endif
								        </td>

                                        <td class="v-align-middle wd-15p typeClients">
                                            @if($item->responsible_lawyer)
                                                <p>{{@$item->employee->name}}</p>
                                            @endif
                                        </td>

								        <td class="v-align-middle wd-5p">
									        <p>{{@$item->hours_count}}</p>
                                        </td>

								        <td class="v-align-middle wd-5p">
                                            <p>{{@$item->price}} {{__('website.r_s')}}</p>
								        </td>

                                        <td class="v-align-middle wd-10p">
                                            <p>
                                                {{Arr::get(getDates(substr($item->start_date, 0, 10)), 'hijri_date')}}
                                            </p>
                                        </td>

								        <td class="v-align-middle wd-10p hourStatus-{{$item->id}}">
									        <p>{{($item->hours_count*$item->price)}} {{__('website.r_s')}}</p>
                                        </td>

								        <td class="v-align-middle wd-5p">
                                            <span class="badge badge-pill
                                            @if($item->hour_status == 'paid') badge-info @endif
                                            @if($item->hour_status == 'billable') badge-success @endif
                                            @if($item->hour_status == 'not_billable') badge-danger @endif " id="label-{{$item->id}}">
                                            {{__('website.'.$item->hour_status)}}
                                            </span>
								        </td>

								        <td class="v-align-middle wd-5p optionAddHours">
                                            <a href="{{url(getLocal(). '/hours/' . $item->id)}}">
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



<!-- modal-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle tءذext-center">
                            <p>{{__('website.are_you_sure_to_delete_this_hours')}}
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll" data-dismiss="modal" data-action="delete">
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



<div class="modal fade slide-right" id="filterModalHours" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h6> {{__('website.filter')}} </h6>
                </div>
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height">
                            <form id="hourFilterForm" action="javascript:avoid(0)" method="get">
                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label>{{__('website.project')}}</label>
                                    <select class="full-width project" data-init-plugin="select2" id="project_id" name="project_id">
                                        <optgroup label="{{__('website.select_project_name')}}">
                                            <option value=""></option>
                                            @if(isset($projects))
                                            @foreach($projects as $one)
                                                <option value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>

                                <!--<div class="form-group form-group-default form-group-default-select2 required">-->
                                <!--    <label>{{__('website.task')}}</label>-->
                                <!--    <select class="full-width task"  name="task_id" id="task_id" data-init-plugin="select2">-->
                                <!--    </select>-->
                                <!--</div>-->

                                <div class="form-group form-group-default form-group-default-select2">
                                    <label>{{__('website.project_manager')}}</label>
                                    <select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                                        <optgroup label="{{__('website.choose_project_manager')}}">
                                            <option value=""></option>
                                            @if(isset(Auth::user()->office_employees))
                                            @foreach(Auth::user()->office_employees as $one)
                                              <option value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                      </select>
                                </div>
                                <div class="form-group form-group-default form-group-default-select2">
                                    <label>{{__('website.hours_status')}}</label>
                                    <select class="full-width" data-init-plugin="select2" id='hour_status' name="hour_status">
                                            <option value=""></option>
                                            <option value="paid">{{__('website.paid')}}</option>
                                            <option value="billable">{{__('website.billable')}}</option>
                                            <option value="not_billable">{{__('website.not_billable')}}</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label> {{__('website.from_date')}} </label>
                                            <input type="text" class="form-control hijri-date-input" id="date_from" name="date_from">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>  {{__('website.to_date')}} </label>
                                            <input type="text" class="form-control hijri-date-input" id="date_to" name="date_to">
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


    /////////////////////// filter Tab Hours ////////////////////
    $(document).on('click','.filterTabHours',function(e){
        var status = $(this).data("action");
        $('.filterTabHours').removeClass('active');
        $(this).addClass('active');
        var url = "{{ url(app()->getLocale().'/hourFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                 $(".hourRow").hide();
                $('.viewAllHours').append(response.hourFilter);
            }
        });
    });


    /////////////////////// filter Text Hours ////////////////////
    $(document).on('submit','#hourFilterText',function(e){
        var text = $('#textKey').val();
        var url = "{{ url(app()->getLocale().'/hourFilterText/') }}";

        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".hourRow").hide();
                $('.viewAllHours').append(response.hourFilter);
            }
        });
    });


    /////////////////////// filter Form Hours ////////////////////
    $(document).on('submit','#hourFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/hourFilterForm/') }}";
        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".hourRow").hide();

                $('#filterModalHours').fadeOut(500,function(){
                    $('#filterModalHours').modal('hide');
                });

                $('.viewAllHours').append(response.hourFilter);

                $("#filterModalHours #project_id").val('').select2();
                $("#filterModalHours #responsible_lawyer").val('').select2();
                $("#filterModalHours #hour_status").val('').select2();
                $("#hourFilterForm").trigger("reset");

            }
        });
    });



});
</script>
@endsection
