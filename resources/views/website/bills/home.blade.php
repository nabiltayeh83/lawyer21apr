@extends('layout.siteLayout')
@section('title', __('website.invoices_and_payments'))
@section('topfixed')

<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.invoices_and_payments')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button type="button" class="btn btn-default has-icon" data-target="#modalExport" data-toggle="modal">
                        <i class="material-icons">description</i><span>{{__('website.export')}}</span>
                    </button>

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>

				<button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale().'/invoices/create')}}'">
					<i class="material-icons">add</i><span> {{__('website.add')}} {{__('website.invoice')}}  </span>
				</button>

				<button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale().'/bills/create')}}'">
					<i class="material-icons">add</i><span>  {{__('website.add')}} {{__('website.addBill')}} </span>
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
                <li class="breadcrumb-item">
                    <a href="{{url(app()->getLocale().'/expenses')}}">{{__('website.invoices_and_payments')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('website.view_invoices_and_payments')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters container-fluid dashboard-no-gutters mt-4">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple container-fluid" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active" data-toggle="tab" role="tab" data-target="#dataProject" href="#">{{__('website.invoices')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#hoursProject">{{__('website.financial_payments')}}</a>
                    </li>
                </ul>
                <div class="tab-content" style="padding:0">
                    <div class="tab-pane active" id="dataProject">
                        <div>
                            <div class="row no-gutters  mt-4">
                                <div class="col-lg-12">
                                    <div class="card m-0 no-border">
                                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                            <div>
                                                <h5>{{__('website.view_invoices')}}</h5>
                                                <p>{{__('website.view_all_invoices')}}</p>
                                            </div>
                                            <div class="btn-group">
                                                <form class="input-group">
                                                    <input type="text" class="form-control" placeholder=" {{__('website.search')}}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary" type="button">
                                                            <i class="material-icons">search</i>
                                                        </button>
                                                    </div>
                                                </form>
                                                <button class="btn btn-sm btn-default filter has-icon" data-target="#filterInvoices" data-toggle="modal"><i class="material-icons">filter_list</i> <span>{{__('website.filter')}}</span></button>
                                                <button class="btn btn-sm btn-default active">  {{__('website.all')}} </button>
                                                <button class="btn btn-sm btn-default">{{__('website.draft')}}</button>
                                                <button class="btn btn-sm btn-default">{{__('website.certified')}}</button>
                                                <button class="btn btn-sm btn-default">{{__('website.canceled')}}</button>
                                                <button class="btn btn-sm btn-default">{{__('website.paid_all')}}</button>
                                                <button class="btn btn-sm btn-default">{{__('website.paid_part')}}</button>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-5p no-sort">
                                                                <div class="checkbox checkMain text-center">
                                                                    <input type="checkbox" value="3" id="checkboxall" name="chkBox" class="chkBox">
                                                                    <label for="checkboxall" class="no-padding no-margin"></label>
                                                                </div>
                                                            </th>
                                                           <th class="wd-10p">{{__('website.invoiceID')}} </th>
                                                           <th class="wd-20p">{{__('website.client_name')}} </th>
                                                           <th class="wd-20p">{{__('website.project_name')}} </th>
                                                           <th class="wd-10p">{{__('website.claim_date')}} </th>
                                                           <th class="wd-10p">{{__('website.amount')}}</th>
                                                           <th class="wd-10p">{{__('website.status')}} </th>
                                                           <th class="wd-20p">{{__('website.action')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($invoices))
                                                        @foreach ($invoices as $one)
                                                        <tr id="tr-{{$one->id}}">
                                                            <td class="v-align-middle wd-5p">
                                                                <div class="checkbox checkMain text-center">
                                                                    <input type="checkbox" value="3" id="checkbox1" name="chkBox" class="chkBox">
                                                                    <label for="checkbox1" class="no-padding no-margin"></label>
                                                                </div>
                                                            </td>
                                                            <td class="v-align-middle wd-10p">
                                                                <p>{{@$one->invoice_number}}</p>
                                                            </td>
                                                            <td class="v-align-middle wd-20p">
                                                                <p>{{@$one->client->name}}</p>
                                                            </td>
                                                            <td class="v-align-middle wd-20p">
                                                                <p>{{@$one->project->name}}</p>
                                                            </td>
                                                            <td class="v-align-middle wd-10p">
                                                                <p>
                                                                    {{Arr::get(getDates(substr($item->claim_date, 0, 10)), 'hijri_date')}}
                                                                </p>
                                                            </td>
                                                            <td class="v-align-middle wd-10p">
                                                                <p>{{@$one->final_total}} {{__('website.sr')}}</p>
                                                            </td>
                                                            <td class="v-align-middle wd-10p">
                                                                <span class="badge badge-pill badge-success invoiceStatus-{{$one->id}}">
                                                                    {{__('website.' .$one->status)}}
                                                                </span>
                                                            </td>
                                                            <td class="v-align-middle wd-15p optionAddHours">
                                                                <div class="note-options completeInvoice" data-id="{{@$one->id}}" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.approve')}}">
                                                                    <i class="material-icons">check</i>
                                                                </div>
                                                                <a href="addBill.html" class="addBill">
                                                                    <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title=" {{__('website.addBill')}}">
                                                                        <i class="material-icons">add</i>
                                                                    </div>
                                                                </a>
                                                                <a href="{{url(getLocal(). '/invoices/' . $one->id)}}">
                                                                    <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                                                                        <i class="material-icons showDitails">visibility</i>
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
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
                    <div class="tab-pane" id="hoursProject">
                        <div>
                            <div class="row no-gutters mt-4">
                                <div class="col-lg-12">
                                    <div class=" card m-0 no-border">
                                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                            <div>
                                                <h5>{{__('website.bills')}}</h5>
                                                <p>{{__('website.view_financial_payments')}}</p>
                                            </div>
                                            <div class="btn-group">
                                                <form class="input-group">
                                                    <input type="text" class="form-control" placeholder="{{__('website.serarch')}}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary" type="button">
                                                            <i class="material-icons">search</i>
                                                        </button>
                                                    </div>
                                                </form>
                                                <button class="btn btn-sm btn-default filter has-icon" data-target="#filterBill" data-toggle="modal"><i class="material-icons">filter_list</i> <span>{{__('website.filter')}}</span></button>
                                                <button class="btn btn-sm btn-default active">{{__('website.all')}}</button>
                                                <button class="btn btn-sm btn-default">{{__('website.cash')}}</button>
                                                <button class="btn btn-sm btn-default">{{__('website.Check')}}</button>
                                                <button class="btn btn-sm btn-default">{{__('website.Transfere')}}</button>
                                                <button class="btn btn-sm btn-default">{{__('website.Deposit')}}</button>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-5p no-sort">
                                                                <div class="checkbox checkMain text-center">
                                                                    <input type="checkbox" value="3" id="checkboxall" name="chkBox" class="chkBox">
                                                                    <label for="checkboxall" class="no-padding no-margin"></label>
                                                                </div>
                                                            </th>
                                                            <th class="wd-10p">{{__('website.billID')}} </th>
                                                            <th class="wd-15p">{{__('website.client_name')}} </th>
                                                            <th class="wd-20p"> {{__('website.project_name')}}</th>
                                                            <th class="wd-10p">{{__('website.payment_date')}}</th>
                                                            <th class="wd-10p"> {{__('website.payment_methods')}}</th>
                                                            <th class="wd-10p">{{__('website.amount')}}</th>
                                                            <th class="wd-10p">{{__('website.action')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="v-align-middle wd-5p">
                                                                <div class="checkbox checkMain text-center">
                                                                    <input type="checkbox" value="3" id="checkbox1" name="chkBox" class="chkBox">
                                                                    <label for="checkbox1" class="no-padding no-margin"></label>
                                                                </div>
                                                            </td>
                                                            <td class="v-align-middle wd-10p"><p>KM542184</p></td>
                                                            <td class="v-align-middle wd-20p">..</td>
                                                            <td class="v-align-middle wd-25p">..</td>
                                                            <td class="v-align-middle wd-10p"><p>14/09/2019</p></td>
                                                            <td class="v-align-middle wd-10p">..</td>
                                                            <td class="v-align-middle wd-10p"><p>1800{{__('website.sr')}}</p></td>
                                                            <td class="v-align-middle wd-10p optionAddHours">
                                                                <a href="invoiceDetails.html">
                                                                    <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                                                                        <i class="material-icons showDitails">visibility</i>
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        </tr>
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
</div>


<!-- modalSlideLeft -->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.are_you_sure_to_delete_this_expense')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll" data-dismiss="modal" data-action="delete">
                                {{__('website.agree')}}
                            </button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade slide-right" id="filterExpense" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
		    <div class="modal-content">
			    <div class="modal-header mb-3">
				    <h6> {{__('website.filter')}} </h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
                            <form id="formAddTask" action="{{url(app()->getLocale().'/expenses/')}}" method="get">
						        <div class="form-group form-group-default form-group-default-select2">
								    <label>{{__('website.expense_aspect')}}</label>
								    <select class="full-width" data-init-plugin="select2" id="aspect_expense_id" name="aspect_expense_id">
								        <optgroup label="{{__('website.select_expense_aspect')}}">
    									    <option value=""></option>
                                            @foreach($aspect_expense as $one)
                                              <option value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
								        </optgroup>
								    </select>
							    </div>
							    <div class="form-group form-group-default form-group-default-select2">
								    <label> {{__('website.project')}} </label>
								    <select class="full-width" data-init-plugin="select2" id="project_id" name="project_id">
								        <optgroup label="{{__('website.select_project_name')}}">
                                            <option value=""></option>
                                            @foreach($projects as $one)
                                              <option value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
								        </optgroup>
								    </select>
							    </div>
                                <div class="form-group form-group-default form-group-default-select2">
								    <label> {{__('website.responsible_emp')}} </label>
								    <select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
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
                                            <input type="text" class="form-control start_date" id="from_date" name="from_date">
									    </div>
								    </div>
                                    <div class="col-md-6">
									    <div class="form-group form-group-default">
										    <label> {{__('website.to_date')}} </label>
                                            <input type="text" class="form-control end_date" id="to_date" name="to_date">
									    </div>
								    </div>
                                </div>
                                <button type="submit" class="btn btn-complete btn-block">{{__('website.search')}}</button>
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

    var pureUrl    = "{{ url(app()->getLocale().'/'.Request::segment(2)) }}";
    var currentUrl = window.location.href;


    if (window.location.href.indexOf("status=draft") > -1) {
      $('#viewDraftItems').addClass('active');
      $('#viewAllItems').removeClass('active');
      $('#viewCertifiedItems').removeClass('active');
      $('#viewCanceledItems').removeClass('active');
    }
    if (window.location.href.indexOf("status=certified") > -1) {
      $('#viewCertifiedItems').addClass('active');
      $('#viewAllItems').removeClass('active');
      $('#viewDraftItems').removeClass('active');
      $('#viewCanceledItems').removeClass('active');
    }
    if (window.location.href.indexOf("status=canceled") > -1) {
      $('#viewCanceledItems').addClass('active');
      $('#viewAllItems').removeClass('active');
      $('#viewDraftItems').removeClass('active');
      $('#viewCertifiedItems').removeClass('active');
    }
    if (window.location.href.indexOf("status") == -1) {
        $('#viewAllItems').addClass('active');
        $('#viewDraftItems').removeClass('active');
        $('#viewCertifiedItems').removeClass('active');
        $('#viewCanceledItems').removeClass('active');
    }



    /////////////////////// View All items ////////////////////
    $(document).on('click','#viewAllItems',function(e){
      $(location).attr('href', pureUrl);
    });

    /////////////////////// viewDraftItems ////////////////////
    $(document).on('click','#viewDraftItems',function(e){
      $(location).attr('href', pureUrl+'?status=draft');
    });

    /////////////////////// viewCertifiedItems ////////////////////
    $(document).on('click','#viewCertifiedItems',function(e){
      $(location).attr('href', pureUrl+'?status=certified');
    });

    /////////////////////// viewCanceledItems ////////////////////
    $(document).on('click','#viewCanceledItems',function(e){
      $(location).attr('href', pureUrl+'?status=canceled');
    });

});
</script>
@endsection
