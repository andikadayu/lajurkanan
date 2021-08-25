$(document).ready(function () {
    $('#datatables').DataTable();
});

function getShops() {
    let re = $('#shop_link').val();
    $('#linksssp').empty();
    $.ajax({
        url: 'controller/getShopLazada.php',
        method: "get",
        data: {
            url: re
        },
        dataType: 'json'
    }).done(function (data) {
        let json = JSON.parse(data);
        let list = json['mods']['listItems'];
        let i = 0;
        let links;
        let cleanlinks;
        let cleanlinkss;
        list.forEach(element => {
            links = element['productUrl'];
            cleanlinks = links.replace('//', 'https://');
            cleanlinkss = cleanlinks.replace('products/', '');
            $('#linksssp').append(`<div class='form-group'><input type='hidden' name='links[${i}]' value='${cleanlinkss}' class='form-control' required></div>`);
            i++;
        });
        $('#labellink').removeClass('bg-danger');
        $('#labellink').addClass('bg-success');
        $('#labellink').text("Get Shop Product Done, Go to Scrap");
        $('#scBtn1').attr('disabled', false);
    });
}

function cetakExcel(id) {
    $('#ex_id_scrap').val(id);
}

function getAllLink() {
    $('#linksss').empty();
    let alllink = $('#all_link').val();
    let link = alllink.replace(/\n/g, ",");;
    let array_link = link.split(',');
    let array_length = array_link.length;
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
                shop: 'lazada',
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