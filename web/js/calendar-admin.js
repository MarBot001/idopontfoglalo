document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'hu',
        firstDay: 1,
        height: 'auto',
        slotMinTime: '08:00:00',
        slotMaxTime: '16:00:00',
        slotDuration: '01:00:00',
        slotLabelInterval: '01:00:00',
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            omitZeroMinute: false,
            meridiem: false
        },
        allDaySlot: false,
        weekends: false,
        selectable: false, // adminban nem foglalunk, csak nézünk
        editable: false,
        eventOverlap: false,
        eventColor: '#ff4d4d',
        eventTextColor: '#fff',
        headerToolbar: {
            start: 'prev,next,today',
            center: 'title',
            end: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: '/site/get-events',
    
        eventClick: function (info) {
            window.location.href = '/admin/view?id=' + info.event.id;
        },
        dayHeaderContent: function (args) {
            let date = args.date;
            let formattedDate = date.toLocaleDateString('hu-HU', {
                month: '2-digit',
                day: '2-digit'
            });
            let weekday = date.toLocaleDateString('hu-HU', {
                weekday: 'long'
            });
            return {
                html: formattedDate + '<br>' + weekday
            };
        }
    });

    calendar.render();
});