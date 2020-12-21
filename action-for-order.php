<?php
session_start();
if (!isset($_SESSION["email"])) {
    header('location: login.php');
}
include_once './connect.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {

        $order_id = $_POST["order_id"];
        $customer_id = $_POST["customer_id"];
        $dealer_id = $_POST["dealer_id"];
        $order_time = $_POST["order_time"];
        $order_message = $_POST["order_message"];
        $order_payment = $_POST["order_payment"];
        $order_total = $_POST["order_total"];
        $order_discount = $_POST["order_discount"];
        $order_received = $_POST["order_received"];
        $order_debit = $_POST["order_debit"];

        if (isset($order_id)
            && isset($customer_id)
            && isset($dealer_id)
            && isset($order_time)
            && isset($order_message)
            && isset($order_payment)
            && isset($order_total)
            && isset($order_discount)
            && isset($order_received)
            && isset($order_debit)) {
            $sql_order = "INSERT INTO tbl_order (
                                order_id,
                                customer_id,
                                dealer_id,
                                order_time,
                                order_message,
                                order_payment,
                                order_total,
                                order_discount,
                                order_received,
                                order_debit,
                                created_at
                                )
                                VALUES (
                                '$order_id',
                                '$customer_id',
                                '$dealer_id',
                                '$order_time',
                                '$order_message',
                                '$order_payment',
                                '$order_total',
                                '$order_discount',
                                '$order_received',
                                '$order_debit',
                                NOW()
                                )";
            $query_order = mysqli_query($connect, $sql_order);

            foreach ($_SESSION["cart"] as $keys => $values) {
                $product_id = $values["product_id"];
                $product_price = $values["product_price"];
                $product_quantity = $values["product_quantity"];
                $product_stock = $values["product_stock"];

                if (isset($order_id)
                    && isset($product_id)
                    && isset($product_price)
                    && isset($product_quantity)) {
                    $sql_order_detail = "INSERT INTO tbl_order_detail (
                                    order_id,
                                    product_id,
                                    product_price,
                                    product_quantity,
                                    created_at
                                    )
                                    VALUES (
                                    '$order_id',
                                    '$product_id',
                                    '$product_price',
                                    '$product_quantity',
                                    NOW()
                                    )";
                    $query_order_detail = mysqli_query($connect, $sql_order_detail);

                    $value_update_product_stock = $product_stock - $product_quantity;
                    $sql_update_product_stock = "UPDATE tbl_product SET
                        product_stock = '$value_update_product_stock',
                        updated_at = NOW()
                        WHERE id='$product_id'";
                    $query_update_product_stock = mysqli_query($connect, $sql_update_product_stock);

                }
            }
            unset($_SESSION["cart"]);

            $modal_view = '';
            $cart_view = '';
            $modal_delete = '';
            $sql_table_body = "SELECT * FROM tbl_order ORDER BY created_at DESC LIMIT 1";
            $query_table_body = mysqli_query($connect, $sql_table_body);
            if (mysqli_num_rows($query_table_body) > 0) {

                $row_table_body = mysqli_fetch_array($query_table_body);
                $id_customer_table_body = $row_table_body["customer_id"];
                $sql_customer_table_body = "SELECT * FROM tbl_customer WHERE id='$id_customer_table_body'";
                $query_customer_table_body = mysqli_query($connect, $sql_customer_table_body);
                $row_customer_table_body = mysqli_fetch_array($query_customer_table_body);

                $id_dealer_table_body = $row_table_body["dealer_id"];
                $sql_dealer_table_body = "SELECT * FROM tbl_dealer WHERE id='$id_dealer_table_body'";
                $query_dealer_table_body = mysqli_query($connect, $sql_dealer_table_body);
                $row_dealer_table_body = mysqli_fetch_array($query_dealer_table_body);

                //--------------- Start CART VIEW MODAL ---------------
                $cart_view_id = $row_table_body["order_id"];
                $sql_cart_view = "SELECT * FROM tbl_order_detail WHERE order_id='$cart_view_id'";
                $query_cart_view = mysqli_query($connect, $sql_cart_view);
                $number_row = 1;
                while ($row_cart_view = mysqli_fetch_array($query_cart_view)) {

                    $cart_view_product_id = $row_cart_view["product_id"];
                    $sql_cart_view_product_id = "SELECT * FROM tbl_product WHERE id='$cart_view_product_id'";
                    $query_cart_view_product_id = mysqli_query($connect, $sql_cart_view_product_id);
                    $row_cart_view_product_id = mysqli_fetch_array($query_cart_view_product_id);

                    $cart_view .= ' <tr>
                                <td>' . $number_row . '</td>
                                <td>' . $row_cart_view_product_id["product_name"] . '</td>
                                <td>' . $row_cart_view["product_quantity"] . '</td>
                                <td>' . $row_cart_view["product_price"] . '</td>
                                <td>' . number_format($row_cart_view["product_price"] * $row_cart_view["product_quantity"], 2) . '</td>
                            </tr>';
                    $number_row++;
                }
                $cart_view .= '
                            <tr>
                                <td colspan="3"></td>
                                <td>Subtotal</td>
                                <td>' . $row_table_body["order_total"] . '</td>
                            </tr>
                ';

                //--------------- End CART VIEW MODAL ---------------

                //--------------- Start EDIT MODAL ---------------
                $modal_view .= '
                                    <div class="modal fade text-left w-100 modal-borderless" id="view-modal-' . $row_table_body["order_id"] . '" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel16" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-full" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                <h4 class="modal-title white" id="myModalLabel16">View order</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-4">
                                                    <div class="col-md-8">
                                                            <div class="card-body">
                                                                <div class="card-header">
                                                                    <h4 class="card-heading">CART</h4>
                                                                </div>

                                                                <table class="table table-hover" id="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Product name</th>
                                                                            <th>Quantity</th>
                                                                            <th>Price</th>
                                                                            <th>Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                ' . $cart_view . '
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                            <div class="card-body">
                                                                <form role="form" method="post" enctype="multipart/form-data" id="form_view_order' . $row_table_body["order_id"] . '">
                                                                        <div class="row">
                                                                            <div class="card-header">
                                                                                <h4>ORDER DETAILS <strong style="color: #5A8DEE"><small>#' . $row_table_body["order_id"] . '</small></strong></h4>
                                                                            </div>

                                                                            <input type="hidden"  id="order_id' . $row_table_body["order_id"] . '" name="order_id' . $row_table_body["order_id"] . '" required value="' . $row_table_body["order_id"] . '">

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">CUSTOMER</label>
                                                                                <div class="position-relative">
                                                                                    <input type="text" class="form-control" id="customer_id_text' . $row_table_body["order_id"] . '" name="customer_id_text' . $row_table_body["order_id"] . '" readonly="readonly" value="' . $row_customer_table_body["customer_name"] . '">
                                                                                    <input type="hidden" class="form-control" id="customer_id' . $row_table_body["order_id"] . '" name="customer_id' . $row_table_body["order_id"] . '" readonly="readonly" value="' . $row_table_body["customer_id"] . '">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">DEALER</label>
                                                                                <div class="position-relative">
                                                                                    <input type="text" class="form-control" id="dealer_id_text' . $row_table_body["order_id"] . '" name="dealer_id_text' . $row_table_body["order_id"] . '" readonly="readonly" value="' . $row_dealer_table_body["dealer_name"] . '">
                                                                                    <input type="hidden" class="form-control" id="dealer_id' . $row_table_body["order_id"] . '" name="dealer_id' . $row_table_body["order_id"] . '" readonly="readonly" value="' . $row_table_body["dealer_id"] . '">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">TIME</label>
                                                                                <div class="position-relative">
                                                                                    <input type="text" class="form-control" id="order_time' . $row_table_body["order_id"] . '" name="order_time' . $row_table_body["order_id"] . '" readonly="readonly" value="' . $row_table_body["order_time"] . '">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">MESSAGE</label>
                                                                                <textarea maxlength="150" class="form-control" id="order_message' . $row_table_body["order_id"] . '" rows="3" name="order_message' . $row_table_body["order_id"] . '" readonly="readonly">' . $row_table_body["order_message"] . '</textarea>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">PAYMENT</label>
                                                                                <input type="text" class="form-control" id="order_payment' . $row_table_body["order_id"] . '" name="order_payment' . $row_table_body["order_id"] . '"  readonly="readonly" value="' . $row_table_body["order_payment"] . '">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">TOTAL</label>
                                                                                <div class="position-relative">
                                                                                    <input type="number" class="form-control"  id="order_total' . $row_table_body["order_id"] . '" name="order_total' . $row_table_body["order_id"] . '" readonly="readonly" value="' . $row_table_body["order_total"] . '">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">DISCOUNT</label>
                                                                                <div class="position-relative">
                                                                                    <input type="number" class="form-control"  id="order_discount' . $row_table_body["order_id"] . '" name="order_discount' . $row_table_body["order_id"] . '" readonly="readonly" value="' . $row_table_body["order_discount"] . '">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">RECEIVED</label>
                                                                                <div class="position-relative" id="received_input' . $row_table_body["order_id"] . '">
                                                                                    <input type="number" class="form-control"  id="order_received' . $row_table_body["order_id"] . '" name="order_received' . $row_table_body["order_id"] . '" onchange="change_debit(' . $row_table_body["order_id"] . ')" required value="' . $row_table_body["order_received"] . '">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">DEBIT</label>
                                                                                <div class="position-relative" id="debit_order_input' . $row_table_body["order_id"] . '">
                                                                                    <input type="number" class="form-control" id="order_debit' . $row_table_body["order_id"] . '" name="order_debit' . $row_table_body["order_id"] . '" readonly="readonly" value="' . $row_table_body["order_debit"] . '">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            <div class="col-12 d-flex justify-content-end ">
                                                                <a class="btn btn-success mr-1 mb-1" href="view-pdf-order.php?order_id=' . $row_table_body["order_id"] . '">View PDF</a>
                                                                <button class="btn btn-primary mr-1 mb-1" onclick="update_order(' . $row_table_body["order_id"] . ')">Update</button>
                                                                <button class="btn btn-light-secondary mr-1 mb-1" data-dismiss="modal" >Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ';
                //--------------- End VIEW MODAL ---------------

                //--------------- End DELETE MODAL ---------------
                $modal_delete .= '
                            <div class="modal fade text-left modal-borderless" id="delete-modal-' . $row_table_body["order_id"] . '" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel120" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this order?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Cancel</span>
                                            </button>
                                            <button type="button" class="btn btn-danger ml-1" onclick="delete_order(' . $row_table_body["order_id"] . ')" data-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Accept</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    ';
                //--------------- End DELETE MODAL ---------------
                $order_column = '<a id="td-' . $row_table_body["order_id"] . '">' . $row_table_body["order_id"] . '<a></td>';
                $table_orders = array(
                    "order_id" => $order_column,
                    "customer_name" => $row_customer_table_body["customer_name"],
                    "dealer_name" => $row_dealer_table_body["dealer_name"],
                    "order_time" => $row_table_body["order_time"],
                    "order_payment" => $row_table_body["order_payment"],
                    "order_total" => $row_table_body["order_total"],
                    "order_discount" => $row_table_body["order_discount"],
                    "order_received" => $row_table_body["order_received"],
                    "order_debit" => $row_table_body["order_debit"],
                    "edit" => '
                                        <div class="buttons">
                                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-warning" data-toggle="modal" data-target="#view-modal-' . $row_table_body["order_id"] . '"><i class="far fa-eye"></i></a>
                                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body["order_id"] . '"><i class="far fa-trash-alt"></i></a>
                                        </div>
                    ',
                    'modal_view' => $modal_view,
                    'modal_delete' => $modal_delete,
                );
                echo json_encode($table_orders);
            }

        } else {
            $table_orders = array(
                "order_id" => "ERROR",
                "customer_name" => "ERROR",
                "dealer_name" => "ERROR",
                "order_time" => "ERROR",
                "order_payment" => "ERROR",
                "order_total" => "ERROR",
                "order_discount" => "ERROR",
                "order_received" => "ERROR",
                "order_debit" => "ERROR",
                "edit" => "ERROR",
                'modal_view' => "",
                'modal_delete' => "",
            );
            echo json_encode($table_orders);
        }
    }
    if ($_POST["action"] == "update") {

        $order_id = $_POST["order_id"];
        $customer_id = $_POST["customer_id"];
        $dealer_id = $_POST["dealer_id"];
        $order_time = $_POST["order_time"];
        $order_message = $_POST["order_message"];
        $order_payment = $_POST["order_payment"];
        $order_total = $_POST["order_total"];
        $order_discount = $_POST["order_discount"];
        $order_received = $_POST["order_received"];
        $order_debit = $_POST["order_debit"];

        if (isset($order_id)
            && isset($customer_id)
            && isset($dealer_id)
            && isset($order_time)
            && isset($order_message)
            && isset($order_payment)
            && isset($order_total)
            && isset($order_discount)
            && isset($order_received)
            && isset($order_debit)) {
            $sql_order_update = "UPDATE tbl_order SET
                                order_id = '$order_id',
                                customer_id = '$customer_id',
                                dealer_id = '$dealer_id',
                                order_time = '$order_time',
                                order_message = '$order_message',
                                order_payment = '$order_payment',
                                order_total = '$order_total',
                                order_discount = '$order_discount',
                                order_received = '$order_received',
                                order_debit = '$order_debit',
                                updated_at = NOW()
                                WHERE order_id='$order_id'";
            $query_order_update = mysqli_query($connect, $sql_order_update);

            $sql_table_body = "SELECT * FROM tbl_order WHERE order_id='$order_id'";
            $query_table_body = mysqli_query($connect, $sql_table_body);
            if (mysqli_num_rows($query_table_body) > 0) {

                $row_table_body = mysqli_fetch_array($query_table_body);
                $id_customer_table_body = $row_table_body["customer_id"];
                $sql_customer_table_body = "SELECT * FROM tbl_customer WHERE id='$id_customer_table_body'";
                $query_customer_table_body = mysqli_query($connect, $sql_customer_table_body);
                $row_customer_table_body = mysqli_fetch_array($query_customer_table_body);

                $id_dealer_table_body = $row_table_body["dealer_id"];
                $sql_dealer_table_body = "SELECT * FROM tbl_dealer WHERE id='$id_dealer_table_body'";
                $query_dealer_table_body = mysqli_query($connect, $sql_dealer_table_body);
                $row_dealer_table_body = mysqli_fetch_array($query_dealer_table_body);

                $order_column = '<a id="td-' . $row_table_body["order_id"] . '">' . $row_table_body["order_id"] . '<a></td>';
                $received_input = '<input type="number" class="form-control"  id="order_received' . $row_table_body["order_id"] . '" name="order_received' . $row_table_body["order_id"] . '" onchange="change_debit(' . $row_table_body["order_id"] . ')" required value="' . $row_table_body["order_received"] . '">';
                $table_orders = array(
                    "order_id" => $order_column,
                    "customer_name" => $row_customer_table_body["customer_name"],
                    "dealer_name" => $row_dealer_table_body["dealer_name"],
                    "order_time" => $row_table_body["order_time"],
                    "order_payment" => $row_table_body["order_payment"],
                    "order_total" => $row_table_body["order_total"],
                    "order_discount" => $row_table_body["order_discount"],
                    "order_received" => $row_table_body["order_received"],
                    "order_debit" => $row_table_body["order_debit"],
                    "edit" => '
                                        <div class="buttons">
                                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-warning" data-toggle="modal" data-target="#view-modal-' . $row_table_body["order_id"] . '"><i class="far fa-eye"></i></a>
                                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body["order_id"] . '"><i class="far fa-trash-alt"></i></a>
                                        </div>',
                    "received_input" => $received_input,
                );
                echo json_encode($table_orders);
            }
        } else {
            $table_orders = array(
                "order_id" => "ERROR",
                "customer_name" => "ERROR",
                "dealer_name" => "ERROR",
                "order_time" => "ERROR",
                "order_payment" => "ERROR",
                "order_total" => "ERROR",
                "order_discount" => "ERROR",
                "order_received" => "ERROR",
                "order_debit" => "ERROR",
                "edit" => "ERROR",
                "received_input" => "",
            );
            echo json_encode($table_orders);
        }
    }

    if ($_POST["action"] == "delete") {
        $email_login = $_SESSION["email"];
        $password_login = $_SESSION["password"];
        $sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
        $query = mysqli_query($connect, $sql);
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $order_id = $_POST['order_id'];
            $sql_delete = "DELETE FROM tbl_order WHERE order_id='$order_id'";
            $query_delete = mysqli_query($connect, $sql_delete);

            $sql_select_delete_order_detail = "SELECT * FROM tbl_order_detail WHERE order_id='$order_id'";
            $query_select_delete_order_detail = mysqli_query($connect, $sql_select_delete_order_detail);
            while ($row_select_delete_order_detail = mysqli_fetch_array($query_select_delete_order_detail)) {
                $order_id_delete = $row_select_delete_order_detail["order_id"];

                $product_id = $row_select_delete_order_detail["product_id"];

                $sql_select_products = "SELECT * FROM tbl_product WHERE id='$product_id'";
                $query_select_products = mysqli_query($connect, $sql_select_products);
                $row_select_products = mysqli_fetch_array($query_select_products);

                $product_stock = $row_select_products["product_stock"];

                $value_update_product_stock = $product_stock + $row_select_delete_order_detail["product_quantity"];

                $sql_update_product_stock = "UPDATE tbl_product SET
                    product_stock = '$value_update_product_stock',
                    updated_at = NOW()
                    WHERE id='$product_id'";
                $query_update_product_stock = mysqli_query($connect, $sql_update_product_stock);

                $sql_delete_order_detail = "DELETE FROM tbl_order_detail WHERE order_id='$order_id_delete'";
                $query_delete_order_detail = mysqli_query($connect, $sql_delete_order_detail);
            }

        } else {
            header('location: login.php');
        }
    }
    if ($_POST["action"] == "add_customer") {
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

            $sql_option_select_customer = "SELECT * FROM tbl_customer ORDER BY id DESC";
            $query_option_select_customer = mysqli_query($connect, $sql_option_select_customer);

            $sql_get_last_id = "SELECT * FROM tbl_customer ORDER BY id DESC LIMIT 1";
            $query_get_last_id = mysqli_query($connect, $sql_get_last_id);
            $row_get_last_id = mysqli_fetch_array($query_get_last_id);

            $option_customer = '
                            <label for="" class="form-label">CUSTOMER</label>
                            <div class="row">
                                <div class="col-md-9">
                                    <select class="js-choices' . $row_get_last_id["id"] . ' customer-choice form-select" id="customer_id">
            ';

            $option_customer .= '<option value="">Choose customer ...</option>';

            if (mysqli_num_rows($query_option_select_customer) > 0) {
                while ($row_option_select_customer = mysqli_fetch_array($query_option_select_customer)) {
                    $option_customer .= '
                                <option value="' . $row_option_select_customer["id"] . '">' . $row_option_select_customer["customer_name"] . '</option>
                    ';
                }
            }
            $option_customer .= '
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex justify-content-between" >
                                    <a style="margin: 5px 0px 5px;" href="#" class="btn btn-primary" onclick="show_modal_add_customer()"><i class="fas fa-user-plus"></i></a>
                                </div>
                            </div>
                            <script>
                            const element' . $row_get_last_id["id"] . ' = document.querySelector(".js-choices' . $row_get_last_id["id"] . '");
                            const choices' . $row_get_last_id["id"] . ' = new Choices(element' . $row_get_last_id["id"] . ');
                            </script>
            ';
            echo $option_customer;
        }
    }
}
