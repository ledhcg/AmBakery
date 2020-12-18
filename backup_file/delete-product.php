<?php
session_start();
include_once './connect.php';
$email_login = $_SESSION["email"];
$password_login = $_SESSION["password"];
$sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
$query = mysqli_query($connect, $sql);
$rows = mysqli_num_rows($query);
if ($rows > 0) {
    $id_product = $_GET['id_product'];
    $sql_delete = "DELETE FROM tbl_product WHERE id='$id_product'";
    $query_delete = mysqli_query($connect, $sql_delete);
    header('location: admin.php?page_layout=all_products');
} else {
    header('location: login.php');
}
