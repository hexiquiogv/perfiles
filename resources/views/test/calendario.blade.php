@extends('layouts.master')

@section('custom_css')    
    <link href="{{ asset('MDB/fullcalendar-3.10.0/fullcalendar.min.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('MDB/fullcalendar-3.10.0/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('MDB/fullcalendar-3.10.0/fullcalendar.min.js') }}"></script>
@endsection

@section('content')
    <div id="calendar"></div>
@endsection

@push('scripts2')       
    <script type="text/javascript"> 
          $(document).ready(function() {
               $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay,listWeek'
                    },
                    defaultDate: '2018-11-16',
                    navLinks: true,
                    eventLimit: true,
                    events: [{
                            title: 'Front-End Conference',
                            start: '2018-11-16',
                            end: '2018-11-18'
                        },
                        {
                            title: 'Hair stylist with Mike',
                            start: '2018-11-20',
                            allDay: true
                        },
                        {
                            title: 'Car mechanic',
                            start: '2018-11-14T09:00:00',
                            end: '2018-11-14T11:00:00'
                        },
                        {
                            title: 'Dinner with Mike',
                            start: '2018-11-21T19:00:00',
                            end: '2018-11-21T22:00:00'
                        },
                        {
                            title: 'Chillout',
                            start: '2018-11-15',
                            allDay: true
                        },
                        {
                            title: 'Vacation',
                            start: '2018-11-23',
                            end: '2018-11-29'
                        },
                    ]
                });
          });
    </script>
@endpush

