<?php
if (isset($_POST["submit"])) {
    $product_name = $_POST["product_name"];
    $brand_id = $_POST["brand_id"];
    $category_id = $_POST["category_id"];
    $product_size = $_POST["product_size"];
    $product_unit_price = $_POST["product_unit_price"];
    $product_sale_price = $_POST["product_sale_price"];
    $product_description = $_POST["product_description"];
    $product_status = $_POST["product_status"];
    //$product_image = $_POST["product_image"];

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
        move_uploaded_file($tem_filename, $upload_dir . '/' . $product_name);
        $sql = "INSERT INTO tbl_product (product_name, brand_id, category_id, product_size, product_unit_price, product_sale_price, product_description, product_status, product_image, created_at)
                VALUES ('$product_name', '$brand_id', '$category_id', '$product_size', '$product_unit_price', '$product_sale_price','$product_description', '$product_status', '$product_image', NOW())";
        $query = mysqli_query($connect, $sql);
        header('location: admin.php?page_layout=all_products');
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
                <h4 class="card-title">Add a new product</h4>
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
                                placeholder="Name"  required>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Category</label>
                                        <select class="choices form-select" name="category_id" required>
                                        <option value="" selected>CHOOSE...</option>
                                        <?php
while ($row_category = mysqli_fetch_array($query_category)) {
    ?>
                            <option value=" <?php echo $row_category["id"]; ?>"> <?php echo $row_category["category_name"]; ?> </option>
                                        <?php
}
?>
                                        </select>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Brand</label>
                                        <select class="choices form-select" name="brand_id" required>
                                        <option value="" selected >CHOOSE...</option>
                                        <?php
while ($row_brand = mysqli_fetch_array($query_brand)) {
    ?>
                            <option value=" <?php echo $row_brand["id"]; ?>"> <?php echo $row_brand["brand_name"]; ?> </option>
                                        <?php
}
?>
                                        </select>
                            </div>


                            <div class="form-group">
                             <label for="" class="form-label">Status</label>
                                        <select class="choices form-select" name="product_status">

                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>

                                        </select>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Price</label>
                            <input type="text" id="" class="form-control" name="product_unit_price"
                                placeholder="Price" required>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Sale price</label>
                            <input type="text" id="" class="form-control" name="product_sale_price"
                                placeholder="Sale price" required>
                            </div>

                            <div class="form-group">
                            <label for="" class="form-label">Size</label>
                            <input type="text" id="" class="form-control" name="product_size"
                                placeholder="Size" required>
                            </div>


                            <div class="form-group">
                                <label for="" class="form-label">Description</label>
                                <textarea maxlength="150" class="form-control" id="" rows="3" name="product_description" placeholder="Description"  required></textarea>
                            </div>
                        </div>


                        <div class="col-md-4 col-12">
                        <div class="form-group">

                            <label for="" class="form-label">Image</label>
                            <div class="form-file">

                                        <input type="file" class="form-file-input" name="product_image" id="file-upload" value="" required>
                                        <label class="form-file-label" for="customFile">
                                            <span class="form-file-text" id="file-name">Choose file...</span>
                                            <span class="form-file-button btn-primary "><i data-feather="upload"></i></span>
                                        </label>
                                    </div>
                            </div>
                            <label for="" class="form-label">Preview</label>

                            <div class="card">
                                    <div class="card-content">

                                        <img class="card-img img-fluid" id="imagePreview" src="images/templates/upload_image.jpg" alt="" >
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
                            <button type="submit" class="btn btn-primary mr-1 mb-1" name="submit">Add</button>
                            <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
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
