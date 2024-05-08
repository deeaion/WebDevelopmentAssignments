$(document).ready(function() {
    var $table = $('#verticalTable');

    // Attach a click event listener to all header cells in the first column
    $table.find('tr th').on('click', function() {
        var $header = $(this);
        var rowIndex = $header.closest('tr').index();
        var asc = !$header.hasClass('asc');  // Determine sort direction

        // Toggle ascending/descending classes
        $header.toggleClass('asc', asc).toggleClass('desc', !asc);

        // Collect the columns as arrays of cells
        var $rows = $table.find('tr');
        var columns = [];
        $rows.each(function() {
            $(this).children('td, th').each(function(index) {
                columns[index] = columns[index] || [];
                columns[index].push(this);
            });
        });

        // Sort the columns based on the values in the clicked header's row
        var sortedColumns = columns.slice(1).sort(function(a, b) {  // Skip the header column
            var aValue = $(a[rowIndex]).text();
            var bValue = $(b[rowIndex]).text();
            aValue = isNaN(aValue) ? aValue.toLowerCase() : parseFloat(aValue);
            bValue = isNaN(bValue) ? bValue.toLowerCase() : parseFloat(bValue);
            return (aValue > bValue ? 1 : aValue < bValue ? -1 : 0) * (asc ? 1 : -1);
        });

        // Re-append the cells in sorted order
        $rows.each(function(rowIdx) {
            var $row = $(this);
            $row.children('td, th').not(':first-child').remove();  // Remove all but the first column
            sortedColumns.forEach(function(col) {
                $row.append(col[rowIdx]);
            });
        });
    });
});
