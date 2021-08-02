 <?php
    include '../config.php';

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = mysqli_query($conn, "UPDATE tb_user SET code=NULL, password='$password' WHERE email='$email'");

    if ($sql) {
        echo "<script>
     alert('Change Password Success');
     location.href = '../index.php';
 </script>";
    } else {
        echo "<script>
     alert('Error');
     location.href = '../remember.php';
 </script>";
    }

    $conn->close();
