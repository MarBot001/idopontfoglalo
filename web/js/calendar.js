document.addEventListener("DOMContentLoaded", function () {
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
});
