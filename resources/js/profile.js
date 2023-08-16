import axios from "axios";
console.log("pozz")
function printHTML(el){
        let html = '';
        if (el.type == "crm_category" && el.field_name == "CATEGORY_ID") {
            console.log(el)
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
                                <input class="form-control" ${el.isReadOnly ? "readonly" : ""} ${el.isRequired ? "required" : ""} name="${el.field_name}" placeholder="${el.type}" />
                            `
        }

    return html;
}


axios.post('/api/user_fields')
    .then(response => {
        let categories = response.data[0];
        let fields = response.data[1];
        let field_details = response.data[2];
        console.log(response.data);
        var html = '';
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
                                <div id="userFormBtn" class="d-none">
                                    <button
                                        type="button"
                                        class="btn btn-success btn-block m-1 "
                                        id="btnSave"
                                    >
                                        Save
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-block m-1"
                                        id="btnCancel"
                                    >
                                        Cancel
                                    </button>
                                </div>
                                <div id="displayFormBtn">
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-block m-1"
                                        id="btnEdit"
                                    >
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                        <form id="userForm" class="mt-4 ">
                            <div class="row">`;
            fields.forEach(field =>{
               if(field.field_category_id == category.field_category_id){
                   let displayName = field.title != null ? field.title : field.field_name;
                   console.log(displayName)
                    let element = field_details.filter(el => el.field_name == field.field_name);
                    html += `<div class="col-sm-4">`;
                    html += printHTML(element[0]);
                   html += `</div>`;
//                    html += `
//                                 <div class="col-lg-4">
//                                     <div class="mb-3">
//                                         <label class="form-label">${displayName}</label>
//                                         <p id="display${displayName}" class="form-control-static">
//
//                                         </p>
//                                     </div>
//                                 </div>
// `;
               }
            });
            html += `
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>`
        });

        $("#fieldsWrap").html(html);
    })
    .catch(error => {
        console.error(error);
    });


