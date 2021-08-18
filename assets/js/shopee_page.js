$(document).ready(function () {
    $('#datatables').DataTable();
});


function checkMarkups(nm) {
    if (nm == 'rumus') {
        $('#rumus').attr('disabled', false);
        $('#metode_markup').attr('disabled', true);
        $('#nilai_markup').attr('disabled', true);
    } else {
        $('#rumus').attr('disabled', true);
        $('#metode_markup').attr('disabled', false);
        $('#nilai_markup').attr('disabled', false);
    }
}

function cetakExcel(id) {
    $('#ex_id_scrap').val(id);
}

function getAllLink() {
    $('#linksss').empty();
    let links = $('#all_link').val();
    let alllink = links.replace(/['"]+/g, '');
    let link = alllink.replace(/\n/g, ",");;
    let array_link = link.split(',');
    let i = 0;
    array_link.forEach(element => {
        $('#linksss').append(`<div class='form-group'><input type='hidden' name='links[${i}]' value='${element}' class='form-control' required></div>`);
        i++;
    });
    $('#scBtn').attr('disabled', false);
    $('#all_badge').removeClass('bg-danger');
    $('#all_badge').addClass('bg-success');
    $('#all_badge').text('Success Go to Scrap');

}

function deleteScrap(id) {
    let r = confirm("Are you sure delete thhis data?");
    if (r == true) {
        $.ajax({
            url: 'controller/deleting_scrap.php',
            method: 'GET',
            data: {
                shop: 'shopee',
                id: id
            }
        }).done(function (data) {
            if (data == 'success') {
                alert('success');
                location.reload();
            } else {
                alert('failed');
            }
        })
    }
}