<?php

require_once __DIR__ . '/vendor/autoload.php';
include_once './connect.php';

if (isset($_GET["order_id"])) {
    $order_id = $_GET["order_id"];

    $mpdf = new \Mpdf\Mpdf();
    $stylesheet = file_get_contents('assets/css/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);

    $html = '<h1 align="center">AMBAKERY - dinhcuong.me<h1>';

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
        $html .= '
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
                                                                            <input type="number" class="form-control"  id="order_received' . $row_table_body["order_id"] . '" name="order_received' . $row_table_body["order_id"] . '" onchange="change_debit(' . $row_table_body["order_id"] . ')" required value="' . $row_table_body["order_received"] . '" readonly="readonly">
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
                                                </div>
                                            </div>';

    } else {
        $html .= '<h1 align="center" style="padding: 5px"><i>Not Found with this ORDER ID!</i></h1>';
    }

    $mpdf->WriteHTML($html, 2);
    $mpdf->Output();
}
