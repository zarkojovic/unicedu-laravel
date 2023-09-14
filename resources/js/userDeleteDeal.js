$(document).ready(function() {

    //var dealId; // Declare the dealId variable in a higher scope

    $('button[data-bs-target="#deleteApplicationModal"]').on('click', function () {
        // Retrieve the deal_id value from the clicked button and store it in the dealId variable
        let dealId = $(this).data('deal-id');
        // console.log(dealId)
        // if(!$('#confirmDeleteButton').data('deal_id')) {
        let hidden;
        $("#dealId").val(dealId);

            // $('#confirmDeleteButton').data('deal_id', dealId);
            // console.log('dodeljen');
        // $('#deleteDealForm').submit();
        // }
    });

    // $('#confirmDeleteButton').on('submit', function(event) {
    //     // event.preventDefault();
    //     // if(!$('#confirmDeleteButton').data('deal-id')) {
    //     //     $('#confirmDeleteButton').data('deal-id', dealId);
    //         console.log('dodeljen');
    //         $('#deleteDealForm').submit();
    //     }
    // });




// Get the CSRF token from the meta tag
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    var csrfInput = document.createElement('input');
    csrfInput.name = '_token'; // This is the default name for Laravel's CSRF token field
    csrfInput.value = csrfToken;
    // $('#confirmDeleteButton').on('click', function () {
    //     $.ajax({
    //         type: 'POST',
    //         url: '/applications/' + dealId,
    //         data: {
    //             _token: csrfToken
    //         },
    //         success: function (data) {
    //             // Handle success, e.g., remove the application from the DOM
    //             console.log(data.result);
    //             $('#deleteApplicationModal').modal('hide');
    //
    //
    //             showToast('Application removed successfully', 'success');
    //
    //         },
    //         error: function (xhr, message, status) {
    //             // Handle error, e.g., show an error message
    //             console.error(xhr, message, status);
    //             showToast('An error occurred while deleting an application', 'error');
    //
    //             $('#deleteApplicationModal').modal('hide');
    //         }
    //     });
    // });
});

function showToast(message, type) {
    if (type === "error") {
        $('#myAlert').hide().addClass("bg-danger text-white")
            .fadeIn().html(message)
            .delay(10000).fadeOut();

    } else {
        $('#myAlert').hide().removeClass("bg-danger text-white")
            .fadeIn().html(message)
            .delay(3000).fadeOut();
    }
}


