<?php
include_once './connect.php';
$sql = "SELECT * FROM tbl_product ORDER BY id ASC";
$query = mysqli_query($connect, $sql);

$table_products = '';
$sql_table_body = "SELECT * FROM tbl_product ORDER BY id DESC";
$query_table_body = mysqli_query($connect, $sql_table_body);

if (mysqli_num_rows($query_table_body) > 0) {
    while ($row_table_body = mysqli_fetch_array($query_table_body)) {

        $id_brand_table_body = $row_table_body["brand_id"];
        $sql_brand_table_body = "SELECT * FROM tbl_brand WHERE id='$id_brand_table_body'";
        $query_brand_table_body = mysqli_query($connect, $sql_brand_table_body);
        $row_brand_table_body = mysqli_fetch_array($query_brand_table_body);

        $id_category_table_body = $row_table_body["category_id"];
        $sql_category_table_body = "SELECT * FROM tbl_product_category WHERE id='$id_category_table_body'";
        $query_category_table_body = mysqli_query($connect, $sql_category_table_body);
        $row_category_table_body = mysqli_fetch_array($query_category_table_body);

        $table_products .= '
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
                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                        </div>
                    </td>
                </tr>

        ';
    }
}

echo $table_products;
