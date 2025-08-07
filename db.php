<?php
$host = '172.31.22.43';
$user = 'Don200620704';
$password = 'I0AwQEhw02';
$db = 'Don200620704';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>