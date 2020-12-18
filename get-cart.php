<?php
session_start();

$total_price = 0;

$output = '';
$total_order_input = '';

if (!empty($_SESSION["cart"])) {
    $number_row = 1;
    foreach ($_SESSION["cart"] as $keys => $values) {
        $subtotal = $values["product_price"] * $values["product_quantity"];
        $output .= '
            <tr>
                <td>' . $number_row . '</td>
                <td>' . $values["product_name"] . '</td>

                <td>
                    <div class="form-group">
                    <form id="form_product_quantity' . $values["product_id"] . '">
                        <input style="text-align:center;" min="1" type="number" id="input_product_quantity' . $values["product_id"] . '" class="form-control form-control-sm round" onchange="update_item_quantity(' . $values["product_id"] . ')"
                            value="' . $values["product_quantity"] . '" required>
                    </form>
                    </div>
                </td>
                <td>' . $values["product_price"] . '</td>
                <td align="right">' . $subtotal . '</td>
                <td>
                    <div class="buttons">
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" onclick="delete_cart_item(' . $values["product_id"] . ')"><i class="far fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
        ';
        $number_row++;
        $total_price = $total_price + $subtotal;
    }
    $output .= '
            <tr>
                <td colspan="4" align="right">Subtotal</td>
                <td align="right">' . $total_price . '</td>
                <td>
                    <div class="buttons">
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" onclick="empty_cart()"><i class="fas fa-trash"></i></a>
                    </div>
                </td>
            </tr>
    ';
    $total_order_input .= '<input type="number" class="form-control" value="' . $total_price . '" id="order_total" name="order_total" readonly="readonly">';

} else {
    $total_order_input .= '<input type="number" class="form-control" value="0" id="order_total" name="order_total" readonly="readonly">';

    $output .= '
            <tr>
                <td colspan="6" align="center">This cart is empty!</td>
            </tr>
    ';
}

echo $output . "," . $total_order_input;
