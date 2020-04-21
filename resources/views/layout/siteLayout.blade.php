<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="assets/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/ico/120.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="152x152" href="assets/ico/152.png">
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
    <link href="{{url('assets/plugins/font-awesome/css/font-awesome.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{url('assets/plugins/summernote/css/summernote.css')}}" rel="stylesheet" type="text/css" media="screen" />

    <!-- custom css  -->
	<link href="{{url('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{url('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{url('assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{url('assets/css/calendar.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <link href="{{url('assets/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" />


    <!-- datatable -->
    <link href="{{url('assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{url('assets/plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen" />

    <!-- style-->
    <link class="main-stylesheet" href="{{url('pages/css/pages.css')}}" rel="stylesheet" type="text/css" />
	<link class="main-stylesheet" href="{{url('pages/css/main.css')}}" rel="stylesheet" type="text/css" />

    <!--<link href="{{url('assets/plugins/fullcalendar/fullcalendar.min.css')}}" rel="stylesheet">-->
    <!--<link rel="stylesheet" href="{{url('assets/css/calendar.css')}}">-->
    
    
    <link href="{{url('assets/plugins/fullcalendar/core/main.css')}}" rel='stylesheet' />
    <link href="{{url('assets/plugins/fullcalendar/daygrid/main.css')}}" rel='stylesheet' />
    
   

    @if(app()->getLocale()=='en')
        <link href="{{url('pages/css/ltr.css')}}" rel="stylesheet">
    @endif
    <script src="{{url('assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/fullcalendar/core/main.js')}}"></script>
    <script src="{{url('assets/plugins/fullcalendar/core/interaction.js')}}"></script>
    <script src="{{url('assets/plugins/fullcalendar/daygrid/main.js')}}"></script>
    <script src="{{url('assets/plugins/fullcalendar/core/locales-all.js')}}"></script>
    @yield('calenderJS')

    
  </head>

  <body class="fixed-header horizontal-menu horizontal-app-menu">

        
        <!-- Header Nav -->
        <div class="header p-r-0 bg-complete">
            <div class="container-fluid">
                <div class="header-inner header-lg-height">
        		    <a class="btn-link toggle-sidebar d-xl-none pg pg-menu text-white" data-toggle="horizontal-menu" href="#">
        			    <i class="material-icons">menu</i>
        			</a>
        			<div class="d-flex flex-grow-1 align-items-lg-center  mr-3">
        			    <div class="brand inline no-border d-sm-inline-block">
                            <a href="{{url('/')}}">
                                <img alt="logo" src="{{@$setting->logo_white}}" width="24">
                            </a>
                        </div>
        
                        <div class="menu-bar border-0 header-lg-height">
        				    <a href="#" class="btn-link toggle-sidebar d-xl-none pg pg-close" data-toggle="horizontal-menu">
        				        <i class="material-icons">close</i>
        					</a>
        					<ul>
        					    <li>
        						    <button aria-expanded="false" aria-haspopup="true" class="add-dropdown-toggle d-flex align-items-center w-100 " data-toggle="dropdown" type="button">
        					            <i class="material-icons">add_circle_outline</i>
        							    <span class="bold mx-2">{{__('website.add')}}</span>
                                    </button>
        
        						    <div class="dropdown-menu dropdown-menu-right add-dropdown no-divider" role="menu">
        
        						        @if(user_role(1))
        							    <a href="{{url(app()->getLocale().'/clients/create')}}" class="dropdown-item">{{__('website.client')}}</a>
        								@endif
        
        								@if(user_role(2))
        								<a href="{{url(app()->getLocale().'/projects/create')}}" class="dropdown-item">{{__('website.project')}}</a>
        								@endif
        
        								@if(user_role(3))
        								<a href="" class="dropdown-item calendar-add" data-target="#modalAddTask" data-toggle="modal">{{__('website.task')}}</a>
        								@endif
        
        								@if(user_role(4))
        								<a href="" class="dropdown-item calendar-add" data-target="#modalAddHours" data-toggle="modal">{{__('website.hours')}}</a>
        								@endif
        
        								@if(user_role(6))
        								<a href="" class="dropdown-item calendar-add" data-target="#AddInvoices" data-toggle="modal">{{__('website.invoice')}}</a>
        								@endif
        
        								@if(user_role(8))
        								<a href="" class="dropdown-item calendar-add" data-target="#AddReports" data-toggle="modal">{{__('website.report')}}</a>
        								@endif
        
        								@if(user_role(5))
        								<a href="" class="dropdown-item calendar-add" data-target="#modalAddDocument" data-toggle="modal">{{__('website.document')}}</a>
        								@endif
        
        								@if(user_role(7))
        								<a href="" class="dropdown-item" data-target="#addExpense" data-toggle="modal">{{__('website.expense')}}</a>
        								@endif
                                    </div>
        						</li>
        						<li class="@if(Request::is('/')) active @endif"> <a href="{{route('HomePage')}}">{{__('website.home')}}</a></li>
        
        
        						@if(user_role(1))
        						<li class="@if(Request::segment(2) == 'clients') active @endif"> <a href="{{url(app()->getLocale().'/clients')}}">{{__('website.clients')}}</a> </li>
        						@endif
        
        						@if(user_role(2))
        						<li class="@if(Request::segment(2) == 'projects') active @endif"> <a href="{{url(app()->getLocale().'/projects')}}">{{__('website.projects')}}</a> </li>
        						@endif
        
        						@if(user_role(3))
        						<li class="@if(Request::segment(2) == 'tasks') active @endif"> <a href="{{url(app()->getLocale().'/tasks')}}">{{__('website.tasks_managment')}}</a></li>
        						@endif
        
        						@if(user_role(4))
        						<li class="@if(Request::segment(2) == 'hours') active @endif"> <a href="{{url(app()->getLocale().'/hours')}}">{{__('website.hours')}}</a></li>
        						@endif
        
        						@if(user_role(5))
        						<li class="@if(Request::segment(2) == 'documents') active @endif"> <a href="{{url(app()->getLocale().'/documents')}}">{{__('website.documents')}}</a> </li>
        						@endif
        
        						@if(user_role(6))
        						<li class="@if(Request::segment(2) == 'invoices') active @endif"> <a href="{{url(app()->getLocale().'/invoices')}}">{{__('website.invoices')}}</a> </li>
        						@endif
        
        						@if(user_role(7))
        						<li class="@if(Request::segment(2) == 'expenses') active @endif"> <a href="{{url(app()->getLocale().'/expenses')}}">{{__('website.expenses')}}</a> </li>
        						@endif
        
        						@if(user_role(8))
        						<li class="@if(Request::segment(2) == 'reports') active @endif"> <a href="{{url(app()->getLocale().'/reports')}}">{{__('website.reports')}}</a> </li>
        						@endif
        
        						@if(user_role(9))
        						<li class="@if(Request::segment(2) == 'settings') active @endif"> <a href="{{url(app()->getLocale().'/settings')}}">{{__('website.settings')}}</a> </>
        				        @endif
        					</ul>
                        </div>
                    </div>
        
                    <div class="d-flex align-items-center">
        		        <ul class="d-lg-inline-block d-none notification-list no-margin b-grey b-l b-r no-style p-l-20 p-r-20">
        				    <li class="p-r-10 inline">
        				        <div class="dropdown">
        						    <a class="header-icon pg pg-world" data-toggle="dropdown" href="javascript:;" id="notification-center">
        						        <span class="bubble"></span>
        					    	    <i class="material-icons">public</i>
        					    	</a>
        					        <div aria-labelledby="notification-center" class="dropdown-menu notification-toggle" role="menu">
        					            <div class="notification-panel">
        						            <div class="notification-body scrollable">
        							            <div class="notification-item clearfix">
        								            <div class="heading">
        									            <a class="notification-title text-danger" href="#">
        										            <span class="notification-icon">
        											            <i class="fa fa-exclamation-triangle m-r-10"></i>
        										            </span>
        										            <span class="bold"> قضية حرث إرث   قضية حرث إرث   قضية حرث إرث   قضية حرث إرث
        											            <span class="fs-12 notification-progress">71% إكتمال العمل على القضية</span>
        										            </span>
        									            </a>
        									            <span class="time"> منذ 2 دقيقة </span>
        								            </div>
        								            <div class="option">
        									            <a class="mark" href="#"></a>
        								            </div>
        							            </div>
        							            <div class="notification-item clearfix">
        								            <div class="heading">
        									            <a class="notification-title text-warning-dark " href="#">
        										            <span class="notification-icon">
        										                <i class="fa fa-exclamation-triangle m-r-10"></i>
        										            </span>
        										            <span class="bold"> قضية حرث إرث   قضية حرث إرث   قضية حرث إرث   قضية حرث إرث
        											            <span class="fs-12 notification-progress">71% إكتمال العمل على القضية</span>
        										            </span>
        									            </a>
        									            <span class="time">  11:00pm  </span>
        								            </div>
        								            <div class="option">
        									            <a class="mark" href="#"></a>
        								            </div>
        							            </div>
        							            <div class="notification-item unread clearfix">
        								            <div class="heading">
        									            <a class="notification-title text-complete " href="#">
        										            <span class="notification-icon">
        										                <div class="thumbnail-wrapper d24 circular b-white m-r-5 b-a b-white  m-r-10">
        										                    <img alt="" data-src="assets/img/profiles/1.jpg" data-src-retina="assets/img/profiles/1x.jpg" height="30" src="assets/img/profiles/1.jpg" width="30">
        										                </div>
        										            </span>
        										            <span class="bold"> قضية حرث إرث   قضية حرث إرث   قضية حرث إرث   قضية حرث إرث
        							                            <span class="fs-12 notification-progress">
        													        71% إكتمال العمل على القضية
        											            </span>
        										            </span>
        									            </a>
        									            <span class="time">  11:00pm  </span>
        									        </div>
        								            <div class="option" data-placement="left" data-toggle="tooltip" title="مقروءة">
        							                    <a class="mark" href="#"></a>
        							                </div>
        							            </div>
        						            </div>
        
        						            <div class="notification-footer text-center">
        						                <a class="" href="#">
        						                    {{__('website.all_notifications')}}
        						                </a>
        						                <a class="portlet-refresh text-black pull-right" data-toggle="refresh" href="#">
        						                    <i class="pg-refresh_new"></i>
        						                </a>
        						            </div><!-- START Notification Footer-->
        				                </div><!-- END Notification -->
        					        </div><!-- END Notification Dropdown -->
        				        </div>
        				    </li>
        				    <li class="p-r-10 inline">
                                <a class="search-link d-lg-inline-block d-none" href="{{url(app()->getLocale().'/events')}}">
        			  		        <i class="material-icons">calendar_today</i>
        			  		    </a>
        				    </li>
        				    <li class="p-r-10 inline">
        					    <a class="search-link d-lg-inline-block d-none" data-toggle="search" href="#">
        			  			    <i class="material-icons">search</i>
        			  		    </a>
        				    </li>
        			    </ul>
        			    <div class="dropdown pull-right">
        				    <button aria-expanded="false" aria-haspopup="true" class="profile-dropdown-toggle  border-0 d-flex align-items-center text-white" data-toggle="dropdown" type="button">
        				        <span class="bold mx-2">{{Auth::user()->name}}</span>
        				        <span class="thumbnail-wrapper d32 circular inline sm-m-r-5">
                                    <img alt="" data-src="{{Auth::user()->image}}" data-src-retina="{{Auth::user()->image}}" height="32" src="{{Auth::user()->image}}" width="32">
        					    </span>
        				    </button>
        
        				    <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
        				        <a href="{{url('profile')}}" class="dropdown-item">
        					        <i class="material-icons"> account_circle </i>
        					        <span>{{__('website.profile')}}</span>
        				        </a>
        
        				        <a href="{{url(app()->getLocale().'/help')}}" class="dropdown-item">
        					        <i class="material-icons">help</i><span>{{__('website.help')}}</span>
        				        </a>
        
                                <a href="{{ route('userlogout') }}" class="clearfix bg-master-lighter dropdown-item">
        					        <i class="material-icons">power_settings_new</i>
        					        <span>{{__('website.logout')}}</span>
        				        </a>
        				    </div>
        			    </div>
        			</div>
        	    </div>
            </div>
        </div>
<!-- End Header Nav -->


    @yield('topfixed')
    <div class="page-container">
        <div class="page-content-wrapper">
            @yield('content')
            <div class="container-fluid footer">
            <div class="copyright sm-text-center">
                <p class=" fs-12 no-margin float-md-right sm-pull-reset">
                    {{__('website.copy_rights')}}
                    <span class="">Innosoft  © 2019</span>.
                </p>
        
                <div class="float-md-left">
                    <a href="#" class="m-l-10 m-r-10 fs-12">{{__('website.terms_and_conditions')}}</a>
                    <span class="muted">|</span>
                    <a href="#" class="m-r-10 fs-12">{{__('website.privacy_policy')}}</a>
                </div>
        
                <div class="clearfix"></div>
            </div>
        </div>
    <!-- END COPYRIGHT -->
        </div>
    <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    

<!-- START OVERLAY -->
    <div class="overlay hide" data-pages="search">
        <div class="overlay-content has-results m-t-20">
            <div class="container-fluid py-5">
                <a href="#" class="close-icon-light overlay-close text-black ">
                    <i class="material-icons pg-close"> close</i>
                </a>
            </div>
            <div class="container-fluid">
                <form method="post" action="javascript:void(0)" id="formSearchResults">
                <input id="overlay-search" class="no-border overlay-search bg-transparent" placeholder="{{__('website.search')}} ... " autocomplete="off" spellcheck="false">
                </form>
                <div class="inline-block mt-2">
                    <p class="fs-13"> {{__('website.for_search_press_enter')}} </p>
                </div>
            </div>
    
            <div class="container-fluid">
                <span id="overlay-suggestions"></span><br>
    
                     <div class="col-md-6 clientResults">
                        @include('website.extraBlade.search.clientResults')
                    </div>
    
                    <div class="col-md-6 projectResults">
                        @include('website.extraBlade.search.projectResults')
                    </div>
    
                    <div class="col-md-6 taskResults">
                        @include('website.extraBlade.search.taskResults')
                    </div>
    
                    <div class="col-md-6 invoiceResults">
                        @include('website.extraBlade.search.invoiceResults')
                    </div>
    
                     <div class="col-md-6 expenseResults">
                        @include('website.extraBlade.search.expenseResults')
                    </div>
    
                    <div class="col-md-6 reportResults">
                        @include('website.extraBlade.search.reportResults')
                    </div>
    
    
    
                <div class="search-results m-t-40">
                    <p class="bold"> {{__('website.search_results')}}</p>
                        <div class="row searchResultsPlace">
    
    
    
    
                        </div>
                    </div>
                </div>
            </div>
        </div>




    <div class="modal fade slide-right" id="addFlatsFees" tabindex="-1" role="dialog" aria-hidden="true">
        	<div class="modal-dialog modal-lg">
        		<div class="modal-content-wrapper">
        			<div class="modal-content">
        				<div class="modal-header mb-3">
        					<h6> {{__('website.add_flat_fee')}} </h6>
        				</div>
        				<div class="container-xs-height full-height">
        				    <div class="row-xs-height">
        				        <div class="modal-body col-xs-height">
                                    <form method="post" action="javascript:void(0)" id="formCreateFlatsFees">
                                    {{csrf_field()}}
        
                                    @if(Request::segment(2) == 'projects' && Request::segment(3) != null)
                                      <input type="hidden" name="project_id" value="{{Request::segment(3)}}">
                                    @endif
        
                                    <div class="form-group form-group-default form-group-default-select2 selectProject">
                                        <label> {{__('website.select_project_name')}} </label>
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
        
                                    <div class="form-group form-group-default">
                                        <label> {{__('website.amount')}} </label>
                                        <input type="text" name="price" class="form-control" value="{{old('price')}}" required>
                                    </div>
        
                                    <div class="form-group form-group-default">
                                      <label> {{__('website.date')}} </label>
                                      <input type="text" name="date" class="form-control hijri-date-input">
                                    </div>
        
                                    <div class="form-group form-group-default">
                                        <label> {{__('website.details')}} </label>
                                        <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                                    </div>
        
                                    <button type="submit" class="btn btn-complete btn-block" id="newFlatsFees"> {{__('website.save')}} </button>
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
        							</form>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>

    <div class="modal fade slide-right" id="modalAddField" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content-wrapper">
                <div class="modal-content">
        
        
                <div class="modal-header mb-3">
                    <h6>{{__('website.add_new_field')}}</h6> </div>
                <!-- modal-header -->
        
        
                  <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                      <div class="modal-body col-xs-height  ">
        
        
                        <form method="post" action="javascript:void(0)" id="formCreateExtraFileds">
                            {{csrf_field()}}
        
                               <div class="form-group form-group-default required">
                                    <label>{{__('website.field_name')}}</label>
                                    <input type="text" class="form-control" required name="name" id="name">
                                </div>
                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label>{{__('website.field_type')}}</label>
                                     <select class="full-width" data-init-plugin="select2" required name="type" id="type">
                                        <optgroup label="{{__('website.choose_field_type')}}">
                                        <option value="input">Input</option>
                                        <option value="checkbox">CheckBox</option>
                                        <option value="textarea">Textarea</option>
                                        </optgroup>
                                     </select>
                                </div>
        
        
                                <div class="form-group secOptionField">
                                    <p>{{__('website.required_field')}}</p>
                                    <div class="toggle-button-cover">
                                      <div class="button-cover">
                                        <div class="button r" id="button-1">
        
                                          <input type="checkbox" class="checkbox" name="required" id="required">
        
                                          <div class="knobs"></div>
                                          <div class="layer"></div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
        
        
                                <div class="form-group secOptionField">
                                    <p>{{__('website.applied_to_all_projects')}}</p>
                                    <div class="toggle-button-cover">
                                      <div class="button-cover">
                                        <div class="button r" id="button-1">
                                          <input type="checkbox" class="checkbox" name="apply_to" id="apply_to">
                                          <div class="knobs"></div>
                                          <div class="layer"></div>
                                        </div>
                                      </div>
                                    </div>
                                </div>
        
                                <button type="submit" class="btn btn-complete btn-block" id="createExtraFields"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
        
        
                            </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
    <div class="modal fade slide-right" id="addExpense" tabindex="-1" role="dialog" aria-hidden="true">
        	<div class="modal-dialog modal-lg">
        		<div class="modal-content-wrapper">
        			<div class="modal-content">
        				<div class="modal-header mb-3">
        					<h6> {{__('website.add_new_expense')}} </h6>
        				</div>
        				<div class="container-xs-height full-height">
        				    <div class="row-xs-height">
        					    <div class="modal-body col-xs-height">
                                    <form method="post" action="javascript:void(0)" id="formCreateExpense">
                                    {{csrf_field()}}
        
                                    @if(Request::segment(2) == 'projects' && Request::segment(3) != null)
                                      <input type="hidden" name="project_id" value="{{Request::segment(3)}}">
                                    @endif
        
                                    <div class="form-group form-group-default form-group-default-select2 selectProject">
                                        <label> {{__('website.select_project_name')}} </label>
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
        
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label> {{__('website.expense_aspect')}} </label>
                                        <select class="full-width" data-init-plugin="select2" id="aspect_expense_id" name="aspect_expense_id">
                                            <optgroup label="{{__('website.select_expense_aspect')}}">
                                                <option value=""></option>
                                                @if(isset($aspect_expense))
                                                @foreach($aspect_expense as $one)
                                                    <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                                            </optgroup>
                                        </select>
                                    </div>
        
                                    <div class="form-group form-group-default">
                                        <label> {{__('website.expense_date')}} </label>
                                        <input type="text" name="expense_date" class="form-control hijri-date-input" required>
                                    </div>
        
                                    <div class="form-group form-group-default">
                                        <label> {{__('website.total_amount')}} </label>
                                        <input type="text" class="form-control" id="total_amount" value="{{old('total_amount')}}"  required  name="total_amount">
                                    </div>
        
        
                                    <div class="form-group form-group-default">
                                        <label> {{__('website.descriptipn')}} </label>
                                        <textarea class="form-control" name="expense_details" id="expense_details">{{old('expense_details')}}</textarea>
                                    </div>
        
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label> {{__('website.responsible_emp')}} </label>
                                        <select class="full-width" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                                            <optgroup label="{{__('website.choose_emp_name')}}">
                                                <option value=""></option>
                                                @if(isset(Auth::user()->office_employees))
                                                @foreach(Auth::user()->office_employees as $one)
                                                    <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                                            </optgroup>
                                        </select>
                                    </div>
        
                                    <button type="submit" class="btn btn-complete btn-block" id="newaExpense"> {{__('website.save')}} </button>
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
        						</form>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        </div>
        
    <div class="modal fade slide-right" id="modalAddFolder" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
		    <div class="modal-content-wrapper">
			    <div class="modal-content">
				    <div class="modal-header mb-3">
					    <h6> {{__('website.add_new_folder')}} </h6>
				    </div>
				    <div class="container-xs-height full-height">
				        <div class="row-xs-height">
					        <div class="modal-body col-xs-height">
                                <form method="post" action="javascript:void(0)" id="formCreateFolder">

    							<div class="form-group form-group-default required">
    								<label> {{__('website.folder_title')}} </label>
    								<input type="text" name="title" id="title" class="form-control" required >
    							</div>

    							<div class="form-group form-group-default form-group-default-select2 required">
    								<label>  {{__('website.project')}} </label>
                                    <select class="full-width project" required data-init-plugin="select2" required id="project_id" name="project_id">
                                        <optgroup label="{{__('website.select_project_name')}}">
                                            <option value=""></option>
                                            @if(isset($projects))
                                            @foreach($projects as $one)
                                                <option  value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
    								</select>
    							</div>

    							<div class="form-group form-group-default required">
    								<label>  {{__('website.date')}} </label>
    								<input type="text" class="form-control hijri-date-input" name="folder_date" required id="folder_date">
    							</div>

                                <button type="submit" class="btn btn-complete btn-block" id="newFolder"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
						        </form>
					        </div>
			            </div>
		    	    </div>
		        </div>
            </div>
        </div>
    </div>

    <div class="modal fade slide-right" id="modalAddDocument" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header mb-3">
                        <h6> {{__('website.add_new_document')}} </h6>
                    </div>
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="modal-body col-xs-height">
                                <form method="post" enctype="multipart/form-data" action="javascript:void(0)" id="formCreateDocument">

                                @if(Request::segment(2) == 'documents' && Request::segment(3) != null)
                                <input type="hidden" name="parent_id" value="{{Request::segment(3)}}">

                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label>  {{__('website.folder')}} </label>
                                    <select class="full-width project" required data-init-plugin="select2" @if(Request::segment(2) == 'documents' && Request::segment(3) != null) disabled @endif id="parent_id" name="parent_id">
                                        <optgroup label="{{__('website.select_folder_name')}}">
                                            @if(isset($folders))
                                            @foreach($folders as $one)
                                                <option @if(Request::segment(3) == $one->id) selected @endif value="{{@$one->id}}">{{@$one->title}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>

                                @else

                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label>  {{__('website.folder')}} </label>
                                    <select class="full-width project" required data-init-plugin="select2" required id="parent_id" name="parent_id">
                                        <optgroup label="{{__('website.select_folder_name')}}">
                                            <option value=""></option>
                                            @if(isset($folders))
                                            @foreach($folders as $one)
                                                <option value="{{@$one->id}}">{{@$one->title}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>
                                @endif

                                <div class="form-group form-group-default required">
                                    <label> {{__('website.document_title')}} </label>
                                    <input type="text" name="title" id="title" class="form-control" required >
                                </div>

                                <div class="form-group form-group-default required">
                                    <label>  {{__('website.date')}} </label>
                                    <input type="text" class="form-control hijri-date-input" required name="document_date" id="document_date">
                                </div>

                                <div class="form-group form-group-default uploadFileRequest  required">
                                    <div class="input-file-container">
                                        <label tabindex="0" for="file-upload-1" class="input-file-trigger ">
                                            <i class="fa fa-upload"></i> {{__('website.upload_file')}}
                                            <span> {{__('website.choose_file')}} </span>
                                        </label>
                                        <input type="file" id="file-upload-1" name="files[]" multiple required size="40" >
                                     </div>
                                </div>

                                <button type="submit" class="btn btn-complete btn-block" id="newDocument"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modalActivate -->
    <div class="modal fade slide-right" id="activation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="modal-body col-xs-height col-middle tءذext-center">
                                <p>{{__('website.do_you_want_to_activate_this_item')}}</p>
                                <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                                <button type="button" class="btn btn-danger btn-block confirmAll" data-dismiss="modal" data-action="active">
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

    <!-- modal Not Activate -->
    <div class="modal fade slide-right" id="cancel_activation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="modal-body col-xs-height col-middle tءذext-center">
                                <p>{{__('website.do_you_want_to_notactivate_this_item')}}</p>
                                <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                                <button type="button" class="btn btn-danger btn-block confirmAll" data-dismiss="modal" data-action="not_active">
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

    <div class="modal fade slide-right" id="modalAddHours" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header mb-3">
                        <h6> {{__('website.add_new_hours')}} </h6>
                    </div>
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="modal-body col-xs-height">

                                <form method="post" action="javascript:void(0)" id="formCreateHours">

                                    @if(Request::segment(2) == 'tasks' && is_numeric(Request::segment(3)) != '')
                                    <input type='hidden' name="task_id" value="{{ @$item->id }}">

                                    @elseif(Request::segment(2) == 'projects' && is_numeric(Request::segment(3)) != '')
                                    <input type="hidden" name="project_id" value="{{Request::segment(3)}}">

                                    @else

                                    <div class="form-group form-group-default project_id_div form-group-default-select2 required">
                                        <label>  {{__('website.project')}} </label>
                                        <select class="full-width project" required data-init-plugin="select2" id="project_id"
                                            @if(Request::segment(2) == 'projects' && is_numeric(Request::segment(3)) != '') disabled @endif name="project_id">
                                            <optgroup label="{{__('website.select_project_name')}}">
                                                <option value=""></option>
                                                @if(isset($projects))
                                                @foreach($projects as $one)
                                                    <option @if(Request::segment(2) == 'projects' && Request::segment(3) != null && $one->id == Request::segment(3)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                                            </optgroup>
                                        </select>
                                    </div>



                                    <div class="form-group form-group-default task_id_div form-group-default-select2
                                    @if(Request::segment(2) == 'hours' ||
                                    (Request::segment(2) == 'projects' && Request::segment(3) != null)) hidden @endif ">
                                        <label> {{__('website.task')}} </label>
                                        <select class="full-width task"  name="task_id" id="task_id" data-init-plugin="select2">
                                        </select>
                                    </div>

                                    @endif

                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label> {{__('website.responsible_emp')}} </label>
                                        <select class="full-width responsible_lawyer_hours" data-init-plugin="select2" id="responsible_lawyer" name="responsible_lawyer">
                                            <optgroup label="{{__('website.choose_responsible_emp')}}">
                                                <option value=""></option>
                                                @if(isset(Auth::user()->office_employees))
                                                @foreach(Auth::user()->office_employees as $one)
                                                    <option data-id="{{@$one->hour_price}}"  value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                                            </optgroup>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default required">
                                                <label> {{__('website.hours_count')}} </label>
                                                <input type="number" name="hours_count" class="form-control hours_count" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default required">
                                                <label> {{__('website.range')}} </label>
                                                <input type="number" value="" disabled name="hour_price" class="form-control hour_price">
                                                <input type="hidden" value="" name="price" class="form-control hidden_hour_price">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group form-group-default hoursTotalAmount hidden">
                                        <label> {{__('website.total_amount')}} </label>
                                        <p class="form-control printHoursTotalAmount"></p>
                                    </div>

                                    <div class="form-group form-group-default required">
                                        <label>  {{__('website.date')}} </label>
                                        <input type="text" class="form-control hijri-date-input" id="start_date" name="start_date" required>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label> {{__('website.hours_details')}}</label>
                                        <textarea class="form-control" style="height:70px !important;" name="hour_details" id="hour_details"></textarea>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label> {{__('website.hours_office_details')}} </label>
                                        <textarea class="form-control" name="hour_office_details" style="height:70px !important;" id="hour_office_details"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-complete btn-block" id="newTaskHours"> {{__('website.save')}} </button>
            						<button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade slide-right" id="AddReports" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
	        <div class="modal-content-wrapper">
	            <div class="modal-content">
			        <div class="modal-header mb-3">
				        <h6>{{__('website.add')}} {{__('website.report')}}</h6>
			        </div>
			        <div class="container-xs-height full-height">
			            <div class="row-xs-height">
					        <div class="modal-body col-xs-height">

						        <form method="post" action="javascript:void(0)" id="formCreateReport">
                                {{csrf_field()}}

                                    @if(Request::segment(2) == 'tasks' && is_numeric(Request::segment(3)) != '')
                                    <input type='hidden' name="task_id" value="{{ @$item->id }}">
                                    <input type='hidden' name="project_id" value="{{ @$item->project_id }}">


                                    @elseif(Request::segment(2) == 'projects' && is_numeric(Request::segment(3)) != '')
                                    <input type="hidden" name="project_id" value="{{Request::segment(3)}}">

                                    <div class="form-group form-group-default task_id_div form-group-default-select2">
                                        <label> {{__('website.task')}} </label>
                                        <select class="full-width task" name="task_id" id="task_id" data-init-plugin="select2">
                                              <optgroup label="{{__('website.task')}}">
                                                <option value=""></option>
                                                @if(isset($item->tasks))
                                                @foreach($item->tasks as $one)
                                                    <option @if(Request::segment(2) == 'projects' && Request::segment(3) != null && $one->id == Request::segment(3)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                                            </optgroup>
                                        </select>
                                    </div>

                                    @else

                                    <div class="form-group form-group-default project_id_div form-group-default-select2 required">
                                        <label>  {{__('website.project')}} </label>
                                        <select class="full-width project" required data-init-plugin="select2" id="project_id"
                                            @if(Request::segment(2) == 'projects' && is_numeric(Request::segment(3)) != '') disabled @endif name="project_id">
                                            <optgroup label="{{__('website.select_project_name')}}">
                                                <option value=""></option>
                                                @if(isset($projects))
                                                @foreach($projects as $one)
                                                    <option @if(Request::segment(2) == 'projects' && Request::segment(3) != null && $one->id == Request::segment(3)) selected @endif value="{{@$one->id}}">{{@$one->name}}</option>
                                                @endforeach
                                                @endif
                                            </optgroup>
                                        </select>
                                    </div>

                                    <div class="form-group form-group-default task_id_div form-group-default-select2
                                        @if(Request::segment(2) == 'projects' && Request::segment(3) != null) hidden @endif">
                                        <label> {{__('website.task')}} </label>
                                        <select class="full-width task"  name="task_id" id="task_id" data-init-plugin="select2">
                                        </select>
                                    </div>

                                    @endif


            					    <div class="form-group form-group-default">
            							<label> {{__('website.report_content')}} </label>
            							<textarea class="form-control" name="report_content" id="report_content" placeholder="{{__('website.report_content')}}" required></textarea>
            						</div>

            						<div class="form-group form-group-default">
            							<label> {{__('website.report_office_content')}} </label>
            							<textarea class="form-control" name="report_office_content" id="report_office_content" placeholder="{{__('website.report_office_content')}}" required></textarea>
            						</div>

            						<div class="form-group form-group-default">
            							<label> {{__('website.appendix')}} </label>
            							<textarea class="form-control height80" name="appendix"></textarea>
            						</div>

            						<button type="submit" class="btn btn-complete btn-block" id="createProjectReport"> {{__('website.save')}} </button>
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
            					</form>
					           </div>
				        </div>
			        </div>
		        </div>
	        </div>
        </div>
    </div>

    <div class="modal fade slide-right" id="AddInvoices" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
	        <div class="modal-content-wrapper">
		            <div class="modal-content">
				        <div class="modal-header mb-3">
				            <h6>{{__('website.add')}} {{__('website.invoices')}}</h6>
				        </div>

			            <div class="container-xs-height full-height">
			                <div class="row-xs-height">
				                <div class="modal-body col-xs-height">

			                        <form method="post" action="javascript:void(0)" id="formCreateInvoice">
                                    {{csrf_field()}}

                                        @if(Request::segment(2) == 'projects' && is_numeric(Request::segment(3)) != '')
                                        <input type="hidden" name="project_id" value="{{Request::segment(3)}}">
                                        <input type="hidden" name="client_id" value="{{@$item->client_id}}">

                                        @else
                                        <div class="form-group form-group-default project_id_div form-group-default-select2 required">
                                            <label>  {{__('website.project')}} </label>
                                            <select class="full-width project" required data-init-plugin="select2" id="project_id" name="project_id">
                                                <optgroup label="{{__('website.select_project_name')}}">
                                                    <option value=""></option>
                                                    @if(isset($projects))
                                                    @foreach($projects as $one)
                                                        <option value="{{@$one->id}}">{{@$one->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </optgroup>
                                            </select>
                                        </div>
                                        @endif

                                        @php
                                            $invoices_number = $office_settings->invoices_number .  str_pad(count($invoices)+1, 5, "0", STR_PAD_LEFT);
                                        @endphp

            						    <div class="form-group form-group-default">
            								<label> {{__('website.invoiceID')}} </label>
            								<input type="text" class="form-control" value="{{ @$invoices_number }}" disabled>
            							</div>
            							<div class="form-group form-group-default">
            								<label> {{__('website.release_date')}} </label>
            								<input type="text" name="release_date" class="form-control hijri-date-input" required>
            							</div>
            							<div class="form-group form-group-default">
            								<label> {{__('website.claim_date')}} </label>
            								<input type="text" name="claim_date" class="form-control hijri-date-input" required>
            							</div>
            							<div class="form-group form-group-default">
            								<label> {{__('website.total_amount')}} </label>
            								<input type="text" name="final_total" class="form-control" required>
            							</div>

						                <button type="submit" class="btn btn-complete btn-block" id="createProjectInvoice"> {{__('website.save')}} </button>
                                        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
						            </form>
					            </div>
		                    </div>
	                    </div>
	                </div>
                </div>
            </div>
        </div>

    <!-- modal-->
    <div class="modal fade slide-right" id="modalToDeleteNote" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="modal-body col-xs-height col-middle text-center">
                                <p>{{__('website.are_you_sure_to_delete_this_note')}}
                                <span class="block bold viewItems"></span></p>
                                <h5 class="text-danger m-t-20">{{__('website.are_you_sure')}}</h5><br>
                                <button type="button" class="btn btn-danger btn-block deleteNote" data-dismiss="modal" data-id="0"  data-action="delete">
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

    <div class="modal fade slide-right" id="modalToEditNote" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
		    <div class="modal-content-wrapper">
			    <div class="modal-content">
				    <div class="modal-header mb-3">
                        <h6>{{__('website.edit')}} {{__('website.note')}}</h6>
				    </div>
				    <div class="container-xs-height full-height">
				        <div class="row-xs-height">
				            <div class="modal-body col-xs-height">
                                <form method="post" action="javascript:void(0)" id="formUpdateNote">

        							<div class="form-group form-group-default required">
        								<label>{{__('website.write_note')}}</label>
        								<input type="text" class="form-control note" id="note" name="note" required>
        							</div>

        							<div class="form-group form-group-default required">
        								<label>{{__('website.date')}}</label>
        								<input type="text" class="input-sm form-control hijri-date-input" required id="note_date" name="note_date"  autocomplete="off" />
        							</div>

        						    <button type="submit" class="btn btn-complete btn-block" data-id="0" id="updateNote">{{__('website.save')}}</button>
                                    <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                                </form>
				            </div>
				        </div>
			        </div>
			    </div>
		    </div>
	    </div>
	</div>

    <div class="modal fade slide-right" id="modalToEditFolder" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
		    <div class="modal-content-wrapper">
			    <div class="modal-content">
				    <div class="modal-header mb-3">
					    <h6> {{__('website.edit')}} {{__('website.folder')}} </h6>
				    </div>
				    <div class="container-xs-height full-height">
				        <div class="row-xs-height">
					        <div class="modal-body col-xs-height">
                                <form method="post" action="javascript:void(0)" id="formUpdateFolder">

    							<div class="form-group form-group-default required">
    								<label> {{__('website.folder_title')}} </label>
    								<input type="text" name="title" id="title" class="form-control title" required >
    							</div>

    							<div class="form-group form-group-default form-group-default-select2 required">
    								<label>  {{__('website.project')}} </label>
                                    <select class="full-width project" required data-init-plugin="select2" id="project_id" name="project_id">
                                        <optgroup label="{{__('website.select_project_name')}}">
                                            <option value=""></option>
                                            @if(isset($projects))
                                            @foreach($projects as $one)
                                                <option  value="{{@$one->id}}">{{@$one->name}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
    								</select>
    							</div>

    							<div class="form-group form-group-default">
    								<label>  {{__('website.date')}} </label>
    								<input type="text" class="form-control hijri-date-input" name="folder_date" id="folder_date">
    							</div>

                                <button type="submit" class="btn btn-complete btn-block" data-id="0" id="UpdateFolder"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
						        </form>
					        </div>
			            </div>
		    	    </div>
		        </div>
            </div>
        </div>
    </div>

    <div class="modal fade slide-right" id="modalAddTask" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
		    <div class="modal-content-wrapper">
			    <div class="modal-content">
				    <div class="modal-header mb-3">
					    <h6>{{__('website.add_new_task')}}</h6>
				    </div>
				    <div class="container-xs-height full-height">
				        <div class="row-xs-height">
					        <div class="modal-body col-xs-height">

                                <form action="{{url(app()->getLocale() . '/tasks')}}" method="post" id="newTaskForm" autocomplete="off" enctype="multipart/form-data">
                                {{csrf_field()}}


                                    <div class="form-group form-group-default required">
                    				    <label> {{__('website.task_name')}} </label>
                    				    <input type="text" class="form-control" name="name" id="name" required>
                    			    </div>

                                    <div class="form-group d-flex align-items-center">
                                        <label for="fname" class="col-md-3 control-label">{{__('website.task_category')}}</label>
                                        <div class="col-md-9">
                                            <div class="radio radio-success">
                                                <input type="radio" value="project" name="task_category" required id="projectCategory3">
                                                <label for="projectCategory3">{{__('website.project')}}</label>
                                                <input type="radio" checked value="other" name="task_category" required id="otherCategory3">
                                                <label for="otherCategory3">{{__('website.other')}}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group form-group-default hidden form-group-default-select2 required selectProject">
                        				<label> {{__('website.project')}} </label>
                                        <select class="full-width" data-init-plugin="select2" id="project_id" name="project_id">
                        				    <optgroup label="{{__('website.select_project_name')}}">
                        					    <option value=""></option>
                        					    @if(isset($projects))
                        					    @foreach($projects as $one)
                        						    <option value="{{@$one->id}}">{{@$one->name}}</option>
                        					    @endforeach
                        					    @endif
                        				    </optgroup>
                        			    </select>
                                    </div>


        							<div class="form-group form-group-default form-group-default-select2 required">
        						        <label>{{__('website.task_type')}}</label>
                                        <select class="full-width" data-init-plugin="select2" id="task_type_id" required name="task_type_id">
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

                        	        <div class="form-group form-group-default">
								        <label>{{__('website.task_details')}}</label>
                                        <textarea class="form-control" name="details" id="details"></textarea>
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
        									    <div class="form-group form-group-default form-group-default-select2 required">
        										    <label> {{__('website.task_status')}} </label>
                                                    <select class="full-width" data-init-plugin="select2" id="task_status_id" required name="task_status_id">
                                                        <optgroup label="{{__('website.select_task_status')}}">
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

                                <button type="submit" class="btn btn-complete btn-block" id="addNewTask"> {{__('website.save')}} </button>
						        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
						        </form>
					        </div>
				        </div>
			        </div>
			    </div>
		    </div>
	    </div>
    </div>

    <div class="modal fade slide-right" id="modalToEditDocument" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header mb-3">
                        <h6> {{__('website.edit')}}  {{__('website.document')}} </h6>
                    </div>
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="modal-body col-xs-height">
                                <form method="post" action="javascript:void(0)" id="formToEditDocument">

                                <div class="form-group form-group-default form-group-default-select2 required">
                                    <label>  {{__('website.folder')}} </label>
                                    <select class="full-width  parentid" required data-init-plugin="select2" id="parent_id" name="parent_id">
                                        <optgroup label="{{__('website.select_folder_name')}}">
                                            <option value=""></option>
                                            @if(isset($folders))
                                            @foreach($folders as $one)
                                                <option value="{{@$one->id}}">{{@$one->title}}</option>
                                            @endforeach
                                            @endif
                                        </optgroup>
                                    </select>
                                </div>


                                <div class="form-group form-group-default required">
                                    <label> {{__('website.document_title')}} </label>
                                    <input type="text" name="title" id="title" class="form-control title" required >
                                </div>

                                <div class="form-group form-group-default">
                                    <label>  {{__('website.date')}} </label>
                                    <input type="text" class="form-control hijri-date-input document_date" name="document_date" id="document_date">
                                </div>

                                <button type="submit" class="btn btn-complete btn-block" data-id="0" id="UpdateDocument"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade slide-right" id="modalAddAttach" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header mb-3">
                        <h6>{{__('cp.add_new_attach')}}</h6>
                    </div>
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="modal-body col-xs-height">
                                <form method="post" action="javascript:void(0)" id="formCreateAttach">
                                {{csrf_field()}}

                                @if(isset($item->id))
                                    <input type="hidden" name="segment_id" value="{{$item->id}}">
                                @endif

                                <input type="hidden" name="segment" value="{{Request::segment(2)}}">

                                <div class="form-group form-group-default required">
                                    <label> {{__('cp.file_title')}} </label>
                                    <input type="text" name="attachment_name" id="attachment_name" class="form-control" required>
                                </div>

                                <div class="form-group form-group-default uploadFileRequest" style="margin-bottom:20px!important">
                                    <div class="input-file-container"  style="height:40px">
                                        <label tabindex="0" for="attachfile" class="input-file-trigger"><i class="fa fa-upload"></i> {{__('cp.upload_file')}}
                                            <span>  {{__('cp.choose_file')}} </span>
                                        </label>
                                        <input type="file" id="attachfile" name="attachfile" required size="40">
                                     </div>
                                </div>

                                <button type="submit" class="btn btn-complete btn-block" id="createAttachFile"> {{__('website.save')}} </button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade slide-right" id="modalAddNote" tabindex="-1" role="dialog" aria-hidden="true">
	    <div class="modal-dialog modal-lg">
		    <div class="modal-content-wrapper">
			    <div class="modal-content">
				    <div class="modal-header mb-3">
					    <h6>{{__('website.add_new_note')}}</h6>
				    </div>
				    <div class="container-xs-height full-height">
				        <div class="row-xs-height">
				            <div class="modal-body col-xs-height">
                                <form method="post" action="javascript:void(0)" id="formCreateNote">
                                {{csrf_field()}}

                                @if(isset($item->id))
                                    <input type="hidden" name="segment_id" value="{{@$item->id}}">
                                @endif

                                <input type="hidden" name="segment" value="{{Request::segment(2)}}">

                                <div class="form-group form-group-default required">
                                    <label>{{__('website.write_note')}}</label>
                                    <input type="text" class="form-control" id="note" name="note" required>
                                </div>
                                <div class="form-group form-group-default required">
                                    <label>{{__('website.date')}}</label>
                                    <input type="text" class="input-sm form-control hijri-date-input" required name="note_date" autocomplete="off" />
                                </div>
                                <button type="submit" class="btn btn-complete btn-block" id="addNewNote">{{__('website.save')}}</button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                                </form>
				            </div>
				        </div>
			        </div>
			    </div>
		    </div>
	    </div>
    </div>


	<script src="{{url('assets/plugins/summernote/js/summernote.min.js')}}"></script>
	<script src="{{url('assets/plugins/summernote/js/summernote.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/pace/pace.min.js')}}" type="text/javascript"></script>
    <!--<script src="{{url('assets/plugins/jquery/jquery-3.2.1.min.js')}}" type="text/javascript"></script>-->
    <script src="{{url('assets/plugins/modernizr.custom.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/popper/umd/popper.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery/jquery-easy.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-unveil/jquery.unveil.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-ios-list/jquery.ioslist.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-actual/jquery.actual.min.js')}}"></script>
    <script src="{{url('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/plugins/select2/js/select2.full.min.js')}}"></script>

    <!-- datatabel -->
    <script src="{{url('assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{url('assets/plugins/datatables-responsive/js/datatables.responsive.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/plugins/datatables-responsive/js/lodash.min.js')}}"></script>

    <!--<script src="{{url('assets/plugins/moment-new/min/moment.min.js')}}"></script>-->


    <script src="{{url('pages/js/pages.min.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/datatables.js')}}" type="text/javascript"></script>
    <script src="{{url('assets/js/scripts.js')}}" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script src="{{url('assets/js/bootstrap-hijri-datepicker.min.js')}}"></script>
    <!--<script src="{{url('assets/plugins/fullcalendar/fullcalendar.min.js')}}"></script>-->
    <!--<script src="{{url('assets/plugins/fullcalendar/locale/ar.js')}}"></script>-->
    
    @yield('js')


    <script type="text/javascript">

        $(function () {

            $(".hijri-date-input").hijriDatePicker();


        });

    </script>

<script>
    $(document).ready(function(){
    
    
    /////////////////////// Hour Price ////////////////////
        $(document).on('keyup',['.hour_price','.hours_count','.responsible_lawyer_hours'],function(e){
                var hours_count, hour_price;
                hours_count = $('.hours_count').val();
                hour_price = $('.hour_price').val();
        
                    $('.hoursTotalAmount').removeClass("hidden");
                    $('.printHoursTotalAmount').html(hours_count*hour_price);
        });
        
        /////////////////////// End Hour Price ////////////////////
        
        $(document).on('change','.responsible_lawyer_hours',function(e){
          $('.hour_price').val($('option:selected',this).data("id"));
          $('.hidden_hour_price').val($('option:selected',this).data("id"));
          $('.hours_count').keyup();
        });
        
        $(document).on('submit','#newTaskForm',function(){
            $('#addNewTask').attr('disabled', 'true');
        });
        
        
        /////////////////////// View Tasks ////////////////////
        $(document).on('change','.taskDate',function(){
            var taskDate = $(this).val();
            var taskNewDate = taskDate.replace("/", "-");
            taskNewDate = taskNewDate.replace("/", "-");
        
            var url = "{{ url(app()->getLocale().'/getTasksSame/') }}";
        
              if(taskNewDate){
                $.ajax({
                  type: "GET",
                  url: url+'/'+taskNewDate,
                  success: function (response) {
                      if(response)
                      {
                        $('.viewTasks').removeClass('hide');
                        $(".tasksSameDay").empty();
                        $(".tasksSameDay").append('<optgroup label="{{__('website.tasks')}}">');
                        $.each(response, function(index, value){
                          $(".tasksSameDay").append('<option value="'+value.id+'">'+ value.name +'</option>');
                          $(".tasksSameDay").append('</optgroup>');
                        });
                      }
                  }
                });
              }
              else{
                $(".tasksSameDay").empty();
              }
        });
        
        $(document).on('submit','#formSearchResults',function(){
            var text = $('#overlay-search').val();
        
            var url = "{{ url(app()->getLocale().'/searchResults/') }}";
        
              if(text){
                $.ajax({
                  type: "GET",
                  url: url+'/'+text,
                  success: function (response) {
                       if(response.status = 'true')
                      {
                        $.each(response, function(index, value){
                            $('.clientResults').html(response.clientResults);
                            $('.projectResults').html(response.projectResults);
                            $('.taskResults').html(response.taskResults);
                            $('.invoiceResults').html(response.invoiceResults);
                            $('.expenseResults').html(response.expenseResults);
                            $('.reportResults').html(response.reportResults);
        
                        });
                      }
                  }
                });
              }
        
        });
    
    
        $(document).on('click','#DiscountForClick',function(e){
    		  $('#invoiceDiscount').toggle();
    	  	});
    
    	$(document).on('click', '#saveDone', function(){
    		$('#clickToAction').click();
    		});
    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    
        $('input.extrafield-chkBox').click(function(){
            if($(this).prop("checked") == true){
                $(this).attr('name', 'extrafield[]');
                $(this).next().attr('name', 'fieldsids[]');
            }else{
                $(this).attr('name', '');
                $(this).next().attr('name', '');
            }
        });
    
    
    
        // $('input[type="checkbox"]').click(function(){
        //     if($('.extrafield-chkBox').prop("checked") == true){
        //             $(this).attr('name', 'extrafield[]');
        //             $(this).next().attr('name', 'fieldsids[]');
    
        //         }
        //         else{
        //             $(this).attr('name', '');
        //             $(this).next().attr('name', '');
        //         }
        //     });
    
        $(document).on('click','.optionAddHours .clickOption',function(){
    		  $('.optionAddHours .toolTip').toggle();
    	});
    
        $(document).on('click','#checkNotiModal',function(e){
    		  $('#typeNotiModal').toggle();
    	});
    
    
        
        //////////////////////// Add New Event ////////////////////////
        ///////// Add New Note ///////
        $(document).on('click', '#addNewEvent', function(){
              $.ajax({
                url: "{{url(app()->getLocale().'/events/store')}}",
                type: "POST",
                data: $('#formCalendar').serialize(),
                success: function (response) {
        
                  $('#formCalendar').trigger("reset");
        
                  $('#modalCreateEvent').fadeOut(500,function(){
                        $('#modalCreateEvent').modal('hide');
                     });
        
                     $("#formCalendar").trigger("reset");
                }
            });
        
        });
        
        ////////////////////// End add new event //////////////////////
        
        $(document).on('click', '#deleteEvent', function(){
            var event_id = $("#event_id").val();
            var url = "{{url(app()->getLocale().'/events/delete')}}";
              $.ajax({
                 url: url+'/'+event_id,
                type: "GET",
                data: $('#deleteEventsTasks').serialize(),
                success: function (response) {
        
                  $('#deleteEventsTasks').trigger("reset");
                  $('#modalCalendarEvent').fadeOut(500,function(){
                        $('#modalCalendarEvent').modal('hide');
                          window.location.href = "{{url(app()->getLocale().'/events')}}";
                     });
                }
            });
        });
        
        $(document).on('click', '#deleteTask', function(){
            var event_id = $("#event_id").val();
            var url = "{{url(app()->getLocale().'/tasks/delete')}}";
              $.ajax({
                 url: url+'/'+event_id,
                type: "GET",
                data: $('#deleteEventsTasks').serialize(),
                success: function (response) {
        
                  $('#deleteEventsTasks').trigger("reset");
                  $('#modalCalendarEvent').fadeOut(500,function(){
                        $('#modalCalendarEvent').modal('hide');
                          window.location.href = "{{url(app()->getLocale().'/events')}}";
                     });
                }
            });
        });
        
        
        ///////// Add New Note ///////
        $('#formCreateNote').on('submit', function(){
        
            $("#addNewNote").attr('disabled', 'true');
            var note   =  $('#note').val();
            var note_date   =  $('#note_date').val();
        
            if(note != null && note_date != null){
        
              $.ajax({
                url: "{{url(app()->getLocale().'/notes/create_note')}}",
                type: "POST",
                data: $('#formCreateNote').serialize(),
                success: function (response) {
        
                    $(this).attr('disabled', false);
        
                  $('#formCreateNote').trigger("reset");
        
                  $('#modalAddNote').fadeOut(500,function(){
                        $('#modalAddNote').modal('hide');
                     });
        
                  $(".allNotes").load(location.href + " .allNotes");
        
                }
            });
            }
        });
        
        ///////// Add Attach File ///////
        $('#formCreateAttach').on('submit', function(){
        
            $('#createAttachFile').attr('disabled', 'true');
        
            var token =  $("input[name = _token]").val();
            var formData = new FormData(this);
        
            $.ajax({
            url: "{{url(app()->getLocale().'/attachments/createAttach')}}",
            type: "POST",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
        
            success: function (response) {
                $('#createAttachFile').attr('disabled', false);
        
                $('#formCreateAttach').trigger("reset");
                $('#attachfile').attr('value', null);
        
                $('#modalAddAttach').fadeOut(500,function(){
                $('#modalAddAttach').modal('hide');
                });
                $(".AttachsFiles").load(location.href + " .AttachsFiles");
            }
        
        });
        
        });
        ////////////////////////////////
        
        ///////// add Hours From Task Home ///////
        $(document).on('click', '#addHoursFromHome', function(){
        
            var task_id = $(this).data("id");
        
            $('.project_id_div').remove();
            $('.task_id_div').remove();
        
            $('.hoursTotalAmount').append('<input type="hidden" name="task_id" value="'+task_id+'">');
        
        });
        ////// End Store New Note //////
        
        ///////// Create Expense ///////
        $('#formCreateExpense').on('submit', function(){
        
            $(this).attr('disabled', 'true');
        
            $.ajax({
            url: "{{url(app()->getLocale().'/expenses')}}",
        
            type: "POST",
            data: $('#formCreateExpense').serialize(),
            success: function (response) {
        
                $(this).attr('disabled', false);
        
                $('#addExpense').fadeOut(500,function(){
                $('#addExpense').modal('hide');
                });
        
                $(".allExpenses").load(location.href + " .allExpenses");
        
                $("#addExpense #project_id").val('').select2();
                $("#addExpense #aspect_expense_id").val('').select2();
                $("#addExpense #responsible_lawyer").val('').select2();
                $("#formCreateExpense").trigger("reset");
        
            }
        
        });
        
        });
        ////// End Store New Note //////
        
        ///////// Create Flats Fees ///////
        $('#formCreateFlatsFees').on('submit', function(){
        
            $("#newFlatsFees").attr('disabled', 'true');
        
            $.ajax({
            url: "{{url(app()->getLocale().'/flats_fees')}}",
        
            type: "POST",
            data: $('#formCreateFlatsFees').serialize(),
            success: function (response) {
        
                $("#newFlatsFees").attr('disabled', false);
                $('#addFlatsFees').fadeOut(500,function(){
                $('#addFlatsFees').modal('hide');
                });
        
                $(".allFlatsFees").load(location.href + " .allFlatsFees");
        
                $("#newFlatsFees #project_id").val('').select2();
                $("#formCreateFlatsFees").trigger("reset");
        
            }
        
        });
        
        });
        ////// End Flats Fees //////
        
        
        ///////// Client Project Task ///////
        $('#formCreateProjectTask').on('submit', function(){
        
            $("#createProjectTask").attr('disabled', 'true');
        
            $.ajax({
            url: "{{url(app()->getLocale().'/tasks')}}",
        
            type: "POST",
            data: $('#formCreateProjectTask').serialize(),
                success: function (response) {
        
                    $("#createProjectTask").attr('disabled', false);
        
                    $('#modalAddProjectTask').fadeOut(500,function(){
                    $('#modalAddProjectTask').modal('hide');
                    });
        
                    $(".ProjectTasks").load(location.href + " .ProjectTasks");
        
                    $("#modalAddProjectTask #project_id").val('').select2();
                    $("#modalAddProjectTask #task_type_id").val('').select2();
                    $("#modalAddProjectTask #task_employees").val('').select2();
                    $("#modalAddProjectTask #task_status_id").val('').select2();
                    $("#formCreateProjectTask").trigger("reset");
        
                }
        
            });
        
        });
        ////// End Store New Note //////
        
        
        ///////// Client New Note ///////
        $(document).on('click', '#createProjectHours', function(){
        
              $.ajax({
                url: "{{url(app()->getLocale().'/hours')}}",
                type: "POST",
                data: $('#formCreateProjectHour').serialize(),
                success: function (response) {
        
                $('#formCreateProjectHour').trigger("reset");
        
                $('#modalAddProjectsHours').fadeOut(500,function(){
                    $('#modalAddProjectsHours').modal('hide');
                });
        
                $("#hoursProject").load(location.href + " #hoursProject");
        
        
                }
            });
        });
        ////// End Store New Note //////
        
        ///////// Create Extra Fields ///////
        $(document).on('click', '#createExtraFields', function(){
        
            $(this).attr('disabled', 'true');
        
            var field_req, name, field, fieldtype;
        
            if($('#required').is(":checked")){
                field_req = '';
            }
            else{
                field_req = 'required';
            }
        
            name = $('#name').val();
        
            fieldtype = $('#type').val();
        
            if(fieldtype == 'textarea'){
                field = '<textarea class="form-control extrafield" name="extrafield[]"  '+field_req+'></textarea>';
            }
            if(fieldtype == 'input'){
                field = '<input type="text" class="form-control extrafield" name="extrafield[]" '+field_req+'>';
            }
        
            if(fieldtype == 'checkbox'){
                field = '<input type="checkbox" class="chkBox extrafield-chkBox" value="checked" name="">';
            }
        
            $.ajax({
            url: "{{url(app()->getLocale().'/fields')}}",
            type: "POST",
            data: $('#formCreateExtraFileds').serialize(),
        
                success: function (response) {
                        $('#createExtraFields').attr('disabled', false);
        
                        $('#modalAddField').fadeOut(500,function(){
                            $('#modalAddField').modal('hide');
                        });
        
                        $('#formCreateExtraFileds').trigger("reset");
                        $('#modalAddField').trigger("reset");
        
        
                        if(response.type != 'checkbox'){
                            $('.AddExtraFields').append('<div class="form-group mb-3 row"><label for="position" class="col-md-3 control-label bold fs-14">'+name+'</label><div class="col-md-7"><div class="form-group form-group-default '+field_req+' "><label>'+name+'</label>'+field+'</div></div></div>');
                        }else{
                            $('.AddExtraFields').append('<div class="form-group mb-3 row"><label for="position" class="col-md-3 control-label bold fs-14">'+name+'</label><div class="col-md-7"><div class="form-group">'+field+'</div></div></div>');
                        }
        
        
                        $('.AddExtraFields').append('<input type="hidden" value="'+response.id+'" name="fieldsids[]" class="fieldsids">');
        
        
                }
            });
        
        });
        ///////// End Create Extra Fields ///////
        
        
        ///////// Add New Bill ///////
        $(document).on('click', '#createProjectBill', function(){
        
            $(this).attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/bills')}}",
                type: "POST",
                data: $('#formCreateBill').serialize(),
                success: function (response) {
        
                  $('#formCreateBill').trigger("reset");
        
                  $('#AddPayment').fadeOut(500,function(){
                        $('#AddPayment').modal('hide');
                    });
        
                  $(".allBills").load(location.href + " .allBills");
        
                }
            });
        });
        ////// End Store New Note //////
        
        
        
        ///////// Add New iNVOICE ///////
        $('#formCreateInvoice').on('submit', function(){
        
            $("#createProjectInvoice").attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/invoices')}}",
                type: "POST",
                data: $('#formCreateInvoice').serialize(),
                success: function (response) {
        
                    $("#createProjectInvoice").attr('disabled', false);
        
                    $('#AddInvoices').fadeOut(500,function(){
                        $('#AddInvoices').modal('hide');
                    });
        
                    $(".allInvoices").load(location.href + " .allInvoices");
        
                    $("#AddInvoices #project_id").val('').select2();
                    $("#formCreateInvoice").trigger("reset");
        
                }
            });
        });
        ////// End Store New Note //////
        
        ///////// Add New Report ///////
        $('#formCreateReport').on('submit', function(){
        
            $('#createProjectReport').attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/reports')}}",
                type: "POST",
                data: $('#formCreateReport').serialize(),
                success: function (response) {
        
                $('#createProjectReport').attr('disabled', false);
        
                $('#AddReports').fadeOut(500,function(){
                    $('#AddReports').modal('hide');
                });
        
                $(".allReports").load(location.href + " .allReports");
        
                $("#AddReports #project_id").val('').select2();
                $("#AddReports #task_id").val('').select2();
                $("#formCreateReport").trigger("reset");
        
                }
            });
        });
        ////// End Store New Note //////
        
        ///////// Client New Note ///////
        $('#formCreateHours').on('submit', function(){
        
            $('#newTaskHours').attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/hours')}}",
                type: "POST",
                data: $('#formCreateHours').serialize(),
                success: function (response) {
        
                $('#newTaskHours').attr('disabled', false);
        
                $('#modalAddHours').fadeOut(500,function(){
                    $('#modalAddHours').modal('hide');
                });
        
                $(".allHours").load(location.href + " .allHours");
        
                $(".hoursTotalAmount").hide();
                $("#modalAddHours #project_id").val('').select2();
                $("#modalAddHours #task_id").val('').select2();
                $("#modalAddHours #responsible_lawyer").val('').select2();
                $("#formCreateHours").trigger("reset");
        
                }
            });
        });
        ////// End Store New Note //////
        
        $('#createReportTasks').on('submit', function(){
        
            $("#newProjectTasks").attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/tasks/ReportTasks')}}",
                type: "POST",
                data: $('#createReportTasks').serialize(),
                success: function (response) {
        
                    $("#newProjectTasks").attr('disabled', false);
        
                    $('#ReportTasksModal').fadeOut(500,function(){
                        $('#ReportTasksModal').modal('hide');
                    });
        
                    $('.projectTasks').prepend(response.projectTasks);
        
                    $("#ReportTasksModal #task_type_id").val('').select2();
                    $("#ReportTasksModal #task_status_id").val('').select2();
                    $("#ReportTasksModal #priority").val('').select2();
                    $("#ReportTasksModal #task_employees").val('').select2();
                    $("#createReportTasks").trigger("reset");
        
                }
            });
        });
        ////// End Store New Invoice Hour//////
        
        $('#createReportExpenses').on('submit', function(){
        
            $("#newReportExpenses").attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/expenses/ReportExpense')}}",
                type: "POST",
                data: $('#createReportExpenses').serialize(),
                success: function (response) {
        
                    $("#newReportExpenses").attr('disabled', 'true');
        
                    $('#ReportExpensesModal').fadeOut(500,function(){
                        $('#ReportExpensesModal').modal('hide');
                    });
        
                    $('.projectExpenses').prepend(response.projectExpenses);
        
                    $("#ReportExpensesModal #aspect_expense_id").val('').select2();
                    $("#ReportExpensesModal #responsible_lawyer").val('').select2();
                    $("#createReportExpenses").trigger("reset");
        
                }
            });
        });
        ////// End Store New Invoice Hour//////
        
        
        $('#createReportHours').on('submit', function(){
        
            $("#newReportHours").attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/hours/ReportHours')}}",
                type: "POST",
                data: $('#createReportHours').serialize(),
                success: function (response) {
        
                    $("#newReportHours").attr('disabled', false);
        
                    $('#createReportHours').trigger("reset");
        
                    $('#ReportsHoursModel').fadeOut(500,function(){
                        $('#ReportsHoursModel').modal('hide');
                    });
        
                    $('.projectHours').prepend(response.projectHours);
        
                    $("#ReportsHoursModel #responsible_lawyer").val('').select2();
                    $("#createReportHours").trigger("reset");
        
                }
            });
        });
        ////// End Store New Invoice Hour//////
        
        
        $('#formInvoiceFlatsFees').on('submit', function(){
        
            $("#newInvoiceFlatsFees").attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/flats_fees/InvoiceFlatsFees')}}",
                type: "POST",
                data: $('#formInvoiceFlatsFees').serialize(),
                success: function (response) {
        
                    $("#newInvoiceFlatsFees").attr('disabled', false);
        
                    $('#InvoiceExpensesModal').fadeOut(500,function(){
                        $('#InvoiceFlatsFeeModal').modal('hide');
                    });
        
                    $('.projectFlatsFees').prepend(response.projectFlatsFees);
                    $("#formInvoiceFlatsFees").trigger("reset");
        
                }
            });
        });
        ////// End Store New Invoice Hour//////
        
        $('#createInvoiceExpenses').on('submit', function(){
        
            $("#newInvoiceExpenses").attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/expenses/InvoiceExpense')}}",
                type: "POST",
                data: $('#createInvoiceExpenses').serialize(),
                success: function (response) {
        
                    $("#newInvoiceExpenses").attr('disabled', false);
        
                    $('#InvoiceExpensesModal').fadeOut(500,function(){
                        $('#InvoiceExpensesModal').modal('hide');
                    });
        
                    $('.projectExpenses').prepend(response.projectExpenses);
        
                    $("#InvoiceExpensesModal #aspect_expense_id").val('').select2();
                    $("#InvoiceExpensesModal #responsible_lawyer").val('').select2();
                    $("#createInvoiceExpenses").trigger("reset");
        
                }
            });
        });
        ////// End Store New Invoice Hour//////
        
        ///////// New Invoice Hour ///////
        $('#createInvoiceHours').on('submit', function(){
        
            $("#newInvoiceHours").attr('disabled', 'true');
        
              $.ajax({
                url: "{{url(app()->getLocale().'/hours/InvoiceHour')}}",
                type: "POST",
                data: $('#createInvoiceHours').serialize(),
                success: function (response) {
        
                $("#newInvoiceHours").attr('disabled', false);
        
                $('#addInvoiceHours').fadeOut(500,function(){
                    $('#addInvoiceHours').modal('hide');
                });
        
                $('.projectHours').prepend(response.projectHours);
        
                $("#addInvoiceHours #responsible_lawyer").val('').select2();
                $(".printHoursTotalAmount").html('0');
                $("#createInvoiceHours").trigger("reset");
        
                }
            });
        });
        ////// End Store New Invoice Hour//////
        
        ///////// New Folder ///////
        $('#formCreateFolder').on('submit', function(){
        
            $("#newFolder").attr('disabled', 'true');
        
            $.ajax({
              url: "{{url(app()->getLocale().'/documents')}}",
              type: "POST",
              data: $('#formCreateFolder').serialize(),
              success: function (response) {
            
                $("#newFolder").attr('disabled', false);
            
                $('#modalAddFolder').fadeOut(500,function(){
                      $('#modalAddFolder').modal('hide');
                   });
            
                $(".allDocuments").load(location.href + " .allDocuments");
            
                $("#parent_id").append('<option selected value="'+response.id+'">'+ response.title +'</option>');
            
                $("#modalAddFolder #project_id").val('').select2();
                $("#formCreateFolder").trigger("reset");
            
            }
            });
        });
        ////// End New Folder //////
        
        ///////// New Client ///////
        $(document).on('submit', '#formCreateClient', function(){
        
            $("#addNewClient").attr('disabled', 'true');
            
            $.ajax({
              url: "{{url(app()->getLocale().'/clients/createModel')}}",
              type: "POST",
              data: $('#formCreateClient').serialize(),
              success: function (response) {
            
                $("#addNewClient").attr('disabled', false);
            
                $('#modalAddClients').fadeOut(500,function(){
                    $('#modalAddClients').modal('hide');
                });
            
            
                $("#case_client_id").append('<option selected value="'+response.id+'">'+ response.name +'</option>');
                $("#consultation_client_id").append('<option selected value="'+response.id+'">'+ response.name +'</option>');
                $("#other_client_id").append('<option selected value="'+response.id+'">'+ response.name +'</option>');
            
                $("#modalAddClients #card_id").val('').select2();
                $("#modalAddClients #person_country_id").val('').select2();
                $("#modalAddClients #person_city_id").val('').select2();
                $("#formCreateClient").trigger("reset");
            
              }
            });
        });
        ////// End New Client //////
        
        ///////// Add New Document ///////
        $('#formCreateDocument').on('submit', function(){
        
            $('#newDocument').attr('disabled', 'true');
        
            var token = $("input[name = _token]").val();
            var formData = new FormData(this);
        
            $.ajax({
            url: "{{url(app()->getLocale().'/documents')}}",
            type: "POST",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
        
            success: function (response) {
        
                $('#newDocument').attr('disabled', 'true');
        
                $('#modalAddDocument').fadeOut(500,function(){
                $('#modalAddDocument').modal('hide');
                });
                $(".allDocuments").load(location.href + " .allDocuments");
        
                $("#modalAddDocument #parent_id").val('').select2();
                $("#formCreateDocument").trigger("reset");
        
            }
        
        });
        
        });
        ////////////////////////////////
    
    ////// End Store New Note //////
    
    
        /////////////////////////// Check Box /////////////////////////
        $(document).on( 'change','.chkBox',function(e){
            var IDArray = [];
    
            $("input:checkbox[name=chkBox]:checked").each(function(e){
              IDArray.push($(this).val());
              $('.viewItems').append($('.name'+$(this).val()).text()+'<br>');
            });
              if(IDArray.length == 0){
                $('.event').addClass('cursorNODrop');
                $('.event').attr('disabled', 'true');
              }else{
                $('.event').removeClass('cursorNODrop');
                $('.event').removeAttr('disabled');
              }
       });
    
    
       ///////////////////////// End Check Box ///////////////////////
    
    	/////////////// Choose Projects & Tasks ///////////////
        if($(".project").val() != ''){
    			$('.project').change();
    		}
    
    
    /////////////////////// View Tasks ////////////////////
        $(document).on('change','.project',function(e){
        var project_id = $(this).val();
        var url = "{{ url(app()->getLocale().'/getTasks/') }}";
    
          if(project_id){
            $.ajax({
              type: "GET",
              url: url+'/'+project_id,
              success: function (response) {
                  if(response)
                  {
                    $(".task").empty();
                    $(".task").append('<optgroup label="{{__('website.choose_task')}}">');
                    $(".task").append('<option value=""></option>');
                    $.each(response, function(index, value){
                      $(".task").append('<option value="'+value.id+'">'+ value.name +'</option>');
                      $(".task").append('</optgroup>');
                    });
                  }
              }
            });
          }
          else{
            $(".task").empty();
          }
    });
    
      ///////////////////////// Complete Task ////////////////////
    
        $(document).on('change','#changeTaskStatus',function(e){
    
          var task_id = $(this).data("id");
          var newStatus = $(this).val();
        
          if(task_id){
            var url = "{{ url(app()->getLocale().'/tasks/changeTaskStatus') }}";
        
            var tr_id = '#tr-' + task_id;
        
            $.ajax({
              type: "GET",
              url: url+'/'+task_id+'/'+newStatus,
              success: function(response){
                $(".taskDetailsDiv").load(location.href+" .taskDetailsDiv>*","");
              }
            });
        
          }
    
      });
    
    ///////////////////////// Change Project Status ////////////////////
    
        $(document).on('change','.changeProjectStatus',function(e){
        
            var newStatus = $(this).val();
            var project_id = $(this).data("id");
            
            if(project_id && newStatus){
            
              var url = "{{ url(app()->getLocale().'/projects/changeStatus') }}";
            
                $.ajax({
                  type: "GET",
                  url: url+'/'+project_id+'/'+newStatus,
                  success: function (response) {
                    $("#projectStatus").load(location.href + " #projectStatus");
                  }
                });
            
            }
        
        });
    
      ///////////////////////// Complete Task ////////////////////
    
        $(document).on('click','.completeTask',function(e){
    
         var task_id = $(this).data("id");
    
         if(task_id){
            var url = "{{ url(app()->getLocale().'/tasks/completeTask') }}";
            var tr_id = '#tr-' + task_id;
            var newTxt  = "{{__('website.completed')}}";
    
            $.ajax({
              type: "GET",
              url: url + '/' + task_id,
              success: function(response){
               //$(".taskDetailsDiv").load(location.href+" .taskDetailsDiv>*","");
               $(".taskStatus-" + task_id).html(newTxt);
    
              }
            });
         }
    });
    
      ///////////////////////// Complete Invoice ////////////////////
    
        $(document).on('click','.completeInvoice',function(e){
    
            var invoice_id = $(this).data("id");
        
            if(invoice_id){
               var url = "{{ url(app()->getLocale().'/invoices/completeInvoice') }}";
               var tr_id = '#tr-' + invoice_id;
               var newTxt  = "{{__('website.approved')}}";
            
               $.ajax({
                 type: "GET",
                 url: url + '/' + invoice_id,
                 success: function(response){
                  $(".invoiceStatus-" + invoice_id).html(newTxt);
            
                 }
               });
            }
        });
      ///////////////////////// Canceled Expense ////////////////////
    
        $(document).on('click','.canceledExpense',function(e){
    
            var expense_id = $(this).data("id");
            
            if(expense_id){
               var url = "{{ url(app()->getLocale().'/expenses/canceledExpense') }}";
            
               $.ajax({
                 type: "GET",
                 url: url + '/' + expense_id,
                 success: function(response){
                  $(".allExpenses").load(location.href+" .allExpenses>*","");
                 }
               });
            }
        });
    
    /////////////////////// View Cities ////////////////////
        $(document).on('change','.country',function(e){
        var country_id = $(this).val();
        var url = "{{ url(app()->getLocale().'/getCities/') }}";
    
          if(country_id){
            $.ajax({
              type: "GET",
              url: url+'/'+country_id,
              success: function (response) {
                  if(response)
                  {
                    $(".city").empty();
                    $(".city").append('<optgroup label="{{__('website.choose_city')}}">');
                    $.each(response, function(index, value){
                      $(".city").append('<option value="'+value.id+'">'+ value.name +'</option>');
                      $(".city").append('</optgroup>');
                    });
                  }
              }
            });
          }
          else{
            $(".city").empty();
          }
    });
    
        $(document).on("click", ".modalToEditDocument", function () {
         var document_id = $(this).data('id');
         $('#UpdateDocument').val(document_id);
         var url = "{{ url(app()->getLocale().'/getDocument/') }}";
    
         if(document_id){
            $.ajax({
              type: "GET",
              url: url+'/'+document_id,
              success: function (response) {
                    $(".parentid").val(response.parent_id);
                    $(".title").val(response.title);
                    $(".document_date").val(response.document_date);
              }
            });
          }
    
        });
    
        $(document).on("click", ".modalToEditFolder", function () {
         var folder_id = $(this).data('id');
         $('#UpdateFolder').val(folder_id);
    
         var url = "{{ url(app()->getLocale().'/getFolder/') }}";
    
         if(folder_id){
            $.ajax({
              type: "GET",
              url: url+'/'+folder_id,
              success: function (response) {
                    $(".title").val(response.title);
                    $(".end_date").val(response.document_date);
                    $(".project").val(response.project_id);
              }
            });
          }
    
        });
    
        $(document).on('click','#UpdateFolder', function(){
            folder_id = $(this).val();
        
            var title        =  $('#title').val();
            var project_id   =  $('#project_id').val();
            var folder_date   =  $('#folder_date').val();
        
            var url = "{{ url(app()->getLocale().'/updateFolder') }}";
    
            $.ajax({
                url: url+'/'+folder_id,
                type: "POST",
                data: $('#formUpdateFolder').serialize(),
    
                success: function (response) {
                    $('#modalToEditFolder').fadeOut(500,function(){
                        $('#modalToEditFolder').modal('hide');
                    });
    
                    $(".allFolders").load(location.href + " .allFolders");
    
                    $("#modalToEditFolder #project_id").val('').select2();
                    $("#formUpdateFolder").trigger("reset");
    
    
                }
            });
      });
    
    //////////////////////////////////
    
    
    
        $(document).on('click','#UpdateDocument', function(){
            document_id = $(this).val();
        
            var parent_id =  $('#parent_id').val();
            var title =  $('#title').val();
            var document_date =  $('#document_date').val();
        
            var url = "{{ url(app()->getLocale().'/updateDoucment') }}";
    
            $.ajax({
                url: url+'/'+document_id,
                type: "POST",
                data: $('#formToEditDocument').serialize(),
    
                success: function (response) {
                    $('#modalToEditDocument').fadeOut(500,function(){
                        $('#modalToEditDocument').modal('hide');
                    });
    
                    $(".allDocuments").load(location.href + " .allDocuments");
    
                    $("#modalToEditDocument #parent_id").val('').select2();
                    $("#formToEditDocument").trigger("reset");
    
    
                }
            });
      });
    
      ///////////////////////// Update Client Note ////////////////////
    
    
        $(document).on("click", ".modalToEditNote", function () {
         var note_id = $(this).data('id');
         $('#updateNote').val(note_id);
    
         var url = "{{ url(app()->getLocale().'/getNote/') }}";
    
         if(note_id){
            $.ajax({
              type: "GET",
              url: url+'/'+note_id,
              success: function (response) {
                    $(".note").val(response.note);
                    $(".start_date").val(response.note_date);
              }
            });
          }
    
        });
    
        $(document).on('click','#updateNote', function(){
        var note_id = $(this).val();
        var note        =  $('#note').val();
        var note_date   =  $('#note_date').val();
    
        var url = "{{ url(app()->getLocale().'/updateNote') }}";
    
    
    
            $.ajax({
                url: url+'/'+note_id,
                type: "POST",
                data: $('#formUpdateNote').serialize(),
    
    
                success: function (response) {
                    $('#modalToEditNote').modal('hide');
                    $(".allNotes").load(location.href + " .allNotes");
                }
            });
    
      });
    
      ////////////////////// End Update Client Note ///////////////////
    
    
      ///////////////////////// Delete Client Note ////////////////////
    
       $(document).on("click", ".modalToDeleteNote", function () {
         var ids = $(this).data('id');
         $('.deleteNote').data('id', ids);
        });
    
       $(document).on('click','.deleteNote',function(e){
        var note_id = $(this).data("id");
    
        var url = "{{ url(app()->getLocale().'/delete_note/') }}";
    
        if(note_id){
          $.ajax({
            type: "GET",
            url: url+'/'+note_id,
            success: function (response) {
            $('#div-' + note_id).hide(500);
            }
          });
        }
    
      });
    
      ////////////////////// End Delete Client Note ///////////////////
    
    /////////////////////// Task Category ////////////////////
    
        $(document).on('click','#projectCategory1',function(){
            $('.selectProject').removeClass("hidden");
        });
    
        $(document).on('click','#otherCategory1',function(){
            $('.selectProject').addClass("hidden");
        });
        
        $(document).on('click','#expenseRelatedProject',function(){
            $('.selectProject').removeClass("hidden");
        });
        
        $(document).on('click','#expenseNotRelatedProject',function(){
            $('.selectProject').addClass("hidden");
        });
        
        $(document).on('click','#expenseRelatedProject1',function(){
            $('.selectProject').removeClass("hidden");
        });
    
    
        $(document).on('click','#expenseNotRelatedProject1',function(){
            $('.selectProject').addClass("hidden");
        });
        
        $(document).on('click','#projectCategory2',function(){
            $('.selectProject').removeClass("hidden");
        });
        
        $(document).on('click','#otherCategory2',function(){
            $('.selectProject').addClass("hidden");
        });
        
        $(document).on('click','#projectCategory3',function(){
            $('.selectProject').removeClass("hidden");
        });
        
        $(document).on('click','#otherCategory3',function(){
            $('.selectProject').addClass("hidden");
        });
    /////////////////////// End Hour Price ////////////////////
    
    // {{$one->hour_price}}
    
        $(document).on('click','.confirmAll',function(e){
            e.preventDefault();
            var action = $(this).data('action');
    
            var url = "{{ url(app()->getLocale().'/changeStatus/'.Request::segment(2)) }}";
    
            if($("#tabSection").val() == 'bill'){
                var url = "{{ url(app()->getLocale().'/changeStatus/bills') }}";
            }
    
            var csrf_token = '{{csrf_token()}}';
            var IDsArray = [];
            $("input:checkbox[name=chkBox]:checked").each(function () {
                IDsArray.push($(this).val());
            });
    
    
            if (IDsArray.length > 0) {
                $.ajax({
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': csrf_token},
                    url: url,
                    data: {action: action, IDsArray: IDsArray, _token: csrf_token},
                    success: function (response) {
                        if (response === 'active') {
    
                            $.each(IDsArray, function (index, value) {
                                $('#label-' + value).removeClass('badge-info');
                                $('#label-' + value).addClass('badge-success');
                                $r = '{{app()->getLocale()}}';
    
                                if($r == 'ar'){
                                    $('#label-' + value).text('{{__("website.active")}}');
                                }else{
                                    $('#label-' + value).text('{{__("website.active")}}');
                                }
    
                            if($r == 'ar'){
                              $('#details-label-' + value).text('{{__("website.active")}}');
                            }else{
                              $('#details-label-' + value).text('{{__("website.active")}}');
                            }
    
                            });
                            $('#activation').modal('hide');
    
    
                        } else if (response === 'not_active') {
    
                            $.each(IDsArray, function (index, value) {
                                $('#label-' + value).removeClass('badge-success');
                                $('#label-' + value).addClass('badge-info');
                                $r = '{{app()->getLocale()}}';
    
    
                                if($r == 'ar'){
                                    $('#label-' + value).text('{{__("website.not_active")}}');
                                }else{
                                    $('#label-' + value).text('{{__("website.not_active")}}');
                                }
    
                                if($r == 'ar'){
                                    $('#details-label-' + value).text('{{__("website.not_active")}}');
                                }else{
                                    $('#details-label-' + value).text('{{__("website.not_active")}}');
                                }
    
    
                            });
                            $('#cancel_activation').modal('hide');
    
    
                        } else if (response === 'delete') {
                            $.each(IDsArray, function (index, value) {
                                $('#tr-' + value).hide(2000);
                            });
                            $('#deleteAll').modal('hide');
                        }
    
                         IDArray = [];
                        $("input:checkbox[name=chkBox]:checked").each(function () {
                            $(this).prop('checked', false);
                        });
                         $("#checkboxall").prop('checked', false);
                         $('.event').addClass('cursorNODrop');
                         $('.event').attr('disabled', 'true');
    
                         $(".chkBox-details").prop('checked', true);
    
    
                    },
                    fail: function (e) {
                        alert(e);
                    }
                });
    
    
    
            } else {
                alert('{{__('cp.not_selected')}}');
            }
        });
    
    });
    
    /////////////////////// Check Box All ////////////////////
    $(document).on('click','#checkboxall',function(e){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            //$("#checkboxall").removeAttr('checked');
    });
    
    /////////////////////// Delete Client From Details Page ////////////////////
    $(document).on('click','.deleteClientFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/clients/') }}";
      window.location.href = url;
    });
    
    /////////////////////// Delete doument From Details Page ////////////////////
    $(document).on('click','.deleteDoumentFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/documents/') }}";
      window.location.href = url;
    });
    
    
    /////////////////////// Delete Expense From Details Page ////////////////////
    $(document).on('click','.deleteBillFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/invoices/') }}";
      window.location.href = url;
    });
    
    /////////////////////// Delete Expense From Details Page ////////////////////
    $(document).on('click','.deleteExpenseFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/expenses/') }}";
      window.location.href = url;
    });
    
    /////////////////////// Delete Client From Details Page ////////////////////
    $(document).on('click','.deleteHourFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/hours/') }}";
      window.location.href = url;
    });
    
    /////////////////////// Delete Client From Details Page ////////////////////
    $(document).on('click','.deleteProjectFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/projects/') }}";
      window.location.href = url;
    });
    
    
    /////////////////////// Delete Report From Details Page ////////////////////
    $(document).on('click','.deleteReportFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/reports/') }}";
      window.location.href = url;
    });
    
    /////////////////////// Delete Project From Details Page ////////////////////
    $(document).on('click','.deleteInvoiceFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/invoices/') }}";
      window.location.href = url;
    });

	////////////////////////////////////////////////  Validation /////////////////////////////////////////
    $('#newHoursForm').validate({
			messages:{
				project_id: "{{__('website.required_field')}}",
				client_id: "{{__('website.required_field')}}",
				responsible_lawyer: "{{__('website.required_field')}}",
				hours_count: "{{__('website.required_field')}}",
				price: "{{__('website.required_field')}}",
				date: "{{__('website.required_field')}}",

				hour_status: "{{__('website.required_field')}}",
				hour_details: "{{__('website.required_field')}}",
				hour_office_details: "{{__('website.required_field')}}",
			}
	  });

	////////////////////////////////////////////// End Validation ///////////////////////////////////////

/////////////////////// Delete Project From Details Page ////////////////////
    $(document).on('click','.deleteProjectFromDetPage',function(e){
      url = "{{ url(app()->getLocale().'/projects/') }}";
      window.location.href = url;
    });
    
    /////////////////////// View Cities For Edit Form ////////////////////
    $(document).on('change','.countryEditForm',function(e){
            //$(".country").change;
            $(this).removeClass("countryEditForm");
            $(this).addClass("country");
            $('.country').change();
    });


</script>


<script>
    $(document).on('click','#PaidForClick',function(e){
      $('#rateHours').show();
      });
      $(document).on('click','#BillForClick',function(e){
      $('#rateHours').show();
      });
    $(document).on('click','#NotBillForClick',function(e){
      $('#rateHours').hide();
      });


</script>

  </body>
</html>
