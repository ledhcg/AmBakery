<?php
include_once './connect.php';
$table_dealers = '';

if (isset($_POST["dealer_name"])) {

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
        $sql = "INSERT INTO tbl_dealer (
                dealer_name,
                dealer_email,
                dealer_phone,
                dealer_address,
                dealer_dob,
                dealer_gender,
                created_at
                )
                VALUES (
                '$dealer_name',
                '$dealer_email',
                '$dealer_phone',
                '$dealer_address',
                '$dealer_dob',
                '$dealer_gender',
                NOW()
                )";
        $query = mysqli_query($connect, $sql);
        add_new_row($table_dealers);
        echo $table_dealers;

    } else {
        $table_dealers .= '<tr><td colspan="10">ERROR</td></tr>';
        echo $table_dealers;
    }

}

function add_new_row($table_dealers)
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

    $sql_table_body = "SELECT * FROM tbl_dealer ORDER BY created_at DESC LIMIT 1";
    $query_table_body = mysqli_query($connect, $sql_table_body);

    if (mysqli_num_rows($query_table_body) > 0) {
        $row_table_body = mysqli_fetch_array($query_table_body);
        $table_dealers .= '
                <div id="add_new_row"></div>
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
