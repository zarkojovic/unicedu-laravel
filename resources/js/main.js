document.addEventListener('DOMContentLoaded', function() {
    const userForm = document.getElementById('userForm');
    const displayForm = document.getElementById('displayForm');
    const btnEdit = document.getElementById('btnEdit');
    const btnSave = document.getElementById('btnSave');
    const btnCancel = document.getElementById('btnCancel');

    const dobInput = document.getElementById('dobInput');
    const citizenshipInput = document.getElementById('citizenshipInput');
    const phoneInput = document.getElementById('phoneInput');
    const passportInput = document.getElementById('passportInput'); 
    const nameInput = document.getElementById('nameInput');
    const surnameInput = document.getElementById('surnameInput');
    
    const displayDOB = document.getElementById('displayDOB');
    const displayCitizenship = document.getElementById('displayCitizenship');
    const displayPhone = document.getElementById('displayPhone');
    const displayPassport = document.getElementById('displayPassport'); 
    const displayName = document.getElementById('displayName');
    const displaySurname = document.getElementById('displaySurame');
    
    
    btnSave.addEventListener('click', function() {
        userForm.classList.add('d-none');
        displayForm.classList.remove('d-none');
        btnCancel.classList.add('d-none');
        btnSave.classList.add('d-none');
        btnEdit.classList.remove('d-none');
        displayFormData();
    });

    btnEdit.addEventListener('click', function() {
        userForm.classList.remove('d-none');
        displayForm.classList.add('d-none');
        btnCancel.classList.remove('d-none');
        btnSave.classList.remove('d-none');
        btnEdit.classList.add('d-none');

    });

    function displayFormData() {
        displayName.textContent = nameInput.value;
        displaySurname.textContent = surnameInput.value;
        displayDOB.textContent = dobInput.value;
        displayCitizenship.textContent = citizenshipInput.value;
        displayPhone.textContent = phoneInput.value;
        displayPassport.textContent = passportInput.value;
    }
  });