<?php
session_start();
if (!isset($_SESSION["email"])) {
    header('location: login.php');
}
include_once './connect.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {

        $customer_name = $_POST["customer_name"];
        $customer_email = $_POST["customer_email"];
        $customer_phone = $_POST["customer_phone"];
        $customer_address = $_POST["customer_address"];
        $customer_dob = $_POST["customer_dob"];
        $customer_gender = $_POST["customer_gender"];

        if (isset($customer_name)
            && isset($customer_email)
            && isset($customer_phone)
            && isset($customer_address)
            && isset($customer_dob)
            && isset($customer_gender)) {
            $sql = "INSERT INTO tbl_customer (
                    customer_name,
                    customer_email,
                    customer_phone,
                    customer_address,
                    customer_dob,
                    customer_gender,
                    created_at
                    )
                    VALUES (
                    '$customer_name',
                    '$customer_email',
                    '$customer_phone',
                    '$customer_address',
                    '$customer_dob',
                    '$customer_gender',
                    NOW()
                    )";
            $query = mysqli_query($connect, $sql);

            $modal_edit = '';
            $modal_delete = '';

            $sql_table_body = "SELECT * FROM tbl_customer ORDER BY created_at DESC LIMIT 1";
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
                                    <h4 class="modal-title white" id="myModalLabel16">Edit customer</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-body">
                                            <form id="edit-form' . $row_table_body['id'] . '">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group has-icon-left">
                                                            <label for="" class="form-label">Name</label>
                                                            <div class="position-relative">
                                                                <input type="text" class="form-control" value="' . $row_table_body['customer_name'] . '" id="customer_name' . $row_table_body['id'] . '" name="customer_name' . $row_table_body['id'] . '" required>
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
                                                                <input type="text" class="form-control" value="' . $row_table_body['customer_email'] . '" id="customer_email' . $row_table_body['id'] . '" name="customer_email' . $row_table_body['id'] . '" required>
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
                                                                <input type="text" class="form-control" value="' . $row_table_body['customer_phone'] . '" id="customer_phone' . $row_table_body['id'] . '" name="customer_phone' . $row_table_body['id'] . '" required>
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
                                                                <input type="text" class="form-control" value="' . $row_table_body['customer_address'] . '" id="customer_address' . $row_table_body['id'] . '" name="customer_address' . $row_table_body['id'] . '" required>
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
                                                                <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" value="' . $row_table_body['customer_dob'] . '" id="customer_dob' . $row_table_body['id'] . '" name="customer_dob' . $row_table_body['id'] . '" required>
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
                                                                <input type="text" class="form-control" value="' . $row_table_body['customer_gender'] . '" id="customer_gender' . $row_table_body['id'] . '" name="customer_gender' . $row_table_body['id'] . '" required>
                                                                <div class="form-control-icon">
                                                                <i class="fas fa-venus-mars"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            </div>
                                            </form>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_customer(' . $row_table_body['id'] . ')">Update</button>
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
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this customer?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_customer(' . $row_table_body['id'] . ')" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Accept</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                //--------------- End DELETE MODAL ---------------

                $customer_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                $table_customers = array(
                    "customer_id" => $customer_column,
                    "customer_name" => $row_table_body["customer_name"],
                    "customer_email" => $row_table_body["customer_email"],
                    "customer_phone" => $row_table_body["customer_phone"],
                    "customer_address" => $row_table_body["customer_address"],
                    "customer_dob" => $row_table_body["customer_dob"],
                    "customer_gender" => $row_table_body["customer_gender"],
                    "edit" => '
                            <div class="buttons">
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                            </div>
                    ',
                    'modal_edit' => $modal_edit,
                    'modal_delete' => $modal_delete,
                );
                echo json_encode($table_customers);
            }

        } else {
            $table_customers = array(
                "customer_id" => "ERROR",
                "customer_name" => "ERROR",
                "customer_email" => "ERROR",
                "customer_phone" => "ERROR",
                "customer_address" => "ERROR",
                "customer_dob" => "ERROR",
                "customer_gender" => "ERROR",
                "edit" => "ERROR",
                'modal_edit' => "",
                'modal_delete' => "",
            );
            echo json_encode($table_customers);
        }
    }
    if ($_POST["action"] == "update") {

        $customer_id = $_POST["customer_id"];
        $customer_name = $_POST["customer_name"];
        $customer_email = $_POST["customer_email"];
        $customer_phone = $_POST["customer_phone"];
        $customer_address = $_POST["customer_address"];
        $customer_dob = $_POST["customer_dob"];
        $customer_gender = $_POST["customer_gender"];

        if (isset($customer_name)
            && isset($customer_email)
            && isset($customer_phone)
            && isset($customer_address)
            && isset($customer_dob)
            && isset($customer_gender)) {
            $sql_update = "UPDATE tbl_customer SET
                customer_name = '$customer_name',
                customer_email ='$customer_email',
                customer_phone ='$customer_phone',
                customer_address ='$customer_address',
                customer_dob = '$customer_dob',
                customer_gender = '$customer_gender',
                updated_at = NOW()
                WHERE id='$customer_id'";
            $query_update = mysqli_query($connect, $sql_update);

            $sql_table_body = "SELECT * FROM tbl_customer WHERE id='$customer_id'";
            $query_table_body = mysqli_query($connect, $sql_table_body);
            if (mysqli_num_rows($query_table_body) > 0) {

                $row_table_body = mysqli_fetch_array($query_table_body);

                $form_customer = '
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="form-group has-icon-left">
                                    <label for="" class="form-label">Name</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" value="' . $row_table_body['customer_name'] . '" id="customer_name' . $row_table_body['id'] . '" name="customer_name' . $row_table_body['id'] . '" required>
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
                                        <input type="text" class="form-control" value="' . $row_table_body['customer_email'] . '" id="customer_email' . $row_table_body['id'] . '" name="customer_email' . $row_table_body['id'] . '" required>
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
                                        <input type="text" class="form-control" value="' . $row_table_body['customer_phone'] . '" id="customer_phone' . $row_table_body['id'] . '" name="customer_phone' . $row_table_body['id'] . '" required>
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
                                        <input type="text" class="form-control" value="' . $row_table_body['customer_address'] . '" id="customer_address' . $row_table_body['id'] . '" name="customer_address' . $row_table_body['id'] . '" required>
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
                                        <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" value="' . $row_table_body['customer_dob'] . '" id="customer_dob' . $row_table_body['id'] . '" name="customer_dob' . $row_table_body['id'] . '" required>
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
                                        <input type="text" class="form-control" value="' . $row_table_body['customer_gender'] . '" id="customer_gender' . $row_table_body['id'] . '" name="customer_gender' . $row_table_body['id'] . '" required>
                                        <div class="form-control-icon">
                                        <i class="fas fa-venus-mars"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';

                $customer_column = '<a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>';
                $table_customers = array(
                    "customer_id" => $customer_column,
                    "customer_name" => $row_table_body["customer_name"],
                    "customer_email" => $row_table_body["customer_email"],
                    "customer_phone" => $row_table_body["customer_phone"],
                    "customer_address" => $row_table_body["customer_address"],
                    "customer_dob" => $row_table_body["customer_dob"],
                    "customer_gender" => $row_table_body["customer_gender"],
                    "edit" => '
                                <div class="buttons">
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                                    <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                                </div>
                        ',
                    "form_customer" => $form_customer,
                );
                echo json_encode($table_customers);
            }

        } else {
            $table_customers = array(
                "customer_id" => "ERROR",
                "customer_name" => "ERROR",
                "customer_email" => "ERROR",
                "customer_phone" => "ERROR",
                "customer_address" => "ERROR",
                "customer_dob" => "ERROR",
                "customer_gender" => "ERROR",
                "edit" => "ERROR",
                "form_customer" => "",
            );
            echo json_encode($table_customers);
        }
    }

    if ($_POST["action"] == "delete") {
        $email_login = $_SESSION["email"];
        $password_login = $_SESSION["password"];
        $sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
        $query = mysqli_query($connect, $sql);
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $customer_id = $_POST['customer_id'];
            $sql_delete = "DELETE FROM tbl_customer WHERE id='$customer_id'";
            $query_delete = mysqli_query($connect, $sql_delete);
        } else {
            header('location: login.php');
        }
    }
}
