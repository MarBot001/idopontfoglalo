document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var selectedEvent = null;

  // Aktuális dátum
  var today = new Date();

  // 10 nappal későbbi dátum
  var tenDaysFromToday = new Date();
  tenDaysFromToday.setDate(today.getDate() + 14);

  var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridDay', // Napi időalapú nézet
      contentHeight: 'auto', // Automatikus magasság
      height: 'auto',
      locale: 'hu', // Magyar nyelv
      firstDay: 1, // Hétfő az első nap
      weekends: false, // Hétvége elrejtése
      slotMinTime: '08:00:00', // Kezdő időpont
      slotMaxTime: '17:00:00', // Záró időpont
      slotDuration: '01:00:00', // Félórás intervallumok
      slotLabelInterval: '01:00:00', // Félórás időbélyegek
      slotLabelFormat: {
          hour: '2-digit',
          minute: '2-digit',
          omitZeroMinute: false,
          meridiem: 'short',
      },
      validRange: {
        start: today.toISOString().split('T')[0], // Mai nap
        end: tenDaysFromToday.toISOString().split('T')[0], // 10 nap múlva
    },
      allDaySlot: false, // Egész napos események elrejtése
      selectable: true, // Kiválasztható időpontok
      editable: false, // Időpontok nem mozgathatók
      events: '/appointment/get-events', // Események betöltése
      eventOverlap: true, // Az események nem fedhetik egymás
      eventColor: '#ff4d4d',
      eventTextColor: '#fff',
      headerToolbar: {
          start: 'title', 
          center: '', 
          end: 'prev,next',
      },
      dateClick: function (info) {
          // Idő és dátum kivonása
          var selectedDateTime = info.dateStr;
          var dateParts = selectedDateTime.split('T');
          var date = dateParts[0];
          var time = dateParts[1].substring(0, 5);

          // Beállítjuk az űrlap mezőiben az értéket
          document.getElementById('selected-date').value = date;
          document.getElementById('selected-time').value = time;


          if (selectedEvent) {
            calendar.getEventById('selected').remove();
        }

        // Új esemény hozzáadása a kijelöléshez
        selectedEvent = calendar.addEvent({
            id: 'selected', // Egyedi azonosító
            title: 'Kiválasztott időpont',
            start: selectedDateTime,
            end: new Date(new Date(selectedDateTime).getTime() + 60 * 60 * 1000).toISOString(), // Fél óra hosszú esemény
            backgroundColor: '#4caf50', // Zöld szín
            borderColor: '#4caf50', // Zöld szegély
            textColor: '#fff' // Fehér szöveg
        });
      },
  });
  calendar.render();
});


/*document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "timeGridDay", // Napi nézet
    contentHeight: "auto", // Automatikus magasság
    height: "auto",
    locale: "hu", // Magyar nyelv
    firstDay: 1, // Hétfő az első nap
    slotMinTime: "08:00:00", // Kezdő időpont
    slotMaxTime: "16:00:00", // Záró időpont
    allDaySlot: false, // Egész napos események elrejtése
    selectable: true, // Kattintható időpontok
    editable: false, // Időpontok nem mozgathatóak
    events: "/appointment/get-events", // Események betöltése
    eventColor: "#ff4d4d",
    eventTextColor: "#fff",
    headerToolbar: {
      start: "title", // Navigációs gombok
      center: "", // Cím középen
      end: "prev,next", // Nézetváltók
    },
    validRange: {
        start: new Date().toISOString().split('T')[0], // Mai nap
        end: new Date(new Date().setDate(new Date().getDate() + 10)).toISOString().split('T')[0] // 10 nap múlva
    },
    scrollTime: "08:00:00", // Görgetés kezdő pozíciója
    dateClick: function (info) {
      // Csak a dátumot vesszük ki (idő nélkül)
      var selectedDate = info.dateStr.split("T")[0];

      // Dátum elhelyezése az űrlap mezőjébe
      document.getElementById("selected-date").value = selectedDate;

      // Megjelenítjük az űrlapot
      document.getElementById("booking-form").style.display = "block";

      // Felugró visszajelzés (opcionális)
      alert("Kiválasztott dátum: " + selectedDate);
    },
  });
  calendar.render();
});*/
