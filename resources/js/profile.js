import axios from "axios";

function printHTML(el) {
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
                                    <input type="file" name="${el.field_name}" class="form-control">
                                `
    } else if (el.type == "date") {
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <input type="date" name="${el.field_name}" class="form-control">
                                `
    } else if (el.type == "datetime") {
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <input type="datetime-local" name="${el.field_name}" class="form-control">
                                `
    } else if (el.type == "enumeration") {
        html += `
                                    <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                    <select class="form-control" name="${el.field_name}">
                                    <option value="0">Select</option>
                                        `;
        el.items.forEach(item => {
            html += `<option value="${item.ID}">${item.VALUE}</option>`
        })
        html += `
                                    </select>
                                 `;
    } else {
        html += `
                                <label for="${el.fieldName}">${el.formLabel ? el.formLabel : el.title}</label>
                                <input class="form-control" ${el.isReadOnly ? "readonly" : ""} ${el.isRequired ? "required" : ""} name="${el.field_name}"  />
                            `
    }

    return html;
}


function printElements() {
//GET ALL CATEGORY FIELDS, ACTIVE FIELDS AND DETAILS FOR PRINTING FIELDS FROM JSON
    axios.post('/api/user_fields')
        .then(response => {
            console.log(response);
            // MAKING THEM SEPERATE
            let categories = response.data[0];
            let fields = response.data[1];
            let field_details = response.data[2];

            // HTML FOR PRINTING
            var html = '';
            // FOR EACH CATEGORY PRINT IT'S FIELDS
            categories.forEach(category => {
                html += `
            <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
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
<form id="displayForm${category.field_category_id}" class="mt-4">
                            <div class="row">`;
                // DECLAREING COUNTER SO WE KNOW WHEN TO BREAK FOR DESIGN
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

                    if (!breakRow) {
                        html += `<div class="row my-2">`
                    }
                    html += `<div class="col-sm-4">`;
                    // FUNCTION FOR PRINTING ITEM
                    // html += printHTML(element[0]);

                    html += `
                                    <div class="mb-3">
                                        <label class="form-label">${displayName}</label>
                                        <p id="display${displayName}" class="form-control-static">
                                        </p>
                                </div>
                `;
                    html += `</div>`;
                    if (breakRow) {
                        html += `</div>`;
                    }

                    i++;


                });
                html += `
                            </div>
                        </div>
                        </form>
                        <form id="userForm${category.field_category_id}" class="mt-4 d-none">
                            <div class="row">`;
                // DECLAREING COUNTER SO WE KNOW WHEN TO BREAK FOR DESIGN
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

                    if (!breakRow) {
                        html += `<div class="row my-2">`
                    }
                    html += `<div class="col-sm-4">`;
                    // FUNCTION FOR PRINTING ITEM
                    html += printHTML(element[0]);

                    // html += `
                    //                     <div class="mb-3">
                    //                         <label class="form-label">${displayName}</label>
                    //                         <p id="display${displayName}" class="form-control-static">
                    //                         </p>
                    //                 </div>
                    // `;
                    html += `</div>`;
                    if (breakRow) {
                        html += `</div>`;
                    }

                    i++;


                });
                html += `
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>`
            });
            // PRINT IN THE ELEMENT
            $("#fieldsWrap").html(html);
        })
        .catch(error => {
            console.error(error);
        });
}

printElements();
