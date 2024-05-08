$(document).ready(function() {
    console.log("Script loaded!");

    // Define validation functions
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email) && email.length > 5;
    }

    function isValidBirthDate(date) {
        const year = parseInt(date.split('-')[0], 10);
        return year > 1940 && year < 2020;
    }

    function isValidName(name) {
        return /^[A-Z][a-z]+$/.test(name);
    }

    // Attach the submit event handler to the form
    $("#myForm").on('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault();  // Prevent the form from submitting
            console.log("Validation failed!");
        } else {
            console.log("Validation passed!");
        }
    });

    // Form validation logic
    function validateForm() {
        let isValid = true;
        const form = $("#myForm");
        let errors = "";  // Initialize the errors string

        // Define the fields and their validation rules
        const fields = [
            { field: 'fNameU', validator: isValidName, errorMessage: "Invalid First Name. Please retry!" },
            { field: 'sNameU', validator: isValidName, errorMessage: "Invalid Second Name. Please retry!" },
            { field: 'birthU', validator: isValidBirthDate, errorMessage: "Invalid Birth Date. Please retry!" },
            { field: 'emailU', validator: isValidEmail, errorMessage: "Invalid Email. Please retry!" }
        ];

        // Validate each field
        fields.forEach(({ field, validator, errorMessage }) => {
            const input = form.find(`[name=${field}]`);
            const value = input.val() || "";  // Default to empty string if undefined

            if (!validator(value.trim())) {
                input.css('border', '2px solid red');
                errors += errorMessage + "\n";  // Accumulate errors
                isValid = false;
            } else {
                input.css('border', '1px solid #ccc');
            }
        });

        if (!isValid) {
            alert(errors);  // Show accumulated errors
        } else {
            alert('Well Done!');
        }

        return isValid;
    }
});
