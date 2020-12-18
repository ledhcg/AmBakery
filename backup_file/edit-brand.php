<?php

$id_brand = $_GET['id_brand'];
$sql = "SELECT * FROM tbl_brand WHERE id='$id_brand'";
$query = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($query);

if (isset($_POST["submit"])) {
    $brand_name = $_POST["brand_name"];
    $brand_description = $_POST["brand_description"];
    $brand_status = $_POST["brand_status"];
    if ($_FILES["brand_image"]["name"]) {
        $upload_dir = "images/brands/";
        $fileName = basename($_FILES["brand_image"]["name"]);
        $targetFilePath = $upload_dir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["brand_image"]["tmp_name"], $targetFilePath)) {
                $brand_image = $fileName;
            }
        }
        if (isset($brand_name) && isset($brand_description) && isset($brand_status) && isset($brand_image)) {
            $sql_update = "UPDATE tbl_brand SET brand_name='$brand_name', brand_description='$brand_description', brand_status='$brand_status', brand_image='$brand_image', updated_at=NOW()  WHERE id='$id_brand'";
            $query_update = mysqli_query($connect, $sql_update);
            header('location: admin.php?page_layout=all_brands');
        }
    } else {
        if (isset($brand_name) && isset($brand_description) && isset($brand_status)) {
            $sql_update = "UPDATE tbl_brand SET brand_name='$brand_name', brand_description='$brand_description', brand_status='$brand_status', updated_at=NOW()  WHERE id='$id_brand'";
            $query_update = mysqli_query($connect, $sql_update);
            header('location: admin.php?page_layout=all_brands');
        }
    }

}
?>

<section id="basic-vertical-layouts">
    <div class="row match-height">
        <div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit brand</h4>
            </div>
            <div class="card-content">
            <div class="card-body">
                <form role="form" method="post" enctype="multipart/form-data">

                <div class="form-body">
                        <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input type="text" id="" class="form-control" name="brand_name"
                                value="<?php echo $row['brand_name']; ?>"  required>
                            </div>

                            <div class="form-group">
                             <label for="" class="form-label">Status</label>
                                <select class="choices form-select" name="brand_status">

                                <option value="1" <?php if ($row['brand_status']) {
    echo "selected";
}
?>>Active</option>
                                <option value="0" <?php if (!$row['brand_status']) {
    echo "selected";
}
?>>Inactive</option>

                                </select>
                            </div>


                            <div class="form-group">
                                <label for="" class="form-label">Description</label>
                                <textarea class="form-control" id="" rows="3" name="brand_description" required><?php echo $row['brand_description']; ?></textarea>
                            </div>
                        </div>


                        <div class="col-md-4 col-12">
                        <div class="form-group">

                            <label for="" class="form-label">Image</label>
                            <div class="form-file">

                                        <input type="file" class="form-file-input" name="brand_image" id="file-upload" value="<?php echo $row['brand_image']; ?>">
                                        <label class="form-file-label" for="customFile">
                                            <span class="form-file-text" id="file-name">Change file...</span>
                                            <span class="form-file-button btn-primary "><i data-feather="upload"></i></span>
                                        </label>
                                    </div>
                            </div>
                            <label for="" class="form-label">Preview</label>

                            <div class="card">
                                    <div class="card-content">

                                        <img class="card-img img-fluid" id="imagePreview" src="images/brands/<?php echo $row['brand_image']; ?>" alt="" >
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
                            <a href="admin.php?page_layout=all_brands" class="btn btn-light-secondary mr-1 mb-1">Cancel</a>
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
