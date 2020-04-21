@extends('layout.siteLayout')

@section('title', __('website.setting_profile'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        <h2 class="page-header mb-1 my-md-3">{{__('website.setting_profile')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
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
                    {{__('website.settings')}}</a>
				</li>
                <li class="breadcrumb-item active">{{__('website.setting_profile')}}</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">

				<form action="{{url(app()->getLocale() . '/office_profile')}}" method="post" id="updateContent" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PUT')}}

                    <div class=" card m-0 no-border">
                        <div class="card-header ">
                            <h5>{{__('website.personal_data')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row">
                                <div class="col-md-12 col-lg-8">
								
									<div class="form-group mb-3 row">
										<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.account_photo')}}</label>
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
								
								
								<div class="form-group mb-3 row">
									<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.name')}}</label>
									<div class="col-md-7">
									  <div class="form-group form-group-default required">
										<label>إسم المكتب</label>
										<input type="text" class="form-control" name="name" value="{{@$item->name}}" required>
									  </div>
									</div>
								</div>
								
								
								<div class="form-group mb-3 row">
									<label class="col-md-3 control-label bold fs-14">{{__('website.location')}}</label>
									<div class="col-md-7">
										<div class="row">
											<div class="col-md-6">
										  		<div class="form-group form-group-default form-group-default-select2 required">
											  		<label class="">{{__('website.country')}}</label>
													<select class="full-width countryEditForm" id="country_id" required name="country_id" data-init-plugin="select2">
														<optgroup label="{{__('website.choose_country')}}">
                                						@foreach(Auth::user()->office_countries as $one)
                                    						<option value="{{@$one->country_id}}" {{$item->country_id == $one->country_id? "selected": ""}}>
																{{@$one->country->name}}
															</option>
                                						@endforeach
														</optgroup>
													</select>
										  		</div>
											</div>
											<div class="col-md-6 sm-m-t-10 pl-md-0">
										  		<div class="form-group form-group-default form-group-default-select2 required">
													<label>{{__('website.city')}}</label>
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
									<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.phone')}}</label>
									<div class="col-md-7">
										<div class="form-group form-group-default required">
											<label>{{__('website.phone')}}</label>
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

			  					<div class="form-group mb-3 row">
									<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.time_zone')}}</label>
									<div class="col-md-7">
										<div class="form-group form-group-default form-group-default-select2">
											<label>{{__('website.time_zone')}}</label>
											<select class="full-width" id="zone_id" name="zone_id" data-init-plugin="select2">
												<optgroup label="{{__('website.choose_time_zone')}}">
                                					@foreach($zones as $one)
                                    					<option value="{{@$one->id}}" {{$item->zone_id == $one->id? "selected":"" }} >{{@$one->name}}</option>
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





@section('js')
<script>

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
</script>
@endsection
