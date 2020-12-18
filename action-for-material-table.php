<?php
session_start();

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {
        if (isset($_SESSION["table_material"])) {
            $is_available = 0;
            foreach ($_SESSION["table_material"] as $keys => $values) {
                if ($_SESSION["table_material"][$keys]['material_id'] == $_POST["material_id"]) {
                    $is_available++;
                    $_SESSION["table_material"][$keys]['additional_quantity'] = $_SESSION["table_material"][$keys]['additional_quantity'] + $_POST["additional_quantity"];
                }
            }
            if ($is_available == 0) {
                $item_array = array(
                    'material_id' => $_POST["material_id"],
                    'material_name' => $_POST["material_name"],
                    'material_stock' => $_POST["material_stock"],
                    'additional_quantity' => $_POST["additional_quantity"],
                );
                $_SESSION["table_material"][] = $item_array;
            }
        } else {
            $item_array = array(
                'material_id' => $_POST["material_id"],
                'material_name' => $_POST["material_name"],
                'material_stock' => $_POST["material_stock"],
                'additional_quantity' => $_POST["additional_quantity"],
            );
            $_SESSION["table_material"][] = $item_array;
        }
    }

    if ($_POST["action"] == "update") {
        foreach ($_SESSION["table_material"] as $keys => $values) {
            if ($_SESSION["table_material"][$keys]['material_id'] == $_POST["material_id"]) {
                $_SESSION["table_material"][$keys]['additional_quantity'] = $_POST["additional_quantity"];
            }
        }
    }

    if ($_POST["action"] == "remove") {
        foreach ($_SESSION["table_material"] as $keys => $values) {
            if ($values["material_id"] == $_POST["material_id"]) {
                unset($_SESSION["table_material"][$keys]);
            }
        }
    }

    if ($_POST["action"] == "empty") {
        unset($_SESSION["table_material"]);
    }
}
