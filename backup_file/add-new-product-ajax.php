<?php
include_once './connect.php';
$table_products = '';
if (isset($_POST["product_name"])) {
    $product_name = $_POST["product_name"];
    $brand_id = $_POST["brand_id"];
    $category_id = $_POST["category_id"];
    $product_size = $_POST["product_size"];
    $product_unit_price = $_POST["product_unit_price"];
    $product_sale_price = $_POST["product_sale_price"];
    $product_description = $_POST["product_description"];
    $product_status = $_POST["product_status"];
    $upload_dir = "images/products/";
    $fileName = basename($_FILES["product_image"]["name"]);
    $targetFilePath = $upload_dir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFilePath)) {
            $product_image = $fileName;
        }
    }

    if (isset($product_name) && isset($product_description) && isset($brand_id) && isset($category_id) && isset($product_size) && isset($product_unit_price) && isset($product_sale_price) && isset($product_status) && isset($product_image)) {
        $sql = "INSERT INTO tbl_product (product_name, brand_id, category_id, product_size, product_unit_price, product_sale_price, product_description, product_status, product_image, created_at)
                VALUES ('$product_name', '$brand_id', '$category_id', '$product_size', '$product_unit_price', '$product_sale_price','$product_description', '$product_status', '$product_image', NOW())";
        $query = mysqli_query($connect, $sql);
        add_new_row($table_products);
        echo $table_products;
    } else {
        $table_products .= '<tr><td colspan="10">ERROR</td></tr>';
        echo $table_products;
    }

}

function add_new_row($table_products)
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
    $sql_table_body = "SELECT * FROM tbl_product ORDER BY created_at DESC LIMIT 1";
    $query_table_body = mysqli_query($connect, $sql_table_body);
    if (mysqli_num_rows($query_table_body) > 0) {
        $row_table_body = mysqli_fetch_array($query_table_body);
        $id_brand_table_body = $row_table_body["brand_id"];
        $sql_brand_table_body = "SELECT * FROM tbl_brand WHERE id='$id_brand_table_body'";
        $query_brand_table_body = mysqli_query($connect, $sql_brand_table_body);
        $row_brand_table_body = mysqli_fetch_array($query_brand_table_body);

        $id_category_table_body = $row_table_body["category_id"];
        $sql_category_table_body = "SELECT * FROM tbl_product_category WHERE id='$id_category_table_body'";
        $query_category_table_body = mysqli_query($connect, $sql_category_table_body);
        $row_category_table_body = mysqli_fetch_array($query_category_table_body);

        $table_products .= '<div id="add_new_row"></div>
            <tr id="tr-' . $row_table_body["id"] . '">
                <td>' . $row_table_body["id"] . '</td>
                <td>
                    <div class="avatar avatar-xl mr-3">
                        <img src="images/products/' . $row_table_body["product_image"] . '" alt="" srcset="">
                    </div>
                </td>
                <td>' . $row_table_body["product_name"] . '</td>
                <td>' . $row_brand_table_body["brand_name"] . '</td>
                <td>' . $row_category_table_body["category_name"] . '</td>
                <td>' . $row_table_body["product_size"] . '</td>
                <td>' . $row_table_body["product_unit_price"] . '</td>
                <td>' . $row_table_body["product_sale_price"] . '</td>

            ';
        if ($row_table_body["product_status"]) {
            $table_products .= '<td><span class="badge bg-success">Active</span></td>';
        } else {
            $table_products .= '<td><span class="badge bg-danger">Inactive</span></td>';
        }
        $table_products .= '
                        <td>
                            <div class="buttons">
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                <a style="margin: 2px 2.5px 2px 2.5px" onclick="return confirmDelete()" href="delete-product.php?id_product=' . $row_table_body["id"] . '" class="btn icon btn-danger"><i class="far fa-trash-alt"></i></a>
                            </div>
                        </td>
                        </tr>
            ';
    }
}
