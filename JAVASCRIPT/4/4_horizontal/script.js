document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('horizontalTable');
    const headers = table.querySelectorAll('th');

    headers.forEach((header, index) => {
        header.addEventListener('click', () => {
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const isAscending = header.classList.toggle('ascending');

            rows.sort((a, b) => {
                const aValue = a.cells[index].textContent;
                const bValue = b.cells[index].textContent;

                return isAscending ? aValue.localeCompare(bValue, undefined, {numeric: true}) : bValue.localeCompare(aValue, undefined, {numeric: true});
            });

            while (tbody.firstChild) tbody.removeChild(tbody.firstChild);
            rows.forEach(row => tbody.appendChild(row));
        });
    });
});
