<?php
session_start();
include_once './connect.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {

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
        if (isset($product_name)
            && isset($brand_id)
            && isset($category_id)
            && isset($product_size)
            && isset($product_unit_price)
            && isset($product_sale_price)
            && isset($product_description)
            && isset($product_status)
            && isset($product_image)) {
            $sql = "INSERT INTO tbl_product (
                product_name,
                brand_id,
                category_id,
                product_size,
                product_unit_price,
                product_sale_price,
                product_description,
                product_status,
                product_stock,
                product_image,
                created_at
                )
                VALUES (
                '$product_name',
                '$brand_id',
                '$category_id',
                '$product_size',
                '$product_unit_price',
                '$product_sale_price',
                '$product_description',
                '$product_status',
                '0',
                '$product_image',
                NOW()
                )";
            $query = mysqli_query($connect, $sql);

            $modal_edit = '';
            $modal_delete = '';

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

                //--------------- Start EDIT MODAL ---------------
                $modal_edit .= '
                        <div class="modal fade text-left w-100 modal-borderless" id="edit-modal-' . $row_table_body["id"] . '" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel16" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                    <h4 class="modal-title white" id="myModalLabel16">Edit product</h4>
                                    </div>
                                    <div class="modal-body">
                ';

                $sql_brand_edit = "SELECT * FROM tbl_brand ORDER BY id ASC";
                $query_brand_edit = mysqli_query($connect, $sql_brand_edit);

                $sql_category_edit = "SELECT * FROM tbl_product_category ORDER BY id ASC";
                $query_category_edit = mysqli_query($connect, $sql_category_edit);

                $modal_edit .= '
                                            <div class="form-body">
                                                <form id="edit-form' . $row_table_body['id'] . '">

                                                <div class="row">
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-group">
                                                        <label for="" class="form-label">Name</label>
                                                        <input type="text" id="product_name' . $row_table_body['id'] . '" class="form-control" name="product_name' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['product_name'] . '"  required>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Category</label>
                                                            <select class="js-choices-edit-category' . $row_table_body['id'] . ' form-select"  id="category_id' . $row_table_body['id'] . '" name="category_id' . $row_table_body['id'] . '" required>
                                                            <option value="" selected>CHOOSE...</option>
                ';

                while ($row_category_edit = mysqli_fetch_array($query_category_edit)) {
                    $modal_edit .= '<option value="' . $row_category_edit["id"] . '"';

                    if ($row_category_edit["id"] == $row_table_body['category_id']) {
                        $modal_edit .= 'selected>' . $row_category_edit["category_name"] . '</option>';
                    } else {
                        $modal_edit .= '>' . $row_category_edit["category_name"] . '</option>';
                    }
                }

                $modal_edit .= '
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Brand</label>
                                                            <select class="js-choices-edit-brand' . $row_table_body['id'] . ' form-select" id="brand_id' . $row_table_body['id'] . '" name="brand_id' . $row_table_body['id'] . '" required>
                                                            <option value="" selected >CHOOSE...</option>
                ';

                while ($row_brand_edit = mysqli_fetch_array($query_brand_edit)) {
                    $modal_edit .= '<option value="' . $row_brand_edit["id"] . '"';
                    if ($row_brand_edit["id"] == $row_table_body['brand_id']) {
                        $modal_edit .= 'selected>' . $row_brand_edit["brand_name"] . '</option>';
                    } else {
                        $modal_edit .= '>' . $row_brand_edit["brand_name"] . '</option>';
                    }
                }

                $modal_edit .= '
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Status</label>
                                                            <select class="js-choices-edit-status' . $row_table_body['id'] . ' form-select" id="product_status' . $row_table_body['id'] . '" name="product_status' . $row_table_body['id'] . '">
                ';

                if ($row_table_body['product_status']) {
                    $modal_edit .= '
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
                ';
                } else {
                    $modal_edit .= '
                <option value="1">Active</option>
                <option value="0" selected>Inactive</option>
                ';
                }

                $modal_edit .= '
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Price</label>
                                                        <input type="text" id="product_unit_price' . $row_table_body['id'] . '" class="form-control" name="product_unit_price' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['product_unit_price'] . '" required>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Sale price</label>
                                                        <input type="text" id="product_sale_price' . $row_table_body['id'] . '" class="form-control" name="product_sale_price' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['product_sale_price'] . '" required>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Size</label>
                                                        <input type="text" id="product_size' . $row_table_body['id'] . '" class="form-control" name="product_size' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['product_size'] . '" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="" class="form-label">Description</label>
                                                            <textarea maxlength="150" class="form-control" id="product_description' . $row_table_body['id'] . '" rows="3" name="product_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['product_description'] . '</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Image</label>
                                                            <div class="form-file">
                                                                        <input type="file" class="form-file-input" name="product_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['product_image'] . '">
                                                                        <label class="form-file-label" for="customFile">
                                                                            <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                            <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                            <label for="" class="form-label">Preview</label>

                                                            <div class="card">
                                                                    <div class="card-content">

                                                                        <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/products/' . $row_table_body['product_image'] . '" alt="" >
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                    document.getElementById(\'file-upload' . $row_table_body['id'] . '\').onchange = function () {
                                                        if (this.files && this.files[0]) {
                                                            var reader = new FileReader();
                                                            reader.onload = function(e) {
                                                            document.getElementById("imagePreview' . $row_table_body['id'] . '").src = e.target.result;
                                                            }
                                                            reader.readAsDataURL(this.files[0]);
                                                        };
                                                        var filePath = this.value;
                                                        if (filePath) {
                                                        var fileName = filePath.replace(/^.*?([^\\\/]*)$/, \'$1\');
                                                        document.getElementById(\'file-name' . $row_table_body['id'] . '\').innerHTML = fileName;
                                                        }
                                                    };

                                                    </script>


                                                </div>
                                                </form>

                                                <div class="col-12 d-flex justify-content-end">
                                                    <button class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_product(' . $row_table_body['id'] . ')">Update</button>
                                                    <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            var element_edit_category' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-category' . $row_table_body['id'] . '");
                            var choices_edit_category' . $row_table_body['id'] . ' = new Choices(element_edit_category' . $row_table_body['id'] . ');

                            var element_edit_brand' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-brand' . $row_table_body['id'] . '");
                            var choices_edit_brand' . $row_table_body['id'] . ' = new Choices(element_edit_brand' . $row_table_body['id'] . ');

                            var element_edit_status' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-status' . $row_table_body['id'] . '");
                            var choices_edit_status' . $row_table_body['id'] . ' = new Choices(element_edit_status' . $row_table_body['id'] . ');
                        </script>
                ';
                //--------------- End EDIT MODAL ---------------

                //--------------- End DELETE MODAL ---------------
                $modal_delete .= '
                    <div class="modal fade text-left modal-borderless" id="delete-modal-' . $row_table_body['id'] . '" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this product?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_product(' . $row_table_body['id'] . ')" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Accept</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                //--------------- End DELETE MODAL ---------------

                $product_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                if ($row_table_body["product_status"]) {
                    $product_status_column = '<span class="badge bg-success">Active</span>';
                } else {
                    $product_status_column = '<span class="badge bg-danger">Inactive</span>';
                }

                $product_image_column = '
                        <div class="avatar avatar-xl mr-3">
                            <img src="images/products/' . $row_table_body["product_image"] . '" alt="" srcset="">
                        </div>
                ';

                $table_product = array(
                    "product_id" => $product_column,
                    "product_image" => $product_image_column,
                    "product_name" => $row_table_body["product_name"],
                    "brand_name" => $row_brand_table_body["brand_name"],
                    "category_name" => $row_category_table_body["category_name"],
                    "product_size" => $row_table_body["product_size"],
                    "product_unit_price" => $row_table_body["product_unit_price"],
                    "product_sale_price" => $row_table_body["product_sale_price"],
                    "product_status" => $product_status_column,
                    "product_stock" => $row_table_body["product_stock"],
                    "updated_at" => $row_table_body["updated_at"],
                    "edit" => '
                                <div class="buttons">
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                            </div>
                    ',
                    'modal_edit' => $modal_edit,
                    'modal_delete' => $modal_delete,
                );
                echo json_encode($table_product);
            }

        } else {
            $table_product = array(
                "product_id" => "ERROR",
                "product_image" => "ERROR",
                "product_name" => "ERROR",
                "brand_name" => "ERROR",
                "category_name" => "ERROR",
                "product_size" => "ERROR",
                "product_unit_price" => "ERROR",
                "product_sale_price" => "ERROR",
                "product_status" => "ERROR",
                "product_stock" => "ERROR",
                "updated_at" => "ERROR",
                "edit" => "ERROR",
                'modal_edit' => "",
                'modal_delete' => "",
            );
            echo json_encode($table_product);
        }
    }
    if ($_POST["action"] == "update") {

        $product_id = $_POST["product_id"];
        $product_name = $_POST["product_name"];
        $brand_id = $_POST["brand_id"];
        $category_id = $_POST["category_id"];
        $product_size = $_POST["product_size"];
        $product_unit_price = $_POST["product_unit_price"];
        $product_sale_price = $_POST["product_sale_price"];
        $product_description = $_POST["product_description"];
        $product_status = $_POST["product_status"];

        if (isset($_FILES["product_image"]["name"])) {
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
            if (isset($product_name)
                && isset($brand_id)
                && isset($category_id)
                && isset($product_size)
                && isset($product_unit_price)
                && isset($product_sale_price)
                && isset($product_description)
                && isset($product_status)
                && isset($product_image)) {
                $sql_update = "UPDATE tbl_product SET
                    product_name = '$product_name',
                    brand_id = '$brand_id',
                    category_id = '$category_id',
                    product_size = '$product_size',
                    product_unit_price = '$product_unit_price',
                    product_sale_price = '$product_sale_price',
                    product_description = '$product_description',
                    product_status = '$product_status',
                    product_image = '$product_image',
                    updated_at = NOW()
                    WHERE id='$product_id'";
                $query_update = mysqli_query($connect, $sql_update);

                $sql_table_body = "SELECT * FROM tbl_product WHERE id='$product_id'";
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

                    $sql_brand_edit = "SELECT * FROM tbl_brand ORDER BY id ASC";
                    $query_brand_edit = mysqli_query($connect, $sql_brand_edit);

                    $sql_category_edit = "SELECT * FROM tbl_product_category ORDER BY id ASC";
                    $query_category_edit = mysqli_query($connect, $sql_category_edit);

                    $form_product = '
                                                    <div class="row">
                                                        <div class="col-md-8 col-12">
                                                            <div class="form-group">
                                                            <label for="" class="form-label">Name</label>
                                                            <input type="text" id="product_name' . $row_table_body['id'] . '" class="form-control" name="product_name' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['product_name'] . '"  required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Category</label>
                                                                <select class="js-choices-edit-category' . $row_table_body['id'] . ' form-select"  id="category_id' . $row_table_body['id'] . '" name="category_id' . $row_table_body['id'] . '" required>
                                                                <option value="" selected>CHOOSE...</option>
                    ';

                    while ($row_category_edit = mysqli_fetch_array($query_category_edit)) {
                        $form_product .= '<option value="' . $row_category_edit["id"] . '"';

                        if ($row_category_edit["id"] == $row_table_body['category_id']) {
                            $form_product .= 'selected>' . $row_category_edit["category_name"] . '</option>';
                        } else {
                            $form_product .= '>' . $row_category_edit["category_name"] . '</option>';
                        }
                    }

                    $form_product .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Brand</label>
                                                                <select class="js-choices-edit-brand' . $row_table_body['id'] . ' form-select" id="brand_id' . $row_table_body['id'] . '" name="brand_id' . $row_table_body['id'] . '" required>
                                                                <option value="" selected >CHOOSE...</option>
                    ';

                    while ($row_brand_edit = mysqli_fetch_array($query_brand_edit)) {
                        $form_product .= '<option value="' . $row_brand_edit["id"] . '"';
                        if ($row_brand_edit["id"] == $row_table_body['brand_id']) {
                            $form_product .= 'selected>' . $row_brand_edit["brand_name"] . '</option>';
                        } else {
                            $form_product .= '>' . $row_brand_edit["brand_name"] . '</option>';
                        }
                    }

                    $form_product .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Status</label>
                                                                <select class="js-choices-edit-status' . $row_table_body['id'] . ' form-select" id="product_status' . $row_table_body['id'] . '" name="product_status' . $row_table_body['id'] . '">
                    ';

                    if ($row_table_body['product_status']) {
                        $form_product .= '
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                    ';
                    } else {
                        $form_product .= '
                    <option value="1">Active</option>
                    <option value="0" selected>Inactive</option>
                    ';
                    }

                    $form_product .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Price</label>
                                                            <input type="text" id="product_unit_price' . $row_table_body['id'] . '" class="form-control" name="product_unit_price' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['product_unit_price'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Sale price</label>
                                                            <input type="text" id="product_sale_price' . $row_table_body['id'] . '" class="form-control" name="product_sale_price' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['product_sale_price'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Size</label>
                                                            <input type="text" id="product_size' . $row_table_body['id'] . '" class="form-control" name="product_size' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['product_size'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="" class="form-label">Description</label>
                                                                <textarea maxlength="150" class="form-control" id="product_description' . $row_table_body['id'] . '" rows="3" name="product_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['product_description'] . '</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Image</label>
                                                                <div class="form-file">
                                                                            <input type="file" class="form-file-input" name="product_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['product_image'] . '">
                                                                            <label class="form-file-label" for="customFile">
                                                                                <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                                <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                            </label>
                                                                        </div>
                                                                </div>
                                                                <label for="" class="form-label">Preview</label>

                                                                <div class="card">
                                                                        <div class="card-content">

                                                                            <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/products/' . $row_table_body['product_image'] . '" alt="" >
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            document.getElementById(\'file-upload' . $row_table_body['id'] . '\').onchange = function () {
                                                                if (this.files && this.files[0]) {
                                                                    var reader = new FileReader();
                                                                    reader.onload = function(e) {
                                                                    document.getElementById("imagePreview' . $row_table_body['id'] . '").src = e.target.result;
                                                                    }
                                                                    reader.readAsDataURL(this.files[0]);
                                                                };
                                                                var filePath = this.value;
                                                                if (filePath) {
                                                                var fileName = filePath.replace(/^.*?([^\\\/]*)$/, \'$1\');
                                                                document.getElementById(\'file-name' . $row_table_body['id'] . '\').innerHTML = fileName;
                                                                }
                                                            };

                                                    </script>
                                                    </div>
                        <script>
                             element_edit_category' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-category' . $row_table_body['id'] . '");
                             choices_edit_category' . $row_table_body['id'] . ' = new Choices(element_edit_category' . $row_table_body['id'] . ');

                             element_edit_brand' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-brand' . $row_table_body['id'] . '");
                             choices_edit_brand' . $row_table_body['id'] . ' = new Choices(element_edit_brand' . $row_table_body['id'] . ');

                             element_edit_status' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-status' . $row_table_body['id'] . '");
                             choices_edit_status' . $row_table_body['id'] . ' = new Choices(element_edit_status' . $row_table_body['id'] . ');
                        </script>

                    ';

                    $product_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                    if ($row_table_body["product_status"]) {
                        $product_status_column = '<span class="badge bg-success">Active</span>';
                    } else {
                        $product_status_column = '<span class="badge bg-danger">Inactive</span>';
                    }

                    $product_image_column = '
                            <div class="avatar avatar-xl mr-3">
                                <img src="images/products/' . $row_table_body["product_image"] . '" alt="" srcset="">
                            </div>
                    ';

                    $table_product = array(
                        "product_id" => $product_column,
                        "product_image" => $product_image_column,
                        "product_name" => $row_table_body["product_name"],
                        "brand_name" => $row_brand_table_body["brand_name"],
                        "category_name" => $row_category_table_body["category_name"],
                        "product_size" => $row_table_body["product_size"],
                        "product_unit_price" => $row_table_body["product_unit_price"],
                        "product_sale_price" => $row_table_body["product_sale_price"],
                        "product_status" => $product_status_column,
                        "edit" => '
                                    <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                                </div>
                        ',
                        "form_product" => $form_product,
                    );
                    echo json_encode($table_product);
                }

            } else {
                $table_product = array(
                    "product_id" => "ERROR",
                    "product_image" => "ERROR",
                    "product_name" => "ERROR",
                    "brand_name" => "ERROR",
                    "category_name" => "ERROR",
                    "product_size" => "ERROR",
                    "product_unit_price" => "ERROR",
                    "product_sale_price" => "ERROR",
                    "product_status" => "ERROR",
                    "edit" => "ERROR",
                    "form_product" => "",
                );
                echo json_encode($table_product);
            }
        } else {
            if (isset($product_name)
                && isset($brand_id)
                && isset($category_id)
                && isset($product_size)
                && isset($product_unit_price)
                && isset($product_sale_price)
                && isset($product_description)
                && isset($product_status)) {
                $sql_update = "UPDATE tbl_product SET
                    product_name = '$product_name',
                    brand_id = '$brand_id',
                    category_id = '$category_id',
                    product_size = '$product_size',
                    product_unit_price = '$product_unit_price',
                    product_sale_price = '$product_sale_price',
                    product_description = '$product_description',
                    product_status = '$product_status',
                    updated_at = NOW()
                    WHERE id='$product_id'";
                $query_update = mysqli_query($connect, $sql_update);

                $sql_table_body = "SELECT * FROM tbl_product WHERE id='$product_id'";
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

                    $sql_brand_edit = "SELECT * FROM tbl_brand ORDER BY id ASC";
                    $query_brand_edit = mysqli_query($connect, $sql_brand_edit);

                    $sql_category_edit = "SELECT * FROM tbl_product_category ORDER BY id ASC";
                    $query_category_edit = mysqli_query($connect, $sql_category_edit);

                    $form_product = '
                                                    <div class="row">
                                                        <div class="col-md-8 col-12">
                                                            <div class="form-group">
                                                            <label for="" class="form-label">Name</label>
                                                            <input type="text" id="product_name' . $row_table_body['id'] . '" class="form-control" name="product_name' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['product_name'] . '"  required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Category</label>
                                                                <select class="js-choices-edit-category' . $row_table_body['id'] . ' form-select"  id="category_id' . $row_table_body['id'] . '" name="category_id' . $row_table_body['id'] . '" required>
                                                                <option value="" selected>CHOOSE...</option>
                    ';

                    while ($row_category_edit = mysqli_fetch_array($query_category_edit)) {
                        $form_product .= '<option value="' . $row_category_edit["id"] . '"';

                        if ($row_category_edit["id"] == $row_table_body['category_id']) {
                            $form_product .= 'selected>' . $row_category_edit["category_name"] . '</option>';
                        } else {
                            $form_product .= '>' . $row_category_edit["category_name"] . '</option>';
                        }
                    }

                    $form_product .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Brand</label>
                                                                <select class="js-choices-edit-brand' . $row_table_body['id'] . ' form-select" id="brand_id' . $row_table_body['id'] . '" name="brand_id' . $row_table_body['id'] . '" required>
                                                                <option value="" selected >CHOOSE...</option>
                    ';

                    while ($row_brand_edit = mysqli_fetch_array($query_brand_edit)) {
                        $form_product .= '<option value="' . $row_brand_edit["id"] . '"';
                        if ($row_brand_edit["id"] == $row_table_body['brand_id']) {
                            $form_product .= 'selected>' . $row_brand_edit["brand_name"] . '</option>';
                        } else {
                            $form_product .= '>' . $row_brand_edit["brand_name"] . '</option>';
                        }
                    }

                    $form_product .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Status</label>
                                                                <select class="js-choices-edit-status' . $row_table_body['id'] . ' form-select" id="product_status' . $row_table_body['id'] . '" name="product_status' . $row_table_body['id'] . '">
                    ';

                    if ($row_table_body['product_status']) {
                        $form_product .= '
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                    ';
                    } else {
                        $form_product .= '
                    <option value="1">Active</option>
                    <option value="0" selected>Inactive</option>
                    ';
                    }

                    $form_product .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Price</label>
                                                            <input type="text" id="product_unit_price' . $row_table_body['id'] . '" class="form-control" name="product_unit_price' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['product_unit_price'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Sale price</label>
                                                            <input type="text" id="product_sale_price' . $row_table_body['id'] . '" class="form-control" name="product_sale_price' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['product_sale_price'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Size</label>
                                                            <input type="text" id="product_size' . $row_table_body['id'] . '" class="form-control" name="product_size' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['product_size'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="" class="form-label">Description</label>
                                                                <textarea maxlength="150" class="form-control" id="product_description' . $row_table_body['id'] . '" rows="3" name="product_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['product_description'] . '</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Image</label>
                                                                <div class="form-file">
                                                                            <input type="file" class="form-file-input" name="product_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['product_image'] . '">
                                                                            <label class="form-file-label" for="customFile">
                                                                                <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                                <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                            </label>
                                                                        </div>
                                                                </div>
                                                                <label for="" class="form-label">Preview</label>

                                                                <div class="card">
                                                                        <div class="card-content">

                                                                            <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/products/' . $row_table_body['product_image'] . '" alt="" >
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            document.getElementById(\'file-upload' . $row_table_body['id'] . '\').onchange = function () {
                                                                if (this.files && this.files[0]) {
                                                                    var reader = new FileReader();
                                                                    reader.onload = function(e) {
                                                                    document.getElementById("imagePreview' . $row_table_body['id'] . '").src = e.target.result;
                                                                    }
                                                                    reader.readAsDataURL(this.files[0]);
                                                                };
                                                                var filePath = this.value;
                                                                if (filePath) {
                                                                var fileName = filePath.replace(/^.*?([^\\\/]*)$/, \'$1\');
                                                                document.getElementById(\'file-name' . $row_table_body['id'] . '\').innerHTML = fileName;
                                                                }
                                                            };

                                                    </script>
                                                    </div>
                        <script>
                             element_edit_category' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-category' . $row_table_body['id'] . '");
                             choices_edit_category' . $row_table_body['id'] . ' = new Choices(element_edit_category' . $row_table_body['id'] . ');

                             element_edit_brand' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-brand' . $row_table_body['id'] . '");
                             choices_edit_brand' . $row_table_body['id'] . ' = new Choices(element_edit_brand' . $row_table_body['id'] . ');

                             element_edit_status' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-status' . $row_table_body['id'] . '");
                             choices_edit_status' . $row_table_body['id'] . ' = new Choices(element_edit_status' . $row_table_body['id'] . ');
                        </script>

                    ';

                    $product_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                    if ($row_table_body["product_status"]) {
                        $product_status_column = '<span class="badge bg-success">Active</span>';
                    } else {
                        $product_status_column = '<span class="badge bg-danger">Inactive</span>';
                    }

                    $product_image_column = '
                            <div class="avatar avatar-xl mr-3">
                                <img src="images/products/' . $row_table_body["product_image"] . '" alt="" srcset="">
                            </div>
                    ';

                    $table_product = array(
                        "product_id" => $product_column,
                        "product_image" => $product_image_column,
                        "product_name" => $row_table_body["product_name"],
                        "brand_name" => $row_brand_table_body["brand_name"],
                        "category_name" => $row_category_table_body["category_name"],
                        "product_size" => $row_table_body["product_size"],
                        "product_unit_price" => $row_table_body["product_unit_price"],
                        "product_sale_price" => $row_table_body["product_sale_price"],
                        "product_status" => $product_status_column,
                        "edit" => '
                                    <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                                </div>
                        ',
                        "form_product" => $form_product,
                    );
                    echo json_encode($table_product);
                }

            } else {
                $table_product = array(
                    "product_id" => "ERROR",
                    "product_image" => "ERROR",
                    "product_name" => "ERROR",
                    "brand_name" => "ERROR",
                    "category_name" => "ERROR",
                    "product_size" => "ERROR",
                    "product_unit_price" => "ERROR",
                    "product_sale_price" => "ERROR",
                    "product_status" => "ERROR",
                    "edit" => "ERROR",
                    "form_product" => "",
                );
                echo json_encode($table_product);
            }
        }
    }

    if ($_POST["action"] == "delete") {
        $email_login = $_SESSION["email"];
        $password_login = $_SESSION["password"];
        $sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
        $query = mysqli_query($connect, $sql);
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $product_id = $_POST['product_id'];
            $sql_delete = "DELETE FROM tbl_product WHERE id='$product_id'";
            $query_delete = mysqli_query($connect, $sql_delete);
        } else {
            header('location: login.php');
        }
    }
}
