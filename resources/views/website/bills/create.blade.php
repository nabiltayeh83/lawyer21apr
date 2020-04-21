@extends('layout.siteLayout')

@section('title', __('website.addBill'))

@section('topfixed')
<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.addBill')}}</h2>
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
	    <!--            <button type="button" class="btn btn-default has-icon" id="btnFillSizeToggler" data-target="#previwPDF" data-toggle="modal">-->
					<!--	<i class="material-icons">picture_as_pdf</i><span>{{__('website.Preview')}}</span>-->
					<!--</button>-->
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/invoices')}}'">
                        <i class="material-icons">delete_outline</i> <span>{{__('website.cancel')}}</span>
                    </button>

                    <button id="saveAndNew" class="btn btn-complete has-icon mb-2 m-md-0">
                        <i class="material-icons">add</i><span>{{__('website.save_and_add_new')}}</span>
                    </button>

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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/invoices')}}">{{__('website.invoices')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.addBill')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <form action="{{url(app()->getLocale() . '/bills')}}" method="post" id="newInvocieForm" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="card m-0 no-border">
                    <div class="card-header"><h5>{{__('website.data')}}</h5></div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8">
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
                                        						<option value="{{@$one->id}}">{{@$one->name}}</option>
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
                                        			</select>
                                        	    </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.payment_date')}}</label>
                                            <div class="col-md-7">
                                        	    <div class="form-group form-group-default required">
                                        			<label>{{__('website.payment_date')}}</label>
                                        			<input type="text" name="payment_date" class="form-control hijri-date-input" required>
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
                                                            <option value=""></option>
                                                            @foreach(Auth::user()->office_payment_methods as $one)
                                                                <option value="{{@$one->payment_method->id}}">{{@$one->payment_method->name}}</option>
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
                                        			<input type="text" class="form-control" name="reference_number" placeholder="{{__('website.reference_number')}} " required>
                                        		</div>
                                        	</div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                            <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.banks_account')}}</label>
                                            <div class="col-md-7">
                                                <div class="form-group form-group-default form-group-default-select2 required">
                                                    <label>{{__('website.banks_account')}}  </label>
                                                    <select class="full-width invoiceClients" required name="bank_id" id="bank_id" data-init-plugin="select2">
                                                        <optgroup label="{{__('website.banks_account')}}  ">
                                                            <option value=""></option>
                                                            @foreach(Auth::user()->office_banks as $one)
                                                                <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                @error('bank_id')<span class="error">{{ $message }}</span>@enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-3 row">
                                        	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.client_account')}} </label>
                                        	<div class="col-md-7">
                                        		<div class="form-group form-group-default required">
                                        			<label>{{__('website.client_account')}} </label>
                                        			<input type="text" class="form-control" name="client_account" placeholder="{{__('website.client_account')}} " required>
                                        		</div>
                                        	</div>
                                        </div>


                                        <div class="form-group mb-3 row toPayAllAmount">
                                        	<label class="col-md-3 control-label bold fs-14">{{__('website.pay_complete_amount')}}</label>
                                        	<div class="col-md-9">
                                        		<div class="radio radio-success">
                                        			<input type="checkbox" value="yes" name="vat_status" id="payAllAmount">
                                        			<label for="payAllAmount">{{__('website.pay')}}</label>
                                        		</div>
                                        	</div>
                                        </div>

                                        <input type="hidden" value="" name="hiddenAmount" id="hiddenAmount">

                                        <div class="form-group mb-3 row toPayRemainAmount">
                                        	<label class="col-md-3 control-label bold fs-14">{{__('website.complete_remain_amount')}}</label>
                                        	<div class="col-md-9">
                                        		<div class="radio radio-success">
                                        			<input type="checkbox" id="payRemainAmount" type="yes" name="invoice_approval">
                                        			<label for="payRemainAmount">{{__('website.complete')}}</label>
                                        		</div>
                                        	</div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                        	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.amount')}}</label>
                                        	<div class="col-md-7">
                                        		<div class="form-group form-group-default required">
                                        			<label>{{__('website.amount')}}</label>
                                        			<input type="number" class="form-control" name="amount" max="" id="amount" placeholder="{{__('website.amount')}}" required>
                                        		</div>
                                        	</div>
                                        </div>


                                        <div class="form-group mb-3 row">
                                        	<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.details')}}</label>
                                        	<div class="col-md-7">
                                        		<div class="form-group form-group-default">
                                        			<label>{{__('website.details')}}</label>
                                        			<textarea class="form-control" name="details" id="details" ></textarea>
                                        		</div>
                                        	</div>
                                        </div>
                                    </div>
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
									<input type="text" name="attachment_name[]" id="1" class="form-control"/>
								</div>
							</div>

							<div class="col col-xs-12">
								<div class="form-group form-group-default uploadFileRequest required">
                                    <div class="input-file-container">
                                        <label class="input-file-trigger" tabindex="0" for="labelFor">
											<i class="fa fa-upload"></i> {{__('website.upload_file')}} <span>{{__('website.choose_file')}}</span>
                                        </label>
                                        <input type="file" class="uploadAttachFile" id="" name="attachfile[]" size="40">
                                    </div>
                                </div>
							</div>

							<div class="col-auto">
								<div class="row-options clickToAddMoreAttach">
									<a href="#" class="btn btn-material btn-complete" >
									<i class="material-icons">add</i></a>
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
									    <label>{{__('website.attachment_name')}}</label>
									   <input type="text" name="attachment_name[]" id="2" class="form-control"/>
								    </div>
							    </div>

							    <div class="col col-xs-12">
								    <div class="form-group form-group-default uploadFileRequest required">
                                        <div class="input-file-container">
                                            <label tabindex="0" for="file-upload-2" class="input-file-trigger">
                                                <i class="fa fa-upload"></i> {{__('website.upload_file')}} <span>{{__('website.choose_file')}}</span>
                                            </label>
                                            <input type="file" id="file-upload-2" name="attachfile[]" size="40">
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


//clientInvoices

    $(document).on('click','#payAllAmount',function(e){
        var hiddenAmount = $('#hiddenAmount').val();
        if(hiddenAmount){
            $('#amount').val(hiddenAmount);
        }
    });


    $(document).on('click','#payRemainAmount',function(e){
        var hiddenAmount = $('#hiddenAmount').val();
        if(hiddenAmount){
            $('#amount').val(hiddenAmount);

        }
    });



    $(document).on('change','#invoice_id',function(e){
    var invoice_id = $(this).val();
    var url = "{{ url(app()->getLocale().'/getInvoiceData/') }}";

      if(invoice_id){
        $.ajax({
          type: "GET",
          url: url+'/'+invoice_id,
          success: function (response) {
              if(response)
              {


                if(response.invoice_bills >= 1){
                    $('.toPayAllAmount').addClass('hidden');
                    $('#hiddenAmount').val(response.invoice_amount-response.invoice_bills);
                    $('#amount').attr('max', response.invoice_amount-response.invoice_bills);

                }

                if(response.invoice_bills == 0){
                    $('.toPayRemainAmount').addClass('hidden');
                    $('#hiddenAmount').val(response.invoice_amount);
                    $('#amount').attr('max', response.invoice_amount-response.invoice_bills);
                }


              }
          }
        });
      }
      else{
        // $(".clientInvoices").empty();
      }
});






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

    /////////////////////////// Save And Done /////////////////////////
    $(document).on('submit','#newInvocieForm',function(){
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
      $('#newInvocieForm').validate({
			messages:{
				related_project: "{{__('website.required_field')}}",
				aspect_expense_id: "{{__('website.required_field')}}",

				expense_date: "{{__('website.required_field')}}",
				total_amount: "{{__('website.required_field')}}",
                expense_status: "{{__('website.required_field')}}",


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
