<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title> {{$setting->title}} | {{__('website.login')}} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="{{url('assets/ico/60.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('assets/ico/76.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{url('assets/ico/120.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('assets/ico/152.png')}}">
    <link rel="icon" type="image/x-icon" href="{{url('assets/ico/favicon.ico')}}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="{{$setting->description}}" name="description" />
    <meta content="" name="author" />

    <!-- main  -->
    <link href="{{url('assets/plugins/pace/pace-theme-flash.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{url('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
  <script src="https://kit.fontawesome.com/5c87032e45.js" crossorigin="anonymous"></script>

    <!-- icons -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- custom css  -->
	<link href="{{url('assets/plugins/jquery-scrollbar/jquery.scrollbar.css')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{url('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
	<link href="{{url('assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" type="text/css" media="screen" />

    <!-- style-->
    <link class="main-stylesheet" href="{{url('pages/css/pages.css')}}" rel="stylesheet" type="text/css" />

  </head>
  <body class="fixed-header ">
    <div class="login-wrapper ">
      <div class="bg-pic">
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
        </div>
        <!-- END Background Caption-->
      </div>
      <!-- END Login Background Pic Wrapper-->
      <!-- START Login Right Container-->
      <div class="login-container bg-white">
        <div class="p-5">
        <a href="{{url('/')}}">
            <img src="{{$setting->logo}}" alt="logo" data-src="{{$setting->logo}}"
            data-src-retina="{{$setting->logo}}" width="160" height="45">
        </a>
          <p class="p-t-35">{{__('website.login_to_your_account')}}</p>




          @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


          <!-- START Login Form -->
          <form id="form-login" class="p-t-15" role="form" method="POST"
          action="{{ url(app()->getLocale()."/loginuser") }}">
          @csrf
            <!-- START Form Control-->
            <div class="form-group form-group-default ">
              <label>{{__('website.email')}}</label>
              <div class="controls">
                <input type="text" id="email" type="email" name="email" value="{{ old('email') }}"
                 autocomplete="email"  class="form-control" >
              </div>
            </div>
            <!-- END Form Control-->
            <!-- START Form Control-->
            <div class="form-group form-group-default mt-4">
              <label>{{__('website.password')}}</label>
              <div class="controls">
                <input id="password" type="password" name="password"  autocomplete="current-password" class="form-control">
              </div>
            </div>
            <!-- START Form Control-->
            <div class="row m-0">
              <div class="col-md-6 p-0 mb-3">

                <div class="custom-control custom-checkbox">



  <input type="checkbox" class="custom-control-input" id="remember" name="remember"
   {{ old('remember') ? 'checked' : '' }}    >




  <label class=" position-relative custom-control-label" for="remember"> {{__('website.remember_me')}} </label>
</div>


              </div>
              <div class="col-md-6 p-0">
                <a href="#" class=" text-md-left d-block text-info small">{{__('website.help_support_center')}}</a>
              </div>
            </div>
            <!-- END Form Control-->

             <button type="submit" id="loginUser" class="btn btn-primary mt-5 btn-lg">{{__('website.login')}}</button>
          </form>
          <!--END Login Form-->

        </div>
      </div>
      <!-- END Login Right Container-->
    </div>


    <!-- BEGIN VENDOR JS -->
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
    <script src="{{url('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <!-- END VENDOR JS -->


    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="{{url('pages/js/pages.min.js')}}" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->


    <!-- BEGIN PAGE LEVEL JS -->
    <script src="{{url('assets/js/scripts.js')}}" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->



    <script>

    $(document).ready(function(){


      $(document).on('click', '#loginUser', function(){
        var email     =  $('#form-login #email').val();
        var password  =  $('#form-login #password').val();
          if(email != "" && password != ""){
            $('#loginUser').html("<i class='fa fa-spinner fa-spin  fa-fw'></i> {{__('website.login')}} ");
          }

      });


    });
    </script>


  </body>
</html>
