@extends('sistema.alunos.layouts.vazio')
@section('content')
  <div class="card-header-custom padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
      <h2 class="quick text-18-pt"><i class="fas fa-calendar-alt margin-right-15"></i> Disponibilidade do professor - {{ $professor->fullName }}</h2>
  </div>
  <div class="card-body p-0 previa-professor">
      <div class="row padding-left-10">
          <div class="col-md-2">
            <h3>
            </h3>
          </div>
      </div>
      <!-- THE CALENDAR -->
      <div id="calendar" class="disponibilidade-professor"></div>
  </div>
  <!-- /.card-body -->
</div>
@stop

@section('scripts')
  <link rel="stylesheet" href="{{assets('sistema/fullcalendar/main.min.css')}}"/>
  <link rel="stylesheet" href="{{assets('sistema/fullcalendar-daygrid/main.min.css')}}"/>
  <link rel="stylesheet" href="{{assets('sistema/fullcalendar-timegrid/main.min.css')}}"/>
  <link rel="stylesheet" href="{{assets('sistema/fullcalendar-bootstrap/main.min.css')}}"/>
  <script src="{{assets('sistema/fullcalendar/main.min.js')}}"></script>
  <script src="{{assets('sistema/fullcalendar/locales/pt-br.js')}}"></script>
  <script src="{{assets('sistema/fullcalendar-daygrid/main.min.js')}}"></script>
  <script src="{{assets('sistema/fullcalendar-timegrid/main.min.js')}}"></script>
  <script src="{{assets('sistema/fullcalendar-interaction/main.min.js')}}"></script>
  <script src="{{assets('sistema/fullcalendar-bootstrap/main.min.js')}}"></script>
  <script>
    $(function() {

        /* initialize the calendar
        -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendarInteraction.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar(calendarEl, {
            now: new Date(),
            locale: 'pt-br',
            plugins: ['bootstrap', 'dayGrid', 'timeGrid'],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,list'
            },
            themeSystem: 'bootstrap',
            validRange: function(nowDate) {
              return {
                start: nowDate,
              };
            },
            showNonCurrentDates: false,
            events: [
              @forelse($eventos as $k => $e)
                {
                  @foreach( $e as $x => $z )
                    {{ $x }}: '{{ $z }}',
                  @endforeach
                },
              @empty
              @endforelse
            ],
            displayEventEnd: {
                month: true,
                basicWeek: true,
                "default": true
            },
            eventTimeFormat: { 
                hour: '2-digit',
                minute: '2-digit',
                hour12:false
            },
        });

        calendar.render();
        // $('#calendar').fullCalendar()
    })
  </script>
@stop