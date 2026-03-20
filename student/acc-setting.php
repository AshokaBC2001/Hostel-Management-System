<?php
    session_start();
    include('../includes/dbconn.php');
    date_default_timezone_set('America/Chicago');
    include('../includes/check-login.php');
    check_login();
    $ai=$_SESSION['id'];
    // code for change password
    if(isset($_POST['changepwd'])){
    $op=md5($_POST['oldpassword']);
    $np=md5($_POST['newpassword']);
    $udate=date('Y-m-d H:i:s');
        $sql="SELECT password FROM userregistration where password=?";
        $chngpwd = $mysqli->prepare($sql);
        $chngpwd->bind_param('s',$op);
        $chngpwd->execute();
        $chngpwd->store_result();
        $row_cnt=$chngpwd->num_rows;;
        if($row_cnt>0){
            $con="update userregistration set password=?,passUdateDate=? where id=?";
            $chngpwd1 = $mysqli->prepare($con);
            $chngpwd1->bind_param('ssi',$np,$udate,$ai);
            $chngpwd1->execute();
            $_SESSION['msg']="Password has been updated successfully!";
        } else {
            $_SESSION['msg']="Old Password does not match !!";
        }

    }
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Hostel Management System</title>

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

    <script type="text/javascript">
    function valid() {
        if (document.changepwd.newpassword.value != document.changepwd.cpassword.value) {
            alert("New Password and Confirmation Password does not match");
            document.changepwd.cpassword.focus();
            return false;
        }
        return true;
    }
    </script>
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
            <?php include '../includes/student-navigation.php'?>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include '../includes/student-sidebar.php'?>
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
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <?php echo htmlentities($_SESSION['msg']); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                <?php unset($_SESSION['msg']); } ?>
                                <form method="POST" name="changepwd" id="change-pwd" onSubmit="return valid();">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="oldpassword" class="form-label">Current Password</label>
                                            <input type="password" name="oldpassword" id="oldpassword"
                                                class="form-control" placeholder="Enter Current Password" required>
                                            <span id="password-availability-status" class="help-block m-b-none"
                                                style="font-size:12px;"></span>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="newpassword" class="form-label">New Password</label>
                                            <input type="password" class="form-control" name="newpassword"
                                                id="newpassword" placeholder="Enter New Password" required>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="cpassword" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" required id="cpassword"
                                                name="cpassword" placeholder="Confirm New Password">
                                        </div>
                                    </div>
                                    <div class="form-actions text-center mt-4">
                                        <button type="submit" name="changepwd" class="btn btn-success me-2">Change
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
    function checkpass() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check-availability.php",
            data: 'oldpassword=' + $("#oldpassword").val(),
            type: "POST",
            success: function(data) {
                $("#password-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script>
</body>

</html>