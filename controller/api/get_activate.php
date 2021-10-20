<?php

include '../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $date = date('Y-m-d');

    $response = [];

    $sql = mysqli_query($conn, "SELECT active_from,active_until FROM tb_user_old WHERE email='$email'");

    if (mysqli_num_rows($sql) > 0) {
        while ($user = mysqli_fetch_assoc($sql)) {
            $date_active = $user['active_until'];

            $datefrom = new DateTime($date);
            $dateuntil = new DateTime($date_active);

            $subs = $datefrom->diff($dateuntil);
            if ($datefrom < $dateuntil) {
                $response['active_day'] = $subs->days;
                $response['subscribe'] = 'OK';
            } else if ($datefrom == $dateuntil) {
                $response['active_day'] = 0;
                $response['subscribe'] = 'OK';
            } else {
                $response['active_day'] = -1;
                $response['subscribe'] = 'ERROR';
            }

            $response['status'] = 'OK';
            $response['active_from'] = $user['active_from'];
            $response['active_until']  = $user['active_until'];
        }
    } else {
        $response['status'] = 'ERROR';
        $response['active_from'] = 'ERROR';
        $response['active_until']  = 'ERROR';
    }

    $conn->close();
    echo json_encode($response, JSON_PRETTY_PRINT);
}
