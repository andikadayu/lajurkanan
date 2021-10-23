<?php

include '../config.php';

$email = $_POST['email'];
$dates = date('Y-m-d H:i:s');
$ids = 0;
$response = [];
$idn = 0;

$check = mysqli_query($conn, "SELECT id_user FROM tb_user WHERE email = '$email'");
if (mysqli_num_rows($check)) {
	while ($d = mysqli_fetch_assoc($check)) {
		$ids = $d['id_user'];
	}
	if ($ids != 0) {
		$sqlnew = mysqli_query($conn, "INSERT INTO tb_scrap VALUES(NULL,'$dates',1,'$ids')");
		$idn = mysqli_insert_id($conn);

		if ($sqlnew) {
			$response['status'] = "OK";
			$response['id_scrap'] = $idn;
		} else {
			$response['status'] = "ERROR";
		}
	}
} else {
	$response['status'] = "ERROR";
}

echo json_encode($response, JSON_PRETTY_PRINT);
