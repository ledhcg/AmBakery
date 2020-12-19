<?php

require_once __DIR__ . '/vendor/autoload.php';
include_once './connect.php';

if (isset($_GET["inv_used_id"])) {
    $inv_used_id = $_GET["inv_used_id"];

    $mpdf = new \Mpdf\Mpdf();
    $stylesheet = file_get_contents('assets/css/bootstrap.css');
    $mpdf->WriteHTML($stylesheet, 1);

    $html = '<h1 align="center">AMBAKERY - dinhcuong.me<h1>';

    $sql_table_body = "SELECT * FROM tbl_used_material WHERE inv_used_id='$inv_used_id'";
    $query_table_body = mysqli_query($connect, $sql_table_body);

    if (mysqli_num_rows($query_table_body) > 0) {

        $row_table_body = mysqli_fetch_array($query_table_body);

        $id_dealer_table_body = $row_table_body["dealer_id"];
        $sql_dealer_table_body = "SELECT * FROM tbl_dealer WHERE id='$id_dealer_table_body'";
        $query_dealer_table_body = mysqli_query($connect, $sql_dealer_table_body);
        $row_dealer_table_body = mysqli_fetch_array($query_dealer_table_body);

        $table_view = '';

        $table_view_id = $row_table_body["inv_used_id"];
        $sql_table_view = "SELECT * FROM tbl_used_material_detail WHERE inv_used_id='$table_view_id'";
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
                                <td>' . $row_table_view["used_quantity"] . '</td>
                            </tr>';
            $number_row++;
        }
        $table_view .= '
                            <tr>
                                <td colspan="2" align="center">
                                    <a type="button" class="btn btn-primary round">
                                        Materials Updated: ' . $row_table_body["materials_updated"] . '
                                    </a>
                                </td>
                                <td colspan="2" align="center">
                                    <a type="button" class="btn btn-primary round">
                                        Quantity Updated: ' . $row_table_body["quantity_updated"] . '
                                    </a>
                                </td>
                            </tr>
        ';
        $html .= '
        <div class="row mb-4">
                                            <div class="col-md-8">
                                                    <div class="card-body">
                                                        <div class="card-header">
                                                            <h4 class="card-heading">USED TABLE</h4>
                                                        </div>

                                                        <table class="table table-hover" id="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Material name</th>
                                                                    <th>Current Quantity</th>
                                                                    <th>Used Quantity</th>
                                                                </tr>
                                                            </thead>
                                                           ' . $table_view . '
                                                            </tbody>
                                                        </table>
                                                    </div>

                                            </div>
                                            <div class="col-md-4">
                                                    <div class="card-body">
                                                        <form role="form" method="post" enctype="multipart/form-data" id="form_view_inv_used' . $row_table_body["inv_used_id"] . '">
                                                                <div class="row">
                                                                    <div class="card-header">
                                                                        <h4>INVENTORY DETAILS <strong style="color: #5A8DEE"><small>#' . $row_table_body["inv_used_id"] . '</small></strong></h4>
                                                                    </div>

                                                                    <input type="hidden"  id="inv_used_id' . $row_table_body["inv_used_id"] . '" name="inv_used_id' . $row_table_body["inv_used_id"] . '" required value="' . $row_table_body["inv_used_id"] . '">

                                                                    <div class="form-group">
                                                                        <label for="" class="form-label">DEALER</label>
                                                                        <div class="position-relative">
                                                                            <input type="text" class="form-control" id="dealer_id_text' . $row_table_body["inv_used_id"] . '" name="dealer_id_text' . $row_table_body["inv_used_id"] . '" readonly="readonly" value="' . $row_dealer_table_body["dealer_name"] . '">
                                                                            <input type="hidden" class="form-control" id="dealer_id' . $row_table_body["inv_used_id"] . '" name="dealer_id' . $row_table_body["inv_used_id"] . '" readonly="readonly" value="' . $row_table_body["dealer_id"] . '">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="" class="form-label">TIME</label>
                                                                        <div class="position-relative">
                                                                            <input type="text" class="form-control" id="inv_used_time' . $row_table_body["inv_used_id"] . '" name="inv_used_time' . $row_table_body["inv_used_id"] . '" readonly="readonly" value="' . $row_table_body["inv_used_time"] . '">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="" class="form-label">NOTE</label>
                                                                        <textarea maxlength="150" class="form-control" id="inv_used_note' . $row_table_body["inv_used_id"] . '" rows="3" name="inv_used_note' . $row_table_body["inv_used_id"] . '" readonly="readonly">' . $row_table_body["inv_used_note"] . '</textarea>
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
