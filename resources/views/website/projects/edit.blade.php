@extends('layout.siteLayout')
@section('title', __('website.projects'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.edit')}} {{__('website.project')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
					</button>

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/projects')}}'">
                        <i class="material-icons">delete_outline</i> <span> {{__('website.cancel')}} </span>
                    </button>
			   </div>

				<button id="saveAndNew" class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(getLocal(). '/projects/create')}}'">
					<i class="material-icons">add</i> <span> {{__('website.add_project')}} </span>
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
                <li class="breadcrumb-item active">{{__('website.edit')}} {{__('website.projects')}}</li>
            </ol>
        </div>
    </div>
    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">

				<form action="{{url(app()->getLocale() . '/projects/' . $item->id)}}" method="post" id="newProjectForm" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PUT')}}
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
                                            <input type="radio" checked="checked" value="1" name="type" id="caseForClick"  {{$item->type == 1? "checked": ""}}>
                                            <label for="caseForClick">{{__('website.issue')}}</label>
                                            <input type="radio" value="2" name="type" id="ConsultationForClick"  {{$item->type == 2? "checked": ""}}>
                                        	<label for="ConsultationForClick">{{__('website.consultation')}}</label>
                                			<input type="radio" value="3" name="type" id="OtherForClick"  {{$item->type == 3? "checked": ""}}>
                                            <label for="OtherForClick">{{__('website.other')}}</label>
                                        </div>
                                    </div>
                                </div>

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
                            						    <option {{($item->client_id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
                            					    @endforeach
                            					    @endif
                            					</optgroup>
                            				</select>
                            			</div>
                            			@error('case_client_id')<span class="error"> {{ $message }} </span>@enderror
                            		</div>

                            		<div class="col-md-1">
                            			<a data-target="#modalAddClients" data-toggle="modal" class="buttonAdd">
                            			    <i class="material-icons">add</i><span>{{__('website.add')}}</span>
                            			</a>
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
                                						<option {{($item->client_description_id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
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
                            				<input type="text" class="form-control" value="{{@$item->case_name}}" name="case_name" id="case_name" required>
                            			</div>
                            			@error('case_name')<span class="error"> {{ $message }} </span>@enderror
                            		</div>
                            	</div>

                                <div class="form-group mb-3 row">
                            		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.court_name')}}</label>
                            		<div class="col-md-7">
                            			<div class="form-group form-group-default required">
                            				<label>{{__('website.court_name')}}</label>
                            				<input type="text" class="form-control" value="{{@$item->court_name}}" name="court_name" id="court_name" required>
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
                            						<input type="text" class="form-control" value="{{@$office_settings->projects_number}}{{@$item->project_number}}" name="case_issue_number" id="case_issue_number" disabled>
                            					</div>
                            				</div>
                            				<div class="col-md-6">
                            					<div class="form-group form-group-default">
                            						<label><span>{{__('website.reference_number')}}</span> <i class="material-icons iconHelp">help</i> </label>
                            						<input type="text" class="form-control" value="{{@$item->reference_number}}" name="case_reference_number" id="case_reference_number">
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
                                					    <option value="{{$i}}" {{($item->project_status_id == $i)? 'selected':''}}>{{__('website.project_status'.$i)}}</option>
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
                            				<textarea class="form-control" name="case_details" id="case_details">{{@$item->details}}</textarea>
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
                                						<option value="{{$i}}" {{($item->fee_type == $i)? 'selected':''}}>{{__('website.fee_type'.$i)}}</option>
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
                            							<input type="number" value="{{@$item->value_per_hour}}" name="case_value_per_hour" id="case_value_per_hour" class="form-control">
                            						</div>
                            					</div>
                            				</div>
                                        </div>
                            			<div class="row animated fadeIn delay-0.5s" id="feesTypeTwo">
                            				<div class="col-md-12">
                            					<div class="form-group form-group-default fieldCase">
                            						<label>{{__('website.issue_fees')}}</label>
                            						<input type="number" value="{{@$item->issue_fees}}" name="case_issue_fees" id="case_issue_fees" class="form-control">
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
                                    					<option value="{{@$one->lawsuit_id}}" {{($item->lawsuit_id == $one->lawsuit_id)? 'selected':''}}>{{@$one->lawsuit->name}}</option>
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
                            						<input type="text" value="{{@$item->start_project_date}}" class="form-control hijri-date-input" name="start_project_date">
                            					</div>
                            				</div>
                            				<div class="col-md-6 p-md-0">
                            					<div class="form-group form-group-default ">
                            						<label class="">{{__('website.gov_institution')}}</label>
                            						<input type="text" value="{{@$item->gov_institution}}" class="form-control" name="case_gov_institution" id="case_gov_institution">
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
                                                                <option value="{{@$one->contender_id}}" {{($item->contender_id == $one->contender_id)? 'selected':''}}>{{@$one->contender->name}}</option>
                                                            @endforeach
                                                            @endif
                                                        </optgroup>
                                                    </select>
                                    	        </div>
                            			    </div>
                            		        <div class="col-md-6 sm-m-t-10 pl-md-0">
                            			        <div class="form-group form-group-default">
                            				        <label class="">{{__('website.contender_name')}}</label>
                            				        <input type="text" class="form-control" value="{{@$item->contender_name}}" name="contender_name" id="contender_name">
                            			        </div>
                            		        </div>
                            		        <div class="col-md-12 p-md-0">
                            			        <div class="form-group form-group-default">
                            				        <label class="">{{__('website.contender_address')}}</label>
                            				        <input type="text" class="form-control" value="{{@$item->contender_address}}" name="contender_address" id="contender_address">
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
                            				<select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                            					<optgroup label="{{__('website.choose_emp_name')}}">
                            					    @if(isset(Auth::user()->office_employees))
                                					@foreach(Auth::user()->office_employees as $one)
                                						<option value="{{@$one->id}}" {{($item->responsible_lawyer == $one->id)? 'selected':''}}>{{@$one->name}}</option>
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
                            				<select class="full-width" data-init-plugin="select2" multiple id="project_employees[]" name="project_employees[]">
                            					<optgroup label="{{__('website.choose_emp_name')}}">
                            					    @if(isset(Auth::user()->office_employees))
                                					@foreach(Auth::user()->office_employees as $one)
                                						<option @if(in_array($one->id, $project_employees)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
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
                                						<option {{($item->client_id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
                                					@endforeach
                                					@endif
                            					</optgroup>
                            				</select>
                            			</div>
                            			@error('consultation_client_id')<span class="error"> {{ $message }} </span>@enderror
                            		</div>
                        		<div class="col-md-1">
                        			<a data-target="#modalAddClients" data-toggle="modal" class="buttonAdd"><i class="material-icons">add</i><span>{{__('website.add')}}</span></a>
                        		</div>
                        	</div>

                        	<div class="form-group mb-3 row">
                        	    <label for="position" class="col-md-3 control-label bold fs-14">{{__('website.consultation_name')}}</label>
                        		<div class="col-md-7">
                        			<div class="form-group form-group-default required">
                        				<label>{{__('website.write_consultation')}}</label>
                        				<input type="text" value="{{@$item->name}}" name="consultation_name" id="consultation_name" class="form-control">
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
                        						<input type="text" class="form-control" value="PRO{{@$item->project_number}}" name="consultation_number" id="consultation_number" disabled>
                        					</div>
                        				</div>
                        				<div class="col-md-6">
                        					<div class="form-group form-group-default">
                        						<label><span>{{__('website.reference_number')}}</span> <i class="material-icons iconHelp">help</i> </label>
                        						<input type="text" class="form-control" value="{{@$item->reference_number}}" name="consultation_reference_number" id="consultation_reference_number">
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
                            						<option value="{{@$one->consultation_id}}" {{$item->consultation_id == $one->consultation_id? "selected":"" }}>{{@$one->consultation->name}}</option>
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
                            						<option value="{{$i}}" {{$item->project_status_id == $i? "selected":"" }}>{{__('website.project_status'.$i)}}</option>
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
                        				<textarea class="form-control" name="consultation_details" id="consultation_details">{{$item->details}}</textarea>
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
                        							<option value="{{$i}}" {{$item->fee_type == $i? "selected":"" }}>{{__('website.fee_type'.$i)}}</option>
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
                        							<input type="number" value="{{@$item->value_per_hour}}" name="consultation_value_per_hour" id="consultation_value_per_hour" class="form-control">
                        						</div>
                        					</div>
                        				</div>
                        			</div>
                        			<div class="row animated fadeIn delay-0.5s" id="feesTypeTwoConsultation">
                        				<div class="col-md-12">
                        					<div class="form-group form-group-default fieldCase">
                        						<label>{{__('website.issue_fees')}}</label>
                        						<input type="number" value="{{@$item->issue_fees}}" name="consultation_issue_fees" id="consultation_issue_fees" class="form-control">
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
                        				<select class="full-width" data-init-plugin="select2" id="consultation_responsible_lawyer" name="consultation_responsible_lawyer">
                        					<optgroup label="{{__('website.choose_emp_name')}}">
                        					    @if(isset(Auth::user()->office_employees))
                            					@foreach(Auth::user()->office_employees as $one)
                            						<option value="{{@$one->id}}" {{$item->responsible_lawyer == $one->id? "selected":"" }}>{{@$one->name}}</option>
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
                        				<select class="full-width" required name="oher_client_id" id="other_client_id" data-init-plugin="select2">
                        					<optgroup label="{{__('website.choose_name')}}">
                        					    @if(isset($clients))
                            					@foreach($clients as $one)
                            						<option {{($item->client_id == $one->id)? 'selected':''}} value="{{$one->id}}">{{$one->name}}</option>
                            					@endforeach
                            					@endif
                        					</optgroup>
                        				</select>
                        			</div>
                        			@error('case_client_id')<span class="error"> {{ $message }} </span>@enderror
                        		</div>

                        		<div class="col-md-1">
                        			<a data-target="#modalAddClients" data-toggle="modal" class="buttonAdd">
                        			    <i class="material-icons">add</i><span>{{__('website.add')}}</span>
                        			</a>
                        		</div>
                        	</div>

                            <div class="form-group mb-3 row">
                        		<label for="position" class="col-md-3 control-label bold fs-14">{{__('website.project_name')}}</label>
                        		<div class="col-md-7">
                        			<div class="form-group form-group-default required">
                        				<label>{{__('website.write_project_name')}}</label>
                        				<input type="text" value="{{@$item->name}}" class="form-control" name="other_name" id="other_name" />
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
                        						<input type="text" class="form-control" value="PRO{{@$item->project_number}}" name="other_number" id="other_number" disabled>
                        					</div>
                        				</div>
                        				<div class="col-md-6">
                        					<div class="form-group form-group-default">
                        						<label><span>{{__('website.reference_number')}}</span> <i class="material-icons iconHelp">help</i> </label>
                        						<input type="text" class="form-control" value="{{@$item->reference_number}}" name="other_reference_number" id="other_reference_number">
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
                        				<textarea class="form-control" name="other_details" id="other_details">{{@$item->details}}</textarea>
                        			</div>

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
                            						<option value="{{$i}}" {{$item->project_status_id == $i? "selected":"" }}>{{__('website.project_status'.$i)}}</option>
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
                                        <select class="full-width" data-init-plugin="select2" id="other_responsible_lawyer" name="other_responsible_lawyer">
                                            <optgroup label="{{__('website.choose_responsible_emp')}}">
                                                @if(isset(Auth::user()->office_employees))
                                                @foreach(Auth::user()->office_employees as $one)
                                                    <option value="{{@$one->id}}" {{$item->responsible_lawyer == $one->id? "selected":"" }}>{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>


                
                        </div>
                        
                        
                                @if(isset($item->extra_fields))
                            @foreach($item->extra_fields as $one)
                                <div class="form-group mb-3 row">
                            		<label for="position" class="col-md-3 control-label bold fs-14">{{$one->field->name}}</label>
                            		<div class="col-md-7">
                            			<div class="form-group form-group-default {{$one->field->required == 'yes'? 'required' : '' }}">

                            				@if($one->field->type == 'input' || $one->field->type == 'textarea')
                            				    <label>{{$one->field->name}}</label>
                            				@endif
                            				<input type="text" class="form-control" value="{{$one->value}}" name="extrafield[]" {{$one->field->required == 'yes'? 'required' : '' }}>
                            			    <input type="hidden" value="{{@$one->field->id}}" name="fieldsids[]" class="fieldsids">

                            			</div>
                            		</div>
                            	</div>
                            @endforeach
                            @endif
                            
                            
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
						<a href="#" class="btn btn-material btn-complete" ><i class="material-icons">add</i></a>
                    </div>
				</div>
			</div>
		</div>

        <div class=" card m-0 mt-4 no-border">
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
						<input type="text" name="oldattachment_name{{$one->id}}" value="{{$one->attachment_name}}" id="1" class="form-control"/>
					</div>
				</div>

				<div class="col col-xs-12">
				    <div class="form-group form-group-default uploadFileRequest required">
                        <div class="input-file-container">
                            <label tabindex="0" for="file-upload-1" class="input-file-trigger">
                                <i class="fa fa-upload"></i> {{__('website.upload_file')}}
                                <span>{{__('website.choose_file')}}</span>
                            </label>
                            <input type="file" id="file-upload-1" name="oldattachfile{{$one->id}}" size="40">
                        </div>
                    </div>
			    </div>

				<div class="col-auto">
					<div class="row-options clickToRemove">
						<a href="#" class="btn btn-default btn-material"><i class="material-icons">close</i></a>
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
					    <div class="modal-body col-xs-height">
						    <form id="formAddTask" method="post" action="app-calendar.html">
						        <div class="radio radio-success">
								    <input type="radio" checked="checked" value="user" name="type" id="userForClick">
								    <label for="userForClick">{{__('website.person')}}</label>
								    <input type="radio" value="company" name="type" id="companyForClick">
								    <label for="companyForClick">{{__('website.company')}}</label>
							    </div>
							    <div class="form-group form-group-default required">
								    <label>{{__('website.name')}}</label>
								    <input type="text" class="form-control" required>
							    </div>
							    <div class="form-group form-group-default">
								    <label>{{__('website.client_number')}}</label>
								    <input type="text" class="form-control" placeholder="MJK748PP">
							    </div>
							    <div class="row">
							        <div class="col-md-6">
								        <div class="form-group form-group-default">
									        <label>{{__('website.card_number')}}</label>
									        <input type="text" class="form-control">
								        </div>
							        </div>
							        <div class="col-md-6">
								        <div class="form-group form-group-default form-group-default-select2">
									        <label>{{__('website.choose_card_type')}}</label>
									        <select class="full-width" data-init-plugin="select2">
										        <optgroup label="{{__('website.choose_card_type')}}">
										        </optgroup>
									        </select>
								        </div>
							        </div>
						        </div>
						        <div class="row">
							        <div class="col-md-6">
								        <div class="form-group form-group-default form-group-default-select2">
									        <label>{{__('website.choose_country')}}</label>
									        <select class="full-width" data-init-plugin="select2">
										        <optgroup label="{{__('website.choose_country')}}">
										            <option value=""></option>
										        </optgroup>
									        </select>
								        </div>
							        </div>
							        <div class="col-md-6">
								        <div class="form-group form-group-default form-group-default-select2 ">
									        <label>{{__('website.choose_city')}}</label>
									        <select class="full-width" data-init-plugin="select2">
										        <optgroup label="{{__('website.choose_city')}}">
										        </optgroup>
									        </select>
								        </div>
							        </div>
						        </div>
						        <div class="form-group form-group-default">
								    <label>{{__('website.address')}}</label>
								    <input type="text" class="form-control" placeholder="MJK748PP">
						        </div>
						        <div class="row">
							        <div class="col-md-6">
								        <div class="form-group form-group-default">
										    <label>{{__('website.phone')}}</label>
										    <input type="text" class="form-control">
								        </div>
							        </div>
							        <div class="col-md-6">
								        <div class="form-group form-group-default">
										    <label>{{__('website.email')}}</label>
										    <input type="email" class="form-control">
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
    $('#other_client_id, #other_name, #other_status').attr("required", "true");
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

    }});


	});

	////////////////////////////////////////////// End Validation ///////////////////////////////////////
</script>
@endsection
