@extends('layout.siteLayout')
@section('title', __('website.calendar'))

@section('topfixed')
<div class="page-top-fixed">
    <div class="container-fluid">
        <div class="px-3 pb-2 p-md-0 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
            <h2 class="page-header mb-1 my-md-3">{{__('website.tasks_managment')}}</h2>
            <div class="page-options-btns">
                <div class="btn-group mb-2 m-md-3 mt-md-0 ml-2">
                    <button type="button" class="btn btn-default has-icon">
                        <i class="material-icons">save</i>
                        <span>{{__('website.save')}}</span>
                    </button>

                    <button type="button" class="btn btn-default has-icon" data-target="#modalSlideLeft" data-toggle="modal">
                        <i class="material-icons">delete_outline</i><span>{{__('website.cancel')}}</span>
                    </button>

                </div>

                <a data-target="#modalCreateEvent" data-toggle="modal">
                    <button class="btn btn-complete has-icon mb-2 m-md-0">
                        <i class="material-icons">add</i><span>{{__('website.add_new')}}</span>
                    </button>
			    </a>

            </div>
        </div>
    </div>
</div>
@endsection



@section('content')
<div class="page-container">
    <div class="page-content-wrapper">
        <div class="content">
            <div class="calendar-wrapper">
                <div class="calendar-sidebar">
                    <div class="calendar-sidebar-header">
                        <i class="material-icons">search</i>
                        <div class="search-form">
                          <input type="search" class="form-control" placeholder="{{__('website.search')}}">
                        </div>
                    </div>
                    <div id="calendarSidebarBody" class="calendar-sidebar-body">
                           <div class="calendar-inline">
                                <div id="calendarInline"></div>
                            </div><!-- calendar-inline -->

                        <div class="py-4 calendar-nav-cont">
                            <label>{{__('website.calendars')}}</label>
                            <nav class="calendar-nav">
                                <a class="holiday show"><span></span>{{__('website.tasks')}}</a>
                                <a class="calendar show"><span></span>{{__('website.events')}}</a>
                                <a class="other show"><span></span>{{__('website.mettings')}}</a>
                                <a class="birthday show"><span></span>{{__('website.other_events')}}</a>
                            </nav>
                        </div>
                        <div class="py-4 schedule-items-cont">
                            <label>{{__('website.TodayTasks')}}</label>
                            <div class="schedule-group">
                                @if(isset($tasks))
                                @foreach($tasks->where('end_date', date('Y-m-d')) as $one)
                                    <a href="#" class="schedule-item bd-r bd-2 {{($loop->iteration % 2 == 0)? 'bd-danger' : 'bd-warning' }}">
                                        <h6>{{@$one->name}}</h6>
                                        <span>{{@$one->end_date}} <br> {{@$one->task_time}}</span>
                                    </a>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="calendar-content">
                    <div id="calendar" class="calendar-content-body"></div>
                </div>
            </div>
      </div>
    </div>
</div>



<div class="modal fade slide-right" id="modalCreateEvent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h6>{{__('website.AddNewEvent')}}</h6>
                </div>
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height">
                            <form method="post" action="javascript:void(0)" id="formCalendar">
                            {{csrf_field()}}

                                <div class="form-group form-group-default required">
                                    <label>{{__('website.title')}}</label>
                                    <input type="text" name="title" class="form-control">
                                </div>

                                <div class="form-group d-flex align-items-center">
                                    <div class="radio radio-success">
                                        <input type="radio" checked="checked" value="events" name="type" id="opt-1">
                                        <label for="opt-1"> {{__('website.events')}} </label>
                                        <input type="radio" value="meetings" name="type" id="opt-2">
                                        <label for="opt-2">{{__('website.meetings')}}</label>
                                        <input type="radio" value="other_events" name="type" id="opt-3">
                                        <label for="opt-3"> {{__('website.other_event')}}</label>
                                    </div>
                                </div>

                                <div class="input-daterange" id="datepicker-range">
                                    <div class="form-group mg-t-30">
                                        <div class="row row-xs">
                                            <div class="col-7">
                                                <div class="form-group form-group-default required">
                                                    <label>{{__('website.start_date')}}</label>
                                                    <input type="text" class="input-sm form-control hijri-date-input" id="eventStartDate" name="start_date" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group form-group-default required">
                                                    <label class="">{{__('website.time')}}</label>
                                                    <input type="time" class="input-sm form-control" name="start_time" autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-xs">
                                            <div class="col-7">
                                                <div class="form-group form-group-default required">
                                                    <label>{{__('website.end_date')}}</label>
                                                    <input type="text" class="input-sm form-control hijri-date-input" id="eventEndDate" name="end_date" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group form-group-default required">
                                                    <label class="">{{__('website.time')}}</label>
                                                    <input type="time" class="input-sm form-control" name="end_time" autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-group-default required">
                                    <label>{{__('website.details')}}</label>
                                    <textarea class="form-control" name="details" rows="2" placeholder=""></textarea>
                                </div>

                                <button type="submit" class="btn btn-complete btn-block" id="addNewEvent">{{__('website.save')}}</button>
                                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">{{__('website.cancel')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade slide-right" id="modalCalendarEvent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h5 class="event-title"></h5>
                </div>

                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height py-5">
                            <div class="row row-sm mb-3">
                                <div class="col-sm-6">
                                    <label><b>{{__('website.start_date')}}</b></label>
                                    <p class="event-start-date"></p>
                                </div>
                                <div class="col-sm-6">
                                    <label><b>{{__('website.end_date')}}</b></label>
                                    <p class="event-end-date"></p>
                                </div>
                            </div>

                            <label><b>{{__('website.details')}}</b></label>
                            <p class="event-desc mb-5"></p>

                            <form method="post" action="javascript:void(0)" id="deleteEventsTasks">
                            {{csrf_field()}}
                                <input type="hidden" id="event_id" name="event_id" value="">
                                <button type="button" class="btn btn-info btn-block" data-dismiss="modal">{{__('website.close')}}</button>
                                <button type="submit" class="btn btn-defaukt btn-block event_type" id="" data-dismiss="modal"> {{__('website.delete')}} </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@section('calenderJS')
<script>
    'use strict'
    var Tasks = {
      id: 1,
    //   backgroundColor: 'rgba(241,0,117,.25)',
    //   borderColor: '#f10075',
      events: [
    
        @foreach($tasks as $one)
        {
          id: '{{$one->id}}',
          start: '{{$one->end_date}}',
          end: '{{$one->end_date}}',
          title: '{{$one->name}}',
          description: '',
          type: 'Task',
      backgroundColor: 'rgba(241,0,117,.25)',
      borderColor: '#f10075',
        },
        @endforeach
    
      ]
    };
    
    var calendarEvents = {
      id: 2,
    //   backgroundColor: 'rgba(1,104,250, .15)',
    //   borderColor: '#0168fa',
      events: [
        @foreach($events->where('type', 'events') as $one)
        {
          id: '{{$one->id}}',
          start: '{{$one->start_date}}',
          end: '{{$one->end_date}}',
          title: '{{$one->title}}',
          description: '{{$one->details}}',
            type: 'Event',
      backgroundColor: 'rgba(1,104,250, .15)',
      borderColor: '#0168fa',
        },
        @endforeach
    
      ]
    };
    
    
    var meetupEvents = {
      id: 3,
    //   backgroundColor: 'rgba(91,71,251,.2)',
    //   borderColor: '#5b47fb',
      events: [
    
        @foreach($events->where('type', 'meetings') as $one)
        {
          id: '{{$one->id}}',
          start: '{{$one->start_date}}',
          end: '{{$one->end_date}}',
          title: '{{$one->title}}',
          description: '{{$one->details}}',
          type: 'Event',
      backgroundColor: 'rgba(91,71,251,.2)',
      borderColor: '#5b47fb',
    
        },
        @endforeach
    
    
      ]
    };
    
    
    var otherEvents = {
      id: 4,
    //   backgroundColor: 'rgba(253,126,20,.25)',
    //   borderColor: '#fd7e14',
      events: [
    
        @foreach($events->where('type', 'other_events') as $one)
        {
          id: '{{$one->id}}',
          start: '{{$one->start_date}}',
          end: '{{$one->end_date}}',
          title: '{{$one->title}}',
          description: '{{$one->details}}',
          type: 'Event',
      backgroundColor: 'rgba(253,126,20,.25)',
      borderColor: '#fd7e14',
        },
        @endforeach
    
      ]
    };

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
            // height: 'parent',

    dir:'rtl',
    selectable: true,
    lang: 'ar',
    locale: 'ar-sa',
    firstDay:6,
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,dayGridWeek,listWeek,agenda',
    //   right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    navLinks: true,
    
    select: function(info) {
        $('#modalCreateEvent').modal('show');
        $('#eventStartDate').val(info.startStr);
        $('#eventEndDate').val(info.endStr);
    
        // $('#eventStartTime').val(info.startStr.format('LT')).trigger('change');
        // $('#eventEndTime').val(info.endStr.format('LT')).trigger('change');
    },
    // selectLongPressDelay: 100,
    editable: true,
    nowIndicator: true,
    // defaultView: 'listMonth',
//       displayEventTime : false,
    views: {
      agenda: {
        columnHeaderHtml: function(mom) {
          return '<span>' + mom.format('ddd') + '</span>' +
                 '<span>' + mom.format('DD') + '</span>';
        }
      },
      timeGridDay: { columnHeader: false },
      dayGridMonth: {
        listDayFormat: 'ddd DD',
        listDayAltFormat: false
      },
      dayGridWeek: {
        listDayFormat: 'ddd DD',
        listDayAltFormat: false
      },
      agendaThreeDay: {
        type: 'agenda',
        duration: { days: 3 },
        titleFormat: 'MMMM YYYY'
      }
    },
    eventSources: [calendarEvents, Tasks, meetupEvents, otherEvents],
    eventAfterAllRender: function(view) {
      if(view.name === 'dayGridMonth' || view.name === 'dayGridWeek') {
        var dates = view.el.find('.fc-list-heading-main');
        dates.each(function(){
          var text = $(this).text().split(' ');
          var now = moment().format('DD');

          $(this).html(text[0]+'<span>'+text[1]+'</span>');
          if(now === text[1]) { $(this).addClass('now'); }
        });
      }

//      console.log(view.el);
    },
    eventRender: function(event, element) {

      if(event.description) {
        element.find('.fc-list-item-title').append('<span class="fc-desc">' + event.description + '</span>');
        element.find('.fc-content').append('<span class="fc-desc">' + event.description + '</span>');
      }

    //   var eBorderColor = (event.borderColor)? event.borderColor : event.borderColor;
    //   element.find('.fc-list-item-time').css({
    //     color: eBorderColor,
    //     borderColor: eBorderColor
    //   });

    //   element.find('.fc-list-item-title').css({
    //     borderColor: eBorderColor
    //   });

    //   element.css('borderRightColor', eBorderColor);
    },
    eventClick: function(info) {
      
    var modal = $('#modalCalendarEvent');

    $('#event_id').val(info.event.id);
    var delButton = "delete" + info.event.type;
    $('.event_type').attr("id", delButton);

    modal.modal('show');
    modal.find('.event-title').text(info.event.title);

    if(info.event.description) {
      modal.find('.event-desc').text(info.event.description);
      modal.find('.event-desc').prev().removeClass('d-none');
    } else {
      modal.find('.event-desc').text('');
      modal.find('.event-desc').prev().addClass('d-none');
    }

    modal.find('.event-start-date').text(moment(info.event.start).format('LLL'));
    modal.find('.event-end-date').text(moment(info.event.end).format('LLL'));

    //styling
    modal.find('.modal-header').css('backgroundColor', info.event.backgroundColor );
    },
    
    windowResize: function(view) {
        if(view.name === 'dayGridWeek') {
          if(window.matchMedia('(min-width: 992px)').matches) {
            calendar.changeView('dayGridMonth');
          } else {
            calendar.changeView('dayGridWeek');
          }
        }
        if(window.matchMedia('(min-width: 576px)').matches) {
            calendar.changeView('dayGridWeek');
        }
        if(window.matchMedia('(min-width: 992px)').matches) {
            calendar.changeView('dayGridMonth');
        }
    }
        });

  

        calendar.render();
      });



</script>
@endsection
@section('js')

<script>
 // sample calendar events data





$(function(){
  'use strict'
// var calendar ;
  // Initialize tooltip
  $('[data-toggle="tooltip"]').tooltip();

 
  // Sidebar calendar
  $('#calendarInline').datepicker({
      isRTL: true,
      locale: 'ar',
    showOtherMonths: true,
    selectOtherMonths: true,
    beforeShowDay: function(date) {

      // add leading zero to single digit date
      var day = date.getDate();
//      console.log(day);
      return [true, (day < 10 ? 'zero' : '')];
    }
  });

  // Initialize fullCalendar
//   $('#calendar').fullCalendar({
//     height: 'parent',
//     isRTL:true,
//     lang: 'ar',
//     locale: 'ar-sa',
//     header: {
//       left: 'prev,next today',
//       center: 'title',
//       right: 'month,agendaWeek,agendaDay,listWeek'
//     }
//     ,
//     navLinks: true,
//     selectable: true,
//     selectLongPressDelay: 100,
//     editable: true,
//     nowIndicator: true,
//     defaultView: 'listMonth',
// //       displayEventTime : false,
//     views: {
//       agenda: {
//         columnHeaderHtml: function(mom) {
//           return '<span>' + mom.format('ddd') + '</span>' +
//                  '<span>' + mom.format('DD') + '</span>';
//         }
//       },
//       day: { columnHeader: false },
//       listMonth: {
//         listDayFormat: 'ddd DD',
//         listDayAltFormat: false
//       },
//       listWeek: {
//         listDayFormat: 'ddd DD',
//         listDayAltFormat: false
//       },
//       agendaThreeDay: {
//         type: 'agenda',
//         duration: { days: 3 },
//         titleFormat: 'MMMM YYYY'
//       }
//     },

//     eventSources: [calendarEvents, Tasks, meetupEvents, otherEvents],
//     eventAfterAllRender: function(view) {
//       if(view.name === 'listMonth' || view.name === 'listWeek') {
//         var dates = view.el.find('.fc-list-heading-main');
//         dates.each(function(){
//           var text = $(this).text().split(' ');
//           var now = moment().format('DD');

//           $(this).html(text[0]+'<span>'+text[1]+'</span>');
//           if(now === text[1]) { $(this).addClass('now'); }
//         });
//       }

// //      console.log(view.el);
//     },
//     eventRender: function(event, element) {

//       if(event.description) {
//         element.find('.fc-list-item-title').append('<span class="fc-desc">' + event.description + '</span>');
//         element.find('.fc-content').append('<span class="fc-desc">' + event.description + '</span>');
//       }

//       var eBorderColor = (event.source.borderColor)? event.source.borderColor : event.borderColor;
//       element.find('.fc-list-item-time').css({
//         color: eBorderColor,
//         borderColor: eBorderColor
//       });

//       element.find('.fc-list-item-title').css({
//         borderColor: eBorderColor
//       });

//       element.css('borderRightColor', eBorderColor);
//     },
//   });

//   var calendar = $('#calendar').fullCalendar('getCalendar');

  // change view to week when in tablet
//   if(window.matchMedia('(min-width: 576px)').matches) {
//     calendar.changeView('agendaWeek');
//   }

  // change view to month when in desktop
//   if(window.matchMedia('(min-width: 992px)').matches) {
//     calendar.changeView('month');
//   }

  // change view based in viewport width when resize is detected
//   calendar.option('windowResize', function(view) {
//     if(view.name === 'listWeek') {
//       if(window.matchMedia('(min-width: 992px)').matches) {
//         calendar.changeView('month');
//       } else {
//         calendar.changeView('listWeek');
//       }
//     }
//   });

  // Display calendar event modal
//   calendar.on('eventClick', function(calEvent, jsEvent, view){

//     var modal = $('#modalCalendarEvent');

//     $('#event_id').val(calEvent.id);
//     var delButton = "delete" + calEvent.type;
//     $('.event_type').attr("id", delButton);

//     modal.modal('show');
//     modal.find('.event-title').text(calEvent.title);

//     if(calEvent.description) {
//       modal.find('.event-desc').text(calEvent.description);
//       modal.find('.event-desc').prev().removeClass('d-none');
//     } else {
//       modal.find('.event-desc').text('');
//       modal.find('.event-desc').prev().addClass('d-none');
//     }

//     modal.find('.event-start-date').text(moment(calEvent.start).format('LLL'));
//     modal.find('.event-end-date').text(moment(calEvent.end).format('LLL'));

//     //styling
//     modal.find('.modal-header').css('backgroundColor', (calEvent.source.borderColor)? calEvent.source.borderColor : calEvent.borderColor);
//   });

  // display current date
//   var dateNow = calendar.getDate();
//   calendar.option('select', function(startDate, endDate){
//     $('#modalCreateEvent').modal('show');
//     $('#eventStartDate').val(startDate.format('LL'));
//     $('#eventEndDate').val(endDate.format('LL'));

//     $('#eventStartTime').val(startDate.format('LT')).trigger('change');
//     $('#eventEndTime').val(endDate.format('LT')).trigger('change');
//   });

  $('.select2-modal').select2({
    minimumResultsForSearch: Infinity,
    dropdownCssClass: 'select2-dropdown-modal',
  });

  $('.calendar-add').on('click', function(e){
    e.preventDefault()

    // $('#modalCreateEvent').modal('show');
  });

})

</script>

@endsection

