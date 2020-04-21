@extends('layout.siteLayout')
@section('title', __('website.invoices_and_payments'))

@section('topfixed')

<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.invoices_and_payments')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon exportInvoices" onclick="window.location.href='{{url(getLocal(). '/exportAllInvoicesPDF')}}'">
				        <i class="material-icons">description</i><span>{{__('website.export')}}</span>
					</button>
					
					<button type="button" class="btn btn-default has-icon exportBills hide" onclick="window.location.href='{{url(getLocal(). '/exportAllBillsPDF')}}'">
				        <i class="material-icons">description</i><span>{{__('website.export')}}</span>
					</button>

                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>

				<button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale().'/invoices/create')}}'">
					<i class="material-icons">add</i><span> {{__('website.add')}} {{__('website.invoice')}}</span>
				</button>

				<button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale().'/bills/create')}}'">
					<i class="material-icons">add</i><span>{{__('website.addBill')}}</span>
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
                    <a href="{{url(app()->getLocale().'/invoices')}}">{{__('website.invoices_and_payments')}}</a>
                </li>
                <li class="breadcrumb-item active">{{__('website.view_invoices_and_payments')}}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row no-gutters container-fluid dashboard-no-gutters mt-4">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple container-fluid" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item invoiceTab">
                        <a class="active" data-toggle="tab" role="tab" data-target="#dataProject" href="#">{{__('website.invoices')}}</a>
                    </li>
                    <li class="nav-item billTab">
                        <a href="#" data-toggle="tab" role="tab" data-target="#hoursProject">{{__('website.financial_payments')}}</a>
                    </li>
                </ul>

                <div class="tab-content" style="padding:0">
                    <div class="tab-pane active" id="dataProject">
                        <div class="">
                            <div class="row no-gutters mt-4">
                                <div class="col-lg-12">
                                    <div class=" card m-0 no-border">
                                        <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                            <div>
                                                <h5>{{__('website.view_invoices')}}</h5>
                                                <p>{{__('website.view_all_invoices')}}</p>
                                            </div>
                                            <div class="btn-group">
                                                 <form class="input-group" id="invoiceFilterText" action="javascript:avoid(0)" method="get">
                                                    <input type="text" name="text" id="textKey" class="form-control" placeholder="{{__('website.search')}}">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-secondary" type="button">
                                                            <i class="material-icons">search</i>
                                                        </button>
                                                    </div>
                                                </form>
                                                <button class="btn btn-sm btn-default filter has-icon " data-target="#filterModalInvoices" data-toggle="modal"><i class="material-icons">filter_list</i> <span>فلترة</span></button>
                                                <button class="btn btn-sm btn-default filterTabInvoices active" data-action="all">{{__('website.all')}}</button>
                                                <button class="btn btn-sm btn-default filterTabInvoices" data-action="draft">{{__('website.draft')}}</button>
                                                <button class="btn btn-sm btn-default filterTabInvoices" data-action="approved">{{__('website.approved')}}</button>
                                                <!--<button class="btn btn-sm btn-default filterTabInvoices" data-action="canceled">{{__('website.canceled')}}</button>-->
                                                <button class="btn btn-sm btn-default filterTabInvoices" data-action="paid_all">{{__('website.paid_all')}}</button>
                                                <!--<button class="btn btn-sm btn-default filterTabInvoices" data-action="paid_part">{{__('website.paid_part')}}</button>-->
                                            </div>
                                        </div>
                                        <div class="card-body p-0 allInvoices">
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
                                                            <th class="wd-10p">{{__('website.invoiceID')}}</th>
                                                            <th class="wd-15p"> {{__('website.client_name')}}</th>
                                                            <th class="wd-20p">{{__('website.project_name')}}</th>
                                                            <th class="wd-20p">{{__('website.claim_date')}}</th>
                                                            <th class="wd-10p">{{__('website.amount')}}</th>
                                                            <th class="wd-10p">{{__('website.status')}}</th>
                                                            <th class="wd-15p">{{__('website.action')}}</th>
                                                        </tr>
                                                    </thead>

                                                <tbody class="viewAllInvoices">

                                                    @include('website.extraBlade.filters.invoiceFilter')

                                                    @if(isset($office_invoices))
                                                    @foreach ($office_invoices as $one)
                                                    <tr id="tr-{{$one->id}}" class="invoiceRow">
                                                        <td class="v-align-middle wd-5p">
                                                            <div class="checkbox checkMain text-center">
                                                                <input type="checkbox" class="checkboxes chkBox deleteInvoice" value="{{$one->id}}" id="chkBox{{$one->id}}" data name="chkBox"/>
                                                                <label for="chkBox{{$one->id}}" class="no-padding no-margin"></label>
									                        </div>
                                                        </td>
                                                        <td class="v-align-middle wd-10p">
                                                            <p>{{ @$office_settings->invoices_number}}{{@$one->invoice_number}}</p>
                                                        </td>
                                                        <td class="v-align-middle wd-15p">
                                                            <p>{{@$one->client->name}}</p>
                                                        </td>
                                                        <td class="v-align-middle wd-20p">
                                                            <p>{{@$one->project->name}}</p>
                                                        </td>
                                                        <td class="v-align-middle wd-10p">
                                                            <p>
                                                                {{Arr::get(getDates(substr($one->claim_date, 0, 10)), 'hijri_date')}}</p>
                                                        </td>
                                                        <td class="v-align-middle wd-10p">
                                                            <p>{{@$one->invoice_amount}} {{__('website.sr')}}</p>
                                                        </td>
                                                        <td class="v-align-middle wd-10p">
                                                            <span class="badge badge-pill badge-success invoiceStatus-{{$one->id}}">
                                                                {{__('website.' .$one->status)}}
                                                            </span>
                                                        </td>
                                                        <td class="v-align-middle wd-10p optionAddHours">
                                                            <div class="note-options completeInvoice" data-id="{{$one->id}}" data-toggle="tooltip" title="" href="#" data-original-title="إعتماد">
                                                                <i class="material-icons">check</i>
                                                            </div>
                                                            <a href="{{url(getLocal(). '/bills/create')}}" class="addBill">
                                                                <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.addBill')}}">
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
                <div class="tab-pane" id="hoursProject">
                    <div class="">
                        <div class="row no-gutters mt-4">
                            <div class="col-lg-12">
                                <div class=" card m-0 no-border">
                                    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                        <div>
                                            <h5>{{__('website.financial_payments')}}</h5>
                                            <p>{{__('website.view_financial_payments')}}</p>
                                        </div>
                                        <div class="btn-group">
                                            <form class="input-group" id="billFilterText" action="javascript:avoid(0)" method="get">
                                                <input type="text" name="text" id="textKeyBill" class="form-control" placeholder="{{__('website.search')}}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-secondary" type="button">
                                                        <i class="material-icons">search</i>
                                                    </button>
                                                </div>
                                            </form>

                                            <button class="btn btn-sm btn-default filter has-icon" data-target="#filterModalBills" data-toggle="modal"><i class="material-icons">filter_list</i> <span>فلترة</span></button>

                                            <button class="btn btn-sm btn-default filterTabBills active" data-action="all">{{__('website.all')}}</button>
                                          

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
                                                        <th class="wd-10p">{{__('website.billID')}}</th>
                                                        <th class="wd-15p">{{__('website.client_name')}} </th>
                                                        <th class="wd-20p">{{__('website.project_name')}}</th>
                                                        <th class="wd-10p">{{__('website.date')}}</th>
                                                        <th class="wd-10p">{{__('website.payment_methods')}}</th>
                                                        <th class="wd-10p">{{__('website.amount')}}</th>
                                                        <th class="wd-10p">{{__('website.action')}}</th>
                                                    </tr>
                                                </thead>


                                                <tbody class="viewAllBills">

                                                @include('website.extraBlade.filters.billFilter')

                                                    @if(isset($bills))
                                                    @foreach ($bills as $one)
                                                    <tr id="tr-{{$one->id}}" class="billRow">
                                                        <td class="v-align-middle wd-5p">
                                                            <div class="checkbox checkMain text-center">

                                                                <input type="checkbox" value="{{$one->id}}" id="chkBox{{$one->id}}"
                                                                name="chkBox" class="checkboxes chkBox deleteBill">




                                                                <label for="chkBox{{$one->id}}" class="no-padding no-margin"></label>
                                                                <input type="hidden" name="tabSection" id="tabSection" value="">
                                                            </div>
                                                        </td>
                                                        <td class="v-align-middle wd-10p"><p>{{$one->id}}</p></td>
                                                        <td class="v-align-middle wd-20p">
                                                            <a href="{{url(getLocal(). '/clients/' . $one->client_id)}}">{{$one->client->name}}</a>
                                                        </td>
                                                        <td class="v-align-middle wd-25p">
                                                            <a href="{{url(getLocal(). '/projects/' . $one->invoice->project_id)}}">{{$one->invoice->project->name}}</a>
                                                        </td>
                                                        <td class="v-align-middle wd-10p"><p>

                                                            {{Arr::get(getDates(substr($one->payment_date, 0, 10)), 'hijri_date')}}
                                                        </p></td>
                                                        <td class="v-align-middle wd-10p">
                                                            <span>{{$one->payment_method->name}}</span>
                                                        </td>
                                                        <td class="v-align-middle wd-10p">
                                                            <p> {{$one->amount}} {{__('website.sr')}} </p>
                                                        </td>
                                                        <td class="v-align-middle wd-10p optionAddHours">
                                                            <a href="{{url(getLocal(). '/bills/' . $one->id)}}">
                                                                <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                                                                    <i class="material-icons showDitails">visibility</i>
                                                                </div>
                                                            </a>
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
                            <p>{{__('website.are_you_sure_to_delete_this_invoices')}}
                            <span class="block bold viewItems"></span></p>
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




<div class="modal fade slide-right" id="filterModalInvoices" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6> {{__('website.filter')}} </h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
                            <form id="invoiceFilterForm" action="javascript:avoid(0)" method="get">
						        <div class="form-group form-group-default form-group-default-select2">
								    <label> {{__('website.client')}} </label>
								    <select class="full-width" data-init-plugin="select2" id="client_id" name="client_id">
								        <optgroup label="{{__('website.client')}}">
									        <option value=""></option>
									        @if(isset($clients))
                                            @foreach($clients as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach
                                            @endif
								        </optgroup>
								    </select>
							    </div>
							    <div class="form-group form-group-default form-group-default-select2">
								    <label>{{__('website.project')}}</label>
								    <select class="full-width" data-init-plugin="select2" id="project_id" name="project_id">
								        <optgroup label="{{__('website.select_project_name')}}">
                                            <option value=""></option>
                                            @if(isset($projects))
                                            @foreach($projects as $one)
                                              <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach
                                            @endif
                        				</optgroup>
                        		    </select>
                        	    </div>
                        	    
                        	    
                        	    	<div class="form-group form-group-default form-group-default-select2">
								    <label>{{__('website.status')}}</label>
								    <select class="full-width" data-init-plugin="select2" id="status" name="status">
								        <optgroup label="{{__('website.status')}}">
                                            <option value=""></option>
                                            <option value="draft">{{__('website.draft')}}</option>
                                            <option value="approved">{{__('website.approved')}}</option>
                                            <option value="canceled">{{__('website.canceled')}}</option>
                                            <option value="paid_all">{{__('website.paid_all')}}</option>
                                            <option value="paid_part">{{__('website.paid_part')}}</option>
                        				</optgroup>
                        		    </select>
                        	    </div>

                                <div class="form-group form-group-default form-group-default-select2">
                				    <label>{{__('website.responsible_emp')}}</label>
                					<select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                                        <optgroup label="{{__('website.choose_emp_name')}}">
                                            <option value=""></option>
                                            @if(isset(Auth::user()->office_employees))
                                            @foreach(Auth::user()->office_employees as $one)
                                                <option value="{{$one->id}}">{{$one->name}}</option>
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
										    <label> {{__('website.to_date')}} </label>
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


<div class="modal fade slide-right" id="filterModalBills" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6> {{__('website.filter')}} </h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
                            <form id="billFilterForm" action="javascript:avoid(0)" method="get">
						        <div class="form-group form-group-default form-group-default-select2">
								    <label> {{__('website.client')}} </label>
								    <select class="full-width" data-init-plugin="select2" id="client_id" name="client_id">
								        <optgroup label="{{__('website.client')}}">
									        <option value=""></option>
									        @if(isset($clients))
                                            @foreach($clients as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach
                                            @endif
								        </optgroup>
								    </select>
							    </div>
							    <div class="form-group form-group-default form-group-default-select2">
								    <label>{{__('website.project')}}</label>
								    <select class="full-width" data-init-plugin="select2" id="project_id" name="project_id">
								        <optgroup label="{{__('website.select_project_name')}}">
                                            <option value=""></option>
                                            @if(isset($projects))
                                            @foreach($projects as $one)
                                              <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach
                                            @endif
                        				</optgroup>
                        		    </select>
                        	    </div>
                        	    
                        	    	    <div class="form-group form-group-default form-group-default-select2">
								    <label>{{__('website.payment_methods')}}</label>
								    <select class="full-width" data-init-plugin="select2" id="payment_method_id" name="payment_method_id">
								        <optgroup label="{{__('website.payment_methods')}}">
                                            <option value=""></option>
                                            @if(isset($payment_methods))
                                            @foreach($payment_methods as $one)
                                              <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach
                                            @endif
                        				</optgroup>
                        		    </select>
                        	    </div>

                                <div class="form-group form-group-default form-group-default-select2">
                				    <label>{{__('website.responsible_emp')}}</label>
                					<select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                                        <optgroup label="{{__('website.choose_emp_name')}}">
                                            <option value=""></option>
                                            @if(isset(Auth::user()->office_employees))
                                            @foreach(Auth::user()->office_employees as $one)
                                                <option value="{{$one->id}}">{{$one->name}}</option>
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
										    <label> {{__('website.to_date')}} </label>
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


    ///////////////////////  invoiceTab ////////////////////
    $(document).on('click','.invoiceTab',function(e){
      $(".exportInvoices").removeClass('hide');
      $(".exportBills").addClass('hide');
    });
    
    
    ///////////////////////  billTab ////////////////////
    $(document).on('click','.billTab',function(e){
      $(".exportBills").removeClass('hide');
      $(".exportInvoices").addClass('hide');
    });
    

    /////////////////////// Delete Bill ////////////////////
    $(document).on('click','.deleteBill',function(e){
      $("#tabSection").val('bill');
    });


    $(document).on('click','.deleteInvoice',function(e){
      $("#tabSection").val('invoice');
    });


    /////////////////////// filter Tab Invoices ////////////////////
    $(document).on('click','.filterTabInvoices',function(e){
        var status = $(this).data("action");

        $('.filterTabInvoices').removeClass('active');
        $(this).addClass('active');

        var url = "{{ url(app()->getLocale().'/invoiceFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                $(".invoiceRow").hide();
                $('.viewAllInvoices').html(response.invoiceFilter);
            }
        });

    });


    /////////////////////// filter Text Invoices ////////////////////
    $(document).on('submit','#invoiceFilterText',function(e){
        var text = $('#textKey').val();
        var url = "{{ url(app()->getLocale().'/invoiceFilterText/') }}";

        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".invoiceRow").hide();
                $('.viewAllInvoices').html(response.invoiceFilter);
            }
        });
    });


    /////////////////////// filter Form Invoices ////////////////////
    $(document).on('submit','#invoiceFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/invoiceFilterForm/') }}";
        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".invoiceRow").hide();

                $('#filterModalInvoices').fadeOut(500,function(){
                    $('#filterModalInvoices').modal('hide');
                });

                $('.viewAllInvoices').html(response.invoiceFilter);

                $("#filterModalInvoices #client_id").val('').select2();
                $("#filterModalInvoices #project_id").val('').select2();
                $("#filterModalInvoices #status").val('').select2();
                $("#filterModalInvoices #responsible_lawyer").val('').select2();
                $("#invoiceFilterForm").trigger("reset");

            }
        });
    });



    ///////////////////////////////////// Bills //////////////////////////////////////
        /////////////////////// filter Tab Bills ////////////////////
    $(document).on('click','.filterTabBills',function(e){
        var status = $(this).data("action");

        $('.filterTabBills').removeClass('active');
        $(this).addClass('active');

        var url = "{{ url(app()->getLocale().'/billFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                $(".billRow").hide();
                $('.viewAllBills').html(response.billFilter);
            }
        });

    });


    /////////////////////// filter Text Bills ////////////////////
    $(document).on('submit','#billFilterText',function(e){
        var text = $('#textKeyBill').val();
        var url = "{{ url(app()->getLocale().'/billFilterText/') }}";
        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".billRow").hide();
                $('.viewAllBills').html(response.billFilter);
            }
        });
    });


    /////////////////////// filter Form Bills ////////////////////
    $(document).on('submit','#billFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/billFilterForm/') }}";
        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".billRow").hide();

                $('#filterModalBills').fadeOut(500,function(){
                    $('#filterModalBills').modal('hide');
                });

                $('.viewAllBills').html(response.billFilter);

                $("#filterModalBills #client_id").val('').select2();
                $("#filterModalBills #project_id").val('').select2();
                $("#filterModalBills #payment_method_id").val('').select2();
                $("#filterModalBills #responsible_lawyer").val('').select2();
                $("#billFilterForm").trigger("reset");

            }
        });
    });


});
</script>
@endsection
