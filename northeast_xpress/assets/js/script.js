/* NAVIGATION */
document.addEventListener('DOMContentLoaded', function () {
    var navbarToggler = document.querySelector('.navbar-toggler');
    var overlayMenu = document.querySelector('.overlay-menu');
    const menuItems = document.querySelectorAll('.overlay-menu a');

    function closeOverlayMenu() {
        navbarToggler.classList.remove('active');
        overlayMenu.style.right = '-100%';
    }

    navbarToggler.addEventListener('click', function () {
        this.classList.toggle('active');
        overlayMenu.style.right = this.classList.contains('active') ? '0' : '-100%';
    });

    menuItems.forEach(item => {
        item.addEventListener('click', closeOverlayMenu);
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 768 && navbarToggler.classList.contains('active')) {
            closeOverlayMenu();
        }
    });
});

/* FADE IN ANIMATION */
const elements = document.querySelectorAll('.fade-in-from-top, .fade-in-from-top-slow');

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.intersectionRatio > 0) {
            entry.target.classList.add('is-visible');
        }
    });
});

elements.forEach(element => {
    observer.observe(element);
});

/* FIX TRUCK FORM */
function openForm() {
    document.getElementById("myForm").style.display = "block";
}

function closeForm() {
    document.getElementById("myForm").style.display = "none";
}

/* VEHICLE FORM */
function openFormVehicle() {
    document.getElementById("vehiclesForm").style.display = "block";
    document.getElementById("addVehicleButtonContainer").style.display = "none";
    document.getElementById("fixTruckButton").style.display = "none";
}

function closeFormVehicle() {
    document.getElementById("vehiclesForm").style.display = "none";
    document.getElementById("addVehicleButtonContainer").style.display = "block";
    document.getElementById("fixTruckButton").style.display = "block";
}

function updateVehicleHeading() {
    const heading = document.querySelector('.vehicles h2');
    if (heading) {
        const rowCount = document.querySelectorAll('#tbody tr').length;
        const vehicleText = rowCount === 1 ? 'vehicle' : 'vehicles';
        heading.textContent = `You currently have ${rowCount} ${vehicleText}`;
    }
}

updateVehicleHeading();

/* Function to display notifications */
function showNotification(message) {

    var form = document.getElementById("vehiclesForm");

    // Create a notification element
    var notification = document.createElement("div");
    notification.className = "notification";
    notification.textContent = message;

    // Create an img element for the icon
    var icon = document.createElement("img");
    icon.src = "assets/img/checked.png";
    icon.alt = "Notification Icon";

    // Append the icon to the notification div
    notification.appendChild(icon);

    // Create a span element for the message
    var messageSpan = document.createElement("span");
    messageSpan.textContent = message;

    // Append the notification to the body
    form.appendChild(notification);

    // Remove the notification after a certain duration (e.g., 3 seconds)
    setTimeout(function () {
        form.removeChild(notification);
    }, 3000); // 3000 milliseconds = 3 seconds
}

/* Function to select trailer or truck */
document.addEventListener('DOMContentLoaded', function () {
    // Get the checkbox element
    const checkbox = document.getElementById('d');

    if (checkbox) {
        // Define the function that will handle the switch change
        function handleSwitchChange() {
            const isTrailer = checkbox.checked; // True if "Trailer" is selected, false if "Truck" is selected

            // Perform different actions based on the selected option
            if (isTrailer) {
                console.log('Trailer selected');
                document.getElementById('vehicleType').value = "Trailer";
                // Add functionality for when "Trailer" is selected
            } else {
                console.log('Truck selected');
                document.getElementById('vehicleType').value = "Truck";
                // Add functionality for when "Truck" is selected
            }
        }

        // Attach the change event listener to the checkbox
        checkbox.addEventListener('change', handleSwitchChange);
        handleSwitchChange(); // Call the function initially to set the initial state
    }
});


/* Add a new row upon clicking add vehicle button */
function addRow() {
    // Retrieve form inputs
    const companyName = document.querySelector('#cname').value;
    const truckMake = document.querySelector('#truckmake').value;
    const truckPlateNumber = document.querySelector('#platenum').value;

    // Create the vehicle description
    const vehicleDescription = document.createElement('p');
    vehicleDescription.className = 'vehicleDescription'; // Use a class instead of an ID
    vehicleDescription.textContent = `${companyName} ${truckMake} ${truckPlateNumber}`;

    // Create a new row
    const tbody = document.getElementById('tbody');
    const newRow = document.createElement('tr');

    // Create a new cell and append the vehicle description
    const newCell = document.createElement('td');
    newCell.appendChild(vehicleDescription);

    // Create the remove button
    const removeButton = document.createElement('button');
    removeButton.className = 'remove-vehicle-btn';
    removeButton.onclick = function () {
        removeRow(removeButton);
    };
    removeButton.innerHTML = "<img src='assets/img/delete-button.png' alt='bin icon'>";

    // Create the remove button container
    const removeButtonContainer = document.createElement('div');
    removeButtonContainer.className = 'col-sm-4 text-right vtableicon';
    removeButtonContainer.appendChild(removeButton);

    // Create a row div and append the vehicle description and remove button container
    const rowDiv = document.createElement('div');
    rowDiv.className = 'row';
    const vehicleTextDiv = document.createElement('div');
    vehicleTextDiv.className = 'col-sm-8 vtabletext';
    vehicleTextDiv.appendChild(vehicleDescription);

    rowDiv.appendChild(vehicleTextDiv);
    rowDiv.appendChild(removeButtonContainer);

    // Create the main container and append the row div
    const mainContainer = document.createElement('div');
    mainContainer.className = 'container-fluid vtable';
    mainContainer.id = 'inputvehicle';
    mainContainer.appendChild(rowDiv);

    // Append the main container to the cell and the cell to the new row
    newCell.appendChild(mainContainer);
    newRow.appendChild(newCell);

    // Append the new row to the tbody
    tbody.appendChild(newRow);

    // Update the vehicle heading
    updateVehicleHeading();

    // Show notification
    showNotification("Vehicle successfully saved");

    // Check if there are any rows in tbody and hide the placeholder
    const rowsInTbody = tbody.querySelectorAll('tr').length;
    if (rowsInTbody > 0) {
        document.getElementById("placeholder").style.display = "none";
    }
}

/* Remove row upon clicking remove button in the above function */
function removeRow(button) {
    var row = button.parentNode.parentNode.parentNode.parentNode;
    row.parentNode.removeChild(row);
    updateVehicleHeading(); // NOT WORKING
}

/* Function to switch to edit mode */
function editAccount() {
    // Hide the profile information table
    document.getElementById('profileInfo').style.display = 'none';

    // Show the form for editing account information
    document.getElementById('editForm').style.display = 'block';
}

/* Function to save account information */
function saveAccount() {
    // Retrieve form values
    var firstName = document.getElementById('firstName').value;
    var lastName = document.getElementById('lastName').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    // Password can be handled securely, omitted here for simplicity

    // Capitalize the first letter of each word in the full name
    var capitalizedFirstName = firstName.charAt(0).toUpperCase() + firstName.slice(1).toLowerCase();
    var capitalizedLastName = lastName.charAt(0).toUpperCase() + lastName.slice(1).toLowerCase();

    // Update the display table with the new values, using the capitalized names
    document.getElementById('displayFirstName').textContent = capitalizedFirstName;
    document.getElementById('displayLastName').textContent = capitalizedLastName;
    document.getElementById('displayEmail').textContent = email;
    document.getElementById('displayPhone').textContent = phone;

    // Update the content of the <h2> element with the full name
    document.getElementById('fullName').textContent = capitalizedFirstName + " " + capitalizedLastName;

    // Save the new account information (e.g., send to server)

    // Switch back to display mode
    document.getElementById('profileInfo').style.display = 'block';
    document.getElementById('editForm').style.display = 'none';
}

/* Function to cancel editing and switch back to display mode */
function cancelEdit() {
    // Hide the edit form
    document.getElementById('editForm').style.display = 'none';

    // Show the profile information table
    document.getElementById('profileInfo').style.display = 'block';
}

// Check the current page using window.location.pathname
const currentPage = window.location.pathname;
if (currentPage.includes('signup.html')) {
    // If you are on signup.html, set up form validation for the signup form
    const form = document.getElementById('form');
    if (form) {
        form.addEventListener('submit', e => {
            e.preventDefault();
            validateInputs();
        });
    }
} else if (currentPage.includes('vehicle.html')) {
    // If you are on vehicle.html, set up form validation for the vehicle form
    const vform = document.getElementById('truckForm');
    if (vform) {
        vform.addEventListener('submit', e => {
            e.preventDefault();
            validateInputsVehicle();
        });
    }
}

/* SIGN UP VALIDATION */
const form = document.getElementById('form');
const fname = document.getElementById('fname');
const lname = document.getElementById('lname');
const email = document.getElementById('email');
const phone = document.getElementById('phone');
const password = document.getElementById('password');
const password2 = document.getElementById('password2');
const checkbox = document.getElementById('checkbox');

const setError = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    if (errorDisplay) {
        errorDisplay.innerText = message;
        inputControl.classList.add('error');
        inputControl.classList.remove('success');
    }
}

const setSuccess = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error');

    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error');
};

const isValidEmail = email => {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

const isValidPhone = phone => {
    const re = /^\d{10}$/;
    return re.test(phone);
};
const validateInputs = () => {
    let errors = true;
    const fnameValue = fname.value.trim();
    const lnameValue = lname.value.trim();
    const emailValue = email.value.trim();
    const phoneValue = phone.value.trim();
    const passwordValue = password.value.trim();
    const password2Value = password2.value.trim();

    if (fnameValue === '') {
        errors = false;
        setError(fname, 'First name is required');
    } else {
        setSuccess(fname);
    }

    if (lnameValue === '') {
        errors = false;
        setError(lname, 'Last name is required');
    } else {
        setSuccess(lname);
    }

    if (emailValue === '') {
        errors = false;
        setError(email, 'Email is required');
    } else if (!isValidEmail(emailValue)) {
        errors = false;
        setError(email, 'Provide a valid email address that includes "@" and a domain name');
    } else {
        setSuccess(email);
    }

    if (phoneValue === '') {
        errors = false;
        setError(phone, 'Phone number is required')
    } else if (!isValidPhone(phoneValue)) {
        errors = false;
        setError(phone, 'Provide a valid phone number of 10 digits without symbols');
    } else {
        setSuccess(phone);
    }

    if (passwordValue === '') {
        errors = false;
        setError(password, 'Password is required');
    } else if (passwordValue.length < 8) {
        errors = false;
        setError(password, 'Password must be at least 8 character.')
    } else {
        setSuccess(password);
    }

    if (password2Value === '') {
        errors = false;
        setError(password2, 'Please confirm your password');
    } else if (password2Value !== passwordValue) {
        errors = false;
        setError(password2, "Passwords doesn't match");
    } else {
        setSuccess(password2);
    }

    if (!checkbox.checked) {
        errors = false;
        setError(checkbox, 'You must agree to the Terms & Conditions');
    } else {
        setSuccess(checkbox);
    }

    return false;
};

/* VEHICLE VALIDATION */
const vform = document.getElementById('truckForm');
const cname = document.getElementById('cname');
const trucknum = document.getElementById('trucknum');
const truckmake = document.getElementById('truckmake');
const platenum = document.getElementById('platenum');
const dotnum = document.getElementById('dotnum');
const mcnum = document.getElementById('mcnum');
const policynum = document.getElementById('policynum');
const policyexp = document.getElementById('policyexp');
const federalexp = document.getElementById('federalexp');
const stateexp = document.getElementById('stateexp');

const setError1 = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error-truck');

    errorDisplay.innerText = message;
    inputControl.classList.add('error-truck');
    inputControl.classList.remove('success')
}

const setSuccess1 = element => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.error-truck');

    errorDisplay.innerText = '';
    inputControl.classList.add('success');
    inputControl.classList.remove('error-truck');
};

const isLettersOnly = truckmake => {
    const lettersOnlyRegex = /^[A-Za-z]+$/;
    return lettersOnlyRegex.test(truckmake);
}

const isValidVin = trucknum => {
    const re = /^[A-Za-z0-9]{17}$/;
    return re.test(trucknum);
}

const isAlphanumericOnly = platenum => {
    const re = /^[A-Za-z0-9]+$/;
    return re.test(platenum);
}

const isValidDot = dotnum => {
    const re = /^\d{8}$/;
    return re.test(dotnum);
}

const isValidMc = mcnum => {
    const re = /^\d{7}$/;
    return re.test(mcnum);
}

const isValidPolicy = policynum => {
    const re = /^[A-Za-z0-9!@#\$%\^&\*\(\)_\+\-=\[\]\{\};':",.<>\/?\\|`~]+$/;
    return re.test(policynum);
}

const isValidDate = policyexp => {
    const inputDate = new Date(policyexp);
    const currentDate = new Date();
    return inputDate > currentDate;
}

const isValidFederal = federalexp => {
    const inputDate = new Date(federalexp);
    const currentDate = new Date();
    return inputDate > currentDate;
}

const isValidState = stateexp => {
    const inputDate = new Date(stateexp);
    const currentDate = new Date();
    return inputDate > currentDate;
}
const validateInputsVehicle = () => {
    const cnameValue = cname.value.trim();
    const trucknumValue = trucknum.value.trim();
    const truckmakeValue = truckmake.value.trim();
    const platenumValue = platenum.value.trim();
    const dotnumValue = dotnum.value.trim();
    const mcnumValue = mcnum.value.trim();
    const policynumValue = policynum.value.trim();
    const policyexpValue = policyexp.value.trim();
    const federalexpValue = federalexp.value.trim();
    const stateexpValue = stateexp.value.trim();

    if (cnameValue === '') {
        setError1(cname, 'Company Name is required');
    } else {
        setSuccess1(cname);
    }

    if (trucknumValue === '') {
        setError1(trucknum, 'Truck Number is required');
    } else if (!isValidVin(trucknumValue)) {
        setError1(trucknum, 'Truck Number must be 17 alphanumeric characters');
    } else {
        setSuccess1(trucknum);
    }

    if (truckmakeValue === '') {
        setError1(truckmake, 'Truck Make is required');
    } else if (!isLettersOnly(truckmakeValue)) {
        setError1(truckmake, 'Truck Make must contain letters only');
    } else {
        setSuccess1(truckmake);
    }

    if (platenumValue === '') {
        setError1(platenum, 'Truck Plate Number is required');
    } else if (!isAlphanumericOnly(platenumValue)) {
        setError1(platenum, 'Plate Number can only contain letters and numbers');
    } else {
        setSuccess1(platenum);
    }

    if (dotnumValue === '') {
        setError1(dotnum, 'DOT Number is required');
    } else if (!isValidDot(dotnumValue)) {
        setError1(dotnum, 'DOT Number must be exactly 8 numbers long');
    } else {
        setSuccess1(dotnum);
    }

    if (mcnumValue === '') {
        setError1(mcnum, 'MC Number is required');
    } else if (!isValidMc(mcnumValue)) {
        setError1(mcnum, 'MC Number must be exactly 7 numbers long');
    } else {
        setSuccess1(mcnum);
    }

    if (policynumValue === '') {
        setError1(policynum, 'Insurance Policy Number is required');
    } else if (!isValidPolicy(policynumValue)) {
        setError1(policynum, 'Insurance Policy Number must contain letters, numbers, and symbols');
    } else {
        setSuccess1(policynum);
    }

    if (policyexpValue === '') {
        setError1(policyexp, 'Insurance Policy Expiration Date is required');
    } else if (!isValidDate(policyexpValue)) {
        setError1(policyexp, 'Insurance Policy Expiration Date must be in the future');
    } else {
        setSuccess1(policyexp);
    }

    if (federalexpValue === '') {
        setError1(federalexp, 'Federal Inspection Expiration Date is required');
    } else if (!isValidFederal(federalexpValue)) {
        setError1(federalexp, 'Federal Inspection Expiration Date must be in the future');
    } else {
        setSuccess1(federalexp);
    }

    if (stateexpValue === '') {
        setError1(stateexp, 'State Inspection Expiration Date is required');
    } else if (!isValidState(stateexpValue)) {
        setError1(stateexp, 'State Inspection Expiration Date must be in the future');
    } else {
        setSuccess1(stateexp);
    }
};

// Add a submit event listener to the form
if (vform) {
    vform.addEventListener('submit', function (e) {
        // Prevent the default form submission initially
        e.preventDefault();

        // Validate the form inputs
        validateInputsVehicle();

        // Check if there are any validation errors
        const formHasErrors = Array.from(document.querySelectorAll('.error-truck')).some(errorElement => {
            return errorElement.textContent.trim() !== '' || errorElement.classList.contains('error');
        });

        // If there are validation errors, stop and log a message
        if (formHasErrors) {
            console.log("Form submission prevented due to validation errors.");
            return;
        }

        // If no validation errors, proceed with adding a new row
        console.log("Form is valid. Proceeding to add a new row and submit the form.");

        // Call the addRow() function to add a new row
        addRow();

        // Since there are no validation errors, submit the form
        // Note: Make sure the form action is set up correctly.
        vform.submit();
    });
}

let signupForm = document.getElementById('signupForm');
if (signupForm) {
    signupForm.addEventListener('submit', function (e) {
        if (!validateInputs()) {
            e.preventDefault();
        }
    })
}

let accountForm = document.getElementById('accountForm');
if (accountForm) {
    accountForm.addEventListener('submit', function (e) {
        if (!validateInputs()) {
            e.preventDefault();
        }
    })
}

window.onload = function () {
    var chatBody = document.getElementById('chat-body');
    // Scroll down the chat body
    if (chatBody) {
        chatBody.scrollTop = chatBody.scrollHeight;
    }
};