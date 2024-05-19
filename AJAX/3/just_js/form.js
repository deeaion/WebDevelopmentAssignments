let originalData={};

function loadIDList()
{
    fetch('get_id_list.php')
        .then(response => response.json())
        .then(data =>{
            if(data.error)
            {
                console.error(data.error);
                return;
            }
            const select = document.getElementById('idList');
            select.innerHTML='';
            select.appendChild(document.createElement('option'));
            data.forEach(id =>{
                const option = document.createElement('option');
                option.value = id['id'];
                option.textContent = id['id'];
                select.appendChild(option);
            });
        });

}
function loadEmailList()
{
    fetch('get_email_list.php')
        .then(response => response.json())
        .then(data =>{
            if(data.error)
            {
                console.error(data.error);
                return;
            }
            const select = document.getElementById('emailList');
            select.innerHTML='';
            select.appendChild(document.createElement('option'));
            data.forEach(email =>{
                const option = document.createElement('option');
                option.value = email['email'];
                option.textContent = email['email'];
                select.appendChild(option);
            });
        });
}
function enableSaveButton()
{
    const formData=
    {
        nume: document.getElementById('FirstName').value,
        prenume: document.getElementById('LastName').value,
        telefon: document.getElementById('Phone').value,
        email: document.getElementById('Email').value
    };
    const isModified= Object.keys(formData).some(key => formData[key] !== originalData[key]);
    document.getElementById("saveBtn").disabled=!isModified;

}
function selectById()
{
        if(document.getElementById('idList').value !== '')

            loadItemDetails('id');
        else
        {
            document.getElementById('FirstName').value = '';
            document.getElementById('LastName').value = '';
            document.getElementById('Phone').value = '';
            document.getElementById('Email').value = '';
            document.getElementById("saveBtn").disabled = true;

        }
}

function loadItemDetails(type = '') {
    let value;
    if (type !== '') {
        if (type === 'id') {
            value = document.getElementById('idList').value;
        } else if (type === 'email') {
            value = document.getElementById('emailList').value;
        }

        fetch('get_item_details.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ type: type, value: value }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    return;
                }
                originalData = data.data;
                console.log(data);
                document.getElementById('FirstName').value = data.data.nume;
                document.getElementById('LastName').value = data.data.prenume;
                document.getElementById('Phone').value = data.data.telefon;
                document.getElementById('Email').value = data.data.email;
                document.getElementById("saveBtn").disabled = true;
            })
            .catch(error => console.error('Error fetching item details:', error));
    }
}


function selectByEmail()
{
        if(document.getElementById('emailList').value !== '')
            loadItemDetails('email');
        else
        {
            document.getElementById('FirstName').value = '';
            document.getElementById('LastName').value = '';
            document.getElementById('Phone').value = '';
            document.getElementById('Email').value = '';
            document.getElementById("saveBtn").disabled = true;

        }
}

function saveUser()
{
    const data = {
        id: originalData.id,
        nume: document.getElementById('FirstName').value,
        prenume: document.getElementById('LastName').value,
        telefon: document.getElementById('Phone').value,
        email: document.getElementById('Email').value};
    fetch('update_user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    }).then(response => response.json())
        .then(data=>
        {
            if(data.success)
            {
                alert('The {email} user has been updated');
                originalData = data;
                document.getElementById("saveBtn").disabled=true;

            }
            else
            {
                alert('An error occurred');
            }
        });
}
window.addEventListener('beforeunload',(event)=>
{
    const formData=
    {
        nume: document.getElementById('nume').value,
        prenume: document.getElementById('prenume').value,
        telefon: document.getElementById('telefon').value,
        email: document.getElementById('email').value
    };
    const isModified= Object.keys(formData).some(key => formData[key] !== originalData[key]);
    if(isModified)
    {
        event.preventDefault();
        event.returnValue = '';
    }});
loadEmailList()
loadIDList();

