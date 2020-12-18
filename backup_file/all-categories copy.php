<?php
$sql = "SELECT * FROM tbl_product_category ORDER BY id ASC";
$query = mysqli_query($connect, $sql);

?>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>ALL CATEGORIES</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Categories</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="buttons">
                <a href="admin.php?page_layout=add_new_category" class="btn btn-primary">Add a new category</a>
                </div>
            </div>

            <div class="card-body">
                <table class='table table-hover' id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description	</th>
                            <th>Status</th>
                            <th>Edit</th>
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
                                    <img src="images/categories/<?php echo $row["category_image"]; ?>" alt="" srcset="">
                                </div>
                            </td>
                            <td><?php echo $row["category_name"]; ?></td>
                            <td><?php echo $row["category_description"]; ?></td>
                            <td>
<?php
if ($row["category_status"]) {
        echo "<span class=\"badge bg-success\">Active</span>";
    } else {
        echo "<span class=\"badge bg-danger\">Inactive</span>";
    }
    ?>

                            </td>
                            <td>
                                <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="admin.php?page_layout=edit_category&id_category=<?php echo $row["id"]; ?>" class="btn icon btn-primary"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" onclick="return confirmDelete()" href="delete-category.php?id_category=<?php echo $row["id"]; ?>" class="btn icon btn-danger"><i class="far fa-trash-alt"></i></i></a>
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