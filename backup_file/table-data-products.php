

<?php
$array_data = [];
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

        $ID = '<td>' . $row_table_body["id"] . '</td>';
        $Image = '<td>
                <div class="avatar avatar-xl mr-3">
                    <img src="images/products/' . $row_table_body["product_image"] . '" alt="" srcset="">
                </div>
            </td>';

        $Name = '<td>' . $row_table_body["product_name"] . '</td>';
        $Brand = '<td>' . $row_brand_table_body["brand_name"] . '</td>';
        $Category = ' <td>' . $row_category_table_body["category_name"] . '</td>';
        $Size = '<td>' . $row_table_body["product_size"] . '</td>';
        $Unit_Price = '<td>' . $row_table_body["product_unit_price"] . '</td>';
        $Sale_Price = '<td>' . $row_table_body["product_sale_price"] . '</td>';
        if ($row_table_body["product_status"]) {
            $Status = '<td><span class="badge bg-success">Active</span></td>';
        } else {
            $Status = '<td><span class="badge bg-danger">Inactive</span></td>';
        }
        $Edit = '
                    <td>
                        <div class="buttons">
                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></i></a>
                        </div>
                    </td>
        ';
        $array_row = [
            "ID" => $ID,
            "Image" => $Image,
            "Name" => $Name,
            "Brand" => $Brand,
            "Category" => $Category,
            "Size" => $Size,
            "Unit_Price" => $Unit_Price,
            "Sale_Price" => $Sale_Price,
            "Status" => $Status,
            "Edit" => $Edit,
        ];
        $array_data[$ID] = $array_row;
    }
}
?>

<script>
$myData = {
	"headings": [
        "ID",
        "Image",
        "Name",
        "Brand",
        "Category",
        "Size",
        "Unit Price",
        "Sale Price",
        "Status",
        "Edit"
	],
	"data": <?php echo $array_data; ?>
};
let table2 = document.querySelector('#table2');
 let dataTable = new simpleDatatables.DataTable(table2, {
 	data: myData
 });
</script>