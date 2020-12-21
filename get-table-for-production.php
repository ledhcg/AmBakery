<?php
session_start();
if (!isset($_SESSION["email"])) {
    header('location: login.php');
}

$products_updated = 0;
$quantity_updated = 0;

$output = '';

if (!empty($_SESSION["table_production"])) {
    $number_row = 1;
    foreach ($_SESSION["table_production"] as $keys => $values) {
        $output .= '
            <tr>
                <td>' . $number_row . '</td>
                <td>' . $values["product_id"] . '</td>
                <td>' . $values["product_name"] . '</td>
                <td>' . $values["product_stock"] . '</td>
                <td>
                    <div class="form-group">
                    <form id="form_product_quantity' . $values["product_id"] . '">
                        <input style="text-align:center;" min="1" type="number" id="input_product_quantity' . $values["product_id"] . '" class="form-control form-control-sm round" onchange="update_table_item_quantity(' . $values["product_id"] . ')"
                            value="' . $values["additional_quantity"] . '" required>
                    </form>
                    </div>
                </td>
                <td>
                    <div class="buttons">
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" onclick="delete_table_item(' . $values["product_id"] . ')"><i class="far fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
        ';

        $products_updated = $number_row;
        $quantity_updated = $quantity_updated + $values["additional_quantity"];
        $number_row++;

    }
    $output .= '
            <tr>
                <td></td>
                <td colspan="2" align="center">
                    <a type="button" class="btn btn-primary round">
                        Products Updated <span class="badge bg-transparent " id="products_updated" >' . $products_updated . '</span>
                    </a>
                </td>
                <td colspan="2" align="center">
                    <a type="button" class="btn btn-primary round">
                        Quantity Updated <span class="badge bg-transparent " id="quantity_updated">' . $quantity_updated . '</span>
                    </a>
                </td>
                <td align="center">
                    <div class="buttons">
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" onclick="empty_table()"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
    ';

} else {

    $output .= '
            <tr>
                <td colspan="6" align="center">This table is empty!</td>
            </tr>
    ';
}

echo $output;
