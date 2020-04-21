@extends('layout.siteLayout')

@section('title', __('website.tasks'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <h2 class="page-header mb-1 my-md-3"> {{__('website.add_new_task')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
                    </button>
                    <a href="{{url(getLocal(). '/tasks')}}">
                        <button type="button" class="btn   btn-default  has-icon" data-target="#modalSlideLeft" data-toggle="modal">
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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/tasks')}}">
                    {{__('website.tasks')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.add_new_task')}}</li>
            </ol>
        </div>
    </div>
    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <form action="{{url(app()->getLocale() . '/tasks')}}" method="post" id="newTaskForm" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                    <div class=" card m-0 no-border">
                        <div class="card-header">
                            <h5>{{__('website.data')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8 ">



<!--  User Details -->
<div class="userDetails animated fadeIn delay-0.5s">

<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.task_name')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default required">
			<label>{{__('website.task_name')}}</label>
			<input type="text" class="form-control" name="name" id="name" required>
		</div>
	</div>
</div>


<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.task_category')}}</label>
	<div class="col-md-9">
        <div class="radio radio-success">
            <input type="radio" value="project" name="task_category" required id="projectCategory1">
            <label for="projectCategory1">{{__('website.project')}}</label>
            <input type="radio" value="other" name="task_category" required id="otherCategory1">
            <label for="otherCategory1">{{__('website.other')}}</label>
        </div>
    </div>
</div>

<div class="form-group mb-3 row hidden selectProject">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.project_name')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default form-group-default-select2">
			<label>{{__('website.select_project_name')}}</label>
			<select class="full-width" data-init-plugin="select2" id="project_id" name="project_id">
				<optgroup label="{{__('website.select_project_name')}}">
					<option value=""></option>
					@foreach($projects as $one)
						<option value="{{@$one->id}}">{{@$one->name}}</option>
					@endforeach
				</optgroup>
			</select>
		</div>
	</div>
</div>

<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.task_type')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default form-group-default-select2">
			<label>{{__('website.select_task_type')}}</label>
			<select class="full-width" data-init-plugin="select2" id="task_type_id" name="task_type_id">
				<optgroup label="{{__('website.select_task_type')}}">
					<option value=""></option>
					@foreach($task_types as $one)
						<option value="{{@$one->id}}">{{@$one->name}}</option>
					@endforeach
				</optgroup>
			</select>
		</div>
	</div>
</div>


<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.task_details')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default">
			<label>{{__('website.task_details')}}</label>
			<textarea class="form-control" name="details" id="details"></textarea>
		</div>
	</div>
</div>


<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.task_status')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default form-group-default-select2">
			<label>{{__('website.select_task_status')}}</label>
			<select class="full-width" data-init-plugin="select2" id="task_status_id" name="task_status_id">
				<optgroup label="{{__('website.select_task_status')}}">
					<option value=""></option>
					@foreach($task_status as $one)
						<option value="{{$one->id}}">{{$one->name}}</option>
					@endforeach
				</optgroup>
			</select>
		</div>
	</div>
</div>


<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.priority')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default form-group-default-select2">
			<label>{{__('website.select_priority')}}</label>
			<select class="full-width" data-init-plugin="select2" id="priority" name="priority">
				<optgroup label="{{__('website.select_priority')}}">
					<option value="normal">{{__('website.normal')}}</option>
					<option value="urgent">{{__('website.urgent')}}</option>
				</optgroup>
			</select>
		</div>
	</div>
</div>


<div class="form-group mb-3 row">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.task_end_date')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default">
			<label>{{__('website.task_end_date')}}</label>
			<input type="text" name="end_date" class="form-control end_date">
	    </div>
	</div>
</div>


<div class="form-group mb-3 row">
    <label for="position" class="col-md-3 control-label bold fs-14">{{__('website.task_employees')}}</label>
    <div class="col-md-7">
        <div class="form-group form-group-default form-group-default-select2 required">
            <label class="">{{__('website.choose_emp')}}</label>
            <select class="full-width" data-init-plugin="select2" multiple
            id="task_employees[]" name="task_employees[]">
                <optgroup label="{{__('website.choose_emp_name')}}">
                @foreach($employees as $one)
                    <option value="{{@$one->id}}">{{@$one->name}}</option>
                @endforeach
                </optgroup>
            </select>
        </div>
    </div>
</div>


<div class="form-group d-flex align-items-center">
	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.reminder')}}</label>
	<div class="col-md-7">
		<div class="radio radio-success">
			<input type="radio" value="yes" name="remind" id="checkNoti">
            <label for="checkNoti">{{__('website.reminder_about_task_time')}}</label>
        </div>

		<div class="animated fadeIn delay-0.5s" id="typeNoti">
			<div class="row">
				<div class="col-md-7">
					<div class="form-group form-group-default form-group-default-select2">
						<label></label>
						<select class="full-width" data-init-plugin="select2" id="remind_type" name="remind_type">
							<optgroup label="{{__('website.choose_reminder_type')}}">
								<option value=""></option>
								<option value="email">{{__('website.email')}}</option>
								<option value="window">{{__('website.window')}}</option>
								<option value="whatsapp">{{__('website.whatsapp')}}</option>
							</optgroup>
						</select>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group form-group-default form-group-default-select2">
						<label>{{__('website.period')}}</label>
						<select class="full-width" data-init-plugin="select2" id="remind_time_id" name="remind_time_id">
							<optgroup label="{{__('website.choose_period')}}">
								<option value=""></option>
								@foreach($reminer_time as $one)
									<option value="{{@$one->id}}">{{@$one->name}}</option>
								@endforeach
							</optgroup>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="form-group mb-3 row">
	<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.responsible_emp')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default form-group-default-select2 required">
			<label class="">{{__('website.choose_responsible_emp')}}</label>
			<select class="full-width" data-init-plugin="select2" id="responsible_employee" name="responsible_employee">
				<optgroup label="{{__('website.choose_responsible_emp')}}">
				@foreach($employees as $one)
					<option value="{{@$one->id}}">{{@$one->name}}</option>
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


<!-- Div To Copy For Attach -->
<!---------------------------------->
<div class="hidden divToCopyForAttach">
    <div class="row attachments-row">
		<div class="col col-xs-12">
		    <div class="form-group form-group-default required">
				<label class="">{{__('website.attachment_name')}}</label>
				<input type="text" name="attachment_name[]" id="1" class="form-control"/>
			</div>
		</div>

		
		<div class="col col-xs-12">
			<div class="form-group form-group-default uploadFileRequest required">
                <div class="input-file-container">
                    <label class="input-file-trigger" tabindex="0" for="labelFor">
					    <i class="fa fa-upload"></i> {{__('website.upload_file')}}
						<span>{{__('website.choose_file')}}</span>
                    </label>
                    <input type="file" class="uploadAttachFile" id="" name="attachfile[]" size="40">
                </div>
            </div>
		</div>

        <div class="col-auto">
		    <div class="row-options clickToAddMoreAttach">
				<a href="#" class="btn btn-material btn-complete"><i class="material-icons">add</i>  </a>
            </div>
		</div>
	</div>
</div>

<div class=" card m-0 mt-4 no-border">
    <div class="card-header ">
        <h5>{{__('website.attachments')}}</h5>
    </div>
    
    <div class="card-body pt-4 placeToAddMoreAttach">
        <div class="row attachments-row">
		    <div class="col col-xs-12">
			    <div class="form-group form-group-default required">
					<label class="">{{__('website.attachment_name')}}</label>
					<input type="text" name="attachment_name[]" id="2" class="form-control"/>
				</div>
			</div>

			<div class="col col-xs-12">
                <div class="form-group form-group-default uploadFileRequest required">
                    <div class="input-file-container">
                        <label tabindex="0" for="file-upload-2" class="input-file-trigger">
                            <i class="fa fa-upload"></i> {{__('website.upload_file')}}
                            <span>{{__('website.choose_file')}}</span>
                        </label>
                        <input type="file"  id="file-upload-2" name="attachfile[]" size="40" >
                    </div>
                </div>
			</div>

			<div class="col-auto">
			    <div class="row-options clickToAddMoreAttach">
					<a href="#" class="btn btn-material btn-complete"><i class="material-icons">add</i>  </a>
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

    $(document).on('submit','#newTaskForm',function(){
    $('#saveDone').attr('disabled', 'true');
    $('#saveAndNew').attr('disabled', 'true');
    });

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

				task_type_id: "{{__('website.required_field')}}",

				task_status_id: "{{__('website.required_field')}}",
				priority: "{{__('website.required_field')}}",

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
		  $('#typeNoti').toggle();
	  	});



		$(document).on('change','#NumberofHours',function(e){
		  $('#NumberofHoursOne').hide();
		  ($(this).val() == 2)? $('#NumberofHoursOne').show():"";
		  ($(this).val() == 1)? $('#NumberofHoursOne').hide():"";
	  	});
	</script>

@endsection
