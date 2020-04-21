@extends('layout.siteLayout')
@section('title', __('website.reports'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3"> {{__('website.edit')}} {{__('website.report')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/reports')}}'">
                        <i class="material-icons">delete_outline</i> <span> {{__('website.cancel')}} </span>
                    </button>
			   </div>

                <button id="saveAndNew" class="btn btn-complete has-icon mb-2 m-md-0">
                    <i class="material-icons">add</i> <span> {{__('website.save_and_add_new')}} </span>
                </button>
            </div>
		</div>
	</div>
</div>
@endsection


@section('content')

<div class="modal fade slide-right" id="ReportExpensesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
	    <div class="modal-content-wrapper">
		    <div class="modal-content">
			    <div class="modal-header mb-3">
					<h6>{{__('website.add_new_expense')}}</h6>
				</div>

				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
				    <div class="modal-body col-xs-height">

                        <form method="post" action="javascript:void(0)" id="createReportExpenses">
                            <input type="hidden" class="reportExpenseID" name="project_id" value="{{$item->project_id}}">

                            <div class="form-group form-group-default form-group-default-select2">
                                <label> {{__('website.expense_aspect')}} </label>
                                <select class="full-width" data-init-plugin="select2" id="aspect_expense_id" name="aspect_expense_id">
                                    <optgroup label="{{__('website.select_expense_aspect')}}">
                                        <option value=""></option>
                                        @if(isset($aspect_expense))
                                        @foreach($aspect_expense as $one)
                                            <option value="{{@$one->id}}">{{@$one->name}}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                            </div>

                            <div class="form-group form-group-default">
                                <label> {{__('website.expense_date')}} </label>
                                <input type="text" name="expense_date" class="form-control hijri-date-input" required>
                            </div>

                            <div class="form-group form-group-default">
                                <label> {{__('website.total_amount')}} </label>
                                <input type="text" class="form-control" id="total_amount" value="{{old('total_amount')}}"  required  name="total_amount">
                            </div>

                            <div class="form-group form-group-default form-group-default-select2">
                                <label> {{__('website.responsible_emp')}} </label>
                                <select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                                    <optgroup label="{{__('website.choose_emp_name')}}">
                                        <option value=""></option>
                                        @if(isset(Auth::user()->office_employees))
                                        @foreach(Auth::user()->office_employees as $one)
                                            <option value="{{@$one->id}}">{{@$one->name}}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-complete btn-block" id="newReportExpenses"> {{__('website.save')}} </button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade slide-right" id="ReportsHoursModel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h6>{{__('website.add_new_hours')}}</h6>
                </div>
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height">
                            <form method="post" action="javascript:void(0)" id="createReportHours">
                                <input type="hidden" class="reportProjectID" name="project_id" value="{{$item->project_id}}">

                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label> {{__('website.responsible_emp')}} </label>
                                    <select class="full-width responsible_lawyer_hours" data-init-plugin="select2" name="responsible_lawyer">
                                        <optgroup label="{{__('website.choose_responsible_emp')}}">
                                            <option value=""></option>
                                            @if(isset(Auth::user()->office_employees))
                                            @foreach(Auth::user()->office_employees as $one)
                                                <option data-id="{{@$one->hour_price}}"  value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default required">
                                            <label> {{__('website.hours_count')}} </label>
                                            <input type="number" name="hours_count" class="form-control hours_count" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label> {{__('website.range')}} </label>
                                            <input type="number" value="" disabled name="hour_price" class="form-control hour_price">
                                            <input type="hidden" value="" name="price" class="form-control hidden_hour_price">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-default hoursTotalAmount hidden">
                                    <label> {{__('website.total_amount')}} </label>
                                    <p class="form-control printHoursTotalAmount"></p>
                                </div>


                                <div class="form-group form-group-default">
                                    <label>  {{__('website.date')}} </label>
                                    <input type="text" class="form-control hijri-date-input" id="start_date" name="start_date" >
                                </div>


                                <div class="form-group form-group-default">
                                    <label> {{__('website.hours_details')}}</label>
                                    <textarea class="form-control" style="height:70px !important;" name="hour_details" id="hour_details"></textarea>
                                </div>
                                <div class="form-group form-group-default">
                                    <label> {{__('website.hours_office_details')}} </label>
                                    <textarea class="form-control" name="hour_office_details" style="height:70px !important;" id="hour_office_details"></textarea>
                                </div>
                                <button type="submit" class="btn btn-complete btn-block" id="newReportHours"> {{__('website.save')}} </button>
        						<button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade slide-right" id="ReportTasksModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h6>{{__('website.add_new_task')}}</h6>
                </div>
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height">

                            <form method="post" action="javascript:void(0)" id="createReportTasks">
                                <input type="hidden" class="reportTaskID" name="project_id" value="{{$item->project_id}}">
                                <input type="hidden" name="task_category" value="project">

                                <div class="form-group form-group-default">
                                    <label> {{__('website.task_name')}} </label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>

                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label>{{__('website.task_type')}}</label>
                                    <select class="full-width" data-init-plugin="select2" id="task_type_id" name="task_type_id">
                                        <optgroup label="{{__('website.select_task_type')}}">
                                            <option value=""></option>
                                            @if(isset(Auth::user()->office_task_types))
                                            @foreach(Auth::user()->office_task_types as $one)
                                                <option value="{{@$one->task_type_id}}">{{@$one->task_type->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label>{{__('website.task_employees')}}</label>
                                    <select class="full-width" data-init-plugin="select2" multiple id="task_employees[]" name="task_employees[]">
                                        <optgroup label="{{__('website.choose_emp_name')}}">
                                            @if(isset(Auth::user()->office_employees))
                                            @foreach(Auth::user()->office_employees as $one)
                                                <option value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group form-group-default">
                                    <label> {{__('website.task_end_date')}} </label>
                                    <input type="text" name="end_date" class="form-control hijri-date-input">
                                </div>


                                <div class="form-group mg-t-30">
                                    <div class="row row-xs">
                                        <div class="col-6">
                                            <div class="form-group form-group-default form-group-default-select2">
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
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group form-group-default form-group-default-select2 required">
                                                <label>{{__('website.priority')}}</label>
                                                <select class="full-width" data-init-plugin="select2" id="priority" name="priority">
                                                    <optgroup label="{{__('website.select_priority')}}">
                                                        <option value="normal">{{__('website.normal')}}</option>
                                                        <option value="urgent">{{__('website.urgent')}}</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group d-flex align-items-center">
                                    <label>{{__('website.reminder')}}</label>
                                    <div class="col-md-7">
                                        <div class="radio radio-success">
                                            <input type="radio" value="yes" name="remind" id="checkNotiModal">
                                            <label for="checkNotiModal"> {{__('website.reminder_about_task_time')}} </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="animated fadeIn delay-0.5s" id="typeNotiModal">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group form-group-default form-group-default-select2">
                                                <label>{{__('website.choose_reminder_type')}}</label>
                                                <select class="full-width" data-init-plugin="select2" id="remind_type" name="remind_type">
                                                    <optgroup label="{{__('website.choose_reminder_type')}}">
                                                        <option value=""></option>
                                                        <option value="email">{{__('website.email')}}</option>
                                                        <option value="window">{{__('website.window')}}</option>
                                                        <option value="whatsapp">{{__('website.whatsapp')}}</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group form-group-default form-group-default-select2">
                                                <label>{{__('website.period')}}</label>
                                                <select class="full-width" data-init-plugin="select2" id="remind_time_id" name="remind_time_id">
                                                    <optgroup label="{{__('website.choose_period')}}">
                                                        <option value=""></option>
                                                        @if(isset($reminer_time))
                                                        @foreach($reminer_time as $one)
                                                            <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                        @endforeach
                                                        @endif
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-complete btn-block" id="newProjectTasks"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="content">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/reports')}}">
                    {{__('website.reports')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.edit')}} {{__('website.report')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
			    <form action="{{url(app()->getLocale() . '/reports/' . $item->id)}}" method="post" id="editTaskForm" autocomplete="off" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}

                    <div class="card m-0 no-border">
                        <div class="card-header">
                            <h5>{{__('website.data')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8">

                                    <!--  User Details -->
                                    <div class="userDetails animated fadeIn delay-0.5s">

         	                            <div class="form-group mb-3 row">
                                	        <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.client_name')}}</label>
                                	        <div class="col-md-7">
                                    		    <div class="form-group form-group-default form-group-default-select2 required">
                                    			    <label>{{__('website.client_name')}}</label>
                                    				<select class="full-width reportClients" required name="client_id" id="client_id" data-init-plugin="select2">
                                    				    <optgroup label="{{__('website.choose_name')}}">
                                                            <option value=""></option>
                                                            @if(isset($clients))
                                    					    @foreach($clients as $one)
                                    						    <option {{($item->client_id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
                                    					    @endforeach
                                    					    @endif
                                    				    </optgroup>
                                    				</select>
                                    			</div>
                                    			@error('client_id')<span class="error"> {{ $message }} </span>@enderror
                                    		</div>
                                        </div>

                                        <div class="form-group mb-3 row selectProject">
                                        	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.project')}}</label>
                                        	<div class="col-md-7">
                                        		<div class="form-group form-group-default form-group-default-select2 required">
                                        			<label>{{__('website.select_project_name')}}</label>
                                        			<select class="full-width reportProjects" data-init-plugin="select2" id="project_id" required name="project_id">
                                        				<optgroup label="{{__('website.select_project_name')}}">
                                        					@if(isset($projects))
                                        					@foreach($projects as $one)
                                        						<option  {{($item->project_id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
                                        					@endforeach
                                        					@endif
                                        				</optgroup>
                                        			</select>
                                        		</div>
                                        	</div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.report_content')}} </label>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <div class="summernote-wrapper">
                                                        <!--<div class="summernote">محتوى التقرير</div>-->
                                                        <textarea class="form-control" name="report_content" id="report_content" placeholder="{{__('website.report_content')}}" required>{{@$item->report_content}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14"> <span>{{__('website.report_office_content')}}
                                            </span> <i class="material-icons iconHelp">help <small class="toolHelp">{{__('website.this_content_not_appear_report')}} </small></i></label>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <div class="summernote-wrapper">
                                                        <!--<div class="summernote">محتوى التقرير</div>-->
                                                        <textarea class="form-control" name="report_office_content" id="report_office_content" placeholder="{{__('website.report_office_content')}}" required>{{$item->report_office_content}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.next_date')}}</label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default required">
                                                    <label>{{__('website.next_date')}}</label>
                                                    <input type="text" class="form-control hijri-date-input" value="{{@$item->next_date}}" name="next_date" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.time')}}</label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default required">
                                                    <label>{{__('website.next_time')}}</label>
                                                    <input type="time" class="form-control next_time" name="next_time" value="{{@$item->next_time}}" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.appendix')}} </label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default">
                                                    <label>{{__('website.appendix')}}  </label>
                                                    <textarea class="form-control height80" name="appendix"> {{@$item->appendix}} </textarea>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                        	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.reports_outputs')}} </label>
                                        	<div class="col-md-7">
                                        		<div class="form-group form-group-default form-group-default-select2">
                                        			<label> {{__('website.reports_outputs')}} </label>
                                        			<select class="full-width" data-init-plugin="select2" name="reports_outputs[]" multiple>
                                        				<optgroup label="{{__('website.reports_outputs')}}">
                                        					<option value=""></option>
                                        					@if(isset($reports_outputs))
                                        					@foreach($reports_outputs as $one)
                                        						<option  value="{{@$one->id}}">{{@$one->name}}</option>
                                        					@endforeach
                                        					@endif
                                        				</optgroup>
                                        			</select>
                                        		</div>
                                        	</div>
                                        </div>
                                    </div>
                                    <!--  End User Details -->
                                </div>
                            </div>
                        </div>
                    </div>


					<!-- Div To Copy For Attach -->
					<!---------------------------------->
					<div class="hidden divToCopyForAttach">
						<div class="row attachments-row">
							<div class="col col-xs-12">
								<div class="form-group form-group-default  required">
									<label class="">{{__('website.attachment_name')}}</label>
									<input type="text" name="attachment_name[]" id="1"  class="form-control"/>
								</div>
							</div>

							<div class="col col-xs-12">
								<div class="form-group form-group-default uploadFileRequest required">
                                    <div class="input-file-container">
                                        <label class="input-file-trigger" tabindex="0" for="labelFor">
											<i class="fa fa-upload"></i> {{__('website.upload_file')}}
											<span>{{__('website.choose_file')}}</span>
                                        </label>
                                        <input type="file" class="uploadAttachFile"  id="" name="attachfile[]" size="40">
                                    </div>
                                </div>
							</div>

							<div class="col-auto">
								<div class="row-options clickToAddMoreAttach">
									<a href="#" class="btn btn-material btn-complete"><i class="material-icons">add</i></a>
                                </div>
							</div>
						</div>
					</div>


              <div class="card m-0 mt-4 no-border">
			        <div class="card no-border m-0">
                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
						    <div>
							    <h5>{{__('website.hours')}}</h5>
							</div>
							<div class="btn-group">
							    <button type="button" class="btn btn-complete has-icon mb-2 m-md-0" data-target="#ReportsHoursModel" data-id="" data-toggle="modal">
								    <i class="material-icons">add</i><span>{{__('website.add')}} {{__('website.hour')}}</span>
							    </button>
							</div>
						</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover tableWithSearch" id="tableWithSearch">
        						    <thead>
        							    <tr>
        							        <th class="wd-5p no-sort">
											    <div class="checkbox checkMain text-center">
												    {{-- <input type="checkbox" value="3" id="checkboxall" name="chkBox" class="chkBox"> --}}
													{{-- <label for="checkboxall" class="no-padding no-margin"></label> --}}
												</div>
										    </th>
        								    <th class="wd-30p">{{__('website.task')}}</th>
        								    <th class="wd-20p">{{__('website.hours')}}</th>
        									<th class="wd-15p">{{__('website.range')}}</th>
        									<th class="wd-15p">{{__('website.amount')}}</th>
        								</tr>
        							</thead>

        						    <tbody class="projectHours">
                                        @include('website.extraBlade.reports.editProjectHours')
        							</tbody>

        						</table>
                          	</div>
                        </div>
				    </div>
				</div>


                <div class="card m-0 mt-4 no-border">
				    <div class="card no-border m-0">
                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
						    <div>
							    <h5>{{__('website.expenses')}}</h5>
						    </div>
							<div class="btn-group">
							    <button type="button" class="btn btn-complete has-icon mb-2 m-md-0" data-target="#ReportExpensesModal" data-id="" data-toggle="modal">
								    <i class="material-icons">add</i><span>{{__('website.add')}} {{__('website.expense')}}</span>
								</button>
							</div>
						</div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover tableWithSearch" id="tableWithSearch">
        					        <thead>
        							    <tr>
        							        <th class="wd-5p no-sort">
											    <div class="checkbox checkMain text-center">
												    {{-- <input type="checkbox" value="3" id="checkboxall" name="chkBox" class="chkBox"> --}}
													{{-- <label for="checkboxall" class="no-padding no-margin"></label> --}}
												</div>
										    </th>
        								    <th class="wd-25p">{{__('website.expense_date')}}</th>
        								    <th class="wd-25p">{{__('website.expense_aspect')}}</th>
        								    <th class="wd-25p">{{__('website.recipient_name')}}</th>
        								    <th class="wd-20p">{{__('website.amount')}}</th>
        								</tr>
        							</thead>
        						    <tbody class="projectExpenses">
                                        @include('website.extraBlade.reports.editProjectExpenses')
        							</tbody>
        						</table>
                          	</div>
                        </div>
				    </div>
			    </div>


                <div class="card m-0 mt-4 no-border">
				    <div class="card no-border m-0">
                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
						    <div>
							    <h5>{{__('website.tasks')}}</h5>
							</div>
						    <div class="btn-group">
						        <button type="button" class="btn btn-complete has-icon mb-2 m-md-0" data-target="#ReportTasksModal" data-id="" data-toggle="modal">
						            <i class="material-icons">add</i><span>{{__('website.add_task')}}</span>
						        </button>
							</div>
					    </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover tableWithSearch" id="tableWithSearch">
        				            <thead>
        						        <tr>
        							        <th class="wd-5p no-sort">
											    <div class="checkbox checkMain text-center">
													{{-- <input type="checkbox" value="3" id="checkboxall" name="chkBox" class="chkBox"> --}}
													{{-- <label for="checkboxall" class="no-padding no-margin"></label> --}}
												</div>
										    </th>
        								    <th class="wd-25p">{{__('website.task_name')}}</th>
        							        <th class="wd-25p">{{__('website.responsible_emp')}}</th>
        							        <th class="wd-25p">{{__('website.delivery_date')}}</th>
        								    <th class="wd-20p">{{__('website.task_status')}}</th>
        								</tr>
        							</thead>
        							<tbody class="projectTasks">
                                        @include('website.extraBlade.reports.editProjectTasks')
        						    </tbody>
        						</table>
                          	</div>
                        </div>
				    </div>
			    </div>


                    <div class="card m-0 mt-4 no-border">
                        <div class="card-header">
                            <h5>{{__('website.attachments')}}</h5>
                        </div>
                        <div class="card-body pt-4 placeToAddMoreAttach">
                            @if(isset($item->attachments))
						    @foreach($item->attachments as $one)
                            <div class="row attachments-row">
    						    <div class="col col-xs-12">
    							    <div class="form-group form-group-default  required">
    								    <label class="">{{__('website.attachment_name')}}</label>
    									<input type="text" name="oldattachment_name{{$one->id}}" value="{{$one->attachment_name}}" id="1"  class="form-control"/>
    								</div>
    							</div>

    							<div class="col col-xs-12">
    							    <div class="form-group form-group-default uploadFileRequest required">
                                        <div class="input-file-container">
                                            <label tabindex="0" for="file-upload-1" class="input-file-trigger">
                                                <i class="fa fa-upload"></i> {{__('website.upload_file')}}
                                                <span>{{__('website.choose_file')}}</span>
                                            </label>
                                            <input type="file" id="file-upload-1" name="oldattachfile{{$one->id}}" size="40" >
                                        </div>
                                    </div>
    							</div>


    							<div class="col-auto">
    								<div class="row-options clickToRemove">
    									<a href="#" class="btn btn-default btn-material">
                                        <i class="material-icons">close</i>  </a>
    								</div>
    							</div>

							    <input type="hidden" name="oldattach_id[]" value="{{$one->id}}">
							    <input type="hidden" name="oldfile_uploaded{{$one->id}}" value="{{$one->getOriginal('file')}}">
						</div>
						@endforeach
						@endif

                        <div class="row attachments-row">
						    <div class="col col-xs-12">
								<div class="form-group form-group-default  required">
									<label class="">{{__('website.attachment_name')}}</label>
									<input type="text" name="attachment_name[]" id="2"  class="form-control"/>
								</div>
							</div>

							<div class="col col-xs-12">
								<div class="form-group form-group-default uploadFileRequest required">
                                    <div class="input-file-container">
                                        <label tabindex="0" for="file-upload-2" class="input-file-trigger">
                                            <i class="fa fa-upload"></i> {{__('website.upload_file')}}
                                            <span>{{__('website.choose_file')}}</span>
                                        </label>
                                        <input type="file" id="file-upload-2" name="attachfile[]" size="40" >
                                    </div>
                                </div>
							</div>

							<div class="col-auto">
								<div class="row-options clickToAddMoreAttach">
									<a href="#" class="btn btn-material btn-complete"><i class="material-icons">add</i></a>
                                </div>
							</div>
						</div>
                    </div>
                </div>
                <button type="submit" id="storeNewClient" style="display:none"></button>
                <input type="hidden" name="saveway" id="saveWay" value="0">
            </form>
        </div>
    </div>
</div>
</div>
@endsection




@section('js')


<script>

$(document).ready(function(){


/////////////////////// View Cities ////////////////////
$(document).on('change','.reportProjects',function(){
	var project_id = $(this).val();

	$(".reportProjectID").val(project_id);
	$(".reportExpenseID").val(project_id);
	$(".reportTaskID").val(project_id);

    var url = "{{ url(app()->getLocale().'/getProjectHoExTa/') }}";

      if(project_id){
        $.ajax({
          type: "GET",
          url: url+'/'+project_id,
          success: function (response) {
              if(response.status = 'true')
              {
                  $('.projectHours').html(response.projectHours);
                  $('.projectExpenses').html(response.projectExpenses);
                  $('.projectTasks').html(response.projectTasks);

              }
          }
        });
      }
      else{
        //$(".invoiceProjects").empty();
      }

});





	/////////////// Choose Client From Invoice Page ///////////////
		if($(".reportClients").val() != ''){
			$('.reportClients').change();
		}


/////////////////////// View Cities ////////////////////
$(document).on('change','.reportClients',function(e){
    var client_id = $(this).val();
    var url = "{{ url(app()->getLocale().'/getClientProjects/') }}";

      if(client_id){
        $.ajax({
          type: "GET",
          url: url+'/'+client_id,
          success: function (response) {
              if(response)
              {
                $(".reportProjects").empty();
                $(".reportProjects").append('<optgroup label="{{__('website.select_project_name')}}">');
				$(".reportProjects").append('<option value=""></option>');
                $.each(response, function(index, value){
                  $(".reportProjects").append('<option value="'+value.id+'">'+ value.name +'</option>');
                  $(".reportProjects").append('</optgroup>');
                });
              }
          }
        });
      }
      else{
        $(".invoiceProjects").empty();
      }
});




        var task_category = "{{$item->task_category}}";

        if(task_category == 'project'){
            $('#selectProject').removeClass("hidden");
            $('#projectCategory').click();
        }



		//////////////////  Add More Or Delete One Attach //////////////////
		var newAttachID = 3;

$(document).on('click','.clickToAddMoreAttach',function(e){
	var $newAttach = $('.divToCopyForAttach').html();
	$('.placeToAddMoreAttach').append($newAttach);
	$('.placeToAddMoreAttach .row:last-child').find('select').attr('id','attachtype_id'+newAttachID);
	$('.placeToAddMoreAttach .row:last-child').find('input[type="file"]').attr('id','file-upload-'+newAttachID);
	$('.placeToAddMoreAttach .row:last-child').find('input[type="file"]').prev().attr('for','file-upload-'+newAttachID);
	$('.placeToAddMoreAttach .row:last-child').find('span').attr('for','file-upload-'+newAttachID);

	newAttachID++;

	$(this).html('<a href="#" class="btn btn-default btn-material" > <i class="material-icons">close</i></a>');
	$(this).addClass('clickToRemove').removeClass('clickToAddMoreAttach');
	$('.placeToAddMoreAttach .row:last-child').find('select').select2();
// 	$("html, body").animate({ scrollTop: "300px" });

});


$(document).on('click','.clickToRemove',function(e){
	$(this).parent().parent().fadeOut(700,function(){$(this).remove();});
});

/////////////////  End Add More Or Delete One Attach ////////////////







	/////////////////////////  Upload Attach File ////////////////////////
	$(document).on('change','.uploadAttachFile',function(e){
		var attachFile = $(this).val();
		$(this).prev().find('span').text(attachFile);
	});
	/////////////////////// End Upload Attach File //////////////////////




    ///////////////////////// Save And Add New One ///////////////////////
    $(document).on('click', '#saveAndNew', function(){
        $('#saveWay').val(1);
        $('#storeNewClient').click();
    });
    /////////////////////// End Save And Add New One /////////////////////

    /////////////////////////// Save And Done /////////////////////////
        $(document).on('click', '#saveDone', function(){
        $('#saveWay').val(0);
        $('#storeNewClient').click();
    });
    ///////////////////////// End Save And Done ///////////////////////

});



	////////////////////////////////////////////////  Validation /////////////////////////////////////////
      $('#newTaskForm').validate({
			messages:{
				name: "{{__('website.required_field')}}",
				project_id: "{{__('website.required_field')}}",

				task_category_id: "{{__('website.required_field')}}",
				task_type_id: "{{__('website.required_field')}}",

				details: "{{__('website.required_field')}}",
				task_status_id: "{{__('website.required_field')}}",
				priority: "{{__('website.required_field')}}",

				end_date: "{{__('website.required_field')}}",
				workgroup_id: "{{__('website.required_field')}}",
				responsible_employee: "{{__('website.required_field')}}",


			}
	  });

	////////////////////////////////////////////// End Validation ///////////////////////////////////////
</script>



<script>
	    $(document).on('click','#caseForClick',function(e){
		  $('.secCase,.secConsultation').hide();
		  $('.secCase').show();
	  	});
	  	$(document).on('click','#ConsultationForClick',function(e){
		  $('.secCase,.secConsultation').hide();
		  $('.secConsultation').show();
	  	});






		$(document).on('click','#checkNoti',function(e){
		  $('#typeNoti').show();
		  });



		$(document).on('click','#checkNotiModal',function(e){
		  $('#typeNotiModal').show();
	  	});



		$(document).on('change','#NumberofHours',function(e){
		  $('#NumberofHoursOne').hide();
		  ($(this).val() == 2)? $('#NumberofHoursOne').show():"";
		  ($(this).val() == 1)? $('#NumberofHoursOne').hide():"";
	  	});
	</script>

@endsection
