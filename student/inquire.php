<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();

if (isset($_POST['submit'])) {
    $regno    = $_POST['regno'];
    $fname    = $_POST['fname'];
    $roomno   = $_POST['room'];
    $inquire  = $_POST['inquire'];
    $posting_date = date('Y-m-d H:i:s');

    $query = "INSERT INTO inquire (regno, posting_date, firstname, room_no, inquire) VALUES (?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt === false) {
        die("Prepare failed: " . $mysqli->error);
    }

    // Ensure room_no is correct type (s = string, i = integer)
    $stmt->bind_param('sssss', $regno, $posting_date, $fname, $roomno, $inquire);

    if ($stmt->execute()) {
        echo "<script>alert('Success: Inquiry submitted!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
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
    .card { border: none; border-radius: 1rem; transition: transform 0.2s ease, box-shadow 0.2s ease; box-shadow: 0 4px 8px rgba(0,0,0,0.05);}
    .card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,0.1);}
    .form-control, .custom-select { border-radius: 0.75rem; border: 1px solid #dee2e6;}
    .btn { border-radius: 0.75rem; padding: 0.6rem 1.5rem;}
    .card-header { border-bottom: none; background: #F4F7FC; border-top-left-radius: 1rem; border-top-right-radius: 1rem;}
    .page-title { font-weight: 600;}
    .btn-success-custom { background-color: #0056b3; border-color: #0056b3; color: #F4F7FC;}
    .btn-success-custom:hover { background-color: #004a98; border-color: #004a98;}
    .btn-danger-custom { background-color: #860000ff; border-color: #860000ff; color: #F4F7FC;}
    .btn-danger-custom:hover { background-color: #750000ff; border-color: #750000ff;}
    </style>
</head>
<body>
<div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">

    <header class="topbar" data-navbarbg="skin6">
        <?php include '../includes/student-navigation.php' ?>
    </header>

    <aside class="left-sidebar" data-sidebarbg="skin6">
        <div class="scroll-sidebar" data-sidebarbg="skin6">
            <?php include '../includes/student-sidebar.php' ?>
        </div>
    </aside>

    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 align-self-center">
                    <h2 class="mb-0 font-weight-bold mt-2">Inquiry Form</h2>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-header">
                    <h4 class="mb-0 font-weight-bold mt-2">Submit Your Inquiry</h4>
                    <hr>
                </div>

                <div class="card-body">
                    <form method="POST">
                        <div class="row">
                            <?php
                            $aid = $_SESSION['id'];
                            $ret = "SELECT * FROM userregistration WHERE id = ?";
                            $stmt = $mysqli->prepare($ret);
                            $stmt->bind_param('i', $aid);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            $row = $res->fetch_object();

                            // Fetch booked room
                            $stmt2 = $mysqli->prepare("SELECT roomno FROM registration WHERE regno = ?");
                            $stmt2->bind_param('s', $row->regNo);
                            $stmt2->execute();
                            $stmt2->bind_result($room_no);
                            $stmt2->fetch();
                            $stmt2->close();
                            ?>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <label for="regno" class="form-label">Registration Number</label>
                                <input type="text" name="regno" id="regno" value="<?php echo htmlspecialchars($row->regNo); ?>" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($row->firstName); ?>" class="form-control" readonly>
                            </div>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <label for="room" class="form-label">Your Room Number</label>
                                <input type="text" name="room" id="room" class="form-control" value="<?php echo htmlspecialchars($room_no ?? ''); ?>" readonly>
                            </div>

                            <div class="col-12 mb-4">
                                <label for="inquire" class="form-label">Your Inquiry</label>
                                <textarea name="inquire" id="inquire" class="form-control" rows="4" placeholder="Write your inquiry here..." required></textarea>
                            </div>
                        </div>

                        <div class="form-actions text-center mt-4">
                            <button type="submit" name="submit" class="btn btn-success-custom me-2">Submit Inquiry</button>
                            <button type="reset" class="btn btn-danger-custom">Reset</button>
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
