@extends('layout.siteLayout')
@section('title', __('website.clients'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{$item->name}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button data-action="active" href="#activation" role="button" data-toggle="modal" class="btn btn-default has-icon">
                        <i class="material-icons">check</i><span>{{__('website.toActivate')}}</span>
                    </button>

                    <button data-action="not_active" href="#cancel_activation" role="button" data-toggle="modal" class="btn btn-default has-icon">
                        <i class="material-icons">do_not_disturb</i><span>{{__('website.toNotActive')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(app()->getLocale(). '/clients/' . $item->id . '/edit')}}'">
    				    <i class="material-icons">edit</i><span>{{__('website.edit')}}</span>
                    </button>

                    <button type="button" class="btn btn-default  has-icon" data-target="#modalSlideLeft" data-toggle="modal">
                        <i class="material-icons">close</i> <span>{{__('website.delete')}}</span>
                    </button>

                </div>
                <button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(app()->getLocale().'/projects/create?client_id='.$item->id)}}'">
                    <i class="material-icons">add</i> <span>{{__('website.add_project')}}</span>
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
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/clients')}}">
                    {{__('website.clients')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.client_data')}}</li>
              </ol>
            </div>
    </div>

    <div class=" container-fluid">
        <div class="row mt-4 no-gutters dashboard-statistics client-statistics dashboard-no-gutters">
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card no-border widget-loader-bar">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="col-xs-height col-top">
                                <div class="p-4">
                                    <h3 class="semi-bold  no-margin p-b-5">
                                    <b>{{$item->bills->sum('amount')}}</b>{{__('website.sr')}}</h3>
                                    <div class="stats-bottom">
                                        <span class="small hint-text">{{__('website.amounts_paid')}}</span>
                                    </div>
                                </div>
                                <div class="note-options">
                                <a class="notes-opt-btn" data-toggle="tooltip" title="{{__('website.details')}}" href="#">
                                    <i class="material-icons">more_horiz</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card no-border widget-loader-bar">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="col-xs-height col-top">
                            <div class="p-4">
                                <h3 class="semi-bold  no-margin p-b-5">
                                    <b>

                                    @php
                                    $final_total = 0;
                                    foreach($item->invoices as $one){
                                    $final_total += $one->invoice_amount;
                                     }
                                    @endphp

                                        {{@$final_total-$item->bills->sum('amount')}}
                                    </b>
                                    {{__('website.sr')}}
                                </h3>

                                <div class="stats-bottom">
                                    <span class="small hint-text ">
                                        {{__('website.amounts_due')}}
                                    </span>
                                </div>
                            </div>
                            <div class="note-options">
                                <a class="notes-opt-btn" data-toggle="tooltip" title="{{__('website.details')}}" href="#">
                                    <i class="material-icons">more_horiz</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6  col-lg-4  col-xl-3">
            <div class="card no-border widget-loader-bar">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="col-xs-height col-top">
                            <div class="p-4">
                                <h3 class="semi-bold  no-margin p-b-5"><b>
                                   {{$item->hours->sum('hours_count')}}
                                   </b>
                                   {{__('website.hour')}}
                                </h3>

                        <div class="stats-bottom">
                            <span class="small hint-text">{{__('website.hours_count')}}</span>
                        </div>
                    </div>
                    <div class="note-options">
                        <a class="notes-opt-btn" data-toggle="tooltip" title="{{__('website.details')}}" href="#">
                            <i class="material-icons">more_horiz</i>
                        </a>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6  col-lg-4 col-xl-3">
    <div class="card no-border widget-loader-bar">
        <div class="container-xs-height full-height">
            <div class="row-xs-height">
                <div class="col-xs-height col-top">
                    <div class="p-4">
                        <h3 class="semi-bold no-margin p-b-5">{{__('website.client_status')}}</h3>
                        <div class="stats-bottom">
                            <span class="small hint-text" id="details-label-{{$item->id}}">{{__('website.'.$item->status)}} </span>
                        </div>
                    </div>
                    <div class="note-options">
                        <a class="notes-opt-btn" data-toggle="tooltip" title="{{__('website.details')}}" href="#">
                            <i class="material-icons">more_horiz</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

        <div class="row no-gutters dashboard-no-gutters mt-4 dashboardProject">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active" data-toggle="tab" role="tab" data-target="#dataClient" href="#">{{__('website.client_data')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#clientProject">{{__('website.projects')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#clientAttachments">{{__('website.attachments')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#clientNotes">{{__('website.notes')}}</a>
                    </li>
                </ul>

                <div class="tab-content bg-white">
                    <div class="tab-pane active" id="dataClient">
                        <div class="col-lg-12 col-xl-12 col-md-12  d-flex">
                            <div class=" card no-border m-0">
                                <div class="card-header">
                                    <h3 class="text-success justify-content-between d-flex align-items-center">{{__('website.client_data')}}</h3>
                                </div>
                                <div class="card-body no-padding">
                                    <div class="card no-border m-0">
                                        <div class="card-header pt-3 pb-0 border-0">
                                            <p class="bold m-0">{{__('website.personal_data')}}</p>
                                        </div>
                                        <div class="card-body pb-1">
                                            <div class="row dashboard-no-gutters">
                    						    <div class="col-lg-6">
                                                    <p>{{__('website.account')}} / {{$item->type == '1'? __('website.person') : __('website.company') }}</p>

                                                    @if(isset($item->client_number))
                                                        <p>{{$item->name}}</p>
                                                        <p>{{ __('website.client_number') . '/ ' . $office_settings->clients_number . $item->client_number}}</p>
                                                    @endif

                    								<p>{{$item->gender == '1'? __('website.male') : '' }}
                                                       {{$item->gender == '2'? __('website.female') : '' }}
                                                    </p>

                    								<p>
                                                    @if($item->type == 2)
                                                        {{__('website.commercial_license')}} / {{@$item->commercial_license}}
                                                    @endif

                                                    @if($item->type == 2 && $item->card_id)
                                                        {{@$item->card->name}} / {{@$item->ID_number}}
                                                    @endif
                                                    </p>
                                                    <p>{{@$item->country->name}} - {{@$item->city->name}}</p>
                    								<p>{{@$item->address}}</p>
                                                </div>
                    						    <div class="col-lg-6">
                                                    <p>{{@$item->email}}</p>
                    								<p>{{__('website.mobile')}} / {{@$item->mobile}}</p>
                                                    <p>{{__('website.phone')}} / {{@$item->phone}}</p>
                                                    <p><strong>{{__('website.notes')}}</strong> <br> {{@$item->notes}}</p>
                    							</div>
                    						</div>
                                        </div>
                                    </div>
                                    <div class="card no-border m-0">
                                        <div class="card-header h-auto pt-3 pb-0 border-0">
                                            <p class="bold d-inline-block m-0">{{__('website.client_representative_information')}}</p>
                                        </div>
                                        <div class="card-body pb-1">
                                        @if(isset($item->representatives))
                                        @foreach($item->representatives as $one)
                                            <div class="clientRepresentative">
                    							<div class="row dashboard-no-gutters">
                    								<div class="col-lg-6"><p>{{@$one->name}}</p></div>
                    								<div class="col-lg-6"><p>{{@$one->role_name}}</p></div>
                    								<div class="col-lg-6"><p>{{@$one->email}}</p></div>
                    								<div class="col-lg-6"><p>{{@$one->mobile}}</p></div>
                                                    <div class="col-lg-12"><p>{{@$one->address}}</p></div>
                    							</div>
                                            </div>
                                        @endforeach
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="clientProject">
                        <div class="col-lg-6 col-xl-12 col-md-12 d-flex">
                            <div class="widget-11 card m-0 no-border tasks-widget">
                                <div class="card-header">
                                    <h3 class="text-complete justify-content-between d-flex align-items-center">
                                        <span>{{__('website.projects')}}</span>
                                    </h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="notes-cont auto-overflow widget-11-table">
                                        @if(isset($item->projects))
                                        @foreach($item->projects as $project)
                                        <div class="note-item">
                                            <div class="note-title">
                                                <a href="{{url(getLocal(). '/projects/'.$project->id)}}">{{@$project->name}}</a>
                                            </div>
                                            <span class="badge badge-pill {{$project->type == '1'? 'badge-success':''}} {{$project->type == '2'? 'badge-info':''}} {{$project->type == '3'? 'badge-danger':''}} ">
                                                @if($project->type == 1)
                                                    {{__('website.issue')}}
                                                @elseif($project->type == 2)
                                                    {{__('website.consultation')}}
                                                @else
                                                    {{__('website.other')}}
                                                @endif
                                            </span>
                                        </div>
                                        @endforeach
                                        @endif
                                        </div>
                                    </div>
                                <div class="heightBottom"></div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="clientAttachments">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0 sectionAttachments">
                                <div class="card-header">
                                    <h3 class="text-success justify-content-between d-flex align-items-center">
                                        <span>{{__('website.attachments')}}</span>
                                        <span class="mr-0 text-black  semi-bold d-flex">
                                            <button class="btn btn-xs btn-complete  has-icon mr-5" data-target="#modalAddAttach" data-toggle="modal">
                                                <i class="material-icons m-0">add</i>
                                            </button>
                                        </span>
                                    </h3>
                                </div>

                                <div class="headBoxAttachment boxAttachment">
                                    <div class="boxAttach"><p>{{__('website.attachment_name')}}</p></div>
                    			    <div class="boxAttach"><p></p></div>
                                </div>

                                <div class="card no-border m-0">
                                    <div class="card-body pb-1 divAttachments">
                                        <div class="cleintAttachment AttachsFiles">
                                        @if(isset($item->attachments))
                                        @foreach($item->attachments as $one)
                                            <div class="dashboard-no-gutters boxAttachment">
                    							<div class="boxAttach"><p>{{@$one->attachment_name}}</p></div>
                                                <div class="boxAttach"><p>{{@$one->attachtype->name}}</p></div>
                                                <div class="boxAttach"><p>{{@$one->reference_number}}</p></div>
                    							<div class="boxAttach">
                    							    <a href="{{@$one->file}}" target="blank"><i class="material-icons m-0">visibility</i></a>
                    							</div>
                                            </div>
                                        @endforeach
                                        @endif
                    				    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="clientNotes">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="widget-11 card m-0 no-border tasks-widget">
                                <div class="card-header">
                                    <h3 class="text-complete justify-content-between d-flex align-items-center">
                                        <span>{{__('website.notes')}}</span>
                                        <span class="mr-0 text-black semi-bold d-flex">

                                            <button class="btn btn-xs btn-complete  has-icon mr-5 calendar-add" data-target="#modalAddNote" data-toggle="modal">
                                        	    <i class="material-icons m-0">add</i>
                        					</button>

                                        </span>
                                    </h3>
                                </div>

                                <div class="card-body p-0">
                                        <div class="notes-cont auto-overflow widget-11-table allNotes">
                                            @if(isset($item->client_notes))
                                            @foreach($item->client_notes as $one)
                                            <div class="note-item" id="div-{{$one->id}}">
                                                <div class="note-title"><i class="material-icons">turned_in_not</i><p>{{@$one->note}}</p></div>
                                                <time>
                                                    {{Arr::get(getDates(substr($one->note_date, 0, 10)), 'hijri_date')}}
                                                </time>
                                                <div class="note-options">

                                                    <a class="notes-opt-btn modalToEditNote event" data-toggle="modal" title="{{__('website.edit')}}" data-id="{{$one->id}}" href="#modalToEditNote">
                                                      <i class="material-icons">edit</i>
                                                    </a>

                                                    <a class="notes-opt-btn modalToDeleteNote event" data-toggle="modal" title="{{__('website.delete')}}" data-id="{{$one->id}}" href="#modalToDeleteNote">
                                                      <i class="material-icons">close</i>
                                                    </a>

                                                </div>
                                            </div>
                                            @endforeach
                                            @endif

                                        </div>
                                    </div>
                                <div class="heightBottom"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<input type="checkbox" class="checkboxes chkBox-details chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" name="chkBox" checked style="display:none;" />


<!-- modal-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.You_are_about_to_delete_the_client')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll deleteClientFromDetPage" data-dismiss="modal" data-action="delete">
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



@endsection
