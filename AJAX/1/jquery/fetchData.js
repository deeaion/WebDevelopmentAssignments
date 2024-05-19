
$(document).ready(function() {  loadDepartures(); });
function loadDepartures() {
    $.ajax({
        url: 'find_departures.php',
        method: 'GET',
        success: function(response) {
            const departures = JSON.parse(response);
            const $departureList = $('#departure');
            departures.forEach(function(departure) {
                const $option = $('<option>').val(departure).text(departure);
                $departureList.append($option);
            });
        }
    });
}

function updateArrival() {
    const departure = $('#departure').val();
    const $arrival = $('#arrival');
    $arrival.empty();

    if (departure === '') {
        const $emptyMessage = $('<li>').text('Selecteaza o statie de plecare');
        $arrival.append($emptyMessage);
        return;
    }

    $.ajax({
        url: `find_destinations.php?departure=${encodeURIComponent(departure)}`,
        method: 'GET',
        success: function(response) {
            const arrivals = JSON.parse(response);
            if (arrivals.length === 0) {
                const $emptyMessage = $('<li>').text('No arrivals found');
                $arrival.append($emptyMessage);
            } else {
                arrivals.forEach(function(arrivalStation) {
                    const $listItem = $('<li>').text(arrivalStation);
                    $arrival.append($listItem);
                });
            }
        }
    });
}