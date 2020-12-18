<?php
session_start();
include_once './connect.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {

        $dealer_name = $_POST["dealer_name"];
        $dealer_email = $_POST["dealer_email"];
        $dealer_phone = $_POST["dealer_phone"];
        $dealer_address = $_POST["dealer_address"];
        $dealer_dob = $_POST["dealer_dob"];
        $dealer_gender = $_POST["dealer_gender"];

        if (isset($dealer_name)
            && isset($dealer_email)
            && isset($dealer_phone)
            && isset($dealer_address)
            && isset($dealer_dob)
            && isset($dealer_gender)) {
            $sql = "INSERT INTO tbl_dealer (
                    dealer_name,
                    dealer_email,
                    dealer_phone,
                    dealer_address,
                    dealer_dob,
                    dealer_gender,
                    created_at
                    )
                    VALUES (
                    '$dealer_name',
                    '$dealer_email',
                    '$dealer_phone',
                    '$dealer_address',
                    '$dealer_dob',
                    '$dealer_gender',
                    NOW()
                    )";
            $query = mysqli_query($connect, $sql);

            $modal_edit = '';
            $modal_delete = '';

            $sql_table_body = "SELECT * FROM tbl_dealer ORDER BY created_at DESC LIMIT 1";
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
                                    <h4 class="modal-title white" id="myModalLabel16">Edit dealer</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-body">
                                            <form id="edit-form' . $row_table_body['id'] . '">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="" class="form-label">Name</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="' . $row_table_body['dealer_name'] . '" id="dealer_name' . $row_table_body['id'] . '" name="dealer_name' . $row_table_body['id'] . '" required>
                                                                <div class="form-control-icon">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">

                                                        <div class="form-group has-icon-left">
                                                            <label for="" class="form-label">Email</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="' . $row_table_body['dealer_email'] . '" id="dealer_email' . $row_table_body['id'] . '" name="dealer_email' . $row_table_body['id'] . '" required>
                                                                <div class="form-control-icon">
                                                                    <i class="fas fa-envelope"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="" class="form-label">Phone</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="' . $row_table_body['dealer_phone'] . '" id="dealer_phone' . $row_table_body['id'] . '" name="dealer_phone' . $row_table_body['id'] . '" required>
                                                                <div class="form-control-icon">
                                                                    <i class="fas fa-phone-alt"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="" class="form-label">Address</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="' . $row_table_body['dealer_address'] . '" id="dealer_address' . $row_table_body['id'] . '" name="dealer_address' . $row_table_body['id'] . '" required>
                                                                <div class="form-control-icon">
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="" class="form-label">Date of birth</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" value="' . $row_table_body['dealer_dob'] . '" id="dealer_dob' . $row_table_body['id'] . '" name="dealer_dob' . $row_table_body['id'] . '" required>
                                                                <div class="form-control-icon">
                                                                    <i class="fas fa-child"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="" class="form-label">Gender</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="' . $row_table_body['dealer_gender'] . '" id="dealer_gender' . $row_table_body['id'] . '" name="dealer_gender' . $row_table_body['id'] . '" required>
                                                                <div class="form-control-icon">
                                                                    <i class="fas fa-venus-mars"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                            </form>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_dealer(' . $row_table_body['id'] . ')">Update</button>
                                                <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                            </div>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';
                //--------------- End EDIT MODAL ---------------

                //--------------- End DELETE MODAL ---------------
                $modal_delete .= '
                    <div class="modal fade text-left modal-borderless" id="delete-modal-' . $row_table_body['id'] . '" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this dealer?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_dealer(' . $row_table_body['id'] . ')" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Accept</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                //--------------- End DELETE MODAL ---------------

                $dealer_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                $table_dealers = array(
                    "dealer_id" => $dealer_column,
                    "dealer_name" => $row_table_body["dealer_name"],
                    "dealer_email" => $row_table_body["dealer_email"],
                    "dealer_phone" => $row_table_body["dealer_phone"],
                    "dealer_address" => $row_table_body["dealer_address"],
                    "dealer_dob" => $row_table_body["dealer_dob"],
                    "dealer_gender" => $row_table_body["dealer_gender"],
                    "edit" => '
                            <div class="buttons">
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                            </div>
                    ',
                    'modal_edit' => $modal_edit,
                    'modal_delete' => $modal_delete,
                );
                echo json_encode($table_dealers);
            }

        } else {
            $table_dealers = array(
                "dealer_id" => "ERROR",
                "dealer_name" => "ERROR",
                "dealer_email" => "ERROR",
                "dealer_phone" => "ERROR",
                "dealer_address" => "ERROR",
                "dealer_dob" => "ERROR",
                "dealer_gender" => "ERROR",
                "edit" => "ERROR",
                'modal_edit' => "",
                'modal_delete' => "",
            );
            echo json_encode($table_dealers);
        }
    }
    if ($_POST["action"] == "update") {

        $dealer_id = $_POST["dealer_id"];
        $dealer_name = $_POST["dealer_name"];
        $dealer_email = $_POST["dealer_email"];
        $dealer_phone = $_POST["dealer_phone"];
        $dealer_address = $_POST["dealer_address"];
        $dealer_dob = $_POST["dealer_dob"];
        $dealer_gender = $_POST["dealer_gender"];

        if (isset($dealer_name)
            && isset($dealer_email)
            && isset($dealer_phone)
            && isset($dealer_address)
            && isset($dealer_dob)
            && isset($dealer_gender)) {
            $sql_update = "UPDATE tbl_dealer SET
                dealer_name = '$dealer_name',
                dealer_email ='$dealer_email',
                dealer_phone ='$dealer_phone',
                dealer_address ='$dealer_address',
                dealer_dob = '$dealer_dob',
                dealer_gender = '$dealer_gender',
                updated_at = NOW()
                WHERE id='$dealer_id'";
            $query_update = mysqli_query($connect, $sql_update);

            $sql_table_body = "SELECT * FROM tbl_dealer WHERE id='$dealer_id'";
            $query_table_body = mysqli_query($connect, $sql_table_body);
            if (mysqli_num_rows($query_table_body) > 0) {

                    $row_table_body = mysqli_fetch_array($query_table_body);
                    
                    $form_dealer = '
                            <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="" class="form-label">Name</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" value="' . $row_table_body['dealer_name'] . '" id="dealer_name' . $row_table_body['id'] . '" name="dealer_name' . $row_table_body['id'] . '" required>
                                        <div class="form-control-icon">
                                        <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">

                                <div class="form-group has-icon-left">
                                    <label for="" class="form-label">Email</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" value="' . $row_table_body['dealer_email'] . '" id="dealer_email' . $row_table_body['id'] . '" name="dealer_email' . $row_table_body['id'] . '" required>
                                        <div class="form-control-icon">
                                        <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="" class="form-label">Phone</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" value="' . $row_table_body['dealer_phone'] . '" id="dealer_phone' . $row_table_body['id'] . '" name="dealer_phone' . $row_table_body['id'] . '" required>
                                        <div class="form-control-icon">
                                        <i class="fas fa-phone-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="" class="form-label">Address</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" value="' . $row_table_body['dealer_address'] . '" id="dealer_address' . $row_table_body['id'] . '" name="dealer_address' . $row_table_body['id'] . '" required>
                                        <div class="form-control-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="" class="form-label">Date of birth</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" value="' . $row_table_body['dealer_dob'] . '" id="dealer_dob' . $row_table_body['id'] . '" name="dealer_dob' . $row_table_body['id'] . '" required>
                                        <div class="form-control-icon">
                                        <i class="fas fa-child"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="" class="form-label">Gender</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" value="' . $row_table_body['dealer_gender'] . '" id="dealer_gender' . $row_table_body['id'] . '" name="dealer_gender' . $row_table_body['id'] . '" required>
                                        <div class="form-control-icon">
                                        <i class="fas fa-venus-mars"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    ';

                    $dealer_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                    $table_dealers = array(
                        "dealer_id" => $dealer_column,
                        "dealer_name" => $row_table_body["dealer_name"],
                        "dealer_email" => $row_table_body["dealer_email"],
                        "dealer_phone" => $row_table_body["dealer_phone"],
                        "dealer_address" => $row_table_body["dealer_address"],
                        "dealer_dob" => $row_table_body["dealer_dob"],
                        "dealer_gender" => $row_table_body["dealer_gender"],
                        "edit" => '
                                <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                                </div>
                        ',
                        "form_dealer" => $form_dealer,
                    );
                    echo json_encode($table_dealers);
                }

            } else {
                $table_dealers = array(
                    "dealer_id" => "ERROR",
                    "dealer_name" => "ERROR",
                    "dealer_email" => "ERROR",
                    "dealer_phone" => "ERROR",
                    "dealer_address" => "ERROR",
                    "dealer_dob" => "ERROR",
                    "dealer_gender" => "ERROR",
                    "edit" => "ERROR",
                    "form_dealer" => "",

                );
                echo json_encode($table_dealers);
            }
        }

    if ($_POST["action"] == "delete") {
        $email_login = $_SESSION["email"];
        $password_login = $_SESSION["password"];
        $sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
        $query = mysqli_query($connect, $sql);
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $dealer_id = $_POST['dealer_id'];
            $sql_delete = "DELETE FROM tbl_dealer WHERE id='$dealer_id'";
            $query_delete = mysqli_query($connect, $sql_delete);
        } else {
            header('location: login.php');
        }
    }
}

