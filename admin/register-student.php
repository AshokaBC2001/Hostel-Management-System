<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();

if (isset($_POST['submit'])) {
    $regno     = $_POST['regno'];
    $fname     = $_POST['fname'];
    $mname     = $_POST['mname'];
    $lname     = $_POST['lname'];
    $gender    = $_POST['gender'];
    $contactno = $_POST['contact'];
    $emailid   = $_POST['email'];
    $password  = md5($_POST['password']);

    // Check if the student registration number or email already exists
    $stmt_check = $mysqli->prepare("SELECT COUNT(*) FROM userRegistration WHERE regNo = ? OR email = ?");
    $stmt_check->bind_param('ss', $regno, $emailid);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        echo "<script>alert('Student with this Registration Number or Email already exists!');</script>";
    } else {
        $query = "INSERT into userRegistration(regNo,firstName,middleName,lastName,gender,contactNo,email,password) values(?,?,?,?,?,?,?,?)";
        $stmt  = $mysqli->prepare($query);
        $stmt->bind_param('sssssiss', $regno, $fname, $mname, $lname, $gender, $contactno, $emailid, $password);
        $stmt->execute();
        echo "<script>alert('Student has been Registered successfully!');</script>";
    }
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

    .btn-success-custom {
        background-color: #0056b3;
        border-color: #0056b3;
        color: #F4F7FC;
    }

    .btn-success-custom:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-danger-custom {
        background-color: #860000ff;
        border-color: #860000ff;
        color: #F4F7FC;
    }

    .btn-danger-custom:hover {
        background-color: #860000ff;
        border-color: #860000ff;
    }
    </style>

    <script type="text/javascript">
    function valid() {
        if (document.registration.password.value !== document.registration.cpassword.value) {
            alert("Password and Confirm Password do not match");
            document.registration.cpassword.focus();
            return false;
        }
        return true;
    }

    function checkAvailability() {
        const emailInput = document.getElementById("email");
        const statusSpan = document.getElementById("user-availability-status");

        jQuery.ajax({
            url: "check-availability.php",
            data: 'emailid=' + emailInput.value,
            type: "POST",
            success: function(data) {
                statusSpan.innerHTML = data;
            },
            error: function() {
                alert('Error checking availability');
            }
        });
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
            <?php include 'includes/navigation.php' ?>
        </header>

        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include 'includes/sidebar.php' ?>
            </div>
        </aside>

        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 align-self-center">
                        <h2 class="mb-0 font-weight-bold mt-2">New Student Registration</h2>
                        <!--<p class="text-muted mb-0">Fill the form to register a new student</p>-->
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-header">
                        <h4 class="mb-0 font-weight-bold mt-2">Register New Student</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" name="registration" onSubmit="return valid();">
                            <div class="row">

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="regno" class="form-label">Registration Number</label>
                                    <input type="text" name="regno" id="regno" class="form-control"
                                        placeholder="Enter Registration Number" required>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="fname" class="form-label">First Name</label>
                                    <input type="text" name="fname" id="fname" class="form-control"
                                        placeholder="Enter First Name" required>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="mname" class="form-label">Middle Name</label>
                                    <input type="text" name="mname" id="mname" class="form-control"
                                        placeholder="Enter Middle Name">
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="lname" class="form-label">Last Name</label>
                                    <input type="text" name="lname" id="lname" class="form-control"
                                        placeholder="Enter Last Name">
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Choose...</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <input type="number" name="contact" id="contact" class="form-control"
                                        placeholder="Student Contact" required>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Student Email" onBlur="checkAvailability()" required>
                                    <span id="user-availability-status" style="font-size:12px;"></span>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Enter Password" required>
                                </div>

                                <div class="col-md-6 col-lg-4 mb-4">
                                    <label for="cpassword" class="form-label">Confirm Password</label>
                                    <input type="password" name="cpassword" id="cpassword" class="form-control"
                                        placeholder="Enter Confirmation Password" required>
                                </div>

                            </div>

                            <div class="form-actions text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-success me-2">Register</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </form>
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