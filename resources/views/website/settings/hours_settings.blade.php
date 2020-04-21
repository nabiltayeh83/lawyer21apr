@extends('layout.siteLayout')

@section('title', __('website.setting_hours'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.setting_hours')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
					</button>
                    <a href="{{url(getLocal(). '/settings')}}">
                        <button type="button" class="btn   btn-default  has-icon" data-target="#modalSlideLeft" data-toggle="modal">
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
                <li class="breadcrumb-item active"> {{__('website.setting_hours')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">

				<form action="{{url(app()->getLocale() . '/hours_settings')}}" method="post" id="newProjectForm" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PUT')}}

                    <div class="card m-0 no-border">
                        <div class="card-header">
                            <h5> {{__('website.setting_hours')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8">



<!--  Choose Project Type -->


<!--  Case Section -->
<div class="">
	<div class="form-group mb-3 row">
        <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.hour_price')}}</label>
        <div class="col-md-7">
			<div class="form-group form-group-default required">
			    <label>{{__('website.hour_price')}} </label>
				<input type="number" class="form-control" name="hour_price" value="{{@$item->hour_price}}" required>
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


@endsection


@section('js')



<script>

$(document).ready(function(){


   /////////////////////////// Save And Done /////////////////////////
    $(document).on('click', '#saveDone', function(){
        $('#storeNewProject').click();
    });


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
