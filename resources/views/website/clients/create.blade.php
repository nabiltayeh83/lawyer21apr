@extends('layout.siteLayout')

@section('title', __('website.clients'))

@section('topfixed')
<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.add_client')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
                    </button>
                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/clients')}}'">
                        <i class="material-icons">delete_outline</i> <span> {{__('website.cancel')}} </span>
                    </button>
			    </div>
                <button id="saveAndNew" class="btn btn-complete has-icon mb-2 m-md-0">
                    <i class="material-icons">add</i> <span>{{__('website.save_and_add_new')}}</span>
                </button>
            </div>
		</div>
	</div>
</div>
@endsection

@section('content')

<div class="content">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/clients')}}">
                    {{__('website.clients')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.add_client')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <form action="{{url(app()->getLocale() . '/clients')}}" method="post" id="newClientForm" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="card m-0 no-border">
                    <div class="card-header">
                        <h5>{{__('website.personal_data')}}</h5>
                    </div>
                    <div class="card-body pt-4">
                        <div class="row">
                            <div class="col-md-12 col-lg-8">
								<div class="form-group mb-3 row">
                                    <label class="col-md-3 control-label bold fs-14">
                                        {{__('website.registration_type')}}
                                    </label>
                                    <div class="col-md-9">
										<div class="radio radio-success">
                                            <input type="radio" checked="checked" value="1" name="type" id="userForClick">
											<label for="userForClick">{{__('website.person')}}</label>
                                            <input type="radio" value="2" name="type" id="companyForClick">
										    <label for="companyForClick">{{__('website.company')}}</label>
									    </div>
                                    </div>
                        	    </div>

                                @php
                                    $person_number = $office_settings->clients_number .  str_pad(count($clients)+1, 5, "0", STR_PAD_LEFT);
                                @endphp

                                <div class="userDetails animated fadeIn delay-0.5s">
                                    <div class="form-group mb-3 row">
		                                <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.name')}}</label>
		                                <div class="col-md-7">
			                                <div class="row">
				                                <div class="col-md-8">
					                                <div class="form-group form-group-default required">
						                                <label>{{__('website.fullname')}}</label>
						                                <input type="text" name="person_name" id="person_name" value="{{old('person_name')}}" required class="form-control">
					                                </div>
					                                @error('person_name')<span class="error">{{ $message }}</span>@enderror
				                                </div>
				                                <div class="col-md-4">
					                                <div class="form-group form-group-default">
                                                        <label>{{__('website.client_number')}}</label>
						                                <input type="text" class="form-control" disabled name="person_number" value="{{$person_number}}" id="person_number">
					                                </div>
					                                @error('person_number')<span class="error"> {{ $message }} </span>@enderror
				                                </div>
		    	                            </div>
		                                </div>
                                    </div>

                                    <div class="form-group mb-3 row">
		                                <label class="col-md-3 control-label bold fs-14">{{__('website.gender')}}</label>
		                                <div class="col-md-9">
			                                <div class="radio radio-success">
                                                <input type="radio" checked="checked" value="1" name="gender" id="male">
                                				<label for="male">{{__('website.male')}}</label>
                                                <input type="radio" value="2" name="gender" id="female">
                                			    <label for="female">{{__('website.female')}}</label>
			                                </div>
		                                </div>
	                                </div>
	                                
	                                <div class="form-group mb-3 row">
		                                <label for="position" class="col-md-3 control-label bold fs-14">{{__('website.card_number')}}</label>
		                                <div class="col-md-7">
			                                <div class="row">
				                                <div class="col-md-6">
					                                <div class="form-group form-group-default">
						                                <label>{{__('website.enter_number')}}</label>
						                                <input type="number" name="ID_number" value="{{old('ID_number')}}" id="ID_number" class="form-control">
					                                </div>
				                                </div>
				                                <div class="col-md-6">
					                                <div class="form-group form-group-default form-group-default-select2">
						                                <label>{{__('website.choose_card_type')}}</label>
                                						<select class="full-width" id="card_id" name="card_id" data-init-plugin="select2">
                                							<optgroup label="{{__('website.choose_card_type')}}">
                                                                @foreach($cards as $one)
                                                                    <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                                @endforeach
                                							</optgroup>
                                						</select>
					                                </div>
                            				    </div>
                            			    </div>
                            		    </div>
                            	    </div>

                                    <div class="form-group mb-3 row">
                                        <label class="col-md-3 control-label bold fs-14">{{__('website.location')}}</label>
		                                <div class="col-md-9">
			                                <div class="row">
				                                <div class="col-md-6">
					                                <div class="form-group form-group-default form-group-default-select2 countryDiv required">
						                                <label class="">{{__('website.country')}}</label>
                                						<select class="full-width country" id="person_country_id" required name="person_country_id" data-init-plugin="select2">
                                                            <optgroup label="{{__('website.choose_country')}}">
                                                                <option value=""></option>
                                                                @foreach(Auth::user()->office_countries as $one)
                                                                    <option value="{{@$one->country_id}}">{{@$one->country->name}}</option>
                                                                @endforeach
                                							</optgroup>
                                						</select>
					                                </div>
					                                @error('person_country_id')<span class="error"> {{ $message }} </span>@enderror
				                                </div>
                                				<div class="col-md-6 sm-m-t-10 pl-md-0">
                                					<div class="form-group form-group-default form-group-default-select2 required">
                                						<label class="">{{__('website.city')}}</label>
                                						<select class="full-width city" id="person_city_id" required name="person_city_id" data-init-plugin="select2">
                                						</select>
                                					</div>
                                					@error('person_city_id')<span class="error"> {{ $message }} </span>@enderror
                                				</div>
                                				<div class="col-md-12 p-md-0">
                                					<div class="form-group form-group-default">
                                						<label>{{__('website.address')}}</label>
                                						<input type="text" name="person_address" value="{{old('person_address')}}" id="person_address" class="form-control">
                                					</div>
                                				</div>
                                			</div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mb-3 row">
	                                    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.contact')}}</label>
		                                <div class="col-md-9">
			                                <div class="row">
                                			    <div class="col-md-4">
                                					<div class="form-group form-group-default">
                                					    <label>{{__('website.phone')}}</label>
                                						<input type="number" id="person_phone" value="{{old('person_phone')}}" name="person_phone" class="form-control">
                                					</div>
                                			    </div>
                                    	        <div class="col-md-4">
                                    				<div class="form-group form-group-default">
                                    					<label>{{__('website.mobile')}}</label>
                                    					<input type="number" id="person_mobile" value="{{old('person_mobile')}}" name="person_mobile"  class="form-control">
                                    				</div>
                                    			</div>
                                				<div class="col-md-4">
                                				    <div class="form-group form-group-default required">
                                						<label>{{__('website.email')}}</label>
                                						<input type="email" id="person_email" required value="{{old('person_email')}}" name="person_email" class="form-control">
                                					</div>
                                                </div>
			                                </div>
		                                </div>
	                                </div>
                                </div>
                                <!--  End User Details -->
                                
                                
                                <!--  Company Details -->
                                <div class="companyDetails animated fadeIn delay-0.5s">
                                    
                                    <div class="form-group mb-3 row">
		                                <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.company_name')}}</label>
		                                <div class="col-md-7">
			                                <div class="row">
                                				<div class="col-md-8">
                                					<div class="form-group form-group-default required">
                                						<label>{{__('website.company_name')}}</label>
                                						<input type="text" name="company_name" value="{{old('company_name')}}" id="company_name" class="form-control">
                                					</div>
                                					@error('company_name')<span class="error"> {{ $message }} </span>@enderror
                                				</div>
                                				<div class="col-md-4">
                                					<div class="form-group form-group-default">
                                						<label>{{__('website.company_number')}}</label>
                                                    <input type="text" class="form-control" value="{{$person_number}}" name="company_number" id="company_number" disabled>
                                					</div>
                                					@error('company_number')<span class="error"> {{ $message }} </span>@enderror
                                				</div>
                                			</div>
                                	    </div>
                                    </div>

                                	<div class="form-group mb-3 row">
                                		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.commercial_license')}}</label>
                                		<div class="col-md-7">
                                			<div class="form-group form-group-default">
                                				<label>{{__('website.commercial_license')}}</label>
                                				<input type="text" name="commercial_license" id="commercial_license" value="{{old('commercial_license')}}" class="form-control" >
                                			</div>
                                		</div>
                                	</div>

                                    <div class="form-group mb-3 row">
                                		<label class="col-md-3 control-label bold fs-14">{{__('website.location')}}</label>
                                		<div class="col-md-9">
                                			<div class="row">
                                				<div class="col-md-6">
                                					<div class="form-group form-group-default form-group-default-select2">
                                						<label class="">{{__('website.country')}}</label>
                                						<select class="full-width country" id="company_country_id" name="company_country_id" data-init-plugin="select2">
                                                            <optgroup label="{{__('website.choose_country')}}">
                                                                <option value=""></option>
                                                                @foreach(Auth::user()->office_countries as $one)
                                                                    <option value="{{@$one->country_id}}">{{@$one->country->name}}</option>
                                                                @endforeach
                                							</optgroup>
                                						</select>
                                					</div>
                                				</div>
                                				<div class="col-md-6 sm-m-t-10 pl-md-0">
                                					<div class="form-group form-group-default form-group-default-select2 ">
                                						<label class="">{{__('website.city')}}</label>
                                						<select class="full-width city" id="company_city_id" name="company_city_id" data-init-plugin="select2">
                                						</select>
                                					</div>
                                				</div>
                                				<div class="col-md-12 p-md-0">
                                					<div class="form-group form-group-default">
                                						<label>{{__('website.address')}}</label>
                                						<input type="text" name="company_address" value="{{old('company_address')}}" id="company_address" class="form-control">
                                					</div>
                                				</div>
                                			</div>
                                        </div>
                                    </div>

                                
                                	<div class="form-group mb-3 row">
                                	    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.contact')}}</label>
                                		<div class="col-md-9">
                                			<div class="row">
                                				<div class="col-md-4">
                                					<div class="form-group form-group-default ">
                                						<label>{{__('website.phone')}}</label>
                                						<input type="number" name="company_phone" id="company_phone" value="{{old('company_phone')}}" class="form-control">
                                					</div>
                                				</div>
                                				<div class="col-md-4">
                                					<div class="form-group form-group-default ">
                                					    <label>{{__('website.mobile')}}</label>
                                						<input type="number" name="company_mobile" id="company_mobile" value="{{old('company_mobile')}}" class="form-control">
                                					</div>
                                				</div>
                                				<div class="col-md-4">
                                					<div class="form-group form-group-default ">
                                						<label>{{__('website.email')}}</label>
                                						<input type="email" name="company_email" id="company_email" value="{{old('company_email')}}" class="form-control">
                                					</div>
                                				</div>
                                			</div>
                                		</div>
                                	</div>
                                </div>
                                <!--  End Company Details -->


                                <div class="form-group mb-3 row">
                                	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.notes')}}</label>
                                	<div class="col-md-9">
                                		<div class="form-group form-group-default">
                                			<label>{{__('website.write_note')}}</label>
                                			<textarea class="form-control" name="notes" id="notes">{{old('notes')}}</textarea>
                                		</div>
                                	</div>
                                </div>


                                <div class="form-group mb-3 row">
                                    <label class="col-md-3 control-label bold fs-14"><span>{{__('website.status')}}</span>
                                    <i class="material-icons iconHelp"  data-toggle="tooltip" title="" data-original-title="{{__('website.select_client_status')}}">help</i></label>
                                	<div class="col-md-9">
                                		<div class="radio radio-success">
                                			<input type="radio" value="active" name="status" id="active" checked>
                                			<label for="active">{{__('website.active')}}</label>
                                			<input type="radio" value="not_active" name="status" id="not_active">
                                			<label for="not_active">{{__('website.not_active')}}</label>
                                		</div>
                                	</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

				
				<!-- Div To Copy For Representive -->
				<!---------------------------------->
				<div class="hidden divToCopyForRepresentive">
				    <div class="row client-row">
					    <div class="col col-xs-12">
							<div class="form-group form-group-default required">
								<label>{{__('website.name')}}</label>
								<input type="text" name="rep_name[]" id="rep_name2" class="form-control">
							</div>
						</div>
						<div class="col col-xs-12">
							<div class="form-group form-group-default required rep_address_div">
								<label class="">{{__('website.address')}}</label>
								<input type="text" name="rep_address[]" id="rep_address2" class="form-control">
							</div>
						</div>
						<div class="col col-xs-12">
							<div class="form-group form-group-default required rep_email_div">
								<label class="">{{__('website.email')}}</label>
								<input type="text" name="rep_email[]" id="rep_email2" class="form-control">
							</div>
						</div>
						<div class="col col-xs-12">
							<div class="form-group form-group-default required rep_mobile_div">
								<label class="">{{__('website.mobile')}}</label>
								<input type="number" name="rep_mobile[]" id="rep_mobile2" class="form-control">
							</div>
						</div>
						<div class="col col-xs-12">
							<div class="form-group form-group-default required ">
								<label class="">{{__('website.Description')}}</label>
								<input type="text" name="rep_role_name[]" id="rep_role_name2" class="form-control">
							</div>
						</div>
                        <div class="col-auto">
							<div class="row-options clickToAddMoreRepresentive">
							    <a href="#" class="btn btn-material btn-complete"><i class="material-icons">add</i></a>
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
									    <i class="fa fa-upload"></i> {{__('website.upload_file')}}<span>{{__('website.choose_file')}}</span>
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

                <div class=" card m-0 mt-4 no-border">
                    <div class="card-header ">
                        <h5>{{__('website.client_representative_information')}}</h5>
                    </div>

                    <div class="card-body pt-4 placeToAddMoreElement">
                        <div class="row client-row">
							<div class="col col-xs-12">
								<div class="form-group form-group-default required">
									<label>{{__('website.name')}}</label>
									<input type="text" name="rep_name[]" id="rep_name2" class="form-control">
								</div>
							</div>
							<div class="col col-xs-12">
							    <div class="form-group form-group-default required">
									<label class="">{{__('website.address')}}</label>
									<input type="text" name="rep_address[]" id="rep_address2" class="form-control">
								</div>
							</div>
							<div class="col col-xs-12">
								<div class="form-group form-group-default required">
									<label class="">{{__('website.email')}}</label>
									<input type="text" name="rep_email[]" id="rep_email2" class="form-control">
								</div>
							</div>
							<div class="col col-xs-12">
								<div class="form-group form-group-default required">
									<label class="">{{__('website.mobile')}}</label>
									<input type="number" name="rep_mobile[]" id="rep_mobile2" class="form-control">
								</div>
							</div>
							<div class="col col-xs-12">
								<div class="form-group form-group-default required">
									<label class="">{{__('website.Description')}}</label>
									<input type="text" name="rep_role_name[]" id="rep_role_name2" class="form-control">
								</div>
							</div>
                            <div class="col-auto">
								<div class="row-options clickToAddMoreRepresentive">
									<a href="#" class="btn btn-material btn-complete" ><i class="material-icons">add</i></a>
 								</div>
							</div>
						</div>
					</div>
                </div>

                <div class=" card m-0 mt-4 no-border">
                    <div class="card-header">
                        <h5>{{__('website.attachments')}}</h5>
                    </div>
                <div class="card-body pt-4 placeToAddMoreAttach">

                <div class="row attachments-row">
					<div class="col col-xs-12">
						<div class="form-group form-group-default required">
						    <label class="">{{__('website.attachment_name')}}</label>
							<input type="text" name="attachment_name[]" id="2"  class="form-control"/>
						</div>
					</div>

					<div class="col col-xs-12">
						<div class="form-group form-group-default uploadFileRequest required">
                            <div class="input-file-container">
                                <label tabindex="0" for="file-upload-2" class="input-file-trigger">
                                    <i class="fa fa-upload"></i> {{__('website.upload_file')}}<span>{{__('website.choose_file')}}</span>
                                </label>
                                <input type="file" id="file-upload-2" name="attachfile[]" size="40">
                            </div>
                        </div>
					</div>

					<div class="col-auto">
						<div class="row-options clickToAddMoreAttach">
							<a href="#" class="btn btn-material btn-complete" ><i class="material-icons">add</i></a>
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


	/////////////// Choose Countries & Cities ///////////////
		if($(".country").val() != ''){
			$('.country').change();
		}



    /////////////// Choose User Type Person OR Company ///////////////
    $(document).on('click','#userForClick',function(e){
		$('.companyDetails').hide();
		$('.companyDetails').find(':input').each(function(){
				$(this).removeAttr('required');
		});

		$('#person_name, #person_country_id, #person_city_id').attr("required", "true");

		$('.userDetails').show();
	});

	  	$(document).on('click','#companyForClick',function(e){
		$('.userDetails').hide();
		$('.userDetails').find(':input').each(function(){
				$(this).removeAttr('required');
		});

		$('#company_name, #company_country_id, #company_city_id').attr("required", "true");

		$('.companyDetails').show();
	});
    /////////////// End Choose User Type Person OR Company ///////////////



	//////////////////  Add More Or Delete One Representive //////////////////
    $(document).on('click','.clickToAddMoreRepresentive',function(e){
		var newElement = $('.divToCopyForRepresentive').html();
		$('.placeToAddMoreElement').append(newElement);
		$(this).html('<a href="#" class="btn btn-default btn-material" > <i class="material-icons">close</i></a>');
		$(this).addClass('clickToRemove').removeClass('clickToAddMoreRepresentive');
		//$('.placeToAddMoreElement .row:last-child').find('select').select2();
	});
	$(document).on('click','.clickToRemove',function(e){
		$(this).parent().parent().fadeOut(700,function(){$(this).remove();});
	});
	/////////////////  End Add More Or Delete One Representive ////////////////



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
// 		$("html, body").animate({ scrollTop: "300px" });

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


        $(document).on('submit','#newClientForm',function(){
            $('#saveDone').attr('disabled', 'true');
            $('#saveAndNew').attr('disabled', 'true');
        });


    /////////////////////////// Save And Done /////////////////////////
    $(document).on('click', '#saveDone', function(){
        $('#saveWay').val(0);
        $('#storeNewClient').click();
    });
    ///////////////////////// End Save And Done ///////////////////////

});



	////////////////////////////////////////////////  Validation /////////////////////////////////////////
      $('#newClientForm').validate({
			messages:{
				person_name: "{{__('website.required_field')}}",
				// ID_number: "{{__('website.required_field')}}",
				// person_address: "{{__('website.required_field')}}",
				// person_phone: "{{__('website.required_field')}}",
				// person_mobile: "{{__('website.required_field')}}",
				person_country_id: "{{__('website.required_field')}}",
				person_city_id: "{{__('website.required_field')}}",

				person_email: {
					required: "{{__('website.required_field')}}",
					email: "{{__('website.enter_valid_email')}}",
            	   },


				company_name: "{{__('website.required_field')}}",
				// commercial_license: "{{__('website.required_field')}}",
				// company_address: "{{__('website.required_field')}}",
				// company_phone: "{{__('website.required_field')}}",
				// company_mobile: "{{__('website.required_field')}}",
				company_country_id: "{{__('website.required_field')}}",
				company_city_id: "{{__('website.required_field')}}",
				// company_email: {
				// 		required: "{{__('website.required_field')}}",
				// 		email: "{{__('website.enter_valid_email')}}",
            	// 	   },
			}
	  });

	////////////////////////////////////////////// End Validation ///////////////////////////////////////
</script>
@endsection
