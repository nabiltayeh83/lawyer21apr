@extends('layout.siteLayout')
@section('title', __('website.invoices'))

@section('topfixed')
<div class="page-top-fixed">
	<div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3"> {{__('website.project_receivables_invoice')}} {{$item->project->name}}
            <span class="badge badge-pill badge-success invoiceStatus-{{$item->id}}"> {{__('website.' .$item->status)}} </span></h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">

                    <button type="button" class="btn btn-default has-icon"
                    onclick="window.location.href='{{url(getLocal(). '/invoicePreview/' . $item->id)}}'">
                        <i class="material-icons">picture_as_pdf</i><span>{{__('website.Preview')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" onclick="window.location.href='{{url(getLocal(). '/invoiceExportPDF/' . $item->id)}}'">
                        <i class="material-icons">cloud_download</i><span>{{__('website.download')}}
                    </button>

                    <button type="button" class="btn btn-default has-icon completeInvoice" data-id="{{$item->id}}">
                        <i class="material-icons">check</i><span>{{__('website.approve')}}</span>
                    </button>

                    @if($item->expense_status != 'certified')
                    <button type="button" class="btn btn-default has-icon"onclick="window.location.href='{{url(getLocal(). '/invoices/' . $item->id . '/edit')}}'">
                        <i class="material-icons">edit</i><span>{{__('website.edit')}}</span>
                    </button>
                    @endif

                    <button type="button" class="btn btn-default has-icon" data-target="#modalSlideLeft" data-toggle="modal">
                        <i class="material-icons">close</i> <span>{{__('website.delete')}}</span>
                    </button>
                </div>

                <button class="btn btn-complete has-icon mb-2 m-md-0" onclick="window.location.href='{{url(getLocal(). '/bills/create')}}'">
                    <i class="material-icons">add</i><span>  {{__('website.addBill')}} </span>
                </button>

            </div>
		</div>
	</div>
</div>
@endsection



@section('content')
<div class="content">
    <div class="bg-white">
        <div class="container-fluid">
            <ol class="breadcrumb breadcrumb-alt">
                <li class="breadcrumb-item"><a href="{{url(app()->getLocale().'/invoices')}}">{{__('website.invoices')}}</a></li>
                <li class="breadcrumb-item active">{{__('website.invoices_data')}}</li>
            </ol>
        </div>
    </div>

    <div class=" container-fluid">
        <div class="row no-gutters dashboard-no-gutters mt-4">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a class="active" data-toggle="tab" role="tab"data-target="#dataInvoices" href="#">
                            {{__('website.data')}} {{__('website.invoice')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#paymentInvoices">{{__('website.bills')}} </a>
                    </li>
                </ul>
                <div class="tab-content bg-white">
                    <div class="tab-pane active" id="dataInvoices">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card no-border m-0">
                                <div class="card-header">
                                    <h3 class="text-success justify-content-between d-flex align-items-center">
                                        {{__('website.invoices_data')}}
                                    </h3>
                                </div>
                                <div class="card-body no-padding p-b-15">
                                    <div class="card no-border m-0">
                                        <div class="card-body pb-1">
                                            <div class="row dashboard-no-gutters">
                                                <div class="col-lg-6 secDataProject">
                                                    <p><strong>{{__('website.project')}}</strong>
                                                    <a href="{{url(getLocal(). '/projects/'.$item->project_id)}}">{{$item->project->name}}</a></p>
                                                    <p><strong>{{__('website.client_name')}}</strong><span>{{$item->client->name}}</span></p>
                                                    <p><strong> {{__('website.release_date')}}
                                                     </strong><span>
                                                        {{Arr::get(getDates(substr($item->release_date, 0, 10)), 'hijri_date')}}</span></p>
                                                    <p><strong> {{__('website.claim_date')}}</strong><span>

                                                        {{Arr::get(getDates(substr($item->claim_date, 0, 10)), 'hijri_date')}}</span></p>
                                                </div>
                                                <div class="col-lg-6 secDataProject">
                                                    <p><strong>{{__('website.amount_paid')}} </strong><span>
                                                    {{$item->invoice_bills}}  {{__('website.sr')}}</span></p>
                                                    <p><strong>{{__('website.amount_claim')}} </strong><span>
                                                    {{$item->invoice_amount - $item->invoice_bills}} {{__('website.sr')}}</span></p>
                                                    <p><strong>
                                                    {{__('website.total_amount')}} </strong><span>

                                                    {{$item->invoice_amount}}

                                                    {{__('website.sr')}}</span></p>
                                                </div>
                                                <div class="col-lg-12 secDataProject">
                                                    <p><strong>{{__('website.descriptipn')}}</strong>
                                                    <span>...</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="paymentInvoices">
                        <div class="col-lg-12 col-xl-12 col-md-12 d-flex">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover tableWithSearch" id="tableWithSearch">
                                        <thead>
                                            <tr>
                                                <th class="wd-5p no-sort">
                                                    <div class="checkbox checkMain text-center">
                                                     #
                                                    </div>
                                                </th>
                                                <th class="wd-10p">{{__('website.billID')}}</th>
                                                <th class="wd-10p">{{__('website.date')}}</th>
                                                <th class="wd-10p">{{__('website.payment_methods')}}</th>
                                                <th class="wd-10p">{{__('website.amount')}}</th>
                                                <th class="wd-10p"></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if(isset($item->bills))
                                            @foreach($item->bills as $one)
                                            <tr>
                                                <td class="v-align-middle wd-5p">
                                                    <div class="checkbox checkMain text-center">
                                                      {{$loop->iteration}}
                                                    </div>
                                                </td>
                                                <td class="v-align-middle wd-10p"><p>{{$one->id}}</p></td>
                                                <td class="v-align-middle wd-10p"><p>
                                                    {{Arr::get(getDates(substr($one->payment_date, 0, 10)), 'hijri_date')}}
                                                    </p></td>
                                                <td class="v-align-middle wd-10p"><span>{{$one->payment_method->name}}</span></td>
                                                <td class="v-align-middle wd-10p"><p> {{$one->amount}}{{__('website.sr')}}</p></td>
                                                <td class="v-align-middle wd-10p optionAddHours">

                                                    <a href="{{url(getLocal(). '/bills/' . $one->id)}}">
                                                    <div class="note-options" data-toggle="tooltip" title="" href="#" data-original-title="{{__('website.details')}}">
                                                                    <i class="material-icons showDitails">visibility</i>
                                                                </div>
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
            </div>
        </div>
    </div>

<input type="checkbox" class="checkboxes chkBox" value="{{$item->id}}" id="chkBox{{$item->id}}" name="chkBox" checked style="display:none;" />


<!--   modalSlideLeft-->
<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle text-center">
                            <p>
                                {{__('website.are_you_sure_to_delete_this_invoices')}}
                                <span class="block bold viewItems"></span>
                            </p>
                            <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                            <button type="button" class="btn btn-danger btn-block confirmAll deleteInvoiceFromDetPage" data-dismiss="modal" data-action="delete">
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
