<?php

$table_materials = '';
$modal_edit = '';
$modal_delete = '';

$sql_table_body = "SELECT * FROM tbl_material ORDER BY id DESC";
$query_table_body = mysqli_query($connect, $sql_table_body);

$sql_partner_add = "SELECT * FROM tbl_partner ORDER BY id ASC";
$query_partner_add = mysqli_query($connect, $sql_partner_add);

if (mysqli_num_rows($query_table_body) > 0) {
    while ($row_table_body = mysqli_fetch_array($query_table_body)) {

        $id_partner_table_body = $row_table_body["partner_id"];
        $sql_partner_table_body = "SELECT * FROM tbl_partner WHERE id='$id_partner_table_body'";
        $query_partner_table_body = mysqli_query($connect, $sql_partner_table_body);
        $row_partner_table_body = mysqli_fetch_array($query_partner_table_body);

        //--------------- Start TABLE BODY ---------------
        $table_materials .= '
                <tr>
                    <td><a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '</a></td>
                    <td>
                        <div class="avatar avatar-xl mr-3">
                            <img src="images/materials/' . $row_table_body["material_image"] . '" alt="" srcset="">
                        </div>
                    </td>
                    <td>' . $row_table_body["material_name"] . '</td>
                    <td>' . $row_partner_table_body["partner_name"] . '</td>
                    <td>' . $row_table_body["material_unit"] . '</td>
                    <td>' . $row_table_body["material_stock"] . '</td>
                    <td>' . $row_table_body["material_import_price"] . '</td>
        ';

        if ($row_table_body["material_status"]) {
            $table_materials .= '<td><span class="badge bg-success">Active</span></td>';
        } else {
            $table_materials .= '<td><span class="badge bg-danger">Inactive</span></td>';
        }

        $table_materials .= '
                    <td>
                        <div class="buttons">
                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                        </div>
                    </td>
                </tr>
        ';
        //--------------- End TABLE BODY ---------------

        //--------------- Start EDIT MODAL ---------------
        $modal_edit .= '
                        <div class="modal fade text-left w-100 modal-borderless" id="edit-modal-' . $row_table_body["id"] . '" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel16" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                    <h4 class="modal-title white" id="myModalLabel16">Edit material</h4>
                                    </div>
                                    <div class="modal-body">
        ';

        $sql_partner_edit = "SELECT * FROM tbl_partner ORDER BY id ASC";
        $query_partner_edit = mysqli_query($connect, $sql_partner_edit);

        $modal_edit .= '
                                            <div class="form-body">
                                                <form id="edit-form' . $row_table_body['id'] . '">

                                                <div class="row">
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-group">
                                                        <label for="" class="form-label">Name</label>
                                                        <input type="text" id="material_name' . $row_table_body['id'] . '" class="form-control" name="material_name' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['material_name'] . '"  required>
                                                        </div>



                                                        <div class="form-group">
                                                        <label for="" class="form-label">Partner</label>
                                                            <select class="js-choices-edit-partner' . $row_table_body['id'] . ' form-select" id="partner_id' . $row_table_body['id'] . '" name="partner_id' . $row_table_body['id'] . '" required>
                                                            <option value="" selected >CHOOSE...</option>
        ';

        while ($row_partner_edit = mysqli_fetch_array($query_partner_edit)) {
            $modal_edit .= '<option value="' . $row_partner_edit["id"] . '"';
            if ($row_partner_edit["id"] == $row_table_body['partner_id']) {
                $modal_edit .= 'selected>' . $row_partner_edit["partner_name"] . '</option>';
            } else {
                $modal_edit .= '>' . $row_partner_edit["partner_name"] . '</option>';
            }
        }

        $modal_edit .= '
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Status</label>
                                                            <select class="js-choices-edit-status' . $row_table_body['id'] . ' form-select" id="material_status' . $row_table_body['id'] . '" name="material_status' . $row_table_body['id'] . '">
        ';

        if ($row_table_body['material_status']) {
            $modal_edit .= '
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            ';
        } else {
            $modal_edit .= '
                <option value="1">Active</option>
                <option value="0" selected>Inactive</option>
            ';
        }

        $modal_edit .= '
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Import price</label>
                                                        <input type="text" id="material_import_price' . $row_table_body['id'] . '" class="form-control" name="material_import_price' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['material_import_price'] . '" required>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Unit</label>
                                                        <input type="text" id="material_unit' . $row_table_body['id'] . '" class="form-control" name="material_unit' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['material_unit'] . '" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="" class="form-label">Description</label>
                                                            <textarea maxlength="150" class="form-control" id="material_description' . $row_table_body['id'] . '" rows="3" name="material_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['material_description'] . '</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Image</label>
                                                            <div class="form-file">
                                                                        <input type="file" class="form-file-input" name="material_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['material_image'] . '">
                                                                        <label class="form-file-label" for="customFile">
                                                                            <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                            <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                            <label for="" class="form-label">Preview</label>

                                                            <div class="card">
                                                                    <div class="card-content">

                                                                        <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/materials/' . $row_table_body['material_image'] . '" alt="" >
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <script>
                                                            document.getElementById(\'file-upload' . $row_table_body['id'] . '\').onchange = function () {
                                                                if (this.files && this.files[0]) {
                                                                    var reader = new FileReader();
                                                                    reader.onload = function(e) {
                                                                    document.getElementById("imagePreview' . $row_table_body['id'] . '").src = e.target.result;
                                                                    }
                                                                    reader.readAsDataURL(this.files[0]);
                                                                };
                                                                var filePath = this.value;
                                                                if (filePath) {
                                                                var fileName = filePath.replace(/^.*?([^\\\/]*)$/, \'$1\');
                                                                document.getElementById(\'file-name' . $row_table_body['id'] . '\').innerHTML = fileName;
                                                                }
                                                            };

                                                    </script>
                                                </div>
                                                </form>

                                                <div class="col-12 d-flex justify-content-end">
                                                    <button class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_material(' . $row_table_body['id'] . ')">Update</button>
                                                    <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>


                                                            var element_edit_partner' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-partner' . $row_table_body['id'] . '");
                                                            var choices_edit_partner' . $row_table_body['id'] . ' = new Choices(element_edit_partner' . $row_table_body['id'] . ');

                                                            var element_edit_status' . $row_table_body['id'] . ' = document.querySelector(".js-choices-edit-status' . $row_table_body['id'] . '");
                                                            var choices_edit_status' . $row_table_body['id'] . ' = new Choices(element_edit_status' . $row_table_body['id'] . ');
                        </script>
        ';
        //--------------- End EDIT MODAL ---------------

        //--------------- End DELETE MODAL ---------------
        $modal_delete .= '
                    <div class="modal fade text-left modal-borderless" id="delete-modal-' . $row_table_body['id'] . '" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this material?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_material(' . $row_table_body['id'] . ')" data-dismiss="modal">
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
                <h3>ALL MATERIALS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All materials</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
            <div class="buttons">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Add a new material</a>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-hover' id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Partner</th>
                            <th>Unit</th>
                            <th>Stock</th>
                            <th>Import Price</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                    <div id="add_new_row"></div>
<?php
echo $table_materials;
?>

                    </tbody>
                </table>
            </div>
        </div>
<?php
echo $modal_edit;
echo $modal_delete;
?>
    <div id="show_new_modal_edit"></div>
    <div id="show_new_modal_delete"></div>
    </section>
<!--------------- End HTML --------------->

<!--------------- Start Modal --------------->
    <div class="modal fade text-left w-100 modal-borderless" id="add-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new material</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-body">
                                    <form id="add-form">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" id="material_name" class="form-control" name="material_name"
                                                placeholder="Name"  required>
                                            </div>



                                            <div class="form-group">
                                            <label for="" class="form-label">Partner</label>
                                                    <select class="js-choices-add-partner form-select" id="partner_id" name="partner_id" required>
                                                        <option value="" selected >CHOOSE...</option>
<?php
while ($row_partner_add = mysqli_fetch_array($query_partner_add)) {
    ?>
                                                        <option value=" <?php echo $row_partner_add["id"]; ?>"> <?php echo $row_partner_add["partner_name"]; ?> </option>
<?php
}
?>
                                                        </select>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Status</label>
                                                        <select class="js-choices-add-status form-select" id="material_status" name="material_status">
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Import price</label>
                                            <input type="text" id="material_import_price" class="form-control" name="material_import_price"
                                                placeholder="Import price" required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Unit</label>
                                            <input type="text" id="material_unit" class="form-control" name="material_unit"
                                                placeholder="Unit" required>
                                            </div>


                                            <div class="form-group">
                                                <label for="" class="form-label">Description</label>
                                                <textarea maxlength="150" class="form-control" id="material_description" rows="3" name="material_description" placeholder="Description"  required></textarea>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="" class="form-label">Image</label>
                                                <div class="form-file">
                                                            <input type="file" class="form-file-input" name="material_image" id="file-upload" value="" required>
                                                            <label class="form-file-label" for="customFile">
                                                                <span class="form-file-text" id="file-name">Choose file...</span>
                                                                <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                            </label>
                                                        </div>
                                                </div>

                                                <label for="" class="form-label">Preview</label>
                                                <div class="card">
                                                        <div class="card-content">
                                                            <img class="card-img img-fluid" id="imagePreview" src="images/templates/upload_image.jpg" alt="" >
                                                        </div>
                                                </div>
                                            </div>
                                        </div>


                                        </div>
                                        </form>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button class="btn btn-primary mr-1 mb-1" id="submit" onclick="create()">Add</button>
                                            <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>

<!--------------- End Modal --------------->
<script>

<?php
function show_add_modal()
{
    if (isset($_GET["name_modal"])) {
        if ($_GET["name_modal"] == "add_material") {
            echo "
                    $(document).ready(function(){
                        $('#add-modal').modal('show');
                    });
                ";
        }
    }
}
show_add_modal();
?>


        const element2 = document.querySelector('.js-choices-add-partner');
        const choices2 = new Choices(element2);

        const element3 = document.querySelector('.js-choices-add-status');
        const choices3 = new Choices(element3);

        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);

    function delete_material(id){
            var action = "delete";
            var material_id = id;
            $.ajax({
                url: "action-for-material.php",
                type: "POST",
                data: {
                    action: action,
                    material_id: material_id
                },
                success: function(){
                    Toastify({
                        text: "Material has been deleted!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                    //alert("Material has been deleted!");
                    let select = document.getElementById("td-"+id).parentNode;
                    let delete_row = select.parentNode;
                    dataTable.rows().remove(delete_row.dataIndex);
                }
            });
    }

    function update_material(id){

            var material_id = id;
            var material_name = $('#material_name'+id).val();
            var partner_id = $('#partner_id'+id).val();
            var material_unit = $('#material_unit'+id).val();
            var material_import_price = $('#material_import_price'+id).val();
            var material_description = $('#material_description'+id).val();
            var material_status = $('#material_status'+id).val();

            var file_data = $('#file-upload'+id).prop('files')[0];
            var action = "update";


            if( !material_name
                || !partner_id
                || !material_unit
                || !material_import_price
                || !material_description
                || !material_status) {
                    Toastify({
                        text: "Please enter all fields! Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Please enter all fields! Try again!");
            } else {

                var form_data = new FormData();

                form_data.append("material_id", material_id);
                form_data.append("material_image", file_data);
                form_data.append("material_name", material_name);
                form_data.append("partner_id", partner_id);
                form_data.append("material_unit", material_unit);
                form_data.append("material_import_price", material_import_price);
                form_data.append("material_description", material_description);
                form_data.append("material_status", material_status);
                form_data.append("action", action);


                $.ajax({
                    url: "action-for-material.php",
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data){
                        Toastify({
                        text: "Material has been updated!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                        //alert("Material has been updated!");
                        var data_array = jQuery.parseJSON(data);
                        let newRow = [
                                data_array.material_id,
                                data_array.material_image,
                                data_array.material_name,
                                data_array.partner_name,
                                data_array.material_unit,
                                data_array.material_stock,
                                data_array.material_import_price,
                                data_array.material_status,
                                data_array.edit,
                        ];
                        let select = document.getElementById("td-"+id).parentNode;
                        let delete_row = select.parentNode;
                        dataTable.rows().remove(delete_row.dataIndex);
                        dataTable.rows().add(newRow);
                        dataTable.sortColumn(0, "desc");
                        $('#edit-form'+id)[0].reset();
                        if ( data_array.form_material != ""){
                            $('#edit-form'+id).html(data_array.form_material);
                        }
                        $('#edit-modal-'+id).modal('toggle');
                        $('.modal-backdrop').remove();
                    }
                });
            }

    };

    function create(){

            var material_name = $('#material_name').val();
            var partner_id = $('#partner_id').val();
            var material_unit = $('#material_unit').val();
            var material_import_price = $('#material_import_price').val();
            var material_description = $('#material_description').val();
            var material_status = $('#material_status').val();
            var file_data = $('#file-upload').prop('files')[0];
            var action = "add";

            if( !material_name
                || !partner_id
                || !material_unit
                || !material_import_price
                || !material_description
                || !material_status
                || !file_data) {
                    Toastify({
                        text: "Please enter all fields! Try again!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#F55260",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Please enter all fields! Try again!");
            } else {
                var form_data = new FormData();

                form_data.append("material_image", file_data);
                form_data.append("material_name", material_name);
                form_data.append("partner_id", partner_id);
                form_data.append("material_unit", material_unit);
                form_data.append("material_import_price", material_import_price);
                form_data.append("material_description", material_description);
                form_data.append("material_status", material_status);
                form_data.append("action", action);

                $.ajax({
                    url: "action-for-material.php",
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data){
                        Toastify({
                        text: "A new material created!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                        //alert("A new material created!");
                        var data_array = jQuery.parseJSON(data);
                        let newRow = [
                                data_array.material_id,
                                data_array.material_image,
                                data_array.material_name,
                                data_array.partner_name,
                                data_array.material_unit,
                                data_array.material_stock,
                                data_array.material_import_price,
                                data_array.material_status,
                                data_array.edit,
                        ];
                        dataTable.rows().add(newRow);
                        dataTable.sortColumn(0, "desc");
                        $('#show_new_modal_edit').append(data_array.modal_edit);
                        $('#show_new_modal_delete').append(data_array.modal_delete);
                        $('#add-form')[0].reset();
                        resetFileInput();
                        $('#add-modal').modal('toggle');
                        $('.modal-backdrop').remove();
                    }
                });
            }



    };

    document.getElementById('file-upload').onchange = function () {
        readURL(this);
        var filePath = this.value;
        if (filePath) {
            var fileName = filePath.replace(/^.*?([^\\\/]*)$/, '$1');
            document.getElementById('file-name').innerHTML = fileName;
        }
    };

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            document.getElementById("imagePreview").src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetFileInput(){
        document.getElementById("file-name").innerHTML = "Choose file...";
        document.getElementById("imagePreview").src = "images/templates/upload_image.jpg";
    }

</script>
