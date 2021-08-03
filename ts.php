<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/datatable/DataTables-1.10.25/css/dataTables.bootstrap5.min.css">
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/datatable/datatables.min.js"></script>
    <script src="assets/datatable/DataTables-1.10.25/js/dataTables.bootstrap5.min.js"></script>
</head>

<body>
    <textarea name="url" id="url" cols="10" rows="5"></textarea>
    <button type="button" onclick="scrapping()">Scrap</button>


    <script>
        function scrapping() {
            let url = $('#url').val();
            $.ajax({
                url: 'controller/getShopLazada.php',
                method: "get",
                data: {
                    url: url
                },
                dataType: 'json'
            }).done(function(data) {
                let json = JSON.parse(data);
                let list = json['mods']['listItems'];
                let i = 0;
                list.forEach(element => {
                    console.log(element['productUrl']);
                    console.log(i);
                    i++;
                });
            })
        }
    </script>
</body>

</html>