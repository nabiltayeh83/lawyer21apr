<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="{{url('assets/ico/60.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('assets/ico/76.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('assets/ico/120.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('assets/ico/152.png')}}">
    <link rel="icon" type="image/x-icon" href="{{url('assets/ico/favicon.ico')}}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />


    <!-- main  -->
    <link href="{{url('assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{url('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- icons -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <!-- custom css  -->
	<link href="{{url('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{url('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{url('assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{url('assets/css/calendar.css')}}" rel="stylesheet">

    <!-- style-->
    <link class="main-stylesheet" href="{{url('pages/css/pages.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{url('pages/css/main.css')}}" rel="stylesheet" type="text/css" />

  </head>
  <body class="fixed-header horizontal-menu horizontal-app-menu">

    <!-- START PAGE-CONTAINER -->

    <div class="page-top-fixed">
		<div class="container-fluid">
    		<div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
				<h2 class="page-header mb-1 my-md-3"> {{__('website.project_receivables_invoice')}} {{$item->project->name}} </h2>
				<div class="page-options-btns">
					<div class="btn-group mb-2 m-md-3 mt-md-0 ml-2 ">

						<a href="{{url('sendInvoiceToClient/' . $item->id)}}">
        					<button type="button" class="btn btn-default  has-icon">
        						<i class="material-icons">send</i>
        						<span>{{__('website.send')}}</span>
        					</button>
						</a>

                        <a href="{{url('invoiceExportPDF/' . $item->id)}}">
                            <button type="button" class="btn btn-default has-icon">
                                <i class="material-icons">cloud_download</i>
                                <span>{{__('website.download')}}</span>
                            </button>
                        </a>
						<!--<button type="button" class="btn btn-default  has-icon " data-target="#modalSlideLeft" data-toggle="modal">-->
						<!--	<i class="material-icons">close</i>-->
						<!--	<span>{{__('website.delete')}}</span>-->
						<!--</button>-->
					</div>
				</div>
			</div>
		</div>
    </div>

    <div class="page-container ">
        <div class="page-content-wrapper ">
            <div class="content ">
            <div class=" container-fluid ">
              <div class="row no-gutters dashboard-no-gutters mt-4">
               <div class="card card-default m-t-20">
               <div class="card-body">
                <div class="invoice padding-50 sm-padding-10">
                  <div>
                    <div class="pull-left">
                      <img width="150" height="47" alt="" class="invoice-logo" data-src-retina="assets/img/logo.svg" data-src="assets/img/logo.svg" src="assets/img/logo.svg">
                      <address class="m-t-10">
					    {{$item->office_address}}
					  </address>
                    </div>
                    <div class="pull-right sm-m-t-20">
                      <h6 class="bold">{{__('website.project_receivables_invoice')}} {{$item->project->name}}</h6>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <br>
                  <br>
                  <div class="col-12">
                    <div class="row">
                      <div class="col-lg-9 col-sm-height sm-no-padding">
                        <p class="small no-margin"> {{__('website.required_from')}} </p>
                        <h5 class="semi-bold m-t-0">{{$item->client->name}}</h5>
                        <address>
						{{$item->client_address}}
						</address>
                      </div>
                      <div class="col-lg-3 sm-no-padding sm-p-b-20 d-flex align-items-end justify-content-between">
                        <div>
                          <div class="bold all-caps">{{__('website.invoiceID')}}</div>
                          <div class="bold all-caps">{{__('website.tax_number')}} :</div>
                          <div class="bold all-caps">{{__('website.invoice_date')}} :</div>
                          <div class="bold all-caps">{{__('website.claim_date')}} :</div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="text-left">
                          <div class="">{{$item->invoice_number}}</div>
                          <div class="">12525484</div>
                          <div class="">
                            {{Arr::get(getDates(substr($item->release_date, 0, 10)), 'hijri_date')}}
                        </div>
                          <div class="">
                            {{Arr::get(getDates(substr($item->claim_date, 0, 10)), 'hijri_date')}}
                        </div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                    </div>
                  </div>



                  @if(isset($item->invoiceHours) && (in_array(3 ,$item->invoice_outputs) || in_array(1 ,$item->invoice_outputs)))

                   <div class="table-responsive table-invoice">
                    <table class="table m-t-50">
                      <thead class="">
                        <tr>
                          <th class="p-b-10">{{__('website.hours')}}</th>
                          <th class="text-center p-b-10">{{__('website.range')}}</th>
                          <th class="text-center p-b-10">{{__('website.date')}}</th>
                          <th class="text-right p-b-10">{{__('website.amount')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($item->invoiceHours as $one)
                        <tr>
                          <td class="">
                            <p class="text-black"> {{$one->hour->hours_count}} </p>
                          </td>
                          <td class="text-center">{{$one->hour->price}} {{__('website.r_s')}}</td>
                          <td class="text-center">
                            {{Arr::get(getDates(substr($one->hour->start_date, 0, 10)), 'hijri_date')}}
                        </td>
                          <td class="text-right">{{($one->hour->hours_count*$one->hour->price)}} {{__('website.r_s')}}</td>
                        </tr>

              @endforeach
                      </tbody>
                    </table>
                  </div>
                  @endif





                @if(isset($item->invoiceExpenses) && (in_array(4 ,$item->invoice_outputs) || in_array(1 ,$item->invoice_outputs)))
                  <div class="table-responsive table-invoice">
                    <table class="table m-t-50">
                      <thead class="">
                        <tr>
                          <th class="p-b-10">{{__('website.expenses')}}</th>
                          <th class="text-center p-b-10">{{__('website.expense_date')}}</th>
                          <th class="text-center p-b-10">{{__('website.recipient_name')}}</th>
                          <th class="text-right p-b-10">{{__('website.amount')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($item->invoiceExpenses as $one)
                        <tr>
                          <td class=""><p>{{@$one->expense->aspect_expense->name}} </p></td>
                          <td class="text-center">
                            {{Arr::get(getDates(substr($one->expense->expense_date, 0, 10)), 'hijri_date')}}
                        </td>
                          <td class="text-center">{{@$one->expense->employee->name}}</td>
                          <td class="text-right">{{(@$one->expense->total_amount)}} {{__('website.r_s')}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @endif



                  @if(isset($item->invoiceFlatsFees) && (in_array(5 ,$item->invoice_outputs) || in_array(1 ,$item->invoice_outputs)))
                  <div class="table-responsive table-invoice">
                    <table class="table m-t-50">
                      <thead class="">
                        <tr>
                          <th class="p-b-10">{{__('website.flats_fees')}}</th>
                          <th class="text-center p-b-10">{{__('website.date')}}</th>
                          <th class="text-center p-b-10">{{__('website.amount')}}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($item->invoiceFlatsFees as $one)
                        <tr>
                          <td class=""><p>{{@$one->flatFee->description	}} </p></td>
                          <td class="text-center">
                            {{Arr::get(getDates(substr($one->flatFee->date, 0, 10)), 'hijri_date')}}
                        </td>
                          <td class="text-right">{{(@$one->flatFee->price)}} {{__('website.r_s')}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @endif



                  </div>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <div>
                    <img width="150" height="58" alt="" class="invoice-signature" data-src-retina="{{url('assets/img/signature2x.png')}}"
                    data-src="{{url('assets/img/signature2x.png')}}" src="{{url('assets/img/signature2x.png')}}">
                    <p>{{__('website.signature')}}</p>
                  </div>
                  <br>
                  <br>
                  <div class="p-l-15 p-r-15">
                    <div class="row b-a b-grey">
					  <div class="col-md-4 p-l-15 sm-p-t-15 clearfix sm-p-b-15 d-flex flex-column justify-content-center">
						<h5 class="all-caps small no-margin hint-text bold">{{__('website.total_without_vat')}}</h5>
						<h3 class="no-margin">{{$item->final_total}} {{__('website.sr')}}</h3>
					  </div>


					  <div class="col-md-3 clearfix sm-p-b-15 d-flex flex-column justify-content-center">
						<h5 class="all-caps small no-margin hint-text bold">{{__('website.vat')}}</h5>
						@if(isset($item->vat))
						<h3 class="no-margin">({{$item->vat}}%)</h3>
					    @else
					    {{__('website.not_found')}}
					    @endif
					  </div>


					  <div class="col-md-5 text-right bg-master-darker col-sm-height padding-15 d-flex flex-column justify-content-center align-items-end">
						<h5 class="all-caps small no-margin hint-text text-white bold">{{__('website.total_with_vat')}}</h5>
						<h1 class="no-margin text-white">
						    {{ $item->invoice_amount }}
						     {{__('website.sr')}}</h1>
					  </div>
					</div>
                  </div>
                  <hr>
                  <p class="small hint-text">{{__('website.invoice_entitlement')}}</p>
                  <br>
                  <hr>
                  <div>
                    <img src="{{url('assets/img/logo.svg')}}" alt="logo" data-src="{{url('assets/img/logo.svg')}}" data-src-retina="{{url('assets/img/logo.svg')}}" width="78" height="34">
                    <span class="m-r-40 text-black sm-pull-right">+34 346 4546 445</span>
                    <span class="m-r-40 text-black sm-pull-right">support@hexacit.com</span>
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

    <!-- END PAGE CONTAINER -->

    <!-- START OVERLAY -->



	<script src="{{url('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/popper/umd/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery/jquery-easy.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-actual/jquery.actual.min.js')}}"></script>
    <script src="{{url('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="{{url('pages/js/pages.min.js')}}" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{url('assets/js/scripts.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
  </body>
</html>
