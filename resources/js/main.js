import axios from "axios";

function printHTML(el, val = null) {
    console.log(el)
    let html = '';
    var requiredSpan = `<span class="text-danger">*</span>`;
    // Handle CRM category field
    if (el.type === "crm_category" && el.field_name === "CATEGORY_ID") {
        html += `<label for="${el.field_name}">${el.formLabel ? el.formLabel : el.title} ${el.is_required ? requiredSpan : ''}</label>
                    <select class="form-control mb-3" name="${el.field_name}">
                    <option value="0">Select</option>`;

        el.items.forEach(item => {
            html += `<option value="${item.ID}">${item.NAME}</option>`;
        });

        html += `</select>`;
    }
    // Handle CRM status field
    else if (el.type === "crm_status" && el.statusType === "DEAL_STAGE") {
        html += `<label for="${el.field_name}">${el.formLabel ? el.formLabel : el.title}  ${el.is_required ? requiredSpan : ''}</label>
                <select class="form-control mb-3" name="${el.field_name}">
                <option value="0">Select</option>`;
        el.items.forEach(item => {
            html += `<option value="${item.STATUS_ID}">${item.NAME}</option>`;
        });

        html += `</select>`;
    }
    // Handle file input field
    else if (el.type === "file") {
        html += `<label for="${el.field_name}">${el.formLabel ? el.formLabel : el.title}  ${el.is_required ? requiredSpan : ''}</label>
                <br>
                <label class="upload-document-label mb-3" for="${el.field_name}"><span>Upload Document</span></label>
                <input type="file" id="${el.field_name}" name="${el.field_name}" value="${val != null ? val.value : ""}" data-field-id="${el.field_id}" class="form-control  d-none">`;
    }
    // Handle date input field
    else if (el.type === "date") {
        html += `<label for="${el.field_name}">${el.formLabel ? el.formLabel : el.title} ${el.is_required ? requiredSpan : ''}</label>
                <input type="date" name="${el.field_name}" value="${val != null ? val.value : ""}" data-field-id="${el.field_id}" class="form-control mb-3">`;
    }
    // Handle datetime input field
    else if (el.type === "datetime") {
        html += `<label for="${el.field_name}">${el.formLabel ? el.formLabel : el.title} ${el.is_required ? requiredSpan : ''}</label>
                <input type="datetime-local" value="${val != null ? val.value : ""}" data-field-id="${el.field_id}" name="${el.field_name}" class="form-control mb-3">`;
    }
    // Handle enumeration/select input field
    else if (el.type === "enumeration") {
        console.log(el.items)
        html += `<label for="${el.field_name}">${el.formLabel ? el.formLabel : el.title} ${el.is_required ? requiredSpan : ''}</label>
                <select class="form-control mb-3" data-field-id="${el.field_id}"  name="${el.field_name}">
                <option value="0">Select</option>`;

        el.items.forEach(item => {
            const isSelected = val != null && val.value === item.ID;
            html += `<option value="${item.item_id}__${item.item_value}" ${isSelected ? "selected" : ""}>${item.item_value}</option>`;
        });

        html += `</select>`;
    }

    // Handle text input field (default case)
    else {
        let checkVal = val != null && val.value != null;
        html += `<label for="${el.field_name}">${el.formLabel ? el.formLabel : el.title} ${el.is_required ? requiredSpan : ''}</label>
                <input class="form-control mb-3" ${el.isReadOnly ? "readonly" : ""} ${el.isRequired ? "required" : ""} value="${checkVal ? val.value : ''}" data-field-id="${el.field_id}" name="${el.field_name}" />`;
    }

    return html;
}

function printForm(category, fields, user_info, display = true, show) {
    // Determine form type and related attributes
    const formType = display ? 'display' : 'user';
    var formId = `${formType}Form${category.field_category_id}`;
    var action;
    var formClass = display ? "" : "d-none";
    if (show) {
        formClass = "";
        formId = "dealForm";
        action = "/apply";
    }
    const enctype = !display ? 'enctype="multipart/form-data"' : '';
    const emptySpan = `<span class='small text-muted fst-italic'>Empty</span>`;
    let html = `
        <form id="${formId}" class="${formClass}" ${enctype} ${action ? 'action=' + action : ''} method="post">
            <div class="container-fluid">
                <div class="row">
                    <div class="${show ? 'col-sm-12' : 'col-sm-8'}">
                        <div class="row">
            `;
    // Counter for row breaking
    let i = 0;

    // Filter fields belonging to the current category
    const categoryFields = fields.filter(el => el.field_category_id === category.field_category_id);

    // Iterate through each field
    categoryFields.forEach(field => {

        const displayName = field.title || field.field_name;
        const breakRow = i % 2;

        // Find element details for the current field
        let element = field;

        html += `<div class="col-sm-6">`;

        // Find user info for the current field
        let info_elem = user_info.filter(el => el.field_id === field.field_id);

        if (display) {
            // Generate HTML for displaying field info
            html += `<div class="mb-3">
                        <label class="form-label">${displayName} ${element.is_required ? '<i>(required)</i>' : ''} </label>
                        <p id="display${displayName}" class="form-control-static mb-3">`;
            // Populate info based on user input
            if (info_elem.length > 0) {
                if (info_elem[0].display_value != null) {
                    html += info_elem[0].display_value;
                } else if (info_elem[0].value != null) {
                    html += info_elem[0].value;
                } else if (info_elem[0].file_name != null) {
                    const fullURL = window.location.protocol + '//' + window.location.host;
                    html += `<a href="${fullURL + "/storage/profile/documents/" + info_elem[0].file_path}" target="_blank">${info_elem[0].file_name} </a>`;
                } else {
                    html += emptySpan;
                }
            } else {
                html += emptySpan;
            }

            html += `</p>
                    </div>`;
        } else {
            // Generate HTML for editing field info
            if (info_elem.length > 0) {
                html += printHTML(element, info_elem[0]);
            } else {
                html += printHTML(element);
            }
        }

        html += `</div>`;
        i++;
    });

    html += `
                        </div>
                    </div>
                </div>
            </div>
        </form>
        `;

    return html;

}

function hideSpinner() {
    $("#preloader").fadeOut();
}

function showSpinner() {
    $("#preloader").fadeIn();
}

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

function printElements(array = [], modal = false) {
    // Prepare data for the request
    let data = {id: array};


    if (modal) {
        // Request category fields, active fields, and details for printing
        axios.post('/api/user_fields', data)
            .then(response => {
                console.log(response.data);
                // Hide the spinner on load
                hideSpinner();

                // Separate data from the response
                var categories = response.data[0];
                var fields = response.data[1];

                // Generate HTML for each category
                var html = '';
                categories.forEach(category => {
                    html += `
                            <div class="row">
                                <div class="col-lg-12 d-flex align-items-stretch">
                                    `;
                    // Generate HTML for printing both forms
                    html += printForm(category, fields, [], false, true);

                    html += `
                                </div>
                            </div>`;
                });
                // Display the generated HTML
                $("#fieldsModalWrap").html(html);

                var form = document.getElementById('dealForm');
                // Get the CSRF token from the meta tag
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Create a hidden input field for the CSRF token
                var csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token'; // This is the default name for Laravel's CSRF token field
                csrfInput.value = csrfToken;

                // Append the CSRF token input field to the form
                form.appendChild(csrfInput);


            })
            .catch(error => {
                showToast(error, 'error');
            });
    } else {
        // Request category fields, active fields, and details for printing
        axios.post('/api/user_fields', data)
            .then(response => {
                // Hide the spinner on load
                hideSpinner();

                array.forEach(el => {
                    let placeholder = `<div class="ph-item rounded">
                                                <div class="ph-col-12">
                                                    <div class="ph-row">
                                                        <div class="ph-col-6 big rounded"></div>
                                                        <div class="ph-col-6 empty big"></div>
                                                        <div class="ph-col-12 empty big"></div>
                                                        <div class="ph-col-12 empty big"></div>
                                                    </div>
                                                    <div class="ph-row mb-2">
                                                        <div class="ph-col-4 me-3 big rounded"></div>
                                                        <div class="ph-col empty big"></div>
                                                        <div class="ph-col-4 big rounded"></div>
                                                        <div class="ph-col-3 empty big"></div>
                                                    </div>
                                                    <div class="ph-row mb-2">
                                                        <div class="ph-col-4 me-3 big rounded"></div>
                                                        <div class="ph-col empty big"></div>
                                                        <div class="ph-col-4 big rounded"></div>
                                                        <div class="ph-col-3 empty big"></div>
                                                    </div>
                                                    <div class="ph-row mb-2">
                                                        <div class="ph-col-4 me-3 big rounded"></div>
                                                        <div class="ph-col empty big"></div>
                                                        <div class="ph-col-4 big rounded"></div>
                                                        <div class="ph-col-3 empty big"></div>
                                                    </div>

                                                </div>
                                            </div>`;
                    $("#fieldsWrap").append(placeholder);
                })

                // Request category fields, active fields, and details for printing
                axios.post('/api/user_fields', data)
                    .then(response => {
                        // Hide the spinner on load
                        hideSpinner();

                        // Separate data from the response
                        var categories = response.data[0];
                        var fields = response.data[1];
                        axios.post("/user_info")
                            .then(response => {

                                var user_info = response.data;

                                // Generate HTML for each category
                                var html = '';
                                categories.forEach(category => {
                                    html += `
                            <div class="row">
                                <div class="col-lg-12 d-flex align-items-stretch">
                                    <div class="card w-100">
                                        <div class="card-header bg-white p-4 px-4">
                                        <div class="container-fluid">
                                            <div class="row align-items-center ">
                                                <div class="col-6 px-0">
                                                    <h5 class="card-title fw-semibold m-0">
                                                        ${category.category_name}
                                                    </h5>
                                                </div>
                                                <div class="col-6 d-flex justify-content-end p-0">
                                                    <div id="userFormBtn${category.field_category_id}" class="d-none justify-content-end">
                                                        <button
                                                            type="button"
                                                            class="btn btn-success btn-block m-1 btnSaveClass"
                                                            id="btnSave${category.field_category_id}"
                                                            data-category="${category.field_category_id}"
                                                            data-print="${array}"
                                                        >
                                                            <i class="ti ti-check"></i>
                                                        </button>
                                                        <button
                                                            type="button"
                                                            class="btn btn-danger btn-block m-1 btnCancelClass"
                                                            id="btnCancel${category.field_category_id}"
                                                            data-category="${category.field_category_id}"
                                                        >
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </div>
                                                    <div id="displayFormBtn${category.field_category_id}">
                                                        <button
                                                            type="button"
                                                            class="btn btn-block m-1 btnEditClass"
                                                            id="btnEdit${category.field_category_id}"
                                                            data-category="${category.field_category_id}"
                                                        >
                                                            Edit
                                                            <i class="ti ti-pencil-minus ms-1"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div></div>
                                        </div>
                                        <div class="card-body  px-sm-4 p-sm-3 px-sm-3 px-2">`;
                                    // Generate HTML for printing both forms
                                    html += printForm(category, fields, user_info, false);
                                    html += printForm(category, fields, user_info);
                                    html += `
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                                });
                                // $("#fieldsWrap").hide();
                                // // Display the generated HTML
                                $("#fieldsWrap").html(html);
                                // $("#fieldsWrap").fadeIn();

                            })
                            .catch(error => {
                                console.error(error);
                            });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            });
    }
}

$(document).ready(function () {

    $(document).on('change', '#profile-image-input', function () {
        this.form.submit();
    });

    $(document).on("click", ".btnEditClass", function () {
        let id = $(this).data("category");

        $(document).find("#userForm" + id).removeClass("d-none");
        $(document).find("#displayForm" + id).addClass("d-none");
        $(document).find("#displayFormBtn" + id).addClass("d-none");
        $(document).find("#userFormBtn" + id).removeClass("d-none");
    });

    function showDisplayForm(id) {
        $(document).find("#userForm" + id).addClass("d-none");
        $(document).find("#displayForm" + id).removeClass("d-none");
        $(document).find("#displayFormBtn" + id).removeClass("d-none");
        $(document).find("#userFormBtn" + id).addClass("d-none");
    }

    $(document).on("click", ".btnSaveClass", function () {
            try {
                showSpinner();
                // Extract data attributes
                let id = $(this).data("category");
                let print = $(this).data("print");
                var numbersArray = [];

                // Convert comma-separated string to array of numbers
                if (print.toString().includes(',')) {
                    numbersArray = print.split(',').map(Number);
                } else {
                    numbersArray.push(parseInt(print))
                }

                // Get the form element and create FormData object
                var formEl = document.getElementById('userForm' + id);
                var formObj = new FormData(formEl);

                // Send data for updating user information
                axios.post("/update_user", formObj, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                }).then(response => {
                    // Display success message and refresh elements
                    showToast('Profile Updated!', 'success');
                    printElements(numbersArray);
                }).catch(error => {
                    // Display error message
                    hideSpinner();
                    showToast(error.response.data.error, 'error');
                })
            } catch
                (error) {
                console.log(error.response.data);
            }
        }
    )
    ;

    $(document).on("click", ".btnCancelClass", function () {
        let id = $(this).data("category");
        hideSpinner();
        showDisplayForm(id);
    });

});

document.addEventListener('DOMContentLoaded', function () {
    try {
        setTimeout(function () {
            $(".alertNotification").remove();
        }, 10000);


        let path = window.location.pathname;

        // Check if the page is for page editing or inserting
        if (path.includes('pages') && (path.includes('edit') || path.includes('insert'))) {

            var searchTimeout;

            // Event for inputting text
            $(document).on('keyup', '#iconSearch', function () {
                var icon = $(this).val();

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function () {
                    if (icon.length >= 3 || icon.length === 0) {
                        axios.post('/api/get_icons', {name: icon})
                            .then(response => {
                                var data = response.data;
                                var html = '';
                                var i = 0;

                                for (const item in data) {
                                    i++;
                                    html += `<div class="col-1 my-1">
                                            <div class="p-4 bg-primary h3 text-center m-0 rounded icon-item"
                                                data-value="ti ${data[item]}"><i
                                                class="text-white ti ${data[item]}"></i></div>
                                        </div>`;
                                }

                                if (i === 0) {
                                    html += `<div><h3 class="mt-3 text-center">No results for your search!</h3></div>`;
                                }

                                $("#iconsWrap").html(html);
                            });
                    }
                }, 400);
            });

            $(document).on('click', '.icon-item', function () {
                $('.icon-item').removeClass('bg-dark');
                $(this).addClass('bg-dark');
                let value = $(this).data('value');
                $('#icon').val(value);
            });
        }

        if (path === '/') {
            path = '/profile';
        }

        // Fetch page category data and print elements
        axios.post("/page_category", {name: path})
            .then(response => {
                let res = response.data;
                const idArray = res.map(item => item.field_category_id);
                if (idArray.length > 0) {
                    printElements(idArray);
                } else {
                    hideSpinner();
                }
            })
            .catch(error => {
                alert(error);
                console.error('Error fetching page category:', error);
            });
        printElements([4], true);


    } catch (error) {
        console.error('Unexpected error:', error);
    }
});
