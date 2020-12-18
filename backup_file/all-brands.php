<?php
$sql = "SELECT * FROM tbl_brand ORDER BY id ASC";
$query = mysqli_query($connect, $sql);

?>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>ALL BRANDS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Brands</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="buttons">
                <a href="admin.php?page_layout=add_new_brand" class="btn btn-primary">Add a new brand</a>
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
                                    <img src="images/brands/<?php echo $row["brand_image"]; ?>" alt="" srcset="">
                                </div>
                            </td>
                            <td><?php echo $row["brand_name"]; ?></td>
                            <td><?php echo $row["brand_description"]; ?></td>
                            <td>
<?php
if ($row["brand_status"]) {
        echo "<span class=\"badge bg-success\">Active</span>";
    } else {
        echo "<span class=\"badge bg-danger\">Inactive</span>";
    }
    ?>

                            </td>
                            <td>
                                <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="admin.php?page_layout=edit_brand&id_brand=<?php echo $row["id"]; ?>" class="btn icon btn-primary"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" onclick="return confirmDelete()" href="delete-brand.php?id_brand=<?php echo $row["id"]; ?>" class="btn icon btn-danger"><i class="far fa-trash-alt"></i></i></a>
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