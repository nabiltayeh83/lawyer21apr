@extends('layout.siteLayout')
@section('title', __('website.home'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="mb-0 card social-card share share-other border-0 mr-3 mr-md-0">
            <div class="card-header border-0 clearfix px-0">
                <div class="user-pic"><img alt="Avatar" height="33" src="{{Auth::user()->image}}"></div>
                <div class="user-content"><h5>{{auth::user()->name}}</h5></div>
            </div>
        </div>
	</div>
</div>
@endsection

@section('content')


<div class="content">
    <div class="container-fluid">
        <div class="row no-gutters dashboard-statistics dashboard-no-gutters mt-4">
            <div class="col-sm-6  col-xl-3">
                <div class="card no-border widget-loader-bar">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="col-xs-height col-top">
                                <div class="p-4">
                                    <h3 class="semi-bold no-margin p-b-5"><b>{{$clients->count()}}</b>{{__('website.client')}}</h3>
                                    <div class="stats-bottom">
                                        <span class="small hint-text text-success">
                                            {{$clients_this_month}} {{__('website.new_client_this_month')}}
                                        </span>
                                    </div>
                                </div>

                                <div class="note-options">
                                    <a class="notes-opt-btn" data-toggle="tooltip" title="{{__('website.details')}}" 
                                    href="{{url(getLocal() . '/clients')}}">
                                        <i class="material-icons">more_horiz</i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="card no-border widget-loader-bar">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="col-xs-height col-top">
                                <div class="p-4">
                                    <h3 class="semi-bold  no-margin p-b-5"><b> {{$projects->count()}} </b> {{__('website.project')}}</h3>
                                    <div class="stats-bottom">
                                        <span class="small hint-text text-success">
                                            {{$projects_this_month}} {{__('website.new_project_this_month')}}
                                        </span>
                                    </div>
                                </div>

                                <div class="note-options">
                                    <a class="notes-opt-btn" data-toggle="tooltip" title="{{__('website.details')}}" 
                                    href="{{url(getLocal(). '/projects')}}">
                                        <i class="material-icons">more_horiz</i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6  col-xl-3">
                <div class="card no-border widget-loader-bar">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="col-xs-height col-top">
                                <div class="p-4">
                                    <h3 class="semi-bold  no-margin p-b-5"><b>

                                        @php
                                        $final_total = 0;
                                        foreach(Auth::user()->office_invoices as $one){
                                        $final_total += $one->invoice_amount;
                                         }

                                        $total =  number_format($final_total - Auth::user()->office_bills->sum('amount'), 1);
                                        @endphp


                                        {{ $total }}
                                        {{__('website.r_s')}}</b> {{__('website.receivables')}}
                                    </h3>
                                    <div class="stats-bottom">
                                        <span class="small hint-text text-success">71% {{__('website.progress')}}</span>
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

            <div class="col-sm-6 col-xl-3">
                <div class="card no-border widget-loader-bar">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="col-xs-height col-top">
                                <div class="p-4">
                                    <h3 class="semi-bold  no-margin p-b-5"><b>
                                        {{ number_format(Auth::user()->office_bills->sum('amount'), 1)}}

                                        {{__('website.r_s')}} </b>  {{__('cp.total_collection')}}
                                    </h3>
                                    <div class="stats-bottom">
                                        <span class="small hint-text text-success">88% {{__('website.progress')}}</span>
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

        <div class="row no-gutters dashboard-no-gutters mt-4">
            <div class="col-lg-6 d-flex">
                <!-- START WIDGET widget_pendingComments.tpl-->
                <div class=" card m-0 no-border pending-projects-widget">
                    <div class="card-header">
                        <h3 class="text-complete justify-content-between d-flex align-items-center">
                            {{__('website.statstics')}}
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 nav nav-tabs nav-tabs-simple m-b-20" role="tablist" data-init-reponsive-tabs="collapse">

                            @if(user_role(2))
                            <li class="nav-item">
                                <a href="#pending" class="active bold" data-toggle="tab" role="tab" aria-expanded="true">
                                    {{__('website.projects')}}
                                </a>
                            </li>
                            @endif

                            @if(user_role(3))
                            <li class="nav-item">
                                <a href="#completed" data-toggle="tab" role="tab" aria-expanded="false" class="bold">
                                    {{__('website.tasks')}}
                                </a>
                            </li>
                            @endif

                            @if(user_role(8))
                            <li class="nav-item">
                                <a href="#Meetings" data-toggle="tab" role="tab" aria-expanded="false" class="bold">
                                    {{__('website.next_sessions')}}
                                </a>
                            </li>
                            @endif

                            @if(user_role(6))
                            <li class="nav-item">
                                <a href="#invoices" data-toggle="tab" role="tab" aria-expanded="false" class="bold">
                                    {{__('website.claim_invoices')}}
                                </a>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content no-padding">
                            <div class="tab-pane active" id="pending">
                                @if(isset($projects))
                                @foreach($projects->take(5) as $one)
                                <div>
                                    <div class="d-flex mb-3">
                                        <span class="icon-thumbnail mr-0  ml-lg-3 bg-master-light pull-left text-master">ws</span>
                                        <div class="flex-1 full-width overflow-ellipsis">
                                            <p class="black-text all-caps bold small no-margin overflow-ellipsis ">
                                                <a href="{{url(getLocal(). '/projects/'.$one->id)}}">{{@$one->name}}</a>
                                            </p>
                                            <h5 class="no-margin overflow-ellipsis fs-12">
                                                {{__('website.this_project_end_in_date')}}
                                                {{substr($one->start_project_date_hijri, 0, 10)}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif

                                    <a href="{{url(getLocal(). '/projects')}}" class="btn btn-block m-t-30 text-black">{{__('cp.view_all_projects')}}</a>

                            </div>

                            <div class="tab-pane" id="completed">
                            @if(isset($tasks))
                            @foreach($tasks->take(5) as $one)
                                <div>
                                    <div class="d-flex mb-3">
                                        <span class="icon-thumbnail mr-0  ml-lg-3 bg-master-light pull-left text-master">ws</span>
                                        <div class="flex-1 full-width overflow-ellipsis">
                                            <p class="black-text all-caps bold small no-margin overflow-ellipsis">
                                                <a href="{{url(getLocal(). '/tasks/'.$one->id)}}">{{@$one->name}}</a>
                                            </p>
                                            <h5 class="no-margin overflow-ellipsis fs-12">
                                                {{__('website.this_task_end_in_date')}}
                                                {{Arr::get(getDates(substr($one->end_date, 0, 10)), 'hijri_date')}}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif

                            <a href="{{url(getLocal(). '/tasks')}}" class="btn btn-block m-t-30 text-black">{{__('cp.view_all_tasks')}}</a>

                        </div>


                        <div class="tab-pane" id="Meetings">

                            @if(isset($reports))
                            @foreach($reports->where('next_date', '<>', null)->take(5)->sortBy('next_date') as $one)
                            <div class="">
                                <div class="d-flex">
                                    <span class="icon-thumbnail mr-0  ml-lg-3 bg-master-light pull-left text-master">ws</span>
                                    <div class="flex-1 full-width overflow-ellipsis">
                                        <p class="black-text all-caps bold no-margin overflow-ellipsis ">
                                            <a href="{{url(getLocal(). '/reports/' . $one->id)}}">{{@$one->project->name}}</a></p>
                                        <h5 class="no-margin overflow-ellipsis fs-12">
                                            {{Arr::get(getDates(substr($one->next_date, 0, 10)), 'hijri_date')}} - {{@$one->next_time}}</h5>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            <a href="{{url(getLocal(). '/reports')}}" class="btn btn-block m-t-30 text-black">{{__('cp.view_all_sessions')}}</a>

                        </div>


                        <div class="tab-pane" id="invoices">


                            @if(isset($invoices))
                            @foreach($invoices->take(5)->sortBy('claim_date') as $one)
                            <div class="">
                                <div class="d-flex">
                                    <span class="icon-thumbnail mr-0  ml-lg-3 bg-master-light pull-left text-master">ws</span>
                                    <div class="flex-1 full-width overflow-ellipsis">
                                        <p class="black-text all-caps bold no-margin overflow-ellipsis ">
                                            <a href="{{url(getLocal(). '/invoices/' . $one->id)}}">
                                            {{__('website.invoice')}} {{ @$one->project->name }}
                                            </a>
                                        </p>
                                        <h5 class="no-margin overflow-ellipsis fs-12">
                                            {{__('website.invoiceAmount')}} {{ @$one->invoice_amount }} {{__('website.sr')}}
                                        </h5>
                                        <h5 class="no-margin overflow-ellipsis fs-12">{{__('website.date')}}
                                            {{Arr::get(getDates(substr($one->claim_date, 0, 10)), 'hijri_date')}}
                                        </h5>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            <a href="{{url(getLocal(). '/invoices')}}" class="btn btn-block m-t-30 text-black">{{__('cp.view_all_invoices')}}</a>

                        </div>

                    </div>
                </div>
            </div>
            <!-- END WIDGET -->
        </div>

        <div class="col-lg-6 d-flex">
            <div class=" card m-0 no-border" style="padding-bottom:40px">
                <div class="card-header ">
                    <h5 class="bold">{{__('cp.activites')}}</h5>
                </div>
                <div class="card-body pt-4" style="height:350px;overflow: auto;">


                            @if(isset(Auth::user()->office_activities))
                            @foreach(Auth::user()->office_activities as $one)
                            <div class="row-xs-height">
                                <div class="social-user-profile col-xs-height text-center col-top">
                                    <div class="thumbnail-wrapper d48 circular bordered b-white">
                                        <img alt="Avatar" width="55" height="55" data-src-retina="assets/img/profiles/avatar_small2x.jpg" data-src="{{$one->user->image}}" src="{{$one->user->image}}">
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-height p-r-20">
                                    <h6 class="no-margin p-b-5 fs-13">{{@$one->user->name}}</h6>
                                    <time class="no-margin fs-12">
                                        {{Arr::get(getDates(substr($one->created_at, 0, 10)), 'hijri_date')}}</time>
                                    <p class="m-t-5 small">{{@$one->activity->name}}</p>
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
@endsection
