<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();

if (isset($_POST['submit'])) {
    $roomno      = $_POST['room'];
    $seater      = $_POST['seater'];
    $feespm      = $_POST['fpm'];
    $stayfrom    = $_POST['stayf'];
    $duration    = $_POST['duration'];
    $regno       = $_POST['regno'];
    $fname       = $_POST['fname'];
    $mname       = $_POST['mname'];
    $lname       = $_POST['lname'];
    $gender      = $_POST['gender'];
    $contactno   = $_POST['contact'];
    $emailid     = $_POST['email'];
    $gurname     = $_POST['gname'];
    $gurrelation = $_POST['grelation'];
    $gurcntno    = $_POST['gcontact'];
    $caddress    = $_POST['address'];
    $ccity       = $_POST['city'];

    $query = "INSERT into registration(roomno,seater,feespm,stayfrom,duration,regno,firstName,middleName,lastName,gender,contactno,emailid,guardianName,guardianRelation,guardianContactno,corresAddress,corresCIty) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('siisisssssisssiss',$roomno, $seater, $feespm, $stayfrom, $duration,$regno, $fname, $mname, $lname, $gender,$contactno, $emailid, $gurname, $gurrelation,$gurcntno, $caddress, $ccity);
    $stmt->execute();
    echo "<script>alert('Success: Booked!');</script>";
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hostel Management System</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <link href="../dist/css/style.min.css" rel="stylesheet">

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
    .form-control,
    .custom-select {
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
    </style>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>

    <script>
    function getSeater(val) {
        $.ajax({
            type: "POST",
            url: "get-seater.php",
            data: 'roomid=' + val,
            success: function(data) {
                $('#seater').val(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "get-seater.php",
            data: 'rid=' + val,
            success: function(data) {
                $('#fpm').val(data);
                calculateTotalFees();
            }
        });
    }

    function calculateTotalFees() {
        var fees = parseFloat($('#fpm').val());
        var duration = parseInt($('#duration').val());
        if (!isNaN(fees) && !isNaN(duration)) {
            $('#totalFees').val(fees * duration);
        } else {
            $('#totalFees').val('');
        }
    }

    $(document).ready(function() {
        $('#duration').on('change', function() {
            calculateTotalFees();
        });
    });
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
                        <h2 class="mb-0 font-weight-bold mt-2">Book Your Room</h2>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-header">
                        <h4 class="mb-0 font-weight-bold mt-2">Room & Booking Duration</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <?php
                            $uid = $_SESSION['login'];
                            $stmt = $mysqli->prepare("SELECT emailid FROM registration WHERE emailid = ?");
                            $stmt->bind_param('s', $uid);
                            $stmt->execute();
                            $stmt->bind_result($email);
                            $rs = $stmt->fetch();
                            $stmt->close();

                            if ($rs) { ?>
                            <div class="alert alert-primary alert-dismissible bg-danger text-white border-0 fade show"
                                role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Info: </strong> You have already booked a hostel!
                            </div>
                            <?php } ?>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Room Number</label>
                                    <select class="form-control" name="room" id="room" onChange="getSeater(this.value);" required>
                                        <option value="">Select Room</option>
                                        <?php 
                                        $query = "SELECT * FROM rooms";
                                        $stmt2 = $mysqli->prepare($query);
                                        $stmt2->execute();
                                        $res = $stmt2->get_result();
                                        while ($row = $res->fetch_object()) { ?>
                                        <option value="<?php echo $row->room_no; ?>">
                                            <?php echo $row->room_no; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Number of Beds</label>
                                    <input type="text" id="seater" name="seater" class="form-control" readonly>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" name="stayf" id="stayf" class="form-control" required>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Duration</label>
                                    <select class="form-control" id="duration" name="duration" required>
                                        <option value="">Select Duration</option>
                                        <option value="1">One Month</option>
                                        <option value="2">Two Month</option>
                                        <option value="3">Three Month</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Fees Per Month</label>
                                    <input type="text" name="fpm" id="fpm" class="form-control" readonly>
                                </div>

                                <!-- ⭐ Corrected & Added Total Fee Display -->
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Fees For Duration</label>
                                    <input type="text" id="totalFees" class="form-control" readonly>
                                </div>

                            </div>

                            <hr>
                            <h4 class="mb-0 font-weight-bold mt-2">Student Personal Information</h4>
                            <hr>

                            <div class="row">
                                <?php
                                $aid = $_SESSION['id'];
                                $ret = "select * from userregistration where id = ?";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->bind_param('i', $aid);
                                $stmt->execute();
                                $res = $stmt->get_result();
                                while ($row = $res->fetch_object()) {
                                ?>
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Registration Number</label>
                                    <input type="text" name="regno" value="<?php echo $row->regNo; ?>" class="form-control" readonly>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="fname" value="<?php echo $row->firstName; ?>" class="form-control" readonly>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="mname" value="<?php echo $row->middleName; ?>" class="form-control" readonly>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="lname" value="<?php echo $row->lastName; ?>" class="form-control" readonly>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Email ID</label>
                                    <input type="email" name="email" value="<?php echo $row->email; ?>" class="form-control" readonly>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Gender</label>
                                    <input type="text" name="gender" value="<?php echo $row->gender; ?>" class="form-control" readonly>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Contact Number</label>
                                    <input type="number" name="contact" value="<?php echo $row->contactNo; ?>" class="form-control" readonly>
                                </div>
                                <?php } ?>
                            </div>

                            <hr>
                            <h4 class="mb-0 font-weight-bold mt-2">Guardian Information</h4>
                            <hr>

                            <div class="row">
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Guardian Name</label>
                                    <input type="text" name="gname" class="form-control" required>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Guardian Relation</label>
                                    <input type="text" name="grelation" class="form-control" required>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Guardian Contact No</label>
                                    <input type="number" name="gcontact" class="form-control" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 mb-4">
                                    <hr>
                                    <h4 class="mb-0 font-weight-bold mt-2">Current Living Address</h4>
                                    <hr>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" required>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-actions text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-success">Book Room</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php include '../includes/footer.php' ?>

        </div>
    </div>

    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <script src="../dist/js/custom.min.js"></script>

</body>
</html>
