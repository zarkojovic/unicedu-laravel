import axios from "axios";
function printHTML(el, val = null) {
    // if(el.type == "enumeration"){

    // }
    let html = '';
    if (el.type == "crm_category" && el.field_name == "CATEGORY_ID") {
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <select class="form-control" name="${el.field_name}">
                                    <option value="0">Select</option>
                                        `;

        el.items.forEach(item => {
            html += `<option value="${item.ID}">${item.NAME}</option>`
        })
        html += `
                                    </select>
                                 `;
    } else if (el.type == "crm_status" && el.statusType == "DEAL_STAGE") {
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <select class="form-control" name="${el.field_name}">
                                    <option value="0">Select</option>
                                        `;
        el.items.forEach(item => {
            html += `<option value="${item.STATUS_ID}">${item.NAME}</option>`
        })
        html += `
                                    </select>
                                 `;
    } else if (el.type == "file") {
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <input type="file" name="${el.field_name}"  class="form-control">
                                `
    } else if (el.type == "date") {
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <input type="date" name="${el.field_name}" value="${val != null ? val.value : ""}" data-field-id="${el.field_id}" class="form-control">
                                `
    } else if (el.type == "datetime") {
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <input type="datetime-local" value="${val != null ? val.value : ""}" data-field-id="${el.field_id}" name="${el.field_name}" class="form-control">
                                `
    } else if (el.type == "enumeration") {
        console.log("DROPPPP");
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <select class="form-control" data-field-id="${el.field_id}" name="${el.field_name}">
                                    <option value="0">Select</option>
                                        `;
        el.items.forEach(item => {
            if (val != null) {
                if (val.value == item.VALUE) {
                    html += `<option value="${item.VALUE}" selected>${item.VALUE}</option>`;
                } else {
                    html += `<option value="${item.VALUE}">${item.VALUE}</option>`;
                }
            } else {
                html += `<option value="${item.VALUE}">${item.VALUE}</option>`;
            }
        })
        html += `
                                    </select>
                                 `;
    } else {
        html += `
            <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
            <input class="form-control" ${el.isReadOnly ? "readonly" : ""} ${el.isRequired ? "required" : ""} value="${val != null ? val.value : ""}" data-field-id="${el.field_id}" name="${el.field_name}"  />
                            `
    }

    return html;
}

function printForm(category, fields, field_details, user_info, display = true) {
    let html = `
        <form id="${display ? 'display' : 'user'}Form${category.field_category_id}" class="mt-4 ${!display ? "d-none" : ""}">
            <div class="col">`;

            // DECLARING COUNTER SO WE KNOW WHEN TO BREAK FOR DESIGN
            var i = 0;

            // GET ONLY FIELDS WHICH ARE IN THAT CATEGORY
            var category_fields = fields.filter(el => el.field_category_id == category.field_category_id);

            // GO THROUGH EACH FIELD
            category_fields.forEach(field => {

                // GET THE FIELD NAME FOR DISPLAY
                let displayName = field.title != null ? field.title : field.field_name;

                // CHECKING ON EVERY TWO TO MAKE NEW ROW
                let breakRow = i % 2;

                // GET ELEMENT OBJECT FROM JSON
                let element = field_details.filter(el => el.field_name == field.field_name);
                element = element[0];
                element.field_id = field.field_id;
                // console.log(element)

                if (!breakRow) {
                    html += `<div class="row my-2">`
                }
                html += `<div class="col-sm-4">`;

                // FUNCTION FOR PRINTING ITEM
                let info_elem = user_info.filter(el => el.field_id == field.field_id);
                if (display) {
                    html += `<div class="mb-3">
                                    <label class="form-label">${displayName}</label>
                                    <p id="display${displayName}" class="form-control-static">
                                        ${info_elem.length > 0 ? info_elem[0].value : ""}
                                    </p>
                            </div>`;
                } else {
                    if (info_elem.length > 0) {

                        // FUNCTION FOR PRINTING ITEM
                        html += printHTML(element, info_elem[0]);
                    } else {

                        // FUNCTION FOR PRINTING ITEM
                        html += printHTML(element);
                    }
                }


                html += `</div>`;
                if (breakRow) {
                    html += `</div>`;
                }
                i++;
            });

            html += `
                </div>
            </div>
        </form>`;


    return html;
}

function hideSpinner() {
    $("#preloader").fadeOut();
    $("#preloader").addClass("opacity-0", 2500);
}

function showSpinner() {
    $("#preloader").fadeIn();
    $("#preloader").removeClass("opacity-0", 2500);
}

function printElements() {
//GET ALL CATEGORY FIELDS, ACTIVE FIELDS AND DETAILS FOR PRINTING FIELDS FROM JSON
    axios.post('/api/user_fields')
        .then(response => {

            // HIDE SPINNER ON LOAD
            hideSpinner();

            // MAKING THEM SEPERATE
            var categories = response.data[0];
            var fields = response.data[1];
            var field_details = response.data[2];

            // GET INFORMATION FROM AUTH USER
            axios.post("/user_info")
                .then(response => {
                    var user_info = response.data;
                    // HTML FOR PRINTING
                    var html = '';
                    // FOR EACH CATEGORY PRINT IT'S FIELDS
                    categories.forEach(category => {
                        html += `
            <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-header p-4">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title fw-semibold mb-4">
                                    ${category.category_name}
                                </h5>
                            </div>
                            <div class="col-4 text-end">
                                <div id="userFormBtn${category.field_category_id}" class="d-none">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block m-1 btnSaveClass"
                                        id="btnSave${category.field_category_id}"
                                        data-category="${category.field_category_id}"
                                    >
                                        Save
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-block m-1 btnCancelClass"
                                        id="btnCancel${category.field_category_id}"
                                        data-category="${category.field_category_id}"
                                    >
                                        Cancel
                                    </button>
                                </div>
                                <div id="displayFormBtn${category.field_category_id}">
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-block m-1 btnEditClass"
                                        id="btnEdit${category.field_category_id}"
                                        data-category="${category.field_category_id}"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                        </div>`;
                        html += printForm(category, fields, field_details, user_info);
                        html += printForm(category, fields, field_details, user_info, false);
                        html += `
                    </div>
                </div>
            </div>`;
                    });
                    // PRINT IN THE ELEMENT
                    $("#fieldsWrap").html(html);
                    $("#fieldsWrap").slideDown();

                })
                .catch(error => {
                    console.error(error);
                });

        })
        .catch(error => {
            console.error(error);
        });
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
        showSpinner();
        let id = $(this).data("category");
        let forma = document.forms['userForm' + id];

        var inputElements = forma.elements; // Get all input elements within the form

        var sendObj = {};
        var elems = [];
        // Loop through the input elements and access their properties
        for (var i = 0; i < inputElements.length; i++) {
            var input = inputElements[i];

            if (input.value != "") {

                var elemObj = {};

                elemObj.field_id = input.getAttribute('data-field-id');

                elemObj.value = input.value;
                elems.push(elemObj);
            }
        }
        sendObj.data = elems;
        sendObj._token = $('meta[name="csrf-token"]').attr('content');

        axios.post("/update_user", sendObj)
            .then(response => {
                printElements();
            })
            .catch(error => {
                console.error('Error:', error);
            });

    });
    $(document).on("click", ".btnCancelClass", function () {
        let id = $(this).data("category");
        showDisplayForm(id);
    });

    const inputs = {
        dob: document.getElementById('dobInput'),
        citizenship: document.getElementById('citizenshipInput'),
        phone: document.getElementById('phoneInput'),
        passport: document.getElementById('passportInput'),
        name: document.getElementById('nameInput'),
        surname: document.getElementById('surnameInput')
    };
    const display = {
        dob: document.getElementById('displayDOB'),
        citizenship: document.getElementById('displayCitizenship'),
        phone: document.getElementById('displayPhone'),
        passport: document.getElementById('displayPassport'),
        name: document.getElementById('displayName'),
        surname: document.getElementById('displaySurname')
    };

    function updateDisplay() {
        display.name.textContent = inputs.name.value;
        display.surname.textContent = inputs.surname.value;
        display.dob.textContent = inputs.dob.value;
        display.citizenship.textContent = inputs.citizenship.value;
        display.phone.textContent = inputs.phone.value;
        display.passport.textContent = inputs.passport.value;
    }
});

document.addEventListener('DOMContentLoaded', function () {

    printElements();


    const userForm = document.getElementById('userForm');
    const displayForm = document.getElementById('displayForm');
    const btnEdit = document.getElementById('btnEdit');
    const btnSave = document.getElementById('btnSave');
    const btnCancel = document.getElementById('btnCancel');

    const inputs = {
        dob: document.getElementById('dobInput'),
        citizenship: document.getElementById('citizenshipInput'),
        phone: document.getElementById('phoneInput'),
        passport: document.getElementById('passportInput'),
        name: document.getElementById('nameInput'),
        surname: document.getElementById('surnameInput')
    };


    // btnSave.addEventListener('click', function() {
    //     userForm.classList.add('d-none');
    //     displayForm.classList.remove('d-none');
    //     btnCancel.classList.add('d-none');
    //     btnSave.classList.add('d-none');
    //     btnEdit.classList.remove('d-none');
    //     updateDisplay();
    // });

    // btnEdit.addEventListener('click', function() {
    //     userForm.classList.remove('d-none');
    //     displayForm.classList.add('d-none');
    //     btnCancel.classList.remove('d-none');
    //     btnSave.classList.remove('d-none');
    //     btnEdit.classList.add('d-none');
    // });


});
