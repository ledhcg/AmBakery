

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
include_once './connect.php';
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