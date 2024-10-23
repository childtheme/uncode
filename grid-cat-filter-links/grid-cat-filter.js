
jQuery(document).ready(function($) {
    // Ensure that the gridCatData object is passed from the server-side
    if (typeof gridCatData !== 'undefined' && gridCatData.catLinks) {
        // Iterate over each data-filter link
        $('[data-filter]').each(function() {
            var filterValue = $(this).attr('data-filter');
            // Check if the filter value has a corresponding URL
            if (gridCatData.catLinks[filterValue]) {
                // Add a click event to redirect to the corresponding URL
                $(this).on('click', function(e) {
                    e.preventDefault(); // Prevent default anchor behavior
                    window.location.href = gridCatData.catLinks[filterValue]; // Redirect to the URL
                });
            }
        });
    }
});
