$(document).ready(function() {

    var dealId; // Declare the dealId variable in a higher scope

    $('button[data-bs-target="#deleteApplicationModal"]').on('click', function () {
        // Retrieve the deal_id value from the clicked button and store it in the dealId variable
        dealId = $(this).data('deal-id');
    });

// Get the CSRF token from the meta tag
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    var csrfInput = document.createElement('input');
    csrfInput.name = '_token'; // This is the default name for Laravel's CSRF token field
    csrfInput.value = csrfToken;
    $('#confirmDeleteButton').on('click', function () {
        $.ajax({
            type: 'POST',
            url: '/applications/' + dealId,
            data: {
                _token: csrfToken
            },
            success: function (data) {
                // Handle success, e.g., remove the application from the DOM
                $('#deleteApplicationModal').modal('hide');

                window.location.href = '/applications';

            },
            error: function (error) {
                // Handle error, e.g., show an error message
                console.error(error.responseJSON.message);
            }
        });
    });
});

// Get the deal ID you want to delete (you may need to customize this part)



    // Send a request to your API to delete the deal
    $.ajax({
        url: '/api/deals/' + dealId, // Replace with your API endpoint
        type: 'DELETE',
        success: function (response) {
            // Handle success, e.g., display a success message
            console.log('Deal deleted successfully');
            // Close the modal
            $('#confirmDeleteModal').modal('hide');
        },
        error: function (error) {
            // Handle error, e.g., display an error message
            console.error('Error deleting deal:', error);
        }
    });
