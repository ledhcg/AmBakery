<?php
session_start();
include_once './connect.php';
$email_login = $_SESSION["email"];
$password_login = $_SESSION["password"];
$sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
$query = mysqli_query($connect, $sql);
$rows = mysqli_num_rows($query);
if ($rows > 0) {
    $id_brand = $_GET['id_brand'];
    $sql_delete = "DELETE FROM tbl_brand WHERE id='$id_brand'";
    $query_delete = mysqli_query($connect, $sql_delete);
    header('location: admin.php?page_layout=all_brands');
} else {
    header('location: login.php');
}
