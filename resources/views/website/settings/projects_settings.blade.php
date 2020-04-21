@extends('layout.siteLayout')

@section('title', __('website.setting_profile'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <h2 class="page-header mb-1 my-md-3">{{__('website.projects_settings')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i><span>{{__('website.save')}}</span>
					</button>
                    <a href="{{url(getLocal(). '/settings')}}">
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

<div class="content ">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale() . '/settings')}}">
                    {{__('website.settings')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.projects_settings')}}</li>
            </ol>
        </div>
    </div>
    <div class=" container-fluid ">
        <div class="row no-gutters  mt-4">
            <div class="col-lg-12">

				<form action="{{url(app()->getLocale() . '/projects_settings')}}" method="post" id="updateContent" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PUT')}}

                    <div class="card m-0 no-border">
                        <div class="card-header">
                            <h5>{{__('website.projects_settings')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8">
								
									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.auto_number')}}</label>
										<div class="col-md-7">
											<div class="form-group form-group-default">
												<label>{{__('website.auto_number')}}</label>
												<input type="text" class="form-control" name="projects_number" value="{{@$office_settings->projects_number}}">
											</div>
										</div>
									</div>
									
									
									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.lawsuits_types')}}</label>
										<div class="col-md-7">
											<div class="form-group form-group-default">
												<label>{{__('website.lawsuits_types')}}</label> 
												<select class="full-width" data-init-plugin="select2" multiple id="offices_lawsuits[]" name="offices_lawsuits[]">
													<optgroup label="{{__('website.choose_lawsuits_types')}}">
													@foreach($all_lawsuits as $one)
														<option @if(in_array($one->id, $offices_lawsuits)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
													@endforeach
													</optgroup>
												</select>
											</div>
										</div>
									</div>
									
									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.contenders_types')}}</label>
										<div class="col-md-7">
											<div class="form-group form-group-default">
												<label>{{__('website.contenders_types')}}</label> 
												<select class="full-width" data-init-plugin="select2" multiple id="offices_contenders[]" name="offices_contenders[]">
													<optgroup label="{{__('website.choose_contenders_types')}}">
														@foreach($all_contenders as $one)
															<option @if(in_array($one->id, $offices_contenders)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
														@endforeach
													</optgroup>
												</select>
											</div>
										</div>
									</div>
									
									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.consultations_available')}}</label>
										<div class="col-md-7">
											<div class="form-group form-group-default ">
												<label>{{__('website.consultations_available')}}</label> 
												<select class="full-width" data-init-plugin="select2" multiple id="offices_consultations[]" name="offices_consultations[]">
													<optgroup label="{{__('website.choose_consultations_available')}}">
														@foreach($all_consultations as $one)
															<option @if(in_array($one->id, $offices_consultations)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
														@endforeach
													</optgroup>
												</select>
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


