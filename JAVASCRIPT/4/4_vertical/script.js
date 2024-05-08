document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('verticalTable');
    const headers = table.querySelectorAll('tr th'); // assuming headers are in `th` elements in the first column

    function sortTableByRow(header) {
        const rowIndex = header.parentNode.rowIndex;
        const asc = !header.classList.contains('asc');  // Toggle the sorting direction
        header.classList.toggle('asc', asc);
        header.classList.toggle('desc', !asc);

        // Gather all columns in an array of arrays, skipping the header column
        const rows = Array.from(table.rows);
        let columns = Array.from({length: rows[0].cells.length}, (_, i) => rows.map(row => row.cells[i]));

        // We'll sort starting from the second cell in each row to skip headers
        columns = columns.slice(1);

        // Sort the column based on the values in the selected row's column
        columns.sort((a, b) => {
            const aValue = isNaN(a[rowIndex].textContent) ? a[rowIndex].textContent.toLowerCase() : parseFloat(a[rowIndex].textContent);
            const bValue = isNaN(b[rowIndex].textContent) ? b[rowIndex].textContent.toLowerCase() : parseFloat(b[rowIndex].textContent);
            return asc ? (aValue > bValue ? 1 : -1) : (aValue < bValue ? 1 : -1);
        });

        // Reconstruct each row with the new column order, leaving the header in place
        rows.forEach((row, i) => {
            // Append each sorted column back to its row, skipping the first cell
            columns.forEach(col => {
                if (row.cells[col[i]] !== row.cells[0]) { // Check to avoid moving the header cell
                    row.appendChild(col[i]);
                }
            });
        });
    }

    // Attach click event listeners to all header cells in the first column
    headers.forEach(header => {
        header.addEventListener('click', () => sortTableByRow(header));
    });
});
