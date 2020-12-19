<?php

$table_inventories = '';
$modal_view = '';
$modal_delete = '';

$sql_table_body = "SELECT * FROM tbl_inventory_material ORDER BY id DESC";
$query_table_body = mysqli_query($connect, $sql_table_body);

$sql_option_material = "SELECT * FROM tbl_material ORDER BY id";
$query_option_material = mysqli_query($connect, $sql_option_material);

$sql_option_dealer = "SELECT * FROM tbl_dealer ORDER BY id";
$query_option_dealer = mysqli_query($connect, $sql_option_dealer);

if (mysqli_num_rows($query_table_body) > 0) {
    while ($row_table_body = mysqli_fetch_array($query_table_body)) {

        $id_dealer_table_body = $row_table_body["dealer_id"];
        $sql_dealer_table_body = "SELECT * FROM tbl_dealer WHERE id='$id_dealer_table_body'";
        $query_dealer_table_body = mysqli_query($connect, $sql_dealer_table_body);
        $row_dealer_table_body = mysqli_fetch_array($query_dealer_table_body);

        //--------------- Start TABLE BODY ---------------
        $table_inventories .= '
            <tr>
                <td><a id="td-' . $row_table_body["inventory_id"] . '">' . $row_table_body["inventory_id"] . '<a></td>
                <td>' . $row_dealer_table_body["dealer_name"] . '</td>
                <td>' . $row_table_body["inventory_time"] . '</td>
                <td>' . $row_table_body["materials_updated"] . '</td>
                <td>' . $row_table_body["quantity_updated"] . '</td>
                <td>' . $row_table_body["inventory_note"] . '</td>
                <td>
                    <div class="buttons">
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-warning" data-toggle="modal" data-target="#view-modal-' . $row_table_body["inventory_id"] . '"><i class="far fa-eye"></i></a>
                        <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body["inventory_id"] . '"><i class="far fa-trash-alt"></i></a>
                    </div>
                </td>
            </tr>
        ';
        //--------------- End TABLE BODY ---------------

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
                                        Materials Updated <span class="badge bg-transparent">' . $row_table_body["materials_updated"] . '</span>
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
                                                                    <th>Material name</th>
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
                                                        <a class="btn btn-success mr-1 mb-1" href="view-pdf-material-inv-added.php?inventory_id=' . $row_table_body["inventory_id"] . '">View PDF</a>
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
    }
}
?>

<!--------------- Start HTML --------------->

    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>ALL IMPORT MATERIAL INVENTORIES</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All import material inventories</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
            <div class="buttons">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal" onclick="create_id()">Add a new inventory</a>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-hover' id="table1">
                    <thead>
                        <tr>
                            <th>Inventory ID</th>
                            <th>Dealer</th>
                            <th>Time</th>
                            <th>Materials Updated</th>
                            <th>Quantity Updated</th>
                            <th>Note</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody id="add_new_row">
                    <div></div>
<?php
echo $table_inventories;
?>

                    </tbody>
                </table>
            </div>
        </div>
<?php
echo $modal_view;
echo $modal_delete;
?>

        <div id="show_new_modal_view"></div>
        <div id="show_new_modal_delete"></div>
    </section>
<!--------------- End HTML --------------->

<!--------------- Start Add Modal --------------->
    <div class="modal fade text-left w-100 modal-borderless" id="add-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-full" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new inventory</h4>
                            </div>
                            <div class="modal-body">
                                    <div class="row mb-4">
                                        <div class="col-md-8">
                                                <div class="card-body">
                                                    <div class="card-header">
                                                        <h4 class='card-heading'>ADDITIONAL QUANTITY</h4>
                                                    </div>
                                                    <form id="form_select_material">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">LIST PRODUCTS</label>
                                                            <select class="js-choices3 form-select" id="select_material">

                            <?php
$option_material = '<option value="">Choose material ...</option>';
$input_hidden_material_price = '';
if (mysqli_num_rows($query_option_material) > 0) {
    while ($row_option_material = mysqli_fetch_array($query_option_material)) {
        $option_material .= '
                                        <option value="' . $row_option_material["id"] . '">' . $row_option_material["material_name"] . '</option>
                                    ';
        $input_hidden_material_price .= '
                                        <input type="hidden" id="material_stock' . $row_option_material["id"] . '" value="' . $row_option_material["material_stock"] . '" required>
                                    ';
    }
}
echo $option_material;
?>
                                                            </select>
                                                        </div>
                            <?php
echo $input_hidden_material_price;
?>
                                                    </form>
                                                    <table class='table table-hover' id="table">
                                                        <thead>
                                                            <tr>
                                                                    <th>#</th>
                                                                    <th>ID Material</th>
                                                                    <th>Material name</th>
                                                                    <th>Current Quantity</th>
                                                                    <th>Additional Quantity</th>
                                                                    <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="all_items">
                                                        </tbody>
                                                    </table>
                                                </div>

                                        </div>



                                        <div class="col-md-4">

                                                <div class="card-body">
                                                    <form role="form" method="post" enctype="multipart/form-data" id="form_input_inventory">
                                                            <div class="row">
                                                                <div class="card-header">
                                                                    <h4>ID <strong style="color: #5A8DEE"><small id="inventory_id_text"><!--inventory_id--></small></strong></h4>
                                                                </div>

                                                                <div id="inventory_id_input"><!--inventory_id_input--></div>



                                                                <div class="form-group">
                                                                    <label for="" class="form-label">DEALER</label>
                                                                        <select class="js-choices form-select" id="dealer_id">

                            <?php
$option_dealer = '<option value="">Choose dealer ...</option>';
if (mysqli_num_rows($query_option_dealer) > 0) {
    while ($row_option_dealer = mysqli_fetch_array($query_option_dealer)) {
        $option_dealer .= '
                                                        <option value="' . $row_option_dealer["id"] . '">' . $row_option_dealer["dealer_name"] . '</option>
                                                    ';
    }
}
echo $option_dealer;
?>
                                                                        </select>
                                                                </div>



                                                                <div class="form-group" id="picker_date">
                                                                    <label for="" class="form-label">TIME</label>
                                                                    <div class="position-relative">
                                                                        <input type="text" class="form-control datepicker-here" placeholder="Time" id="inventory_time" name="inventory_time" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="" class="form-label">NOTE</label>
                                                                    <textarea maxlength="150" class="form-control" id="inventory_note" rows="3" name="inventory_note" placeholder="Note"></textarea>
                                                                </div>




                                                            </div>
                                                </div>
                                            </form>
                                        <div class="col-12 d-flex justify-content-end ">
                                            <button class="btn btn-primary mr-1 mb-1" onclick="add_inventory()">Add</button>
                                            <button class="btn btn-light-secondary mr-1 mb-1" data-dismiss="modal" >Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!--------------- End  Add Modal --------------->

<div id="load_page_all_materials">
</div>

<script>

<?php
function show_add_modal()
{
    if (isset($_GET["name_modal"])) {
        if ($_GET["name_modal"] == "add_material_inventory") {
            echo "
                        $(document).ready(function(){
                            $('#add-modal').modal('show');
                        });
                    ";
        }
    }
}
echo "create_id();";
show_add_modal();
?>
        const element = document.querySelector('.js-choices');
        const choices = new Choices(element);

        const element3 = document.querySelector('.js-choices3');
        const choices3 = new Choices(element3);

        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);



        function create_id(){
            var inventory_id_text = $.now().toString().slice(3);
            $('#inventory_id_text').html("#"+inventory_id_text);
            var inventory_id_input = '<input type="hidden" value="' + inventory_id_text + '" id="inventory_id" name="inventory_id" required>'
            $('#inventory_id_input').html(inventory_id_input);
        };

        function load_page_materials(){
            $('#load_page_all_materials').load("all-materials-in-material-statistics.php");
        }

        function load_page_materials_fix_script(){
            $('#load_page_all_materials').load("all-materials-in-material-statistics-fix-script.php");
        }

        load_page_materials();

        function add_inventory(){

            var inventory_id = $('#inventory_id').val();
            var dealer_id = $('#dealer_id').val();
            var inventory_time = $('#inventory_time').val();
            var materials_updated = $('#materials_updated').text();
            var quantity_updated = $('#quantity_updated').text();

            if($('#inventory_note').val()){
                var inventory_note = $('#inventory_note').val();
            } else {
                var inventory_note = "Nothing";
            }
            var action = "add";

            if( !dealer_id
                || !inventory_time) {
                Toastify({
                        text: "Please enter all fields! Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                        //alert("Please enter all fields! Try again!");;
            } else {

                    var form_data = new FormData();

                    form_data.append("inventory_id", inventory_id);
                    form_data.append("dealer_id", dealer_id);
                    form_data.append("inventory_time", inventory_time);
                    form_data.append("inventory_note", inventory_note);
                    form_data.append("materials_updated", materials_updated);
                    form_data.append("quantity_updated", quantity_updated);
                    form_data.append("action", action);

                    $.ajax({
                        url: "action-for-material-inventory.php",
                        type: "POST",
                        dataType: 'script',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        success: function(data){
                            Toastify({
                        text: "A new inventory created!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                        //alert("A new inventory created!");
                            var data_array = jQuery.parseJSON(data);
                            let newRow = [
                                data_array.inventory_id,
                                data_array.dealer_name,
                                data_array.inventory_time,
                                data_array.materials_updated,
                                data_array.quantity_updated,
                                data_array.inventory_note,
                                data_array.edit,
                            ];
                            dataTable.rows().add(newRow);
                            dataTable.sortColumn(0, "desc");
                            $('#show_new_modal_view').append(data_array.modal_view);
                            $('#show_new_modal_delete').append(data_array.modal_delete);
                            load_table_data();
                            load_page_materials_fix_script();
                            $('#form_input_inventory')[0].reset();
                            $('#add-modal').modal('toggle');
                            $('.modal-backdrop').remove();
                        }
                    });
                }
            };


        function delete_inventory(id){
            var action = "delete";
            var inventory_id = id;
            $.ajax({
                url: "action-for-material-inventory.php",
                type: "POST",
                data: {
                    action: action,
                    inventory_id: inventory_id
                },
                success: function(){
                    Toastify({
                        text: "Inventory has been deleted!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                    //alert("Inventory has been deleted!");;
                    let select = document.getElementById("td-"+id).parentNode;
                    let delete_row = select.parentNode;
                    console.log(delete_row);
                    dataTable.rows().remove(delete_row.dataIndex);
                    load_page_materials();
                }
            });
        }

        function load_table_data(){
            $.ajax({
                url: "get-table-for-material.php",
                type: "POST",
                success: function(data){
                    $('#all_items').html(data);
                }
            });
        };

        load_table_data();

        function empty_table(){
            var action = "empty";
            $.ajax({
                url: "action-for-material-table.php",
                type: "POST",
                data: {action: action},
                success: function(){
                    Toastify({
                        text: "Empty table!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Empty table");;
                    load_table_data();
                }
            });
        };

        function delete_table_item(id){
            var action = "remove";
            var material_id = id;
            $.ajax({
                url: "action-for-material-table.php",
                type: "POST",
                data: {
                    action: action,
                    material_id: material_id
                },
                success: function(){
                    Toastify({
                        text: "Delete item!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                    //alert("Delete item!");;
                    load_table_data();
                }
            });
        };

        function update_table_item_quantity(id){
            var additional_quantity = $("#input_material_quantity"+id).val();
            var action = "update";
            var material_id = id;

            if (additional_quantity == 0){
                Toastify({
                        text: "Quantity = 0 => Delete item!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                        //alert("Quantity = 0 => Delete item!");;
                        delete_table_item(id);
            } else if (additional_quantity > 0) {
                $.ajax({
                    url: "action-for-material-table.php",
                    type: "POST",
                    data: {
                        action: action,
                        material_id: material_id,
                        additional_quantity: additional_quantity
                    },
                    success: function(){
                        load_table_data();
                    }
                });
            } else {
                Toastify({
                        text: "Quantity < 0. Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                        //alert("Quantity < 0. Try again!");;
                        $("#form_material_quantity"+id)[0].reset();
            };
        }

        $("#select_material").change(function(){
            var material_id = $(this).val();
            var material_name = $(this).text();
            var material_stock = $("#material_stock" + material_id).val();
            var additional_quantity = "1";
            var action = "add";

            var form_data = new FormData();

            form_data.append("material_id", material_id);
            form_data.append("material_name", material_name);
            form_data.append("material_stock", material_stock);
            form_data.append("additional_quantity", additional_quantity);
            form_data.append("action", action);

            $.ajax({
                url: "action-for-material-table.php",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(){
                    Toastify({
                        text: "\""+ material_name + "\" has been added into table!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                        //alert("\""+ material_name + "\" has been added into table!");
                    load_table_data();
                    $("#form_select_material")[0].reset();
                }
            });
        });
        //https://www.w3schools.com/sql/trymysql.asp?filename=trysql_func_mysql_last_insert_id




        //---------------------Script for All Materials--------------------------

        // table2 = document.querySelector('#table2');
        // dataTable2 = new simpleDatatables.DataTable(table2);

        //---------------------Script for All Materials--------------------------


</script>
<!-- <script src="assets/vendors/choices.js/choices.min.js"></script> -->



