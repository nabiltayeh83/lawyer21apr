@extends('layout.siteLayout')

@section('title', __('website.reports'))


@section('topfixed')


<div class="page-top-fixed">
	<div class="container-fluid">
    	<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.reports')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

        <!--          <button type="button" class="btn btn-default  has-icon " data-target="#modalSlideLeft" data-toggle="modal">-->
						  <!-- <i class="material-icons">send</i> -->
						  <!-- <span>إرسال</span>-->
					   <!--</button>-->
					   <!--<button type="button" class="btn btn-default  has-icon " data-target="#modalSlideLeft" data-toggle="modal">-->
						  <!-- <i class="material-icons">visibility</i> -->
						  <!-- <span>معاينة</span>-->
					   <!--</button>	-->

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>

                <button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale() . '/reports/create')}}'">
                    <i class="material-icons">add</i> <span>{{__('website.add')}} {{__('website.report')}}</span>
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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/reports')}}">{{__('website.reports')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.view_all_reports')}}  </li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <div class=" card m-0 no-border">
                    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
						<div>
						    <h5> {{__('website.reports')}}</h5>
						    <p>{{__('website.view_all_reports')}}</p>
                        </div>

						<div class="btn-group">
                            <form class="input-group" id="reportFilterText" action="javascript:avoid(0)" method="get">
                                <input type="text" name="text" id="textKey" class="form-control" placeholder="{{__('website.search')}}">
							    <div class="input-group-append">
							        <button class="btn btn-secondary" type="submit">
								        <i class="material-icons">search</i>
							        </button>
							    </div>
                            </form>

                            <button class="btn btn-sm btn-default filter has-icon" data-target="#filterModalReports" data-toggle="modal">
                                <i class="material-icons">filter_list</i><span>{{__('website.filter')}}</span>
                            </button>

                            <button class="btn btn-sm btn-default filterTabReports active" data-action="all">{{__('website.all')}}</button>
						    <button class="btn btn-sm btn-default filterTabReports" data-action="draft">{{__('website.draft')}}</button>
						    <button class="btn btn-sm btn-default filterTabReports" data-action="completed">{{__('website.completed')}}</button>
						</div>
					</div>

                    <div class="card-body p-0 allReports">
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
                                        <th class="wd-20p">{{__('website.project')}}</th>
                                        <th class="wd-20p">{{__('website.task')}}</th>
                                        <th class="wd-20p">{{__('website.date')}}</th>
                                        <th class="wd-20p">{{__('website.status')}}</th>
                                        <th class="wd-15p">{{__('website.action')}}</th>
                                    </tr>
							    </thead>

                                <tbody class="viewAllReports">

                                    @include('website.extraBlade.filters.reportFilter')

                                    @if(isset($items))
                                    @forelse($items as $item)

                                    <tr id="tr-{{$item->id}}" class="reportRow">
								        <td class="v-align-middle wd-5p">
									        <div class="checkbox checkMain text-center">
                                                <input type="checkbox" class="checkboxes chkBox" value="{{@$item->id}}" id="chkBox{{@$item->id}}" data name="chkBox"/>
                                                <label for="chkBox{{@$item->id}}" class="no-padding no-margin"></label>
									        </div>
                                        </td>
								        <td class="v-align-middle wd-15p name{{$item->id}}">
                                            <a href="{{url(getLocal(). '/projects/' . $item->project_id)}}">{{$item->project->name}}</a>
                                        </td>
                                        <td class="v-align-middle wd-15p">
                                                <a href="{{url(getLocal(). '/tasks/'.$item->task_id)}}">
                                                    <p>{{@$item->task->name}}</p>
                                                </a>
						                </td>

								        <td class="v-align-middle wd-10p">
                                            <p>
                                                {{Arr::get(getDates(substr($item->created_at, 0, 10)), 'hijri_date')}}
                                            </p>
								        </td>



								        <td class="v-align-middle wd-10p reportStatus-{{$item->id}}">
									        <p>{{ __('website.' . $item->status) }}</p>
                                        </td>



								        <td class="v-align-middle wd-15p optionAddHours">

                                        <a href="{{url(getLocal(). '/reportExportPDF/' . $item->id)}}">
                                        <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.download')}}">
										   <i class="material-icons showDitails">picture_as_pdf</i>
                                        </div>
                                    </a>

									  <a href="{{url(getLocal(). '/reports/' . $item->id)}}" class="addBill">
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
                            <p>{{__('website.are_you_sure_to_delete_this_reports')}}
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



<div class="modal fade slide-right" id="filterModalReports" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6> {{__('website.filter')}} </h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
					        <form id="reportFilterForm" action="javascript:avoid(0)" method="get">


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
								    <label> {{__('website.responsible_lawyer')}} </label>
								    <select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
								        <optgroup label="{{__('website.responsible_lawyer')}}">
								  	        <option value=""></option>
								  	        @if(isset(Auth::user()->office_employees))
                                            @foreach(Auth::user()->office_employees as $one)
									            <option value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
                                            @endif
								        </optgroup>
								    </select>
							    </div>



                                <div class="row">
								        <div class="col-md-6">
									        <div class="form-group form-group-default">
										        <label>{{__('website.from_date')}}</label>
                                                <input type="text" class="form-control hijri-date-input" id="from_date" name="from_date">
									        </div>
								        </div>
                                        <div class="col-md-6">
        								    <div class="form-group form-group-default">
        									    <label>{{__('website.to_date')}}</label>
                                                <input type="text" class="form-control hijri-date-input" id="to_date" name="to_date">
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

    /////////////////////// filter Tab Reports ////////////////////
    $(document).on('click','.filterTabReports',function(e){
        var status = $(this).data("action");
        $('.filterTabReports').removeClass('active');
        $(this).addClass('active');
        var url = "{{ url(app()->getLocale().'/reportFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                $(".reportRow").hide();
                $('.viewAllReports').append(response.reportFilter);
            }
        });
    });


    /////////////////////// filter Text Reports ////////////////////
    $(document).on('submit','#reportFilterText',function(e){
        var text = $('#textKey').val();
        var url = "{{ url(app()->getLocale().'/reportFilterText/') }}";

        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".reportRow").hide();
                $('.viewAllReports').append(response.reportFilter);
            }
        });
    });


    /////////////////////// filter Form Reports ////////////////////
    $(document).on('submit','#reportFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/reportFilterForm/') }}";
        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".reportRow").hide();

                $('#filterModalReports').fadeOut(500,function(){
                    $('#filterModalReports').modal('hide');
                });

                $('.viewAllReports').append(response.reportFilter);

                $("#filterModalReports #client_id").val('').select2();
                $("#filterModalReports #responsible_lawyer").val('').select2();
                $("#reportFilterForm").trigger("reset");

            }
        });
    });


});
</script>
@endsection
