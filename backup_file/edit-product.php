<?php

$id_product = $_GET['id_product'];
$sql = "SELECT * FROM tbl_product WHERE id='$id_product'";
$query = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($query);

if (isset($_POST["submit"])) {
    $product_name = $_POST["product_name"];
    $product_description = $_POST["product_description"];
    $product_status = $_POST["product_status"];
    $category_id = $_POST["category_id"];
    $brand_id = $_POST["brand_id"];
    $product_unit_price = $_POST["product_unit_price"];
    $product_sale_price = $_POST["product_sale_price"];
    $product_size = $_POST["product_size"];

    if ($_FILES["product_image"]["name"]) {
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
            $sql_update = "UPDATE tbl_product SET product_name='$product_name', product_description='$product_description', product_status='$product_status', category_id='$category_id', brand_id='$brand_id', product_unit_price='$product_unit_price', product_sale_price='$product_sale_price' , product_size='$product_size', product_image='$product_image', updated_at=NOW()  WHERE id='$id_product'";
            $query_update = mysqli_query($connect, $sql_update);
            header('location: admin.php?page_layout=all_products');
        }
    } else {
        if (isset($product_name) && isset($product_description) && isset($brand_id) && isset($category_id) && isset($product_size) && isset($product_unit_price) && isset($product_sale_price) && isset($product_status)) {
            $sql_update = "UPDATE tbl_product SET product_name='$product_name', product_description='$product_description', product_status='$product_status', category_id='$category_id', brand_id='$brand_id', product_unit_price='$product_unit_price', product_sale_price='$product_sale_price' , product_size='$product_size', updated_at=NOW()  WHERE id='$id_product'";
            $query_update = mysqli_query($connect, $sql_update);
            header('location: admin.php?page_layout=all_products');
        }
    }

}

$sql_brand = "SELECT * FROM tbl_brand ORDER BY id ASC";
$query_brand = mysqli_query($connect, $sql_brand);

$sql_category = "SELECT * FROM tbl_product_category ORDER BY id ASC";
$query_category = mysqli_query($connect, $sql_category);
?>

<section id="basic-vertical-layouts">
    <div class="row match-height">
        <div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit product</h4>
            </div>
            <div class="card-content">
            <div class="card-body">
                <form role="form" method="post" enctype="multipart/form-data">

                <div class="form-body">
                        <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input type="text" id="" class="form-control" name="product_name"
                                value="<?php echo $row['product_name']; ?>"  required>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Category</label>
                                        <select class="choices form-select" name="category_id" required>

                                        <?php
while ($row_category = mysqli_fetch_array($query_category)) {
    ?>
                            <option value=" <?php echo $row_category["id"]; ?>" <?php if ($row_category["id"] == $row['category_id']) {
        echo "selected";
    }
    ?>> <?php echo $row_category["category_name"]; ?> </option>
                                        <?php
}
?>
                                        </select>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Brand</label>
                                        <select class="choices form-select" name="brand_id" required>

                                        <?php
while ($row_brand = mysqli_fetch_array($query_brand)) {
    ?>
                            <option value=" <?php echo $row_brand["id"]; ?>" <?php if ($row_brand["id"] == $row['brand_id']) {
        echo "selected";
    }
    ?> > <?php echo $row_brand["brand_name"]; ?> </option>
                                        <?php
}
?>
                                        </select>
                            </div>




                            <div class="form-group">
                             <label for="" class="form-label">Status</label>
                                <select class="choices form-select" name="product_status">

                                <option value="1" <?php if ($row['product_status']) {
    echo "selected";
}
?>>Active</option>
                                <option value="0" <?php if (!$row['product_status']) {
    echo "selected";
}
?>>Inactive</option>

                                </select>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Price</label>
                            <input type="text" id="" class="form-control" name="product_unit_price"
                            value="<?php echo $row['product_unit_price']; ?>" required>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Sale price</label>
                            <input type="text" id="" class="form-control" name="product_sale_price"
                            value="<?php echo $row['product_sale_price']; ?>" required>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Size</label>
                            <input type="text" id="" class="form-control" name="product_size"
                            value="<?php echo $row['product_size']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="" class="form-label">Description</label>
                                <textarea class="form-control" id="" rows="3" name="product_description" required><?php echo $row['product_description']; ?></textarea>
                            </div>
                        </div>


                        <div class="col-md-4 col-12">
                        <div class="form-group">

                            <label for="" class="form-label">Image</label>
                            <div class="form-file">

                                        <input type="file" class="form-file-input" name="product_image" id="file-upload" value="<?php echo $row['product_image']; ?>">
                                        <label class="form-file-label" for="customFile">
                                            <span class="form-file-text" id="file-name">Change file...</span>
                                            <span class="form-file-button btn-primary "><i data-feather="upload"></i></span>
                                        </label>
                                    </div>
                            </div>
                            <label for="" class="form-label">Preview</label>

                            <div class="card">
                                    <div class="card-content">

                                        <img class="card-img img-fluid" id="imagePreview" src="images/products/<?php echo $row['product_image']; ?>" alt="" >
                                    </div>
                            </div>
                        </div>
                        </div>

                        <script>

//Write filename into span tag
document.getElementById('file-upload').onchange = function () {
    readURL(this);
  var filePath = this.value;
    if (filePath) {
      var fileName = filePath.replace(/^.*?([^\\\/]*)$/, '$1');
      document.getElementById('file-name').innerHTML = fileName;
    }
  };

//Change link preview
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("imagePreview").src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }

}

                        </script>

                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mr-1 mb-1" name="submit">Apply</button>
                            <a href="admin.php?page_layout=all_products" class="btn btn-light-secondary mr-1 mb-1">Cancel</a>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
