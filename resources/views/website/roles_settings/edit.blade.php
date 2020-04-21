@extends('layout.siteLayout')

@section('title', __('website.roles'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3"> {{__('website.edit')}} {{__('website.roles')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
                    </button>
                    <a href="{{url(getLocal(). '/roles_settings')}}">
                        <button type="button" class="btn btn-default  has-icon" data-target="#modalSlideLeft" data-toggle="modal">
                            <i class="material-icons">delete_outline</i> <span> {{__('website.cancel')}} </span>
                        </button>
                    </a>
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

<div class="content">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/roles_settings')}}">
                    {{__('website.roles')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.edit')}} {{__('website.roles')}}</li>
            </ol>
        </div>
    </div>
    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
			    <form action="{{url(app()->getLocale() . '/roles_settings/' . $item->id)}}" method="post" id="editTaskForm" autocomplete="off" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{method_field('PUT')}}

                    <div class="card m-0 no-border">
                        <div class="card-header">
                            <!--<h5>{{__('website.data')}}</h5>-->
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8 ">


<!--  User Details -->
<div class="userDetails animated fadeIn delay-0.5s">

<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.name')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default required">
			<label>{{__('website.name')}}</label>
			<input type="text" class="form-control" name="name" value="{{$item->name}}" id="name" required>
		</div>
	</div>
</div>


<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.departments')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default required">
			<label>{{__('website.departments')}}</label>
			<select class="full-width" data-init-plugin="select2" multiple id="departments[]" name="departments[]">
				<optgroup label="{{__('website.departments')}}">
				@foreach($departments as $one)
					<option @if(in_array($one->id, $roles_groups_departments)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
				@endforeach
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

	var remindStstus = "{{$item->remind}}";
		if(remindStstus == 'yes'){
			$("#checkNoti").click();
		}

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
