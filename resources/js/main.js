$(document).ready(function (){

    $(document).on("click",".btnEditClass",function (){
        let id = $(this).data("category");
        console.log(id);
        // $("#displayForm"+id).addClass("d-none");
        $(document).find("#userForm"+id).removeClass("d-none");
        $(document).find("#displayForm"+id).addClass("d-none");
        $(document).find("#displayFormBtn"+id).addClass("d-none");
        $(document).find("#userFormBtn"+id).removeClass("d-none");
        // $("#displayFormBtn").addClass("d-none");
        // $("#userFormBtn").removeClass("d-none");
    });

    function showDisplayForm(id){

        $(document).find("#userForm"+id).addClass("d-none");
        $(document).find("#displayForm"+id).removeClass("d-none");
        $(document).find("#displayFormBtn"+id).removeClass("d-none");
        $(document).find("#userFormBtn"+id).addClass("d-none");

        // $("#userForm").addClass("d-none");
        // $("#displayForm").removeClass("d-none");
        // $("#displayFormBtn").removeClass("d-none");
        // $("#userFormBtn").addClass("d-none");
    }

    $(document).on("click",".btnSaveClass",function (){
        let id = $(this).data("category");
        updateDisplay();
        showDisplayForm(id);
    });
    $(document).on("click",".btnCancelClass",function (){
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

document.addEventListener('DOMContentLoaded', function() {
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
