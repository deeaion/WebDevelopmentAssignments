

function isEmpty(field)
{
    return field.length === 0;
}
function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simplified regex for email validation
    return email.length > 5 && emailRegex.test(email);
}

function isValidBirthDate(date) {
    let el = date.split('-');
    let year = parseInt(el[0], 10);
    return year > 1940 && year < 2020;
}

function isValidName(word) {
    return word.length > 0 && /^[A-Z][a-z]+$/.test(word);
}

function validateForm() {
    var form = document.forms["myForm"];
    let firstN = form["fNameU"].value.trim();
    let lastN = form["sNameU"].value.trim();
    let birthDate = form["birthU"].value.trim();
    let email = form["emailU"].value.trim();
    var error = "";

    if (!isValidName(firstN)) {
        error += "Invalid First Name. Please retry!\n";
        form["fNameU"].style.border = "2px solid red";
    }
    if (!isValidName(lastN)) {
        error += "Invalid Second Name. Please retry!\n";
        form["sNameU"].style.border = "2px solid red";
    }
    if (!isValidEmail(email)) {
        error += "Invalid Email. Please retry!\n";
        form["emailU"].style.border = "2px solid red";
    }
    if (!isValidBirthDate(birthDate)) {
        error += "Invalid Birth Date. Please retry!\n";
        form["birthU"].style.border = "2px solid red";
    }
    if (error.length > 0) {
        alert(error);
        return false;
    } else {
        alert('Well Done!');
        return true;
    }
}
