@extends('layout.siteLayout')

@section('title', __('website.reports'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{@$item->project->name}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/sendReportToClient/'. $item->id)}}'">
				        <i class="material-icons">send</i><span>{{__('website.send')}}</span>
					</button>

					<button type="button" class="btn btn-default  has-icon " data-target="#previwPDF" data-toggle="modal">
				        <i class="material-icons">picture_as_pdf</i> <span>{{__('website.Preview')}}</span>
				    </button>

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/reports/' . $item->id . '/edit')}}'">
                        <i class="material-icons">edit</i><span>{{__('website.edit')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" data-target="#modalSlideLeft" data-toggle="modal">
					    <i class="material-icons">close</i> <span>{{__('website.delete')}}</span>
				    </button>

                </div>

                <div class="btn-group m-l-20">
		            <select class="btn-default buttonTypeTask has-icon mb-2 m-md-0" name="slct" >
						<option selected disabled>{{__('website.change_status')}} </option>
						<option value="1">{{__('website.draft')}}</option>
						<option value="2">{{__('website.completed')}}</option>
					</select>
				</div>

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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/reports')}}">
                    {{__('website.reports')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.data')}} {{__('website.reports')}}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row no-gutters dashboard-no-gutters mt-4 taskDetailsDiv">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active" data-toggle="tab" role="tab" data-target="#reportData" href="#">
                            {{__('website.data')}} {{__('website.reports')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#reportHours">{{__('website.hours')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#reportExpenses">{{__('website.expenses')}}</a>
                    </li>
                     <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#reportTasks">{{__('website.tasks')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#attchTask">{{__('website.attachments')}}</a>
                    </li>
                </ul>

                <div class="tab-content bg-white">
                    <div class="tab-pane active" id="reportData">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class=" card no-border m-0 ">
                                <div class="card-header ">
                                    <h3 class="text-success justify-content-between d-flex align-items-center">
                                        {{__('website.reports')}} {{__('website.data')}}
                                    </h3>
                                </div>

                                <div class="card-body no-padding">
                                    <div class="card no-border m-0">
                                        <div class="card-body pb-1">
                                            <div class="row dashboard-no-gutters">
                								<div class="col-lg-6 secDataProject">
                                                    <p>
                                                        <strong>{{__('website.project')}}</strong>
                                                        <span>{{@$item->project->name}}</span>
                                                    </p>

                                                      <p>
                                                        <strong>{{__('website.task')}}</strong>
                                                        <span> {{@$item->task->name}}</span>
                                                    </p>

                                                    <p>
                                                        <strong>{{__('website.project_name')}}</strong>
                                                        <span>
                                                            @if(isset($item->project_id))
                                                                <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}">
                                                                    {{@$item->project->name}}
                                                                </a>
                                                            @endif
                                                        </span>
                                                </p>
                                                </div>

                								<div class="col-lg-6 secDataProject">
                								    <p>
                                                        <strong>{{__('website.hours_count')}}</strong>
                                                        <span> {{ $report_hours_count }} </span>
                                                    </p>

                                                    <p>
                                                        <strong>{{__('website.status')}}</strong>
                                                        <span> {{ __('website.' . $item->status) }} </span>
                                                    </p>

                                                    <p>
                                                        <strong>{{__('website.date')}}</strong>
                                                        <span>
                                                            {{Arr::get(getDates(substr($item->created_at, 0, 10)), 'hijri_date')}}
                                                        </span>
                                                    </p>

                                                    @if(isset($item->next_date))
                                                        <p>
                                                            <strong>{{__('website.next_date')}}</strong><span>
                                                            {{Arr::get(getDates(substr($item->next_date, 0, 10)), 'hijri_date')}}
                                                            </span>
                                                        </p>

                                                        <p>
                                                            <strong>{{__('website.time')}}</strong><span>{{@$item->next_time}}</span>
                                                        </p>
                                                    @endif
                                                </div>

                                                <div class="col-lg-12 secDataProject">
                                                </div>


                								<div class="col-lg-12 secDataProject">
                									<p><strong> {{__('website.report_content')}}</strong>
                									<span>{{@$item->report_content}}</span></p>
                								</div>


                                                <div class="col-lg-12 secDataProject">
                									<p><strong>   {{__('website.report_office_content')}}</strong>
                									<span>{{@$item->report_office_content}}</span></p>
                								</div>
                						    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="reportHours">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card-body p-0">
                        		<div class="table-responsive allHours">
                            	    <table class="table table-hover tableWithSearch allHours" id="tableWithSearch">
        							    <thead>
        									<tr>
        									    <th class="wd-5p no-sort">
        										    <div class="checkbox checkMain text-center">#</div>
        									    </th>
                                                <th class="wd-30p">{{__('website.task')}}</th>
        									    <th class="wd-20p">{{__('website.hours_count')}}</th>
        									    <th class="wd-15p"> {{__('website.amount')}} </th>
        									    <th class="wd-15p">{{__('website.total_amount')}}</th>
        									</tr>
                                        </thead>

                                        <tbody>
                                        @if(isset($item->reportHours))
                                        @foreach($item->reportHours as $one)
        									<tr>
        									    <td class="wd-5p no-sort">
        										    <div class="checkbox checkMain text-center">{{$loop->iteration}}</div>
        									    </td>
                                                <td class="wd-30p">@if(isset($one->hour->task_id)) {{@$one->hour->task->name}} @endif</td>
        									    <td class="wd-20p">{{@$one->hour->hours_count}}</td>
        									    <td class="wd-15p"> {{@$one->hour->price}} </td>
        									    <td class="wd-15p">{{@$one->hour->hours_count*$one->hour->price}}</td>
        									</tr>
                                            @endforeach
                                        @endif

                                        </tbody>
        							</table>
                          		</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="reportExpenses">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card-body p-0 ">
                        		<div class="table-responsive">
                            		<table class="table table-hover tableWithSearch" id="tableWithSearch">
        								<thead>
        									<tr>
        									    <th class="wd-5p no-sort">
        										    <div class="checkbox checkMain text-center">#</div>
        									    </th>
                                                <th class="wd-15p" >{{__('website.expense_date')}}</th>
                                                <th class="wd-40p" > {{__('website.expense_aspect')}}  </th>
                                                <th class="wd-10p" >{{__('website.recipient_name')}} </th>
                                                <th class="wd-15p" >{{__('website.amount')}}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                           @if(isset($item->reportExpenses))
        								   @foreach($item->reportExpenses as $one)
        									<tr>
        									    <td class="wd-5p no-sort">
        										    <div class="checkbox checkMain text-center">{{$loop->iteration}}</div>
        									    </td>
                                            <td class="v-align-middle wd-25p">

                                                {{Arr::get(getDates(substr($one->expense->expense_date, 0, 10)), 'hijri_date')}}
                                            </td>
                                            <td class="v-align-middle wd-25p"> {{@$one->expense->aspect_expense->name}} </td>
                                            <td class="v-align-middle wd-25p"> {{@$one->expense->employee->name}} </td>
                                            <td class="v-align-middle wd-20p"> {{@$one->expense->total_amount}} </td>
        									</tr>
                                            @endforeach
                                            @endif
        							  </tbody>
        							</table>
                          		</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="reportTasks">
                            <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                                <div class="card-body p-0">
                        		    <div class="table-responsive allHours">
                            		    <table class="table table-hover tableWithSearch allHours" id="tableWithSearch">
        								    <thead>
        									    <tr>
        									        <th class="wd-5p no-sort">
        										        <div class="checkbox checkMain text-center">#</div>
        									        </th>
                                                    <th class="wd-35p">{{__('website.task')}}</th>
        									        <th class="wd-30p">{{__('website.responsible_emp')}}</th>
        									        <th class="wd-15p"> {{__('website.end_date')}} </th>
        									        <th class="wd-15p">{{__('website.status')}}</th>
        									    </tr>
                                            </thead>
                                            
                                            <tbody>

                 	                        @if(isset($item->reportTasks))
                 	                        @foreach($item->reportTasks as $one)
                 	                        <tr>
                 	                            <td class="wd-5p no-sort">
        										    <div class="checkbox checkMain text-center">{{$loop->iteration}}</div>
        									    </td>
        							            <td class="v-align-middle wd-35p"> {{@$one->task->name}} </td>
                                                <td class="v-align-middle wd-30p"> @if(isset($one->task->employee_id)) {{@$one->task->employee->name}} @endif </td>
                                                <td class="v-align-middle wd-15p">
                                                    {{Arr::get(getDates(substr($one->task->end_date, 0, 10)), 'hijri_date')}}
                                                </td>
                                                <td class="v-align-middle wd-15p"> {{@$one->task->task_status->name}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
        							    </tbody>
        							</table>
                          		</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="attchTask">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card-body p-0">
                        		<div class="table-responsive">
                            		<table class="table table-hover tableWithSearch" id="tableWithSearch">
        								<thead>
        								    <tr>
        									    <th class="wd-5p no-sort">
        										    <div class="checkbox checkMain text-center">#</div>
        									    </th>
                                                <th class="wd-75p">{{__('website.attachment_name')}}</th>
                                                <th class="wd-20p no-sort "></th>
                                            </tr>
        								</thead>

                                        <tbody>
                                            @if(isset($item->attachments))
                                            @foreach($item->attachments as $one)
                                            <tr>
                                                <td class="v-align-middle wd-5p">
                                                    <div class="checkbox checkMain text-center"> 1 </div>
                                                </td>
                                                <td class="v-align-middle wd-75p">
                                                    <a href="">{{@$one->attachment_name}}</a>
                                                </td>
                                                <td class="v-align-middle wd-20p text-center">
                                                    <a href="{{@$one->file}}" target="_blank"><i class="material-icons">visibility</i></a>
                                                </td>
                                            </tr>
                                            @endforeach
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
				<div class="modal-body col-xs-height  ">
                <form id="formCalendar11" method="post" action="{{url(app()->getLocale().'/clients/note_note')}}" >
                    {{csrf_field()}}
                    <input type="hidden" name="note_id" value="">
                    <div class="form-group form-group-default required">
                        <label>{{__('website.write_note')}}</label>
                        <input type="text" class="form-control" id="note" name="note">
                    </div>
                    <div class="form-group form-group-default required">
                        <label>{{__('website.date')}}</label>
                        <input type="text" class="input-sm form-control hijri-date-input" name="note_date"  autocomplete="off" />
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
				<div class="modal-body col-xs-height  ">
                <form id="formCalendar11" method="post" action="{{url(app()->getLocale().'/clients/create_note')}}" >
                    {{csrf_field()}}
                    <input type="hidden" name="client_id" value="{{$item->id}}">
					<div class="form-group form-group-default required">
						<label>{{__('website.write_note')}}</label>
						<input type="text" class="form-control" id="note" name="note">
					</div>
					<div class="form-group form-group-default required">
						<label>{{__('website.date')}}</label>
						<input type="text" class="input-sm form-control hijri-date-input" name="note_date" autocomplete="off" />
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



<!--  modal-->
<div class="modal fade slide-right" id="modalToDeleteNote" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.are_you_sure_to_delete_this_note')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5>
                            <br>
                            <button type="button" class="btn btn-danger btn-block deleteNote"
                            data-dismiss="modal" data-id="0"  data-action="delete">{{__('website.agree')}}</button>
                            <button type="button" class="btn btn-default btn-block"
                            data-dismiss="modal">{{__('website.cancel')}}</button>
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
                    <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.are_you_sure_to_delete_this_reports')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5>
                            <br>
                            <button type="button" class="btn btn-danger btn-block confirmAll deleteReportFromDetPage"
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


	<div class="modal fade fill-in" id="previwPDF" tabindex="-1" role="dialog" aria-hidden="true">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
			<i class="material-icons">close</i>
		</button>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="page-container ">
					<div class="page-content-wrapper ">
						<div class="content ">
							<div class=" container-fluid ">
								<div class="row no-gutters dashboard-no-gutters mt-4">
									<div class="card card-default m-t-20">
										<div class="card-body">
											<div class="invoice padding-50 sm-padding-10">
												<div>
													<div class="pull-left">
														<img width="150" height="47" alt="" class="invoice-logo" data-src-retina="assets/img/logo.svg" data-src="assets/img/logo.svg" src="assets/img/logo.svg">
														<address class="m-t-10">
															{{@$item->client->address}}
														</address>
													</div>
													<div class="pull-right sm-m-t-20">
														<h6 class="bold">{{__('website.report')}} {{__('website.project')}} {{@$item->project->name}}</h6>
													</div>
													<div class="clearfix"></div>
												</div>
												<br>
												<br>
												<div class="col-12">
													<div class="row">
														<!--<div class="col-lg-9 col-sm-height sm-no-padding">-->
														<!--	<h6 class="bold fs-13 no-margin">المحكمة : <span class="small fs-12 no-margin">ديوان المظالم</span> </h6>-->
														<!--	<h6 class="bold fs-13 no-margin">المدعي : <span class="small fs-12 no-margin">محمد حسن الهاشي</span> / الوكيل <span class="small fs-12 no-margin">"أحمد حسن الهاشي"</span> </h6>-->
														<!--	<h6 class="bold fs-13 no-margin">المدعي عليه : <span class="small fs-12 no-margin">شركة بكري احسان للمقاولات</span>  / الوكيل <span class="small fs-12 no-margin">"سالم الهاجري"</span> </h6>-->

														<!--</div>-->
														<div class="col-lg-3 sm-no-padding sm-p-b-20 d-flex align-items-end justify-content-between">
															<div>
																<div class="bold all-caps">{{__('website.reportID')}} :</div>
																<div class="bold all-caps">{{__('website.reportDate')}} :</div>
																<div class="bold all-caps">{{__('website.sessionDate')}}  :</div>
																<div class="bold all-caps">{{__('website.time')}} :</div>
																<div class="clearfix"></div>
															</div>
															<div class="text-left">
																<div class="">{{@$item->id}}</div>
                                                                <div class="fs-13">
                                                                    {{Arr::get(getDates(substr($item->created_at, 0, 10)), 'hijri_date')}}
                                                                </div>
																<div class="fs-13">

                                                                    {{Arr::get(getDates(substr($item->next_date, 0, 10)), 'hijri_date')}}
                                                                </div>
																<div class="">{{@$item->next_time}}</div>
																<div class="clearfix"></div>
															</div>
														</div>
													</div>
												</div>
												<br>
												<br>
												<div class="col-12">
													<h5>{{__('website.the_facts')}}</h5>
													<p>{{@$item->report_content}}</p>
												</div>
												<br>
												<br>



				@if(isset($item->reportHours) && (in_array(3 ,$item->report_outputs) || in_array(1 ,$item->report_outputs)))

                   <div class="table-responsive table-invoice">
                    <table class="table m-t-50">
                      <thead class="">
                        <tr>
                          <th class="p-b-10">{{__('website.hours')}}</th>
                          <th class="text-center p-b-10">{{__('website.range')}}</th>
                          <th class="text-center p-b-10">{{__('website.date')}}</th>
                          <th class="text-right p-b-10">{{__('website.amount')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($item->reportHours as $one)
                        <tr>
                          <td class="">
                            <p class="text-black"> {{$one->hour->hours_count}} </p>
                          </td>
                          <td class="text-center">{{$one->hour->price}} {{__('website.r_s')}}</td>
                          <td class="text-center">
                            {{Arr::get(getDates(substr($one->hour->start_date, 0, 10)), 'hijri_date')}}
                        </td>
                          <td class="text-right">{{($one->hour->hours_count*$one->hour->price)}} {{__('website.r_s')}}</td>
                        </tr>

              @endforeach
                      </tbody>
                    </table>
                  </div>
                  @endif


                  @if(isset($item->reportExpenses) && count($item->reportExpenses) >= 1 && (in_array(4 ,$item->report_outputs) || in_array(1 ,$item->report_outputs)))
                  <div class="table-responsive table-invoice">
                    <table class="table m-t-50">
                      <thead class="">
                        <tr>
                          <th class="p-b-10">{{__('website.expenses')}}</th>
                          <th class="text-center p-b-10">{{__('website.expense_date')}}</th>
                          <th class="text-center p-b-10">{{__('website.recipient_name')}}</th>
                          <th class="text-right p-b-10">{{__('website.amount')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($item->reportExpenses as $one)
                        <tr>
                          <td class=""><p>{{@$one->expense->aspect_expense->name}} </p></td>
                          <td class="text-center">
                            {{Arr::get(getDates(substr($one->expense->expense_date, 0, 10)), 'hijri_date')}}
                        </td>
                          <td class="text-center">{{@$one->expense->employee->name}}</td>
                          <td class="text-right">{{(@$one->expense->total_amount)}} {{__('website.r_s')}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @endif




                  @if(isset($item->reportTasks) && (in_array(6 ,$item->report_outputs) || in_array(1 ,$item->report_outputs)))
                  <div class="table-responsive table-invoice">
                    <table class="table m-t-50">
                      <thead class="">
                        <tr>
                          <th class="p-b-10">{{__('website.tasks')}}</th>
                          <th class="text-center p-b-10">{{__('website.date')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($item->reportTasks as $one)
                        <tr>
                          <td class=""><p>{{@$one->task->name}} </p></td>
                          <td class="text-center">
                            {{Arr::get(getDates(substr($one->task->end_date, 0, 10)), 'hijri_date')}}
                        </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @endif


												<br>
												<br>
												<div class="p-l-15 p-r-15">
													<div class="row b-a b-grey p-4">
														<div class="col-md-4 p-l-15 sm-p-t-15 clearfix sm-p-b-15 d-flex flex-column justify-content-center">
															<h5 class="all-caps small no-margin hint-text bold">{{__('website.next_session_date')}}</h5>
                                                            <h6 class="no-margin">
                                                                {{Arr::get(getDates(substr($item->next_date, 0, 10)), 'hijri_date')}}
                                                            </h6>
														</div>
														<div class="col-md-3 clearfix sm-p-b-15 d-flex flex-column justify-content-center">
															<h5 class="all-caps small no-margin hint-text bold">{{__('website.time')}}</h5>
                                                            <h6 class="no-margin">{{@$item->next_time}}
                                                            </h6>
														</div>
														<div class="col-md-5 clearfix sm-p-b-15 d-flex flex-column justify-content-center">
															<!--<h5 class="all-caps small no-margin hint-text bold">الطلبات</h5>-->
															<!--<p class="no-margin">إفادة من المكتب الموكل لطلب تسجيل القيمة في دائرة الأحوال المدنية</p>-->
														</div>
													</div>
												</div>
												<br>
												<br>
												<br>
												<br>
												<br>
												<div>
													<img width="150" height="58" alt="" class="invoice-signature"
													data-src-retina="{{url('assets/img/signature2x.png')}}"
													data-src="{{url('assets/img/signature2x.png')}}"
													src="{{url('assets/img/signature2x.png')}}">
													<p>{{__('website.office_signature')}}</p>
												</div>
												<hr>
												<!--<p class="small hint-text">نحيطكم علماً أن الفاتورة هي إستحقاق للمكتب يجب عليكم الإلتزام في دفع الفاتورة حتى تاريخ الإستحقاق</p>-->
												<br>
												<hr>
												<div>
													<img src="{{url('assets/img/logo.svg')}}" alt="logo"
													data-src="{{url('assets/img/logo.svg')}}"
													data-src-retina="{{url('assets/img/logo.svg')}}" width="78" height="34">
													<span class="m-r-40 text-black sm-pull-right">+34 346 4546 445</span>
													<span class="m-r-40 text-black sm-pull-right">support@hexacit.com</span>
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
	</div>


@endsection
