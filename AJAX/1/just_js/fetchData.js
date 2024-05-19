document.addEventListener('DOMContentLoaded', function() {
  loadDepartures();
});

function loadDepartures() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'find_departures.php', true);
    xhr.onload= function()
    {
        if(this.status === 200)
        {
            //inseamna ca totul a mers bine
            var departures = JSON.parse(this.responseText);
            var departureList=document.getElementById('departure');
            departures.forEach(function (departure) {
                var option = document.createElement('option');
                option.value= departure;
                option.textContent= departure;
                departureList.appendChild(option);
            });
        }
    };
    xhr.send();
}
function updateArrival() {
    var departure = document.getElementById('departure').value;
    console.log(departure);
    var arrival = document.getElementById('arrival');
    console.log(arrival);
    if (departure === '') {
        var emptyMessage = document.createElement('li');
        emptyMessage.textContent = 'Selecteaza o statie de plecare';
        arrival.appendChild(emptyMessage);
        return;
    }
    var xhr = new XMLHttpRequest();
    xhr.open('GET', `find_destinations.php?departure=${encodeURIComponent(departure)}`, true);
    xhr.onload = function() {
        if (this.status === 200) {
            arrival.innerHTML = '';
            var arrivals = JSON.parse(this.responseText);
            if (arrivals.length === 0) {
                var emptyMessage = document.createElement('li');
                emptyMessage.textContent = 'No arrivals found';
                arrival.appendChild(emptyMessage);
            } else {
                arrivals.forEach(function(arrivalStation) {
                    var listItem = document.createElement('li');
                    listItem.textContent = arrivalStation;
                    arrival.appendChild(listItem);
                });
            }
        }
    };
    xhr.send();
}