@extends('layout.siteLayout')
@section('title', __('website.clients'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3 ">{{__('website.clients')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button data-action="active" href="#activation" role="button" data-toggle="modal" class="btn btn-default has-icon event cursorNODrop" disabled>
                        <i class="material-icons">check</i><span>{{__('website.toActivate')}}</span>
                    </button>
                    <button data-action="not_active" href="#cancel_activation" role="button" data-toggle="modal" class="btn btn-default has-icon event cursorNODrop" disabled>
                        <i class="material-icons">do_not_disturb</i><span>{{__('website.toNotActive')}}</span>
                    </button>
                    <button class="btn btn-default has-icon modalSlideLeft event cursorNODrop" href="#modalSlideLeft" data-toggle="modal" disabled>
                        <i class="material-icons">close</i><span>{{__('website.delete')}}</span>
                    </button>
			    </div>

				    <button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale() . '/clients/create')}}'">
                        <i class="material-icons">add</i> <span>{{__('website.add_client')}}</span>
                    </button>
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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/clients')}}">{{__('website.clients')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.view_clients_data')}}</li>
            </ol>
        </div>
    </div>

    <div class=" container-fluid">
        <div class="row no-gutters mt-4">
            <div class="col-lg-12">
                <div class="card m-0 no-border">
                    <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
					    <div>
						    <h5>{{__('website.view_clients_data')}}</h5>
						    <p>{{__('website.View_active_and_inactive_clients_data')}}</p>
						</div>
						<div class="btn-group">
                            <form class="input-group" id="clientFilterText" action="javascript:avoid(0)" method="get">
                                <input type="text" name="text" id="textKey" class="form-control" placeholder="{{__('website.search_client')}}">
							    <div class="input-group-append">
							        <button class="btn btn-secondary" type="submit">
								        <i class="material-icons">search</i>
							        </button>
							    </div>
                            </form>

						    <button class="btn btn-sm btn-default filter has-icon filterModalClients" data-target="#filterModalClients" data-toggle="modal">
                              <i class="material-icons">filter_list</i><span>{{__('website.filter')}}</span>
                            </button>

                            <button class="btn btn-sm btn-default filterTabClients active" data-action="all">{{__('website.all')}}</button>
						    <button class="btn btn-sm btn-default filterTabClients" data-action="active">{{__('website.active_clients')}}</button>
						    <button class="btn btn-sm btn-default filterTabClients" data-action="not_active">{{__('website.inactive_clients')}}</button>
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
    								    <th class="wd-20p">{{__('website.client_name')}}</th>
    								    <th class="wd-10p">{{__('website.client_number')}}</th>
    								    <th class="wd-15p">{{__('website.client_type')}}</th>
    								    <th class="wd-15p">{{__('website.address')}}</th>
    								    <th class="wd-15p">{{__('website.email')}}</th>
    								    <th class="wd-10p">{{__('website.mobile')}}</th>
    								    <th class="wd-5p">{{__('website.status')}}</th>
                                   	    <th class="wd-5p">{{__('website.action')}}</th>
                                    </tr>
							    </thead>

                                <tbody class="viewAllClients">

                                @include('website.extraBlade.filters.clientFilter')

                                @if(isset($items))
                                @forelse($items as $item)


                                    <tr id="tr-{{$item->id}}" class="clientRow">
								        <td class="v-align-middle wd-5p">
									        <div class="checkbox checkMain text-center">
                                                <input type="checkbox" class="checkboxes chkBox" value="{{@$item->id}}" id="chkBox{{@$item->id}}" data name="chkBox"/>
                                                <label for="chkBox{{@$item->id}}" class="no-padding no-margin"></label>
									        </div>
                                        </td>

								        <td class="v-align-middle wd-20p name{{$item->id}}">
                                            <a href="{{url(getLocal(). '/clients/' . $item->id)}}">{{@$item->name}}</a>
                                        </td>

                                        <td class="v-align-middle wd-10p">
									        <p> {{@$office_settings->clients_number}}{{@$item->client_number}}</p>
								        </td>

                                        <td class="v-align-middle wd-10p typeClients">
                                            @if($item->type == 1)
                                                <i class="material-icons">perm_identity</i>
                                            @else
                                                <i class="material-icons">apartment</i>
                                            @endif

                                            <span>
                                                {{$item->type == '1'? __('website.person') : __('website.company') }}
                                            </span>
                                        </td>

								        <td class="v-align-middle wd-15p"><p>{{@$item->address}}</p></td>

                                        <td class="v-align-middle wd-15p"><p>{{@$item->email}}</p></td>

								        <td class="v-align-middle wd-10p"><p>{{@$item->mobile}}</p></td>

								        <td class="v-align-middle wd-5p">
                                            <span class="badge badge-pill
                                                {{$item->status == 'active'? 'badge-success' : 'badge-info'}}" id="label-{{@$item->id}}">
                                                {{__('website.'.$item->status)}}
                                            </span>
								        </td>

                                        <td class="v-align-middle wd-5p optionAddHours">
									        <a href="{{url(getLocal(). '/clients/' . $item->id)}}">
										        <div class="note-options" data-toggle="tooltip" title="" href="{{url(getLocal(). '/clients/' . $item->id)}}" data-original-title="التفاصيل">
											        <i class="material-icons showDitails">visibility</i>
										        </div>
									        </a>
								        </td>
								    </tr>

                                    @empty
                                    @endforelse
                                    @endif
                                    </tbody>



							    </table>
                  		    </div>
                	    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- modal-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle tءذext-center">
                            <p>{{__('website.You_are_about_to_delete_the_client')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll" data-dismiss="modal" data-action="delete">
                                {{__('website.agree')}}
                            </button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">
                                {{__('website.cancel')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="allModals">
<div class="modal fade slide-right" id="filterModalClients" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content-wrapper">
		    <div class="modal-content">
			    <div class="modal-header mb-3">
				    <h6>{{__('website.filter')}}</h6>
				</div>
				<div class="container-xs-height full-height">
			        <div class="row-xs-height">
					    <div class="modal-body col-xs-height">
                            <form id="clientFilterForm" action="javascript:avoid(0)" method="get">

							<div class="form-group form-group-default form-group-default-select2 required">
								<label>{{__('website.client_type')}}</label>
								<select class="full-width" data-init-plugin="select2" id="type" name="type">
								  <optgroup label="{{__('website.choose_client_type')}}">
								  	  <option value=""></option>
									  <option value="1">{{__('website.person')}}</option>
									  <option value="2">{{__('website.company')}}</option>
								  </optgroup>
								</select>
							</div>


                    		<div class="form-group form-group-default form-group-default-select2">
							    <label>{{__('website.country')}}</label>
                    		    <select class="full-width country" id="country_id"  name="country_id" data-init-plugin="select2">
                                    <optgroup label="{{__('website.choose_country')}}">
                                        <option value=""></option>
                                        @foreach(Auth::user()->office_countries as $one)
                                            <option value="{{@$one->country_id}}">{{@$one->country->name}}</option>
                                        @endforeach
							        </optgroup>
						        </select>
						  </div>

                    		    <div class="form-group form-group-default form-group-default-select2 ">
								    <label>{{__('website.city')}}</label>
								    <select class="full-width city" id="city_id" name="city_id" data-init-plugin="select2">
						            </select>
							    </div>

                                <button type="submit" class="btn btn-complete btn-block" >{{__('website.filter')}}</button>
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

    /////////////////////// filter Tab Clients ////////////////////
    $(document).on('click','.filterTabClients',function(e){
        var status = $(this).data("action");

        $('.filterTabClients').removeClass('active');
        $(this).addClass('active');

        var url = "{{ url(app()->getLocale().'/clientFilterStatus/') }}";

        $.ajax({
            url: url+'/'+status,
            type: "get",
            success: function (response) {
                $(".clientRow").hide();
                $('.viewAllClients').append(response.clientFilter);
            }
        });

    });


        /////////////////////// filter Text Clients ////////////////////
    $(document).on('submit','#clientFilterText',function(e){
        var text = $('#textKey').val();
        var url = "{{ url(app()->getLocale().'/clientFilterText/') }}";

        $.ajax({
            url: url+'/'+text,
            type: "get",
            success: function (response) {
                $(".clientRow").hide();
                $('.viewAllClients').append(response.clientFilter);
            }
        });
    });



    /////////////////////// filter Form Clients ////////////////////
    $(document).on('submit','#clientFilterForm',function(e){

        var url = "{{ url(app()->getLocale().'/clientFilterForm/') }}";


        $.ajax({
            url: url,
            type: "get",
            data: $(this).serialize(),
            success: function (response) {
                $(".clientRow").hide();
                $('#filterModalClients').fadeOut(500,function(){
                    $('#filterModalClients').modal('hide');
                });

                $('.viewAllClients').append(response.clientFilter);

                $("#filterModalClients #type").val('').select2();
                $("#filterModalClients #country_id").val('').select2();
                $("#filterModalClients #city_id").val('').select2();

            }
        });
    });





});
</script>
@endsection
