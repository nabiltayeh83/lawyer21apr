@extends('layout.siteLayout')
@section('title', __('website.invoices'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3"> {{__('website.edit')}} {{__('website.invoices')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/invoices')}}'">
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


<div class="modal fade slide-right" id="InvoiceExpensesModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6> {{__('website.add_new_expense')}} </h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
				        <div class="modal-body col-xs-height">
                            <form method="post" action="javascript:void(0)" id="createInvoiceExpenses">
                                <input type="hidden" class="invoiceExpenseID" name="project_id" value="{{$item->project_id}}">
                                <div class="form-group form-group-default form-group-default-select2">
                                    <label> {{__('website.expense_aspect')}} </label>
                                    <select class="full-width" data-init-plugin="select2" id="aspect_expense_id" name="aspect_expense_id">
                                        <optgroup label="{{__('website.select_expense_aspect')}}">
                                            <option value=""></option>
                                            @if(isset($aspect_expense))
                                            @foreach($aspect_expense as $one)
                                                <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>

                                <div class="form-group form-group-default">
                                    <label> {{__('website.expense_date')}} </label>
                                    <input type="text" name="expense_date" class="form-control start_date" required>
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
                                                <option value="{{$one->id}}">{{$one->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-complete btn-block" id="newInvoiceExpenses"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade slide-right" id="addInvoiceHours" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h6> {{__('website.add_new_hours')}} </h6>
                </div>
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height">
                            <form method="post" action="javascript:void(0)" id="createInvoiceHours">
                                <input type="hidden" class="invoiceProjectID" name="project_id" value="{{$item->project_id}}">

                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label> {{__('website.responsible_emp')}} </label>
                                    <select class="full-width responsible_lawyer_hours" data-init-plugin="select2" name="responsible_lawyer">
                                        <optgroup label="{{__('website.choose_responsible_emp')}}">
                                            <option value=""></option>
                                            @if(isset(Auth::user()->office_employees))
                                            @foreach(Auth::user()->office_employees as $one)
                                                <option data-id="{{$one->hour_price}}"  value="{{$one->id}}">{{$one->name}}</option>
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
                                    <input type="text" class="form-control start_date" id="start_date" name="start_date" >
                                </div>

                                <div class="form-group form-group-default">
                                    <label> {{__('website.hours_details')}}</label>
                                    <textarea class="form-control" style="height:70px !important;" name="hour_details" id="hour_details"></textarea>
                                </div>
                                <div class="form-group form-group-default">
                                    <label> {{__('website.hours_office_details')}} </label>
                                    <textarea class="form-control" name="hour_office_details" style="height:70px !important;" id="hour_office_details"></textarea>
                                </div>
                                <button type="submit" class="btn btn-complete btn-block" id="newInvoiceHours"> {{__('website.save')}} </button>
        						<button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade slide-right" id="InvoiceFlatsFeeModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6>{{__('website.add_flat_fee')}} </h6>
				</div>
				<div class="container-xs-height full-height">
				    <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
                            <form method="post" action="javascript:void(0)" id="formInvoiceFlatsFees">
                            {{csrf_field()}}
                                <input type="hidden" class="invoiceFlatFee" name="project_id" value="{{$item->project_id}}">

                                <div class="form-group form-group-default">
                                    <label> {{__('website.amount')}} </label>
                                    <input type="text" name="price" class="form-control" value="{{old('price')}}" required>
                                </div>

                                <div class="form-group form-group-default">
                                  <label> {{__('website.date')}} </label>
                                  <input type="text" name="date" class="form-control start_date">
                                </div>

                                <div class="form-group form-group-default">
                                    <label> {{__('website.details')}} </label>
                                    <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                </div>

                                <button type="submit" class="btn btn-complete btn-block" id="newInvoiceFlatsFees"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="content ">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/invoices')}}">
                    {{__('website.expenses')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.edit')}} {{__('website.invoices')}}</li>
            </ol>
        </div>
    </div>
    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
			    <form action="{{url(app()->getLocale() . '/invoices/' . $item->id)}}" method="post" id="editTaskForm" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PUT')}}

    				<div class=" card m-0 no-border">
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
                                    				<select class="full-width invoiceClients" required name="client_id" id="client_id" data-init-plugin="select2">
                                    					<optgroup label="{{__('website.choose_name')}}">
                                    					    @if(isset($clients))
                                        					@foreach($clients as $one)
                                        						<option {{($item->client_id == $one->id)? 'selected':''}} value="{{$one->id}}">{{$one->name}}</option>
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
                                                    <select class="full-width invoiceProjects" data-init-plugin="select2" id="project_id" required name="project_id">
                                                        <optgroup label="{{__('website.select_project_name')}}">
                                                            @if(isset($projects))
                                                            @foreach($projects as $one)
                                                                <option {{($item->project_id == $one->id)? 'selected':''}} value="{{$one->id}}">{{$one->name}}</option>
                                                            @endforeach
                                                            @endif
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.invoiceID')}}</label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default required">
                                                    <label>{{__('website.invoiceID')}} </label>
                                                    <input type="text" class="form-control" value="{{$office_settings->invoices_number}}{{ $item->invoice_number }}" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label class="col-md-3 control-label bold fs-14">{{__('website.vat')}} </label>
                                            <div class="col-md-9">
                                                <div class="radio radio-success">
                                                    <input type="radio" value="no" @if($item->vat_status == 'no') checked @endif name="vat_status" id="tax22">
                                                    <label for="tax22"> {{__('website.non')}}</label>
                                                    <input type="radio" value="yes" @if($item->vat_status == 'yes') checked @endif name="vat_status" id="tax222">
                                                    <label for="tax222">VAT</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.release_date')}}</label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default required">
                                                    <label> {{__('website.release_date')}}</label>
                                                    <input type="text" name="release_date" value="{{$item->release_date}}" class="form-control hijri-date-input" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.claim_date')}} </label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default required">
                                                    <label> {{__('website.claim_date')}}</label>
                                                    <input type="text" name="claim_date" value="{{$item->claim_date}}" class="form-control hijri-date-input" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.office_address')}}</label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default required">
                                                    <label> {{__('website.office_address')}}</label>
                                                    <input type="text" class="form-control" name="office_address" value="{{$item->office_address}}" placeholder="  {{__('website.office_address')}}" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.client_address')}} </label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default required">
                                                    <label>{{__('website.client_address')}}</label>
                                                    <input type="text" class="form-control" name="client_address" value="{{$item->client_address}}" placeholder="{{__('website.client_address')}}" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.total_amount')}}</label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default">
                                                    <label> {{__('website.total_amount')}} </label>
                                                    <p class="form-control">
                                                    <span class="invoiceTotalAmount">{{$item->final_total}}</span>
                                                    {{__('website.sr')}}</p>
                                                    <input type="hidden" class="final_total" name="final_total" value="{{$item->final_total}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label class="col-md-3 control-label bold fs-14"> {{__('website.discount')}}</label>
                                            <div class="col-md-7">
                                                <div class="radio radio-success">
                                                    <input type="checkbox" @if($item->discount_status == 'yes') checked @endif value="Discount" value="yes" name="discount_status" id="DiscountForClick">
                                                    <label for="DiscountForClick"> {{__('website.discount')}}</label>
                                                </div>
                                                <div class="animated fadeIn delay-0.5s" id="invoiceDiscount">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group form-group-default">
                                                                <label>{{__('website.discount_name')}}</label>
                                                                <input type="text" name="discount_name" value="{{$item->discount_name}}" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-group-default form-group-default-select2">
                                                                <label> {{__('website.discount_type')}}</label>
                                                                <select class="full-width" data-init-plugin="select2" name="discount_type_id" id="discount_type_id">
                                                                    <optgroup label="{{__('website.discount_type')}}">
                                                                        <option value=""></option>
                                                                        @if(isset(Auth::user()->office_discount_types))
                                                                        @foreach(Auth::user()->office_discount_types as $one)
                                                                            <option {{($item->discount_type_id == $one->discount_type->id)? 'selected':''}} value="{{$one->discount_type_id}}">{{$one->discount_type->name}}</option>
                                                                        @endforeach
                                                                        @endif
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group form-group-default">
                                                                <label>{{__('website.discount')}}</label>
                                                                <input type="text" name="discount_amount" value="{{$item->discount_amount}}" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label class="col-md-3 control-label bold fs-14">{{__('website.invoice_approval')}}</label>
                                            <div class="col-md-9">
                                                <div class="radio radio-success">
                                                    <input type="checkbox" id="etemad" @if($item->status == 'approved') checked @endif
                                                    type="yes" name="status" value="approved">
                                                    <label for="etemad">{{__('website.approve')}}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.invoices_outputs')}} </label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default form-group-default-select2">
                                                    <label>{{__('website.invoices_outputs')}}  </label>
                                                    <select class="full-width" data-init-plugin="select2" name="invoices_outputs[]" multiple>
                                                        <optgroup label="{{__('website.invoices_outputs')}}">
                                                            <option value=""></option>
                                                            @if(isset($invoices_outputs))
                                                            @foreach($invoices_outputs as $one)
                                                                <option  @if(in_array($one->id, $invoices_invoices_outputs)) selected @endif value="{{$one->id}}">{{$one->name}}</option>
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
									<a href="#" class="btn btn-material btn-complete">
									<i class="material-icons">add</i>  </a>
                                </div>
							</div>
						</div>
					</div>

                    <div class=" card m-0 mt-4 no-border">
                        <div class=" card no-border m-0">
                            <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                <div>
                                    <h5> {{__('website.hours')}}</h5>
                                </div>
                                <div class="btn-group">
                      	            <button type="button" class="btn btn-complete has-icon mb-2 m-md-0" data-target="#addInvoiceHours" data-id="" data-toggle="modal">
									    <i class="material-icons">add</i> <span> {{__('website.add')}} {{__('website.hours')}}</spans
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
                                            @include('website.extraBlade.invoices.editProjectHours')
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" card m-0 mt-4 no-border">
                        <div class=" card no-border m-0">
                            <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                <div>
                                    <h5>{{__('website.expenses')}}</h5>
                                </div>
                                <div class="btn-group">
                    	            <button type="button" class="btn btn-complete has-icon mb-2 m-md-0" data-target="#InvoiceExpensesModal" data-id="" data-toggle="modal">
										<i class="material-icons">add</i>
										<span> {{__('website.add_new_expense')}}</span>
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
                                            @include('website.extraBlade.invoices.editProjectExpenses')
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class=" card m-0 mt-4 no-border">
                        <div class=" card no-border m-0">
                            <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                <div>
                                    <h5>{{__('website.flats_fees')}} </h5>
                                </div>
                                <div class="btn-group">
                      		        <button type="button" class="btn btn-complete has-icon mb-2 m-md-0" data-target="#InvoiceFlatsFeeModal" data-id="" data-toggle="modal">
										<i class="material-icons">add</i>
										<span> {{__('website.add_flat_fee')}} </spans
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
                                                <th class="wd-70p">{{__('website.details')}}</th>
                                                <th class="wd-20p">{{__('website.date')}}</th>
                                                <th class="wd-10p">{{__('website.amount')}}</th>
                                            </tr>
                                        </thead>

                                        <tbody class="projectFlatsFees">
                                            @include('website.extraBlade.invoices.editProjectFlatsFees')
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card m-0 mt-4 no-border">
                        <div class="card-header ">
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
                                            <input type="file" id="file-upload-1"  name="oldattachfile{{$one->id}}" size="40">
                                        </div>
                                    </div>
    							</div>

    							<div class="col-auto">
    								<div class="row-options clickToRemove">
    									<a href="#" class="btn btn-default btn-material" >
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
                                            <input type="file"  id="file-upload-2" name="attachfile[]" size="40">
                                        </div>
                                    </div>
    							</div>

    							<div class="col-auto">
    								<div class="row-options clickToAddMoreAttach">
    									<a href="#" class="btn btn-material btn-complete">
    									<i class="material-icons">add</i>  </a>
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


	var discount_status	 = "{{$item->discount_status}}";
		if(discount_status == 'yes'){
			$("#invoiceDiscount").toggle();
		}


    $('input.editProjectHours').click(function(){

        var sum = $('.invoiceTotalAmount').html();
        var sumint= parseInt(sum);

        if($(this).prop("checked") == true){

            sumint += Number($(this).data("id"));
            $('.invoiceTotalAmount').html(sumint);
            $('.final_total').val(sumint);

        }
        else{
            sumint -= Number($(this).data("id"));
            $('.invoiceTotalAmount').html(sumint);
            $('.final_total').val(sumint);
        }

    });


//////////////////////////////////////////////////////////


        $('input.projectExpensesBox').click(function(){
            var sum = $('.invoiceTotalAmount').html();
            var sumint= parseInt(sum);

            if($(this).prop("checked") == true){

                sumint += Number($(this).data("id"));
                $('.invoiceTotalAmount').html(sumint);
                $('.final_total').val(sumint);

            }
            else{
                sumint -= Number($(this).data("id"));
                $('.invoiceTotalAmount').html(sumint);
                $('.final_total').val(sumint);
            }

        });

///////////////////////////////////////////////////////////


        $('input.projectFlatsFeesBox').click(function(){
            var sum = $('.invoiceTotalAmount').html();
            var sumint= parseInt(sum);

            if($(this).prop("checked") == true){

                sumint += Number($(this).data("id"));
                $('.invoiceTotalAmount').html(sumint);
                $('.final_total').val(sumint);

            }
            else{
                sumint -= Number($(this).data("id"));
                $('.invoiceTotalAmount').html(sumint);
                $('.final_total').val(sumint);
            }

        });

/////////////////////// View Cities ////////////////////
$(document).on('change','.invoiceProjects',function(){
	var project_id = $(this).val();

	$(".invoiceProjectID").val(project_id);
	$(".invoiceExpenseID").val(project_id);
	$(".invoiceFlatFee").val(project_id);

    var url = "{{ url(app()->getLocale().'/getProjectHours/') }}";

      if(project_id){
        $.ajax({
          type: "GET",
          url: url+'/'+project_id,
          success: function (response) {
              if(response.status = 'true')
              {
                  $('.projectHours').html(response.projectHours);
                  $('.projectExpenses').html(response.projectExpenses);
                  $('.projectFlatsFees').html(response.projectFlatsFees);

              }
          }
        });
      }
      else{
        //$(".invoiceProjects").empty();
      }


});




	/////////////// Choose Client From Invoice Page ///////////////
    if($(".invoiceClients").val() != ''){
			$('.invoiceClients').change();
		}


/////////////////////// View Cities ////////////////////
$(document).on('change','.invoiceClients',function(e){
    var client_id = $(this).val();
    var url = "{{ url(app()->getLocale().'/getClientProjects/') }}";

      if(client_id){
        $.ajax({
          type: "GET",
          url: url+'/'+client_id,
          success: function (response) {
              if(response)
              {
                $(".invoiceProjects").empty();
                $(".invoiceProjects").append('<optgroup label="{{__('website.select_project_name')}}">');
				$(".invoiceProjects").append('<option value=""></option>');
                $.each(response, function(index, value){
                  $(".invoiceProjects").append('<option value="'+value.id+'">'+ value.name +'</option>');
                  $(".invoiceProjects").append('</optgroup>');
                });
              }
          }
        });
      }
      else{
        $(".invoiceProjects").empty();
      }
});








	var remindStstus = "{{$item->remind}}";
		if(remindStstus == 'yes'){
			$("#checkNoti").click();
		}


    var related_project = "{{$item->related_project}}";

    if(related_project == 'yes'){
        $('.selectProject').removeClass("hidden");
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
