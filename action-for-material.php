<?php
session_start();
include_once './connect.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {

        $material_name = $_POST["material_name"];
        $partner_id = $_POST["partner_id"];
        $material_unit = $_POST["material_unit"];
        $material_import_price = $_POST["material_import_price"];
        $material_description = $_POST["material_description"];
        $material_status = $_POST["material_status"];

        $upload_dir = "images/materials/";
        $fileName = basename($_FILES["material_image"]["name"]);
        $targetFilePath = $upload_dir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["material_image"]["tmp_name"], $targetFilePath)) {
                $material_image = $fileName;
            }
        }
        if (isset($material_name)
            && isset($partner_id)
            && isset($material_unit)
            && isset($material_import_price)
            && isset($material_description)
            && isset($material_status)
            && isset($material_image)) {
            $sql = "INSERT INTO tbl_material (
                material_name,
                partner_id,
                material_unit,
                material_stock,
                material_import_price,
                material_description,
                material_status,
                material_image,
                created_at
                )
                VALUES (
                '$material_name',
                '$partner_id',
                '$material_unit',
                '0',
                '$material_import_price',
                '$material_description',
                '$material_status',
                '$material_image',
                NOW()
                )";
            $query = mysqli_query($connect, $sql);

            $modal_edit = '';
            $modal_delete = '';

            $sql_table_body = "SELECT * FROM tbl_material ORDER BY created_at DESC LIMIT 1";
            $query_table_body = mysqli_query($connect, $sql_table_body);
            if (mysqli_num_rows($query_table_body) > 0) {
                $row_table_body = mysqli_fetch_array($query_table_body);

                $id_partner_table_body = $row_table_body["partner_id"];
                $sql_partner_table_body = "SELECT * FROM tbl_partner WHERE id='$id_partner_table_body'";
                $query_partner_table_body = mysqli_query($connect, $sql_partner_table_body);
                $row_partner_table_body = mysqli_fetch_array($query_partner_table_body);

                //--------------- Start EDIT MODAL ---------------
                $modal_edit .= '
                        <div class="modal fade text-left w-100 modal-borderless" id="edit-modal-' . $row_table_body["id"] . '" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel16" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                    <h4 class="modal-title white" id="myModalLabel16">Edit material</h4>
                                    </div>
                                    <div class="modal-body">
                ';

                $sql_partner_edit = "SELECT * FROM tbl_partner ORDER BY id ASC";
                $query_partner_edit = mysqli_query($connect, $sql_partner_edit);

                $modal_edit .= '
                                            <div class="form-body">
                                                <form id="edit-form' . $row_table_body['id'] . '">

                                                <div class="row">
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-group">
                                                        <label for="" class="form-label">Name</label>
                                                        <input type="text" id="material_name' . $row_table_body['id'] . '" class="form-control" name="material_name' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['material_name'] . '"  required>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Partner</label>
                                                            <select class="js-choices-edit-partner' . $row_table_body['id'] . ' form-select" id="partner_id' . $row_table_body['id'] . '" name="partner_id' . $row_table_body['id'] . '" required>
                                                            <option value="" selected >CHOOSE...</option>
                ';

                while ($row_partner_edit = mysqli_fetch_array($query_partner_edit)) {
                    $modal_edit .= '<option value="' . $row_partner_edit["id"] . '"';
                    if ($row_partner_edit["id"] == $row_table_body['partner_id']) {
                        $modal_edit .= 'selected>' . $row_partner_edit["partner_name"] . '</option>';
                    } else {
                        $modal_edit .= '>' . $row_partner_edit["partner_name"] . '</option>';
                    }
                }

                $modal_edit .= '
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Status</label>
                                                            <select class="js-choices-edit-status' . $row_table_body['id'] . ' form-select" id="material_status' . $row_table_body['id'] . '" name="material_status' . $row_table_body['id'] . '">
                ';

                if ($row_table_body['material_status']) {
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
                                                        <label for="" class="form-label">Import price</label>
                                                        <input type="text" id="material_import_price' . $row_table_body['id'] . '" class="form-control" name="material_import_price' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['material_import_price'] . '" required>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Unit</label>
                                                        <input type="text" id="material_unit' . $row_table_body['id'] . '" class="form-control" name="material_unit' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['material_unit'] . '" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="" class="form-label">Description</label>
                                                            <textarea maxlength="150" class="form-control" id="material_description' . $row_table_body['id'] . '" rows="3" name="material_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['material_description'] . '</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Image</label>
                                                            <div class="form-file">
                                                                        <input type="file" class="form-file-input" name="material_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['material_image'] . '">
                                                                        <label class="form-file-label" for="customFile">
                                                                            <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                            <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                            <label for="" class="form-label">Preview</label>

                                                            <div class="card">
                                                                    <div class="card-content">

                                                                        <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/materials/' . $row_table_body['material_image'] . '" alt="" >
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
                                                    <button class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_material(' . $row_table_body['id'] . ')">Update</button>
                                                    <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>

                            var element_edit_partner' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-partner' . $row_table_body['id'] . '");
                            var choices_edit_partner' . $row_table_body['id'] . ' = new Choices(element_edit_partner' . $row_table_body['id'] . ');

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
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this material?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_material(' . $row_table_body['id'] . ')" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Accept</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                //--------------- End DELETE MODAL ---------------

                $material_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                if ($row_table_body["material_status"]) {
                    $material_status_column = '<span class="badge bg-success">Active</span>';
                } else {
                    $material_status_column = '<span class="badge bg-danger">Inactive</span>';
                }

                $material_image_column = '
                        <div class="avatar avatar-xl mr-3">
                            <img src="images/materials/' . $row_table_body["material_image"] . '" alt="" srcset="">
                        </div>
                ';

                $table_material = array(
                    "material_id" => $material_column,
                    "material_image" => $material_image_column,
                    "material_name" => $row_table_body["material_name"],
                    "partner_name" => $row_partner_table_body["partner_name"],
                    "material_unit" => $row_table_body["material_unit"],
                    "material_stock" => $row_table_body["material_stock"],
                    "material_import_price" => $row_table_body["material_import_price"],
                    "material_status" => $material_status_column,
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
                echo json_encode($table_material);
            }

        } else {
            $table_material = array(
                "material_id" => "ERROR",
                "material_image" => "ERROR",
                "material_name" => "ERROR",
                "partner_name" => "ERROR",
                "material_unit" => "ERROR",
                "material_stock" => "ERROR",
                "material_import_price" => "ERROR",
                "material_status" => "ERROR",
                "edit" => "ERROR",
                'modal_edit' => "",
                'modal_delete' => "",
            );
            echo json_encode($table_material);
        }
    }
    if ($_POST["action"] == "update") {

        $material_id = $_POST["material_id"];
        $material_name = $_POST["material_name"];
        $partner_id = $_POST["partner_id"];
        $material_unit = $_POST["material_unit"];
        $material_import_price = $_POST["material_import_price"];
        $material_description = $_POST["material_description"];
        $material_status = $_POST["material_status"];

        if (isset($_FILES["material_image"]["name"])) {
            $upload_dir = "images/materials/";
            $fileName = basename($_FILES["material_image"]["name"]);
            $targetFilePath = $upload_dir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowTypes)) {
                if (move_uploaded_file($_FILES["material_image"]["tmp_name"], $targetFilePath)) {
                    $material_image = $fileName;
                }
            }
            if (isset($material_name)
                && isset($partner_id)
                && isset($material_unit)
                && isset($material_import_price)
                && isset($material_description)
                && isset($material_status)
                && isset($material_image)) {
                $sql_update = "UPDATE tbl_material SET
                    material_name = '$material_name',
                    partner_id = '$partner_id',
                    material_unit = '$material_unit',
                    material_import_price = '$material_import_price',
                    material_description = '$material_description',
                    material_status = '$material_status',
                    material_image = '$material_image',
                    updated_at = NOW()
                    WHERE id='$material_id'";
                $query_update = mysqli_query($connect, $sql_update);

                $sql_table_body = "SELECT * FROM tbl_material WHERE id='$material_id'";
                $query_table_body = mysqli_query($connect, $sql_table_body);
                if (mysqli_num_rows($query_table_body) > 0) {

                    $row_table_body = mysqli_fetch_array($query_table_body);

                    $id_partner_table_body = $row_table_body["partner_id"];
                    $sql_partner_table_body = "SELECT * FROM tbl_partner WHERE id='$id_partner_table_body'";
                    $query_partner_table_body = mysqli_query($connect, $sql_partner_table_body);
                    $row_partner_table_body = mysqli_fetch_array($query_partner_table_body);

                    $sql_partner_edit = "SELECT * FROM tbl_partner ORDER BY id ASC";
                    $query_partner_edit = mysqli_query($connect, $sql_partner_edit);

                    $form_material = '
                                                    <div class="row">
                                                        <div class="col-md-8 col-12">
                                                            <div class="form-group">
                                                            <label for="" class="form-label">Name</label>
                                                            <input type="text" id="material_name' . $row_table_body['id'] . '" class="form-control" name="material_name' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['material_name'] . '"  required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Partner</label>
                                                                <select class="js-choices-edit-partner' . $row_table_body['id'] . ' form-select" id="partner_id' . $row_table_body['id'] . '" name="partner_id' . $row_table_body['id'] . '" required>
                                                                <option value="" selected >CHOOSE...</option>
                    ';

                    while ($row_partner_edit = mysqli_fetch_array($query_partner_edit)) {
                        $form_material .= '<option value="' . $row_partner_edit["id"] . '"';
                        if ($row_partner_edit["id"] == $row_table_body['partner_id']) {
                            $form_material .= 'selected>' . $row_partner_edit["partner_name"] . '</option>';
                        } else {
                            $form_material .= '>' . $row_partner_edit["partner_name"] . '</option>';
                        }
                    }

                    $form_material .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Status</label>
                                                                <select class="js-choices-edit-status' . $row_table_body['id'] . ' form-select" id="material_status' . $row_table_body['id'] . '" name="material_status' . $row_table_body['id'] . '">
                    ';

                    if ($row_table_body['material_status']) {
                        $form_material .= '
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                    ';
                    } else {
                        $form_material .= '
                    <option value="1">Active</option>
                    <option value="0" selected>Inactive</option>
                    ';
                    }

                    $form_material .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Import price</label>
                                                            <input type="text" id="material_import_price' . $row_table_body['id'] . '" class="form-control" name="material_import_price' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['material_import_price'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Unit</label>
                                                            <input type="text" id="material_unit' . $row_table_body['id'] . '" class="form-control" name="material_unit' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['material_unit'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="" class="form-label">Description</label>
                                                                <textarea maxlength="150" class="form-control" id="material_description' . $row_table_body['id'] . '" rows="3" name="material_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['material_description'] . '</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Image</label>
                                                                <div class="form-file">
                                                                            <input type="file" class="form-file-input" name="material_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['material_image'] . '">
                                                                            <label class="form-file-label" for="customFile">
                                                                                <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                                <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                            </label>
                                                                        </div>
                                                                </div>
                                                                <label for="" class="form-label">Preview</label>

                                                                <div class="card">
                                                                        <div class="card-content">

                                                                            <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/materials/' . $row_table_body['material_image'] . '" alt="" >
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

                             element_edit_partner' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-partner' . $row_table_body['id'] . '");
                             choices_edit_partner' . $row_table_body['id'] . ' = new Choices(element_edit_partner' . $row_table_body['id'] . ');

                             element_edit_status' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-status' . $row_table_body['id'] . '");
                             choices_edit_status' . $row_table_body['id'] . ' = new Choices(element_edit_status' . $row_table_body['id'] . ');
                        </script>

                    ';

                    $material_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                    if ($row_table_body["material_status"]) {
                        $material_status_column = '<span class="badge bg-success">Active</span>';
                    } else {
                        $material_status_column = '<span class="badge bg-danger">Inactive</span>';
                    }

                    $material_image_column = '
                            <div class="avatar avatar-xl mr-3">
                                <img src="images/materials/' . $row_table_body["material_image"] . '" alt="" srcset="">
                            </div>
                    ';

                    $table_material = array(
                        "material_id" => $material_column,
                        "material_image" => $material_image_column,
                        "material_name" => $row_table_body["material_name"],
                        "partner_name" => $row_partner_table_body["partner_name"],
                        "material_unit" => $row_table_body["material_unit"],
                        "material_stock" => $row_table_body["material_stock"],
                        "material_import_price" => $row_table_body["material_import_price"],
                        "material_status" => $material_status_column,
                        "edit" => '
                                    <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                                </div>
                        ',
                        "form_material" => $form_material,
                    );
                    echo json_encode($table_material);
                }

            } else {
                $table_material = array(
                    "material_id" => "ERROR",
                    "material_image" => "ERROR",
                    "material_name" => "ERROR",
                    "partner_name" => "ERROR",
                    "material_unit" => "ERROR",
                    "material_stock" => "ERROR",
                    "material_import_price" => "ERROR",
                    "material_status" => "ERROR",
                    "edit" => "ERROR",
                    "form_material" => "",
                );
                echo json_encode($table_material);
            }
        } else {
            if (isset($material_name)
                && isset($partner_id)
                && isset($material_unit)
                && isset($material_import_price)
                && isset($material_description)
                && isset($material_status)) {
                $sql_update = "UPDATE tbl_material SET
                    material_name = '$material_name',
                    partner_id = '$partner_id',
                    material_unit = '$material_unit',
                    material_import_price = '$material_import_price',
                    material_description = '$material_description',
                    material_status = '$material_status',
                    updated_at = NOW()
                    WHERE id='$material_id'";
                $query_update = mysqli_query($connect, $sql_update);

                $sql_table_body = "SELECT * FROM tbl_material WHERE id='$material_id'";
                $query_table_body = mysqli_query($connect, $sql_table_body);
                if (mysqli_num_rows($query_table_body) > 0) {

                    $row_table_body = mysqli_fetch_array($query_table_body);

                    $id_partner_table_body = $row_table_body["partner_id"];
                    $sql_partner_table_body = "SELECT * FROM tbl_partner WHERE id='$id_partner_table_body'";
                    $query_partner_table_body = mysqli_query($connect, $sql_partner_table_body);
                    $row_partner_table_body = mysqli_fetch_array($query_partner_table_body);

                    $sql_partner_edit = "SELECT * FROM tbl_partner ORDER BY id ASC";
                    $query_partner_edit = mysqli_query($connect, $sql_partner_edit);

                    $form_material = '
                                                    <div class="row">
                                                        <div class="col-md-8 col-12">
                                                            <div class="form-group">
                                                            <label for="" class="form-label">Name</label>
                                                            <input type="text" id="material_name' . $row_table_body['id'] . '" class="form-control" name="material_name' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['material_name'] . '"  required>
                                                            </div>



                                                            <div class="form-group">
                                                            <label for="" class="form-label">Partner</label>
                                                                <select class="js-choices-edit-partner' . $row_table_body['id'] . ' form-select" id="partner_id' . $row_table_body['id'] . '" name="partner_id' . $row_table_body['id'] . '" required>
                                                                <option value="" selected >CHOOSE...</option>
                    ';

                    while ($row_partner_edit = mysqli_fetch_array($query_partner_edit)) {
                        $form_material .= '<option value="' . $row_partner_edit["id"] . '"';
                        if ($row_partner_edit["id"] == $row_table_body['partner_id']) {
                            $form_material .= 'selected>' . $row_partner_edit["partner_name"] . '</option>';
                        } else {
                            $form_material .= '>' . $row_partner_edit["partner_name"] . '</option>';
                        }
                    }

                    $form_material .= '
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Status</label>
                                                                <select class="js-choices-edit-status' . $row_table_body['id'] . ' form-select" id="material_status' . $row_table_body['id'] . '" name="material_status' . $row_table_body['id'] . '">
                    ';

                    if ($row_table_body['material_status']) {
                        $form_material .= '
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                    ';
                    } else {
                        $form_material .= '
                    <option value="1">Active</option>
                    <option value="0" selected>Inactive</option>
                    ';
                    }

                    $form_material .= '
                                                                </select>
                                                            </div>


                                                            <div class="form-group">
                                                            <label for="" class="form-label">Import price</label>
                                                            <input type="text" id="material_import_price' . $row_table_body['id'] . '" class="form-control" name="material_import_price' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['material_import_price'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                            <label for="" class="form-label">Unit</label>
                                                            <input type="text" id="material_unit' . $row_table_body['id'] . '" class="form-control" name="material_unit' . $row_table_body['id'] . '"
                                                            value="' . $row_table_body['material_unit'] . '" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="" class="form-label">Description</label>
                                                                <textarea maxlength="150" class="form-control" id="material_description' . $row_table_body['id'] . '" rows="3" name="material_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['material_description'] . '</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-12">
                                                            <div class="form-group">
                                                                <label for="" class="form-label">Image</label>
                                                                <div class="form-file">
                                                                            <input type="file" class="form-file-input" name="material_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['material_image'] . '">
                                                                            <label class="form-file-label" for="customFile">
                                                                                <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                                <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                            </label>
                                                                        </div>
                                                                </div>
                                                                <label for="" class="form-label">Preview</label>

                                                                <div class="card">
                                                                        <div class="card-content">

                                                                            <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/materials/' . $row_table_body['material_image'] . '" alt="" >
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


                             element_edit_partner' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-partner' . $row_table_body['id'] . '");
                             choices_edit_partner' . $row_table_body['id'] . ' = new Choices(element_edit_partner' . $row_table_body['id'] . ');

                             element_edit_status' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-status' . $row_table_body['id'] . '");
                             choices_edit_status' . $row_table_body['id'] . ' = new Choices(element_edit_status' . $row_table_body['id'] . ');
                        </script>

                    ';

                    $material_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                    if ($row_table_body["material_status"]) {
                        $material_status_column = '<span class="badge bg-success">Active</span>';
                    } else {
                        $material_status_column = '<span class="badge bg-danger">Inactive</span>';
                    }

                    $material_image_column = '
                            <div class="avatar avatar-xl mr-3">
                                <img src="images/materials/' . $row_table_body["material_image"] . '" alt="" srcset="">
                            </div>
                    ';

                    $table_material = array(
                        "material_id" => $material_column,
                        "material_image" => $material_image_column,
                        "material_name" => $row_table_body["material_name"],
                        "partner_name" => $row_partner_table_body["partner_name"],
                        "material_unit" => $row_table_body["material_unit"],
                        "material_stock" => $row_table_body["material_stock"],
                        "material_import_price" => $row_table_body["material_import_price"],
                        "material_status" => $material_status_column,
                        "edit" => '
                                    <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                                </div>
                        ',
                        "form_material" => $form_material,
                    );
                    echo json_encode($table_material);
                }

            } else {
                $table_material = array(
                    "material_id" => "ERROR",
                    "material_image" => "ERROR",
                    "material_name" => "ERROR",
                    "partner_name" => "ERROR",
                    "material_unit" => "ERROR",
                    "material_stock" => "ERROR",
                    "material_import_price" => "ERROR",
                    "material_status" => "ERROR",
                    "edit" => "ERROR",
                    "form_material" => "",
                );
                echo json_encode($table_material);
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
            $material_id = $_POST['material_id'];
            $sql_delete = "DELETE FROM tbl_material WHERE id='$material_id'";
            $query_delete = mysqli_query($connect, $sql_delete);
        } else {
            header('location: login.php');
        }
    }
}
