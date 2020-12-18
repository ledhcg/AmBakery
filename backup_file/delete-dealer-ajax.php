<?php
session_start();
include_once './connect.php';
$email_login = $_SESSION["email"];
$password_login = $_SESSION["password"];
$sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
$query = mysqli_query($connect, $sql);
$rows = mysqli_num_rows($query);
if ($rows > 0) {
    $id_dealer = $_POST['id'];
    $sql_delete = "DELETE FROM tbl_dealer WHERE id='$id_dealer'";
    $query_delete = mysqli_query($connect, $sql_delete);
} else {
    header('location: login.php');
}
