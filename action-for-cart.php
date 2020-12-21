<?php
session_start();
if (!isset($_SESSION["email"])) {
    header('location: login.php');
}

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {
        if (isset($_SESSION["cart"])) {
            $is_available = 0;
            foreach ($_SESSION["cart"] as $keys => $values) {
                if ($_SESSION["cart"][$keys]['product_id'] == $_POST["product_id"]) {
                    $is_available++;
                    $_SESSION["cart"][$keys]['product_quantity'] = $_SESSION["cart"][$keys]['product_quantity'] + $_POST["product_quantity"];
                }
            }
            if ($is_available == 0) {
                $item_array = array(
                    'product_id' => $_POST["product_id"],
                    'product_name' => $_POST["product_name"],
                    'product_quantity' => $_POST["product_quantity"],
                    'product_price' => $_POST["product_price"],
                    'product_stock' => $_POST["product_stock"],
                );
                $_SESSION["cart"][] = $item_array;
            }
        } else {
            $item_array = array(
                'product_id' => $_POST["product_id"],
                'product_name' => $_POST["product_name"],
                'product_quantity' => $_POST["product_quantity"],
                'product_price' => $_POST["product_price"],
                'product_stock' => $_POST["product_stock"],
            );
            $_SESSION["cart"][] = $item_array;
        }
    }

    if ($_POST["action"] == "update") {
        foreach ($_SESSION["cart"] as $keys => $values) {
            if ($_SESSION["cart"][$keys]['product_id'] == $_POST["product_id"]) {
                $_SESSION["cart"][$keys]['product_quantity'] = $_POST["product_quantity"];
            }
        }
    }

    if ($_POST["action"] == "remove") {
        foreach ($_SESSION["cart"] as $keys => $values) {
            if ($values["product_id"] == $_POST["product_id"]) {
                unset($_SESSION["cart"][$keys]);
            }
        }
    }

    if ($_POST["action"] == "empty") {
        unset($_SESSION["cart"]);
    }
}
