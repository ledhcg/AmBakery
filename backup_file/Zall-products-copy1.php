<?php
$sql = "SELECT * FROM tbl_product ORDER BY id ASC";
$query = mysqli_query($connect, $sql);

$table_products = '';
$modal_edit = '';
$modal_delete = '';
$sql_table_body = "SELECT * FROM tbl_product ORDER BY id DESC";
$query_table_body = mysqli_query($connect, $sql_table_body);

$table_products .= '

        <table class=\'table table-hover\' id="table1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Category</th>

                            <th>Size</th>
                            <th>Unit Price</th>
                            <th>Sale Price</th>
                            <th>Status</th>
                            <th style="width:10%">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                    <div id="add_new_row"></div>
';
if (mysqli_num_rows($query_table_body) > 0) {
    while ($row_table_body = mysqli_fetch_array($query_table_body)) {

        $id_brand_table_body = $row_table_body["brand_id"];
        $sql_brand_table_body = "SELECT * FROM tbl_brand WHERE id='$id_brand_table_body'";
        $query_brand_table_body = mysqli_query($connect, $sql_brand_table_body);
        $row_brand_table_body = mysqli_fetch_array($query_brand_table_body);

        $id_category_table_body = $row_table_body["category_id"];
        $sql_category_table_body = "SELECT * FROM tbl_product_category WHERE id='$id_category_table_body'";
        $query_category_table_body = mysqli_query($connect, $sql_category_table_body);
        $row_category_table_body = mysqli_fetch_array($query_category_table_body);

        $table_products .= '
        <tr id="tr-' . $row_table_body["id"] . '">
            <td>' . $row_table_body["id"] . '</td>
            <td>
                <div class="avatar avatar-xl mr-3">
                    <img src="images/products/' . $row_table_body["product_image"] . '" alt="" srcset="">
                </div>
            </td>
            <td>' . $row_table_body["product_name"] . '</td>
            <td>' . $row_brand_table_body["brand_name"] . '</td>
            <td>' . $row_category_table_body["category_name"] . '</td>
            <td>' . $row_table_body["product_size"] . '</td>
            <td>' . $row_table_body["product_unit_price"] . '</td>
            <td>' . $row_table_body["product_sale_price"] . '</td>

        ';
        if ($row_table_body["product_status"]) {
            $table_products .= '<td><span class="badge bg-success">Active</span></td>';
        } else {
            $table_products .= '<td><span class="badge bg-danger">Inactive</span></td>';
        }
        $table_products .= '
                    <td>
                        <div class="buttons">
                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-primary" data-toggle="modal" data-target="#edit-modal-' . $row_table_body['id'] . '"><i class="far fa-edit"></i></a>
                            <a style="margin: 2px 2.5px 2px 2.5px" href="#" class="btn icon btn-danger" data-toggle="modal" data-target="#delete-modal-' . $row_table_body['id'] . '"><i class="far fa-trash-alt"></i></a>
                        </div>
                    </td>
                </tr>

        ';

        //Edit modal

        $modal_edit .= '
            <div class="modal fade text-left w-100 modal-borderless" id="edit-modal-' . $row_table_body["id"] . '" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel16" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                        <h4 class="modal-title white" id="myModalLabel16">Edit product</h4>

                                        </div>
                                        <div class="modal-body">
        ';

        $sql_brand_edit = "SELECT * FROM tbl_brand ORDER BY id ASC";
        $query_brand_edit = mysqli_query($connect, $sql_brand_edit);

        $sql_category_edit = "SELECT * FROM tbl_product_category ORDER BY id ASC";
        $query_category_edit = mysqli_query($connect, $sql_category_edit);

        $modal_edit .= '

            <form role="form" method="post" enctype="multipart/form-data" id="edit-form' . $row_table_body['id'] . '">
            <div class="form-body">
                    <div class="row">
                    <div class="col-md-8 col-12">
                        <div class="form-group">
                        <label for="" class="form-label">Name</label>
                        <input type="text" id="product_name' . $row_table_body['id'] . '" class="form-control" name="product_name' . $row_table_body['id'] . '"
                        value="' . $row_table_body['product_name'] . '"  required>
                        </div>

                        <div class="form-group">
                        <label for="" class="form-label">Category</label>
                                    <select class="choices form-select"  id="category_id' . $row_table_body['id'] . '" name="category_id' . $row_table_body['id'] . '" required>
                                    <option value="" selected>CHOOSE...</option>
        ';

        while ($row_category_edit = mysqli_fetch_array($query_category_edit)) {
            $modal_edit .= '
                    <option value="' . $row_category_edit["id"] . '"
            ';
            if ($row_category_edit["id"] == $row_table_body['category_id']) {
                $modal_edit .= '
                    selected>' . $row_category_edit["category_name"] . '</option>
                ';
            } else {
                $modal_edit .= '
                    >' . $row_category_edit["category_name"] . '</option>
                ';
            }
        }

        $modal_edit .= '
                                    </select>
                        </div>

            <div class="form-group">
            <label for="" class="form-label">Brand</label>
                        <select class="choices form-select" id="brand_id' . $row_table_body['id'] . '" name="brand_id' . $row_table_body['id'] . '" required>
                        <option value="" selected >CHOOSE...</option>
        ';

        while ($row_brand_edit = mysqli_fetch_array($query_brand_edit)) {
            $modal_edit .= '
                    <option value="' . $row_brand_edit["id"] . '"
            ';
            if ($row_brand_edit["id"] == $row_table_body['brand_id']) {
                $modal_edit .= '
                    selected>' . $row_brand_edit["brand_name"] . '</option>
                ';
            } else {
                $modal_edit .= '
                    >' . $row_brand_edit["brand_name"] . '</option>
                ';
            }
        }

        $modal_edit .= '
                                    </select>
                        </div>

            <div class="form-group">
             <label for="" class="form-label">Status</label>
                        <select class="choices form-select" id="product_status' . $row_table_body['id'] . '" name="product_status' . $row_table_body['id'] . '">
        ';
        if ($row_table_body['product_status']) {
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
            <label for="" class="form-label">Price</label>
            <input type="text" id="product_unit_price' . $row_table_body['id'] . '" class="form-control" name="product_unit_price' . $row_table_body['id'] . '"
            value="' . $row_table_body['product_unit_price'] . '" required>
            </div>

            <div class="form-group">
            <label for="" class="form-label">Sale price</label>
            <input type="text" id="product_sale_price' . $row_table_body['id'] . '" class="form-control" name="product_sale_price' . $row_table_body['id'] . '"
            value="' . $row_table_body['product_sale_price'] . '" required>
            </div>

            <div class="form-group">
            <label for="" class="form-label">Size</label>
            <input type="text" id="product_size' . $row_table_body['id'] . '" class="form-control" name="product_size' . $row_table_body['id'] . '"
            value="' . $row_table_body['product_size'] . '" required>
            </div>


            <div class="form-group">
                <label for="" class="form-label">Description</label>
                <textarea maxlength="150" class="form-control" id="product_description' . $row_table_body['id'] . '" rows="3" name="product_description' . $row_table_body['id'] . '" placeholder="Description"  required>' . $row_table_body['product_description'] . '</textarea>
            </div>
        </div>

        <input type="hidden" id="product_id' . $row_table_body['id'] . '" name="product_id' . $row_table_body['id'] . '"
            value="' . $row_table_body['id'] . '" required>

        <div class="col-md-4 col-12">
        <div class="form-group">
            <label for="" class="form-label">Image</label>
            <div class="form-file">
                        <input type="file" class="form-file-input" name="product_image' . $row_table_body['id'] . '" id="file-upload' . $row_table_body['id'] . '" value="' . $row_table_body['product_image'] . '">
                        <label class="form-file-label" for="customFile">
                            <span class="form-file-text" id="file-name' . $row_table_body['id'] . '">Choose file...</span>
                            <span class="form-file-button btn-primary "><i class="fas fa-file-upload"></i></span>
                        </label>
                    </div>
            </div>
            <label for="" class="form-label">Preview</label>

            <div class="card">
                    <div class="card-content">

                        <img class="card-img img-fluid" id="imagePreview' . $row_table_body['id'] . '" src="images/products/' . $row_table_body['product_image'] . '" alt="" >
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

        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-1 mb-1" id="submit' . $row_table_body['id'] . '" onclick="update' . $row_table_body['id'] . '()">Update</button>
            <button type="reset" class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
        </div>
      </div>
    </div>
</form>
                            </div>

                        </div>
                        </div>
                    </div>

<script>

    function update' . $row_table_body['id'] . '(){
            var product_id = $(\'#product_id' . $row_table_body['id'] . '\').val();
            var product_name = $(\'#product_name' . $row_table_body['id'] . '\').val();
            var brand_id = $(\'#brand_id' . $row_table_body['id'] . '\').val();
            var category_id = $(\'#category_id' . $row_table_body['id'] . '\').val();
            var product_size = $(\'#product_size' . $row_table_body['id'] . '\').val();
            var product_unit_price = $(\'#product_unit_price' . $row_table_body['id'] . '\').val();
            var product_sale_price = $(\'#product_sale_price' . $row_table_body['id'] . '\').val();
            var product_description = $(\'#product_description' . $row_table_body['id'] . '\').val();
            var product_status = $(\'#product_status' . $row_table_body['id'] . '\').val();

            var file_data = $(\'#file-upload' . $row_table_body['id'] . '\').prop(\'files\')[0];
            var form_data = new FormData();

            form_data.append("id", product_id);
            form_data.append("product_image", file_data);
            form_data.append("product_name", product_name);
            form_data.append("category_id", category_id);
            form_data.append("brand_id", brand_id);
            form_data.append("product_size", product_size);
            form_data.append("product_unit_price", product_unit_price);
            form_data.append("product_sale_price", product_sale_price);
            form_data.append("product_description", product_description);
            form_data.append("product_status", product_status);
            console.log(form_data);
            $.ajax({
                url: "update-product-ajax.php",
                type: "POST",
                dataType: \'script\',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data){
                    $(\'#tr-' . $row_table_body['id'] . '\').html(data);
                }
            });
    };
</script>
';

        $modal_delete .= '


        <div class="modal fade text-left modal-borderless" id="delete-modal-' . $row_table_body['id'] . '" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel120" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                <h5 class="modal-title white" id="myModalLabel120">Do you want to delete this product?</h5>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Cancel</span>
                                </button>
                                <button type="button" class="btn btn-danger ml-1" onclick="delete_product(' . $row_table_body['id'] . ')" data-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Accept</span>
                                </button>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
            ';

    }
    $table_products .= '

            </tbody>
        </table>

        ';
} else {
    $table_products .= '
        </tbody>
    </table>
    ';
}

$result = '';
$result .= $table_products;
$result .= $modal_edit;
$result .= $modal_delete;

?>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>ALL PRODUCTS</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All products</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>



    <section class="section">
        <div class="card">
            <div class="card-header">
            <div class="buttons">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal">Add a new product</a>
                </div>
            </div>
            <div class="card-body">
           <?php
echo $result;
?>
            </div>
        </div>

    </section>

  <!--Extra Large Modal -->
  <div class="modal fade text-left w-100 modal-borderless" id="add-modal" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new product</h4>

                            </div>
                            <div class="modal-body">

                            <!--Edit -->
                            <?php

$sql_brand_add = "SELECT * FROM tbl_brand ORDER BY id ASC";
$query_brand_add = mysqli_query($connect, $sql_brand_add);

$sql_category_add = "SELECT * FROM tbl_product_category ORDER BY id ASC";
$query_category_add = mysqli_query($connect, $sql_category_add);
?>

<form role="form" method="post" enctype="multipart/form-data" id="add-form">

<div class="form-body">
        <div class="row">
        <div class="col-md-8 col-12">
            <div class="form-group">
            <label for="" class="form-label">Name</label>
            <input type="text" id="product_name" class="form-control" name="product_name"
                placeholder="Name"  required>
            </div>

            <div class="form-group">
            <label for="" class="form-label">Category</label>
                        <select class="choices form-select"  id="category_id" name="category_id" required>
                        <option value="" selected>CHOOSE...</option>
                        <?php
while ($row_category_add = mysqli_fetch_array($query_category_add)) {
    ?>
            <option value=" <?php echo $row_category_add["id"]; ?>"> <?php echo $row_category_add["category_name"]; ?> </option>
                        <?php
}
?>
                        </select>
            </div>

            <div class="form-group">
            <label for="" class="form-label">Brand</label>
                        <select class="choices form-select" id="brand_id" name="brand_id" required>
                        <option value="" selected >CHOOSE...</option>
                        <?php
while ($row_brand_add = mysqli_fetch_array($query_brand_add)) {
    ?>
            <option value=" <?php echo $row_brand_add["id"]; ?>"> <?php echo $row_brand_add["brand_name"]; ?> </option>
                        <?php
}
?>
                        </select>
            </div>


            <div class="form-group">
             <label for="" class="form-label">Status</label>
                        <select class="choices form-select" id="product_status" name="product_status">

                            <option value="1">Active</option>
                            <option value="0">Inactive</option>

                        </select>
            </div>

            <div class="form-group">
            <label for="" class="form-label">Price</label>
            <input type="text" id="product_unit_price" class="form-control" name="product_unit_price"
                placeholder="Price" required>
            </div>

            <div class="form-group">
            <label for="" class="form-label">Sale price</label>
            <input type="text" id="product_sale_price" class="form-control" name="product_sale_price"
                placeholder="Sale price" required>
            </div>

            <div class="form-group">
            <label for="" class="form-label">Size</label>
            <input type="text" id="product_size" class="form-control" name="product_size"
                placeholder="Size" required>
            </div>


            <div class="form-group">
                <label for="" class="form-label">Description</label>
                <textarea maxlength="150" class="form-control" id="product_description" rows="3" name="product_description" placeholder="Description"  required></textarea>
            </div>
        </div>


        <div class="col-md-4 col-12">
        <div class="form-group">

            <label for="" class="form-label">Image</label>
            <div class="form-file">

                        <input type="file" class="form-file-input" name="product_image" id="file-upload" value="" required>
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


        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mr-1 mb-1" id="submit" onclick="create()">Add</button>
            <button type="reset" class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
        </div>
        </div>
    </div>
</form>


                            <!--Edit -->
                            </div>

                        </div>
                    </div>
                </div>
     <!--Extra Large Modal -->

<script>


    function delete_product(id){
        $.ajax({
                url: "delete-product-ajax.php",
                type: "POST",
                data: {id:id},
                success: function(data){
                    $('#tr-'+id).remove();
                }
        });
    }
    function create(){
            var product_name = $('#product_name').val();
            var brand_id = $('#brand_id').val();
            var category_id = $('#category_id').val();
            var product_size = $('#product_size').val();
            var product_unit_price = $('#product_unit_price').val();
            var product_sale_price = $('#product_sale_price').val();
            var product_description = $('#product_description').val();
            var product_status = $('#product_status').val();

            var file_data = $('#file-upload').prop('files')[0];


            var form_data = new FormData();

            form_data.append("product_image", file_data);
            form_data.append("product_name", product_name);
            form_data.append("category_id", category_id);
            form_data.append("brand_id", brand_id);
            form_data.append("product_size", product_size);
            form_data.append("product_unit_price", product_unit_price);
            form_data.append("product_sale_price", product_sale_price);
            form_data.append("product_description", product_description);
            form_data.append("product_status", product_status);
            console.log(form_data);
            $.ajax({
                url: "add-new-product-ajax.php",
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

    //Write filename into span tag
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
</script>
<!---End modal-->
