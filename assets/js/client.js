$(document).ready(function () {
    $('#datatables').DataTable();
});

function getData(id) {
    $.ajax({
        url: 'controller/api/get_manageadmin.php',
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
        $('#updateAdmin').modal('show');
    });
}

function deleteData(id) {
    let d = confirm('are you sure to delete this?');
    if (d == true) {
        $.ajax({
            url: 'controller/api/get_manageadmin.php',
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
    $.ajax({
        url: 'controller/api/get_manageadmin.php',
        method: "GET",
        data: {
            id: id,
            purpose: 'getbill'
        },
        dataType: 'json',

    }).done(function (resp) {
        $('#update_id_activate_lunas').val(id);
        $('#name_client_lunas').val(resp.name);
        $('#active_date_lunas').val(resp.active_date);
        $('#count_date_lunas').val(resp.count_date);
        $('#harga_regis_lunas').val(resp.harga_regis);
        $('#email_client_lunas').val(resp.email);
        $('#activateClientLunas').modal('show');
    })
}

function invoicebill(id) {
    $.ajax({
        url: 'controller/api/get_manageadmin.php',
        method: "GET",
        data: {
            id: id,
            purpose: 'getbill'
        },
        dataType: 'json',

    }).done(function (resp) {
        $('#update_id_activate').val(id);
        $('#name_client').val(resp.name);
        $('#active_date').val(resp.active_date);
        $('#count_date').val(resp.count_date);
        $('#harga_regis').val(resp.harga_regis);
        $('#email_client').val(resp.email);
        $('#activateClient').modal('show');
    })
}

function cetakInvoice(id) {
    $.ajax({
        url: 'controller/api/get_manageadmin.php',
        method: "GET",
        data: {
            id: id,
            purpose: 'getbill'
        },
        dataType: 'json',

    }).done(function (resp) {
        $('#update_id_activate_invoice').val(id);
        $('#name_client_invoice').val(resp.name);
        $('#active_date_invoice').val(resp.active_date);
        $('#count_date_invoice').val(resp.count_date);
        $('#harga_regis_invoice').val(resp.harga_regis);
        $('#email_client_invoice').val(resp.email);
        $('#activateClientInvoice').modal('show');
    })
}

function deactivate(id) {
    let a = confirm('are you sure to deactivate this user?');
    if (a == true) {
        $.ajax({
            url: 'controller/api/get_manageadmin.php',
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

