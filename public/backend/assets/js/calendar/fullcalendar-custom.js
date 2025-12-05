document.addEventListener('DOMContentLoaded', function() {
    /* initialize the external events
    -----------------------------------------------------------------*/

    var containerEl = document.getElementById('external-events-list');
    new FullCalendar.Draggable(containerEl, {
      itemSelector: '.fc-event',
      eventData: function(eventEl) {
        return {
          title: eventEl.innerText.trim()
        }
      }
    });
  
    let today_date = '';
    let eventLists = '';
    calendarData();
    function calendarData(){
      $.ajax({
        url: calendarDatesInfo,
        type: "POST",
        data: { fetch:1},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          today_date = response.today;
          eventLists = response.dates;
          drawCalendar();
        }
      });
    }
    /* initialize the calendar
    -----------------------------------------------------------------*/

    function drawCalendar(){
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        initialView: 'dayGridMonth',
        initialDate: today_date,
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        selectable: true,
        nowIndicator: true,
        // dayMaxEvents: true, // allow "more" link when too many events
        events: eventLists,
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function(arg) {
          // is the "remove after drop" checkbox checked?
          if (document.getElementById('drop-remove').checked) {
            // if so, remove the element from the "Draggable Events" list
            arg.draggedEl.parentNode.removeChild(arg.draggedEl);
          }
        }
      });
      calendar.render();
    }
  });