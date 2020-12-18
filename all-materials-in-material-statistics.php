<?php
include_once './connect.php';

$table_materials = '';

$sql_table_body_material = "SELECT * FROM tbl_material ORDER BY id DESC";
$query_table_body_material = mysqli_query($connect, $sql_table_body_material);

$sql_partner_add = "SELECT * FROM tbl_partner ORDER BY id ASC";
$query_partner_add = mysqli_query($connect, $sql_partner_add);

if (mysqli_num_rows($query_table_body_material) > 0) {
    while ($row_table_body_material = mysqli_fetch_array($query_table_body_material)) {

        $id_partner_table_body = $row_table_body_material["partner_id"];
        $sql_partner_table_body = "SELECT * FROM tbl_partner WHERE id='$id_partner_table_body'";
        $query_partner_table_body = mysqli_query($connect, $sql_partner_table_body);
        $row_partner_table_body = mysqli_fetch_array($query_partner_table_body);

        //--------------- Start TABLE BODY ---------------
        $table_materials .= '
                <tr>
                    <td><a id="td-' . $row_table_body_material["id"] . '">' . $row_table_body_material["id"] . '</a></td>
                    <td>
                        <div class="avatar avatar-xl mr-3">
                            <img src="images/materials/' . $row_table_body_material["material_image"] . '" alt="" srcset="">
                        </div>
                    </td>
                    <td>' . $row_table_body_material["material_name"] . '</td>
                    <td>' . $row_partner_table_body["partner_name"] . '</td>
                    <td>' . $row_table_body_material["material_unit"] . '</td>
                    <td>' . $row_table_body_material["material_stock"] . '</td>
        ';

        if ($row_table_body_material["material_status"]) {
            $table_materials .= '<td><span class="badge bg-success">Active</span></td>';
        } else {
            $table_materials .= '<td><span class="badge bg-danger">Inactive</span></td>';
        }

        $table_materials .= '
                    <td>' . $row_table_body_material["updated_at"] . '</td>
                </tr>
        ';
        //--------------- End TABLE BODY ---------------
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
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal-material">Add a new material</a>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-hover' id="table2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Partner</th>
                            <th>Unit</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Last Update</th>
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
    </section>
<!--------------- End HTML --------------->

<!--------------- Start Modal --------------->
    <div class="modal fade text-left w-100 modal-borderless" id="add-modal-material" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new material</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-body">
                                    <form id="add-form-material">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" id="material_nameX" class="form-control" name="material_nameX"
                                                placeholder="Name"  required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Partner</label>
                                                    <select class="js-choices-add-partner form-select" id="partner_idX" name="partner_idX" required>
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
                                                        <select class="js-choices-add-status form-select" id="material_statusX" name="material_statusX">
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Import price</label>
                                            <input type="text" id="material_import_priceX" class="form-control" name="material_import_priceX"
                                                placeholder="Import price" required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Unit</label>
                                            <input type="text" id="material_unitX" class="form-control" name="material_unitX"
                                                placeholder="Unit" required>
                                            </div>


                                            <div class="form-group">
                                                <label for="" class="form-label">Description</label>
                                                <textarea maxlength="150" class="form-control" id="material_descriptionX" rows="3" name="material_descriptionX" placeholder="Description"  required></textarea>
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
                                            <button class="btn btn-primary mr-1 mb-1" id="submit" onclick="create_material('X')">Add</button>
                                            <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>

<!--------------- End Modal --------------->
<script>

        let element_add_2 = document.querySelector('.js-choices-add-partner');
        let choices_add_2 = new Choices(element_add_2);

        let element_add_3 = document.querySelector('.js-choices-add-status');
        let choices_add_3 = new Choices(element_add_3);

        let table2 = document.querySelector('#table2');
        let dataTable2 = new simpleDatatables.DataTable(table2);



    function create_material(val){

            var material_name = $('#material_name'+val).val();
            var partner_id = $('#partner_id'+val).val();
            var material_unit = $('#material_unit'+val).val();
            var material_import_price = $('#material_import_price'+val).val();
            var material_description = $('#material_description'+val).val();
            var material_status = $('#material_status'+val).val();
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
                                data_array.material_status,
                                data_array.updated_at,
                        ];
                        dataTable2.rows().add(newRow);
                        dataTable2.sortColumn(0, "desc");
                        $('#add-form-material')[0].reset();
                        resetFileInput();
                        $('#add-modal-material').modal('toggle');
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
