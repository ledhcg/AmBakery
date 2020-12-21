<?php
session_start();
if (!isset($_SESSION["email"])) {
    header('location: login.php');
}

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {
        if (isset($_SESSION["table_material_used"])) {
            $is_available = 0;
            foreach ($_SESSION["table_material_used"] as $keys => $values) {
                if ($_SESSION["table_material_used"][$keys]['material_id'] == $_POST["material_id"]) {
                    $is_available++;
                    $_SESSION["table_material_used"][$keys]['used_quantity'] = $_SESSION["table_material_used"][$keys]['used_quantity'] + $_POST["used_quantity"];
                }
            }
            if ($is_available == 0) {
                $item_array = array(
                    'material_id' => $_POST["material_id"],
                    'material_name' => $_POST["material_name"],
                    'material_stock' => $_POST["material_stock"],
                    'used_quantity' => $_POST["used_quantity"],
                );
                $_SESSION["table_material_used"][] = $item_array;
            }
        } else {
            $item_array = array(
                'material_id' => $_POST["material_id"],
                'material_name' => $_POST["material_name"],
                'material_stock' => $_POST["material_stock"],
                'used_quantity' => $_POST["used_quantity"],
            );
            $_SESSION["table_material_used"][] = $item_array;
        }
    }

    if ($_POST["action"] == "update") {
        foreach ($_SESSION["table_material_used"] as $keys => $values) {
            if ($_SESSION["table_material_used"][$keys]['material_id'] == $_POST["material_id"]) {
                $_SESSION["table_material_used"][$keys]['used_quantity'] = $_POST["used_quantity"];
            }
        }
    }

    if ($_POST["action"] == "remove") {
        foreach ($_SESSION["table_material_used"] as $keys => $values) {
            if ($values["material_id"] == $_POST["material_id"]) {
                unset($_SESSION["table_material_used"][$keys]);
            }
        }
    }

    if ($_POST["action"] == "empty") {
        unset($_SESSION["table_material_used"]);
    }
}
