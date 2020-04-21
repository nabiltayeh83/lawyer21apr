@extends('layout.siteLayout')
@section('title', __('website.settings'))
@section('content')

<div class=" container-fluid">
    <div class="row no-gutters mt-4">
        <div class="col-lg-12">
            <div class="allBoxSettings">
                <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/office_profile')}}">
                        <img src="{{url('pages/img/settings.svg')}}" alt="settings" /><h4>{{__('website.settings')}}</h4>
                    </a>
                </div>

                <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/staff')}}">
                        <img src="{{url('pages/img/staff.svg')}}" alt="settings" /><h4>{{__('website.staff')}}</h4>
                    </a>
                </div>

                <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/clients_settings')}}">
                        <img src="{{url('pages/img/clients.svg')}}" alt="settings" /><h4>{{__('website.clients')}}</h4>
                    </a>
                </div>

                <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/projects_settings')}}">
                        <img src="{{url('pages/img/projects.svg')}}" alt="settings" /><h4>{{__('website.projects')}}</h4>
                    </a>
                </div>

                <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/tasks_settings')}}">
                        <img src="{{url('pages/img/task.svg')}}" alt="settings" /><h4>{{__('website.tasks')}}</h4>
                    </a>
                </div>

                {{-- <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/hours_settings')}}">
                    <img src="{{url('pages/img/hours.svg')}}" alt="settings" />
                        <h4>{{__('website.hours')}}</h4>
                    </a>
                </div> --}}
                {{-- <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/documents_settings')}}">
                    <img src="{{url('pages/img/documents.svg')}}" alt="settings" />
                        <h4>{{__('website.documents')}}</h4>
                    </a>
                </div> --}}

                <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/invoices_settings')}}">
                        <img src="{{url('pages/img/invoices.svg')}}" alt="settings" /><h4>{{__('website.invoices')}}</h4>
                    </a>
                </div>

                <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/expenses_settings')}}">
                        <img src="{{url('pages/img/expense.svg')}}" alt="settings" /><h4>{{__('website.expenses')}}</h4>
                    </a>
                </div>

                <!--<div class="boxSettings">-->
                <!--    <a href="{{url(app()->getLocale().'/reports_settings')}}">-->
                <!--        <img src="{{url('pages/img/reports.svg')}}" alt="settings" /><h4>{{__('website.reports')}}</h4>-->
                <!--    </a>-->
                <!--</div>-->
                
                <div class="boxSettings">
                    <a href="{{url(app()->getLocale().'/roles_settings')}}">
                        <img src="{{url('pages/img/powers.svg')}}" alt="settings" /><h4>{{__('website.roles')}}</h4>
                    </a>
                </div>
                <div class="boxSettings">
                    <a href="#">
                        <img src="{{url('pages/img/noti.svg')}}" alt="settings" /><h4>{{__('website.notifications')}}</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
