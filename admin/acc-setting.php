<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();

    if(isset($_POST['changepwd'])){
        $op = $_POST['oldpassword'];
        $np = $_POST['newpassword'];
        $ai = $_SESSION['id'];
        $udate = date('Y-m-d');
        
        $sql = "SELECT password FROM admin where password=?";
        $chngpwd = $mysqli->prepare($sql);
        $chngpwd->bind_param('s', $op);
        $chngpwd->execute();
        $chngpwd->store_result();
        $row_cnt = $chngpwd->num_rows;
        
        if($row_cnt > 0) {
            $con = "update admin set password=?, updation_date=? where id=?";
            $chngpwd1 = $mysqli->prepare($con);
            $chngpwd1->bind_param('ssi', $np, $udate, $ai);
            $chngpwd1->execute();
            $_SESSION['msg'] = "Password has been changed successfully!";
        } else {
            $_SESSION['msg'] = "Current password does not match.";
        }
    }
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Change Password - Hostel Management System</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">

    <link href="../dist/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <style>
    .card {
        border: none;
        border-radius: 1rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .form-control {
        border-radius: 0.75rem;
        border: 1px solid #dee2e6;
        padding: 1rem;
    }

    .btn {
        border-radius: 0.75rem;
        padding: 0.6rem 1.5rem;
    }

    .card-header {
        border-bottom: none;
        background: #F4F7FC;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .page-title {
        font-weight: 600;
    }
    </style>
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <?php include 'includes/navigation.php'?>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include 'includes/sidebar.php'?>
            </div>
        </aside>

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header">
                                <h2 class="mb-0 font-weight-bold mt-2">Update Password</h2>
                            </div>
                            <div class="card-body">
                                <?php if(isset($_SESSION['msg'])) { ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo htmlentities($_SESSION['msg']); ?>
                                    <?php session_unset(); ?>
                                </div>
                                <?php } ?>
                                <form method="POST" name="changepwdform">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="oldpassword" class="form-label">Current Password</label>
                                            <input type="password" name="oldpassword" id="oldpassword"
                                                class="form-control" placeholder="Enter Current Password" required>
                                            <span id="password-availability-status" style="font-size:12px;"></span>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="newpassword" class="form-label">New Password</label>
                                            <input type="password" class="form-control" name="newpassword"
                                                id="newpassword" placeholder="Enter New Password" required>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="cpassword" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="cpassword" name="cpassword"
                                                placeholder="Confirm New Password" required>
                                        </div>
                                    </div>

                                    <div class="form-actions text-center mt-4">
                                        <button type="submit" name="submit" class="btn btn-success me-2">Change
                                            Password</button>
                                        <button type="reset" class="btn btn-danger">Reset</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php' ?>
        </div>
    </div>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.min.js"></script>
    <script>
    // Use feather icons
    feather.replace()
    </script>
</body>

</html>