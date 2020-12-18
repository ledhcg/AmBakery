<?php

$table_customers = '';
$modal_edit = '';
$modal_delete = '';
$sql_table_body = "SELECT * FROM tbl_customer ORDER BY id DESC";
$query_table_body = mysqli_query($connect, $sql_table_body);

if (mysqli_num_rows($query_table_body) > 0) {
    while ($row_table_body = mysqli_fetch_array($query_table_body)) {

        //--------------- Start TABLE BODY ---------------
        $table_customers .= '
                <tr>
                    <td><a id="td-' . $row_table_body["id"] . '">' . $row_table_body["id"] . '</a></td>
                    <td>' . $row_table_body["customer_name"] . '</td>
                    <td>' . $row_table_body["customer_email"] . '</td>
                    <td>' . $row_table_body["customer_phone"] . '</td>
                    <td>' . $row_table_body["customer_address"] . '</td>
                    <td>' . $row_table_body["customer_dob"] . '</td>
                    <td>' . $row_table_body["customer_gender"] . '</td>
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
                                        <h4 class="modal-title white" id="myModalLabel16">Edit customer</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-body">
                                                <form id="edit-form' . $row_table_body['id'] . '">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Name</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['customer_name'] . '" id="customer_name' . $row_table_body['id'] . '" name="customer_name' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                    <i class="fas fa-user"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">

                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Email</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['customer_email'] . '" id="customer_email' . $row_table_body['id'] . '" name="customer_email' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                    <i class="fas fa-envelope"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Phone</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['customer_phone'] . '" id="customer_phone' . $row_table_body['id'] . '" name="customer_phone' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                    <i class="fas fa-phone-alt"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Address</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['customer_address'] . '" id="customer_address' . $row_table_body['id'] . '" name="customer_address' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Date of birth</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" value="' . $row_table_body['customer_dob'] . '" id="customer_dob' . $row_table_body['id'] . '" name="customer_dob' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                    <i class="fas fa-child"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Gender</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['customer_gender'] . '" id="customer_gender' . $row_table_body['id'] . '" name="customer_gender' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                    <i class="fas fa-venus-mars"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    
                                                </div>
                                                </form>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_customer(' . $row_table_body['id'] . ')">Update</button>
                                                    <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                                </div>
                                                </div>
                                            
                                         </div>
                                    </div>
                                </div>
                            </div>
                        ';
        //--------------- End EDIT MODAL ---------------

        //--------------- End DELETE MODAL ---------------
        $modal_delete .= '
                     <div class="modal fade text-left modal-borderless" id="delete-modal-' . $row_table_body['id'] . '" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel120" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this customer?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_customer(' . $row_table_body['id'] . ')" data-dismiss="modal">
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
                <h3>ALL CUSTOMERS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All customers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
            <div class="buttons">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Add a new customer</a>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-hover' id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                    <div id="add_new_row"></div>
<?php
echo $table_customers;
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

<!--------------- Start Add Modal --------------->
    <div class="modal fade text-left w-100 modal-borderless" id="add-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new customer</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-body">
                                    <form id="add-form">
                                        <div class="row">
                                        
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Name" id="customer_name" name="customer_name" required>
                                                        <div class="form-control-icon">
                                                        <i class="fas fa-user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">

                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Email</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Email" id="customer_email" name="customer_email" required>
                                                        <div class="form-control-icon">
                                                        <i class="fas fa-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Phone</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Phone" id="customer_phone" name="customer_phone" required>
                                                        <div class="form-control-icon">
                                                        <i class="fas fa-phone-alt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Address</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Address" id="customer_address" name="customer_address" required>
                                                        <div class="form-control-icon">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Date of birth</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" placeholder="Date of birth" id="customer_dob" name="customer_dob" required>
                                                        <div class="form-control-icon">
                                                        <i class="fas fa-child"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Gender</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Gender" id="customer_gender" name="customer_gender" required>
                                                        <div class="form-control-icon">
                                                        <i class="fas fa-venus-mars"></i>
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

<!--------------- Start End Modal --------------->

<script>

<?php
    function show_add_modal (){
        if (isset($_GET["name_modal"])) {
            if ($_GET["name_modal"] == "add_customer") {
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


    function delete_customer(id){
        var action = "delete";
        var customer_id = id;
        $.ajax({
                url: "action-for-customer.php",
                type: "POST",
                data: {
                    action: action,
                    customer_id: customer_id
                },
                success: function(data){
                    Toastify({
                        text: "Customer has been deleted!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center", 
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true, 
                        }).showToast();
                //alert("Customer has been deleted!");;
                    let select = document.getElementById("td-"+id).parentNode;
                    let delete_row = select.parentNode;
                    dataTable.rows().remove(delete_row.dataIndex);
                }
        });
    };


    function update_customer(id){

            var customer_id = id;
            var customer_name = $('#customer_name'+id).val();
            var customer_email = $('#customer_email'+id).val();
            var customer_phone = $('#customer_phone'+id).val();
            var customer_address = $('#customer_address'+id).val();
            var customer_dob = $('#customer_dob'+id).val();
            var customer_gender = $('#customer_gender'+id).val();

            var action = "update";

            if( !customer_name
                || !customer_email
                || !customer_phone
                || !customer_address
                || !customer_dob
                || !customer_gender) {
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
                
                form_data.append("customer_id", customer_id);
                form_data.append("customer_name", customer_name);
                form_data.append("customer_email", customer_email);
                form_data.append("customer_phone", customer_phone);
                form_data.append("customer_address", customer_address);
                form_data.append("customer_dob", customer_dob);
                form_data.append("customer_gender", customer_gender);
                form_data.append("action", action);

                $.ajax({
                    url: "action-for-customer.php",
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data){
                        Toastify({
                        text: "Customer has been updated!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center", 
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true, 
                        }).showToast();
                //alert("Customer has been updated!");;
                        var data_array = jQuery.parseJSON(data);
                        let newRow = [
                                data_array.customer_id,
                                data_array.customer_name,
                                data_array.customer_email,
                                data_array.customer_phone,
                                data_array.customer_address,
                                data_array.customer_dob,
                                data_array.customer_gender,
                                data_array.edit,
                        ];
                        let select = document.getElementById("td-"+id).parentNode;
                        let delete_row = select.parentNode; 
                        dataTable.rows().remove(delete_row.dataIndex);
                        dataTable.rows().add(newRow);
                        dataTable.sortColumn(0, "desc");
                        $('#edit-form'+id)[0].reset();
                        if ( data_array.form_customer != ""){
                            $('#edit-form'+id).html(data_array.form_customer);
                        }
                        $('#edit-modal-'+id).modal('toggle');
                        $('.modal-backdrop').remove();
                    }
                });
            }
    };

    function create(){

            var customer_name = $('#customer_name').val();
            var customer_email = $('#customer_email').val();
            var customer_phone = $('#customer_phone').val();
            var customer_address = $('#customer_address').val();
            var customer_dob = $('#customer_dob').val();
            var customer_gender = $('#customer_gender').val();
            var action = "add";

            if( !customer_name
                || !customer_email
                || !customer_phone
                || !customer_address
                || !customer_dob
                || !customer_gender) {
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

                form_data.append("customer_name", customer_name);
                form_data.append("customer_email", customer_email);
                form_data.append("customer_phone", customer_phone);
                form_data.append("customer_address", customer_address);
                form_data.append("customer_dob", customer_dob);
                form_data.append("customer_gender", customer_gender);
                form_data.append("action", action);

                $.ajax({
                    url: "action-for-customer.php",
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data){
                        Toastify({
                        text: "A new customer created!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center", 
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true, 
                        }).showToast();
                //alert("A new customer created!");;
                        var data_array = jQuery.parseJSON(data);
                        let newRow = [
                                data_array.customer_id,
                                data_array.customer_name,
                                data_array.customer_email,
                                data_array.customer_phone,
                                data_array.customer_address,
                                data_array.customer_dob,
                                data_array.customer_gender,
                                data_array.edit,
                        ];
                        dataTable.rows().add(newRow);
                        dataTable.sortColumn(0, "desc");
                        $('#show_new_modal_edit').append(data_array.modal_edit);
                        $('#show_new_modal_delete').append(data_array.modal_delete);
                        $('#add-form')[0].reset();
                        $('#add-modal').modal('toggle');
                        $('.modal-backdrop').remove();
                    }
                });
            }
    };

</script>
