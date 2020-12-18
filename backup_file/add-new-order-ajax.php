<?php
session_start();
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
                }
            }
            unset($_SESSION["cart"]);

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

                $table_orders = array(
                    "order_id" => $row_table_body["order_id"],
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
                );
                echo json_encode($table_orders);
            }

        } else {
            $table_orders .= '<tr><td colspan="10">ERROR</td></tr>';
            echo $table_orders;
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
            $sql_order_update = "UPDATE INTO tbl_order SET (
                                order_id = $order_id,
                                customer_id = $customer_id,
                                dealer_id = $dealer_id,
                                order_time = $order_time,
                                order_message = $order_message,
                                order_payment = $order_payment,
                                order_total = $order_payment,
                                order_discount = $order_total,
                                order_received = $order_discount,
                                order_debit = $order_received,
                                updated_at = NOW()
                                ) WHERE order_id='$order_id'";
            $query_order_update = mysqli_query($connect, $sql_order_update);

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

                $table_orders = array(
                    "order_id" => $row_table_body["order_id"],
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
                                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#view-modal-' . $row_table_body["order_id"] . '"><i class="far fa-eye"></i></a>
                                            <a style="margin: 2px 2.5px 2px 2.5px" onclick="return confirmDelete()" href="delete-product.php?id_product=' . $row_table_body["id"] . '" class="btn icon btn-danger"><i class="far fa-trash-alt"></i></a>
                                        </div>
                    ',
                );
                echo json_encode($table_orders);
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
            $order_id = $_POST['order_id'];
            $sql_delete = "DELETE FROM tbl_order WHERE order_id='$order_id'";
            $query_delete = mysqli_query($connect, $sql_delete);

            $sql_select_delete_order_detail = "SELECT * FROM tbl_order_detail WHERE order_id='$order_id'";
            $query_select_delete_order_detail = mysqli_query($connect, $sql_select_delete_order_detail);
            while ($row_select_delete_order_detail = mysqli_fetch_array($query_select_delete_order_detail)) {
                $order_id_delete = $row_select_delete_order_detail["order_id"];
                $sql_delete_order_detail = "DELETE FROM tbl_order_detail WHERE order_id='$order_id_delete'";
                $query_delete_order_detail = mysqli_query($connect, $sql_delete_order_detail);
            }

        } else {
            header('location: login.php');
        }
    }
}
