<?php
//Load Composer's autoloader
require  __DIR__ . '/vendor/autoload.php';

ini_set('max_execution_time', '3600');
set_time_limit(3600);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('EMAIL_USERNAME')->notEmpty();
$dotenv->required('EMAIL_PASSWORD')->notEmpty();
$dotenv->required('NAME_APP')->notEmpty();
$dotenv->required('DB_HOST')->notEmpty();
$dotenv->required('DB_USER')->notEmpty();
$dotenv->required('DB_NAME')->notEmpty();

date_default_timezone_set('Asia/Jakarta');

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db = $_ENV['DB_NAME'];

$conn = mysqli_connect($host, $user, $pass, $db) or die(mysqli_connect_error());
