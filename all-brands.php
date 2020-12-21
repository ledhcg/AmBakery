<?php

$table_brands = '';
$modal_edit = '';
$modal_delete = '';

$sql_table_body = "SELECT * FROM tbl_brand ORDER BY id DESC";
$query_table_body = mysqli_query($connect, $sql_table_body);

if (mysqli_num_rows($query_table_body) > 0) {
    while ($row_table_body = mysqli_fetch_array($query_table_body)) {

        //--------------- Start TABLE BODY ---------------
        $table_brands .= '
                <tr>
                    <td><a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '<a></td>
                    <td>
                        <div class="avatar avatar-xl mr-3">
                            <img src="images/brands/' . $row_table_body["brand_image"] . '" alt="" srcset="">
                        </div>
                    </td>
                    <td>' . $row_table_body["brand_name"] . '</td>
                    <td>' . $row_table_body["brand_description"] . '</td>
        ';

        if ($row_table_body["brand_status"]) {
            $table_brands .= '<td><span class="badge bg-success">Active</span></td>';
        } else {
            $table_brands .= '<td><span class="badge bg-danger">Inactive</span></td>';
        }

        $table_brands .= '
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
                                    <h4 class="modal-title white" id="myModalLabel16">Edit brand</h4>
                                    </div>
                                    <div class="modal-body">
                                            <div class="form-body">
                                                <form id="edit-form' . $row_table_body['id'] . '">
                                                <div class="row">
                                                    <div class="col-md-8 col-12">
                                                        <div class="form-group">
                                                        <label for="" class="form-label">Name</label>
                                                        <input type="text" id="brand_name' . $row_table_body['id'] . '" class="form-control" name="brand_name' . $row_table_body['id'] . '"
                                                        value="' . $row_table_body['brand_name'] . '"  required>
                                                        </div>

                                                        <div class="form-group">
                                                        <label for="" class="form-label">Status</label>
                                                            <select class="js-choices-edit' . $row_table_body["id"] . ' form-select" id="brand_status' . $row_table_body['id'] . '" name="brand_status' . $row_table_body['id'] . '">
        ';

        if ($row_table_body['brand_status']) {
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
                                                            <label for="" class="form-label">Description</label>
                                                            <textarea maxlength="150" class="form-control" id="brand_description' . $row_table_body['id'] . '" rows="3" name="brand_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['brand_description'] . '</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 col-12">
                                                        <div class="form-group">
                                                            <label for="" class="form-label">Image</label>
                                                            <div class="form-file">
                                                                        <input type="file" class="form-file-input" name="brand_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['brand_image'] . '">
                                                                        <label class="form-file-label" for="customFile">
                                                                            <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                                                                            <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                                                                        </label>
                                                                    </div>
                                                            </div>
                                                            <label for="" class="form-label">Preview</label>

                                                            <div class="card">
                                                                    <div class="card-content">

                                                                        <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/brands/' . $row_table_body['brand_image'] . '" alt="" >
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
                                                        <button class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_brand(' . $row_table_body['id'] . ')">Update</button>
                                                        <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            var element_edit' . $row_table_body["id"] . ' = document.querySelector(".js-choices-edit' . $row_table_body["id"] . '");
                            var choices_edit' . $row_table_body["id"] . ' = new Choices(element_edit' . $row_table_body["id"] . ');
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
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this brand?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_brand(' . $row_table_body['id'] . ')" data-dismiss="modal">
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
                <h3>ALL BRANDS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All brands</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
            <div class="buttons">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Add a new brand</a>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-hover' id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                    <div id="add_new_row"></div>
<?php
echo $table_brands;
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
                            <h4 class="modal-title white" id="myModalLabel16">Add a new brand</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-body">
                                    <form id="add-form">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" id="brand_name" class="form-control" name="brand_name"
                                                placeholder="Name"  required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Status</label>
                                                        <select class="js-choices-add form-select" id="brand_status" name="brand_status">
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="form-label">Description</label>
                                                <textarea maxlength="150" class="form-control" id="brand_description" rows="3" name="brand_description" placeholder="Description"  required></textarea>
                                            </div>
                                        </div>


                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="" class="form-label">Image</label>
                                                <div class="form-file">
                                                            <input type="file" class="form-file-input" name="brand_image" id="file-upload" value="" required>
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
        if ($_GET["name_modal"] == "add_brand") {
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

    let table1 = document.querySelector('#table1');
    let dataTable = new simpleDatatables.DataTable(table1);

    const element_add = document.querySelector(".js-choices-add");
    const choices_add = new Choices(element_add);


    function delete_brand(id){
        var action = "delete";
        var brand_id = id;
        $.ajax({
                url: "action-for-brand.php",
                type: "POST",
                data: {
                    action: action,
                    brand_id: brand_id
                },
                success: function(data){
                    Toastify({
                        text: "Brand has been deleted!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Brand has been deleted!");;
                    let select = document.getElementById("td-"+id).parentNode;
                    let delete_row = select.parentNode;
                    dataTable.rows().remove(delete_row.dataIndex);
                }
        });
    }
    function update_brand(id){

            var brand_id = id;
            var brand_name = $('#brand_name'+id).val();
            var brand_status = $('#brand_status'+id).val();
            var brand_description = $('#brand_description'+id).val();
            var action = "update";

            var file_data = $('#file-upload'+id).prop('files')[0];
            if( !brand_name
                || !brand_status
                || !brand_description) {
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

            form_data.append("brand_id", brand_id);
            form_data.append("brand_name", brand_name);
            form_data.append("brand_status", brand_status);
            form_data.append("brand_description", brand_description);
            form_data.append("brand_image", file_data);
            form_data.append("action", action);

            $.ajax({
                url: "action-for-brand.php",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data){
                        Toastify({
                        text: "Brand has been updated!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("Brand has been updated!");;
                        var data_array = jQuery.parseJSON(data);
                        let newRow = [
                                data_array.brand_id,
                                data_array.brand_image,
                                data_array.brand_name,
                                data_array.brand_description,
                                data_array.brand_status,
                                data_array.edit,
                        ];
                        let select = document.getElementById("td-"+id).parentNode;
                        let delete_row = select.parentNode;
                        dataTable.rows().remove(delete_row.dataIndex);
                        dataTable.rows().add(newRow);
                        dataTable.sortColumn(0, "desc");
                        $('#edit-form'+id)[0].reset();
                        if ( data_array.form_brand != ""){
                            $('#edit-form'+id).html(data_array.form_brand);
                        }
                        $('#edit-modal-'+id).modal('toggle');
                        $('.modal-backdrop').remove();
                }
            });
        }
    };

    function create(){
            var brand_name = $('#brand_name').val();
            var brand_status = $('#brand_status').val();
            var brand_description = $('#brand_description').val();
            var action = "add";

            var file_data = $('#file-upload').prop('files')[0];
            if( !brand_name
                || !brand_status
                || !brand_description
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
                //alert("Please enter all fields! Try again!");;
            } else {

            var form_data = new FormData();

            form_data.append("brand_name", brand_name);
            form_data.append("brand_status", brand_status);
            form_data.append("brand_description", brand_description);
            form_data.append("brand_image", file_data);
            form_data.append("action", action);

            $.ajax({
                url: "action-for-brand.php",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data){
                        Toastify({
                        text: "A new brand created!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                //alert("A new brand created!");;
                        var data_array = jQuery.parseJSON(data);
                        let newRow = [
                                data_array.brand_id,
                                data_array.brand_image,
                                data_array.brand_name,
                                data_array.brand_description,
                                data_array.brand_status,
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
