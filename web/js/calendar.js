document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var selectedEvent = null;
  
    var today = new Date();
    var tomorrow = new Date();
    tomorrow.setDate(today.getDate() + 1);
  
    var fourteenDaysLater = new Date();
    fourteenDaysLater.setDate(today.getDate() + 14);
  
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGrid',
      duration: { days: 3 },
      initialDate: tomorrow,
      contentHeight: 'auto',
      height: 'auto',
      locale: 'hu',
      firstDay: tomorrow.getDay(),
      weekends: false,
      slotMinTime: '08:00:00',
      slotMaxTime: '16:00:00',
      slotDuration: '01:00:00',
      slotLabelInterval: '01:00:00',
      slotLabelFormat: {
        hour: '2-digit',
        minute: '2-digit',
        omitZeroMinute: false,
        meridiem: 'short',
      },
      validRange: {
        start: tomorrow,
        end: fourteenDaysLater,
      },
      dayHeaderContent: function (args) {
        let date = args.date;
        let formattedDate = date.toLocaleDateString('hu-HU', { month: '2-digit', day: '2-digit' });
        let weekday = date.toLocaleDateString('hu-HU', { weekday: 'long' });
        return { html: formattedDate + '<br>' + weekday };
      },
      allDaySlot: false,
      selectable: true,
      editable: false,
      events: '/site/get-events',
      eventOverlap: true,
      eventColor: '#ff4d4d',
      eventTextColor: '#fff',
      headerToolbar: {
        start: '',
        center: '',
        end: 'prev,next',
      },
      dateClick: function (info) {
        var selectedDateTime = info.dateStr;
        var dateParts = selectedDateTime.split('T');
        var date = dateParts[0];
        var time = dateParts[1].substring(0, 5);
  
        document.getElementById('selected-date').value = date;
        document.getElementById('selected-time').value = time;
  
        if (selectedEvent) {
          calendar.getEventById('selected').remove();
        }
  
        selectedEvent = calendar.addEvent({
          id: 'selected',
          title: 'Kiválasztott időpont',
          start: selectedDateTime,
          end: new Date(new Date(selectedDateTime).getTime() + 60 * 60 * 1000).toISOString(),
          backgroundColor: '#4caf50',
          borderColor: '#4caf50',
          textColor: '#fff'
        });
      }
    });
  
    calendar.render();
  
    const toolbarChunk = calendarEl.querySelector('.fc-toolbar-chunk:first-child');
    if (toolbarChunk) {
      toolbarChunk.innerHTML = '<div style="font-weight: bold; font-size: 25px;">Időpont kiválasztása</div>';
    }
  });
  