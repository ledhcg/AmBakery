<?php
if (isset($_POST["submit"])) {
    $category_name = $_POST["category_name"];
    $category_description = $_POST["category_description"];
    $category_status = $_POST["category_status"];
    //$category_image = $_POST["category_image"];

    $upload_dir = "images/categories/";
    $fileName = basename($_FILES["category_image"]["name"]);
    $targetFilePath = $upload_dir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $targetFilePath)) {
            $category_image = $fileName;
        }
    }

    if (isset($category_name) && isset($category_description) && isset($category_status) && isset($category_image)) {
        move_uploaded_file($tem_filename, $upload_dir . '/' . $category_name);
        $sql = "INSERT INTO tbl_product_category (category_name, category_description, category_status, category_image, created_at)
                VALUES ('$category_name', '$category_description', '$category_status', '$category_image', NOW())";
        $query = mysqli_query($connect, $sql);
        header('location: admin.php?page_layout=all_categories');
    }
}

?>

<section id="basic-vertical-layouts">
    <div class="row match-height">
        <div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add a new category</h4>
            </div>
            <div class="card-content">
            <div class="card-body">
                <form role="form" method="post" enctype="multipart/form-data">

                <div class="form-body">
                        <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="form-group">
                            <label for="" class="form-label">Name</label>
                            <input type="text" id="" class="form-control" name="category_name"
                                placeholder="Name"  required>
                            </div>

                            <div class="form-group">
                             <label for="" class="form-label">Status</label>
                                        <select class="choices form-select" name="category_status">

                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>

                                        </select>
                            </div>


                            <div class="form-group">
                                <label for="" class="form-label">Description</label>
                                <textarea maxlength="150" class="form-control" id="" rows="5" name="category_description" placeholder="Description"  required></textarea>
                            </div>
                        </div>


                        <div class="col-md-4 col-12">
                        <div class="form-group">

                            <label for="" class="form-label">Image</label>
                            <div class="form-file">

                                        <input type="file" class="form-file-input" name="category_image" id="file-upload" value="" required>
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
