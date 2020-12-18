<?php
session_start();
include_once './connect.php';

if (isset($_POST["action"])) {
    if ($_POST["action"] == "add") {

        $inventory_id = $_POST["inventory_id"];
        $dealer_id = $_POST["dealer_id"];
        $inventory_time = $_POST["inventory_time"];
        $inventory_note = $_POST["inventory_note"];
        $materials_updated = $_POST["materials_updated"];
        $quantity_updated = $_POST["quantity_updated"];

        if (isset($inventory_id)
            && isset($dealer_id)
            && isset($inventory_time)
            && isset($inventory_note)
            && isset($materials_updated)
            && isset($quantity_updated)) {
            $sql_inventory = "INSERT INTO tbl_inventory_material (
                                inventory_id,
                                dealer_id,
                                inventory_time,
                                inventory_note,
                                materials_updated,
                                quantity_updated,
                                created_at
                                )
                                VALUES (
                                '$inventory_id',
                                '$dealer_id',
                                '$inventory_time',
                                '$inventory_note',
                                '$materials_updated',
                                '$quantity_updated',
                                NOW()
                                )";
            $query_inventory = mysqli_query($connect, $sql_inventory);

            foreach ($_SESSION["table_material"] as $keys => $values) {
                $material_id = $values["material_id"];
                $material_stock = $values["material_stock"];
                $additional_quantity = $values["additional_quantity"];

                if (isset($inventory_id)
                    && isset($material_id)
                    && isset($material_stock)
                    && isset($additional_quantity)) {
                    $sql_inventory_material_detail = "INSERT INTO tbl_inventory_material_detail (
                                    inventory_id,
                                    material_id,
                                    material_stock,
                                    additional_quantity,
                                    created_at
                                    )
                                    VALUES (
                                    '$inventory_id',
                                    '$material_id',
                                    '$material_stock',
                                    '$additional_quantity',
                                    NOW()
                                    )";
                    $query_inventory_material_detail = mysqli_query($connect, $sql_inventory_material_detail);

                    $value_update_material_stock = $material_stock + $additional_quantity;
                    $sql_update_material_stock = "UPDATE tbl_material SET
                        material_stock = '$value_update_material_stock',
                        updated_at = NOW()
                        WHERE id='$material_id'";
                    $query_update_material_stock = mysqli_query($connect, $sql_update_material_stock);
                }
            }
            unset($_SESSION["table_material"]);

            $modal_view = '';
            $cart_view = '';
            $modal_delete = '';
            $sql_table_body = "SELECT * FROM tbl_inventory_material ORDER BY created_at DESC LIMIT 1";
            $query_table_body = mysqli_query($connect, $sql_table_body);

            if (mysqli_num_rows($query_table_body) > 0) {

                $row_table_body = mysqli_fetch_array($query_table_body);

                $id_dealer_table_body = $row_table_body["dealer_id"];
                $sql_dealer_table_body = "SELECT * FROM tbl_dealer WHERE id='$id_dealer_table_body'";
                $query_dealer_table_body = mysqli_query($connect, $sql_dealer_table_body);
                $row_dealer_table_body = mysqli_fetch_array($query_dealer_table_body);

                //--------------- Start INVENTORY VIEW MODAL ---------------
                $table_view = '';

                $table_view_id = $row_table_body["inventory_id"];
                $sql_table_view = "SELECT * FROM tbl_inventory_material_detail WHERE inventory_id='$table_view_id'";
                $query_table_view = mysqli_query($connect, $sql_table_view);
                $number_row = 1;
                while ($row_table_view = mysqli_fetch_array($query_table_view)) {

                    $table_view_material_id = $row_table_view["material_id"];
                    $sql_table_view_material_id = "SELECT * FROM tbl_material WHERE id='$table_view_material_id'";
                    $query_table_view_material_id = mysqli_query($connect, $sql_table_view_material_id);
                    $row_table_view_material_id = mysqli_fetch_array($query_table_view_material_id);

                    $table_view .= ' <tr>
                                <td>' . $number_row . '</td>
                                <td>' . $row_table_view_material_id["material_name"] . '</td>
                                <td>' . $row_table_view["material_stock"] . '</td>
                                <td>' . $row_table_view["additional_quantity"] . '</td>
                            </tr>';
                    $number_row++;
                }
                $table_view .= '
                            <tr>
                                <td colspan="2" align="center">
                                    <a type="button" class="btn btn-primary round">
                                        Products Updated <span class="badge bg-transparent">' . $row_table_body["materials_updated"] . '</span>
                                    </a>
                                </td>
                                <td colspan="2" align="center">
                                    <a type="button" class="btn btn-primary round">
                                        Quantity Updated <span class="badge bg-transparent">' . $row_table_body["quantity_updated"] . '</span>
                                    </a>
                                </td>
                            </tr>
        ';

                //--------------- End INVENTORY VIEW MODAL ---------------

                //--------------- Start VIEW MODAL ---------------
                $modal_view .= '
                                    <div class="modal fade text-left w-100 modal-borderless" id="view-modal-' . $row_table_body["inventory_id"] . '" tabindex="-1" role="dialog"
                                            aria-labelledby="myModalLabel16" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-full" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                <h4 class="modal-title white" id="myModalLabel16">View inventory</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-4">
                                                    <div class="col-md-8">
                                                            <div class="card-body">
                                                                <div class="card-header">
                                                                    <h4 class="card-heading">ADDITIONAL TABLE</h4>
                                                                </div>

                                                                <table class="table table-hover" id="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Product name</th>
                                                                            <th>Current Quantity</th>
                                                                            <th>Additional Quantity</th>
                                                                        </tr>
                                                                    </thead>
                                                                ' . $table_view . '
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                            <div class="card-body">
                                                                <form role="form" method="post" enctype="multipart/form-data" id="form_view_inventory' . $row_table_body["inventory_id"] . '">
                                                                        <div class="row">
                                                                            <div class="card-header">
                                                                                <h4>INVENTORY DETAILS <strong style="color: #5A8DEE"><small>#' . $row_table_body["inventory_id"] . '</small></strong></h4>
                                                                            </div>

                                                                            <input type="hidden"  id="inventory_id' . $row_table_body["inventory_id"] . '" name="inventory_id' . $row_table_body["inventory_id"] . '" required value="' . $row_table_body["inventory_id"] . '">

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">DEALER</label>
                                                                                <div class="position-relative">
                                                                                    <input type="text" class="form-control" id="dealer_id_text' . $row_table_body["inventory_id"] . '" name="dealer_id_text' . $row_table_body["inventory_id"] . '" readonly="readonly" value="' . $row_dealer_table_body["dealer_name"] . '">
                                                                                    <input type="hidden" class="form-control" id="dealer_id' . $row_table_body["inventory_id"] . '" name="dealer_id' . $row_table_body["inventory_id"] . '" readonly="readonly" value="' . $row_table_body["dealer_id"] . '">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">TIME</label>
                                                                                <div class="position-relative">
                                                                                    <input type="text" class="form-control" id="inventory_time' . $row_table_body["inventory_id"] . '" name="inventory_time' . $row_table_body["inventory_id"] . '" readonly="readonly" value="' . $row_table_body["inventory_time"] . '">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="" class="form-label">NOTE</label>
                                                                                <textarea maxlength="150" class="form-control" id="inventory_note' . $row_table_body["inventory_id"] . '" rows="3" name="inventory_note' . $row_table_body["inventory_id"] . '" readonly="readonly">' . $row_table_body["inventory_note"] . '</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            <div class="col-12 d-flex justify-content-end ">
                                                                <button class="btn btn-primary mr-1 mb-1" onclick="convert_pdf(' . $row_table_body["inventory_id"] . ')">View PDF</button>
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

                // //--------------- End DELETE MODAL ---------------
                $modal_delete .= '
                            <div class="modal fade text-left modal-borderless" id="delete-modal-' . $row_table_body["inventory_id"] . '" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel120" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this inventory?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                                <i class="bx bx-x d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Cancel</span>
                                            </button>
                                            <button type="button" class="btn btn-danger ml-1" onclick="delete_inventory(' . $row_table_body["inventory_id"] . ')" data-dismiss="modal">
                                                <i class="bx bx-check d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Accept</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    ';
                //--------------- End DELETE MODAL ---------------

                $inventory_column = '<a id="td-' . $row_table_body["inventory_id"] . '">' . $row_table_body["inventory_id"] . '<a></td>';
                $table_inventories = array(
                    "inventory_id" => $inventory_column,
                    "dealer_name" => $row_dealer_table_body["dealer_name"],
                    "inventory_time" => $row_table_body["inventory_time"],
                    "materials_updated" => $row_table_body["materials_updated"],
                    "quantity_updated" => $row_table_body["quantity_updated"],
                    "inventory_note" => $row_table_body["inventory_note"],
                    "edit" => '
                                        <div class="buttons">
                                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-warning" data-toggle="modal" data-target="#view-modal-' . $row_table_body["inventory_id"] . '"><i class="far fa-eye"></i></a>
                                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body["inventory_id"] . '"><i class="far fa-trash-alt"></i></a>
                                        </div>
                    ',
                    'modal_view' => $modal_view,
                    'modal_delete' => $modal_delete,
                );
                echo json_encode($table_inventories);
            }

        } else {
            $table_inventories = array(
                "inventory_id" => "ERROR",
                "dealer_name" => "ERROR",
                "inventory_time" => "ERROR",
                "materials_updated" => "ERROR",
                "quantity_updated" => "ERROR",
                "inventory_note" => "ERROR",
                "edit" => "ERROR",
                'modal_view' => "",
                'modal_delete' => "",
            );
            echo json_encode($table_inventories);
        }
    }

    if ($_POST["action"] == "delete") {
        $email_login = $_SESSION["email"];
        $password_login = $_SESSION["password"];
        $sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
        $query = mysqli_query($connect, $sql);
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $inventory_id = $_POST['inventory_id'];
            $sql_delete = "DELETE FROM tbl_inventory_material WHERE inventory_id='$inventory_id'";
            $query_delete = mysqli_query($connect, $sql_delete);

            $sql_select_delete_inventory_detail = "SELECT * FROM tbl_inventory_material_detail WHERE inventory_id='$inventory_id'";
            $query_select_delete_inventory_detail = mysqli_query($connect, $sql_select_delete_inventory_detail);
            while ($row_select_delete_inventory_detail = mysqli_fetch_array($query_select_delete_inventory_detail)) {
                $inventory_id_delete = $row_select_delete_inventory_detail["inventory_id"];

                $material_id = $row_select_delete_inventory_detail["material_id"];

                $sql_select_materials = "SELECT * FROM tbl_material WHERE id='$material_id'";
                $query_select_materials = mysqli_query($connect, $sql_select_materials);
                $row_select_materials = mysqli_fetch_array($query_select_materials);

                $material_stock = $row_select_materials["material_stock"];

                $value_update_material_stock = $material_stock - $row_select_delete_inventory_detail["additional_quantity"];

                $sql_update_material_stock = "UPDATE tbl_material SET
                    material_stock = '$value_update_material_stock',
                    updated_at = NOW()
                    WHERE id='$material_id'";
                $query_update_material_stock = mysqli_query($connect, $sql_update_material_stock);

                $sql_delete_inventory_detail = "DELETE FROM tbl_inventory_material_detail WHERE inventory_id='$inventory_id_delete'";
                $query_delete_inventory_detail = mysqli_query($connect, $sql_delete_inventory_detail);
            }

        } else {
            header('location: login.php');
        }
    }
}
