function searchTable() {
    var input, filter, table, tbody, tr, td, i, j, txtValue;
    input = document.getElementById('searchInput1');
    filter = input.value.trim().toUpperCase();
    table = document.getElementById('dataTable1');
    tbody = table.querySelector('tbody');
    tr = tbody.getElementsByTagName('tr');
    var noResultsRow = document.getElementById('noResultsRow');

    if (!noResultsRow) {
        // Create a new row for displaying no results
        noResultsRow = tbody.insertRow();
        noResultsRow.id = 'noResultsRow';

        var cell = noResultsRow.insertCell();
        cell.colSpan = table.rows[0].cells.length; // Span the entire row
        cell.textContent = 'Aucun résultat correspondant trouvé.';

    }

    var showNoResults = true; // Assume no results initially

    for (i = 0; i < tr.length; i++) {
        let rowDisplay = 'none';

        for (j = 0; j < tr[i].getElementsByTagName('td').length; j++) {
            td = tr[i].getElementsByTagName('td')[j];

            if (td) {
                txtValue = td.textContent || td.innerText;

                if (txtValue.trim().toUpperCase().includes(filter)) {
                    rowDisplay = '';
                    showNoResults = false; // There is at least one result
                    break;
                }
            }
        }

        tr[i].style.display = rowDisplay;
    }

    // Toggle visibility of the no results row
    noResultsRow.style.display = showNoResults ? '' : 'none';
}
