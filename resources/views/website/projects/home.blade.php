@extends('layout.siteLayout')
@section('title', __('website.projects'))

@section('topfixed')

<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
		    <h2 class="page-header mb-1 my-md-3 ">{{__('website.projects')}}</h2>
    		<div class="page-options-btns">

			    <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/exportAllProjectsPDF')}}'">
				        <i class="material-icons">description</i><span>{{__('website.export')}}</span>
					</button>

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
				</div>

				<button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale() . '/projects/create')}}'">
                    <i class="material-icons">add</i> <span>{{__('website.add_project')}}</span>
                </button>

			</div>
		</div>
	</div>
</div>
@endsection


@section('content')
<div class="content allprojects">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/projects')}}">
                    {{__('website.projects')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('website.view_projects')}}</li>
            </ol>
        </div>
    </div>

    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <div class=" card m-0 no-border">
                    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
					    <div>
						    <h5>{{__('website.view_projects')}}</h5>
						    <p>{{__('website.view_all_projects_type')}}</p>
					    </div>

                        <div class="btn-group">
                            <form class="input-group" id="projectFilterText" action="javascript:avoid(0)" method="get">
							    <input type="text" class="form-control" placeholder="{{__('website.search')}}"  name="text" id="textKey">
							    <div class="input-group-append">
							        <button class="btn btn-secondary" type="submit">
								        <i class="material-icons">search</i>
							        </button>
							    </div>
						    </form>

						    <button class="btn btn-sm btn-default filter has-icon " data-target="#filterModalProjects" data-toggle="modal">
                            <i class="material-icons">filter_list</i> <span>{{__('website.filter')}}</span></button>
                            <button class="btn btn-sm btn-default filterTabProjects active" data-action="all">{{__('website.all')}}</button>
						    <button class="btn btn-sm btn-default filterTabProjects" data-action="1">{{__('website.project_status1')}}</button>
						    <button class="btn btn-sm btn-default filterTabProjects" data-action="2">{{__('website.project_status2')}}</button>
						    <button class="btn btn-sm btn-default filterTabProjects" data-action="3">{{__('website.project_status3')}}</button>
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
                                        <th class="wd-25p">{{__('website.project_name')}}</th>
        								<th class="wd-15p">{{__('website.client_name')}}</th>
        								<th class="wd-15p">{{__('website.responsible_emp')}}</th>
        								<th class="wd-10p">{{__('website.project_type')}}</th>
        								<th class="wd-15p">{{__('website.project_open_date')}}</th>
        								<th class="wd-5p">{{__('website.status')}}</th>
                                       	<th class="wd-5p">{{__('website.action')}}</th>
                                    </tr>
							    </thead>

							    <tbody class="viewAllProjects">

							    @include('website.extraBlade.filters.projectFilter')

							    @if(isset($items))
                                @forelse($items as $item)
                                    <tr id="tr-{{$item->id}}" class="projectRow">
                                        <td class="v-align-middle wd-5p">
									        <div class="checkbox checkMain text-center">
                                                <input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" data name="chkBox"/>
                                                <label for="chkBox{{$item->id}}" class="no-padding no-margin"></label>
									        </div>
								        </td>
								        <td class="v-align-middle wd-25p">
                                            <a href="{{url(getLocal(). '/projects/' . $item->id)}}">{{$item->name}}</a>
								        </td>
                                        <td class="v-align-middle wd-15p">
								            @if($item->client_id)
                                                <a href="{{url(getLocal(). '/clients/' . $item->client_id)}}"
                                                    >{{@$item->client->name}}</a>
									        @endif
                                        </td>

                                        <td class="v-align-middle wd-15p">
                                            @if($item->responsible_lawyer)
                                                {{@$item->project_manager->name}}
                                            @endif
								        </td>

    								    <td class="v-align-middle wd-10p">
    									    <p>
                                            @if($item->type == 1)
                                                {{__('website.issue')}}
                                                @elseif($item->type == 2)
                                                {{__('website.consultation')}}
                                                @else
                                                {{__('website.other')}}
                                            @endif
                                            </p>
                                        </td>

                                        <td class="v-align-middle wd-10p">
                                            <p>
                                            {{@Arr::get(getDates(substr($item->created_at, 0, 10)), 'hijri_date')}}
                                            </p>
								        </td>

                                        <td class="v-align-middle wd-5p">
                                            <span class="badge badge-pill
                                            {{$item->project_status->id == '1'? 'badge-success':''}}
                                            {{$item->project_status->id == '2'? 'badge-info':''}}
                                            {{$item->project_status->id == '3'? 'badge-danger':''}}"
                                            id="label-{{$item->id}}">
                                            {{ @$item->project_status->name }}</span>
                                        </td>

								        <td class="v-align-middle wd-5p optionAddHours">
                                            <a href="{{url(getLocal(). '/projects/' . $item->id)}}">
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
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.You_are_about_to_delete_the_project')}}
                                <span class="block bold viewItems"></span>
                            </p>
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



<div class="modal fade slide-right" id="filterModalProjects" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content-wrapper">
		    <div class="modal-content">
			    <div class="modal-header mb-3">
				    <h6>{{__('website.filter')}}</h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
					        <form id="projectFilterForm" action="javascript:avoid(0)" method="get">
							    <div class="form-group form-group-default form-group-default-select2">
							        <label>{{__('website.client_name')}}</label>
							        <select class="full-width" data-init-plugin="select2" id="client_id" name="client_id">
								        <optgroup label="{{__('website.choose_client_name')}}">
								  	        <option value=""></option>
								  	        @if(isset($clients))
                                            @foreach($clients as $one)
									            <option value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
                                            @endif
								        </optgroup>
								    </select>
							    </div>
							    <div class="form-group form-group-default form-group-default-select2">
								    <label> {{__('website.project_manager')}} </label>
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
								    <label>{{__('website.project_type')}}</label>
								    <select class="full-width" data-init-plugin="select2" id="type" name="type">
								        <optgroup label="{{__('website.choose_project_type')}}">
									        <option value=""></option>
									        <option value="1">{{__('website.issue')}}</option>
									        <option value="2">{{__('website.consultation')}}</option>
									        <option value="3">{{__('website.service')}}</option>
								        </optgroup>
								    </select>
							    </div>
							    <div class="row">
								    <div class="col-md-6">
									    <div class="form-group form-group-default">
										    <label>{{__('website.start_date')}}</label>
										    <input type="text" class="form-control hijri-date-input" name="start_date">
									    </div>
								    </div>
								    <div class="col-md-6">
									    <div class="form-group form-group-default">
										    <label>{{__('website.end_date')}}</label>
										    <input type="text" class="form-control hijri-date-input" name="end_date">
									    </div>
								    </div>
							    </div>
							    <button type="submit" class="btn btn-complete btn-block" >{{__('website.filter')}}</button>
						        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
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


    /////////////////////// filter Tab Projects ////////////////////
    $(document).on('click','.filterTabProjects',function(e){
        var status = $(this).data("action");

        $('.filterTabProjects').removeClass('active');
        $(this).addClass('active');

        var url = "{{ url(app()->getLocale().'/projectFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                $(".projectRow").hide();
                $('.viewAllProjects').append(response.projectFilter);
            }
        });

    });


    /////////////////////// filter Text Projects ////////////////////
    $(document).on('submit','#projectFilterText',function(e){
        var text = $('#textKey').val();
        var url = "{{ url(app()->getLocale().'/projectFilterText/') }}";

        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".projectRow").hide();
                $('.viewAllProjects').append(response.projectFilter);
            }
        });
    });

        /////////////////////// filter Form Clients ////////////////////
    $(document).on('submit','#projectFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/projectFilterForm/') }}";
        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".projectRow").hide();

                $('#filterModalProjects').fadeOut(500,function(){
                    $('#filterModalProjects').modal('hide');
                });

                $('.viewAllProjects').append(response.projectFilter);

                $("#projectFilterForm #client_id").val('').select2();
                $("#projectFilterForm #responsible_lawyer").val('').select2();
                $("#projectFilterForm #type").val('').select2();
                $("#projectFilterForm").trigger("reset");

            }
        });
    });


});

</script>
@endsection
