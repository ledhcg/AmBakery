<?php
include_once './connect.php';

$id_dealer = $_POST["dealer_id"];
$table_dealers = '';

if (isset($id_dealer)) {
    $dealer_name = $_POST["dealer_name"];
    $dealer_email = $_POST["dealer_email"];
    $dealer_phone = $_POST["dealer_phone"];
    $dealer_address = $_POST["dealer_address"];
    $dealer_dob = $_POST["dealer_dob"];
    $dealer_gender = $_POST["dealer_gender"];

    if (isset($dealer_name)
        && isset($dealer_email)
        && isset($dealer_phone)
        && isset($dealer_address)
        && isset($dealer_dob)
        && isset($dealer_gender)) {
        $sql_update = "UPDATE tbl_dealer SET
            dealer_name = '$dealer_name',
            dealer_email ='$dealer_email',
            dealer_phone ='$dealer_phone',
            dealer_address ='$dealer_address',
            dealer_dob = '$dealer_dob',
            dealer_gender = '$dealer_gender',
            updated_at = NOW()
            WHERE id='$id_dealer'";
        $query_update = mysqli_query($connect, $sql_update);
        update_row($id_dealer, $table_dealers);
        echo $table_dealers;
    }
}

function update_row($id_dealer, $table_dealers)
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
    $sql_table_body = "SELECT * FROM tbl_dealer WHERE id='$id_dealer'";
    $query_table_body = mysqli_query($connect, $sql_table_body);
    if (mysqli_num_rows($query_table_body) > 0) {
        $row_table_body = mysqli_fetch_array($query_table_body);

        $table_dealers .= '
            <tr id="tr-' . $row_table_body["id"] . '">
                <td>' . $row_table_body["id"] . '</td>
                <td>' . $row_table_body["dealer_name"] . '</td>
                <td>' . $row_table_body["dealer_email"] . '</td>
                <td>' . $row_table_body["dealer_phone"] . '</td>
                <td>' . $row_table_body["dealer_address"] . '</td>
                <td>' . $row_table_body["dealer_dob"] . '</td>
                <td>' . $row_table_body["dealer_gender"] . '</td>
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
