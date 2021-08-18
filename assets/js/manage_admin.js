$(document).ready(function () {
    $('#datatables').DataTable();
});

var myModal = new bootstrap.Modal(document.getElementById("updateAdmin"), {});

function getData(id) {
    $.ajax({
        url: 'controller/get_manageadmin.php',
        method: 'GET',
        data: {
            id: id,
            purpose: 'getData'
        },
        dataType: 'json'
    }).done(function (data) {
        $('#update_id_user').val(data[0].id_user);
        $('#update_name').val(data[0].name);
        $('#update_email').val(data[0].email);
        $('#update_no_telp').val(data[0].no_telp);
        $('#update_alamat').val(data[0].alamat);
        myModal.show();
    });
}

function deleteData(id) {
    let d = confirm('are you sure to delete this?');
    if (d == true) {
        $.ajax({
            url: 'controller/get_manageadmin.php',
            method: 'GET',
            data: {
                id: id,
                purpose: 'deleteData'
            }
        }).done(function (data) {
            if (data == 'success') {
                alert('success');
                location.reload();
            } else {
                alert('failed');
            }
        });
    }
}

function activate(id) {
    let a = confirm('are you sure to activate this user?');
    if (a == true) {
        $.ajax({
            url: 'controller/get_manageadmin.php',
            method: 'GET',
            data: {
                id: id,
                purpose: 'activateData'
            }
        }).done(function (data) {
            if (data == 'success') {
                alert('success');
                location.reload();
            } else {
                alert('failed');
            }
        });
    }
}

function deactivate(id) {
    let a = confirm('are you sure to deactivate this user?');
    if (a == true) {
        $.ajax({
            url: 'controller/get_manageadmin.php',
            method: 'GET',
            data: {
                id: id,
                purpose: 'deactivateData'
            }
        }).done(function (data) {
            if (data == 'success') {
                alert('success');
                location.reload();
            } else {
                alert('failed');
            }
        });
    }
}