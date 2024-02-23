<?php
session_start();
// error_reporting(0);
if (isset($_SESSION['role']) && $_SESSION['role'] === 'branch') {
    header("location: index.php");
    exit;
}
unset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title><?=$_SESSION['site_name']?> - Admin</title>

    <?php include 'layouts/head.php'; ?>

    <?php include 'layouts/head-style.php'; ?>

</head>


<body data-layout="vertical" data-sidebar="dark">

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="text-center mb-4">
                            <a href="index.php">
                                <img src="assets/images/logo-sm.svg" alt="" height="22"> <span class="logo-txt">Symox</span>
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Reset Password</h5>
                                    <p class="text-muted">Reset Password with Symox.</p>
                                </div>
                                <div class="p-2 mt-4">

                                    <div class="alert alert-success text-center small mb-4" role="alert">
                                        Enter your Email and instructions will be sent to you!
                                    </div>
                                    <form action="../php/controller/resetPasswordController.php" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="useremail" placeholder="Enter email">
                                            <span class="text-danger">
                                                <?php
                                                if (isset($_SESSION['otp_alert'])) {
                                                    echo $_SESSION['otp_alert'];
                                                    unset($_SESSION['otp_alert']); // Clear the error message
                                                }
                                                ?>
                                            </span>
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button class="btn btn-primary w-sm waves-effect waves-light" type="submit" name="reset_password">Reset</button>
                                        </div>


                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Remember It ? <a href="login.php" class="fw-medium text-primary"> Sign in </a></p>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div><!-- end col -->
                </div><!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center text-muted p-4">
                            <p class="text-white-50">© <script>
                                    document.write(new Date().getFullYear())
                                </script> Symox. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- end container -->
    </div>
    <!-- end authentication section -->

    <?php include 'layouts/vendor-scripts.php'; ?>

</body>

</html>