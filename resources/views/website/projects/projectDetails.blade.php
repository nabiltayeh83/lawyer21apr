@extends('layout.siteLayout')
@section('title', __('website.projects'))

@section('topfixed')
<div class="page-top-fixed">
    <div class="container-fluid">
    	<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
		    <h2 class="page-header mb-1 my-md-3">{{$item->name}}</h2>
    	    <div class="page-options-btns">
		        <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

				 <!--   <button type="button" class="btn btn-default has-icon" data-toggle="modal">-->
					<!--    <i class="material-icons">description</i>-->
					<!--    <span>{{__('website.release_invoice')}}</span>-->
     <!--                </button>-->

			        <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/exportProjectDetPDF/' . $item->id)}}'">
				        <i class="material-icons">picture_as_pdf</i>
				        <span>{{__('website.export')}}</span>
                    </button>

					<button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/projects/' .$item->id. '/edit')}}'">
					    <i class="material-icons">edit</i>
					    <span>{{__('website.edit')}}</span>
					</button>

                    <button type="button" class="btn btn-default has-icon" data-target="#modalSlideLeft" data-toggle="modal">
                        <i class="material-icons">close</i> <span>{{__('website.delete')}}</span>
                    </button>

                    <select style="padding:2px;" class="cs-select cs-skin-slide buttonTypeTask changeProjectStatus" name="slct" id="changeProjectStatus" name="changeProjectStatus" data-id="{{$item->id}}">
						<option selected disabled>{{__('website.change_status')}}</option>
                        <option value="1" {{ $item->project_status_id == 1? 'selected':'' }} > {{__('website.open')}} </option>
                        <option value="2" {{ $item->project_status_id == 2? 'selected':'' }}> {{__('website.close')}} </option>
                        <option value="3" {{ $item->project_status_id == 3? 'selected':'' }}> {{__('website.waiting')}} </option>
                    </select>

                </div>
			</div>
		</div>
	</div>
</div>

<input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" name="chkBox" checked style="display:none;" />

@endsection


@section('content')
<div class="content">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/projects')}}">{{__('website.projects')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.project_data')}}</li>
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row no-gutters dashboard-statistics dashboard-no-gutters mt-4">
            <div class="col-sm-6 col-xl-4">
                <div class="card no-border widget-loader-bar">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="col-xs-height col-top">
                                <div class="p-4">
                                    <h3 class="semi-bold no-margin p-b-5"><b>
                                        {{$item->hours->sum('hours_count')}}
                                        </b> {{__('website.hour')}}
                                    </h3>

                                    <div class="stats-bottom">
                                        <span class="small hint-text text-success">
                                            {{__('website.project_hours_count')}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-4">
                <div class="card no-border widget-loader-bar">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="col-xs-height col-top">
                                <div class="p-4">
                                    <h3 class="semi-bold no-margin p-b-5"><b>
                                        {{@$item->bills->sum('amount')}}
                                        </b>{{__('website.sr')}}
                                    </h3>

                                    <div class="stats-bottom">
                                        <span class="small hint-text text-success">
                                            {{__('website.total_financial_payments')}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-4">
                <div class="card no-border widget-loader-bar">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="col-xs-height col-top">
                                <div class="p-4">
                                    <h3 class="semi-bold no-margin p-b-5"><b>

                                        @php
                                        $final_total = 0;
                                        if(isset($item->invoices)){
                                            foreach($item->invoices as $one){
                                                $final_total += $one->invoice_amount;
                                            }
                                         }
                                        @endphp

                                        {{$final_total - $item->bills->sum('amount')}}
                                        </b>{{__('website.sr')}}
                                    </h3>
                                    <div class="stats-bottom">
                                        <span class="small hint-text text-success">
                                            {{__('website.total_financial_receivables')}}
                                        </span>
                                    </div>
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
                        <a class="active" data-toggle="tab" role="tab" data-target="#dataProject" href="#">{{__('website.project_data')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#hoursProject">{{__('website.hours')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#expenseProject">{{__('website.expenses')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#flatsFees">{{__('website.flats_fees')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#noteProject">{{__('website.notes')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#taskProject">{{__('website.tasks')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#attchProject">{{__('website.attachments')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#reportsProject">{{__('website.reports')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#invoiceProject">{{__('website.invoices')}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#paymentProject">{{__('website.financial_payments')}}</a>
                    </li>
                </ul>

                <div class="tab-content bg-white">
                    <div class="tab-pane active" id="dataProject">
                        <div class="col-lg-12 col-xl-12 col-md-12  d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header">
                                    <h3 class="text-success justify-content-between d-flex align-items-center">
                                        {{__('website.project_data')}}
                                    </h3>
                                </div>
                                <div class="card-body no-padding">
                                    <div class="card no-border m-0">
                                        <div class="card-body pb-1">
                                            <div class="row dashboard-no-gutters">
                                                <div class="col-lg-4 secDataProject">
                                                    <p>
                                                        <strong>{{__('website.project_type')}}</strong>
                                                        <span>
                                                            @if(@$item->type == 1)
                                                                {{__('website.issue')}}
                                                                @elseif(@$item->type == 2)
                                                                    {{__('website.consultation')}}
                                                                @else
                                                                    {{__('website.other')}}
                                                            @endif
                                                        </span>
                                                    </p>

                                                    @if(isset($item->project_number))
                                                        <p>
                                                            <strong>{{__('website.issue_number')}}</strong>
                                                            <span>{{@$office_settings->projects_number}}{{@$item->project_number}}</span>
                                                        </p>
                                                    @endif

                                                    @if(isset($item->fee_type))
                                                        <p>
                                                            <strong>{{__('website.fees_type')}}</strong>
                                                            <span>
                                                                {{__('website.fee_type' . $item->fee_type)}}
                                                                @if(isset($item->fee_type) && $item->fee_type == 1)
                                                                    {{@$item->value_per_hour}} {{__('website.sr')}}  <br>
                                                                @endif
                                                                @if(isset($item->fee_type) && $item->fee_type == 2)
                                                                    / {{@$item->flats_fees->sum('price')}} {{__('website.sr')}}
                                                                @endif
                                                            </span>
                                                        </p>
                                                    @endif

                                                    @if(isset($item->lawsuit->name))
                                                        <p>
                                                            <strong>{{__('website.type_suit')}}</strong>
                                                            <span>{{@$item->lawsuit->name}}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4 secDataProject">
                                                    <p id="projectStatus">
                                                        <strong>{{__('website.issues_case')}}</strong>
                                                        <span>{{@$item->status->name}}</span>
                                                    </p>

                                                    @if(isset($item->court_name) && $item->court_name != null)
                                                    <p>
                                                        <strong>{{__('website.court_name')}}</strong>
                                                        <span id="projectStatus">{{@$item->court_name}}</span>
                                                    </p>
                                                    @endif

                                                    <p>
                                                        <strong>{{__('website.date')}}</strong>
                                                        <span>{{Arr::get(getDates(substr($item->start_project_date, 0, 10)), 'hijri_date')}}</span>
                                                    </p>
                                                    <p>
                                                        <strong>{{__('website.gov_institution')}}</strong>
                                                        <span>{{@$item->gov_institution}}</span>
                                                    </p>

                                                    @if(isset($item->responsible_lawyer))
                                                        <p>
                                                            <strong>{{__('website.responsible_emp')}}</strong>
                                                            <span>{{ @$item->project_manager->name}}</span>
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4 secDataProject">
                                                    @if(isset($item->client_id))
                                                    <p>
                                                        <strong>{{__('website.client')}}</strong>
                                                        <span>
                                                            <a href="{{url(getLocal(). '/clients/'.$item->client_id)}}" style="margin:0;">
                                                                {{@$item->client->name}}
                                                            </a>
                                                        </span>
                                                    </p>
                                                    @endif

                                                    <p>
                                                        <strong>{{__('website.phone')}}</strong>
                                                        <span>{{ @$item->client->mobile}}</span>
                                                    </p>
                                                    <p>
                                                        <strong>{{__('website.email')}}</strong>
                                                        <span>{{ @$item->client->email}}</span>
                                                    </p>

                                                    <p>
                                                        <strong>{{__('website.address')}}</strong>
                                                        <span>{{ @$item->client->address}}</span>
                                                    </p>
                                                </div>
                                                
                                                @if(isset($item->extra_fields))
                                                <div class="col-lg-12 secDataProject">
                                                    <p>
                                                        @foreach($item->extra_fields as $one)
                                                            <strong>{{@$one->field->name}}</strong>
                                                            <span>{{@$one->value}}<br><br></span>
                                                        @endforeach
                                                    </p>
                                                </div>
                                                @endif
                                                

                                                @if(isset($item->employees))
                                                <div class="col-lg-12 secDataProject">
                                                    <p>
                                                        <strong>{{__('website.project_employees')}}</strong>
                                                        <span>
                                                                @foreach($item->employees as $one)
                                                                   {{$loop->iteration}} - {{@$one->user->name}} <br>
                                                                @endforeach
                                                        </span>
                                                    </p>
                                                </div>
                                                @endif

                                                <div class="col-lg-12 secDataProject">
                                                    <p>
                                                        <strong>{{__('website.issue_description')}}</strong>
                                                        <span>{{@$item->details}}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="hoursProject">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div>
                                        <h5>{{__('website.hours')}}</h5>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddHours" data-toggle="modal">
                                            <i class="material-icons">add</i>
                                            <span>{{__('website.add_hours')}}</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body p-0 allHours">
                                    <div class="table-responsive">
                                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">#</div>
                                                    </th>
                                                    <th class="wd-25p">{{__('website.responsible_emp')}}</th>
                                                    <th class="wd-15p">{{__('website.hours')}}</th>
                                                    <th class="wd-15p">{{__('website.range')}}</th>
                                                    <th class="wd-10p">{{__('website.date')}}</th>
                                                    <th class="wd-20p">{{__('website.amount')}}</th>
                                                    <th class="wd-15p">{{__('website.status')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($item->hours))
                                                @foreach($item->hours as $one)
                                                <tr>
                                                    <td class="v-align-middle wd-5p">
                                                        <div class="checkbox checkMain text-center">{{$loop->iteration}}</div>
                                                    </td>
                                                    <td class="v-align-middle wd-20p">{{@$one->employee->name}}</td>
                                                    <td class="v-align-middle wd-15p">{{@$one->hours_count}}</td>
                                                    <td class="v-align-middle wd-15p"><p>{{@$one->price}}</p></td>
                                                    <td class="v-align-middle wd-10p"><p>

                                                        {{Arr::get(getDates(substr($one->start_date, 0, 10)), 'hijri_date')}}
                                                    </p></td>
                                                    <td class="v-align-middle wd-20p"><p>
                                                        {{($one->hours_count*$one->price)}} {{__('website.r_s')}}</p></td>
                                                    <td class="v-align-middle wd-15p">
                                                        <span class="badge badge-pill
                                                            @if($one->hour_status == 'paid') badge-info @endif
                                                            @if($one->hour_status == 'billable') badge-success @endif
                                                            @if($one->hour_status == 'not_billable') badge-danger @endif " id="label-{{@$one->id}}">
                                                            {{__('website.'.$one->hour_status)}}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane allExpenses" id="expenseProject">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div>
                                        <h5> {{__('website.expenses')}}</h5>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#addExpense" data-toggle="modal">
                                            <i class="material-icons">add</i><span> {{__('website.add')}} {{__('website.expense')}}</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">#</div>
                                                    </th>
                                                    <th class="wd-15p">{{__('website.expense_aspect')}}</th>
                                                    <th class="wd-20p">{{__('website.expense_date')}}</th>
                                                    <th class="wd-15p">{{__('website.recipient_name')}}</th>
                                                    <th class="wd-15p">{{__('website.amount')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($item->expenses))
                                                @foreach($item->expenses as $one)
                                                <tr>
                                                    <td class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">{{$loop->iteration}}</div>
                                                    </td>
                                                    <td class="wd-15p"><a href="{{url(getLocal(). '/expenses/'.$one->id)}}">{{@$one->aspect_expense->name}}</a></td>
                                                    <td class="wd-20p">
                                                        {{Arr::get(getDates(substr($one->expense_date, 0, 10)), 'hijri_date')}}
                                                    </td>
                                                    <td class="wd-15p">{{@$one->employee->name}}</td>
                                                    <td class="wd-15p">{{@$one->total_amount}} {{__('website.r_s')}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane allFlatsFees" id="flatsFees">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div>
                                        <h5>{{__('website.flats_fees')}}</h5>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#addFlatsFees" data-toggle="modal">
                                            <i class="material-icons">add</i><span>{{__('website.add_flat_fee')}}</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">#</div>
                                                    </th>
                                                    <th class="wd-15p">{{__('website.amount')}}</th>
                                                    <th class="wd-15p">{{__('website.date')}}</th>
                                                    <th class="wd-60p">{{__('website.details')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($item->flats_fees))
                                                @foreach ($item->flats_fees as $one)
                                                <tr>
                                                    <td class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">{{$loop->iteration}}</div>
                                                    </td>
                                                    <td class="wd-15p">{{@$one->price}} {{__('website.sr')}}</td>
                                                    <td class="wd-15p">
                                                        {{Arr::get(getDates(substr($one->date, 0, 10)), 'hijri_date')}}
                                                    </td>
                                                    <td class="wd-60p">{{@$one->description}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="noteProject">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class=" card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div>
                                        <h5>{{__('website.notes')}}</h5>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddNote" data-toggle="modal">
                                            <i class="material-icons">add</i>
                                            <span>{{__('website.add_new_note')}}</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover tableWithSearch allNotes" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">#</div>
                                                    </th>
                                                    <th class="wd-65p">{{__('website.details')}}</th>
                                                    <th class="wd-20p">{{__('website.date')}}</th>
                                                    <th class="wd-10p">{{__('website.action')}}</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if(isset($item->project_notes))
                                                @foreach($item->project_notes as $one)
                                                <tr id="div-{{$one->id}}">
                                                    <td class="v-align-middle wd-5p">
                                                        <div class="checkbox checkMain text-center">
                                                            {{$loop->iteration}}
                                                        </div>
                                                    </td>
                                                    <td class="v-align-middle wd-105p">
                                                        {{@$one->note}}
                                                    </td>
                                                    <td class="v-align-middle wd-20p">

                                                        {{Arr::get(getDates(substr($one->note_date, 0, 10)), 'hijri_date')}}
                                                    </td>
                                                    <td class="v-align-middle wd-10p">
                                                        <div class="note-options">
                                                            <a class="notes-opt-btn modalToEditNote event" data-toggle="modal" title="{{__('website.edit')}}" data-id="{{$one->id}}" href="#modalToEditNote">
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                            <a class="notes-opt-btn modalToDeleteNote event" data-toggle="modal" title="{{__('website.delete')}}" data-id="{{$one->id}}" href="#modalToDeleteNote">
                                                                <i class="material-icons">close</i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="taskProject">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div>
                                        <h5>{{__('website.tasks')}}</h5>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddProjectTask" data-toggle="modal">
                                            <i class="material-icons">add</i>
                                            <span>{{__('website.add_task')}}</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover tableWithSearch ProjectTasks" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">
                                                            #
                                                        </div>
                                                    </th>
                                                    <th class="wd-15p">{{__('website.title')}}</th>
                                                    <th class="wd-20p">{{__('website.responsible_emp')}}</th>
                                                    <th class="wd-15p">{{__('website.date')}}</th>
                                                    <th class="wd-15p">{{__('website.status')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($item->tasks))
                                                @foreach($item->tasks as $one)
                                                <tr>
                                                    <td class="v-align-middle wd-5p">
                                                        <div class="checkbox checkMain text-center">1</div>
                                                    </td>
                                                    <td class="v-align-middle wd-20p">
                                                        <a href="{{url(getLocal(). '/tasks/' . $one->id)}}">{{@$one->name}}</a>
                                                    </td>
                                                    <td class="v-align-middle wd-20p">
                                                        @if(isset($one->employee))
                                                            <p>{{@$one->employee->name}}</p>
                                                        @endif
                                                    </td>
                                                    <td class="v-align-middle wd-15p">
                                                        <p>

                                                            {{Arr::get(getDates(substr($one->end_date, 0, 10)), 'hijri_date')}}
                                                        </p>
                                                    </td>
                                                    <td class="v-align-middle wd-15p">
                                                        <p>{{@$one->task_status->name}}</p>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="attchProject">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div>
                                        <h5>{{__('website.attachments')}}</h5>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#modalAddAttach" data-toggle="modal">
                                            <i class="material-icons">add</i><span>{{__('website.add_attachment')}}</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive AttachsFiles">
                                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">#</div>
                                                    </th>
                                                    <th class="wd-45p">{{__('website.attachment_name')}}</th>
                                                    <th class="wd-15p no-sort"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($item->attachments))
                                                @foreach($item->attachments as $one)
                                                <tr>
                                                    <td class="v-align-middle wd-5p">
                                                        <div class="checkbox checkMain text-center">1</div>
                                                    </td>
                                                    <td class="v-align-middle wd-45p">{{@$one->attachment_name}}</td>
                                                    <td class="v-align-middle wd-15p text-center">
                                                        <a href="{{@$one->file}}" target="_blank"><i class="material-icons">visibility</i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="reportsProject">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div>
                                        <h5>{{__('website.reports')}}</h5>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(getLocal(). '/reports/create')}}'">
                                            <i class="material-icons">add</i>
                                            <span>{{__('website.add_report')}}</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0 allReports">
                                    <div class="table-responsive">
                                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">#</div>
                                                    </th>
                                                    <th class="wd-30p">{{__('website.task')}}</th>
                                                    <th class="wd-20p">{{__('website.date')}}</th>
                                                    <th class="wd-20p">{{__('website.status')}}</th>
                                                    <th class="wd-20p">{{__('website.action')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if(isset($item->reports))
                                                @foreach($item->reports as $one)
                                                <tr>
                                                    <td class="v-align-middle wd-5p">
                                                        <div class="checkbox checkMain text-center">{{$loop->iteration}}-</div>
                                                    </td>
                                                    <td class="v-align-middle wd-30p">{{@$one->task->name}}</a></td>
                                                    <td class="v-align-middle wd-20p"><p>
                                                        {{Arr::get(getDates(substr($one->created_at, 0, 10)), 'hijri_date')}}
                                                    </p></td>
                                                    <td class="v-align-middle wd-20p"><p>{{__('website.' . $one->status)}}</p></td>
                                                    <td class="v-align-middle wd-20p">
                                                        <a href="href=https://docs.google.com/spreadsheets/d/15iJFdNcNYxlUIlrQ5bo7x5GtXqBGD3U6Ki7o1-ouQtk/edit#gid=1506658336" target="_blank">
                                                            <i class="material-icons">picture_as_pdf</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="invoiceProject">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div><h5> {{__('website.invoices')}}</h5></div>
                                    <div class="btn-group">
                                        <button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#AddInvoices" data-toggle="modal">
										    <i class="material-icons">add</i> <span>{{__('website.add')}} {{__('website.invoices')}}</span>
									  </button>
                                    </div>
                                </div>
                                <div class="card-body p-0 allInvoices">
                                    <div class="table-responsive">
                                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">#</div>
                                                    </th>
                                                    <th class="wd-15p">{{__('website.invoiceID')}}</th>
                                                    <th class="wd-20p">{{__('website.recipient_name')}}</th>
                                                    <th class="wd-15p">{{__('website.invoice_date')}}</th>
                                                    <th class="wd-15p">{{__('website.amount')}}</th>
                                                    <th class="wd-15p">{{__('website.status')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if(isset($item->invoices))
                                                @foreach($item->invoices as $one)
                                                <tr>
                                                    <td class="v-align-middle wd-5p">
                                                        <div class="checkbox checkMain text-center">{{$loop->iteration}}</div>
                                                    </td>
                                                    <td class="v-align-middle wd-15p">{{@$one->invoice_number}}</a></td>
                                                    <td class="v-align-middle wd-20p">{{@$one->client->name}}</td>
                                                    <td class="v-align-middle wd-15p">
                                                        {{Arr::get(getDates(substr($one->claim_date, 0, 10)), 'hijri_date')}}
                                                    </a></td>
                                                    <td class="v-align-middle wd-15p">{{@$one->invoice_amount}} {{__('website.sr')}}</td>
                                                    <td class="v-align-middle wd-15p">{{__('website.' . $one->status)}}</td>
                                                </tr>
                                                @endforeach
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="paymentProject">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header d-flex flex-column flex-sm-row align-items-sm-start justify-content-sm-between">
                                    <div>
                                        <h5> {{__('website.financial_payments')}}</h5>
                                    </div>
                                    <div class="btn-group">

                                        <!--<button class="btn btn-complete has-icon mb-2 m-md-0" data-target="#AddPayment" data-toggle="modal">-->

                                        <button class="btn btn-complete  has-icon mb-2 m-md-0" onclick="window.location.href='{{url(getLocal(). '/bills/create')}}'">
                                            <i class="material-icons">add</i>
                                            <span> {{__('website.add')}} {{__('website.financial_payments')}}</span>
                                        </button>




                                    </div>

                                </div>
                                <div class="card-body p-0 allBills">
                                    <div class="table-responsive">
                                        <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                            <thead>
                                                <tr>
                                                    <th class="wd-5p no-sort">
                                                        <div class="checkbox checkMain text-center">#</div>
                                                    </th>
                                                    <th class="wd-15p">{{__('website.billID')}}</th>
                                                    <th class="wd-15p">{{__('website.date')}}</th>
                                                    <th class="wd-15p">{{__('website.payment_methods')}}</th>
                                                    <th class="wd-15p">{{__('website.amount')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @if(isset($item->bills))
                                                @foreach($item->bills as $one)
                                                <tr>
                                                    <td class="v-align-middle wd-5p">
                                                        <div class="checkbox checkMain text-center">{{$loop->iteration}}</div>
                                                    </td>
                                                    <td class="v-align-middle wd-15p">{{@$one->id}}</a></td>
                                                    <td class="v-align-middle wd-15p">
                                                        {{Arr::get(getDates(substr($one->payment_date, 0, 10)), 'hijri_date')}}
                                                    </td></a></td>
                                                    <td class="v-align-middle wd-15p">{{@$one->payment_method->name}}</td>
                                                    <td class="v-align-middle wd-15p">{{@$one->amount}} {{__('website.sr')}}</td>
                                                </tr>
                                                @endforeach
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
        </div>

        <div class="row no-gutters dashboard-statistics dashboard-no-gutters mt-4">
            <div class="card m-0 no-border">
                <div class="card-header">
                    <h5 class="bold">{{__('website.project_activities')}}</h5>
                </div>
                <div class="card-body pt-4" style="height:350px;overflow: auto;">

                @if(isset($item->activities))
                @foreach($item->activities as $itm)
                <div class="row-xs-height">
                    <div class="social-user-profile col-xs-height text-center col-top">
                        <div class="thumbnail-wrapper d48 circular bordered b-white">
                            <img alt="Avatar" width="55" height="55" data-src-retina="assets/img/profiles/avatar_small2x.jpg" data-src="assets/img/profiles/avatar.jpg" src="{{@$itm->user->image}}">
                        </div><br>
                    </div>
                    <div class="col-xs-height p-r-20">
                        <h6 class="no-margin p-b-5 fs-13">{{@$itm->user->name}}</h6>
                        <time class="no-margin fs-12">
                            {{Arr::get(getDates(substr($itm->created_at, 0, 10)), 'hijri_date')}}</time>
                        <p class="m-t-5 small">{{@$itm->activity->name}}</p>
                    </div>
                </div>
                @endforeach
                @endif
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
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>{{__('website.You_are_about_to_delete_the_project')}}
                            <span class="block bold viewItems"></span></p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll deleteProjectFromDetPage" data-dismiss="modal" data-action="delete">
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


<div class="modal fade slide-right" id="modalAddProjectTask" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h6>{{__('website.add_new_task')}}</h6>
                </div>
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height">
                            <form method="post" action="javascript:void(0)" id="formCreateProjectTask">
                            {{csrf_field()}}

                            @if(Request::segment(2) == 'projects' && Request::segment(3))
                            <input type="hidden" name="task_category" value="project">
                            <input type="hidden" name="project_id" value="{{Request::segment(3)}}">

                            <div class="form-group form-group-default form-group-default-select2 selectProject">
                                <label>{{__('website.select_project_name')}} </label>
                                <select class="full-width" data-init-plugin="select2" id="project_id" @if(Request::segment(2) == 'projects' && Request::segment(3) != null) disabled @endif name="project_id">
                                    <optgroup label="{{__('website.select_project_name')}}">
                                        <option value=""></option>
                                        @if(isset($projects))
                                        @foreach($projects as $one)
                                            <option @if($one->id == Request::segment(3)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                            </div>
                            @else

                            <div class="form-group mb-3 row">
                                <label for="fname" class="col-md-3 control-label bold fs-14">{{__('website.task_category')}}</label>
                                <div class="col-md-9">
                                    <div class="radio radio-success">
                                        <input type="radio" value="project" name="task_category" required id="projectCategory2">
                                        <label for="projectCategory2">{{__('website.project')}}</label>
                                        <input type="radio" value="other" name="task_category" required id="otherCategory2">
                                        <label for="otherCategory2">{{__('website.other')}}</label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group form-group-default form-group-default-select2 hidden selectProject required">
                                <label> {{__('website.project')}} </label>
                                <select class="full-width" data-init-plugin="select2" id="project_id" name="project_id">
                                    <optgroup label="{{__('website.select_project_name')}}">
                                        <option value=""></option>
                                        @if(isset($projects))
                                        @foreach($projects as $one)
                                            <option {{($item->id == $one->id)? 'selected':''}} value="{{@$one->id}}">{{@$one->name}}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                            </div>
                            @endif

                            <div class="form-group form-group-default">
                                <label> {{__('website.task_name')}} </label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>

                            <div class="form-group form-group-default form-group-default-select2 required">
                                <label>{{__('website.task_type')}}</label>
                                <select class="full-width" data-init-plugin="select2" id="task_type_id" name="task_type_id">
                                    <optgroup label="{{__('website.select_task_type')}}">
                                        <option value=""></option>
                                        @if(isset(Auth::user()->office_task_types))
                                        @foreach(Auth::user()->office_task_types as $one)
                                            <option value="{{@$one->task_type_id}}">{{@$one->task_type->name}}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                            </div>

                            <div class="form-group form-group-default form-group-default-select2 required">
                                <label>{{__('website.task_employees')}}</label>
                                <select class="full-width" data-init-plugin="select2" multiple id="task_employees" name="task_employees[]">
                                    <optgroup label="{{__('website.choose_emp_name')}}">
                                        @if(isset(Auth::user()->office_employees))
                                        @foreach(Auth::user()->office_employees as $one)
                                            <option value="{{@$one->id}}">{{@$one->name}}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                </select>
                            </div>

                            <div class="form-group form-group-default">
                                <label> {{__('website.task_end_date')}} </label>
                                <input type="text" name="end_date" class="form-control hijri-date-input">
                            </div>


                            <div class="form-group form-group-default">
                                <label> {{__('website.time')}} </label>
                                <input type="time" class="form-control next_time" name="task_time">
                            </div>

                            <div class="form-group mg-t-30">
                                <div class="row row-xs">
                                    <div class="col-6">
                                        <div class="form-group form-group-default form-group-default-select2 ">
                                            <label> {{__('website.task_status')}} </label>
                                            <select class="full-width" data-init-plugin="select2" id="task_status_id" name="task_status_id">
                                                <optgroup label="{{__('website.select_task_status')}}">
                                                    <option value=""></option>
                                                    @if(isset(Auth::user()->office_task_status))
                                                    @foreach(Auth::user()->office_task_status as $one)
                                                        <option value="{{@$one->task_status_id}}">{{@$one->task_status->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-6">
                                        <div class="form-group form-group-default form-group-default-select2 required">
                                            <label>{{__('website.priority')}}</label>
                                            <select class="full-width" data-init-plugin="select2" id="priority" name="priority">
                                                <optgroup label="{{__('website.select_priority')}}">
                                                    <option value="normal">{{__('website.normal')}}</option>
                                                    <option value="urgent">{{__('website.urgent')}}</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group d-flex align-items-center">
                                <label>{{__('website.reminder')}}</label>
                                <div class="col-md-7">
                                    <div class="radio radio-success">
                                        <input type="radio" value="yes" name="remind" id="checkNotiModal">
                                        <label for="checkNotiModal"> {{__('website.reminder_about_task_time')}} </label>
                                    </div>
                                </div>
                            </div>
                            <div class="animated fadeIn delay-0.5s" id="typeNotiModal">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label>{{__('website.choose_reminder_type')}}</label>
                                            <select class="full-width" data-init-plugin="select2" id="remind_type" name="remind_type">
                                                <optgroup label="{{__('website.choose_reminder_type')}}">
                                                    <option value=""></option>
                                                    <option value="email">{{__('website.email')}}</option>
                                                    <option value="window">{{__('website.window')}}</option>
                                                    <option value="whatsapp">{{__('website.whatsapp')}}</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label>{{__('website.period')}}</label>
                                            <select class="full-width" data-init-plugin="select2" id="remind_time_id" name="remind_time_id">
                                                <optgroup label="{{__('website.choose_period')}}">
                                                    <option value=""></option>
                                                    @if(isset($reminer_time))
                                                    @foreach($reminer_time as $one)
                                                        <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-complete btn-block" id="createProjectTask"> {{__('website.save')}} </button>
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>






<div class="modal fade slide-right" id="AddPayment" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
		    <div class="modal-content">
				<div class="modal-header mb-3">
					<h6> {{__('website.addBill')}} </h6>
				</div>
			    <div class="container-xs-height full-height">
		            <div class="row-xs-height">
					    <div class="modal-body col-xs-height">

						    <form method="post" action="javascript:void(0)" id="formCreateBill">
                            {{csrf_field()}}

                            @if(Request::segment(2) == 'projects' && Request::segment(3))
                                <input type="hidden" name="project_id" value="{{Request::segment(3)}}">
                                <input type="hidden" name="client_id" value="{{@$item->client_id}}">
                            @endif


					    	<div class="form-group form-group-default form-group-default-select2">
								<label>{{__('website.invoice')}}</label>
								<select class="full-width" data-init-plugin="select2" name="invoice_id">
								  <optgroup label="{{__('website.invoice')}}">
								  	  <option value=""></option>
								  	  @if(isset($item->invoices))
								  	  @foreach($item->invoices as $one)
								  	    <option value="{{$one->id}}">
								  	        {{ @$office_settings->invoices_number}}{{@$one->invoice_number}} - {{@$one->project->name}}
								  	    </option>
								  	  @endforeach
								  	  @endif
								  </optgroup>
								</select>
							</div>


						    <div class="form-group form-group-default">
								<label> {{__('website.reference_number')}} </label>
                                <input type="text" class="form-control" name="reference_number" required>
							</div>

							<div class="form-group form-group-default">
								<label>{{__('website.payment_date')}}</label>
                                <input type="text" name="payment_date" class="form-control payment_date" required>
							</div>

							<div class="form-group form-group-default form-group-default-select2">
								<label> {{__('website.payment_methods')}} </label>
						        <select class="full-width invoiceClients" required name="payment_method_id" id="payment_method_id" data-init-plugin="select2">
                                    <optgroup label="{{__('website.payment_methods')}}">
                                        <option value=""></option>
                                        @if(isset(Auth::user()->office_payment_methods))
                                        @foreach(Auth::user()->office_payment_methods as $one)
                                            <option value="{{$one->payment_method->id}}">{{$one->payment_method->name}}</option>
                                        @endforeach
                                        @endif
                                    </optgroup>
                                </select>
							</div>
							<div class="form-group form-group-default">
								<label> {{__('website.banks_account')}} </label>
							    <select class="full-width invoiceClients" required name="bank_id" id="bank_id" data-init-plugin="select2">
                                        <option value=""></option>
                                        @if(isset(Auth::user()->office_banks))
                                        @foreach(Auth::user()->office_banks as $one)
                                            <option value="{{$one->id}}">{{$one->name}}</option>
                                        @endforeach
                                        @endif
                                </select>
							</div>

							<div class="form-group form-group-default">
								<label>{{__('website.amount')}}</label>
                                <input type="text" class="form-control" name="amount" required>
							</div>

						    <button type="submit" class="btn btn-complete btn-block" id="createProjectBill"> {{__('website.save')}} </button>
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
