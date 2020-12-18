<?php
ob_start();
session_start();
include_once './connect.php';

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    if (isset($email) && isset($password)) {
        $sql = "SELECT * FROM tbl_admin WHERE admin_email='$email' AND admin_password='$password'";
        $query = mysqli_query($connect, $sql);
        $rows = mysqli_num_rows($query);
        $data = mysqli_fetch_array($query);
        if ($rows > 0) {
            $_SESSION["email"] = $email;
            $_SESSION["password"] = $password;
            $_SESSION["name"] = $data["admin_name"];
            $_SESSION["image"] = $data["admin_image"];
            header('location: admin.php');
        } else {
            echo '<a>Error</a>';
        }
    }
}

if (!isset($_SESSION["email"])) {

    ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="shortcut icon" href="assets/logo/AmBakery.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/app.css">
</head>

<body>
    <div id="auth">

<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="assets/logo/AmBakery.svg" height="100" class='mb-4'>
                        <h3>Sign In</h3>
                        <p>Please sign in to continue to admin.</p>
                    </div>
                    <form method="post" role="form">
                        <div class="form-group position-relative has-icon-left">
                            <label for="email">Email</label>
                            <div class="position-relative">
                                <input type="email" class="form-control" name="email" id="email">
                                <div class="form-control-icon">
                                    <i data-feather="mail"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <label for="password">Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control" name="password" id="password">
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix">
                            <button type="submit" class="btn btn-primary float-right" name="submit" id="submit">LOGIN</button>
                        </div>
                    </form>

                    <div class="divider">
                        <div class="divider-text">OR</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-block mb-2 btn-primary" data-toggle="modal" data-target="#warning"><i data-feather="facebook"></i> Facebook</button>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-block mb-2 btn-secondary" data-toggle="modal" data-target="#warning"><i data-feather="github"></i> Github</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


                        <div class="modal fade text-left w-100 modal-borderless" id="warning" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel140" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-warning">
                                <h5 class="modal-title white" id="myModalLabel140">New features coming soon</h5>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>

                                <button type="button" class="btn btn-warning ml-1" data-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Accept</span>
                                </button>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>

    </div>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/js/main.js"></script>
</body>

</html>

<?php
} else {
    header('location: admin.php');
}

?>