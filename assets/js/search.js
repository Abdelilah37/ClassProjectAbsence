var timeoutId;

$('#searchInput').on('input', function () {
    // Show loading indicator
    $('#loadingIndicator').show();

    clearTimeout(timeoutId);
    var searchTerm = $(this).val();

    if (searchTerm.length >= 3) {
        timeoutId = setTimeout(function () {
            // Make the AJAX request here
            $.ajax({
                type: 'POST',
                url: 'SearchConfig.php',
                data: { searchTerm: searchTerm },
                success: function (response) {
                    // Hide loading indicator
                    $('#loadingIndicator').hide();
                    // Update the results container
                    $('#searchResults').html(response).show();
                },
                error: function () {
                    // Handle errors
                    $('#loadingIndicator').hide();
                    $('#searchResults').html('<p>Error loading search results.</p>').show();
                }
            });
        }, 300);
    } else {
        // Hide loading indicator and clear results
        $('#loadingIndicator').hide();
        $('#searchResults').html('').hide();
    }
});

