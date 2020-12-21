<?php
ob_start();
session_start();
include_once './connect.php';

$email_login = $_SESSION["email"];
$password_login = $_SESSION["password"];
$sql = "SELECT * FROM tbl_admin WHERE admin_email='$email_login' AND admin_password='$password_login'";
$query = mysqli_query($connect, $sql);
$rows = mysqli_num_rows($query);
if ($rows > 0) {

//Check selected menu
    $check_selected = "DASHBOARD";
    if (isset($_GET["page_layout"])) {
        switch ($_GET["page_layout"]) {
            case "home":$check_selected = "DASHBOARD";
                break;
            case "all_categories":$check_selected = "ALL CATEGORIES";
                break;
            case "all_brands":$check_selected = "ALL BRANDS";
                break;
            case "all_products":$check_selected = "ALL PRODUCTS";
                break;
            case "all_customers":$check_selected = "ALL CUSTOMERS";
                break;
            case "all_orders":$check_selected = "ALL ORDERS";
                break;
            case "all_dealers":$check_selected = "ALL DEALERS";
                break;
            case "all_partners":$check_selected = "ALL PARTNERS";
                break;
            case "production_statistics":$check_selected = "PRODUCTION STATISTICS";
                break;
            case "material_import":$check_selected = "MATERIAL STATISTICS";
                break;
            case "material_used":$check_selected = "MATERIAL STATISTICS";
                break;
            case "all_materials":$check_selected = "MATERIAL STATISTICS";
                break;
            case "about":$check_selected = "ABOUT";
                break;
        }
    }

    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AmBakery</title>

    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="assets/vendors/choices.js/choices.min.css" />
    <script src="assets/vendors/choices.js/choices.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/chartjs/Chart.min.css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="shortcut icon" href="assets/logo/AmBakery.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/vendors/simple-datatables/style.css">
    <link rel="stylesheet" href="assets/vendors/datepicker/datepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/vendors/simple-datatables/simple-datatables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/vendors/apexcharts/apexcharts.min.js"></script>



</head>
<body >
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <img src="assets/logo/AmBakeryTextLogo.svg" alt="" srcset="">
    </div>
    <div class="sidebar-menu">
        <ul class="menu">


                <li class='sidebar-title'>Main Menu</li>



                <li class="sidebar-item <?php if ($check_selected == "DASHBOARD") {
        echo "active";
    }
    ?>" >
                    <a href="admin.php" class='sidebar-link'>
                        <i data-feather="home" width="20"></i>
                        <span>Dashboard</span>
                    </a>

                </li>


                <li class='sidebar-title'>SHOP</li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "ALL CATEGORIES") {echo "active";}?>">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="database" width="20"></i>
                        <span>Categories</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=all_categories&name_modal=add_category">Add a new category</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=all_categories">All Categories</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "ALL BRANDS") {echo "active";}?>">
                    <a href="admin.php?page_layout=all_brands" class='sidebar-link'>
                        <i data-feather="database" width="20"></i>
                        <span>Brands</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=all_brands&name_modal=add_brand">Add a new brand</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=all_brands">All Brands</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "ALL PRODUCTS") {echo "active";}?>">
                    <a href="admin.php?page_layout=all_products" class='sidebar-link'>
                        <i data-feather="database" width="20"></i>
                        <span>Products</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=all_products&name_modal=add_product">Add a new product</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=all_products">All Products</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "ALL ORDERS") {echo "active";}?>">
                    <a href="admin.php?page_layout=all_products" class='sidebar-link'>
                        <i data-feather="box" width="20"></i>
                        <span>Orders</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=all_orders&name_modal=add_order">Add a new order</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=all_orders">All Orders</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "ALL CUSTOMERS") {echo "active";}?>" >
                    <a href="admin.php?page_layout=all_products" class='sidebar-link'>
                        <i data-feather="users" width="20"></i>
                        <span>Customers</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=all_customers&name_modal=add_customer">Add a new customer</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=all_customers">All Customers</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "ALL DEALERS") {echo "active";}?>" >
                    <a href="admin.php?page_layout=all_products" class='sidebar-link'>
                        <i data-feather="users" width="20"></i>
                        <span>Dealers</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=all_dealers&name_modal=add_dealer">Add a new dealer</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=all_dealers">All Dealers</a>
                        </li>
                    </ul>
                </li>

                <li class='sidebar-title'>PRODUCE & MATERIALS</li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "PRODUCTION STATISTICS") {echo "active";}?>">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="repeat" width="20"></i>
                        <span>Production</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=production_statistics&name_modal=add_inventory">Update Production Process</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=production_statistics">Production Statistics</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "ALL PARTNERS") {echo "active";}?>">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="credit-card" width="20"></i>
                        <span>Partner</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=all_partners&name_modal=add_partner">Add a new partner</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=all_partners">All Partners</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub <?php if ($check_selected == "MATERIAL STATISTICS") {echo "active";}?> ">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="package" width="20"></i>
                        <span>Materials</span>
                    </a>
                    <ul class="submenu ">
                        <li>
                            <a href="admin.php?page_layout=material_import&name_modal=add_material_inventory">Import Inventory</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=material_import">Material Import</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=material_used&name_modal=add_material_inv_used">Used Inventory</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=material_used">Material Used</a>
                        </li>
                        <li>
                            <a href="admin.php?page_layout=all_materials">All Materials</a>
                        </li>
                    </ul>

                </li>



                <li class='sidebar-title'> PROJECT INFORMATION</li>

                <li class="sidebar-item <?php if ($check_selected == "ABOUT") {echo "active";}?>">
                    <a href="admin.php?page_layout=about" class='sidebar-link'>
                        <i data-feather="info" width="20"></i>
                        <span>ABOUT</span>
                    </a>
                </li>


                <li class='sidebar-title'>
                    <div class="float-right">
                        <p>2020 &copy; AmBakery</p>
                    </div>
                </li>


        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
        </div>
        <div id="main" style="background-image: url(https://www.fg-a.com/wallpapers/white-marble-4-2018.jpg); background-size: cover; background-repeat: no-repeat;">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">

                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar mr-1">
                                    <img src="images/admin/<?php if (isset($_SESSION['image'])) {echo $_SESSION['image'];}?>" alt="" srcset="">
                                    <span class="avatar-status bg-success"></span>
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Hi, <?php if (isset($_SESSION['name'])) {echo $_SESSION['name'];}?></div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="admin.php?page_layout=about""><i data-feather="user"></i> About</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php"><i data-feather="log-out"></i> Logout</a>
                            </div>
                    </ul>
                </div>
            </nav>

<div class="main-content container-fluid">

<?php

    if (isset($_GET["page_layout"])) {
        switch ($_GET["page_layout"]) {
            case "all_categories":include_once './all-categories.php';
                break;
            case "all_brands":include_once './all-brands.php';
                break;
            case "all_products":include_once './all-products.php';
                break;
            case "all_customers":include_once './all-customers.php';
                break;
            case "all_dealers":include_once './all-dealers.php';
                break;
            case "all_orders":include_once './all-orders.php';
                break;
            case "about":include_once './about.php';
                break;
            case "production_statistics":include_once './production-statistics.php';
                break;
            case "all_materials":include_once './all-materials.php';
                break;
            case "all_partners":include_once './all-partners.php';
                break;
            case "material_import":include_once './material-import.php';
                break;
            case "material_used":include_once './material-used.php';
                break;
            default:include_once './dashboard.php';
        }
    } else {
        include_once './dashboard.php';
    }

    ?>

</div>

        </div>
    </div>

    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/vendors.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/vendors/datepicker/datepicker.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>



</body>
</html>
<?php
} else {
    header('location: login.php');
}
?>