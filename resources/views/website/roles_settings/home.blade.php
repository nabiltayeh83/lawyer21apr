@extends('layout.siteLayout')

@section('title', __('website.roles'))

@section('topfixed')

<div class="page-top-fixed">
	<div class="container-fluid">
    	<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.roles')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>
          		<a data-target="#addRoleGroup" data-toggle="modal">
				    <button class="btn btn-complete  has-icon mb-2 m-md-0">
						<i class="material-icons">add</i><span> {{__('website.add')}}</span>
					</button>
				</a>
            </div>
		</div>
	</div>
</div>
@endsection


@section('content')
<div class="content allclients">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/settings')}}">
                {{__('website.settings')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.roles')}}</li>
            </ol>
        </div>
    </div>

	<div class="row no-gutters container-fluid dashboard-no-gutters mt-4">
        <div class="card card-borderless">
			<div class="tab-content" style="padding:0">
                <div class="tab-pane active" id="DataStaff">
					<div class="">
						<div class="row no-gutters mt-4">
						    <div class="col-lg-12">
								<div class=" card m-0 no-border">
									<div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
									    <div>
											<h5> {{__('website.settings')}} </h5>
											<p> {{__('website.roles')}} </p>
										</div>
										<div class="btn-group">
											<!--<form class="input-group">-->
											<!--	<input type="text" class="form-control" placeholder="{{__('website.search')}}">-->
											<!--	<div class="input-group-append">-->
											<!--		<button class="btn btn-secondary" type="button">-->
											<!--		    <i class="material-icons">search</i>-->
											<!--		</button>-->
											<!--	</div>-->
											<!--</form>-->
										</div>
									</div>
								    <div class="card-body p-0">
									    <div class="table-responsive">
											<table class="table table-hover tableWithSearch" id="tableWithSearch">
												<thead>
													<tr>
                                                        <th class="wd-5p no-sort">
								                            <div class="checkbox checkMain text-center">
                                                                <input type="checkbox" value="" id="checkboxall" name="client" class="chkBox">
									                            <label for="checkboxall" class="no-padding no-margin"></label>
									                        </div>
								                        </th>
														<th class="wd-75p">{{__('website.name')}}</th>
														<th class="wd-20p">{{__('website.action')}}</th>
													</tr>
												</thead>
												<tbody>

                                                @foreach($items as $one)
                                                    <tr id="tr-{{$one->id}}">
      					                                <td class="v-align-middle wd-5p">
									                        <div class="checkbox checkMain text-center">
                                                                <input type="checkbox" class="checkboxes chkBox" value="{{@$one->id}}" id="chkBox{{@$one->id}}" data name="chkBox"/>
                                                                <label for="chkBox{{@$one->id}}" class="no-padding no-margin"></label>
									                        </div>
                                                        </td>
								                        <td class="v-align-middle wd-75p">
									                        <p>{{$one->name}}</p>
										                </td>   
										                <td class="v-align-middle wd-20p">
										                    <a href="{{url(getLocal(). '/roles_settings/' . $one->id . '/edit')}}">
                                                                <i class="material-icons editTask">edit</i>
                                                            </a>
												        </td>
												    </tr>
                                                @endforeach
                                                </tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		    </div>
		</div>
    </div>

</div>



<!--     modal-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle tءذext-center">
                            <p>{{__('website.are_you_sure_to_delete_this_role')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5>
                            <br>
                            <button type="button" class="btn btn-danger btn-block confirmAll"
                            data-dismiss="modal" data-action="delete">{{__('website.agree')}}</button>
                            <button type="button" class="btn btn-default btn-block"
                            data-dismiss="modal">{{__('website.cancel')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade slide-right" id="addRoleGroup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content-wrapper">
			<div class="modal-content">
				<div class="modal-header mb-3">
					<h6>{{__('website.add')}} {{__('website.roles')}}</h6>
				</div>
				<div class="container-xs-height full-height">
					<div class="row-xs-height">
						<div class="modal-body col-xs-height">

                            <form action="{{url(app()->getLocale() . '/roles_settings')}}" method="post" id="newClientForm"
                            autocomplete="off" enctype="multipart/form-data">
                            {{csrf_field()}}
                            
								<div class="form-group form-group-default">
									<label>{{__('website.name')}}</label>
									<input type="text" name="name" class="form-control" />
								</div>
									
								<div class="form-group form-group-default">
									<label>  {{__('website.departments')}} </label>
								    <select class="full-width" data-init-plugin="select2" multiple id="departments[]" name="departments[]">
					                    <optgroup label="{{__('website.departments')}}">
					                    @foreach($departments as $one)
						                    <option value="{{@$one->id}}">{{@$one->name}}</option>
					                    @endforeach
					                    </optgroup>
				                    </select>
								</div>
                                
                                <button type="submit" class="btn btn-complete btn-block"> {{__('website.save')}} </button>
						        <button type="button" class="btn btn-default btn-block" data-dismiss="modal"> {{__('website.cancel')}} </button>
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

});
</script>
@endsection
