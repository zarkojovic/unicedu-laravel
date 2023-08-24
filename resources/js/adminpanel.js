console.log("adminnnn")



$(document).ready(function() {
    let searchTimeout;
    // Fetch initial data and populate the dropdown
    fetchDropdownData("");

    $("#search-fields").on("input", function() {
        clearTimeout(searchTimeout);
        let query = $(this).val();
        searchTimeout = setTimeout(function() {
            fetchDropdownData(query);
        }, 400);
    });

    //FILL IN INPUT TEXT
    $("#search-list").on("change", function() {
        let selectedText = $(this).find("option:selected").text();

        $("#search-fields").val(selectedText);
    });
});

function fetchDropdownData(query) {
    $.ajax({
        url: "/search-dropdown",
        method: "get",
        data: {"search": query},
        success: function(result) {
            $("#search-list").html(result);

            let numOptions = $("#search-list option").length;
            numOptions = Math.min(numOptions, 10); // Limit to a maximum of 10 options
            $("#search-list").attr("size", numOptions);
        },
        error: function() {
            // Handle AJAX error here
            console.error("Failed to retrieve search results.");

            // Reset the dropdown to show all options
            $("#search-list").attr("size", $("#search-list option").length);
        }
    });

    const icons = document.querySelectorAll('.panel-field-settings');
    const checkboxesArray = document.querySelectorAll('.checkboxes');

    icons.forEach((icon, index) => {
        icon.addEventListener('click', () => {
            event.stopPropagation();
            checkboxesArray[index].style.display = 'block';
        });
    });

    // Close checkboxes when clicking outside
    document.addEventListener('click', (event) => {
        checkboxesArray.forEach((checkboxes) => {
            if (!checkboxes.contains(event.target) && !icons[index].contains(event.target)) {
                checkboxes.style.display = 'none';
            }
        });
    });
};
