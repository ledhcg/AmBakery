<?php
$sql = "SELECT * FROM tbl_product ORDER BY id ASC";
$query = mysqli_query($connect, $sql);

?>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>ALL PRODUCTS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All products</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
            <div class="buttons">
                <a href="admin.php?page_layout=add_new_product" class="btn btn-primary">Add a new product</a>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-hover' id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Category</th>

                            <th>Size</th>
                            <th>Unit Price</th>
                            <th>Sale Price</th>
                            <th>Status</th>
                            <th style="width:10%">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
while ($row = mysqli_fetch_array($query)) {

    ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td>
                                <div class="avatar avatar-xl mr-3">
                                    <img src="images/products/<?php echo $row["product_image"]; ?>" alt="" srcset="">
                                </div>
                            </td>
                            <td><?php echo $row["product_name"]; ?></td>

                            <td>
<?php
$id_brand = $row["brand_id"];
    $sql_brand = "SELECT * FROM tbl_brand WHERE id='$id_brand'";
    $query_brand = mysqli_query($connect, $sql_brand);
    $row_brand = mysqli_fetch_array($query_brand);
    echo $row_brand["brand_name"];
    ?>
                            </td>
                            <td>
<?php
$id_category = $row["category_id"];
    $sql_category = "SELECT * FROM tbl_product_category WHERE id='$id_category'";
    $query_category = mysqli_query($connect, $sql_category);
    $row_category = mysqli_fetch_array($query_category);
    echo $row_category["category_name"];
    ?>
                            </td>

                            <td><?php echo $row["product_size"]; ?></td>
                            <td><?php echo $row["product_unit_price"]; ?></td>
                            <td><?php echo $row["product_sale_price"]; ?></td>
                            <td>
<?php
if ($row["product_status"]) {
        echo "<span class=\"badge bg-success\">Active</span>";
    } else {
        echo "<span class=\"badge bg-danger\">Inactive</span>";
    }
    ?>

                            </td>
                            <td>
                                <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="admin.php?page_layout=edit_product&id_product=<?php echo $row["id"]; ?>" class="btn icon btn-primary"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" onclick="return confirmDelete()" href="delete-product.php?id_product=<?php echo $row["id"]; ?>" class="btn icon btn-danger"><i class="far fa-trash-alt"></i></i></a>
                                </div>
                            </td>
                        </tr>
<?php
}
?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>

    <script>

    function confirmDelete(){
        var conf = confirm("Do you want to delete?");
        return conf;
    }

    </script>