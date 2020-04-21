@extends('layout.siteLayout')

@section('title', __('website.setting_profile'))


@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <h2 class="page-header mb-1 my-md-3"> {{__('website.setting_profile')}} </h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
					</button>
                    <a href="{{url('/')}}">
                        <button type="button" class="btn btn-default has-icon" data-target="#modalSlideLeft" data-toggle="modal">
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

<div class="content">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/settings')}}">
                   {{__('website.settings')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.setting_profile')}}</li>
            </ol>
        </div>
    </div>
    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">

				<form action="{{url(app()->getLocale() . '/profile')}}" method="post" id="newProjectForm" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PUT')}}

                    <div class=" card m-0 no-border">
                        <div class="card-header">
                            <h5>{{__('website.data')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8">



<!--  Choose Project Type -->
<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.account_photo')}} </label>
	<div class="col-md-7">
	    <div class="form-group form-group-default">
		    <div class="avatar-upload">
				<div class="avatar-edit">
					<input type='file' name="file" id="imageUpload" accept=".png, .jpg, .jpeg" />
					<label for="imageUpload"><i class="material-icons">edit</i></label>
				</div>
		        <div class="avatar-preview">
					<div id="imagePreview" style="background-image:url({{@$item->image}});">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!--  Case Section -->
<div class="">
    <div class="form-group mb-3 row">
		<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.name')}}</label>
		<div class="col-md-7">
			<div class="form-group form-group-default required">
				<label>{{__('website.name')}}</label>
			    <input type="text" class="form-control" name="name" value="{{@$item->name}}" required>
			</div>
		</div>
	</div>


    <div class="form-group mb-3 row">
	    <label class="col-md-3 control-label bold fs-14">{{__('website.address')}}</label>
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group form-group-default form-group-default-select2 required">
						<label class="">{{__('website.country')}}</label>
						<select class="full-width countryEditForm" id="country_id" required name="country_id" data-init-plugin="select2">
							<optgroup label="{{__('website.choose_country')}}">
                                @foreach(Auth::user()->office_countries as $one)
                                <option value="{{@$one->country_id}}" {{$item->country_id == $one->country_id? "selected": ""}}>
								{{@$one->country->name}}</option>
                                @endforeach
    						</optgroup>
						</select>
					</div>
			    </div>
									
				<div class="col-md-6 sm-m-t-10 pl-md-0">
					<div class="form-group form-group-default form-group-default-select2 required">
						<label class="">{{__('website.city')}}</label>
						<select class="full-width city" id="city_id" required name="city_id" data-init-plugin="select2">
						    <optgroup label="{{__('website.choose_city')}}">
                                @foreach($cities as $one)
                                    <option value="{{@$one->id}}" {{$item->city_id == $one->id? "selected": ""}}>{{@$one->name}}</option>
                                @endforeach
							</optgroup>
						</select>
					</div>
				</div>
				
				<div class="col-md-12 p-md-0">
					<div class="form-group form-group-default">
						<label>{{__('website.address')}}</label>
					    <input type="text" name="address" value="{{@$item->address}}" class="form-control">
					</div>
				</div>
			</div>
		</div>
	</div>
								

    <div class="form-group mb-3 row">
	    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.mobile')}}</label>
		<div class="col-md-7">
			<div class="form-group form-group-default required">
				<label>{{__('website.mobile')}} </label>
				<input type="number" name="mobile" value="{{@$item->mobile}}" class="form-control" required>
			</div>
		</div>
    </div>


	<div class="form-group mb-3 row">
		<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.email')}}</label>
		<div class="col-md-7">
			<div class="form-group form-group-default required">
			    <label>{{__('website.email')}}</label>
				<input type="email" name="email" value="{{@$item->email}}" class="form-control" required>
			</div>
	    </div>
    </div>

</div>
</div>
</div>
</div>
</div>

</div>
<button type="submit" id="storeNewProject" style="display:none"></button>
<input type="hidden" name="saveway" id="saveWay" value="0">
</form>
</div>
</div>
</div>
</div>



<div class="modal fade slide-right" id="modalAddClients" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6>{{__('website.add_new_client')}}</h6>
				</div>
				<div class="container-xs-height full-height">
				  <div class="row-xs-height">
					<div class="modal-body col-xs-height  ">
						<form id="formAddTask" method="post" action="app-calendar.html">
							  <div class="radio radio-success">
								<input type="radio" checked="checked" value="user" name="type" id="userForClick">
								<label for="userForClick">{{__('website.person')}}</label>
								<input type="radio" value="company" name="type" id="companyForClick">
								<label for="companyForClick">{{__('website.company')}}</label>
							  </div>
							<div class="form-group form-group-default required">
								<label>{{__('website.name')}}</label>
								<input type="text" class="form-control" required >
							</div>
							<div class="form-group form-group-default">
								<label>{{__('website.client_number')}}</label>
								<input type="text" class="form-control" placeholder="MJK748PP">
							</div>
							<div class="row">
							  <div class="col-md-6">
								  <div class="form-group form-group-default ">
									  <label>{{__('website.card_number')}}</label>
									  <input type="text" class="form-control" >
								  </div>
							  </div>
							  <div class="col-md-6">
								  <div class="form-group form-group-default form-group-default-select2 ">
									  <label>{{__('website.choose_card_type')}}</label>
									  <select class="full-width" data-init-plugin="select2">
										<optgroup label="{{__('website.choose_card_type')}}">
										<option value=""> </option>
										<option value=""></option>
										</optgroup>
									  </select>
								  </div>
							  </div>
						  </div>
						  <div class="row">
							  <div class="col-md-6">
								  <div class="form-group form-group-default form-group-default-select2 ">
									  <label>{{__('website.choose_country')}}</label>
									  <select class="full-width" data-init-plugin="select2">
										<optgroup label="{{__('website.choose_country')}}">
										<option value=""></option>ion>
										</optgroup>
									  </select>
								  </div>
							  </div>
							  <div class="col-md-6">
								  <div class="form-group form-group-default form-group-default-select2 ">
									  <label>{{__('website.choose_city')}}</label>
									  <select class="full-width" data-init-plugin="select2">
										<optgroup label="{{__('website.choose_city')}}">
										<option value=""> </option>
										</optgroup>
									  </select>
								  </div>
							  </div>
						  </div>
						  <div class="form-group form-group-default">
								<label>{{__('website.address')}}</label>
								<input type="text" class="form-control" placeholder="MJK748PP" >
						  </div>
						  <div class="row">
							  <div class="col-md-6">
								  <div class="form-group form-group-default ">
										<label>{{__('website.phone')}}</label>
										<input type="text" class="form-control" >
								  </div>
							  </div>
							  <div class="col-md-6">
								  <div class="form-group form-group-default">
										<label>{{__('website.email')}}</label>
										<input type="email" class="form-control" >
								  </div>
							  </div>
						  </div>
						</form>
						<button type="button" class="btn btn-complete btn-block" data-dismiss="modal"> {{__('website.save')}} </button>
						<button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
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


    var typeProfile = "{{$item->type}}";
    var feeType	 = "{{$item->fee_type}}";


	////////////////////////////// Choose Type ////////////////////////////
	    // secCase
	    $(document).on('click','#caseForClick',function(e){
		  $('.secCase,.secConsultation,.secOther').hide();
			$('.secConsultation, .secOther').find(':input').each(function(){
				$(this).removeAttr('required');
			});

			$('#case_client_id, #case_name, #case_fee_type, #case_details,#case_lawsuit_id, #case_project_status').attr("required", "true");

		  $('.secCase').show();
	  	});


		//secConsultation
	  	$(document).on('click','#ConsultationForClick',function(e){
			$('.secCase,.secConsultation,.secOther').hide();

			$('.secCase, .secOther').find(':input').each(function(){
				$(this).removeAttr('required');
			});

            $('#consultation_client_id, #consultation_name, #consultation_consultation_id, #consultation_status, #consultation_details').attr("required", "true");

			$('.secConsultation').show();
	  	});



		$(document).on('click','#OtherForClick',function(e){
		  $('.secCase,.secConsultation,.secOther').hide();

		  $('.secCase, .secConsultation').find(':input').each(function(){
				$(this).removeAttr('required');
		    });

			$('#other_client_id, #other_name, #other_details, #other_status').attr("required", "true");

		  $('.secOther').show();
	  	});



if(typeProfile == 1){ // Edit For Case
    $('.secCase,.secConsultation,.secOther').hide();
    $('.secConsultation, .secOther').find(':input').each(function(){
        $(this).removeAttr('required');
    });
    $('#case_client_id, #case_name, #case_fee_type, #case_details,#case_lawsuit_id, #case_project_status').attr("required", "true");
    $('.secCase').show();
}



if(typeProfile == 2){ // Edit For secConsultation
    $('.secCase,.secConsultation,.secOther').hide();
    $('.secCase, .secOther').find(':input').each(function(){
        $(this).removeAttr('required');
    });
      $('#consultation_client_id, #consultation_name, #consultation_consultation_id, #consultation_status, #consultation_details').attr("required", "true");
    $('.secConsultation').show();
}


if(typeProfile == 3){ // Edit For Other
    $('.secCase,.secConsultation,.secOther').hide();
    $('.secCase, .secConsultation').find(':input').each(function(){
        $(this).removeAttr('required');
    });
    $('#other_client_id, #other_name, #other_details, #other_status').attr("required", "true");
    $('.secOther').show();
}




if(typeProfile == 1 && feeType == 1){
			$('#feesTypeOne, #feesTypeTwo').hide();
		  	$('#feesTypeOne').show();
		}

		if(typeProfile == 1 && feeType == 2){
			$('#feesTypeOne, #feesTypeTwo').hide();
		  	$('#feesTypeTwo').show();
		}



		if(typeProfile == 2 && feeType == 1){
			$('#feesTypeOneConsultation, #feesTypeTwoConsultation').hide();
			$('#feesTypeOneConsultation').show();
		}


		if(typeProfile == 2 && feeType == 2){
			$('#feesTypeOneConsultation, #feesTypeTwoConsultation').hide();
			$('#feesTypeTwoConsultation').show();
		}





		////////////////////////////// Choose Fees Type for Case ////////////////////////////
		$(document).on('change','#case_fee_type',function(e){
		  $('#feesTypeOne, #feesTypeTwo').hide();
		  ($(this).val() == '1')? $('#feesTypeOne').show():"";
		  ($(this).val() == '2')? $('#feesTypeTwo').show():"";
	  	});


		////////////////////////////// Choose Fees Type for Consultation ////////////////////////////
		$(document).on('change','#feesTypeConsultation',function(e){
		  $('#feesTypeOneConsultation, #feesTypeTwoConsultation').hide();
		  ($(this).val() == 1)? $('#feesTypeOneConsultation').show():"";
		  ($(this).val() == 2)? $('#feesTypeTwoConsultation').show():"";
	  	});



             ///////////////////////// Save And Add New One ///////////////////////
    $(document).on('click', '#saveAndNew', function(){
        $('#saveWay').val(1);
        $('#storeNewProject').click();
    });
    /////////////////////// End Save And Add New One /////////////////////

    /////////////////////////// Save And Done /////////////////////////
        $(document).on('click', '#saveDone', function(){
        $('#saveWay').val(0);
        $('#storeNewProject').click();
    });
    ///////////////////////// End Save And Done ///////////////////////





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
		$("html, body").animate({ scrollTop: "300px" });

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




	////////////////////////////////////////////////  Validation /////////////////////////////////////////
    $('#newProjectForm').validate({
			messages:{
				case_client_id: "{{__('website.required_field')}}",
				case_name: "{{__('website.required_field')}}",
				case_fee_type: "{{__('website.required_field')}}",
				case_details: "{{__('website.required_field')}}",
				case_lawsuit_id: "{{__('website.required_field')}}",
				case_project_status: "{{__('website.required_field')}}",

				consultation_client_id: "{{__('website.required_field')}}",
				consultation_name: "{{__('website.required_field')}}",
				consultation_consultation_id: "{{__('website.required_field')}}",
				consultation_status: "{{__('website.required_field')}}",
				consultation_details: "{{__('website.required_field')}}",

				other_client_id: "{{__('website.required_field')}}",
				other_name: "{{__('website.required_field')}}",
				other_details: "{{__('website.required_field')}}",
				other_status: "{{__('website.required_field')}}",

    }});


	});



			function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#imagePreview').css('background-image', 'url('+e.target.result +')');
				$('#imagePreview').hide();
				$('#imagePreview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
			}
		}
		$("#imageUpload").change(function() {
			readURL(this);
		});

	////////////////////////////////////////////// End Validation ///////////////////////////////////////
</script>
@endsection
