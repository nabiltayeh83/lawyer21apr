@extends('layout.siteLayout')
@section('title', __('website.expenses'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3"> @if($item->project_id) {{$item->project->name}} @endif </h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                
                     <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/expenseInvoice/' . $item->id )}}'">
                        <i class="material-icons">storage</i><span>{{__('website.Billing')}}</span>
                    </button>

                    @if($item->expense_status != 'certified')
                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/expenses/' . $item->id . '/edit')}}'">
                        <i class="material-icons">edit</i><span>{{__('website.edit')}}</span>
                    </button>
                    @endif

                    <button type="button" class="btn btn-default  has-icon" data-target="#modalSlideLeft" data-toggle="modal">
                        <i class="material-icons">close</i> <span>{{__('website.delete')}}</span>
                    </button>
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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/expenses')}}">{{__('website.expenses')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.expense_data')}}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row no-gutters dashboard-no-gutters mt-4">
            <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                <div class="card no-border m-0">
                    <div class="card-header"></div>
                    <div class="card-body no-padding p-b-15">
                        <div class="card no-border m-0">
                            <div class="card-body pb-1">
                                <div class="row dashboard-no-gutters">
                                    <div class="col-lg-6 secDataProject">

                                        @if($item->project_id)
                                        <p>
                                          <strong>{{__('website.project_name')}}</strong>
                                          <span><a href="{{url(getLocal(). '/projects/'. $item->project_id)}}">{{$item->project->name}}</a></span>
                                        </p>
                                        @endif

                                        <p>
                                          <strong>{{__('website.expense_aspect')}}</strong>
                                          <span>{{@$item->aspect_expense->name}}</span>
                                        </p>

                                        <p>
                                            <strong>{{__('website.responsible_emp')}}</strong>
                                            <span>
                                            @if($item->responsible_lawyer)
                                                {{@$item->employee->name}}
                                            @endif
                                            </span>
                                        </p>

                                        <p>
                                            <strong>{{__('website.status')}}</strong>
                                            <span>{{__('website.'.$item->expense_status)}}</span>
                                        </p>
                                    </div>

                                    <div class="col-lg-6 secDataProject">
                                        <p>
                                            <strong>{{__('website.reference_number')}}</strong>
                                            <span>{{@$item->reference_number}}</span>
                                        </p>

                                        <p>
                                          <strong>{{__('website.expense_date')}}</strong>
                                          <span>{{Arr::get(getDates(substr($item->expense_date, 0, 10)), 'hijri_date')}}</span>
                                        </p>

                                        <p>
                                          <strong>{{__('website.total_amount')}}</strong>
                                          <span>{{$item->total_amount}} {{__('website.r_s')}}</span>
                                        </p>
                                    </div>

                                    <div class="col-lg-12 secDataProject">
                                    <p>
                                        <strong>{{__('website.descriptipn')}}</strong>
                                        <span>{{@$item->expense_details}}</span>
                                    </p>

                                    <p>
                                        <strong>{{__('website.expense_office_details')}}</strong>
                                        <span>{{@$item->expense_office_details}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


	<div class="row no-gutters dashboard-no-gutters mt-4">
		<div class="col-lg-12 col-xl-12 col-md-12 d-flex">
            <div class="card no-border m-0 sectionAttachments">
                <div class="card-header">
                    <h3 class="text-success justify-content-between d-flex align-items-center">
                        <span>{{__('website.attachments')}}</span>
                    </h3>
                </div>

                <div class="headBoxAttachment boxAttachment">
					<div class="boxAttach">
						<p>{{__('website.attachment_name')}}</p>
					</div>
					<div class="boxAttach"><p></p></div>
                </div>

                <div class="card no-border m-0">
                    <div class="card-body pb-1 divAttachments">
                        <div class="cleintAttachment AttachsFiles">

                        @if(isset($item->attachments))
                        @foreach($item->attachments as $one)
                        <div class="dashboard-no-gutters boxAttachment">
        			        <div class="boxAttach"><p>{{@$one->attachment_name}}</p></div>
        					<div class="boxAttach"><p>{{@$one->attachtype->name}}</p></div>
        				    <div class="boxAttach"><p>{{$one->reference_number}}</p></div>
        					<div class="boxAttach">
        					    <a href="{{@$one->file}}" target="blank"><i class="material-icons m-0">visibility</i></a>
        				    </div>
                        </div>
                        @endforeach
                        @endif
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>


<input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" name="chkBox" checked style="display:none;" />


<!-- modalSlideLeft-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>
                                {{__('website.are_you_sure_to_delete_this_expense')}}
                                <span class="block bold viewItems"></span>
                            </p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll deleteExpenseFromDetPage" data-dismiss="modal" data-action="delete">
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
