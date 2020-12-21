<?php
session_start();
if (!isset($_SESSION["email"])) {
    header('location: login.php');
}
include_once './connect.php';

$table_products = '';

$sql_table_body_product = "SELECT * FROM tbl_product ORDER BY id DESC";
$query_table_body_product = mysqli_query($connect, $sql_table_body_product);

$sql_brand_add = "SELECT * FROM tbl_brand ORDER BY id ASC";
$query_brand_add = mysqli_query($connect, $sql_brand_add);

$sql_category_add = "SELECT * FROM tbl_product_category ORDER BY id ASC";
$query_category_add = mysqli_query($connect, $sql_category_add);

if (mysqli_num_rows($query_table_body_product) > 0) {
    while ($row_table_body_product = mysqli_fetch_array($query_table_body_product)) {

        $id_brand_table_body = $row_table_body_product["brand_id"];
        $sql_brand_table_body = "SELECT * FROM tbl_brand WHERE id='$id_brand_table_body'";
        $query_brand_table_body = mysqli_query($connect, $sql_brand_table_body);
        $row_brand_table_body = mysqli_fetch_array($query_brand_table_body);

        $id_category_table_body = $row_table_body_product["category_id"];
        $sql_category_table_body = "SELECT * FROM tbl_product_category WHERE id='$id_category_table_body'";
        $query_category_table_body = mysqli_query($connect, $sql_category_table_body);
        $row_category_table_body = mysqli_fetch_array($query_category_table_body);

        //--------------- Start TABLE BODY ---------------
        $table_products .= '
                <tr>
                    <td><a id="td-' . $row_table_body_product["id"] . '">' . $row_table_body_product["id"] . '</a></td>
                    <td>
                        <div class="avatar avatar-xl mr-3">
                            <img src="images/products/' . $row_table_body_product["product_image"] . '" alt="" srcset="">
                        </div>
                    </td>
                    <td>' . $row_table_body_product["product_name"] . '</td>
                    <td>' . $row_brand_table_body["brand_name"] . '</td>
                    <td>' . $row_category_table_body["category_name"] . '</td>
                    <td>' . $row_table_body_product["product_size"] . '</td>
                    <td>' . $row_table_body_product["product_stock"] . '</td>
        ';

        if ($row_table_body_product["product_status"]) {
            $table_products .= '<td><span class="badge bg-success">Active</span></td>';
        } else {
            $table_products .= '<td><span class="badge bg-danger">Inactive</span></td>';
        }

        $table_products .= '
                    <td>' . $row_table_body_product["updated_at"] . '</td>
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
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#add-modal-product">Add a new product</a>
                </div>
            </div>
            <div class="card-body">
                <table class='table table-hover' id="table2">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Size</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                    <div id="add_new_row"></div>
<?php
echo $table_products;
?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
<!--------------- End HTML --------------->

<!--------------- Start Modal --------------->
    <div class="modal fade text-left w-100 modal-borderless" id="add-modal-product" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                            <h4 class="modal-title white" id="myModalLabel16">Add a new product</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-body">
                                    <form id="add-form-product">
                                    <div class="row">
                                        <div class="col-md-8 col-12">
                                            <div class="form-group">
                                            <label for="" class="form-label">Name</label>
                                            <input type="text" id="product_nameX" class="form-control" name="product_nameX"
                                                placeholder="Name"  required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Category</label>
                                                    <select class="js-choices-add-category form-select"  id="category_idX" name="category_idX" required>
                                                        <option value="" selected>CHOOSE...</option>
<?php
while ($row_category_add = mysqli_fetch_array($query_category_add)) {
    ?>
                                                        <option value="<?php echo $row_category_add["id"]; ?>"> <?php echo $row_category_add["category_name"]; ?> </option>
<?php
}
?>
                                                    </select>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Brand</label>
                                                    <select class="js-choices-add-brand form-select" id="brand_idX" name="brand_idX" required>
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
                                                        <select class="js-choices-add-status form-select" id="product_statusX" name="product_statusX">
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Price</label>
                                            <input type="text" id="product_unit_priceX" class="form-control" name="product_unit_priceX"
                                                placeholder="Price" required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Sale price</label>
                                            <input type="text" id="product_sale_priceX" class="form-control" name="product_sale_priceX"
                                                placeholder="Sale price" required>
                                            </div>

                                            <div class="form-group">
                                            <label for="" class="form-label">Size</label>
                                            <input type="text" id="product_sizeX" class="form-control" name="product_sizeX"
                                                placeholder="Size" required>
                                            </div>


                                            <div class="form-group">
                                                <label for="" class="form-label">Description</label>
                                                <textarea maxlength="150" class="form-control" id="product_descriptionX" rows="3" name="product_descriptionX" placeholder="Description"  required></textarea>
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


                                        </div>
                                        </form>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button class="btn btn-primary mr-1 mb-1" id="submit" onclick="create_product('X')">Add</button>
                                            <button class="btn btn-light-secondary mr-1 mb-1"  data-dismiss="modal" >Cancel</button>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>

<!--------------- End Modal --------------->
<script>

        let element_add_1 = document.querySelector('.js-choices-add-category');
        let choices_add_1 = new Choices(element_add_1);

        let element_add_2 = document.querySelector('.js-choices-add-brand');
        let choices_add_2 = new Choices(element_add_2);

        let element_add_3 = document.querySelector('.js-choices-add-status');
        let choices_add_3 = new Choices(element_add_3);

        let table2 = document.querySelector('#table2');
        let dataTable2 = new simpleDatatables.DataTable(table2);



    function create_product(val){

            var product_name = $('#product_name'+val).val();
            var brand_id = $('#brand_id'+val).val();
            var category_id = $('#category_id'+val).val();
            var product_size = $('#product_size'+val).val();
            var product_unit_price = $('#product_unit_price'+val).val();
            var product_sale_price = $('#product_sale_price'+val).val();
            var product_description = $('#product_description'+val).val();
            var product_status = $('#product_status'+val).val();
            var file_data = $('#file-upload').prop('files')[0];
            var action = "add";

            if( !product_name
                || !brand_id
                || !category_id
                || !product_size
                || !product_unit_price
                || !product_sale_price
                || !product_description
                || !product_status
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

                form_data.append("product_image", file_data);
                form_data.append("product_name", product_name);
                form_data.append("category_id", category_id);
                form_data.append("brand_id", brand_id);
                form_data.append("product_size", product_size);
                form_data.append("product_unit_price", product_unit_price);
                form_data.append("product_sale_price", product_sale_price);
                form_data.append("product_description", product_description);
                form_data.append("product_status", product_status);
                form_data.append("action", action);

                $.ajax({
                    url: "action-for-product.php",
                    type: "POST",
                    dataType: 'script',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    success: function(data){
                        Toastify({
                        text: "A new product created!",
                        duration: 5000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "#39DA8A",
                        stopOnFocus: true,
                        }).showToast();
                        //alert("A new product created!");
                        var data_array = jQuery.parseJSON(data);
                        let newRow = [
                                data_array.product_id,
                                data_array.product_image,
                                data_array.product_name,
                                data_array.brand_name,
                                data_array.category_name,
                                data_array.product_size,
                                data_array.product_stock,
                                data_array.product_status,
                                data_array.updated_at,
                        ];
                        dataTable2.rows().add(newRow);
                        dataTable2.sortColumn(0, "desc");
                        $('#add-form-product')[0].reset();
                        resetFileInput();
                        $('#add-modal-product').modal('toggle');
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
