$(document).ready(function () {
    $('#datatables').DataTable();
});

function activate(id) {
    $.ajax({
        url: 'controller/api/get_manageadmin.php',
        method: "GET",
        data: {
            id: id,
            purpose: 'getbillsub'
        },
        dataType: 'json',

    }).done(function (resp) {
        $('#update_id_activate_lunas').val(id);
        $('#name_client_lunas').val(resp.name);
        $('#active_date_lunas').val(resp.active_date);
        $('#active_from_lunas').val(resp.active_from);
        $('#active_until_lunas').val(resp.active_until);
        $('#count_date_lunas').val(resp.count_date);
        $('#harga_subscribe_lunas').val(resp.harga_regis);
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
            purpose: 'getbillsub'
        },
        dataType: 'json',

    }).done(function (resp) {
        $('#update_id_activate').val(id);
        $('#name_client').val(resp.name);
        $('#active_date').val(resp.active_date);
        $('#count_date').val(resp.count_date);
        $('#harga_subscribe').val(resp.harga_regis);
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
            purpose: 'getbillsub'
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