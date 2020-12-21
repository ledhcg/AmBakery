<?php
session_start();
if (!isset($_SESSION["email"])) {
    header('location: login.php');
}

include_once './connect.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {

        $brand_name = $_POST["brand_name"];
        $brand_status = $_POST["brand_status"];
        $brand_description = $_POST["brand_description"];

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

        if (isset($brand_name)
            && isset($brand_status)
            && isset($brand_description)
            && isset($brand_image)) {
            $sql = "INSERT INTO tbl_brand (
                    brand_name,
                    brand_status,
                    brand_description,
                    brand_image,
                    created_at
                    )
                    VALUES (
                    '$brand_name',
                    '$brand_status',
                    '$brand_description',
                    '$brand_image',
                    NOW()
                    )";
            $query = mysqli_query($connect, $sql);

            $modal_edit = '';
            $modal_delete = '';

            $sql_table_body = "SELECT * FROM tbl_brand ORDER BY created_at DESC LIMIT 1";
            $query_table_body = mysqli_query($connect, $sql_table_body);
            if (mysqli_num_rows($query_table_body) > 0) {
                $row_table_body = mysqli_fetch_array($query_table_body);

                //--------------- Start EDIT MODAL ---------------
                $modal_edit .= '
                        <div class="modal fade text-left w-100 modal-borderless" id="edit-modal-' . $row_table_body["id"] . '" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel16" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                    <h4 class="modal-title white" id="myModalLabel16">Edit brand</h4>
                                    </div>
                                    <div class="modal-body">
                                            <div class="form-body">
                                                <form id="edit-form' . $row_table_body['id'] . '">
                                                <div class="row">
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-group">
                                                        <label for="" class="form-label">Name</label>
                                                        <input type="text" id="brand_name' . $row_table_body['id'] . '" class="form-control" name="brand_name' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['brand_name'] . '"  required>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Status</label>
                                                            <select class="js-choices-edit' . $row_table_body["id"] . ' form-select" id="brand_status' . $row_table_body['id'] . '" name="brand_status' . $row_table_body['id'] . '">
                ';

                if ($row_table_body['brand_status']) {
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
                                                            <label for="" class="form-label">Description</label>
                                                            <textarea maxlength="150" class="form-control" id="brand_description' . $row_table_body['id'] . '" rows="3" name="brand_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['brand_description'] . '</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Image</label>
                                                            <div class="form-file">
                                                                        <input type="file" class="form-file-input" name="brand_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['brand_image'] . '">
                                                                        <label class="form-file-label" for="customFile">
                                                                            <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                            <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                            <label for="" class="form-label">Preview</label>

                                                            <div class="card">
                                                                    <div class="card-content">

                                                                        <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/brands/' . $row_table_body['brand_image'] . '" alt="" >
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
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_brand(' . $row_table_body['id'] . ')">Update</button>
                                                        <button type="reset" class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                                    </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            var element_edit' . $row_table_body["id"] . ' = document.querySelector(".js-choices-edit' . $row_table_body["id"] . '");
                            var choices_edit' . $row_table_body["id"] . ' = new Choices(element_edit' . $row_table_body["id"] . ');
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
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this brand?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_brand(' . $row_table_body['id'] . ')" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Accept</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                //--------------- End DELETE MODAL ---------------

                $brand_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                if ($row_table_body["brand_status"]) {
                    $brand_status_column = '<span class="badge bg-success">Active</span>';
                } else {
                    $brand_status_column = '<span class="badge bg-danger">Inactive</span>';
                }

                $brand_image_column = '
                        <div class="avatar avatar-xl mr-3">
                            <img src="images/brands/' . $row_table_body["brand_image"] . '" alt="" srcset="">
                        </div>
                ';

                $table_brands = array(
                    "brand_id" => $brand_column,
                    "brand_image" => $brand_image_column,
                    "brand_name" => $row_table_body["brand_name"],
                    "brand_description" => $row_table_body["brand_description"],
                    "brand_status" => $brand_status_column,
                    "edit" => '
                                <div class="buttons">
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                            </div>
                    ',
                    'modal_edit' => $modal_edit,
                    'modal_delete' => $modal_delete,
                );
                echo json_encode($table_brands);
            }

        } else {
            $table_brands = array(
                "brand_id" => "ERROR",
                "brand_image" => "ERROR",
                "brand_name" => "ERROR",
                "brand_description" => "ERROR",
                "brand_status" => "ERROR",
                "edit" => "ERROR",
                'modal_edit' => "",
                'modal_delete' => "",
            );
            echo json_encode($table_brands);
        }
    }
    if ($_POST["action"] == "update") {

        $brand_id = $_POST["brand_id"];
        $brand_name = $_POST["brand_name"];
        $brand_status = $_POST["brand_status"];
        $brand_description = $_POST["brand_description"];

        if (isset($_FILES["brand_image"]["name"])) {
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
            if (isset($brand_name)
                && isset($brand_status)
                && isset($brand_description)
                && isset($brand_image)) {
                $sql_update = "UPDATE tbl_brand SET
                brand_name = '$brand_name',
                brand_status ='$brand_status',
                brand_description ='$brand_description',
                brand_image ='$brand_image',
                updated_at = NOW()
                WHERE id='$brand_id'";
                $query_update = mysqli_query($connect, $sql_update);

                $sql_table_body = "SELECT * FROM tbl_brand WHERE id='$brand_id'";
                $query_table_body = mysqli_query($connect, $sql_table_body);
                if (mysqli_num_rows($query_table_body) > 0) {

                    $row_table_body = mysqli_fetch_array($query_table_body);

                    $form_brand = '
                                        <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" id="brand_name' . $row_table_body['id'] . '" class="form-control" name="brand_name' . $row_table_body['id'] . '"
                                            value="' . $row_table_body['brand_name'] . '"  required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Status</label>
                                                <select class="js-choices-edit' . $row_table_body["id"] . ' form-select" id="brand_status' . $row_table_body['id'] . '" name="brand_status' . $row_table_body['id'] . '">
                    ';

                    if ($row_table_body['brand_status']) {
                        $form_brand .= '
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                    ';
                    } else {
                        $form_brand .= '
                    <option value="1">Active</option>
                    <option value="0" selected>Inactive</option>
                    ';
                    }

                    $form_brand .= '
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="form-label">Description</label>
                                                <textarea maxlength="150" class="form-control" id="brand_description' . $row_table_body['id'] . '" rows="3" name="brand_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['brand_description'] . '</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="" class="form-label">Image</label>
                                                <div class="form-file">
                                                            <input type="file" class="form-file-input" name="brand_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['brand_image'] . '">
                                                            <label class="form-file-label" for="customFile">
                                                                <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                            </label>
                                                        </div>
                                                </div>
                                                <label for="" class="form-label">Preview</label>

                                                <div class="card">
                                                        <div class="card-content">

                                                            <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/brands/' . $row_table_body['brand_image'] . '" alt="" >
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

                                                element_edit' . $row_table_body["id"] . ' = document.querySelector(".js-choices-edit' . $row_table_body["id"] . '");
                                                choices_edit' . $row_table_body["id"] . ' = new Choices(element_edit' . $row_table_body["id"] . ');

                                        </script>


                                    </div>
                    ';

                    $brand_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                    if ($row_table_body["brand_status"]) {
                        $brand_status_column = '<span class="badge bg-success">Active</span>';
                    } else {
                        $brand_status_column = '<span class="badge bg-danger">Inactive</span>';
                    }
                    $brand_image_column = '
                            <div class="avatar avatar-xl mr-3">
                                <img src="images/brands/' . $row_table_body["brand_image"] . '" alt="" srcset="">
                            </div>
                    ';
                    $table_brands = array(
                        "brand_id" => $brand_column,
                        "brand_image" => $brand_image_column,
                        "brand_name" => $row_table_body["brand_name"],
                        "brand_description" => $row_table_body["brand_description"],
                        "brand_status" => $brand_status_column,
                        "edit" => '
                                <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                                </div>
                        ',
                        "form_brand" => $form_brand,

                    );
                    echo json_encode($table_brands);
                }

            } else {
                $table_brands = array(
                    "brand_id" => "ERROR",
                    "brand_image" => "ERROR",
                    "brand_name" => "ERROR",
                    "brand_description" => "ERROR",
                    "brand_status" => "ERROR",
                    "edit" => "ERROR",
                    "form_brand" => "",

                );
                echo json_encode($table_brands);
            }
        } else {
            if (isset($brand_name)
                && isset($brand_status)
                && isset($brand_description)) {
                $sql_update = "UPDATE tbl_brand SET
                brand_name = '$brand_name',
                brand_status ='$brand_status',
                brand_description ='$brand_description',
                updated_at = NOW()
                WHERE id='$brand_id'";
                $query_update = mysqli_query($connect, $sql_update);

                $sql_table_body = "SELECT * FROM tbl_brand WHERE id='$brand_id'";
                $query_table_body = mysqli_query($connect, $sql_table_body);
                if (mysqli_num_rows($query_table_body) > 0) {

                    $row_table_body = mysqli_fetch_array($query_table_body);

                    $form_brand = '
                                        <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" id="brand_name' . $row_table_body['id'] . '" class="form-control" name="brand_name' . $row_table_body['id'] . '"
                                            value="' . $row_table_body['brand_name'] . '"  required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Status</label>
                                                <select class="js-choices-edit' . $row_table_body["id"] . ' form-select" id="brand_status' . $row_table_body['id'] . '" name="brand_status' . $row_table_body['id'] . '">
                    ';

                    if ($row_table_body['brand_status']) {
                        $form_brand .= '
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                    ';
                    } else {
                        $form_brand .= '
                    <option value="1">Active</option>
                    <option value="0" selected>Inactive</option>
                    ';
                    }

                    $form_brand .= '
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="form-label">Description</label>
                                                <textarea maxlength="150" class="form-control" id="brand_description' . $row_table_body['id'] . '" rows="3" name="brand_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['brand_description'] . '</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="" class="form-label">Image</label>
                                                <div class="form-file">
                                                            <input type="file" class="form-file-input" name="brand_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['brand_image'] . '">
                                                            <label class="form-file-label" for="customFile">
                                                                <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                            </label>
                                                        </div>
                                                </div>
                                                <label for="" class="form-label">Preview</label>

                                                <div class="card">
                                                        <div class="card-content">

                                                            <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/brands/' . $row_table_body['brand_image'] . '" alt="" >
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
                                                element_edit' . $row_table_body["id"] . ' = document.querySelector(".js-choices-edit' . $row_table_body["id"] . '");
                                                choices_edit' . $row_table_body["id"] . ' = new Choices(element_edit' . $row_table_body["id"] . ');

                                        </script>


                                    </div>
                    ';

                    $brand_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                    if ($row_table_body["brand_status"]) {
                        $brand_status_column = '<span class="badge bg-success">Active</span>';
                    } else {
                        $brand_status_column = '<span class="badge bg-danger">Inactive</span>';
                    }
                    $brand_image_column = '
                            <div class="avatar avatar-xl mr-3">
                                <img src="images/brands/' . $row_table_body["brand_image"] . '" alt="" srcset="">
                            </div>
                    ';
                    $table_brands = array(
                        "brand_id" => $brand_column,
                        "brand_image" => $brand_image_column,
                        "brand_name" => $row_table_body["brand_name"],
                        "brand_description" => $row_table_body["brand_description"],
                        "brand_status" => $brand_status_column,
                        "edit" => '
                                <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                                </div>
                        ',
                        "form_brand" => $form_brand,
                    );
                    echo json_encode($table_brands);
                }

            } else {
                $table_brands = array(
                    "brand_id" => "ERROR",
                    "brand_image" => "ERROR",
                    "brand_name" => "ERROR",
                    "brand_description" => "ERROR",
                    "brand_status" => "ERROR",
                    "edit" => "ERROR",
                    "form_brand" => "",

                );
                echo json_encode($table_brands);
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
            $brand_id = $_POST['brand_id'];
            $sql_delete = "DELETE FROM tbl_brand WHERE id='$brand_id'";
            $query_delete = mysqli_query($connect, $sql_delete);
        } else {
            header('location: login.php');
        }
    }
}
