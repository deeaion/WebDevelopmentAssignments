$(document).ready(function() {
    let currentPage = 0;
    function fetchData(page) {
        $.getJSON(
            `retrieve_data.php?page=${page}`,
            function(data){
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                const tableBody = $('#table-body');
                tableBody.empty();

                data.personal_info.forEach(item => {
                    const row = $('<tr></tr>');
                    row.html(`<td>${item.nume}</td>
                                 <td>${item.prenume}</td>
                                 <td>${item.telefon}</td>
                                 <td>${item.email}</td>`);
                    tableBody.append(row);
                });

                $('#prev').prop('disabled', page <= 0);
                $('#next').prop('disabled', (page + 1) * 3 >= data.total);
            }
        );
    }

    $('#prev').on('click', function() {
        if (currentPage > 0) {
            currentPage--;
            fetchData(currentPage);
        }
    });

    $('#next').on('click', function() {
        currentPage++;
        fetchData(currentPage);
    });

    fetchData(currentPage);
});


