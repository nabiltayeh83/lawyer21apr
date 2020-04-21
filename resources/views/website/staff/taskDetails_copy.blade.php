@extends('layout.siteLayout')

@section('title', __('website.clients'))


@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{$item->name}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon completeTask" data-id="{{$item->id}}">
                        <i class="material-icons">check</i><span>{{__('website.complete_it')}}</span>
                    </button>

                    <button type="button" class="btn btn-default  has-icon">
                        <i class="material-icons">edit</i><span><a href="{{url(getLocal(). '/tasks/' . $item->id . '/edit')}}">{{__('website.edit')}}</a></span>
                    </button>

                </div>

                <div class="btn-group m-l-20">
					<select class="btn-default buttonTypeTask has-icon mb-2 m-md-0" name="slct" id="changeTaskStatus" name="changeTaskStatus" data-id="{{$item->id}}">
						<option selected disabled>{{__('website.change_status')}}</option>
					    @foreach($task_status as $one)
						    <option value="{{$one->id}}">{{$one->name}}</option>
                        @endforeach
                    </select>
				</div>

				<a data-target="#modalAddHours" data-toggle="modal">
					<button class="btn btn-complete has-icon mb-2 m-md-0">
                        <i class="material-icons">add</i><span>{{__('website.add_hours')}}</span>
					  </button>
			    </a>
				<a href="addReports.html">
					<button class="btn btn-complete has-icon mb-2 m-md-0">
						<i class="material-icons">add</i><span>{{__('website.add_report')}}</span>
					</button>
                </a>

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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/tasks')}}">
                    {{__('website.tasks')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.task_data')}}</li>
            </ol>
        </div>
    </div>

    <div class=" container-fluid ">

        <div class="row no-gutters dashboard-no-gutters mt-4 taskDetailsDiv">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active" data-toggle="tab" role="tab" data-target="#dataTask" href="#">
                            {{__('website.task_data')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#hoursTask">{{__('website.task_hours')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#reportsTask">{{__('website.task_reports')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#attchTask">{{__('website.task_attachments')}}</a>
                    </li>
                </ul>

                <div class="tab-content bg-white">
                    <div class="tab-pane active" id="dataTask">
                        <div class="col-lg-12 col-xl-12 col-md-12  d-flex">
                            <div class=" card no-border m-0 ">
                                <div class="card-header ">
                                    <h3 class="text-success justify-content-between d-flex align-items-center">
                                        {{__('website.task_data')}}
                                    </h3>
                                </div>

                                <div class="card-body no-padding">
                                    <div class="card no-border m-0">
                                        <div class="card-body pb-1">
                                            <div class="row dashboard-no-gutters ">
                								<div class="col-lg-6 secDataProject">
                                                    <p>
                                                        <strong>{{__('website.task_status')}}</strong>
                                                        <span class="taskStatus-{{$item->id}}"> {{$item->task_status->name}}</span>
                                                    </p>

                                                    <p>
                                                        <strong>{{__('website.task_type')}}</strong>
                                                        <span>{{$item->task_type->name}}</span>
                                                    </p>

                                                    <p>
                                                        <strong>{{__('website.project_name')}}</strong>
                                                        <span>
                                                            @if($item->project_id)
                                                                <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}">
                                                                    {{$item->project->name}}
                                                                </a>
                                                            @endif
                                                        </span>
                                                </p>
                                                </div>

                								<div class="col-lg-6 secDataProject">
                                                    <p>
                                                        <strong>{{__('website.priority')}}</strong>
                                                        <span>{{__('website.'.$item->priority)}} </span>
                                                    </p>

                                                    <p>
                                                        <strong>{{__('website.task_deliver_date')}}</strong>
                                                        <span>{{$item->end_date}}</span>
                                                    </p>

                                                    <p>
                                                        <strong>{{__('website.task_manager_name')}}</strong>
                                                        <span>
                                                            @if($item->responsible_employee)
                                                                <p>{{$item->employee->name}}</p>
                                                            @endif
                                                        </span>
                                                </p>
                                                </div>


                                                <div class="col-lg-12 secDataProject">

                                                @if(count($item->employees) >= 1)
                                                <div class="col-lg-12 secDataProject">
                                                    <p><strong>{{__('website.task_employees')}}</strong><span>
                                                        @foreach ($item->employees as $one)
                                                           {{$loop->iteration}} - {{$one->user->name}} <br>
                                                        @endforeach
                                                  </div>
                                                  @endif

                                                </div>


                								<div class="col-lg-12 secDataProject">
                									<p><strong>{{__('website.task_details')}}</strong><span>{{$item->details}}</span></p>
                								</div>
                						    </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                               </div>
                          </div>
                          <div class="tab-pane " id="hoursTask">
                            <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                              <div class="card-body p-0 ">
                        		<div class="table-responsive allHours">
                            		<table class="table table-hover tableWithSearch allHours" id="tableWithSearch">
        								<thead>
        									<tr>
        									    <th class="wd-5p no-sort">
        										    <div class="checkbox checkMain text-center">#</div>
        									    </th>
                                                <th class="wd-30p">{{__('website.title')}}</th>
        									    <th class="wd-20p">{{__('website.responsible_emp')}}</th>
        									    <th class="wd-15p"> {{__('website.hours_count')}} </th>
        									    <th class="wd-15p">{{__('website.date')}}</th>
        									</tr>
                                        </thead>

                                        <tbody>
                                            @foreach($item->hours as $one)
                                                <tr>
        								            <td class="v-align-middle wd-5p">
                                                        <div class="checkbox checkMain text-center">
                                                            {{$loop->iteration}}
                                                        </div>
        								            </td>
        								            <td class="v-align-middle wd-20p">
                                                        <a href="{{url(getLocal(). '/hours/' . $one->id)}}">{{$one->task->name}}</a>
        								            </td>
        								            <td class="v-align-middle wd-20p">
                                                        {{$one->employee->name}}
                                                    </td>
        								            <td class="v-align-middle wd-15p">
                                                        <p>{{$one->hours_count}}</p>
                                                    </td>
                                                    <td class="v-align-middle wd-15p">
                                                        <p>{{$one->start_date}}</p>
                                                  </td>
                                                </tr>
                                            @endforeach
        							    </tbody>
        							</table>
                          		</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="reportsTask">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card-body p-0 ">
                        		<div class="table-responsive">
                            		<table class="table table-hover tableWithSearch" id="tableWithSearch">
        								<thead>
        									<tr>
        									    <th class="wd-5p no-sort">
        										    <div class="checkbox checkMain text-center">#</div>
        									    </th>
                                                <th class="wd-15p" >{{__('website.report_title')}}</th>
                                                <th class="wd-40p" >{{__('website.report_content')}}</th>
                                                <th class="wd-10p" >{{__('website.report_status')}} </th>
                                                <th class="wd-15p" >{{__('website.date')}}</th>
                                                <th class="wd-15p" > {{__('website.hours_count')}}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
        								    <tr>
                                                <td class="v-align-middle wd-5p">
                                                    <div class="checkbox checkMain text-center"> 1 </div>
                                                </td>
                                                <td class="v-align-middle wd-15p">
                                                    <a href="">تبعيات اصدار قرار بشان الحصول على الرخصة الدولية</a>
                                                </td>
                                                <td class="v-align-middle wd-40p">
                                                    <a href="">هذا النص تجريبي لرؤية محتوى الصفحة من حيث الشكل والخروج النهائي للتصميم هذا النص تجريبي لرؤية محتوى الصفحة من حيث الشكل والخروج النهائي للتصميم هذا النص تجريبي لرؤية محتوى الصفحة من حيث الشكل والخروج النهائي للتصميم هذا النص تجريبي لرؤية محتوى الصفحة من حيث الشكل والخروج النهائي للتصميم</a>
                                                </td>
                                                <td class="v-align-middle wd-10p">
                                                    <p>مسودة</p>
                                                </td>
                                                <td class="v-align-middle wd-15p">
                                                    <p>11/09/2018</p>
                                                </td>
                                                <td class="v-align-middle wd-15p">
                                                    <p>18 ساعة</p>
                                                </td>
                                            </tr>
        							  </tbody>
        							</table>
                          		</div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="attchTask">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card-body p-0 ">
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
                                            @foreach($item->attachments as $one)
                                            <tr>
                                                <td class="v-align-middle wd-5p">
                                                    <div class="checkbox checkMain text-center"> 1 </div>
                                                </td>
                                                <td class="v-align-middle wd-75p">
                                                    <a href="">{{$one->attachment_name}}</a>
                                                </td>
                                                <td class="v-align-middle wd-20p text-center">
                                                    <a href="{{$one->file}}" target="_blank"><i class="material-icons">visibility</i></a>
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

<input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" name="chkBox" checked style="display:none;" />



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
                            <p>{{__('website.You_are_about_to_delete_the_client')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5>
                            <br>
                            <button type="button" class="btn btn-danger btn-block confirmAll deleteClientFromDetPage"
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




@endsection
