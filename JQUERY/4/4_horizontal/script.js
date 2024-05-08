$(document).ready(function() {
    const $table = $('#horizontalTable');
    const $headers = $table.find('th');

    $headers.each(function(index) {
        $(this).on('click', function() {
            const $tbody = $table.find('tbody');
            const $rows = $tbody.find('tr').toArray();
            const isAscending = $(this).toggleClass('ascending').hasClass('ascending');

            $rows.sort((a, b) => {
                const aValue = $(a).find('td').eq(index).text();
                const bValue = $(b).find('td').eq(index).text();

                return isAscending ? aValue.localeCompare(bValue, undefined, { numeric: true }) :
                    bValue.localeCompare(aValue, undefined, { numeric: true });
            });

            $.each($rows, function(_, row) {
                $tbody.append(row);
            });
        });
    });
});
