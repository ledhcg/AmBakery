<?php

$table_dealers = '';
$modal_edit = '';
$modal_delete = '';
$sql_table_body = "SELECT * FROM tbl_dealer ORDER BY id DESC";
$query_table_body = mysqli_query($connect, $sql_table_body);

if (mysqli_num_rows($query_table_body) > 0) {
    while ($row_table_body = mysqli_fetch_array($query_table_body)) {

        //--------------- Start TABLE BODY ---------------
        $table_dealers .= '
                <tr id="tr-' . $row_table_body["id"] . '">
                    <td>' . $row_table_body["id"] . '</td>
                    <td>' . $row_table_body["dealer_name"] . '</td>
                    <td>' . $row_table_body["dealer_email"] . '</td>
                    <td>' . $row_table_body["dealer_phone"] . '</td>
                    <td>' . $row_table_body["dealer_address"] . '</td>
                    <td>' . $row_table_body["dealer_dob"] . '</td>
                    <td>' . $row_table_body["dealer_gender"] . '</td>
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
                                        <h4 class="modal-title white" id="myModalLabel16">Edit dealer</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form role="form" method="post" enctype="multipart/form-data" id="edit-form' . $row_table_body['id'] . '">
                                            <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Name</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['dealer_name'] . '" id="dealer_name' . $row_table_body['id'] . '" name="dealer_name' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                        <i data-feather="user"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">

                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Email</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['dealer_email'] . '" id="dealer_email' . $row_table_body['id'] . '" name="dealer_email' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                        <i data-feather="mail"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Phone</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['dealer_phone'] . '" id="dealer_phone' . $row_table_body['id'] . '" name="dealer_phone' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                        <i data-feather="phone"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Address</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['dealer_address'] . '" id="dealer_address' . $row_table_body['id'] . '" name="dealer_address' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                        <i data-feather="map-pin"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Date of birth</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" value="' . $row_table_body['dealer_dob'] . '" id="dealer_dob' . $row_table_body['id'] . '" name="dealer_dob' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                        <i data-feather="smile"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group has-icon-left">
                                                                <label for="" class="form-label">Gender</label>
                                                                <div class="position-relative">
                                                                    <input type="text" class="form-control" value="' . $row_table_body['dealer_gender'] . '" id="dealer_gender' . $row_table_body['id'] . '" name="dealer_gender' . $row_table_body['id'] . '" required>
                                                                    <div class="form-control-icon">
                                                                        <i data-feather="users"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update_dealer(' . $row_table_body['id'] . ')">Update</button>
                                                        <button type="reset" class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                                    </div>
                                                </div>
                                                </div>
                                            </form>
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
                                    <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this dealer?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Cancel</span>
                                    </button>
                                    <button type="button" class="btn btn-danger ml-1" onclick="delete_dealer(' . $row_table_body['id'] . ')" data-dismiss="modal">
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
                <h3>ALL DEALERS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All dealers</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
            <div class="buttons">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Add a new dealer</a>
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
echo $table_dealers;
?>

                    </tbody>
                </table>
            </div>
        </div>
<?php
echo $modal_edit;
echo $modal_delete;
?>
    </section>
<!--------------- End HTML --------------->

<!--------------- Start Add Modal --------------->
    <div class="modal fade text-left w-100 modal-borderless" id="add-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new dealer</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" method="post" enctype="multipart/form-data" id="add-form">
                                <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Name" id="dealer_name" name="dealer_name" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="user"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">

                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Email</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Email" id="dealer_email" name="dealer_email" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="mail"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Phone</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Phone" id="dealer_phone" name="dealer_phone" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="phone"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Address</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Address" id="dealer_address" name="dealer_address" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="map-pin"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Date of birth</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control datepicker-here" data-position="top left" data-timepicker="false" placeholder="Date of birth" id="dealer_dob" name="dealer_dob" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="smile"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="" class="form-label">Gender</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Gender" id="dealer_gender" name="dealer_gender" required>
                                                        <div class="form-control-icon">
                                                            <i data-feather="users"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-1 mb-1" id="submit" onclick="create()">Add</button>
                                            <button type="reset" class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                        </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<!--------------- Start End Modal --------------->

<script>

<?php
if (isset($_GET["name_modal"])) {
    if ($_GET["name_modal"] == "add_dealer") {
        echo "
                $(document).ready(function(){
                    $('#add-modal').modal('show');
                });
            ";
    }
}
?>
    function delete_dealer(id){
        $.ajax({
                url: "delete-dealer-ajax.php",
                type: "POST",
                data: {id:id},
                success: function(data){
                    $('#tr-'+id).remove();
                }
        });
    };

    function update_dealer(id){
            var dealer_id = id;
            var dealer_name = $('#dealer_name'+id).val();
            var dealer_email = $('#dealer_email'+id).val();
            var dealer_phone = $('#dealer_phone'+id).val();
            var dealer_address = $('#dealer_address'+id).val();
            var dealer_dob = $('#dealer_dob'+id).val();
            var dealer_gender = $('#dealer_gender'+id).val();

            var form_data = new FormData();

            form_data.append("dealer_id", dealer_id);
            form_data.append("dealer_name", dealer_name);
            form_data.append("dealer_email", dealer_email);
            form_data.append("dealer_phone", dealer_phone);
            form_data.append("dealer_address", dealer_address);
            form_data.append("dealer_dob", dealer_dob);
            form_data.append("dealer_gender", dealer_gender);

            $.ajax({
                url: "update-dealer-ajax.php",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data){
                    $('#tr-'+id).html(data);
                }
            });
    };

    function create(){
            var dealer_name = $('#dealer_name').val();
            var dealer_email = $('#dealer_email').val();
            var dealer_phone = $('#dealer_phone').val();
            var dealer_address = $('#dealer_address').val();
            var dealer_dob = $('#dealer_dob').val();
            var dealer_gender = $('#dealer_gender').val();

            var form_data = new FormData();

            form_data.append("dealer_name", dealer_name);
            form_data.append("dealer_email", dealer_email);
            form_data.append("dealer_phone", dealer_phone);
            form_data.append("dealer_address", dealer_address);
            form_data.append("dealer_dob", dealer_dob);
            form_data.append("dealer_gender", dealer_gender);

            $.ajax({
                url: "add-new-dealer-ajax.php",
                type: "POST",
                dataType: 'script',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data){
                    $('#add_new_row').html(data);
                }
            });
    };

</script>
