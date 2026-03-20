<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();

    if(isset($_POST['submit'])){
        $seater = $_POST['seater'];
        $roomno = $_POST['rmno'];
        $fees = $_POST['fee'];

        $sql = "SELECT room_no FROM rooms where room_no=?";
        $stmt1 = $mysqli->prepare($sql);
        $stmt1->bind_param('s', $roomno);
        $stmt1->execute();
        $stmt1->store_result();
        $row_cnt = $stmt1->num_rows;;
        
        if($row_cnt > 0){
            echo "<script>alert('Room already exist!');</script>";
        } else {
            $query = "INSERT into rooms (seater, room_no, fees) values(?,?,?)";
            $stmt = $mysqli->prepare($query);
            $rc = $stmt->bind_param('isi', $seater, $roomno, $fees);
            $stmt->execute();
            echo "<script>alert('Room has been added successfully!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Room - Hostel Management System</title>

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
                        <h2 class="mb-0 font-weight-bold mt-2">Add Room</h2>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-header">
                                <h4 class="mb-0 font-weight-bold mt-2">New Room Details</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" name="addroom">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="rmno" class="form-label">Room Number</label>
                                            <input type="text" name="rmno" id="rmno" class="form-control"
                                                placeholder="Enter Room Number" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="seater" class="form-label">Number of Beds</label>
                                            <select class="form-control" id="seater" name="seater" required>
                                                <option value="">Choose...</option>
                                                <option value="2">Two Beds</option>
                                                <option value="4">Four Beds</option>
                                                <option value="6">Six Beds</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="fee" class="form-label">Total Fees (Per Month)</label>
                                            <input type="number" name="fee" id="fee" class="form-control"
                                                placeholder="Enter Total Fees" required>
                                        </div>
                                    </div>

                                    <div class="form-actions text-center mt-4">
                                        <button type="submit" name="submit" class="btn btn-success me-2">Add
                                            Room</button>
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