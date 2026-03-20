<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();
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
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        border-bottom: none;
        background: #F4F7FC;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .info-group {
        margin-bottom: 1.5rem;
    }

    .info-label {
        font-weight: 600;
        color: #555;
    }

    .info-value {
        color: #002651;
    }

    .hr-divider {
        border-top: 1px solid #dee2e6;
        margin: 2rem 0;
    }

    .address-box {
        background-color: #f8f9fa;
        border: 1px solid #e7ebf4;
        border-radius: 0.5rem;
        padding: 1rem;
        line-height: 1.6;
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
                        <h2 class="mb-0 font-weight-bold mt-2">My Room Details</h2>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <?php 
                    $aid=$_SESSION['login'];
                    $ret="SELECT * from registration where emailid=?";
                    $stmt= $mysqli->prepare($ret);
                    $stmt->bind_param('s',$aid);
                    $stmt->execute();
                    $res=$stmt->get_result();
                    while($row=$res->fetch_object()) {
                ?>
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">

                        <h4 class="card-title text-dark font-weight-bold mb-4">
                            <i class="fas fa-bed me-2"></i> Hostel & Booking Details
                        </h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Room Number:</p>
                                <p class="info-value"><?php echo $row->roomno;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Number of Beds:</p>
                                <p class="info-value"><?php echo $row->seater;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Date & Time of Registration:</p>
                                <p class="info-value"><?php echo $row->postingDate;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Stay From:</p>
                                <p class="info-value"><?php echo $row->stayfrom;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Duration:</p>
                                <p class="info-value"><?php echo $dr=$row->duration;?> Months</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Fees Per Month:</p>
                                <p class="info-value">LKR<?php echo $fpm=$row->feespm;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Total Fees (<?php echo ($dr).' months'?>):</p>
                                <p class="info-value font-weight-bold">
                                    LKR<?php if($row->foodstatus==1){ $fd=211; echo ($fd+$fpm)*$dr; } else { echo $dr*$fpm; } ?>
                                </p>
                            </div>
                        </div>

                        <hr class="hr-divider">

                        <h4 class="card-title text-dark font-weight-bold mb-4">
                            <i class="fas fa-user-circle me-2"></i> Personal Details
                        </h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Registration Number:</p>
                                <p class="info-value"><?php echo $row->regno;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Full Name:</p>
                                <p class="info-value"><?php echo $row->firstName;?> <?php echo $row->middleName;?>
                                    <?php echo $row->lastName;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Email Address:</p>
                                <p class="info-value"><?php echo $row->emailid;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Contact Number:</p>
                                <p class="info-value"><?php echo $row->contactno;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Gender:</p>
                                <p class="info-value"><?php echo $row->gender;?></p>
                            </div>
                        </div>

                        <hr class="hr-divider">

                        <h4 class="card-title text-dark font-weight-bold mb-4">
                            <i class="fas fa-shield-alt me-2"></i> Guardian Information
                        </h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Guardian Name:</p>
                                <p class="info-value"><?php echo $row->guardianName;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Guardian Relation:</p>
                                <p class="info-value"><?php echo $row->guardianRelation;?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-0">Guardian Contact No:</p>
                                <p class="info-value"><?php echo $row->guardianContactno;?></p>
                            </div>
                        </div>

                        <hr class="hr-divider">

                        <h4 class="card-title text-dark font-weight-bold mb-4">
                            <i class="fas fa-map-marker-alt me-2"></i> Address Details
                        </h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="info-label mb-2">Current Address:</p>
                                <div class="address-box">
                                    <?php echo $row->corresAddress;?><br>
                                    <?php echo $row->corresCIty;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
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
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>
</body>

</html>