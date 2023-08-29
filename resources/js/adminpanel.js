// import 'jquery';
// import 'jquery-ui';

$(document).ready(function() {
    let currentFieldIcon = null;

    //SHOW CHECKBOXES FOR FIELD SETTINGS
    $('.panel-field-settings').click(function (event) {
        const clickedFieldIcon = $(this);

        if (currentFieldIcon && currentFieldIcon.is(clickedFieldIcon)) {
            currentFieldIcon.next().removeClass("d-block");
            currentFieldIcon.next().addClass("d-none");
            clickedFieldIcon.removeClass("primary-color");
            currentFieldIcon = null;
            return;
        }

        if (currentFieldIcon && currentFieldIcon !== clickedFieldIcon) {
            currentFieldIcon.next().removeClass("d-block");
            currentFieldIcon.next().addClass("d-none");
            currentFieldIcon.removeClass("primary-color");

            currentFieldIcon = null;
        }

        //IF DROPDOWN SEARCH DOESN'T ALREADY EXIST MAKE IT
        clickedFieldIcon.next().removeClass("d-none");
        clickedFieldIcon.next().addClass("d-block");

        // OVDE BOJI
        clickedFieldIcon.addClass("primary-color");

        // clickedFieldIcon.after(html);
        currentFieldIcon = clickedFieldIcon;

        // Fetch initial data and populate the dropdown
        // fetchDropdownData("");


        event.stopPropagation();
    });

    //HIDE FIELD SETTINGS
    $(document).on('click', function (event) {
        const clickedFieldIcon = currentFieldIcon; // Assuming currentFieldIcon is defined elsewhere

        if (clickedFieldIcon){
            if (!$(event.target).closest('.checkboxes').length) {
                clickedFieldIcon.next().removeClass("d-block"); //OVDE IZLAZI ERROR ALI RADI
                clickedFieldIcon.next().addClass("d-none");
                clickedFieldIcon.removeClass("primary-color");
                currentFieldIcon = null;
            }
        }
    });

    //ADD NEW FIELD
    let currentCategory = null; // To keep track of the currently focused category
    let clickedCategory = null;
    $('.add-category').click(function(event) {
        clickedCategory = $(this);

        if (currentCategory && currentCategory.is(clickedCategory)) {
            currentCategory.next('#search-dropdown').remove();
            currentCategory = null;
            return;
        }

        if (currentCategory && currentCategory !== clickedCategory) {
            currentCategory.next('#search-dropdown').remove();
            currentCategory = null;
        }

        //IF DROPDOWN SEARCH DOESN'T ALREADY EXIST MAKE IT
        if (!$('#search-dropdown').length) {
            if (clickedCategory.next().attr('id') !== 'search-dropdown') {
                const html = `
                        <div class="container d-block" id="search-dropdown">
                            <div class="row justify-content-center">
                                <div class="col-12 search-parent">
                                    <form action="search-dropdown" class="search-dropdown w-100" autocomplete="off">
                                        <input type="text" name="search-fields" id="search-fields" autocomplete="off" class="d-block w-100 form-control"/>
                                        <select id="search-list" class="w-100 form-select scrollbar" size="10"></select>
                                    </form>
                                </div>
                            </div>
                        </div>`;

                clickedCategory.after(html);
                currentCategory = clickedCategory;

                // Fetch initial data and populate the dropdown
                fetchDropdownData("");
            }
        }
        event.stopPropagation();
    });

    //REMOVE DROPDOWN SEARCH OFF FOCUS
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#search-dropdown').length) {
            $('#search-dropdown').remove();
            currentCategory = null
        }
    });

    let searchTimeout;

    // Event delegation for input change event
    $(document).on("input", "#search-fields", function() {
        clearTimeout(searchTimeout);
        let query = $(this).val();
        searchTimeout = setTimeout(function() {
            fetchDropdownData(query);
        }, 400);
    });

    // Event delegation for select change event
    $(document).on("change", "#search-list", function() {
        let selectedOption = $(this).find("option:selected");
        let selectedValue = selectedOption.val();
        let selectedText = selectedOption.text();

        let data = {
            "field_id": selectedValue,
            "field_category_id": clickedCategory.attr("id")
        };

        ajaxCallback("/search-update","post",data, function (result) {
            location.reload();
            console.log("uspeh");
        }), function (xhr,message,status) {
            console.log(message, status);
        }

        $("#search-fields").val(selectedText);
        // Remove #search-dropdown
        currentCategory.next('#search-dropdown').remove();
        currentCategory = null;
    });

    //DRAG AND DROP FIELDS
    $(".row-sortable").sortable({
        start: function (event, ui) {
            // Get the initial cursor position
            const initialCursorPos = ui.helper.offset();

            // Store the initial cursor position in data attribute
            ui.helper.data("initialCursorPos", initialCursorPos);

            console.log(initialCursorPos, ui.helper.data("initialCursorPos"))
        },
        // change: function (event, ui) {
        //     // Calculate the difference between initial cursor position and placeholder position
        //     const initialCursorPos = ui.helper.data("initialCursorPos");
        //     const placeholderPos = ui.placeholder.offset();
        //     const diffTop = initialCursorPos.top - placeholderPos.top;
        //     const diffLeft = initialCursorPos.left - placeholderPos.left;
        //
        //     // Adjust the position of the helper element
        //     ui.helper.css({
        //         top: ui.position.top + diffTop,
        //         left: ui.position.left + diffLeft,
        //     });
        // },
        update: function (event,ui){
            console.log("dropped");
        },
        // helper: "clone",
    });
    $( ".row-sortable" ).disableSelection();

    const checkboxes = document.querySelectorAll('input[type="checkbox"][name^="fields["]');
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
            const parentDiv = this.closest(".sortable-item");
            if (parentDiv) {
                if (this.checked) {
                    parentDiv.classList.remove("to-remove");
                } else {
                    parentDiv.classList.add("to-remove");
                }
            }
        });
    });


});


function ajaxCallback(route,method,data,success,error=null){
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: route,
        method: method,
        data: data,
        headers: {
            "X-CSRF-Token": csrfToken // Include the CSRF token in the headers
        },
        success: success,
        error: error
    });
}

function fetchDropdownData(query) {
    ajaxCallback("/search-dropdown","get",{"search":query}, function(result) {
        $("#search-list").html(result);

        let numOptions = $("#search-list option").length;
        numOptions = Math.max(Math.min(numOptions, 10), 2); // Limit to a maximum of 10 options and min 2
        $("#search-list").attr("size", numOptions);
    }, function() {
        console.error("Failed to retrieve search results.");

        // Reset the dropdown to show all options
        $("#search-list").attr("size", $("#search-list option").length);
    })
}


