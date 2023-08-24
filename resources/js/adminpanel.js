console.log("adminnnn")



$(document).ready(function() {
    // const icons = $('.panel-field-settings');
    // let openCheckboxes = null;
    //
    // icons.click(function (event) {
    //     event.stopPropagation();
    //
    //     const clickedIcon = $(this);
    //     console.log(clickedIcon.attr('id'));
    //
    //     if (openCheckboxes && openCheckboxes.prev().is(clickedIcon)) {
    //         openCheckboxes.remove();
    //         openCheckboxes = null;
    //         return;
    //     }
    //
    //     if (openCheckboxes) {
    //         openCheckboxes.remove();
    //     }
    //
    //     const checkboxesHTML = `
    //     <div class="checkboxes">
    //         <input type="checkbox" id="${clickedIcon.data('fieldName')}" value="${clickedIcon.data('fieldId')}" name="fields[]">
    //         <label for="${clickedIcon.data('fieldName')}">Is Active</label>
    //     </div>`;
    //
    //     clickedIcon.after(checkboxesHTML);
    //     openCheckboxes = clickedIcon.next('.checkboxes');
    // });
    //


    // $(".panel-field-settings").click(function(){
    //     let icon = $(this);
    //     icon.next().removeClass("d-none");
    //     icon.next().addClass("d-block");
    //
    // });

    // $(document).on('click', function (event) {
    //     if (openCheckboxes && !$(event.target).closest('.checkboxes').length) {
    //         openCheckboxes.remove();
    //         openCheckboxes = null;
    //     }
    // });
    // const icons = document.querySelectorAll('.panel-field-settings');
    // const checkboxesArray = document.querySelectorAll('.checkboxes');
    let currentFieldIcon = null;

    $('.panel-field-settings').click(function (event) {
        const clickedFieldIcon = $(this);

        if (currentFieldIcon && currentFieldIcon.is(clickedFieldIcon)) {
            currentFieldIcon.next().removeClass("d-block");
            currentFieldIcon.next().addClass("d-none");
            currentFieldIcon = null;
            return;
        }

        if (currentFieldIcon && currentFieldIcon !== clickedFieldIcon) {
            currentFieldIcon.next().removeClass("d-block");
            currentFieldIcon.next().addClass("d-none");
            currentFieldIcon = null;
        }

        //IF DROPDOWN SEARCH DOESN'T ALREADY EXIST MAKE IT
        clickedFieldIcon.next().removeClass("d-none");
        clickedFieldIcon.next().addClass("d-block");

        // OVDE BOJI


        // clickedFieldIcon.after(html);
        currentFieldIcon = clickedFieldIcon;

        // Fetch initial data and populate the dropdown
        // fetchDropdownData("");


        event.stopPropagation();
    });

    $(document).on('click', function (event) {
        const clickedFieldIcon = currentFieldIcon; // Assuming currentFieldIcon is defined elsewhere

        if (!$(event.target).closest('.checkboxes').length) {
            clickedFieldIcon.next().removeClass("d-block");
            clickedFieldIcon.next().addClass("d-none");
            currentFieldIcon = null;
        }
    });


    function fetchDropdownData(query) {
        $.ajax({
            url: "/search-dropdown",
            method: "get",
            data: {"search": query},
            success: function (result) {
                $("#search-list").html(result);

                let numOptions = $("#search-list option").length;
                numOptions = Math.min(numOptions, 10); // Limit to a maximum of 10 options
                $("#search-list").attr("size", numOptions);
            },
            error: function () {
                // Handle AJAX error here
                console.error("Failed to retrieve search results.");

                // Reset the dropdown to show all options
                $("#search-list").attr("size", $("#search-list option").length);
            }
        });


        // icons.forEach((icon, index) => {
        //     icon.addEventListener('click', () => {
        //         event.stopPropagation();
        //         checkboxesArray[index].style.display = 'block';
        //     });
        // });

        // Close checkboxes when clicking outside
        // document.addEventListener('click', (event) => {
        //     checkboxesArray.forEach((checkboxes) => {
        //         if (!checkboxes.contains(event.target) && !icons[index].contains(event.target)) {
        //             checkboxes.style.display = 'none';
        //         }
        //     });
        // });


    }
})
