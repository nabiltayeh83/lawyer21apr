@extends('layout.siteLayout')
@section('title', __('website.bills'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3"> {{__('website.editBill')}}</h2>
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


<div class="content ">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/invoices')}}">
                    {{__('website.expenses')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.editBill')}}</li>
            </ol>
        </div>
    </div>
    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
			    <form action="{{url(app()->getLocale() . '/bills/' . $item->id)}}" method="post" id="editTaskForm" autocomplete="off" enctype="multipart/form-data">
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
            <select class="full-width billClients" required name="client_id" id="client_id" data-init-plugin="select2">
                <optgroup label="{{__('website.choose_name')}}">
                    <option value=""></option>
                    @foreach($clients as $one)
                    <option @if($item->client_id == $one->id) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
                    @endforeach
                </optgroup>
            </select>
		</div>
		@error('client_id')<span class="error">{{ $message }}</span>@enderror
	</div>
</div>


<div class="form-group mb-3 row selectProject">
    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.invoice')}}</label>
	<div class="col-md-7">
		<div class="form-group form-group-default form-group-default-select2 required">
            <label>{{__('website.invoice')}} </label>
            <select class="full-width clientInvoices" data-init-plugin="select2" id="invoice_id" required name="invoice_id">
                @foreach($clientInvoices as $one)
                <option @if($item->invoice_id == $one->id) selected @endif value="{{@$one->id}}">
                {{@$one->invoice_number}} - {{@$one->project->name}}</option>
                @endforeach
                </optgroup>
            </select>
        </div>
    </div>
</div>


<div class="form-group mb-3 row">
    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.payment_date')}}</label>
    <div class="col-md-7">
        <div class="form-group form-group-default required">
            <label>{{__('website.payment_date')}}</label>
            <input type="text" name="payment_date" value="{{@$item->payment_date}}" class="form-control hijri-date-input" required>
        </div>
    </div>
</div>


<div class="form-group mb-3 row">
    <label for="fname" class="col-md-3 control-label bold fs-14"> {{__('website.payment_methods')}}</label>
    <div class="col-md-7">
        <div class="form-group form-group-default form-group-default-select2 required">
            <label>{{__('website.payment_methods')}}  </label>
            <select class="full-width invoiceClients" required name="payment_method_id" id="payment_method_id" data-init-plugin="select2">
                <optgroup label="{{__('website.payment_methods')}}  ">
                    @foreach(Auth::user()->office_payment_methods as $one)
                        <option @if($item->payment_method_id == $one->id) selected @endif value="{{@$one->payment_method->id}}">{{@$one->payment_method->name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        @error('payment_method_id')<span class="error"> {{ $message }} </span>@enderror
    </div>
</div>


<div class="form-group mb-3 row">
    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.reference_number')}} </label>
    <div class="col-md-7">
        <div class="form-group form-group-default required">
            <label>{{__('website.reference_number')}}</label>
            <input type="text" class="form-control" value="{{@$item->reference_number}}" name="reference_number" placeholder="{{__('website.reference_number')}} " required>
        </div>
    </div>
</div>


<div class="form-group mb-3 row">
    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.banks_account')}}</label>
    <div class="col-md-7">
        <div class="form-group form-group-default form-group-default-select2 required">
            <label>{{__('website.banks_account')}}  </label>
            <select class="full-width invoiceClients" required name="bank_id" id="bank_id" data-init-plugin="select2">
                <optgroup label="{{__('website.banks_account')}}">
                    <option value=""></option>
                    @foreach(Auth::user()->office_banks as $one)
                    <option @if($item->bank_id == $one->id) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>
        @error('bank_id')<span class="error">{{ $message }}</span>@enderror
    </div>
</div>


<div class="form-group mb-3 row">
    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.amount')}}</label>
    <div class="col-md-7">
        <div class="form-group form-group-default required">
            <label>{{__('website.amount')}}</label>
            <input type="text" class="form-control" value="{{@$item->amount}}" name="amount" id="amount" placeholder="{{__('website.amount')}}" required>
        </div>
    </div>
</div>


<div class="form-group mb-3 row">
    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.details')}}</label>
    <div class="col-md-7">
        <div class="form-group form-group-default">
            <label>{{__('website.details')}}</label>
            <textarea class="form-control" name="details" id="details">{{@$item->details}}</textarea>
        </div>
    </div>
</div>


<div class="form-group mb-3 row">
    <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.client_account')}} </label>
    <div class="col-md-7">
        <div class="form-group form-group-default required">
            <label>{{__('website.client_account')}} </label>
            <input type="text" class="form-control" value="{{@$item->client_account}}" name="client_account" placeholder="{{__('website.client_account')}} " required>
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
						<i class="fa fa-upload"></i> {{__('website.upload_file')}}<span>{{__('website.choose_file')}}</span>
                    </label>
                    <input type="file" class="uploadAttachFile" id="" name="attachfile[]" size="40">
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


<div class="card m-0 mt-4 no-border">
    <div class="card-header">
        <h5>{{__('website.attachments')}}</h5>
    </div>
    <div class="card-body pt-4 placeToAddMoreAttach">
    @if(isset($item->attachments))
    @foreach($item->attachments as $one)
        <div class="row attachments-row">
    		<div class="col col-xs-12">
    			<div class="form-group form-group-default  required">
    				<label class="">{{__('website.attachment_name')}}</label>
    				<input type="text" name="oldattachment_name{{@$one->id}}" value="{{@$one->attachment_name}}" id="1"  class="form-control"/>
    			</div>
    		</div>

    		<div class="col col-xs-12">
    			<div class="form-group form-group-default uploadFileRequest required">
                    <div class="input-file-container">
                        <label tabindex="0" for="file-upload-1" class="input-file-trigger">
                            <i class="fa fa-upload"></i> {{__('website.upload_file')}}<span>{{__('website.choose_file')}}</span>
                        </label>
                        <input type="file" id="file-upload-1"  name="oldattachfile{{$one->id}}" size="40">
                    </div>
                </div>
    		</div>

    		<div class="col-auto">
    			<div class="row-options clickToRemove">
    				<a href="#" class="btn btn-default btn-material"><i class="material-icons">close</i></a>
    			</div>
    		</div>

    		<input type="hidden" name="oldattach_id[]" value="{{@$one->id}}">
    	    <input type="hidden" name="oldfile_uploaded{{@$one->id}}" value="{{@$one->getOriginal('file')}}">
        </div>
    	@endforeach
    	@endif

        <div class="row attachments-row">
			<div class="col col-xs-12">
			    <div class="form-group form-group-default  required">
					<label class="">{{__('website.attachment_name')}}</label>
				    <input type="text" name="attachment_name[]" id="2" class="form-control"/>
				</div>
			</div>

		    <div class="col col-xs-12">
    			<div class="form-group form-group-default uploadFileRequest required">
                    <div class="input-file-container">
                        <label tabindex="0" for="file-upload-2" class="input-file-trigger">
                            <i class="fa fa-upload"></i> {{__('website.upload_file')}}<span>{{__('website.choose_file')}}</span>
                        </label>
                        <input type="file"  id="file-upload-2" name="attachfile[]" size="40">
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

if($(".billClients").val() != ''){
	$('.billClients').change();
}


/////////////////////// View Cities ////////////////////
$(document).on('change','.billClients',function(e){
    var client_id = $(this).val();
    var url = "{{ url(app()->getLocale().'/getClientInvoices/') }}";

      if(client_id){
        $.ajax({
          type: "GET",
          url: url+'/'+client_id,
          success: function (response) {
              if(response)
              {
                $(".clientInvoices").empty();
                $(".clientInvoices").append('<optgroup label="{{__('website.select_invoice')}}">');
				$(".clientInvoices").append('<option value=""></option>');
                $.each(response, function(index, value){
                    var remain_amount = value.invoice_amount - value.invoice_bills;
                    if(remain_amount > 0){
                  $(".clientInvoices").append('<option value="'+value.id+'">'+value.invoice_number+' {{__('website.project_receivables_invoice')}} '+ value.project.name +'</option>');
                    }
                  $(".clientInvoices").append('</optgroup>');
                });
              }
          }
        });
      }
      else{
        $(".clientInvoices").empty();
      }
});




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
