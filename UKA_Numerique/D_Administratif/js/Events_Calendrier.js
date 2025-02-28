

        document.addEventListener("DOMContentLoaded", function() {
       
            calendrier_mise_a_jr();
       
        });

  
        
  function calendrier_mise_a_jr() {
    var calendarEl = document.getElementById('calendrier');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'fr', // Localisation en français
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        buttonText: {
            today: "Aujourd'hui",
            month: 'Mois',
            week: 'Semaine',
            day: 'Jour',
            list: 'Agenda'
        },
        events: {
            url: 'D_Administratif/API/API_Select_Events.php', // URL de votre source d'événements
            method: 'GET', // Méthode HTTP à utiliser
            failure: function() {
                alert('Erreur de chargement des événements !'); // Message d'erreur en cas d'échec
            }
        },
        views: {
            dayGridMonth: {
                titleFormat: { year: 'numeric', month: 'long' }
            },
            dayGrid: {
                dayCellContent: function(e) {
                    e.dayNumberText = e.dayNumberText.replace(' ', '');
                }
            }
        }
    });
    calendar.render();
}


    