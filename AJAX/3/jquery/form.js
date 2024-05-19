let originalData = {};

function loadIDList() {
    $.getJSON('get_id_list.php', function(data) {
        if (data.error) {
            console.error(data.error);
            return;
        }
        const $select = $('#idList');
        $select.empty();
        $select.append($('<option>'));
        $.each(data, function(index, id) {
            $select.append($('<option>').val(id['id']).text(id['id']));
        });
    });
}

function loadEmailList() {
    $.getJSON('get_email_list.php', function(data) {
        if (data.error) {
            console.error(data.error);
            return;
        }
        const $select = $('#emailList');
        $select.empty();
        $select.append($('<option>'));
        $.each(data, function(index, email) {
            $select.append($('<option>').val(email['email']).text(email['email']));
        });
    });
}

function enableSaveButton() {
    const formData = {
        nume: $('#FirstName').val(),
        prenume: $('#LastName').val(),
        telefon: $('#Phone').val(),
        email: $('#Email').val()
    };
    const isModified = Object.keys(formData).some(key => formData[key] !== originalData[key]);
    $('#saveBtn').prop('disabled', !isModified);
}

function selectById() {
    if ($('#idList').val() !== '') {
        loadItemDetails('id');
    } else {
        $('#FirstName, #LastName, #Phone, #Email').val('');
        $('#saveBtn').prop('disabled', true);
    }
}

function selectByEmail() {
    if ($('#emailList').val() !== '') {
        loadItemDetails('email');
    } else {
        $('#FirstName, #LastName, #Phone, #Email').val('');
        $('#saveBtn').prop('disabled', true);
    }
}

function loadItemDetails(type = '') {
    let value;
    if (type !== '') {
        if (type === 'id') {
            value = $('#idList').val();
        } else if (type === 'email') {
            value = $('#emailList').val();
        }

        $.ajax('get_item_details.php', {
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ type: type, value: value }),
            success: function(data) {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                originalData = data.data;
                $('#FirstName').val(data.data.nume);
                $('#LastName').val(data.data.prenume);
                $('#Phone').val(data.data.telefon);
                $('#Email').val(data.data.email);
                $('#saveBtn').prop('disabled', true);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching item details:', error);
            }
        });
    }
}

function saveUser() {
    const data = {
        id: originalData.id,
        nume: $('#FirstName').val(),
        prenume: $('#LastName').val(),
        telefon: $('#Phone').val(),
        email: $('#Email').val()
    };
    $.ajax({
        url: 'update_user.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            if (response.success) {
                alert(`The ${data.email} user has been updated`);
                originalData = data;
                $("#saveBtn").prop('disabled', true);
            } else {
                alert('An error occurred');
            }
        }
    });
}

$(window).on('beforeunload', function(event) {
    const formData = {
        nume: $('#FirstName').val(),
        prenume: $('#LastName').val(),
        telefon: $('#Phone').val(),
        email: $('#Email').val()
    };
    const isModified = Object.keys(formData).some(key => formData[key] !== originalData[key]);
    if (isModified) {
        event.preventDefault();
        event.returnValue = '';
    }
});

$(document).ready(function() {
    loadEmailList();
    loadIDList();
});