<?php
session_start();

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {
        if (isset($_SESSION["table_production"])) {
            $is_available = 0;
            foreach ($_SESSION["table_production"] as $keys => $values) {
                if ($_SESSION["table_production"][$keys]['product_id'] == $_POST["product_id"]) {
                    $is_available++;
                    $_SESSION["table_production"][$keys]['additional_quantity'] = $_SESSION["table_production"][$keys]['additional_quantity'] + $_POST["additional_quantity"];
                }
            }
            if ($is_available == 0) {
                $item_array = array(
                    'product_id' => $_POST["product_id"],
                    'product_name' => $_POST["product_name"],
                    'product_stock' => $_POST["product_stock"],
                    'additional_quantity' => $_POST["additional_quantity"],
                );
                $_SESSION["table_production"][] = $item_array;
            }
        } else {
            $item_array = array(
                'product_id' => $_POST["product_id"],
                'product_name' => $_POST["product_name"],
                'product_stock' => $_POST["product_stock"],
                'additional_quantity' => $_POST["additional_quantity"],
            );
            $_SESSION["table_production"][] = $item_array;
        }
    }

    if ($_POST["action"] == "update") {
        foreach ($_SESSION["table_production"] as $keys => $values) {
            if ($_SESSION["table_production"][$keys]['product_id'] == $_POST["product_id"]) {
                $_SESSION["table_production"][$keys]['additional_quantity'] = $_POST["additional_quantity"];
            }
        }
    }

    if ($_POST["action"] == "remove") {
        foreach ($_SESSION["table_production"] as $keys => $values) {
            if ($values["product_id"] == $_POST["product_id"]) {
                unset($_SESSION["table_production"][$keys]);
            }
        }
    }

    if ($_POST["action"] == "empty") {
        unset($_SESSION["table_production"]);
    }
}
