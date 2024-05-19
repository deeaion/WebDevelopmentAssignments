document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 0;

    function fetchData(page) {
        fetch(`retrieve_data.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }

                const tableBody = document.getElementById('table-body');
                tableBody.innerHTML = '';

                data.personal_info.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td>${item.nume}</td>
                                             <td>${item.prenume}</td>
                                             <td>${item.telefon}</td>
                                             <td>${item.email}</td>`;
                    tableBody.appendChild(row);
                });

                document.getElementById('prev').disabled = page <= 0;
                document.getElementById('next').disabled = (page + 1) * 3 >= data.total;
            })
            .catch(error => console.error('Error:', error));
    }

    document.getElementById('prev').addEventListener('click', function() {
        if (currentPage > 0) {
            currentPage--;
            fetchData(currentPage);
        }
    });

    document.getElementById('next').addEventListener('click', function() {
        currentPage++;
        fetchData(currentPage);
    });

    fetchData(currentPage);
});