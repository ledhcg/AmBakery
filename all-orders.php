<?php

$table_orders = '';
$modal_view = '';
$modal_delete = '';

$sql_table_body = "SELECT * FROM tbl_order ORDER BY id DESC";
$query_table_body = mysqli_query($connect, $sql_table_body);

$sql_option_product = "SELECT * FROM tbl_product WHERE product_status='1' ORDER BY id";
$query_option_product = mysqli_query($connect, $sql_option_product);

$sql_option_customer = "SELECT * FROM tbl_customer ORDER BY id";
$query_option_customer = mysqli_query($connect, $sql_option_customer);

$sql_option_dealer = "SELECT * FROM tbl_dealer ORDER BY id";
$query_option_dealer = mysqli_query($connect, $sql_option_dealer);

if (mysqli_num_rows($query_table_body) > 0) {
    while ($row_table_body = mysqli_fetch_array($query_table_body)) {

        $id_customer_table_body = $row_table_body["customer_id"];
        $sql_customer_table_body = "SELECT * FROM tbl_customer WHERE id='$id_customer_table_body'";
        $query_customer_table_body = mysqli_query($connect, $sql_customer_table_body);
        $row_customer_table_body = mysqli_fetch_array($query_customer_table_body);

        $id_dealer_table_body = $row_table_body["dealer_id"];
        $sql_dealer_table_body = "SELECT * FROM tbl_dealer WHERE id='$id_dealer_table_body'";
        $query_dealer_table_body = mysqli_query($connect, $sql_dealer_table_body);
        $row_dealer_table_body = mysqli_fetch_array($query_dealer_table_body);

        //--------------- Start TABLE BODY ---------------
        $table_orders .= '
            <tr>
                <td><a id="td-' . $row_table_body["order_id"] . '">' . $row_table_body["order_id"] . '<a></td>
                <td>' . $row_customer_table_body["customer_name"] . '</td>
                <td>' . $row_dealer_table_body["dealer_name"] . '</td>
                <td>' . $row_table_body["order_time"] . '</td>
                <td>' . $row_table_body["order_payment"] . '</td>
                <td>' . $row_table_body["order_total"] . '</td>
                <td>' . $row_table_body["order_discount"] . '</td>
                <td>' . $row_table_body["order_received"] . '</td>
                <td>' . $row_table_body["order_debit"] . '</td>
                <td>
                    <div class="buttons">
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-warning" data-toggle="modal" data-target="#view-modal-' . $row_table_body["order_id"] . '"><i class="far fa-eye"></i></a>
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body["order_id"] . '"><i class="far fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
        ';
        //--------------- End TABLE BODY ---------------

        //--------------- Start CART VIEW MODAL ---------------
        $cart_view = '';

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

        //--------------- Start VIEW MODAL ---------------
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
    }
}
?>

<!--------------- Start HTML --------------->

    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>ALL ORDERS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All orders</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
            <div class="buttons">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal" onclick="create_order_id()">Add a new order</a>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-hover' id="table1">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Dealer</th>
                            <th>Time</th>
                            <th>Payment</th>
                            <th>Total</th>
                            <th>Discount</th>
                            <th>Received</th>
                            <th>Debit</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="add_new_row">
                    <div></div>
<?php
echo $table_orders;
?>

                    </tbody>
                </table>
            </div>
        </div>
<?php
echo $modal_view;
echo $modal_delete;
?>

        <div id="show_new_modal_view"></div>
        <div id="show_new_modal_delete"></div>
    </section>
<!--------------- End HTML --------------->

<!--------------- Start Add Modal --------------->
    <div class="modal fade text-left w-100 modal-borderless" id="add-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-full" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new order</h4>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                                <div class="card-body">
                                                    <div class="card-header">
                                                        <h4 class='card-heading'>CART</h4>
                                                    </div>
                                                    <form id="form_select_product">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">LIST PRODUCTS</label>
                                                            <select class="js-choices3 form-select" id="select_product">

                            <?php
$option_product = '<option value="">Choose product ...</option>';
$input_hidden_product_price = '';
$input_hidden_product_stock = '';
if (mysqli_num_rows($query_option_product) > 0) {
    while ($row_option_product = mysqli_fetch_array($query_option_product)) {
        if ($row_option_product["product_stock"] > 0) {
            $option_product .= '
                                        <option value="' . $row_option_product["id"] . '">' . $row_option_product["product_name"] . '</option>
                                    ';
        } else {
            $option_product .= '
                                        <option value="' . $row_option_product["id"] . '" disabled>' . $row_option_product["product_name"] . '</option>
                                    ';
        }

        $input_hidden_product_price .= '
                                        <input type="hidden" id="product_price' . $row_option_product["id"] . '" value="' . $row_option_product["product_unit_price"] . '" required>
                                    ';

        $input_hidden_product_stock .= '
                                        <input type="hidden" id="product_stock' . $row_option_product["id"] . '" value="' . $row_option_product["product_stock"] . '" required>

                                    ';
    }
}
echo $option_product;
?>
                                                            </select>
                                                        </div>
                            <?php
echo $input_hidden_product_price;
echo $input_hidden_product_stock;
?>
                                                    </form>
                                                    <table class='table table-hover' id="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Product name</th>
                                                                <th>Quantity</th>
                                                                <th>Price</th>
                                                                <th>Total</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="all_items">
                                                        </tbody>
                                                    </table>
                                                </div>

                                        </div>



                                        <div class="col-md-4">

                                                <div class="card-body">
                                                    <form role="form" method="post" enctype="multipart/form-data" id="form_input_order">
                                                            <div class="row">
                                                                <div class="card-header">
                                                                    <h4>ORDER DETAILS <strong style="color: #5A8DEE"><small id="order_id_text"><!--ORDER_ID--></small></strong></h4>
                                                                </div>

                                                                <div id="order_id_input"><!--ORDER_ID_INPUT--></div>

                                                                <div class="form-group" id="option_customer_update">
                                                                    <label for="" class="form-label">CUSTOMER</label>
                                                                    <div class="row">
                                                                        <div class="col-md-9">
                                                                            <select class="js-choices2 customer-choice form-select" id="customer_id">

                            <?php
$option_customer = '<option value="">Choose customer ...</option>';
if (mysqli_num_rows($query_option_customer) > 0) {
    while ($row_option_customer = mysqli_fetch_array($query_option_customer)) {
        $option_customer .= '
                                                        <option value="' . $row_option_customer["id"] . '">' . $row_option_customer["customer_name"] . '</option>
                                                    ';
    }
}
echo $option_customer;
?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3 d-flex justify-content-between" >
                                                                            <a style="margin: 5px 0px 5px;" href="#" class="btn btn-primary" onclick="show_modal_add_customer()"><i class="fas fa-user-plus"></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="" class="form-label">DEALER</label>
                                                                        <select class="js-choices form-select" id="dealer_id">

                            <?php
$option_dealer = '<option value="">Choose dealer ...</option>';
if (mysqli_num_rows($query_option_dealer) > 0) {
    while ($row_option_dealer = mysqli_fetch_array($query_option_dealer)) {
        $option_dealer .= '
                                                        <option value="' . $row_option_dealer["id"] . '">' . $row_option_dealer["dealer_name"] . '</option>
                                                    ';
    }
}
echo $option_dealer;
?>
                                                                        </select>
                                                                </div>



                                                                <div class="form-group" id="picker_date">
                                                                    <label for="" class="form-label">Time</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control datepicker-here" placeholder="Time" id="order_time" name="order_time" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="" class="form-label">Message</label>
                                                                    <textarea maxlength="150" class="form-control" id="order_message" rows="3" name="order_message" placeholder="A message"></textarea>
                                                                </div>


                                                                <div class="divider">
                                                                    <div class="divider-text"><i class="fas fa-shopping-basket"></i></div>
                                                                </div>
                                                                <label class="form-label"></label>

                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="form-label">PAYMENT</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <ul class="list-unstyled mb-0">
                                                                        <li class="d-inline-block mr-5 mb-3">
                                                                            <div class='form-check'>
                                                                                <div class="checkbox">
                                                                                    <input type="checkbox" name="order_payment" class='form-check-input' value="CASH">
                                                                                    <label for="checkbox1">CASH</label>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                        <li class="d-inline-block mr-5 mb-3">
                                                                            <div class='form-check'>
                                                                                <div class="checkbox">
                                                                                    <input type="checkbox" name="order_payment" class='form-check-input' value="CREDIT">
                                                                                    <label for="checkbox2">CREDIT</label>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="" class="form-label">TOTAL</label>
                                                                    <div class="position-relative" id="total_order_input">
                                                                        <input type="number" class="form-control" value="0" id="order_total" onchange="change_debit_add()" name="order_total" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="" class="form-label">DISCOUNT</label>
                                                                    <div class="position-relative">
                                                                        <input type="number" class="form-control" value="0" id="order_discount" onchange="change_debit_add()" name="order_discount" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="" class="form-label">RECEIVED</label>
                                                                    <div class="position-relative">
                                                                        <input type="number" class="form-control" value="0" id="order_received" onchange="change_debit_add()" name="order_received" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="" class="form-label">DEBIT</label>
                                                                    <div class="position-relative" id="debit_order_input">
                                                                        <input type="number" class="form-control" id="order_debit" name="order_debit" readonly="readonly">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                </div>
                                            </form>
                                        <div class="col-12 d-flex justify-content-end ">
                                            <button class="btn btn-primary mr-1 mb-1" onclick="add_order()">Add</button>
                                            <button class="btn btn-light-secondary mr-1 mb-1" data-dismiss="modal" >Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!--------------- End  Add Modal --------------->

<!--------------- Start Add Customer Modal --------------->
<div class="modal fade text-left w-100 modal-borderless" id="add-customer-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new customer</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" method="post" enctype="multipart/form-data" id="add-form-customer">
                                <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Name" id="customer_name" name="customer_name" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">

                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Email</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Email" id="customer_email" name="customer_email" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="mail"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Phone</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Phone" id="customer_phone" name="customer_phone" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="phone"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Address</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Address" id="customer_address" name="customer_address" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="map-pin"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Date of birth</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" placeholder="Date of birth" id="customer_dob" name="customer_dob" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="smile"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Gender</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Gender" id="customer_gender" name="customer_gender" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="users"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </form>
                                <div class="col-12 d-flex justify-content-end">
                                    <button class="btn btn-primary mr-1 mb-1" onclick="create_customer()">Add</button>
                                    <button class="btn btn-light-secondary mr-1 mb-1" onclick="back_modal_add_order()" >Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!--------------- End Add Customer Modal --------------->

<script>

<?php
function show_add_modal()
{
    if (isset($_GET["name_modal"])) {
        if ($_GET["name_modal"] == "add_order") {
            echo "
                        $(document).ready(function(){
                            $('#add-modal').modal('show');
                        });
                    ";
        }
    }
}
echo "create_order_id();";
show_add_modal();
?>
        const element = document.querySelector('.js-choices');
        const choices = new Choices(element);

        const element2 = document.querySelector('.js-choices2');
        const choices2 = new Choices(element2);

        const element3 = document.querySelector('.js-choices3');
        const choices3 = new Choices(element3);

        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

        function show_modal_add_customer(){
            $('#add-modal').modal('toggle');
            $('.modal-backdrop').remove();
            $('#add-customer-modal').modal('show');
        }

        function back_modal_add_order(){
            $('#add-customer-modal').modal('toggle');
            $('.modal-backdrop').remove();
            $('#add-modal').modal('show');
        }

        function create_customer(){

            var customer_name = $('#customer_name').val();
            var customer_email = $('#customer_email').val();
            var customer_phone = $('#customer_phone').val();
            var customer_address = $('#customer_address').val();
            var customer_dob = $('#customer_dob').val();
            var customer_gender = $('#customer_gender').val();
            var action = "add_customer";

            if( !customer_name
                || !customer_email
                || !customer_phone
                || !customer_address
                || !customer_dob
                || !customer_gender) {
                Toastify({
                        text: "Please enter all fields! Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Please enter all fields! Try again!");;
            } else {
                var form_data = new FormData();

                form_data.append("customer_name", customer_name);
                form_data.append("customer_email", customer_email);
                form_data.append("customer_phone", customer_phone);
                form_data.append("customer_address", customer_address);
                form_data.append("customer_dob", customer_dob);
                form_data.append("customer_gender", customer_gender);
                form_data.append("action", action);

                $.ajax({
                    url: "action-for-order.php",
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data){
                        Toastify({
                        text: "A new customer created!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("A new customer created!");;
                        $('#option_customer_update').html(data);
                        $('#add-form-customer')[0].reset();
                        back_modal_add_order();
                    }
                });
            }
        }

        function create_order_id(){
            var order_id_text = $.now().toString().slice(3);
            $('#order_id_text').html("#"+order_id_text);
            var order_id_input = '<input type="hidden" value="' + order_id_text + '" id="order_id" name="order_id" required>'
            $('#order_id_input').html(order_id_input);
        };


        $('input[type="checkbox"]').on('change', function() {
            $('input[type="checkbox"]').not(this).prop('checked', false);

        });

        function add_order(){
            var order_id = $('#order_id').val();
            var customer_id = $('#customer_id').val();
            var dealer_id = $('#dealer_id').val();
            var order_time = $('#order_time').val();
            if($('#order_message').val()){
                var order_message = $('#order_message').val();
            } else {
                var order_message = "Nothing";
            }
            var order_payment;
            $('input[name="order_payment"]:checked').each(function() {
                order_payment = this.value;
            });
            var order_total = $('#order_total').val();
            var order_discount = $('#order_discount').val();
            var order_received = $('#order_received').val();
            var order_debit = $('#order_debit').val();
            var action = "add";

            if( !customer_id
                || !dealer_id
                || !order_time
                || !order_payment
                || !order_discount
                || !order_received) {
                Toastify({
                        text: "Please enter all fields! Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Please enter all fields! Try again!");;
            } else {
                if (parseFloat(order_total) > 0
                && parseFloat(order_discount) >= 0
                && parseFloat(order_received) >= 0
                && parseFloat(order_debit) >= 0){

                    var form_data = new FormData();

                    form_data.append("order_id", order_id);
                    form_data.append("customer_id", customer_id);
                    form_data.append("dealer_id", dealer_id);
                    form_data.append("order_time", order_time);
                    form_data.append("order_message", order_message);
                    form_data.append("order_payment", order_payment);
                    form_data.append("order_total", order_total);
                    form_data.append("order_discount", order_discount);
                    form_data.append("order_received", order_received);
                    form_data.append("order_debit", order_debit);
                    form_data.append("action", action);

                    $.ajax({
                        url: "action-for-order.php",
                        type: "POST",
                        dataType: 'script',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        success: function(data){
                            Toastify({
                        text: "A new order created!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("A new order created!");
                            var data_array = jQuery.parseJSON(data);
                            let newRow = [
                                data_array.order_id,
                                data_array.customer_name,
                                data_array.dealer_name,
                                data_array.order_time,
                                data_array.order_payment,
                                data_array.order_total,
                                data_array.order_discount,
                                data_array.order_received,
                                data_array.order_debit,
                                data_array.edit,
                            ];

                            dataTable.rows().add(newRow);
                            dataTable.sortColumn(0, "desc");
                            $('#show_new_modal_view').append(data_array.modal_view);
                            $('#show_new_modal_delete').append(data_array.modal_delete);
                            load_cart_data();
                            $('#form_input_order')[0].reset();
                            $('#add-modal').modal('toggle');
                            $('.modal-backdrop').remove();
                        }
                    });
                } else {
                    Toastify({
                        text: "[ERROR] Total > 0; Discount >= 0; Received >=0; Debit >= 0! Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                //alert("[ERROR] Total > 0; Discount >= 0; Received >=0; Debit >= 0! Try again!");;
                }
            };
        }

        function update_order(id){
            var order_id = id;
            var customer_id = $('#customer_id'+id).val();
            var dealer_id = $('#dealer_id'+id).val();
            var order_time = $('#order_time'+id).val();
            var order_message = $('#order_message'+id).val();
            var order_payment = $('#order_payment'+id).val();
            var order_total = $('#order_total'+id).val();
            var order_discount = $('#order_discount'+id).val();
            var order_received = $('#order_received'+id).val();
            var order_debit = $('#order_debit'+id).val();
            var action = "update";

            if( !order_received) {
                Toastify({
                        text: "Please enter value for received field! Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Please enter value for received field! Try again!");;
                $('#form_view_order'+id)[0].reset();
                change_debit(id);
            } else {
                if (parseFloat(order_received) >= 0
                && parseFloat(order_debit) >= 0){

                    var form_data = new FormData();

                    form_data.append("order_id", order_id);
                    form_data.append("customer_id", customer_id);
                    form_data.append("dealer_id", dealer_id);
                    form_data.append("order_time", order_time);
                    form_data.append("order_message", order_message);
                    form_data.append("order_payment", order_payment);
                    form_data.append("order_total", order_total);
                    form_data.append("order_discount", order_discount);
                    form_data.append("order_received", order_received);
                    form_data.append("order_debit", order_debit);
                    form_data.append("action", action);

                    $.ajax({
                        url: "action-for-order.php",
                        type: "POST",
                        dataType: 'script',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        success: function(data){
                            Toastify({
                        text: "Order has been updated!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Order has been updated!");;
                            var data_array = jQuery.parseJSON(data);
                            let newRow = [
                                data_array.order_id,
                                data_array.customer_name,
                                data_array.dealer_name,
                                data_array.order_time,
                                data_array.order_payment,
                                data_array.order_total,
                                data_array.order_discount,
                                data_array.order_received,
                                data_array.order_debit,
                                data_array.edit,
                            ];
                            let select = document.getElementById("td-"+id).parentNode;
                            let delete_row = select.parentNode;
                            dataTable.rows().remove(delete_row.dataIndex);
                            dataTable.rows().add(newRow);
                            dataTable.sortColumn(0, "desc");
                            $('#received_input'+id).html(data_array.received_input);
                            $('#form_view_order'+id)[0].reset();
                            $('#view-modal-'+id).modal('toggle');
                            $('.modal-backdrop').remove();
                        }
                    });
                } else {
                    Toastify({
                        text: "[ERROR] Received >=0; Debit >= 0! Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                //alert("[ERROR] Received >=0; Debit >= 0! Try again!");;
                    $('#form_view_order'+id)[0].reset();
                    change_debit(id);
                }
            }

        }

        function delete_order(id){
            var action = "delete";
            var order_id = id;
            $.ajax({
                url: "action-for-order.php",
                type: "POST",
                data: {
                    action: action,
                    order_id: order_id
                },
                success: function(){
                    Toastify({
                        text: "Order has been deleted!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Order has been deleted!");;
                    let select = document.getElementById("td-"+id).parentNode;
                    let delete_row = select.parentNode;
                    console.log(delete_row);
                    dataTable.rows().remove(delete_row.dataIndex);
                }
            });
        }

        function change_debit_add(){
            var value_debit = $('#order_total').val() - $('#order_discount').val() - $('#order_received').val();
            var html = '<input type="number" class="form-control" value="' + value_debit.toFixed(2).toString() + '" id="order_debit" name="order_debit" readonly="readonly">';
            $('#debit_order_input').html(html);
        };

        function change_debit(id){
            var value_debit = $('#order_total'+id).val() - $('#order_discount'+id).val() - $('#order_received'+id).val();
            var html = '<input type="number" class="form-control" value="' + value_debit.toFixed(2).toString() + '" id="order_debit'+id+'" name="order_debit'+id+'" readonly="readonly">';
            $('#debit_order_input'+id).html(html);
        };

        function load_cart_data(){
            $.ajax({
                url: "get-cart.php",
                type: "POST",
                success: function(value){
                    var data = value.split(",");
                    $('#all_items').html(data[0]);
                    $('#total_order_input').html(data[1]);
                    change_debit_add();
                }
            });
        };

        load_cart_data();

        function empty_cart(){
            var action = "empty";
            $.ajax({
                url: "action-for-cart.php",
                type: "POST",
                data: {action: action},
                success: function(){
                    Toastify({
                        text: "Empty cart!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Empty cart");;
                    load_cart_data();
                }
            });
        };

        function delete_cart_item(id){
            var action = "remove";
            var product_id = id;
            $.ajax({
                url: "action-for-cart.php",
                type: "POST",
                data: {
                    action: action,
                    product_id: product_id
                },
                success: function(){
                    Toastify({
                        text: "Delete item!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Delete item!");;
                    load_cart_data();
                }
            });
        };

        function update_item_quantity(id){
            var product_quantity = $("#input_product_quantity"+id).val();
            var product_stock = $("#product_stock"+id).val();
            var action = "update";
            var product_id = id;

            if (product_quantity == 0){
                Toastify({
                        text: "Quantity = 0 => Delete item!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Quantity = 0 => Delete item!");;
                delete_cart_item(id);
            } else if (product_quantity > 0) {

                if( (parseInt(product_stock) - parseInt(product_quantity)) >= 0){
                    $.ajax({
                        url: "action-for-cart.php",
                        type: "POST",
                        data: {
                            action: action,
                            product_id: product_id,
                            product_quantity: product_quantity
                        },
                        success: function(){
                            load_cart_data();
                        }
                    });
                } else {
                    Toastify({
                        text: "Stock is not enough ("+ product_stock +"). Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                    //alert("Stock is not enough ("+ product_stock +"). Try again!");;
                    $("#form_product_quantity"+id)[0].reset();
                }

            } else {
                Toastify({
                        text: "Quantity < 0. Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Quantity < 0. Try again!");;
                $("#form_product_quantity"+id)[0].reset();
            };
        }

        $("#select_product").change(function(){
            var product_id = $(this).val();
            var product_name = $(this).text();
            var product_price = $("#product_price" + product_id).val();
            var product_stock = $("#product_stock" + product_id).val();
            var product_quantity = "1";
            var action = "add";

            var form_data = new FormData();

            form_data.append("product_id", product_id);
            form_data.append("product_name", product_name);
            form_data.append("product_price", product_price);
            form_data.append("product_quantity", product_quantity);
            form_data.append("product_stock", product_stock);
            form_data.append("action", action);

            $.ajax({
                url: "action-for-cart.php",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(){
                    Toastify({
                        text: "\""+ product_name + "\" has been added into cart!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("\""+ product_name + "\" has been added into cart!");
                    load_cart_data();
                    $("#form_select_product")[0].reset();
                }
            });
        });
        //https://www.w3schools.com/sql/trymysql.asp?filename=trysql_func_mysql_last_insert_id

</script>
<!-- <script src="assets/vendors/choices.js/choices.min.js"></script> -->
