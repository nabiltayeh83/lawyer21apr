@extends('layout.siteLayout')
@section('title', __('website.projects'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <h2 class="page-header mb-1 my-md-3">{{__('website.add_project')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
                    </button>
                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/projects')}}'">
                        <i class="material-icons">delete_outline</i> <span>{{__('website.cancel')}}</span>
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

<div class="content ">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/projects')}}">
                    {{__('website.projects')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.add_project')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <form action="{{url(app()->getLocale() . '/projects')}}" method="post" id="newProjectForm" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                    
                    <div class="card m-0 no-border">
                        <div class="card-header ">
                            <h5>{{__('website.personal_data')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
        
                                <div class="col-md-12 col-lg-8">
            
                                    <!--  Choose Project Type -->
                                    <div class="form-group mb-3 row">
                                        <label class="col-md-3 control-label bold fs-14">{{__('website.project_type')}}</label>
                                        <div class="col-md-9">
                                            <div class="radio radio-success">
                                                <input type="radio" checked="checked" value="1" name="type" id="caseForClick">
                                                <label for="caseForClick">{{__('website.issue')}}</label>
                                                <input type="radio" value="2" name="type" id="ConsultationForClick">
                                            	<label for="ConsultationForClick">{{__('website.consultation')}}</label>
                                    			<input type="radio" value="3" name="type" id="OtherForClick">
                                                <label for="OtherForClick">{{__('website.other')}}</label>
                                            </div>
                                        </div>
                                    </div>
            
            
                                    @php
                                    $project_number = $office_settings->projects_number . str_pad(count($projects)+1, 5, "0", STR_PAD_LEFT);
                                    @endphp
            
            
                                        <!--  Case Section -->
                                        <div class="secCase animated fadeIn delay-0.5s">
            
                                        	<div class="form-group mb-3 row">
                                        		<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.client_name')}}</label>
                                        		<div class="col-md-6">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label>{{__('website.client_name')}}</label>
                                        				<select class="full-width" required name="case_client_id" id="case_client_id" data-init-plugin="select2">
                                        					<optgroup label="{{__('website.choose_name')}}">
                                        					    @if(isset($clients))
                                        					@foreach($clients as $one)
                                        						<option {{($client_id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
                                        					@endforeach
                                        					@endif
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        			@error('case_client_id')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        
                                        		<div class="col-md-1">
                                        			<a data-target="#modalAddClients" data-toggle="modal" class="buttonAdd"><i class="material-icons">add</i><span>إضافة</span></a>
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.client_description')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.choose_client_description')}}</label>
                                        				<select class="full-width" data-init-plugin="select2" id="client_description_id" name="client_description_id">
                                        					<optgroup label="{{__('website.choose_client_description')}}">
                                        					<option value=""></option>
                                        					@if(isset($clients_descriptions))
                                        					@foreach($clients_descriptions as $one)
                                        						<option value="{{@$one->id}}">{{@$one->name}}</option>
                                        					@endforeach
                                        					@endif
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        		</div>
                                        	</div>
            	
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.issue_name')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default required">
                                        				<label>{{__('website.write_issue_name')}}</label>
                                        				<input type="text" class="form-control" name="case_name" id="case_name" required>
                                        			</div>
                                        			@error('case_name')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.court_name')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default required">
                                        				<label>{{__('website.court_name')}}</label>
                                        				<input type="text" class="form-control" name="court_name" id="court_name" required>
                                        			</div>
                                        			@error('case_name')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                        		<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.issue_number')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="row">
                                        				<div class="col-md-6">
                                        					<div class="form-group form-group-default fieldCase">
                                        						<label>{{__('website.issue_number_in_the_system')}}</label>
                                                            <input type="text" class="form-control" name="case_issue_number" id="case_issue_number" value="{{$project_number}}" disabled>
                                        					</div>
                                        				</div>
                                        				<div class="col-md-6">
                                        					<div class="form-group form-group-default">
                                                                <label><span>{{__('website.reference_number')}}</span>
                                                                <i class="material-icons iconHelp" data-toggle="tooltip" title="" data-original-title="{{__('website.reference_number_for_this_case')}}">help</i> </label>
                                        						<input type="text" class="form-control" name="case_reference_number" id="case_reference_number">
                                        					</div>
                                        				</div>
                                        			</div>
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.issues_case')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.issues_case')}}</label>
                                        				<select class="full-width" required data-init-plugin="select2" name="case_project_status" id="case_project_status">
                                        					<optgroup label="{{__('website.choose_issues_case')}}">
                                        					@for($i=1; $i<=3; $i++)
                                        						<option value="{{$i}}">{{__('website.project_status'.$i)}}</option>
                                        					@endfor
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        			@error('case_project_status')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
            	
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.issue_description')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default">
                                        				<label>{{__('website.write_issue_description')}}</label>
                                        				<textarea class="form-control" name="case_details" id="case_details"></textarea>
                                        			</div>
                                        			@error('case_details')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.fees_type')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.choose_fees_type')}}</label>
                                        				<select class="full-width" data-init-plugin="select2" required name="case_fee_type" id="case_fee_type">
                                        					<optgroup label="{{__('website.choose_fees_type')}}">
                                        					<option value=""></option>
                                        					@for($i=1; $i<=3; $i++)
                                        						<option value="{{$i}}">{{__('website.fee_type'.$i)}}</option>
                                        					@endfor
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        			@error('case_fee_type')<span class="error"> {{ $message }} </span>@enderror
                                        			<div class="animated fadeIn delay-0.5s" id="feesTypeOne">
                                        				<div class="row">
                                        					<div class="col-md-12">
                                        						<div class="form-group form-group-default">
                                        							<label>{{__('website.value_hour')}}</label>
                                        							<input type="number" name="case_value_per_hour" id="case_value_per_hour" class="form-control">
                                        						</div>
                                        					</div>
                                        				</div>
                                        			</div>
                                        			<div class="row animated fadeIn delay-0.5s" id="feesTypeTwo">
                                        				<div class="col-md-12">
                                        					<div class="form-group form-group-default fieldCase">
                                        						<label>{{__('website.issue_fees')}}</label>
                                        						<input type="number" name="case_issue_fees" id="case_issue_fees" class="form-control">
                                        					</div>
                                        				</div>
                                        			</div>
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.type_suit')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.type_suit')}}</label>
                                        				<select class="full-width" required data-init-plugin="select2" name="case_lawsuit_id" id="case_lawsuit_id">
                                        					<optgroup label="{{__('website.choose_type')}}">
                                        					    @if(isset(Auth::user()->office_lawsuits))
                                        					@foreach(Auth::user()->office_lawsuits as $one)
                                        						<option value="{{@$one->lawsuit_id}}">{{@$one->lawsuit->name}}</option>
                                        					@endforeach
                                        					@endif
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        			@error('case_lawsuit_id')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                                <label class="col-md-3 control-label bold fs-14">{{__('website.details')}}</label>
                                                <div class="col-md-7">
                                        			<div class="row">
                                        				<div class="col-md-6">
                                        					<div class="form-group form-group-default">
                                        						<label class="">{{__('website.start_project_date')}}</label>
                                        						<input type="text" class="form-control hijri-date-input" name="start_project_date">
                                        					</div>
                                        				</div>
                                        				<div class="col-md-6 p-md-0">
                                        					<div class="form-group form-group-default ">
                                        						<label class="">{{__('website.gov_institution')}}</label>
                                        						<input type="text" class="form-control" name="case_gov_institution" id="case_gov_institution">
                                        					</div>
                                        				</div>
                                        			</div>
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                                <label class="col-md-3 control-label bold fs-14">{{__('website.contender')}}</label>
                                                <div class="col-md-7">
                                        			<div class="row">
                                        				<div class="col-md-6">
                                        					<div class="form-group form-group-default form-group-default-select2 required">
                                        					<label class="">{{__('website.choose_contender_type')}}</label>
                                                			<select class="full-width" data-init-plugin="select2" id="contender_id" name="contender_id">
                                                				<optgroup label="{{__('website.choose_contender_type')}}">
                                        							<option value=""></option>
                                        							@if(isset(Auth::user()->office_contenders))
                                        							@foreach(Auth::user()->office_contenders as $one)
                                        								<option value="{{@$one->contender_id}}">{{@$one->contender->name}}</option>
                                        							@endforeach
                                        							@endif
                                                				</optgroup>
                                                			</select>
                                                		</div>
                                        			</div>
                                        		<div class="col-md-6 sm-m-t-10 pl-md-0">
                                        			<div class="form-group form-group-default ">
                                        				<label class="">{{__('website.contender_name')}}</label>
                                        				<input type="text" class="form-control" name="contender_name" id="contender_name">
                                        			</div>
                                        		</div>
                                        		<div class="col-md-12 p-md-0">
                                        			<div class="form-group form-group-default ">
                                        				<label class="">{{__('website.contender_address')}}</label>
                                        				<input type="text" class="form-control" name="contender_address" id="contender_address">
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
                                        				<select class="full-width" data-init-plugin="select2"
                                        				id="responsible_lawyer" name="responsible_lawyer">
                                        					<optgroup label="{{__('website.choose_responsible_emp')}}">
                                        					    @if(isset(Auth::user()->office_employees))
                                        					@foreach(Auth::user()->office_employees as $one)
                                        						<option value="{{@$one->id}}">{{@$one->name}}</option>
                                        					@endforeach
                                        					@endif
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        		</div>
                                        	</div>
            
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.project_employees')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.choose_emp')}}</label>
                                        				<select class="full-width" data-init-plugin="select2" multiple
                                        				id="project_employees[]" name="project_employees[]">
                                        					<optgroup label="{{__('website.choose_emp_name')}}">
                                        					    @if(isset(Auth::user()->office_employees))
                                        					@foreach(Auth::user()->office_employees as $one)
                                        						<option value="{{@$one->id}}">{{@$one->name}}</option>
                                        					@endforeach
                                        					@endif
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        		</div>
                                            </div>
            
                                        </div>
            
                                        <!--  Consultation Section -->
                                        
                                        <div class="secConsultation animated fadeIn delay-0.5s">
                                        	<div class="form-group mb-3 row">
                                        		<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.client_name')}}</label>
                                        		<div class="col-md-6">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label>{{__('website.choose_client_name')}}</label>
                                        				<select class="full-width" required id="consultation_client_id" name="consultation_client_id" data-init-plugin="select2">
                                        					<optgroup label="{{__('website.choose_name')}}">
                                        					    @if(isset($clients))
                                        					@foreach($clients as $one)
                                        						<option {{($client_id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
                                        					@endforeach
                                        					@endif
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        			@error('consultation_client_id')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        		<div class="col-md-1">
                                        			<a data-target="#modalAddClients" data-toggle="modal" class="buttonAdd"><i class="material-icons">add</i><span>إضافة</span></a>
                                        		</div>
                                        	</div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.consultation_name')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default required">
                                        				<label>{{__('website.write_consultation')}}</label>
                                        				<input type="text" name="consultation_name" id="consultation_name" class="form-control">
                                        			</div>
                                        			@error('consultation_name')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
                                        
                                        
                                        
                                            <div class="form-group mb-3 row">
                                        		<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.consultation_number')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="row">
                                        				<div class="col-md-6">
                                        					<div class="form-group form-group-default fieldCase">
                                        						<label>{{__('website.consultation_number_in_the_system')}}</label>
                                                            <input type="text" class="form-control" name="consultation_number" id="consultation_number" value="{{$project_number}}" disabled>
                                        					</div>
                                        				</div>
                                        				<div class="col-md-6">
                                        					<div class="form-group form-group-default">
                                                                <label><span>{{__('website.reference_number')}}</span>
                                                                <i class="material-icons iconHelp" data-toggle="tooltip" title="" data-original-title="{{__('website.reference_number_for_this_case')}}">help</i> </label>
                                        						<input type="text" class="form-control" name="consultation_reference_number" id="consultation_reference_number">
                                        					</div>
                                        				</div>
                                        			</div>
                                        		</div>
                                        	</div>
                                        
                                        
                                        
                                        
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.consultation_type')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.consultation_type')}}</label>
                                        				<select class="full-width" data-init-plugin="select2" name="consultation_consultation_id" id="consultation_consultation_id">
                                        					<optgroup label="{{__('website.choose_type')}}">
                                        					    @if(isset(Auth::user()->office_consultations))
                                        					@foreach(Auth::user()->office_consultations as $one)
                                        						<option value="{{@$one->consultation_id}}">{{@$one->consultation->name}}</option>
                                        					@endforeach
                                        					@endif
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        			@error('consultation_consultation_id')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
                                        
                                        
                                        
                                        
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.consultation_status')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.consultation_status')}}</label>
                                        				<select class="full-width" data-init-plugin="select2" name="consultation_status" id="consultation_status">
                                        					<optgroup label="{{__('website.choose_status')}}">
                                        					@for($i=1; $i<=3; $i++)
                                        						<option value="{{$i}}">{{__('website.project_status'.$i)}}</option>
                                        					@endfor
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        			@error('consultation_consultaconsultation_statustion_id')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
                                        
                                        
                                        
                                        
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.consultation_details')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default">
                                        				<label>{{__('website.write_consultation_details')}}</label>
                                        				<textarea class="form-control" name="consultation_details" id="consultation_details"></textarea>
                                        			</div>
                                        			@error('consultation_details')<span class="error"> {{ $message }} </span>@enderror
                                        		</div>
                                        	</div>
                                        
                                        
                                        
                                        
                                        
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.fees_type')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.choose_fees_type')}}</label>
                                        				<select class="full-width" data-init-plugin="select2" name="consultation_fee_type" id="feesTypeConsultation">
                                        					<optgroup label="{{__('website.choose_fees_type')}}">
                                        						<option value=""></option>
                                        						@for($i=1; $i<=3; $i++)
                                        							<option value="{{$i}}">{{__('website.fee_type'.$i)}}</option>
                                        						@endfor
                                        					</optgroup>
                                        		    		</select>
                                        			</div>
                                        			@error('consultation_fee_type')<span class="error"> {{ $message }} </span>@enderror
                                        
                                        
                                        			<div class="animated fadeIn delay-0.5s" id="feesTypeOneConsultation">
                                        				<div class="row">
                                        					<div class="col-md-12">
                                        						<div class="form-group form-group-default">
                                        							<label>{{__('website.value_hour')}}</label>
                                        							<input type="number" name="consultation_value_per_hour" id="consultation_value_per_hour" class="form-control">
                                        						</div>
                                        					</div>
                                        				</div>
                                        			</div>
                                        			<div class="row animated fadeIn delay-0.5s" id="feesTypeTwoConsultation">
                                        				<div class="col-md-12">
                                        					<div class="form-group form-group-default fieldCase">
                                        						<label>{{__('website.issue_fees')}}</label>
                                        						<input type="number" name="consultation_issue_fees" id="consultation_issue_fees" class="form-control">
                                        					</div>
                                        				</div>
                                        			</div>
                                        		</div>
                                        	</div>
                                        
                                        
                                        	<div class="form-group mb-3 row">
                                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.responsible_lawyer')}}</label>
                                        		<div class="col-md-7">
                                        			<div class="form-group form-group-default form-group-default-select2 required">
                                        				<label class="">{{__('website.choose_responsible_lawyer')}}</label>
                                        				<select class="full-width" data-init-plugin="select2"
                                        				id="consultation_responsible_lawyer" name="consultation_responsible_lawyer">
                                        					<optgroup label="{{__('website.choose_emp_name')}}">
                                        					    @if(isset(Auth::user()->office_employees))
                                        					@foreach(Auth::user()->office_employees as $one)
                                        						<option value="{{@$one->id}}">{{@$one->name}}</option>
                                        					@endforeach
                                        					@endif
                                        					</optgroup>
                                        				</select>
                                        			</div>
                                        		</div>
                                        	</div>
                                        
                                        
                                        
                                        </div>
            
                                        <!--  Other Section -->
                                        <div class="secOther animated fadeIn delay-0.5s">
            
            
            
                <div class="form-group mb-3 row">
            		<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.client_name')}}</label>
            		<div class="col-md-6">
            			<div class="form-group form-group-default form-group-default-select2 required">
            				<label>{{__('website.client_name')}}</label>
            				<select class="full-width" required name="other_client_id" id="other_client_id" data-init-plugin="select2">
            					<optgroup label="{{__('website.choose_name')}}">
            					    @if(isset($clients))
            					@foreach($clients as $one)
            						<option {{($client_id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
            					@endforeach
            					@endif
            					</optgroup>
            				</select>
            			</div>
            			@error('case_client_id')<span class="error"> {{ $message }} </span>@enderror
            		</div>
            
            		<div class="col-md-1">
            			<a data-target="#modalAddClients" data-toggle="modal" class="buttonAdd"><i class="material-icons">add</i><span>إضافة</span></a>
            		</div>
            	</div>
            
            
            
            <div class="form-group mb-3 row">
            		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.project_name')}}</label>
            		<div class="col-md-7">
            			<div class="form-group form-group-default required">
            				<label>{{__('website.write_project_name')}}</label>
            				<input type="text" class="form-control" name="other_name" id="other_name" />
            			</div>
            			@error('other_name')<span class="error"> {{ $message }} </span>@enderror
            		</div>
            	</div>
            
            
            
                <div class="form-group mb-3 row">
            		<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.project_number')}}</label>
            		<div class="col-md-7">
            			<div class="row">
            				<div class="col-md-6">
            					<div class="form-group form-group-default fieldCase">
            						<label>{{__('website.project_number_in_the_system')}}</label>
                                <input type="text" class="form-control" name="other_number" id="other_number" value="{{@$project_number}}" disabled>
            					</div>
            				</div>
            				<div class="col-md-6">
            					<div class="form-group form-group-default">
                                    <label><span>{{__('website.reference_number')}}</span>
                                    <i class="material-icons iconHelp" data-toggle="tooltip" title="" data-original-title="{{__('website.reference_number_for_this_case')}}">help</i> </label>
            						<input type="text" class="form-control" name="other_reference_number" id="other_reference_number">
            					</div>
            				</div>
            			</div>
            		</div>
            	</div>
            
            
            	<div class="form-group mb-3 row">
            		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.project_description')}}</label>
            		<div class="col-md-7">
            			<div class="form-group form-group-default">
            				<label>{{__('website.write_project_description')}}</label>
            				<textarea class="form-control" name="other_details" id="other_details"></textarea>
            			</div>
            			@error('other_details')<span class="error"> {{ $message }} </span>@enderror
            		</div>
            	</div>
            
            
            
            
            
            
            
            
            	<div class="form-group mb-3 row">
            		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.project_status')}}</label>
            		<div class="col-md-7">
            			<div class="form-group form-group-default form-group-default-select2 required">
            				<label class="">{{__('website.project_status')}}</label>
            				<select class="full-width" data-init-plugin="select2" name="other_status" id="other_status">
            					<optgroup label="{{__('website.choose_project_status')}}">
            					@for($i=1; $i<=3; $i++)
            						<option value="{{$i}}">{{__('website.project_status'.$i)}}</option>
            					@endfor
            					</optgroup>
            				</select>
            			</div>
            			@error('other_status')<span class="error"> {{ $message }} </span>@enderror
            		</div>
            	</div>
            
            
            
            
            <div class="form-group mb-3 row">
            		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.employee')}}</label>
            		<div class="col-md-7">
            			<div class="form-group form-group-default form-group-default-select2 required">
            				<label class="">{{__('website.employee')}}</label>
            				<select class="full-width" data-init-plugin="select2"
            				id="other_responsible_lawyer" name="other_responsible_lawyer">
            					<optgroup label="{{__('website.choose_emp_name')}}">
            					    @if(isset(Auth::user()->office_employees))
            					@foreach(Auth::user()->office_employees as $one)
            						<option value="{{@$one->id}}">{{@$one->name}}</option>
            					@endforeach
            					@endif
            					</optgroup>
            				</select>
            			</div>
            		</div>
            	</div>
            
            
                                         </div>
            
                                        @foreach ($extra_fields as $one)
                                            @if($one->type == 'textarea' || $one->type == 'input')
            	                            <div class="form-group mb-3 row">
            		<label for="position" class="col-md-3 control-label bold fs-14">{{$one->name}}</label>
            		<div class="col-md-7">
            			<div class="form-group form-group-default @if($one->required == 'yes') required @endif ">
                            <label>{{$one->name}}</label>
            
                            @if($one->type == 'textarea')
                                <textarea class="form-control extrafield" name="extrafield[]"></textarea>
                                <input type="hidden" value="{{@$one->id}}" name="fieldsids[]" class="fieldsids">
                            @endif
            
                            @if($one->type == 'input')
                            <input type="text" class="form-control extrafield" name="extrafield[]">
                            <input type="hidden" value="{{@$one->id}}" name="fieldsids[]" class="fieldsids">
                            @endif
            
            			</div>
            		</div>
                </div>
                                            @else
                                            <div class="form-group mb-3 row">
                <label for="position" class="col-md-3 control-label bold fs-14">{{@$one->name}}</label>
                <div class="col-md-7">
                    <div class="form-group">
                            @if($one->type == 'checkbox')
                            <input type="checkbox" class="chkBox extrafield-chkBox" value="checked" name="">
                            <input type="hidden" value="{{@$one->id}}" name="" class="fieldsids">
                            @endif
                    </div>
                </div>
            </div>
                                            @endif
                                        @endforeach
            
            
                                            <div class="AddExtraFields">
            
            </div>
            
                                            <div class="form-group mb-3 row">
                <label for="position" class="col-md-3 control-label bold fs-14">{{__('website.more_field')}}</label>
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="button" class="btn btn-complete has-icon mb-2  m-md-0 calendar-add" data-target="#modalAddField" data-toggle="modal">
                            <i class="material-icons">add</i>
                            <span>{{__('website.add_new_field')}}</span>
                        </button>
                    </div>
                </div>
            </div>
            
                                        </div>
                                    </div>
                                </div>
                    </div>

				    <!-- Div To Copy For Attach -->
				
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
    								<a href="#" class="btn btn-material btn-complete" >
    								<i class="material-icons">add</i>  </a>
                                </div>
    						</div>
    					</div>
    				</div>

                    <div class="card m-0 mt-4 no-border">
                        <div class="card-header ">
                            <h5>{{__('website.attachments')}}</h5>
                        </div>
                        <div class="card-body pt-4 placeToAddMoreAttach">
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
                                            <input type="file"  id="file-upload-2" name="attachfile[]" size="40" >
                                        </div>
                                    </div>
    							</div>
    							<div class="col-auto">
    								<div class="row-options clickToAddMoreAttach">
    									<a href="#" class="btn btn-material btn-complete" >
    									<i class="material-icons">add</i>  </a>
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


@php
    $person_number = $office_settings->clients_number .  str_pad(count($clients)+1, 5, "0", STR_PAD_LEFT);
@endphp







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


                        <form method="post" action="javascript:void(0)" id="formCreateClient">



							  <div class="radio radio-success">
								<input type="radio" checked="checked" value="1" name="type" id="userForClick">
								<label for="userForClick">{{__('website.person')}}</label>
								<input type="radio" value="2" name="type" id="companyForClick">
								<label for="companyForClick">{{__('website.company')}}</label>
							  </div>



							  <div class="userDetails">

                                <div class="form-group form-group-default required">
                                      <label>{{__('website.fullname')}}</label>
                                      <input type="text" name="person_name" id="person_name" value="{{old('person_name')}}" required class="form-control">
                                  </div>

                                  <div class="form-group form-group-default">
                                      <label>{{__('website.client_number')}}</label>
                                      <input type="text" class="form-control" disabled name="person_number" value="{{$person_number}}" id="person_number">
                                  </div>

                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default ">
                                            <label>{{__('website.card_number')}}</label>
                                            <input type="number" name="ID_number" value="{{old('ID_number')}}" id="ID_number" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group form-group-default form-group-default-select2 ">
                                            <label>{{__('website.choose_card_type')}}</label>
                                            <select class="full-width" id="card_id" name="card_id" data-init-plugin="select2">
                                              <optgroup label="{{__('website.choose_card_type')}}">
                                                  @if(isset($cards))
                                                    <option value=""></option>
                                                  @foreach($cards as $one)
                                                    <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                  @endforeach
                                                  @endif
                                              </optgroup>
                                          </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default form-group-default-select2 ">
                                            <label>{{__('website.country')}}</label>
                                            <select class="full-width country" id="person_country_id" required name="person_country_id" data-init-plugin="select2">
                                              <optgroup label="{{__('website.choose_country')}}">
                                                  <option value=""></option>
@if(isset(Auth::user()->office_countries))
                                                  @foreach(Auth::user()->office_countries as $one)
                                                      <option value="{{@$one->country_id}}">{{@$one->country->name}}</option>
                                                  @endforeach
                                                  @endif
                                              </optgroup>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default form-group-default-select2 ">
                                            <label>{{__('website.city')}}</label>
                                            <select class="full-width city" id="person_city_id" required name="person_city_id" data-init-plugin="select2">
                                          </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-default">
                                      <label>{{__('website.address')}}</label>
                                      <input type="text" name="person_address" value="{{old('person_address')}}" id="person_address" class="form-control">
                                  </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default ">
                                              <label>{{__('website.phone')}}</label>
                                              <input type="number" id="person_phone" value="{{old('person_phone')}}" name="person_phone" class="form-control">
                                          </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                              <label>{{__('website.email')}}</label>
                                              <input type="email" id="person_email" required value="{{old('person_email')}}" name="person_email" class="form-control">
                                          </div>
                                    </div>
                                </div>
                            </div>



							  <div class="companyDetails">

							      <div class="form-group form-group-default required">
        								<label>{{__('website.company_name')}}</label>
                                        <input type="text" name="company_name" value="{{old('company_name')}}" id="company_name" class="form-control">
                                    </div>

        							<div class="form-group form-group-default">
        								<label>{{__('website.company_number')}}</label>
                                        <input type="text" class="form-control" disabled name="person_number" value="{{@$person_number}}" id="person_number">
                                    </div>


                                    <div class="form-group form-group-default">
        								<label>{{__('website.commercial_license')}}</label>
                                        <input type="text" name="commercial_license" id="commercial_license" value="{{old('commercial_license')}}" class="form-control" >
                                    </div>



        						  <div class="row">
        							  <div class="col-md-6">
        								  <div class="form-group form-group-default form-group-default-select2 ">
        									  <label>{{__('website.country')}}</label>
                                      		<select class="full-width country" id="company_country_id" name="company_country_id" data-init-plugin="select2">
                                                <optgroup label="{{__('website.choose_country')}}">
                                                    <option value=""></option>

@if(isset(Auth::user()->office_countries))
                                                    @foreach(Auth::user()->office_countries as $one)
                                                        <option value="{{@$one->country_id}}">{{@$one->country->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </optgroup>
                                            </select>
        								  </div>
        							  </div>
        							  <div class="col-md-6">
        								  <div class="form-group form-group-default form-group-default-select2 ">
        									  <label>{{__('website.city')}}</label>
                                              <select class="full-width city" id="company_city_id" name="company_city_id" data-init-plugin="select2">
                                            </select>
        								  </div>
        							  </div>
                                  </div>

        						  <div class="form-group form-group-default">
        								<label>{{__('website.address')}}</label>
                                        <input type="text" name="company_address" value="{{old('company_address')}}" id="company_address" class="form-control">
                                    </div>

                                    <div class="row">
        							  <div class="col-md-6">
        								  <div class="form-group form-group-default ">
        										<label>{{__('website.phone')}}</label>
                                                <input type="number" name="company_phone" id="company_phone" value="{{old('company_phone')}}" class="form-control">
                                            </div>
        							  </div>

                                      <div class="col-md-6">
        								  <div class="form-group form-group-default">
        										<label>{{__('website.email')}}</label>
                                                <input type="email" name="company_email" id="company_email" value="{{old('company_email')}}" class="form-control">
                                            </div>
        							  </div>
        						  </div>
                              </div>


                              <button type="submit" class="btn btn-complete btn-block" id="addNewClient">{{__('website.save')}}</button>
                              <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>


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

	////////////////////////////// Choose Type ////////////////////////////
	    // secCase
	    $(document).on('click','#caseForClick',function(e){
		  $('.secCase,.secConsultation,.secOther').hide();
			$('.secConsultation, .secOther').find(':input').each(function(){
				$(this).removeAttr('required');
			});

			$('#case_client_id, #case_name, #case_fee_type, #case_lawsuit_id, #case_project_status').attr("required", "true");

		  $('.secCase').show();
	  	});


		//secConsultation
	  	$(document).on('click','#ConsultationForClick',function(e){
		  $('.secCase,.secConsultation,.secOther').hide();

		  $('.secCase, .secOther').find(':input').each(function(){
				$(this).removeAttr('required');
		    });

			$('#consultation_client_id, #consultation_name, #consultation_consultation_id, #consultation_status').attr("required", "true");

		  $('.secConsultation').show();
	  	});



		$(document).on('click','#OtherForClick',function(e){
		  $('.secCase,.secConsultation,.secOther').hide();

		  $('.secCase, .secConsultation').find(':input').each(function(){
				$(this).removeAttr('required');
		    });

			$('#other_client_id, #other_name, #other_status').attr("required", "true");

		  $('.secOther').show();
	  	});


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




    ///////////////////////// Save And Add New One ///////////////////////
    $(document).on('click', '#saveAndNew', function(){
        $('#saveWay').val(1);
        $('#storeNewProject').click();
    });
    /////////////////////// End Save And Add New One /////////////////////

    /////////////////////////// Save And Done /////////////////////////

    $(document).on('submit','#newProjectForm',function(){
    $('#saveDone').attr('disabled', 'true');
    $('#saveAndNew').attr('disabled', 'true');
    });


        $(document).on('click', '#saveDone', function(){
        $('#saveWay').val(0);
        $('#storeNewProject').click();
    });
    ///////////////////////// End Save And Done ///////////////////////

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



	////////////////////////////////////////////////  Validation /////////////////////////////////////////
      $('#newProjectForm').validate({
			messages:{
				case_client_id: "{{__('website.required_field')}}",
				case_name: "{{__('website.required_field')}}",
				case_fee_type: "{{__('website.required_field')}}",
				case_lawsuit_id: "{{__('website.required_field')}}",
				case_project_status: "{{__('website.required_field')}}",

				consultation_client_id: "{{__('website.required_field')}}",
				consultation_name: "{{__('website.required_field')}}",
				consultation_consultation_id: "{{__('website.required_field')}}",
				consultation_status: "{{__('website.required_field')}}",

				other_client_id: "{{__('website.required_field')}}",
				other_name: "{{__('website.required_field')}}",
				other_status: "{{__('website.required_field')}}",

			}
	  });

	////////////////////////////////////////////// End Validation ///////////////////////////////////////
</script>
@endsection




