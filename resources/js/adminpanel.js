console.log("adminnnn")



$(document).ready(function() {
    const icons = document.querySelectorAll('.panel-field-settings');
    const checkboxesArray = document.querySelectorAll('.checkboxes');
    let currentFieldIcon = null;

    $('.panel-field-settings').click(function(event) {
        const clickedFieldIcon = $(this);
        console.log("clickd")

        if (currentFieldIcon && currentFieldIcon.is(clickedFieldIcon)) {
            currentFieldIcon.next('#search-dropdown').remove();
            currentFieldIcon = null;
            return;
        }

        if (currentFieldIcon && currentFieldIcon !== clickedFieldIcon) {
            currentFieldIcon.next('#checkboxes-container').remove();
            currentFieldIcon = null;
        }

        //IF DROPDOWN SEARCH DOESN'T ALREADY EXIST MAKE IT
        if (!$('#checkboxes-container').length) {
            if (clickedFieldIcon.next().attr('id') !== 'checkboxes-container') {
                const html = `
                        <div class="checkboxes" id="checkboxes-container">
                            <input type="checkbox" id="{{$field->field_name}}"
                                   value="{{$field->field_id}}"
                                   name="fields[]" {{ $field->field_category_id === $category->field_category_id ? 'checked' : '' }}>
                            <label for="{{$field->field_name}}">Is Active</label>
                        </div>`;

                clickedFieldIcon.after(html);
                currentFieldIcon = clickedFieldIcon;

                // Fetch initial data and populate the dropdown
                fetchDropdownData("");
            }
        }
        event.stopPropagation();
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#checkboxes-container').length) {
            $('#checkboxes-container').remove();
            currentFieldIcon = null
        }
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
