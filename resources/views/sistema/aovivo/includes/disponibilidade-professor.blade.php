  <section class="disponibilidade-professor">
    <div class="card-header-custom padding-top-10 padding-left-15 padding-right-15 padding-bottom-10">
        <h2 class="quick text-18-pt text-red"><i class="fas fa-calendar-alt margin-right-15 text-red"></i> Disponibilidade do professor - {{ $professor->fullName }}</h2>
    </div>
    <div class="card-body p-0">
        <div class="row padding-left-10">
            <div class="col-md-2">
              <h3>
               Agende sua aula
              </h3>
            </div>
        </div>
        <!-- THE CALENDAR -->
        <div id="calendar" class="disponibilidade-professor"></div>
    </div>
    <!-- /.card-body -->
  </div>
  <div class="modal fade modal-agendar" id="modal-sm" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Agendar Aula</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body padding-50">
          <div class="row quick text-gray text-20-pt bold">
            Dia: &nbsp;<span class="dia"></span>
          </div>
          <div class="row margin-top-10 quick text-gray text-20-pt bold">
            <span class="ini"></span> &nbsp;até &nbsp;<span class="fim"></span>
          </div>
          <div class="row margin-top-5 quick text-gray text-15-pt medium line-24">
              <div class="col-12">
                Categoria: &nbsp;<span class="categoria"></span>
              </div>
              <div class="col-12">
                Professor: &nbsp;<span class="professor"></span>
              </div>
          </div>
          <div class="row margin-top-10">
            <a href="#" data-id="" data-dia="" data-inicio="" data-fim="" data-agenda="" class="btn-purple-square quick medium text-14-pt btn-agendar">
                <i class="fas fa-check-circle padding-right-5"></i>
                Agendar Aula
            </a>
          </div>
          <div class="row margin-top-10 quick text-gray text-15-pt medium line-24">
            Possível reagendamento até 24 horas antes do ínicio previsto da aula.
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</section>
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
          eventSources: [
            {
              url: '{{ route('sistema.alunos.aovivo.agendar.pagas.disponibilidade.professor', [$agendamento->id, $professor->id, $aula->id]) }}',
              method: 'POST',
              extraParams: {
                _token: "{{ csrf_token() }}",
              },
              failure: function() {
                alert('there was an error while fetching events!');
              },
              success: function(data){
                $('body').removeClass('load');
              },
              beforeSend: function() {
                $('body').addClass('load'); 
              },
            }

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
          eventClick: function(info) {
            if( info.event.extendedProps.a != false ){
              console.log('asdasdasd');
              preAgendamento(info.event.start, info.event.end, info.event.extendedProps.a, info.event.extendedProps.ag);
            }
          },
      });

      calendar.render();
      // $('#calendar').fullCalendar()
  })
</script>