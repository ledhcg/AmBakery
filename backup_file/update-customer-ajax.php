<?php
include_once './connect.php';

$id_customer = $_POST["customer_id"];
$table_customers = '';

if (isset($id_customer)) {
    $customer_name = $_POST["customer_name"];
    $customer_email = $_POST["customer_email"];
    $customer_phone = $_POST["customer_phone"];
    $customer_address = $_POST["customer_address"];
    $customer_dob = $_POST["customer_dob"];
    $customer_gender = $_POST["customer_gender"];

    if (isset($customer_name)
        && isset($customer_email)
        && isset($customer_phone)
        && isset($customer_address)
        && isset($customer_dob)
        && isset($customer_gender)) {
        $sql_update = "UPDATE tbl_customer SET
            customer_name = '$customer_name',
            customer_email ='$customer_email',
            customer_phone ='$customer_phone',
            customer_address ='$customer_address',
            customer_dob = '$customer_dob',
            customer_gender = '$customer_gender',
            updated_at = NOW()
            WHERE id='$id_customer'";
        $query_update = mysqli_query($connect, $sql_update);
        update_row($id_customer, $table_customers);
        echo $table_customers;
    }
}

function update_row($id_customer, $table_customers)
{
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "db_bakery";
    $connect = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);
    if ($connect) {
        $setLang = mysqli_query($connect, "SET NAMES 'utf8'");
    } else {
        die("Connection Refused" . mysqli_connect_error());
    }
    $sql_table_body = "SELECT * FROM tbl_customer WHERE id='$id_customer'";
    $query_table_body = mysqli_query($connect, $sql_table_body);
    if (mysqli_num_rows($query_table_body) > 0) {
        $row_table_body = mysqli_fetch_array($query_table_body);

        $table_customers .= '
            <tr id="tr-' . $row_table_body["id"] . '">
                <td>' . $row_table_body["id"] . '</td>
                <td>' . $row_table_body["customer_name"] . '</td>
                <td>' . $row_table_body["customer_email"] . '</td>
                <td>' . $row_table_body["customer_phone"] . '</td>
                <td>' . $row_table_body["customer_address"] . '</td>
                <td>' . $row_table_body["customer_dob"] . '</td>
                <td>' . $row_table_body["customer_gender"] . '</td>
                <td>
                    <div class="buttons">
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
        ';
    }
}
