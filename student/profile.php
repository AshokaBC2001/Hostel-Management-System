<?php
    session_start();
    include('../includes/dbconn.php');
    date_default_timezone_set('America/Chicago');
    include('../includes/check-login.php');
    check_login();
    $aid=$_SESSION['id'];
    if(isset($_POST['update']))
    {

    $fname=$_POST['fname'];
    $mname=$_POST['mname'];
    $lname=$_POST['lname'];
    $gender=$_POST['gender'];
    $contactno=$_POST['contact'];
    $udate = date('d-m-Y h:i:s', time());
    $query="UPDATE userRegistration set firstName=?,middleName=?,lastName=?,gender=?,contactNo=?,updationDate=? where id=?";
    $stmt = $mysqli->prepare($query);
    $rc=$stmt->bind_param('ssssisi',$fname,$mname,$lname,$gender,$contactno,$udate,$aid);
    $stmt->execute();
    echo"<script>alert('Profile updated Successfully');</script>";
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
                                <h2 class="mb-0 font-weight-bold mt-2">Profile Details</h2>
                            </div>
                            <div class="card-body">
                                <form name="registration" method="POST">
                                    <?php 
                                    $aid=$_SESSION['id'];
                                    $ret="select * from userregistration where id=?";
                                    $stmt= $mysqli->prepare($ret) ;
                                    $stmt->bind_param('i',$aid);
                                    $stmt->execute() ;
                                    $res=$stmt->get_result();
                                    while($row=$res->fetch_object()) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="regNo" class="form-label">Registration Number</label>
                                            <input type="text" class="form-control" value="<?php echo $row->regNo;?>"
                                                required readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="updationDate" class="form-label">Last Updated On</label>
                                            <input type="text" value="<?php echo $row->updationDate; ?>"
                                                class="form-control" required readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="fname" class="form-label">First Name</label>
                                            <input type="text" name="fname" id="fname" class="form-control"
                                                value="<?php echo $row->firstName;?>" required="required">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="mname" class="form-label">Middle Name</label>
                                            <input type="text" name="mname" id="mname" class="form-control"
                                                value="<?php echo $row->middleName;?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="lname" class="form-label">Last Name</label>
                                            <input type="text" name="lname" id="lname" class="form-control"
                                                value="<?php echo $row->lastName;?>" required="required">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select form-control" id="gender" name="gender">
                                                <option value="<?php echo $row->gender;?>"><?php echo $row->gender;?>
                                                </option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="contact" class="form-label">Contact Number</label>
                                            <input type="text" name="contact" id="contact" maxlength="10"
                                                class="form-control" value="<?php echo $row->contactNo;?>"
                                                required="required">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                value="<?php echo $row->email;?>" readonly>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="form-actions text-center mt-4">
                                        <button type="submit" name="update" class="btn btn-success me-2">Update
                                            Profile</button>
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
</body>

</html>