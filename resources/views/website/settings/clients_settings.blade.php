@extends('layout.siteLayout')

@section('title', __('website.clients_settings'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
    	<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
        	<h2 class="page-header mb-1 my-md-3">{{__('website.clients_settings')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">
                    <button id="saveDone" class="btn btn-default has-icon">
                        <i class="material-icons">save</i> <span>{{__('website.save')}}</span>
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
                   {{__('website.settings')}}</a>
				</li>
                <li class="breadcrumb-item active">{{__('website.clients_settings')}}</li>
            </ol>
        </div>
    </div>

    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">

				<form action="{{url(app()->getLocale() . '/clients_settings')}}" method="post" id="updateContent" autocomplete="off" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('PUT')}}
                    <div class=" card m-0 no-border">
                        <div class="card-header">
                            <h5>{{__('website.clients_settings')}}</h5>
                        </div>
                        <div class="card-body pt-4">
                        	<div class="row">
                            	<div class="col-md-12 col-lg-8 ">
								
								<div class="form-group mb-3 row">
									<label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.auto_number')}}</label>
									<div class="col-md-7">
										<div class="form-group form-group-default required">
											<label>{{__('website.auto_number')}}</label>
											<input type="text" class="form-control" name="clients_number" value="{{@$office_settings->clients_number}}" required>
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


