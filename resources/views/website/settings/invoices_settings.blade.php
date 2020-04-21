@extends('layout.siteLayout')

@section('title', __('website.setting_profile'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
    	<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        	<h2 class="page-header mb-1 my-md-3">{{__('website.billing_Receipt_settings')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
					</button>
                    <a href="{{url(getLocal(). '/settings')}}">
						<button type="button" class="btn btn-default  has-icon" data-target="#modalSlideLeft" data-toggle="modal">
							<i class="material-icons">delete_outline</i> <span> {{__('website.cancel')}} </span>
						</button>
					</a>
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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/settings')}}">
                    {{__('website.settings')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.billing_Receipt_settings')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                
				<form action="{{url(app()->getLocale() . '/invoices_settings')}}" method="post" id="updateContent" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PUT')}}

                    <div class=" card m-0 no-border">
                        <div class="card-header ">
                            <h5>{{__('website.billing_Receipt_settings')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8">
                                
									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.auto_number')}}</label>
										<div class="col-md-7">
											<div class="form-group form-group-default ">
												<label>{{__('website.auto_number')}}</label>
												<input type="text" class="form-control" name="invoices_number" value="{{@$office_settings->invoices_number}}">
											</div>
										</div>
									</div>


									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.vat')}}</label>
										<div class="col-md-7">
											<div class="form-group form-group-default">
												<label>{{__('website.vat')}}</label>
												<input type="number" class="form-control" lang="en" name="office_vat" value="{{@$office_settings->office_vat}}">
											</div>
										</div>
									</div>


									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.contenders_types')}}</label>
										<div class="col-md-7">
											<div class="form-group form-group-default ">
												<label>{{__('website.contenders_types')}}</label> 
												<select class="full-width" data-init-plugin="select2" multiple id="office_discount_types[]" name="office_discount_types[]">
													<optgroup label="{{__('website.choose_contenders_types')}}">
														@foreach($all_discount_types as $one)
															<option @if(in_array($one->id, $office_discount_types)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
														@endforeach
													</optgroup>
												</select>
											</div>
										</div>
									</div>


									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.payment_methods_available')}}</label>
										<div class="col-md-7">
											<div class="form-group form-group-default ">
												<label>{{__('website.payment_methods_available')}}</label> 
												<select class="full-width" data-init-plugin="select2" multiple id="office_payment_methods[]" name="office_payment_methods[]">
													<optgroup label="{{__('website.choose_payment_methods_available')}}">
													@foreach($all_payment_methods as $one)
															<option @if(in_array($one->id, $office_payment_methods)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
														@endforeach
													</optgroup>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group mb-12 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.banks_account')}}</label>
									</div>


									<!-- Div To Copy For Bank -->
									<div class="hidden divToCopyForBank">
										<div class="row client-row">
											<div class="col col-xs-12">
												<div class="form-group form-group-default required">
													<label>{{__('website.bank')}}</label>
													<input type="text" name="bank_name[]" id="name2" class="form-control">
												</div>
											</div>
											<div class="col col-xs-12">
												<div class="form-group form-group-default required rep_address_div">
													<label class="">{{__('website.iban')}}</label>
													<input type="text" name="iban[]" id="iban" class="form-control">
												</div>
											</div>
											<div class="col-auto">
												<div class="row-options clickToAddMoreBank">
													<a href="#" class="btn btn-material btn-complete" >
													<i class="material-icons">add</i>  </a>
												</div>
											</div>
										</div>
									</div>
									<!---------------------------------->
									
									<div class="card-body placeToAddMoreElement">

										@foreach(Auth::user()->office_banks as $one)
										<div class="row client-row">
											<div class="col col-xs-12">
												<div class="form-group form-group-default required">
													<label>{{__('website.bank')}}</label>
													<input type="text" name="bank_name[]" id="name1" value="{{@$one->name}}" class="form-control">
												</div>
											</div>

											<div class="col col-xs-12">
												<div class="form-group form-group-default required">
													<label class="">{{__('website.iban')}}</label>
													<input type="text" name="iban[]" value="{{@$one->iban}}" id="iban1" class="form-control">
												</div>
											</div>

											<div class="col-auto">
												<div class="row-options clickToRemove">
													<a href="#" class="btn btn-default btn-material" > <i class="material-icons">close</i>  </a>
												</div>
											</div>
										</div>
										@endforeach


										<div class="row client-row">
											<div class="col col-xs-12">
												<div class="form-group form-group-default required">
													<label>{{__('website.bank')}}</label>
													<input type="text" name="bank_name[]" id="name2" class="form-control">
												</div>
											</div>

											<div class="col col-xs-12">
												<div class="form-group form-group-default required">
													<label class="">{{__('website.iban')}}</label>
													<input type="text" name="iban[]" id="iban2" class="form-control">
												</div>
											</div>

											<div class="col-auto">
												<div class="row-options clickToAddMoreBank">
													<a href="#" class="btn btn-material btn-complete" >
													<i class="material-icons">add</i>  </a>
												</div>
											</div>
										</div>
									</div>
                             	</div>
                          	</div>
                      	</div>
                    </div>
                </div>
                <button type="submit" id="clickToAction" style="display:none"></button>
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

	//////////////////  Add More Or Delete One Bank //////////////////
    $(document).on('click','.clickToAddMoreBank',function(e){
		var newElement = $('.divToCopyForBank').html();
		$('.placeToAddMoreElement').append(newElement);
		$(this).html('<a href="#" class="btn btn-default btn-material" > <i class="material-icons">close</i></a>');
		$(this).addClass('clickToRemove').removeClass('clickToAddMoreBank');
		//$('.placeToAddMoreElement .row:last-child').find('select').select2();
	});
	$(document).on('click','.clickToRemove',function(e){
		$(this).parent().parent().fadeOut(700,function(){$(this).remove();});
	});
	/////////////////  End Add More Or Delete One Representive ////////////////
	});
</script>
@endsection